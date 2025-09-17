<?php
// app/models/CvThesisDirectionModel.php
require_once __DIR__ . '/BaseModel.php';

class CvThesisDirectionModel extends BaseModel {
    protected $table = 'cv_thesis_direction';

    public function __construct() {
        parent::__construct();
    }
}