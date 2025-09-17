<?php
// app/controllers/EvaluationController.php

require_once __DIR__ . '/../models/EvaluationModel.php';
require_once __DIR__ . '/../models/UserModel.php'; // Se agregó
require_once __DIR__ . '/../models/RoleModel.php'; // Se agregó

class EvaluationController
{
    private $evaluationModel;
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->evaluationModel = new EvaluationModel();
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

        $evaluations = $this->evaluationModel->getAll();
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

        $pageTitle = 'Crear Evaluación';
        require_once __DIR__ . '/../views/evaluations/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para guardar una nueva evaluación...
            header('Location: ' . BASE_PATH . '/evaluations');
            exit();
        }
    }
}