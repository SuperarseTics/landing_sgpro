<?php
// app/models/RoleModel.php

require_once __DIR__ . '/BaseModel.php';

class RoleModel extends BaseModel {
    protected $table = 'user_roles';

    public function __construct() {
        parent::__construct();
    }

    // Método para obtener todos los roles de un usuario
    public function getRolesByUserId($userId) {
        $stmt = $this->db->prepare("
            SELECT r.role_name
            FROM user_roles AS r
            JOIN user_roles_pivot AS urp ON r.id = urp.role_id
            WHERE urp.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para asignar un rol a un usuario
    public function assignRoleToUser($userId, $roleId) {
        $stmt = $this->db->prepare("INSERT INTO user_roles_pivot (user_id, role_id) VALUES (?, ?)");
        return $stmt->execute([$userId, $roleId]);
    }
}