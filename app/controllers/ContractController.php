<?php
// app/controllers/ContractController.php

require_once __DIR__ . '/../models/ContractModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/PaoModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';

class ContractController
{
    private $contractModel;
    private $userModel;
    private $roleModel;
    private $paoModel;
    private $auditLogModel;

    public function __construct()
    {
        $this->contractModel = new ContractModel();
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->paoModel = new PaoModel();
        $this->auditLogModel = new AuditLogModel();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $contracts = $this->contractModel->getContractsWithDetails();
        $pageTitle = 'Gestión de Contratos';
        require_once __DIR__ . '/../views/contracts/index.php';
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
        $pageTitle = 'Crear Nuevo Contrato';
        require_once __DIR__ . '/../views/contracts/create-contract.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_POST['professor_id'] ?? null;
            $paoId = $_POST['pao_id'] ?? null;
            $startDate = $_POST['start_date'] ?? null;
            $endDate = $_POST['end_date'] ?? null;
            $status = $_POST['status'] ?? 'Activo';
            $documentPath = null;

            if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/contracts/';
                $fileName = uniqid() . '_' . basename($_FILES['document']['name']);
                $documentPath = $uploadDir . $fileName;
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                move_uploaded_file($_FILES['document']['tmp_name'], $documentPath);
            }

            if ($this->contractModel->create($professorId, $paoId, $startDate, $endDate, $status, $documentPath)) {
                $lastContractId = $this->contractModel->getLastInsertedId();
                $userIdLog = $_SESSION['user_id'] ?? null;
                $newData = ['professor_id' => $professorId, 'pao_id' => $paoId, 'start_date' => $startDate, 'end_date' => $endDate, 'status' => $status, 'document_path' => $documentPath];
                $this->auditLogModel->logAction($userIdLog, 'CREATE', 'contracts', $lastContractId, null, $newData);

                header('Location: ' . BASE_PATH . '/contracts');
                exit();
            } else {
                echo "Error al guardar el contrato.";
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
        $contract = $this->contractModel->find($id);

        if (!$contract) {
            header('Location: ' . BASE_PATH . '/contracts');
            exit();
        }

        $professors = $this->userModel->getUsersByRole('Profesor');
        $paos = $this->paoModel->getAll();
        $pageTitle = 'Editar Contrato: ' . htmlspecialchars($contract['id']);

        $professor = $this->userModel->find($contract['professor_id']);
        if ($professor) {
            $contract['professor_name'] = $professor['name'];
        } else {
            $contract['professor_name'] = 'Desconocido';
        }

        $pao = $this->paoModel->find($contract['pao_id']);
        if ($pao) {
            $contract['pao_name'] = $pao['name'];
        } else {
            $contract['pao_name'] = 'Desconocido';
        }

        require_once __DIR__ . '/../views/contracts/edit-contract.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Obtener los datos del formulario
            $startDate = $_POST['start_date'];
            $endDate = $_POST['end_date'];
            $status = $_POST['status'];

            // 2. Lógica para manejar la subida del archivo
            $newDocumentPath = null;
            if (isset($_FILES['new_contract_file']) && $_FILES['new_contract_file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['new_contract_file']['tmp_name'];
                $fileName = $_FILES['new_contract_file']['name'];
                $fileSize = $_FILES['new_contract_file']['size'];
                $fileType = $_FILES['new_contract_file']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                $allowedfileExtensions = ['pdf', 'doc', 'docx'];
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadDir = __DIR__ . '/../../public/uploads/contracts/';
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    $destPath = $uploadDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        // La ruta que se guarda en la DB NO debe incluir la carpeta `public`.
                        // Se agrega el '/' inicial para que sea una ruta absoluta desde la carpeta `public`.
                        $newDocumentPath = '/uploads/contracts/' . $newFileName;
                    }
                }
            }

            // 3. Llamar al modelo para actualizar el contrato
            $success = $this->contractModel->updateContract($id, $startDate, $endDate, $status, $newDocumentPath);

            if ($success) {
                // Redirigir a la vista de contratos con un mensaje de éxito
                header('Location: ' . BASE_PATH . '/contracts');
                exit;
            } else {
                // Manejar el error de actualización
                // ...
            }
        }
    }
}
