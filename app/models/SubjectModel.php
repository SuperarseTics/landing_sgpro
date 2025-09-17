<?php
// app/models/SubjectModel.php
require_once __DIR__ . '/BaseModel.php';

class SubjectModel extends BaseModel {
    protected $table = 'subjects';

    public function __construct() {
        parent::__construct();
    }
}