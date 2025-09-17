<?php
// app/models/CvAcademicManagementExperienceModel.php
require_once __DIR__ . '/BaseModel.php';

class CvAcademicManagementExperienceModel extends BaseModel {
    protected $table = 'cv_academic_management_experience';

    public function __construct() {
        parent::__construct();
    }
}