<?php
// app/models/CvResearchProjectsModel.php
require_once __DIR__ . '/BaseModel.php';

class CvResearchProjectsModel extends BaseModel {
    protected $table = 'cv_research_projects';

    public function __construct() {
        parent::__construct();
    }
}