<?php
// app/models/ProfessorCvModel.php
require_once __DIR__ . '/BaseModel.php';

class ProfessorCvModel extends BaseModel {
    protected $table = 'professor_cv';

    public function __construct() {
        parent::__construct();
    }
}