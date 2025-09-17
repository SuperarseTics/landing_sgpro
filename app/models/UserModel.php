<?php
// app/models/UserModel.php

require_once __DIR__ . '/BaseModel.php';

class UserModel extends BaseModel {
    protected $table = 'users';

    public function __construct() {
        parent::__construct();
    }

    // Este método es para encontrar un usuario por email,
    // útil para el login.
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para crear un nuevo usuario
    public function create($name, $email, $password) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $password]);
    }
}