<?php
// app/controllers/ContractController.php

require_once __DIR__ . '/../models/ContractModel.php';

class ContractController
{
    private $contractModel;

    public function __construct()
    {
        $this->contractModel = new ContractModel();
    }

    public function index()
    {
        $contracts = $this->contractModel->getAll();
        $pageTitle = 'Gestión de Contratos';
        require_once __DIR__ . '/../views/contracts/index.php';
    }

    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para manejar la subida del archivo y guardar en la base de datos
            // $documentPath = 'uploads/' . basename($_FILES["document"]["name"]);
            // $this->contractModel->create($professorId, $paoId, $documentPath);
            header('Location: ' . BASE_PATH . '/contracts');
            exit();
        }
    }
}