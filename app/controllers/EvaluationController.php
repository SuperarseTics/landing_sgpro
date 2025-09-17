<?php
// app/controllers/EvaluationController.php

require_once __DIR__ . '/../models/EvaluationModel.php';

class EvaluationController
{
    private $evaluationModel;

    public function __construct()
    {
        $this->evaluationModel = new EvaluationModel();
    }

    public function index()
    {
        $evaluations = $this->evaluationModel->getAll();
        $pageTitle = 'Gestión de Evaluaciones';
        require_once __DIR__ . '/../views/evaluations/index.php';
    }

    public function create()
    {
        // Lógica para mostrar el formulario de creación de evaluación
        $pageTitle = 'Crear Evaluación';
        require_once __DIR__ . '/../views/evaluations/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para guardar una nueva evaluación
            $professorId = $_POST['professor_id'];
            $paoId = $_POST['pao_id'];
            $evaluatorId = $_SESSION['user_id'];
            $score = $_POST['score'];
            $comments = $_POST['comments'];
            
            // $this->evaluationModel->create($professorId, $paoId, $evaluatorId, $score, $comments);
            
            header('Location: ' . BASE_PATH . '/evaluations');
            exit();
        }
    }
}