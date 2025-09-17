<?php
// app/controllers/ContinuityController.php

require_once __DIR__ . '/../models/ContinuityModel.php';

class ContinuityController
{
    private $continuityModel;

    public function __construct()
    {
        $this->continuityModel = new ContinuityModel();
    }

    public function index()
    {
        $continuities = $this->continuityModel->getAll();
        $pageTitle = 'Gestión de Continuidad';
        require_once __DIR__ . '/../views/continuity/index.php';
    }

    public function decide()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_POST['professor_id'];
            $paoId = $_POST['pao_id'];
            $isRetained = isset($_POST['is_retained']) ? 1 : 0;
            $approvedBy = $_SESSION['user_id'];
            
            // $this->continuityModel->saveDecision($professorId, $paoId, $isRetained, $approvedBy);

            header('Location: ' . BASE_PATH . '/continuity');
            exit();
        }
    }
}