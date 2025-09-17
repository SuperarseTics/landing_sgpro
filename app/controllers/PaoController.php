<?php
// app/controllers/PaoController.php

require_once __DIR__ . '/../models/PaoModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php'; // Agregamos el modelo de auditoría

class PaoController {
    private $paoModel;
    private $userModel;
    private $roleModel;
    private $auditLogModel; // Propiedad para el modelo de auditoría

    public function __construct() {
        $this->paoModel = new PaoModel();
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->auditLogModel = new AuditLogModel(); // Instanciamos el modelo de auditoría
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $paos = $this->paoModel->getAll();
        $pageTitle = 'Gestión de PAO';
        require_once __DIR__ . '/../views/pao/index.php';
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $pageTitle = 'Crear PAO';
        require_once __DIR__ . '/../views/pao/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';

            if ($this->paoModel->create($name, $start_date, $end_date)) {
                
                // Obtener el ID del último PAO creado
                $lastPaoId = $this->paoModel->getLastInsertedId();
                
                // Lógica de Auditoría: Registrar la acción
                $userId = $_SESSION['user_id'] ?? null;
                $newData = ['name' => $name, 'start_date' => $start_date, 'end_date' => $end_date];
                $this->auditLogModel->logAction($userId, 'CREATE', 'pao', $lastPaoId, null, $newData);

                header('Location: ' . BASE_PATH . '/pao');
                exit();
            } else {
                echo "Error al guardar el PAO.";
            }
        }
    }
}