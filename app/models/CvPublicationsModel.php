<?php
// app/models/CvPublicationsModel.php

require_once __DIR__ . '/BaseModel.php';

class CvPublicationsModel extends BaseModel
{
    protected $table = "cv_publications";

    public function __construct()
    {
        parent::__construct();
    }

    public function create(
        $professorId,
        $productionType,
        $publicationTitle,
        $publisherMagazine,
        $isbnIssn,
        $authorship
    ) {
        $query = "INSERT INTO {$this->table} (
            professor_id, production_type, publication_title, publisher_magazine, isbn_issn, authorship
        ) VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $productionType);
        $stmt->bindParam(3, $publicationTitle);
        $stmt->bindParam(4, $publisherMagazine);
        $stmt->bindParam(5, $isbnIssn);
        $stmt->bindParam(6, $authorship);

        return $stmt->execute();
    }
}