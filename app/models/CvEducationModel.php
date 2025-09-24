<?php
// app/models/CvEducationModel.php

require_once __DIR__ . '/BaseModel.php';

class CvEducationModel extends BaseModel
{
    protected $table = "cv_education";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $educationLevel,
        $institutionName,
        $degreeTitle,
        $senescytRegister
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, education_level, institution_name, degree_title, senescyt_register
        ) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $educationLevel);
        $stmt->bindParam(3, $institutionName);
        $stmt->bindParam(4, $degreeTitle);
        $stmt->bindParam(5, $senescytRegister);

        return $stmt->execute();
    }
}