<?php
// app/models/UserModel.php

require_once __DIR__ . '/BaseModel.php';

class UserModel extends BaseModel
{
    protected $table = "users";

    public function __construct()
    {
        parent::__construct();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $email, $password)
    {
        $query = "INSERT INTO " . $this->table . " (name, email, password) VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($query);

        // Limpieza de datos
        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $hashed_password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Método para obtener el ID del último registro insertado
    public function getLastInsertedId()
    {
        return $this->db->lastInsertId();
    }

    public function update($id, $name, $email)
    {
        $query = "UPDATE " . $this->table . " SET name = ?, email = ? WHERE id = ?";

        $stmt = $this->db->prepare($query);

        $name = htmlspecialchars(strip_tags($name));
        $email = htmlspecialchars(strip_tags($email));

        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $id);

        return $stmt->execute();
    }
}
