<?php
// app/controllers/UserController.php
//controlador para el uso del super adminsitrador

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
        // Solo un Super Administrador debería ver esto
        // if ($_SESSION['user_role'] != 'Super Administrador') {
        //     header('Location: ' . BASE_PATH . '/dashboard');
        //     exit();
        // }
        
        $users = $this->userModel->getAll();
        $pageTitle = 'Gestión de Usuarios';
        require_once __DIR__ . '/../views/users/index.php';
    }

    public function edit($id)
    {
        // Lógica para mostrar el formulario de edición de usuario
        $user = $this->userModel->find($id);
        $roles = $this->roleModel->getAll();
        $userRoles = $this->roleModel->getRolesByUserId($id);
        $pageTitle = 'Editar Usuario';
        require_once __DIR__ . '/../views/users/edit.php';
    }

    public function update()
    {
        // Lógica para procesar la actualización del usuario
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