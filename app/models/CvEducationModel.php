<?php
// app/models/CvEducationModel.php
require_once __DIR__ . '/BaseModel.php';

class CvEducationModel extends BaseModel {
    protected $table = 'cv_education';

    public function __construct() {
        parent::__construct();
    }
}