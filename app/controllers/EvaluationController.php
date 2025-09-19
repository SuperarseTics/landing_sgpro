<?php
// app/controllers/EvaluationController.php

require_once __DIR__ . '/../models/EvaluationModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/PaoModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php'; // Agregamos el modelo de auditoría

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

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $evaluations = $this->evaluationModel->getEvaluationsWithDetails();
        $pageTitle = 'Gestión de Evaluaciones';
        require_once __DIR__ . '/../views/evaluations/index.php';
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $professors = $this->userModel->getUsersByRole('Profesor');
        $evaluators = $this->userModel->getUsersByRole('Coordinador académico');
        $paos = $this->paoModel->getAll();
        $pageTitle = 'Crear Evaluación';
        require_once __DIR__ . '/../views/evaluations/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
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
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $evaluation = $this->evaluationModel->find($id);

        if (!$evaluation) {
            header('Location: ' . BASE_PATH . '/evaluations');
            exit();
        }

        $professors = $this->userModel->getUsersByRole('Profesor');
        $evaluators = $this->userModel->getUsersByRole('Coordinador académico');
        $paos = $this->paoModel->getAll();
        $pageTitle = 'Editar Evaluación: ' . htmlspecialchars($evaluation['id']);
        require_once __DIR__ . '/../views/evaluations/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $oldEvaluation = $this->evaluationModel->find($id);

            $data = [
                'professor_id' => $_POST['professor_id'] ?? null,
                'pao_id' => $_POST['pao_id'] ?? null,
                'evaluator_id' => $_POST['evaluator_id'] ?? null,
                'score' => $_POST['score'] ?? null,
                'comments' => $_POST['comments'] ?? null,
                'status' => $_POST['status'] ?? 'Pendiente de subida',
                'final_status' => $_POST['final_status'] ?? 'En proceso'
            ];

            // Lógica para subir un nuevo archivo si se proporciona
            if (isset($_FILES['initial_file']) && $_FILES['initial_file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['initial_file']['tmp_name'];
                $fileName = uniqid() . '_' . basename($_FILES['initial_file']['name']);
                $uploadFileDir = __DIR__ . '/../landing_sgpro/public/uploads/evaluations/';
                $destPath = $uploadFileDir . $fileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    // Guarda la ruta relativa a la carpeta 'public'
                    $data['initial_file_path'] = '/landing_sgpro/public/uploads/evaluations/' . $fileName;
                }
            } else {
                // Mantener el archivo existente si no se sube uno nuevo
                $data['initial_file_path'] = $oldEvaluation['initial_file_path'];
            }

            // Lógica para subir un nuevo archivo firmado si se proporciona
            if (isset($_FILES['signed_file']) && $_FILES['signed_file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['signed_file']['tmp_name'];
                $fileName = uniqid() . '_signed_' . basename($_FILES['signed_file']['name']);
                $uploadFileDir = __DIR__ . '/../landing_sgpro/public/uploads/evaluations/';
                $destPath = $uploadFileDir . $fileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    // Guarda la ruta relativa a la carpeta 'public'
                    $data['signed_file_path'] = '/landing_sgpro/public/uploads/evaluations/' . $fileName;
                    $data['professor_signed_at'] = date('Y-m-d H:i:s');
                }
            } else {
                // Mantener el archivo firmado existente si no se sube uno nuevo
                $data['signed_file_path'] = $oldEvaluation['signed_file_path'];
                $data['professor_signed_at'] = $oldEvaluation['professor_signed_at'];
            }

            if ($this->evaluationModel->update($id, $data)) {
                $this->auditLogModel->logAction($_SESSION['user_id'], 'UPDATE', 'evaluations', $id, $oldEvaluation, $data);
                header('Location: ' . BASE_PATH . '/evaluations');
                exit();
            } else {
                echo "Error al actualizar la evaluación.";
            }
        }
    }
}
