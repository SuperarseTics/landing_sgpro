<?php
// app/controllers/CvPresentationsController.php

require_once __DIR__ . '/../models/CvPresentationsModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';
require_once __DIR__ . '/../models/RoleModel.php';

class CvPresentationsController
{
    private $cvPresentationsModel;
    private $auditLogModel;
    private $roleModel;

    public function __construct()
    {
        $this->cvPresentationsModel = new CvPresentationsModel();
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
        $presentationsList = $this->cvPresentationsModel->getAllByProfessorId($_SESSION['user_id']);
        $pageTitle = 'Ponencias y Presentaciones';
        require_once __DIR__ . '/../views/professor/cv/index.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_SESSION['user_id'] ?? null;
            $eventName = $_POST['event_name'] ?? '';
            $institutionName = $_POST['institution_name'] ?? '';
            $year = $_POST['year'] ?? '';
            $presentation = $_POST['presentation'] ?? '';

            if ($this->cvPresentationsModel->create(
                $professorId,
                $eventName,
                $institutionName,
                $year,
                $presentation
            )) {
                $lastId = $this->cvPresentationsModel->getLastInsertedId();
                $this->auditLogModel->logAction($professorId, 'CREATE', 'cv_presentations', $lastId);
                header('Location: ' . BASE_PATH . '/professor/cv');
                exit();
            } else {
                echo "Error al guardar la presentación.";
            }
        }
    }
}