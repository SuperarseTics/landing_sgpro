<?php
// app/models/CvPersonalReferencesModel.php
require_once __DIR__ . '/BaseModel.php';

class CvPersonalReferencesModel extends BaseModel {
    protected $table = 'cv_personal_references';

    public function __construct() {
        parent::__construct();
    }
}