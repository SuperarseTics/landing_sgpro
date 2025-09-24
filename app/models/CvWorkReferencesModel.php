<?php
// app/models/CvWorkReferencesModel.php

require_once __DIR__ . '/BaseModel.php';

class CvWorkReferencesModel extends BaseModel
{
    protected $table = "cv_work_references";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $contactPerson,
        $relationPosition,
        $organizationCompany,
        $contactNumber
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, contact_person, relation_position, organization_company, contact_number
        ) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $contactPerson);
        $stmt->bindParam(3, $relationPosition);
        $stmt->bindParam(4, $organizationCompany);
        $stmt->bindParam(5, $contactNumber);

        return $stmt->execute();
    }
}