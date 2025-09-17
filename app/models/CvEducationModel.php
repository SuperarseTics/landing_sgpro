<?php
// app/models/CvEducationModel.php
require_once __DIR__ . '/BaseModel.php';

class CvEducationModel extends BaseModel {
    protected $table = 'cv_education';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Busca todos los registros de educación para un profesor específico.
     * @param int $professorId
     * @return array
     */
    public function findByProfessorId($professorId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE professor_id = ?");
        $stmt->execute([$professorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}