<?php
// app/controllers/AuthController.php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/RoleModel.php';

class AuthController
{
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function showLogin()
    {
        $pageTitle = 'Login - SGPRO';
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Usa el modelo para buscar el usuario por email
            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Autenticación exitosa
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                
                // Redirige al dashboard
                header('Location: ' . BASE_PATH . '/dashboard');
                exit();
            } else {
                // Autenticación fallida
                $error = "Correo o contraseña incorrectos.";
                $pageTitle = 'Login - SGPRO';
                require_once __DIR__ . '/../views/auth/login.php';
            }
        }
    }

    public function showRegister()
    {
        $pageTitle = 'Registro - SGPRO';
        // Usa el modelo para obtener todos los roles
        $roles = $this->roleModel->getAll();

        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role_id = $_POST['role'] ?? null;

            if (empty($name) || empty($email) || empty($password) || empty($role_id)) {
                $error = "Todos los campos son obligatorios.";
                $this->showRegister();
                return;
            }

            // Encripta la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                // Usa el modelo de usuario para crear el nuevo registro
                $this->userModel->create($name, $email, $hashedPassword);
                $user_id = $this->userModel->getConnection()->lastInsertId();

                // Usa el modelo de rol para asignar el rol
                $this->roleModel->assignRoleToUser($user_id, $role_id);

                // Redirige al login después de un registro exitoso
                header('Location: ' . BASE_PATH . '/');
                exit();

            } catch (PDOException $e) {
                // Manejo de error si el email ya existe
                $error = "Error al registrar el usuario. El correo electrónico podría ya existir.";
                $this->showRegister();
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_PATH . '/');
        exit();
    }
}