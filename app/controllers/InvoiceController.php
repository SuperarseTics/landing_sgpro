<?php
// app/controllers/InvoiceController.php

require_once __DIR__ . '/../models/InvoiceModel.php';
require_once __DIR__ . '/../models/UserModel.php'; // Se agregó
require_once __DIR__ . '/../models/RoleModel.php'; // Se agregó

class InvoiceController
{
    private $invoiceModel;
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);

        $invoices = $this->invoiceModel->getAll();
        $pageTitle = 'Gestión de Facturas';
        require_once __DIR__ . '/../views/invoices/index.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lógica para guardar la factura...
            header('Location: ' . BASE_PATH . '/invoices');
            exit();
        }
    }
}