<?php
// app/controllers/InvoiceController.php

require_once __DIR__ . '/../models/InvoiceModel.php';

class InvoiceController
{
    private $invoiceModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
    }

    public function index()
    {
        $invoices = $this->invoiceModel->getAll();
        $pageTitle = 'Gestión de Facturas';
        require_once __DIR__ . '/../views/invoices/index.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para guardar la factura
            $professorId = $_POST['professor_id'];
            $paoId = $_POST['pao_id'];
            $amount = $_POST['amount'];
            $status = $_POST['status'];
            
            // $this->invoiceModel->create($professorId, $paoId, $amount, $status);

            header('Location: ' . BASE_PATH . '/invoices');
            exit();
        }
    }
}