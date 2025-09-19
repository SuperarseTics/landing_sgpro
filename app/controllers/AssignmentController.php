<?php
// app/controllers/AssignmentController.php

require_once __DIR__ . '/../models/AssignmentModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/SubjectModel.php';
require_once __DIR__ . '/../models/PaoModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';

class AssignmentController
{
    private $assignmentModel;
    private $userModel;
    private $subjectModel;
    private $paoModel;
    private $roleModel;
    private $auditLogModel;

    public function __construct()
    {
        $this->assignmentModel = new AssignmentModel();
        $this->userModel = new UserModel();
        $this->subjectModel = new SubjectModel();
        $this->paoModel = new PaoModel();
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
        $assignments = $this->assignmentModel->getAssignmentsWithDetails();
        $pageTitle = 'Gestión de Asignaciones';
        // Ruta de la vista actualizada
        require_once __DIR__ . '/../views/academic/assignments.php';
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $professors = $this->userModel->getUsersByRole('Profesor');
        $subjects = $this->subjectModel->getAll();
        $paos = $this->paoModel->getAll();
        $pageTitle = 'Crear Nueva Asignación';
        // Ruta de la vista actualizada
        require_once __DIR__ . '/../views/academic/create-assignments.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_POST['professor_id'] ?? null;
            $subjectId = $_POST['subject_id'] ?? null;
            $paoId = $_POST['pao_id'] ?? null;
            $hoursPerWeek = $_POST['hours_per_week'] ?? null;
            $status = $_POST['status'] ?? 'Asignado';

            if ($this->assignmentModel->create($professorId, $subjectId, $paoId, $hoursPerWeek, $status)) {
                $lastAssignmentId = $this->assignmentModel->getLastInsertedId();
                $userIdLog = $_SESSION['user_id'] ?? null;
                $newData = ['professor_id' => $professorId, 'subject_id' => $subjectId, 'pao_id' => $paoId, 'hours_per_week' => $hoursPerWeek, 'status' => $status];
                $this->auditLogModel->logAction($userIdLog, 'CREATE', 'professor_assignments', $lastAssignmentId, null, $newData);

                header('Location: ' . BASE_PATH . '/academic/assignments');
                exit();
            } else {
                echo "Error al guardar la asignación.";
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
        $assignment = $this->assignmentModel->find($id);

        if (!$assignment) {
            header('Location: ' . BASE_PATH . '/assignments');
            exit();
        }

        $professor = $this->userModel->find($assignment['professor_id']);
        $subject = $this->subjectModel->find($assignment['subject_id']);
        $pao = $this->paoModel->find($assignment['pao_id']);

        $assignment['professor_name'] = $professor['name'] ?? 'Desconocido';
        $assignment['subject_name'] = $subject['name'] ?? 'Desconocido';
        $assignment['pao_name'] = $pao['name'] ?? 'Desconocido';

        $pageTitle = 'Editar Asignación: ' . htmlspecialchars($assignment['id']);
        // Ruta de la vista actualizada
        require_once __DIR__ . '/../views/academic/edit-assignments.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldAssignment = $this->assignmentModel->find($id);
            if (!$oldAssignment) {
                echo "Asignación no encontrada.";
                exit();
            }

            $hoursPerWeek = $_POST['hours_per_week'] ?? null;
            $status = $_POST['status'] ?? 'Asignado';

            $data = ['hours_per_week' => $hoursPerWeek, 'status' => $status];

            if ($this->assignmentModel->update($id, $data)) {
                $userIdLog = $_SESSION['user_id'] ?? null;
                $newData = ['hours_per_week' => $hoursPerWeek, 'status' => $status];
                $oldData = ['hours_per_week' => $oldAssignment['hours_per_week'], 'status' => $oldAssignment['status']];
                $this->auditLogModel->logAction($userIdLog, 'UPDATE', 'professor_assignments', $id, $oldData, $newData);

                header('Location: ' . BASE_PATH . '/assignments');
                exit();
            } else {
                echo "Error al actualizar la asignación.";
            }
        }
    }
}
