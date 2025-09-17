<?php
// app/controllers/PortfolioController.php

require_once __DIR__ . '/../models/PortfolioModel.php';

class PortfolioController
{
    private $portfolioModel;

    public function __construct()
    {
        $this->portfolioModel = new PortfolioModel();
    }

    public function index()
    {
        // Lógica para listar portafolios (puedes filtrar por usuario o PAO)
        $portfolios = $this->portfolioModel->getAll();
        $pageTitle = 'Gestión de Portafolios';
        require_once __DIR__ . '/../views/portfolios/index.php';
    }

    public function upload()
    {
        // Lógica para procesar la subida del archivo
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para manejar el archivo subido
            $documentPath = 'uploads/' . basename($_FILES["document"]["name"]);
            // Mover el archivo subido al directorio
            // move_uploaded_file($_FILES["document"]["tmp_name"], $documentPath);
            
            // Guardar la información en la base de datos a través del modelo
            // $this->portfolioModel->create($professor_id, $pao_id, $documentPath);
            
            header('Location: ' . BASE_PATH . '/portfolios');
            exit();
        }
    }
}