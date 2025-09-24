<?php
// app/controllers/CvOutreachProjectsController.php

require_once __DIR__ . '/../models/CvOutreachProjectsModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';
require_once __DIR__ . '/../models/RoleModel.php';

class CvOutreachProjectsController
{
    private $cvOutreachProjectsModel;
    private $auditLogModel;
    private $roleModel;

    public function __construct()
    {
        $this->cvOutreachProjectsModel = new CvOutreachProjectsModel();
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
        $outreachProjectsList = $this->cvOutreachProjectsModel->getAllByProfessorId($_SESSION['user_id']);
        $pageTitle = 'Proyectos de Vinculación';
        require_once __DIR__ . '/../views/professor/cv/index.php#subsection-vinculacion';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_SESSION['user_id'] ?? null;
            $institutionName = $_POST['institution_name'] ?? '';
            $projectName = $_POST['project_name'] ?? '';

            if ($this->cvOutreachProjectsModel->create(
                $professorId,
                $institutionName,
                $projectName
            )) {
                $lastId = $this->cvOutreachProjectsModel->getLastInsertedId();
                $this->auditLogModel->logAction($professorId, 'CREATE', 'cv_outreach_projects', $lastId);
                header('Location: ' . BASE_PATH . '/professor/cv');
                exit();
            } else {
                echo "Error al guardar el proyecto de vinculación.";
            }
        }
    }
}