<?php
// app/models/CvLanguageProficiencyModel.php
require_once __DIR__ . '/BaseModel.php';

class CvLanguageProficiencyModel extends BaseModel {
    protected $table = 'cv_language_proficiency';

    public function __construct() {
        parent::__construct();
    }
}