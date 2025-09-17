<?php
// app/controllers/AuthController.php

// Asegúrate de requerir la clase del modelo que necesites
require_once __DIR__ . '/../core/Database.php';

class AuthController
{

    public function showLogin()
    {
        // Lógica para mostrar la vista del formulario de login
        $pageTitle = 'Login - SGPRO';
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function login()
    {
        // Verifica si la petición es un POST y captura los datos del formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Lógica de validación y autenticación (con PDO)
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

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

    public function logout()
    {
        session_destroy();
        // Redirige al login
        header('Location: ' . BASE_PATH . '/');
        exit();
    }
}