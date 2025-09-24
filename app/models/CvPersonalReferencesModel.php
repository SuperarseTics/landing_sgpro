<?php
// app/models/CvPersonalReferencesModel.php

require_once __DIR__ . '/BaseModel.php';

class CvPersonalReferencesModel extends BaseModel
{
    protected $table = "cv_personal_references";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $contactPerson,
        $relationshipType,
        $contactNumber
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, contact_person, relationship_type, contact_number
        ) VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $contactPerson);
        $stmt->bindParam(3, $relationshipType);
        $stmt->bindParam(4, $contactNumber);

        return $stmt->execute();
    }
}