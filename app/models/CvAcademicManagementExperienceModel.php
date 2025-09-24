<?php
// app/models/CvAcademicManagementExperienceModel.php

require_once __DIR__ . '/BaseModel.php';

class CvAcademicManagementExperienceModel extends BaseModel
{
    protected $table = "cv_academic_management_experience";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $startDate,
        $endDate,
        $iesName,
        $position,
        $activitiesDescription
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, start_date, end_date, ies_name, position, activities_description
        ) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $startDate);
        $stmt->bindParam(3, $endDate);
        $stmt->bindParam(4, $iesName);
        $stmt->bindParam(5, $position);
        $stmt->bindParam(6, $activitiesDescription);

        return $stmt->execute();
    }
}