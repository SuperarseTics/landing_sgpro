<?php
// app/controllers/InvoiceController.php

require_once __DIR__ . '/../models/InvoiceModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/PaoModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';

class InvoiceController
{
    private $invoiceModel;
    private $userModel;
    private $paoModel;
    private $roleModel;
    private $auditLogModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->userModel = new UserModel();
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

        // Make sure your InvoiceModel has this method implemented
        $invoices = $this->invoiceModel->getInvoicesWithDetails();

        $pageTitle = 'Gestión de Facturas';

        // **This is the line you need to check carefully.**
        require_once __DIR__ . '/../views/invoices/index.php';
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $professors = $this->userModel->getUsersByRole('Profesor');
        $paos = $this->paoModel->getAll();
        $pageTitle = 'Crear Nueva Factura';
        require_once __DIR__ . '/../views/invoices/create-invoice.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_POST['professor_id'] ?? null;
            $paoId = $_POST['pao_id'] ?? null;
            $amount = $_POST['amount'] ?? null;
            $status = $_POST['status'] ?? 'Pendiente';
            $paymentProofPath = null;

            if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/proofs/';
                $fileName = uniqid() . '_' . basename($_FILES['payment_proof']['name']);
                $paymentProofPath = $uploadDir . $fileName;
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                move_uploaded_file($_FILES['payment_proof']['tmp_name'], $paymentProofPath);
            }

            if ($this->invoiceModel->create($professorId, $paoId, $amount, $status, $paymentProofPath)) {
                $lastInvoiceId = $this->invoiceModel->getLastInsertedId();
                $userId = $_SESSION['user_id'] ?? null;
                $newData = ['professor_id' => $professorId, 'pao_id' => $paoId, 'amount' => $amount, 'status' => $status];
                $this->auditLogModel->logAction($userId, 'CREATE', 'invoices', $lastInvoiceId, null, $newData);
                header('Location: ' . BASE_PATH . '/invoices');
                exit();
            } else {
                echo "Error al guardar la factura.";
            }
        }
    }

    // Método para mostrar el formulario de edición
    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $invoice = $this->invoiceModel->find($id);

        if (!$invoice) {
            header('Location: ' . BASE_PATH . '/invoices');
            exit();
        }

        // Obtener el nombre del profesor usando el ID de la factura
        $professor = $this->userModel->find($invoice['professor_id']);

        // Si el profesor existe, pasar su nombre a la vista
        if ($professor) {
            $invoice['professor_name'] = $professor['name'];
        } else {
            $invoice['professor_name'] = 'Desconocido';
        }

        // Obtener también el nombre del PAO
        $pao = $this->paoModel->find($invoice['pao_id']);
        if ($pao) {
            $invoice['pao_name'] = $pao['name'];
        } else {
            $invoice['pao_name'] = 'Desconocido';
        }

        $pageTitle = 'Editar Factura: ' . htmlspecialchars($invoice['id']);
        require_once __DIR__ . '/../views/invoices/edit-invoice.php';
    }

    // Método para procesar la actualización de la factura
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $oldInvoice = $this->invoiceModel->find($id);
            if (!$oldInvoice) {
                echo "Factura no encontrada.";
                exit();
            }

            $amount = $_POST['amount'] ?? null;
            $status = $_POST['status'] ?? 'Pendiente';
            $paymentProofPath = $oldInvoice['payment_proof_path'];

            if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
                // Lógica para subir un nuevo archivo de comprobante de pago
                $uploadDir = 'uploads/proofs/';
                $fileName = uniqid() . '_' . basename($_FILES['payment_proof']['name']);
                $paymentProofPath = $uploadDir . $fileName;
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                move_uploaded_file($_FILES['payment_proof']['tmp_name'], $paymentProofPath);
            }

            if ($this->invoiceModel->update($id, $amount, $status, $paymentProofPath)) {
                $userId = $_SESSION['user_id'] ?? null;
                $newData = ['amount' => $amount, 'status' => $status, 'payment_proof_path' => $paymentProofPath];
                $oldData = ['amount' => $oldInvoice['amount'], 'status' => $oldInvoice['status'], 'payment_proof_path' => $oldInvoice['payment_proof_path']];
                $this->auditLogModel->logAction($userId, 'UPDATE', 'invoices', $id, $oldData, $newData);

                header('Location: ' . BASE_PATH . '/invoices');
                exit();
            } else {
                echo "Error al actualizar la factura.";
            }
        }
    }
}
