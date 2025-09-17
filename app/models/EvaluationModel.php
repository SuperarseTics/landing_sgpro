<?php
// app/models/EvaluationModel.php
require_once __DIR__ . '/BaseModel.php';

class EvaluationModel extends BaseModel {
    protected $table = 'evaluations';

    public function __construct() {
        parent::__construct();
    }
}