<?php
// app/models/CvProfessionalExperienceModel.php
require_once __DIR__ . '/BaseModel.php';

class CvProfessionalExperienceModel extends BaseModel {
    protected $table = 'cv_professional_experience';

    public function __construct() {
        parent::__construct();
    }
}