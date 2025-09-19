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
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $continuity = $this->continuityModel->find($id);

        if (!$continuity) {
            header('Location: ' . BASE_PATH . '/continuity');
            exit();
        }
        
        $professor = $this->userModel->find($continuity['professor_id']);
        $pao = $this->paoModel->find($continuity['pao_id']);
        $approvedBy = $this->userModel->find($continuity['docencia_decision_by']);

        $pageTitle = 'Editar Continuidad: ' . htmlspecialchars($continuity['id']);
        require_once __DIR__ . '/../views/continuity/edit-continuity.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldContinuity = $this->continuityModel->find($id);
            if (!$oldContinuity) {
                echo "Continuidad no encontrada.";
                exit();
            }

            $userIdLog = $_SESSION['user_id'] ?? null;
            $userRoles = $this->roleModel->getRolesByUserId($userIdLog);

            // Actualización de la decisión del profesor
            if (in_array('Profesor', $userRoles) && isset($_POST['professor_decision'])) {
                $decision = $_POST['professor_decision'] == '1';
                $this->continuityModel->updateProfessorDecision($id, $decision);
                $newData = ['professor_decision' => $decision];
                $oldData = ['professor_decision' => $oldContinuity['professor_decision']];
                $this->auditLogModel->logAction($userIdLog, 'UPDATE', 'continuity', $id, $oldData, $newData);
            }
            
            // Actualización de la decisión de Docencia
            if (in_array('Dirección de Docencia', $userRoles) && isset($_POST['docencia_decision'])) {
                $decision = $_POST['docencia_decision'] == '1';
                $this->continuityModel->updateDocenciaDecision($id, $decision, $userIdLog);
                $newData = ['docencia_decision' => $decision];
                $oldData = ['docencia_decision' => $oldContinuity['docencia_decision']];
                $this->auditLogModel->logAction($userIdLog, 'UPDATE', 'continuity', $id, $oldData, $newData);
            }

            header('Location: ' . BASE_PATH . '/continuity');
            exit();
        }
    }
}