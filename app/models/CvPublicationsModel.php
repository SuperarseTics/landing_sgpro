<?php
// app/models/CvPublicationsModel.php
require_once __DIR__ . '/BaseModel.php';

class CvPublicationsModel extends BaseModel {
    protected $table = 'cv_publications';

    public function __construct() {
        parent::__construct();
    }
}