<?php
// app/models/CvOutreachProjectsModel.php
require_once __DIR__ . '/BaseModel.php';

class CvOutreachProjectsModel extends BaseModel {
    protected $table = 'cv_outreach_projects';

    public function __construct() {
        parent::__construct();
    }
}