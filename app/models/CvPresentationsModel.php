<?php
// app/models/CvPresentationsModel.php

require_once __DIR__ . '/BaseModel.php';

class CvPresentationsModel extends BaseModel
{
    protected $table = "cv_presentations";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $eventName,
        $institutionName,
        $year,
        $presentation
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, event_name, institution_name, year, presentation
        ) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $eventName);
        $stmt->bindParam(3, $institutionName);
        $stmt->bindParam(4, $year);
        $stmt->bindParam(5, $presentation);

        return $stmt->execute();
    }
}