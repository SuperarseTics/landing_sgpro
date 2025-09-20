<?php
// app/controllers/PortfolioController.php

require_once __DIR__ . '/../models/PortfolioModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/PaoModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';

class PortfolioController
{
    private $portfolioModel;
    private $userModel;
    private $paoModel;
    private $roleModel;
    private $auditLogModel;

    public function __construct()
    {
        $this->portfolioModel = new PortfolioModel();
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
        // Obtiene una lista de todos los portafolios con detalles
        $portfolios = $this->portfolioModel->getPortfoliosWithDetails();
        $pageTitle = 'Gestión de Portafolios';
        require_once __DIR__ . '/../views/portfolios/index.php';
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
        $pageTitle = 'Crear Nuevo Portafolio';
        require_once __DIR__ . '/../views/portfolios/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/portfolios');
            exit();
        }

        $professorId = $_POST['professor_id'];
        $paoId = $_POST['pao_id'];

        // Se crea la entrada inicial con la primera unidad y un placeholder
        $data = [
            'professor_id' => $professorId,
            'pao_id' => $paoId,
            'unit_number' => 1,
            'docencia_path' => null,
            'practicas_path' => null,
            'titulacion_path' => null
        ];

        // Verificar si el portafolio ya existe para evitar duplicados
        $existing = $this->portfolioModel->findByKeys($professorId, $paoId, 1);
        if ($existing) {
            echo "El portafolio ya existe. Por favor, edítelo.";
            exit();
        }

        if ($this->portfolioModel->create($data)) {
            $lastId = $this->portfolioModel->getLastInsertedId();
            $this->auditLogModel->logAction($_SESSION['user_id'], 'CREATE', 'portfolios', $lastId, null, $data);
            header('Location: ' . BASE_PATH . '/portfolios/edit/' . $lastId);
            exit();
        } else {
            echo "Error al crear el portafolio.";
        }
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);

        $portfolio = $this->portfolioModel->find($id);
        if (!$portfolio) {
            header('Location: ' . BASE_PATH . '/portfolios');
            exit();
        }

        $professorId = $portfolio['professor_id'];
        $paoId = $portfolio['pao_id'];

        // Obtener todos los datos de portafolio para este profesor y PAO
        $portfolioData = $this->portfolioModel->getPortfolio($professorId, $paoId);
        $professor = $this->userModel->find($professorId);
        $pao = $this->paoModel->find($paoId);

        $pageTitle = "Editar Portafolio de " . htmlspecialchars($professor['name']) . " para " . htmlspecialchars($pao['name']);

        require_once __DIR__ . '/../views/portfolios/edit.php';
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/portfolios');
            exit();
        }

        $oldPortfolio = $this->portfolioModel->find($id);
        if (!$oldPortfolio) {
            header('Location: ' . BASE_PATH . '/portfolios');
            exit();
        }

        $unitNumber = $_POST['unit_number'];

        // Lógica de subida de archivos
        $uploadFileDir = __DIR__ . '/../../public/uploads/portfolios/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        $docenciaPath = $oldPortfolio['docencia_path'];
        if (isset($_FILES['docencia_file']) && $_FILES['docencia_file']['error'] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_docencia_' . basename($_FILES['docencia_file']['name']);
            if (move_uploaded_file($_FILES['docencia_file']['tmp_name'], $uploadFileDir . $fileName)) {
                $docenciaPath = '/uploads/portfolios/' . $fileName;
            }
        }

        $practicasPath = $oldPortfolio['practicas_path'];
        if (isset($_FILES['practicas_file']) && $_FILES['practicas_file']['error'] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_practicas_' . basename($_FILES['practicas_file']['name']);
            if (move_uploaded_file($_FILES['practicas_file']['tmp_name'], $uploadFileDir . $fileName)) {
                $practicasPath = '/uploads/portfolios/' . $fileName;
            }
        }

        $titulacionPath = $oldPortfolio['titulacion_path'];
        if (isset($_FILES['titulacion_file']) && $_FILES['titulacion_file']['error'] === UPLOAD_ERR_OK) {
            $fileName = uniqid() . '_titulacion_' . basename($_FILES['titulacion_file']['name']);
            if (move_uploaded_file($_FILES['titulacion_file']['tmp_name'], $uploadFileDir . $fileName)) {
                $titulacionPath = '/uploads/portfolios/' . $fileName;
            }
        }

        $data = [
            'docencia_path' => $docenciaPath,
            'practicas_path' => $practicasPath,
            'titulacion_path' => $titulacionPath
        ];

        if ($this->portfolioModel->update($id, $data)) {
            $this->auditLogModel->logAction($_SESSION['user_id'], 'UPDATE', 'portfolios', $id, $oldPortfolio, $data);
            header('Location: ' . BASE_PATH . '/portfolios/edit/' . $id);
            exit();
        } else {
            echo "Error al actualizar el portafolio.";
        }
    }
}
