<?php
// app/controllers/PaoController.php

require_once __DIR__ . '/../models/PaoModel.php';

class PaoController
{
    private $paoModel;

    public function __construct()
    {
        $this->paoModel = new PaoModel();
    }

    public function index()
    {
        $paos = $this->paoModel->getAll();
        $pageTitle = 'Gestión de PAO';
        require_once __DIR__ . '/../views/pao/index.php';
    }

    public function create()
    {
        $pageTitle = 'Crear PAO';
        require_once __DIR__ . '/../views/pao/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para guardar un nuevo PAO
            $name = $_POST['name'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            // Usar el modelo para insertar en la base de datos
            // $this->paoModel->create($name, $start_date, $end_date);
            
            // Redirigir después de guardar
            header('Location: ' . BASE_PATH . '/pao');
            exit();
        }
    }
}