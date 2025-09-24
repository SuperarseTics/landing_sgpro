<?php
// app/models/CvResearchProjectsModel.php

require_once __DIR__ . '/BaseModel.php';

class CvResearchProjectsModel extends BaseModel
{
    protected $table = "cv_research_projects";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $denomination,
        $scope,
        $responsibility,
        $entityName,
        $year,
        $duration
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, denomination, scope, responsibility, entity_name, year, duration
        ) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $denomination);
        $stmt->bindParam(3, $scope);
        $stmt->bindParam(4, $responsibility);
        $stmt->bindParam(5, $entityName);
        $stmt->bindParam(6, $year);
        $stmt->bindParam(7, $duration);

        return $stmt->execute();
    }
}