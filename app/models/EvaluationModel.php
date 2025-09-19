<?php
// app/models/EvaluationModel.php

require_once __DIR__ . '/BaseModel.php';

class EvaluationModel extends BaseModel
{
    protected $table = 'evaluations';

    public function __construct()
    {
        parent::__construct();
    }

    public function create(array $data)
    {
        $query = "INSERT INTO " . $this->table . " (
                    professor_id, pao_id, evaluator_id, score, comments, initial_file_path, status, final_status
                  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $data['professor_id'],
            $data['pao_id'],
            $data['evaluator_id'],
            $data['score'],
            $data['comments'],
            $data['initial_file_path'],
            $data['status'],
            $data['final_status']
        ]);
    }

    public function update($id, array $data)
    {
        $query = "UPDATE " . $this->table . " SET
                    professor_id = ?, pao_id = ?, evaluator_id = ?, score = ?, comments = ?,
                    status = ?, final_status = ?, initial_file_path = ?, signed_file_path = ?,
                    professor_signed_at = ?
                  WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $data['professor_id'],
            $data['pao_id'],
            $data['evaluator_id'],
            $data['score'],
            $data['comments'],
            $data['status'],
            $data['final_status'],
            $data['initial_file_path'],
            $data['signed_file_path'],
            $data['professor_signed_at'],
            $id
        ]);
    }

    public function getEvaluationsWithDetails()
    {
        $query = "SELECT
                    e.id,
                    u_prof.name AS professor_name,
                    p.name AS pao_name,
                    u_eval.name AS evaluator_name,
                    e.score,
                    e.comments,
                    e.status,
                    e.final_status,
                    e.initial_file_path,
                    e.signed_file_path,
                    e.evaluation_date
                  FROM " . $this->table . " e
                  JOIN users u_prof ON e.professor_id = u_prof.id
                  JOIN pao p ON e.pao_id = p.id
                  JOIN users u_eval ON e.evaluator_id = u_eval.id
                  ORDER BY e.evaluation_date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
