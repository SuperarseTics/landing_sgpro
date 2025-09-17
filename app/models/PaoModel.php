<?php
// app/models/PaoModel.php
require_once __DIR__ . '/BaseModel.php';

class PaoModel extends BaseModel {
    protected $table = 'pao';

    public function __construct() {
        parent::__construct();
    }
}