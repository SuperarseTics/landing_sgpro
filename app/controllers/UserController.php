<?php
// app/controllers/UserController.php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/RoleModel.php';

class UserController
{
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        // Lógica de autenticación y autorización
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        
        // CORRECCIÓN: Obtener los roles del usuario actual para la barra de navegación.
        $user = $this->userModel->find($_SESSION['user_id']);
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        
        $users = $this->userModel->getAll();
        $pageTitle = 'Gestión de Usuarios';
        require_once __DIR__ . '/../views/users/index.php';
    }

    public function edit($id)
    {
        // CORRECCIÓN: Obtener los roles del usuario actual para la barra de navegación.
        $user = $this->userModel->find($id);
        $roles = $this->roleModel->getAll();
        $userRoles = $this->roleModel->getRolesByUserId($id);
        $pageTitle = 'Editar Usuario';
        
        // CORRECCIÓN: Obtener los roles del usuario actual para la barra de navegación.
        $currentUserRoles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        
        require_once __DIR__ . '/../views/users/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            // Lógica para actualizar en el modelo
            // $this->userModel->update($id, $name, $email);
            // Redirigir
            header('Location: ' . BASE_PATH . '/users');
            exit();
        }
    }
}