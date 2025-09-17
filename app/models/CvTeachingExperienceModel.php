<?php
// app/models/CvTeachingExperienceModel.php
require_once __DIR__ . '/BaseModel.php';

class CvTeachingExperienceModel extends BaseModel {
    protected $table = 'cv_teaching_experience';

    public function __construct() {
        parent::__construct();
    }
}