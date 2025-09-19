<?php
// app/models/ContinuityModel.php

require_once __DIR__ . '/BaseModel.php';

class ContinuityModel extends BaseModel
{
    protected $table = 'continuity';

    public function __construct()
    {
        parent::__construct();
    }

    public function getContinuitiesWithDetails()
    {
        $query = "SELECT 
                    c.id,
                    c.professor_decision,
                    c.docencia_decision,
                    c.docencia_decision_by,
                    c.final_status,
                    c.created_at,
                    c.professor_decision_at,
                    c.docencia_decision_at,
                    u.name AS professor_name,
                    p.name AS pao_name,
                    ua.name AS docencia_approved_by_name
                  FROM " . $this->table . " c
                  JOIN users u ON c.professor_id = u.id
                  JOIN pao p ON c.pao_id = p.id
                  LEFT JOIN users ua ON c.docencia_decision_by = ua.id
                  ORDER BY c.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($professorId, $paoId)
    {
        $query = "INSERT INTO " . $this->table . " (professor_id, pao_id, final_status) VALUES (?, ?, 'Pendiente')";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $paoId);
        return $stmt->execute();
    }

    // Método para que el profesor actualice su decisión
    public function updateProfessorDecision($id, $decision)
    {
        $query = "UPDATE " . $this->table . " SET professor_decision = ?, professor_decision_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $decision, PDO::PARAM_BOOL);
        $stmt->bindParam(2, $id);
        return $stmt->execute();
    }

    // Método para que Docencia actualice su decisión y el estado final
    public function updateDocenciaDecision($id, $decision, $approvedBy)
    {
        // Obtener la decisión del profesor para calcular el estado final
        $current = $this->find($id);
        $professorDecision = $current['professor_decision'];
        $finalStatus = ($professorDecision && $decision) ? 'Retenido' : 'No Retenido';

        $query = "UPDATE " . $this->table . " SET docencia_decision = ?, docencia_decision_by = ?, docencia_decision_at = CURRENT_TIMESTAMP, final_status = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $decision, PDO::PARAM_BOOL);
        $stmt->bindParam(2, $approvedBy);
        $stmt->bindParam(3, $finalStatus);
        $stmt->bindParam(4, $id);
        return $stmt->execute();
    }
}