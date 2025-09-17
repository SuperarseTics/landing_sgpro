<?php
// app/controllers/AcademicController.php

require_once __DIR__ . '/../models/CareerModel.php';
require_once __DIR__ . '/../models/SubjectModel.php';
require_once __DIR__ . '/../models/ProfessorAssignmentModel.php';

class AcademicController
{
    private $careerModel;
    private $subjectModel;
    private $assignmentModel;

    public function __construct()
    {
        $this->careerModel = new CareerModel();
        $this->subjectModel = new SubjectModel();
        $this->assignmentModel = new ProfessorAssignmentModel();
    }

    public function careers()
    {
        $careers = $this->careerModel->getAll();
        $pageTitle = 'Gestión de Carreras';
        require_once __DIR__ . '/../views/academic/careers.php';
    }
    
    public function subjects()
    {
        $subjects = $this->subjectModel->getAll();
        $pageTitle = 'Gestión de Asignaturas';
        require_once __DIR__ . '/../views/academic/subjects.php';
    }
    
    public function assignments()
    {
        $assignments = $this->assignmentModel->getAll();
        $pageTitle = 'Asignaciones a Profesores';
        require_once __DIR__ . '/../views/academic/assignments.php';
    }
}