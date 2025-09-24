<?php
// app/models/CvThesisDirectionModel.php

require_once __DIR__ . '/BaseModel.php';

class CvThesisDirectionModel extends BaseModel
{
    protected $table = "cv_thesis_direction";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $studentName,
        $thesisTitle,
        $academicProgram,
        $universityName
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, student_name, thesis_title, academic_program, university_name
        ) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $studentName);
        $stmt->bindParam(3, $thesisTitle);
        $stmt->bindParam(4, $academicProgram);
        $stmt->bindParam(5, $universityName);

        return $stmt->execute();
    }
}