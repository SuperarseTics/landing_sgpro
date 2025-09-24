<?php
// app/controllers/CvPublicationsController.php

require_once __DIR__ . '/../models/CvPublicationsModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';
require_once __DIR__ . '/../models/RoleModel.php';

class CvPublicationsController
{
    private $cvPublicationsModel;
    private $auditLogModel;
    private $roleModel;

    public function __construct()
    {
        $this->cvPublicationsModel = new CvPublicationsModel();
        $this->auditLogModel = new AuditLogModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $publicationsList = $this->cvPublicationsModel->getAllByProfessorId($_SESSION['user_id']);
        $pageTitle = 'Publicaciones';
        require_once __DIR__ . '/../views/professor/cv/index.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_SESSION['user_id'] ?? null;
            $productionType = $_POST['production_type'] ?? '';
            $publicationTitle = $_POST['publication_title'] ?? '';
            $publisherMagazine = $_POST['publisher_magazine'] ?? '';
            $isbnIssn = $_POST['isbn_issn'] ?? '';
            $authorship = $_POST['authorship'] ?? '';

            if ($this->cvPublicationsModel->create(
                $professorId,
                $productionType,
                $publicationTitle,
                $publisherMagazine,
                $isbnIssn,
                $authorship
            )) {
                $lastId = $this->cvPublicationsModel->getLastInsertedId();
                $this->auditLogModel->logAction($professorId, 'CREATE', 'cv_publications', $lastId);
                header('Location: ' . BASE_PATH . '/professor/cv');
                exit();
            } else {
                echo "Error al guardar la publicación.";
            }
        }
    }
}