<?php
// app/controllers/PaoController.php

require_once __DIR__ . '/../models/PaoModel.php';
require_once __DIR__ . '/../models/UserModel.php'; // Agrega este
require_once __DIR__ . '/../models/RoleModel.php'; // Agrega este

class PaoController
{
    private $paoModel;
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->paoModel = new PaoModel();
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

        // Obtener los roles del usuario actual para la barra de navegación.
        $user = $this->userModel->find($_SESSION['user_id']);
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);

        $paos = $this->paoModel->getAll();
        $pageTitle = 'Gestión de PAO';
        require_once __DIR__ . '/../views/pao/index.php';
    }

    public function create()
    {
        // Obtener los roles del usuario actual para la barra de navegación.
        $user = $this->userModel->find($_SESSION['user_id']);
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        
        $pageTitle = 'Crear PAO';
        require_once __DIR__ . '/../views/pao/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para guardar un nuevo PAO
            $name = $_POST['name'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            // Usar el modelo para insertar en la base de datos
            // $this->paoModel->create($name, $start_date, $end_date);
            
            // Redirigir después de guardar
            header('Location: ' . BASE_PATH . '/pao');
            exit();
        }
    }
}