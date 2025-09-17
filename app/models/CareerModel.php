<?php
// app/models/CareerModel.php
require_once __DIR__ . '/BaseModel.php';

class CareerModel extends BaseModel {
    protected $table = 'careers';

    public function __construct() {
        parent::__construct();
    }
}