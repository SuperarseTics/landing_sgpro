<?php
// app/controllers/CvAcademicManagementExperienceController.php

require_once __DIR__ . '/../models/CvAcademicManagementExperienceModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';
require_once __DIR__ . '/../models/RoleModel.php';

class CvAcademicManagementExperienceController
{
    private $cvAcademicManagementExperienceModel;
    private $auditLogModel;
    private $roleModel;

    public function __construct()
    {
        $this->cvAcademicManagementExperienceModel = new CvAcademicManagementExperienceModel();
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
        $academicManagementExperienceList = $this->cvAcademicManagementExperienceModel->getAllByProfessorId($_SESSION['user_id']);
        $pageTitle = 'Experiencia en Gestión Académica';
        require_once __DIR__ . '/../views/professor/cv/index.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_SESSION['user_id'] ?? null;
            $startDate = $_POST['start_date'] ?? '';
            $endDate = $_POST['end_date'] ?? '';
            $iesName = $_POST['ies_name'] ?? '';
            $position = $_POST['position'] ?? '';
            $activitiesDescription = $_POST['activities_description'] ?? '';

            if ($this->cvAcademicManagementExperienceModel->create(
                $professorId,
                $startDate,
                $endDate,
                $iesName,
                $position,
                $activitiesDescription
            )) {
                $lastId = $this->cvAcademicManagementExperienceModel->getLastInsertedId();
                $this->auditLogModel->logAction($professorId, 'CREATE', 'cv_academic_management_experience', $lastId);
                header('Location: ' . BASE_PATH . '/professor/cv');
                exit();
            } else {
                echo "Error al guardar la experiencia en gestión académica.";
            }
        }
    }
}