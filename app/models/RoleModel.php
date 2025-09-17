<?php
// app/models/RoleModel.php

require_once __DIR__ . '/BaseModel.php';

class RoleModel extends BaseModel
{
    // La tabla principal de roles se llama 'user_roles' en tu DB
    protected $table = "user_roles";

    public function __construct()
    {
        parent::__construct();
    }

    // Este método usa el nombre de la tabla de unión correcta: user_roles_pivot
    public function getRolesByUserId($userId)
    {
        $query = "SELECT r.role_name FROM user_roles_pivot ur JOIN user_roles r ON ur.role_id = r.id WHERE ur.user_id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Este método usa el nombre de la tabla de unión correcta: user_roles_pivot
    public function assignRoleToUser($userId, $roleId)
    {
        $query = "INSERT INTO user_roles_pivot (user_id, role_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId, $roleId]);
    }

    public function removeRolesFromUser($userId)
    {
        $query = "DELETE FROM user_roles_pivot WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId]);
    }
}
