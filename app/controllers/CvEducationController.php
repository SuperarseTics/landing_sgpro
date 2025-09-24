<?php
// app/controllers/CvEducationController.php

require_once __DIR__ . '/../models/CvEducationModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';
require_once __DIR__ . '/../models/RoleModel.php';

class CvEducationController
{
    private $cvEducationModel;
    private $auditLogModel;
    private $roleModel;

    public function __construct()
    {
        $this->cvEducationModel = new CvEducationModel();
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
        $educationList = $this->cvEducationModel->getAllByProfessorId($_SESSION['user_id']);
        $pageTitle = 'Educación y Formación';
        require_once __DIR__ . '/../views/professor/cv/index.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_SESSION['user_id'] ?? null;
            $educationLevel = $_POST['education_level'] ?? '';
            $institutionName = $_POST['institution_name'] ?? '';
            $degreeTitle = $_POST['degree_title'] ?? '';
            $senescytRegister = $_POST['senescyt_register'] ?? '';

            if ($this->cvEducationModel->create(
                $professorId,
                $educationLevel,
                $institutionName,
                $degreeTitle,
                $senescytRegister
            )) {
                $lastId = $this->cvEducationModel->getLastInsertedId();
                $this->auditLogModel->logAction($professorId, 'CREATE', 'cv_education', $lastId);
                header('Location: ' . BASE_PATH . '/professor/cv');
                exit();
            } else {
                echo "Error al guardar la información de educación.";
            }
        }
    }
}