<?php
// app/controllers/UserController.php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php'; // Se agregó

class UserController
{
    private $userModel;
    private $roleModel;
    private $auditLogModel; // Propiedad para el modelo de auditoría

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->auditLogModel = new AuditLogModel(); // Instanciamos el modelo de auditoría
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $users = $this->userModel->getAll();
        $pageTitle = 'Gestión de Usuarios';
        require_once __DIR__ . '/../views/users/index.php';
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        // Obtener los roles del USUARIO EN SESIÓN para el menú
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        
        // Obtener TODOS los roles disponibles para el formulario
        $allRoles = $this->roleModel->getAll();
        
        $pageTitle = 'Crear Nuevo Usuario';
        
        require_once __DIR__ . '/../views/users/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role_id = $_POST['role_id'] ?? null;

            // 1. Crear el usuario
            if ($this->userModel->create($name, $email, $password)) {
                $lastUserId = $this->userModel->getLastInsertedId();

                // 2. Asignar el rol
                if ($this->roleModel->assignRoleToUser($lastUserId, $role_id)) {

                    // 3. Lógica de Auditoría: Registrar la acción
                    $userId = $_SESSION['user_id'] ?? null;
                    $newData = ['name' => $name, 'email' => $email, 'role_id' => $role_id];
                    $this->auditLogModel->logAction($userId, 'CREATE', 'users', $lastUserId, null, $newData);

                    header('Location: ' . BASE_PATH . '/users');
                    exit();
                } else {
                    echo "Error al asignar el rol al usuario.";
                }
            } else {
                echo "Error al crear el usuario.";
            }
        }
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        // Obtener los roles del USUARIO EN SESIÓN para el menú
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);

        // Obtener el usuario que se va a editar
        $user = $this->userModel->find($id);
        if (!$user) {
            header('Location: ' . BASE_PATH . '/users');
            exit();
        }

        // Obtener todos los roles disponibles
        $allRoles = $this->roleModel->getAll();

        // Obtener los roles específicos del USUARIO QUE SE EDITA
        $userRoles = $this->roleModel->getRolesByUserId($id);

        $pageTitle = 'Editar Usuario: ' . htmlspecialchars($user['name']);

        require_once __DIR__ . '/../views/users/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Obtener los datos del formulario
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $roles = $_POST['roles'] ?? []; // Los roles seleccionados son un array

            // 1. Obtener los datos antiguos para la auditoría
            $oldUser = $this->userModel->find($id);
            $oldRoles = $this->roleModel->getRolesByUserId($id);

            // 2. Actualizar la información básica del usuario
            if ($this->userModel->update($id, $name, $email)) {

                // 3. Gestionar la asignación de roles
                // Primero, eliminar los roles actuales del usuario
                $this->roleModel->removeRolesFromUser($id);

                // Luego, asignar los nuevos roles seleccionados
                foreach ($roles as $roleId) {
                    $this->roleModel->assignRoleToUser($id, $roleId);
                }

                // 4. Lógica de Auditoría
                $newData = ['name' => $name, 'email' => $email, 'roles' => $roles];
                $oldData = ['name' => $oldUser['name'], 'email' => $oldUser['email'], 'roles' => $oldRoles];
                $this->auditLogModel->logAction($_SESSION['user_id'], 'UPDATE', 'users', $id, $oldData, $newData);

                // Redirigir a la vista de gestión de usuarios
                header('Location: ' . BASE_PATH . '/users');
                exit();
            } else {
                // Manejar el error si la actualización del usuario falla
                echo "Error al actualizar el usuario.";
            }
        }
    }
}
