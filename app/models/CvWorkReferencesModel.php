<?php
// app/models/CvWorkReferencesModel.php
require_once __DIR__ . '/BaseModel.php';

class CvWorkReferencesModel extends BaseModel {
    protected $table = 'cv_work_references';

    public function __construct() {
        parent::__construct();
    }
}