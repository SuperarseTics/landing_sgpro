<?php
// app/models/CvProfessionalExperienceModel.php

require_once __DIR__ . '/BaseModel.php';

class CvProfessionalExperienceModel extends BaseModel
{
    protected $table = "cv_professional_experience";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $startDate,
        $endDate,
        $companyName,
        $position,
        $activitiesDescription
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, start_date, end_date, company_name, position, activities_description
        ) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $startDate);
        $stmt->bindParam(3, $endDate);
        $stmt->bindParam(4, $companyName);
        $stmt->bindParam(5, $position);
        $stmt->bindParam(6, $activitiesDescription);

        return $stmt->execute();
    }
}