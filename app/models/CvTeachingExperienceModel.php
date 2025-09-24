<?php
// app/models/CvTeachingExperienceModel.php

require_once __DIR__ . '/BaseModel.php';

class CvTeachingExperienceModel extends BaseModel
{
    protected $table = "cv_teaching_experience";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $startDate,
        $endDate,
        $ies,
        $denomination,
        $subjects
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, start_date, end_date, ies, denomination, subjects
        ) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $startDate);
        $stmt->bindParam(3, $endDate);
        $stmt->bindParam(4, $ies);
        $stmt->bindParam(5, $denomination);
        $stmt->bindParam(6, $subjects);

        return $stmt->execute();
    }
}