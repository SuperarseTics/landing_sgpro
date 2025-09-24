<?php
// app/controllers/ProfessorCvController.php

require_once __DIR__ . '/../models/ProfessorCvModel.php';
require_once __DIR__ . '/../models/AuditLogModel.php';
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../models/CvEducationModel.php';
require_once __DIR__ . '/../models/CvAcademicManagementExperienceModel.php';
require_once __DIR__ . '/../models/CvTeachingExperienceModel.php';
require_once __DIR__ . '/../models/CvProfessionalExperienceModel.php';
require_once __DIR__ . '/../models/CvResearchProjectsModel.php';
require_once __DIR__ . '/../models/CvPresentationsModel.php';
require_once __DIR__ . '/../models/CvPublicationsModel.php';
require_once __DIR__ . '/../models/CvOutreachProjectsModel.php';
require_once __DIR__ . '/../models/CvThesisDirectionModel.php';
require_once __DIR__ . '/../models/CvWorkReferencesModel.php';
require_once __DIR__ . '/../models/CvPersonalReferencesModel.php';

class ProfessorCvController
{
    private $professorCvModel;
    private $educationModel;
    private $academicManagementExperienceModel;
    private $teachingExperienceModel;
    private $professionalExperienceModel;
    private $researchProjectsModel;
    private $presentationsModel;
    private $publicationsModel;
    private $outreachProjectsModel;
    private $thesisDirectionModel;
    private $workReferencesModel;
    private $personalReferencesModel;
    private $auditLogModel;
    private $roleModel;

    public function __construct()
    {
        $this->professorCvModel = new ProfessorCvModel();
        $this->educationModel = new CvEducationModel();
        $this->academicManagementExperienceModel = new CvAcademicManagementExperienceModel();
        $this->teachingExperienceModel = new CvTeachingExperienceModel();
        $this->professionalExperienceModel = new CvProfessionalExperienceModel();
        $this->researchProjectsModel = new CvResearchProjectsModel();
        $this->presentationsModel = new CvPresentationsModel();
        $this->publicationsModel = new CvPublicationsModel();
        $this->outreachProjectsModel = new CvOutreachProjectsModel();
        $this->thesisDirectionModel = new CvThesisDirectionModel();
        $this->workReferencesModel = new CvWorkReferencesModel();
        $this->personalReferencesModel = new CvPersonalReferencesModel();
        $this->auditLogModel = new AuditLogModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        $professorId = $_SESSION['user_id'];

        // Obtener los datos del CV del profesor
        $professorCv = $this->professorCvModel->findByProfessorId($professorId);

        // Obtener los datos para cada una de las listas
        $educationList = $this->educationModel->getAllByProfessorId($professorId);
        $academicManagementExperienceList = $this->academicManagementExperienceModel->getAllByProfessorId($professorId);
        $teachingExperienceList = $this->teachingExperienceModel->getAllByProfessorId($professorId);
        $professionalExperienceList = $this->professionalExperienceModel->getAllByProfessorId($professorId);
        $researchProjectsList = $this->researchProjectsModel->getAllByProfessorId($professorId);
        $presentationsList = $this->presentationsModel->getAllByProfessorId($professorId);
        $publicationsList = $this->publicationsModel->getAllByProfessorId($professorId);
        $outreachProjectsList = $this->outreachProjectsModel->getAllByProfessorId($professorId);
        $thesisDirectionList = $this->thesisDirectionModel->getAllByProfessorId($professorId);
        $workReferencesList = $this->workReferencesModel->getAllByProfessorId($professorId);
        $personalReferencesList = $this->personalReferencesModel->getAllByProfessorId($professorId);
        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);

        $pageTitle = 'Hoja de Vida';

        // Preparar un array de datos para pasar a la vista
        $data = [
            'pageTitle' => $pageTitle,
            'roles' => $roles,
            'professorCv' => $professorCv,
            'educationList' => $educationList,
            'academicManagementExperienceList' => $academicManagementExperienceList,
            'teachingExperienceList' => $teachingExperienceList,
            'professionalExperienceList' => $professionalExperienceList,
            'researchProjectsList' => $researchProjectsList,
            'presentationsList' => $presentationsList,
            'publicationsList' => $publicationsList,
            'outreachProjectsList' => $outreachProjectsList,
            'thesisDirectionList' => $thesisDirectionList,
            'workReferencesList' => $workReferencesList,
            'personalReferencesList' => $personalReferencesList,
        ];

        // Extraer el array de datos para que las variables estén disponibles en la vista
        extract($data);

        // Incluir la vista
        require_once __DIR__ . '/../views/professor/cv/index.php';
    }

    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/');
            exit();
        }

        $roles = $this->roleModel->getRolesByUserId($_SESSION['user_id']);
        $pageTitle = 'Crear CV del Profesor';
        require_once __DIR__ . '/../views/professor/cv/index.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $professorId = $_SESSION['user_id'] ?? null;
            $surnames = $_POST['surnames'] ?? '';
            $firstName = $_POST['first_name'] ?? '';
            $cedulaPassport = $_POST['cedula_passport'] ?? '';
            $nationality = $_POST['nationality'] ?? null;
            $birthDate = $_POST['birth_date'] ?? null;
            $city = $_POST['city'] ?? null;
            $address = $_POST['address'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $cellPhone = $_POST['cell_phone'] ?? null;
            $email = $_POST['email'] ?? '';
            $photoPath = null;

            // Lógica de subida de foto
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/photos/';
                $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                    $photoPath = '/uploads/photos/' . $fileName; // Guarda la ruta relativa
                }
            }

            // Verifica si ya existe un perfil para este profesor
            $existingCv = $this->professorCvModel->findByProfessorId($professorId);

            if ($existingCv) {
                // Si ya existe, actualiza los datos
                $this->professorCvModel->update(
                    $professorId,
                    $surnames,
                    $firstName,
                    $cedulaPassport,
                    $nationality,
                    $birthDate,
                    $city,
                    $address,
                    $phone,
                    $cellPhone,
                    $email,
                    $photoPath
                );
            } else {
                // Si no existe, crea un nuevo registro
                $this->professorCvModel->create(
                    $professorId,
                    $surnames,
                    $firstName,
                    $cedulaPassport,
                    $nationality,
                    $birthDate,
                    $city,
                    $address,
                    $phone,
                    $cellPhone,
                    $email,
                    $photoPath
                );
            }

            header('Location: ' . BASE_PATH . '/professor/cv');
            exit();
        }
    }
}
