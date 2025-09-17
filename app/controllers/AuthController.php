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

    public function showRegister()
    {
        $pageTitle = 'Registro - SGPRO';
        // Aquí pasas los roles disponibles a la vista
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id, role_name FROM user_roles");
        $stmt->execute();
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role_id = $_POST['role'] ?? null;

            // Validaciones básicas
            if (empty($name) || empty($email) || empty($password) || empty($role_id)) {
                $error = "Todos los campos son obligatorios.";
                $this->showRegister();
                return;
            }

            // Encripta la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                // Guarda el usuario en la base de datos
                $db = Database::getInstance()->getConnection();
                $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $hashedPassword]);

                $user_id = $db->lastInsertId();

                // Asigna el rol al usuario en la tabla de unión
                $stmt = $db->prepare("INSERT INTO user_roles_pivot (user_id, role_id) VALUES (?, ?)");
                $stmt->execute([$user_id, $role_id]);

                // Registro exitoso, redirige al login
                header('Location: ' . BASE_PATH . '/');
                exit();

            } catch (PDOException $e) {
                // Maneja errores (ej. email ya existe)
                $error = "Error al registrar el usuario: " . $e->getMessage();
                $this->showRegister();
            }
        }
    }
}