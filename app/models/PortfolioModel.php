<?php
// app/models/PortfolioModel.php

require_once __DIR__ . '/BaseModel.php';

class PortfolioModel extends BaseModel
{
    protected $table = 'portfolios';

    public function __construct()
    {
        parent::__construct();
    }

    // Este método ya estaba, lo incluyo para referencia
    public function create(array $data)
    {
        $query = "INSERT INTO " . $this->table . " (professor_id, pao_id, unit_number, docencia_path, practicas_path, titulacion_path) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $data['professor_id']);
        $stmt->bindParam(2, $data['pao_id']);
        $stmt->bindParam(3, $data['unit_number']);
        $stmt->bindParam(4, $data['docencia_path']);
        $stmt->bindParam(5, $data['practicas_path']);
        $stmt->bindParam(6, $data['titulacion_path']);

        return $stmt->execute();
    }
    
    // Este método ya estaba
    public function update($id, array $data)
    {
        $query = "UPDATE " . $this->table . " SET docencia_path = ?, practicas_path = ?, titulacion_path = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(1, $data['docencia_path']);
        $stmt->bindParam(2, $data['practicas_path']);
        $stmt->bindParam(3, $data['titulacion_path']);
        $stmt->bindParam(4, $id);

        return $stmt->execute();
    }

    // Este es el nuevo método que necesitas agregar
    public function getPortfoliosWithDetails()
    {
        $query = "
            SELECT 
                p.id, 
                p.professor_id, 
                u.name AS professor_name, 
                p.pao_id, 
                pa.name AS pao_name,
                p.unit_number,
                p.docencia_path,
                p.practicas_path,
                p.titulacion_path
            FROM " . $this->table . " AS p
            JOIN users AS u ON p.professor_id = u.id
            JOIN pao AS pa ON p.pao_id = pa.id
            ORDER BY u.name, pa.name, p.unit_number ASC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agrupar los resultados por profesor y PAO
        $groupedPortfolios = [];
        foreach ($results as $row) {
            $key = $row['professor_id'] . '-' . $row['pao_id'];
            if (!isset($groupedPortfolios[$key])) {
                $groupedPortfolios[$key] = [
                    'id' => $row['id'],
                    'professor_id' => $row['professor_id'],
                    'professor_name' => $row['professor_name'],
                    'pao_id' => $row['pao_id'],
                    'pao_name' => $row['pao_name'],
                    'units' => []
                ];
            }
            $groupedPortfolios[$key]['units'][] = [
                'unit_number' => $row['unit_number'],
                'docencia_path' => $row['docencia_path'],
                'practicas_path' => $row['practicas_path'],
                'titulacion_path' => $row['titulacion_path']
            ];
        }

        return array_values($groupedPortfolios);
    }

    // Y el resto de los métodos que ya tenías...
    public function findByKeys($professorId, $paoId, $unitNumber)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE professor_id = ? AND pao_id = ? AND unit_number = ?";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $paoId);
        $stmt->bindParam(3, $unitNumber);
        
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getPortfolio($professorId, $paoId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE professor_id = ? AND pao_id = ? ORDER BY unit_number ASC";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $paoId);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getLastInsertedId()
    {
        return $this->db->lastInsertId();
    }
}