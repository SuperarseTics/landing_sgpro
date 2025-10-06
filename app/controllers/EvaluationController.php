<?php
// app/controllers/EvaluationController.php

require_once __DIR__ . '/../models/EvaluationModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/PaoModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';

class EvaluationController
{
    private $evaluationModel;
    private $userModel;
    private $paoModel;
    private $roleModel;
    private $auditLogModel;

    public function __construct()
    {
        $this->evaluationModel = new EvaluationModel();
        $this->userModel = new UserModel();
        $this->paoModel = new PaoModel();
        $this->roleModel = new RoleModel();
        $this->auditLogModel = new AuditLogModel();
    }

    /**
     * Función auxiliar para verificar si el usuario tiene uno de los roles dados.
     * @param array $userRoles Roles del usuario logueado (ej: [['role_name' => 'Professor']]).
     * @param array $allowedRoles Lista de roles permitidos (ej: ['Super Administrador', 'Coordinador académico']).
     * @return bool
     */
    private function hasRole(array $userRoles, array $allowedRoles): bool
    {
        $allowed = array_map('strtolower', $allowedRoles);
        foreach ($userRoles as $role) {
            if (isset($role['role_name']) && in_array(strtolower($role['role_name']), $allowed)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Redirige a la página de inicio de sesión si el usuario no está autenticado, 
     * o a una página de error de acceso si no está autorizado.
     */
    private function denyAccess()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/'); // No logueado, redirigir al login
        } else {
            // Logueado, pero sin permisos para la acción
            http_response_code(403);
            die("Acceso denegado: No tiene permisos para realizar esta acción.");
        }
        exit();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $roles = $this->roleModel->getRolesByUserId($userId);

        // Determinar el rol principal para la vista (el más permisivo prevalece)
        $unrestrictedRoles = ['super administrador', 'coordinador académico', 'director de docencia'];
        $userRoleForView = 'Professor'; // Por defecto, es el rol más restringido

        // Verifica si tiene algún rol irrestricto
        if ($this->hasRole($roles, $unrestrictedRoles)) {
            $userRoleForView = 'Administrator'; // Si tiene cualquiera de esos roles, se considera administrador para la vista
        }

        // El modelo filtra las evaluaciones basándose en $userRoleForView
        $evaluations = $this->evaluationModel->getEvaluationsWithDetails($userId, $userRoleForView);
        $pageTitle = 'Gestión de Evaluaciones';
        require_once __DIR__ . '/../views/evaluations/index.php';
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->denyAccess();
        }

        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);

        // PERMISO CREAR: Solo Super Administrador y Coordinador académico
        $allowedCreationRoles = ['Super Administrador', 'Coordinador académico'];
        if (!$this->hasRole($roles, $allowedCreationRoles)) {
            $this->denyAccess();
        }

        $professors = $this->userModel->getUsersByRole('Profesor');
        $evaluators = $this->userModel->getUsersByRole('Coordinador académico');
        $paos = $this->paoModel->getAll();
        $pageTitle = 'Crear Evaluación';
        require_once __DIR__ . '/../views/evaluations/create.php';
    }

    public function store()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->denyAccess();
        }

        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $allowedCreationRoles = ['Super Administrador', 'Coordinador académico'];

        // PERMISO CREAR (Store): Revisa si está autorizado para guardar
        if (!$this->hasRole($roles, $allowedCreationRoles)) {
            $this->denyAccess();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'professor_id' => $_POST['professor_id'] ?? null,
                'pao_id' => $_POST['pao_id'] ?? null,
                'evaluator_id' => $_POST['evaluator_id'] ?? null,
                'score' => $_POST['score'] ?? null,
                'comments' => $_POST['comments'] ?? null,
                'initial_file_path' => null,
                'status' => 'Pendiente de subida',
                'final_status' => 'En proceso'
            ];

            if (isset($_FILES['initial_file']) && $_FILES['initial_file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['initial_file']['tmp_name'];
                $fileName = uniqid() . '_' . basename($_FILES['initial_file']['name']);
                $uploadFileDir = __DIR__ . '/../../public/uploads/evaluations/';
                $destPath = $uploadFileDir . $fileName;

                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    // Guarda la ruta completa y relativa desde la raíz del proyecto
                    $data['initial_file_path'] = '/landing_sgpro/public/uploads/evaluations/' . $fileName;
                    $data['status'] = 'Pendiente de firma';
                }
            }

            if ($this->evaluationModel->create($data)) {
                $lastId = $this->evaluationModel->getLastInsertedId();
                $this->auditLogModel->logAction($_SESSION['user_id'], 'CREATE', 'evaluations', $lastId, null, $data);
                header('Location: ' . BASE_PATH . '/evaluations');
                exit();
            } else {
                echo "Error al crear la evaluación.";
            }
        }
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            $this->denyAccess();
        }

        $userId = $_SESSION['user_id'];
        $roles = $this->roleModel->getRolesByUserId($userId);
        $evaluation = $this->evaluationModel->find((int)$id);

        if (!$evaluation) {
            // Si la evaluación no existe, redirigir
            header('Location: ' . BASE_PATH . '/evaluations');
            exit();
        }

        // PERMISO EDITAR: Solo Profesor (si es dueño) o Super Administrador
        $isSuperAdmin = $this->hasRole($roles, ['Super Administrador']);
        $isOwnerProfessor = $this->hasRole($roles, ['Profesor']) && $evaluation['professor_id'] == $userId;

        if (!$isSuperAdmin && !$isOwnerProfessor) {
            $this->denyAccess();
        }

        $professors = $this->userModel->getUsersByRole('Profesor');
        $evaluators = $this->userModel->getUsersByRole('Coordinador académico');
        $paos = $this->paoModel->getAll();
        $pageTitle = 'Editar Evaluación: ' . htmlspecialchars($evaluation['id']);
        require_once __DIR__ . '/../views/evaluations/edit.php';
    }

    public function update($id)
    {
        if (!isset($_SESSION['user_id'])) {
            $this->denyAccess();
        }

        $userId = $_SESSION['user_id'];
        $roles = $this->roleModel->getRolesByUserId($userId);
        $oldEvaluation = $this->evaluationModel->find((int)$id);

        if (!$oldEvaluation) {
            header('Location: ' . BASE_PATH . '/evaluations');
            exit();
        }

        // PERMISO EDITAR (Update): Solo Profesor (si es dueño) o Super Administrador
        $isSuperAdmin = $this->hasRole($roles, ['Super Administrador']);
        $isOwnerProfessor = $this->hasRole($roles, ['Profesor']) && $oldEvaluation['professor_id'] == $userId;

        if (!$isSuperAdmin && !$isOwnerProfessor) {
            $this->denyAccess();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'professor_id' => $_POST['professor_id'] ?? null,
                'pao_id' => $_POST['pao_id'] ?? null,
                'evaluator_id' => $_POST['evaluator_id'] ?? null,
                'score' => $_POST['score'] ?? null,
                'comments' => $_POST['comments'] ?? null,
                'status' => $_POST['status'] ?? 'Pendiente de subida',
                'final_status' => $_POST['final_status'] ?? 'En proceso',
                'initial_file_path' => $oldEvaluation['initial_file_path'], // Mantener por defecto
                'signed_file_path' => $oldEvaluation['signed_file_path'], // Mantener por defecto
                'professor_signed_at' => $oldEvaluation['professor_signed_at'], // Mantener por defecto
            ];

            // Lógica para subir un nuevo archivo si se proporciona
            if (isset($_FILES['initial_file']) && $_FILES['initial_file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['initial_file']['tmp_name'];
                $fileName = uniqid() . '_' . basename($_FILES['initial_file']['name']);
                $uploadFileDir = __DIR__ . '/../../public/uploads/evaluations/';
                $destPath = $uploadFileDir . $fileName;

                // Nota: Verifiqué y corregí la ruta de uploadFileDir en el controlador.
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $data['initial_file_path'] = '/landing_sgpro/public/uploads/evaluations/' . $fileName;
                }
            }

            // Lógica para subir un nuevo archivo firmado si se proporciona
            if (isset($_FILES['signed_file']) && $_FILES['signed_file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['signed_file']['tmp_name'];
                $fileName = uniqid() . '_signed_' . basename($_FILES['signed_file']['name']);
                $uploadFileDir = __DIR__ . '/../../public/uploads/evaluations/';
                $destPath = $uploadFileDir . $fileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $data['signed_file_path'] = '/landing_sgpro/public/uploads/evaluations/' . $fileName;
                    $data['professor_signed_at'] = date('Y-m-d H:i:s');
                }
            }

            if ($this->evaluationModel->update((int)$id, $data)) {
                $this->auditLogModel->logAction($userId, 'UPDATE', 'evaluations', (int)$id, $oldEvaluation, $data);
                header('Location: ' . BASE_PATH . '/evaluations');
                exit();
            } else {
                echo "Error al actualizar la evaluación.";
            }
        }
    }
}
