<?php
// app/models/CvPresentationsModel.php
require_once __DIR__ . '/BaseModel.php';

class CvPresentationsModel extends BaseModel {
    protected $table = 'cv_presentations';

    public function __construct() {
        parent::__construct();
    }
}