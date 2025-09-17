<?php
// app/controllers/ContinuityController.php

require_once __DIR__ . '/../models/ContinuityModel.php';
require_once __DIR__ . '/../models/UserModel.php'; // Se agregó
require_once __DIR__ . '/../models/RoleModel.php'; // Se agregó

class ContinuityController
{
    private $continuityModel;
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->continuityModel = new ContinuityModel();
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

        $continuities = $this->continuityModel->getAll();
        $pageTitle = 'Gestión de Continuidad';
        require_once __DIR__ . '/../views/continuity/index.php';
    }

    public function decide()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para procesar la decisión de continuidad...
            header('Location: ' . BASE_PATH . '/continuity');
            exit();
        }
    }
}