<?php
// app/controllers/PortfolioController.php

require_once __DIR__ . '/../models/PortfolioModel.php';
require_once __DIR__ . '/../models/UserModel.php'; // Se agregó
require_once __DIR__ . '/../models/RoleModel.php'; // Se agregó

class PortfolioController
{
    private $portfolioModel;
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->portfolioModel = new PortfolioModel();
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

        $portfolios = $this->portfolioModel->getAll();
        $pageTitle = 'Gestión de Portafolios';
        require_once __DIR__ . '/../views/portfolios/index.php';
    }

    public function upload()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para procesar la subida del archivo...
            header('Location: ' . BASE_PATH . '/portfolios');
            exit();
        }
    }
}