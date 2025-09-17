<?php
// app/models/CvTrainingModel.php
require_once __DIR__ . '/BaseModel.php';

class CvTrainingModel extends BaseModel {
    protected $table = 'cv_training';

    public function __construct() {
        parent::__construct();
    }
}