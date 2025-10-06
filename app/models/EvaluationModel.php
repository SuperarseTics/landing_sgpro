<?php
// app/models/EvaluationModel.php

declare(strict_types=1); // Habilita la comprobación estricta de tipos

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

    /**
     * Obtiene las evaluaciones con detalles, filtradas por rol de usuario.
     * * @param int $userId El ID del usuario logueado.
     * @param string $userRole El rol principal del usuario logueado.
     * @return array
     */
    public function getEvaluationsWithDetails(int $userId, string $userRole): array
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
                    e.evaluation_date,
                    e.professor_id as evaluation_professor_id
                  FROM " . $this->table . " e
                  JOIN users u_prof ON e.professor_id = u_prof.id
                  JOIN pao p ON e.pao_id = p.id
                  JOIN users u_eval ON e.evaluator_id = u_eval.id";

        $params = [];
        $whereClause = "";

        // Roles que tienen acceso irrestricto (pueden ver todas las evaluaciones)
        $unrestrictedRoles = ['super administrador', 'coordinador académico', 'director de docencia'];

        // Aplicación de la lógica de filtrado
        // Si el rol NO está en la lista de irrestrictos, se aplica el filtro por ID.
        if (!in_array(strtolower($userRole), $unrestrictedRoles)) {
            // Los roles restringidos (como 'Profesor') solo ven sus propias evaluaciones.
            $whereClause = " WHERE e.professor_id = ?";
            $params[] = $userId;
        }

        $query .= $whereClause;
        $query .= " ORDER BY e.evaluation_date DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una evaluación por su ID.
     * Se mantiene aquí para la verificación de permisos en el controlador.
     */
    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getLastInsertedId(): string
    {
        return $this->db->lastInsertId();
    }
}
