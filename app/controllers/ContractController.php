<?php
// app/controllers/ContractController.php

require_once __DIR__ . '/../models/ContractModel.php';
require_once __DIR__ . '/../models/UserModel.php'; // Se agregó
require_once __DIR__ . '/../models/RoleModel.php'; // Se agregó

class ContractController
{
    private $contractModel;
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->contractModel = new ContractModel();
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);

        $contracts = $this->contractModel->getAll();
        $pageTitle = 'Gestión de Contratos';
        require_once __DIR__ . '/../views/contracts/index.php';
    }

    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para manejar la subida del archivo...
            header('Location: ' . BASE_PATH . '/contracts');
            exit();
        }
    }
}