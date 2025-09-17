<?php
// app/models/PaoModel.php

require_once __DIR__ . '/BaseModel.php';

class PaoModel extends BaseModel
{
    protected $table = "pao";

    public function __construct()
    {
        parent::__construct();
    }

    // El método getAll() ya está definido en BaseModel

    public function create($name, $start_date, $end_date)
    {
        $query = "INSERT INTO " . $this->table . " (name, start_date, end_date) VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($query);

        // Limpieza y asignación de datos
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $start_date);
        $stmt->bindParam(3, $end_date);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getLastInsertedId()
    {
        return $this->db->lastInsertId();
    }
}
