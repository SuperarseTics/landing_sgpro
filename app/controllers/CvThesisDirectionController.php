<?php
// app/controllers/CvThesisDirectionController.php

require_once __DIR__ . '/../models/CvThesisDirectionModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';
require_once __DIR__ . '/../models/RoleModel.php';

class CvThesisDirectionController
{
    private $cvThesisDirectionModel;
    private $auditLogModel;
    private $roleModel;

    public function __construct()
    {
        $this->cvThesisDirectionModel = new CvThesisDirectionModel();
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
        $thesisDirectionList = $this->cvThesisDirectionModel->getAllByProfessorId($_SESSION['user_id']);
        $pageTitle = 'Dirección de Tesis';
        require_once __DIR__ . '/../views/professor/cv/index.php#subsection-tesis';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_SESSION['user_id'] ?? null;
            $studentName = $_POST['student_name'] ?? '';
            $thesisTitle = $_POST['thesis_title'] ?? '';
            $academicProgram = $_POST['academic_program'] ?? '';
            $universityName = $_POST['university_name'] ?? '';

            if ($this->cvThesisDirectionModel->create(
                $professorId,
                $studentName,
                $thesisTitle,
                $academicProgram,
                $universityName
            )) {
                $lastId = $this->cvThesisDirectionModel->getLastInsertedId();
                $this->auditLogModel->logAction($professorId, 'CREATE', 'cv_thesis_direction', $lastId);
                header('Location: ' . BASE_PATH . '/professor/cv');
                exit();
            } else {
                echo "Error al guardar la dirección de tesis.";
            }
        }
    }
}