<?php
// app/controllers/DashboardController.php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/RoleModel.php';

class DashboardController
{
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        // Instancia de los modelos necesarios
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        // Verifica si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        // Puedes obtener información adicional del usuario si es necesario
        $user = $this->userModel->find($_SESSION['user_id']);
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);

        $pageTitle = 'Dashboard - SGPRO';
        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}