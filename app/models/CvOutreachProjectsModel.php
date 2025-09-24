<?php
// app/models/CvOutreachProjectsModel.php

require_once __DIR__ . '/BaseModel.php';

class CvOutreachProjectsModel extends BaseModel
{
    protected $table = "cv_outreach_projects";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $institutionName,
        $projectName
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, institution_name, project_name
        ) VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $institutionName);
        $stmt->bindParam(3, $projectName);

        return $stmt->execute();
    }
}