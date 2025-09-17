<?php
// app/controllers/SubjectController.php

require_once __DIR__ . '/../models/SubjectModel.php';
require_once __DIR__ . '/../models/CareerModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';

class SubjectController
{
    private $subjectModel;
    private $careerModel;
    private $roleModel;
    private $auditLogModel;

    public function __construct()
    {
        $this->subjectModel = new SubjectModel();
        $this->careerModel = new CareerModel();
        $this->roleModel = new RoleModel();
        $this->auditLogModel = new AuditLogModel();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $subjects = $this->subjectModel->getSubjectsWithCareerNames();
        $careers = $this->careerModel->getAll();
        $pageTitle = 'Gestión de Asignaturas';
        require_once __DIR__ . '/../views/academic/subjects.php';
    }

    // Este es el método que faltaba para mostrar el formulario de creación
    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $careers = $this->careerModel->getAll(); // Obtiene las carreras para el select
        $pageTitle = 'Crear Nueva Asignatura';
        require_once __DIR__ . '/../views/academic/create-subject.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $careerId = $_POST['career_id'] ?? null;

            if ($this->subjectModel->create($name, $careerId)) {
                $lastSubjectId = $this->subjectModel->getLastInsertedId();
                $userId = $_SESSION['user_id'] ?? null;
                $newData = ['name' => $name, 'career_id' => $careerId];
                $this->auditLogModel->logAction($userId, 'CREATE', 'subjects', $lastSubjectId, null, $newData);

                header('Location: ' . BASE_PATH . '/academic/subjects');
                exit();
            } else {
                echo "Error al guardar la asignatura.";
            }
        }
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);

        // Obtiene todas las carreras para el campo de selección
        $careers = $this->careerModel->getAll();

        // Utiliza el método del modelo que obtiene la asignatura con el nombre de la carrera
        $subject = $this->subjectModel->findWithCareer($id);

        if (!$subject) {
            header('Location: ' . BASE_PATH . '/academic/subjects');
            exit();
        }

        $pageTitle = 'Editar Asignatura: ' . htmlspecialchars($subject['name']);
        require_once __DIR__ . '/../views/academic/edit-subject.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $careerId = $_POST['career_id'] ?? null;

            // Obtiene los datos antiguos para el registro de auditoría
            $oldSubject = $this->subjectModel->find($id);

            if ($this->subjectModel->update($id, $name, $careerId)) {
                $userId = $_SESSION['user_id'] ?? null;
                $newData = ['name' => $name, 'career_id' => $careerId];

                // Asegúrate de que los datos antiguos existen antes de usarlos
                $oldData = [];
                if ($oldSubject) {
                    $oldData = ['name' => $oldSubject['name'], 'career_id' => $oldSubject['career_id']];
                }

                $this->auditLogModel->logAction($userId, 'UPDATE', 'subjects', $id, $oldData, $newData);

                header('Location: ' . BASE_PATH . '/academic/subjects');
                exit();
            } else {
                echo "Error al actualizar la asignatura.";
            }
        }
    }
}
