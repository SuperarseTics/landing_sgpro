<?php
// app/controllers/ContinuityController.php

require_once __DIR__ . '/../models/ContinuityModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/PaoModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';

class ContinuityController
{
    private $continuityModel;
    private $userModel;
    private $paoModel;
    private $roleModel;
    private $auditLogModel;

    public function __construct()
    {
        $this->continuityModel = new ContinuityModel();
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
        $continuities = $this->continuityModel->getContinuitiesWithDetails();
        $pageTitle = 'Gestión de Continuidad';
        require_once __DIR__ . '/../views/continuity/index.php';
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $professors = $this->userModel->getUsersByRole('Profesor');
        $paos = $this->paoModel->getAll();
        $pageTitle = 'Registrar Decisión de Continuidad';
        require_once __DIR__ . '/../views/continuity/create-continuity.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_POST['professor_id'] ?? null;
            $paoId = $_POST['pao_id'] ?? null;

            if ($this->continuityModel->create($professorId, $paoId)) {
                $lastId = $this->continuityModel->getLastInsertedId();
                $userIdLog = $_SESSION['user_id'] ?? null;
                $newData = ['professor_id' => $professorId, 'pao_id' => $paoId, 'final_status' => 'Pendiente'];
                $this->auditLogModel->logAction($userIdLog, 'CREATE', 'continuity', $lastId, null, $newData);

                header('Location: ' . BASE_PATH . '/continuity');
                exit();
            } else {
                echo "Error al guardar la continuidad.";
            }
        }
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        $userIdLog = $_SESSION['user_id'];
        $roles = $this->roleModel->getRolesByUserId($userIdLog);
        $continuity = $this->continuityModel->find($id);

        if (!$continuity) {
            header('Location: ' . BASE_PATH . '/continuity');
            exit();
        }

        $professor = $this->userModel->find($continuity['professor_id']);
        $pao = $this->paoModel->find($continuity['pao_id']);
        $approvedBy = $this->userModel->find($continuity['docencia_decision_by']);

        // --- LÓGICA DE ROLES Y PERMISOS MOVIDA AQUÍ (al Controller) ---
        $userRoleNames = array_column($roles, 'role_name');

        $isSuperAdmin = in_array('Super Administrador', $userRoleNames);
        $isDocenciaTHRole = in_array('Director de docencia', $userRoleNames) || in_array('Talento humano', $userRoleNames);

        // Permiso para ver/editar la Decisión del Profesor (Sección 1)
        $canViewEditProfessorDecision = $isSuperAdmin || (in_array('Profesor', $userRoleNames) && $continuity['professor_id'] == $userIdLog);

        // Permiso para ver/editar la Decisión de Docencia/TH (Sección 2)
        $canViewEditDocenciaTHDecision = $isSuperAdmin || $isDocenciaTHRole;
        // --- FIN LÓGICA DE ROLES ---

        $pageTitle = 'Editar Continuidad: ' . htmlspecialchars($continuity['id']);

        // Pasamos las nuevas variables de control a la vista
        require_once __DIR__ . '/../views/continuity/edit-continuity.php';
    }

    // =========================================================================
    // MÉTODO DE ACTUALIZACIÓN (CON RESTRICCIÓN DE WORKFLOW)
    // =========================================================================
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldContinuity = $this->continuityModel->find($id);
            if (!$oldContinuity) {
                // Redirige si la continuidad no se encuentra, en lugar de imprimir un error
                header('Location: ' . BASE_PATH . '/continuity');
                exit();
            }

            $userIdLog = $_SESSION['user_id'] ?? null;

            // Determinar qué campo se está intentando actualizar (viene del campo oculto 'update_field' de la vista)
            $fieldToUpdate = $_POST['update_field'] ?? null;
            $updated = false;
            $oldData = [];
            $newData = [];
            $decision = null;
            $success = false;
            $logAction = null;
            $approvedBy = null;

            // --- Decisión del Profesor (Primer paso) ---
            if ($fieldToUpdate === 'professor_decision' && isset($_POST['professor_decision'])) {

                $decision = (int)($_POST['professor_decision'] == '1'); // 1 o 0
                $approvedBy = $userIdLog;

                // Usamos el método dinámico para actualizar la decisión del profesor
                $success = $this->continuityModel->updateDecisionDynamically(
                    $id,
                    $fieldToUpdate,
                    $decision,
                    $approvedBy
                );

                if ($success) {
                    $oldData = ['professor_decision' => $oldContinuity['professor_decision']];
                    $newData = ['professor_decision' => $decision];
                    $logAction = 'Decisión de Profesor';
                    $updated = true;
                }

                // --- Decisión de Docencia/TH (Segundo paso: Solo si el Profesor ya decidió) ---
            } elseif ($fieldToUpdate === 'docencia_decision' && isset($_POST['docencia_decision'])) {

                // Aplicamos la restricción de workflow: solo se puede decidir si el profesor ya dio su decisión.
                if ($oldContinuity['professor_decision'] !== null) {

                    $decision = (int)($_POST['docencia_decision'] == '1'); // 1 o 0
                    $approvedBy = $userIdLog;

                    // Usamos el método dinámico para actualizar la decisión de docencia
                    $success = $this->continuityModel->updateDecisionDynamically(
                        $id,
                        $fieldToUpdate,
                        $decision,
                        $approvedBy
                    );

                    if ($success) {
                        $oldData = ['docencia_decision' => $oldContinuity['docencia_decision']];
                        $newData = ['docencia_decision' => $decision];
                        $logAction = 'Decisión de Docencia';
                        $updated = true;
                    }
                }
            }

            // Si se actualizó algo, registra el log de auditoría
            if ($updated) {
                $this->auditLogModel->logAction($userIdLog, 'UPDATE', 'continuity: ' . $logAction, $id, $oldData, $newData);
            }

            // Redirigir de vuelta a la edición para ver el cambio
            header('Location: ' . BASE_PATH . '/continuity/edit/' . $id);
            exit();
        }
    }
}
