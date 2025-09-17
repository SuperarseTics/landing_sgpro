<?php
// app/models/ContinuityModel.php
require_once __DIR__ . '/BaseModel.php';

class ContinuityModel extends BaseModel {
    protected $table = 'continuity';

    public function __construct() {
        parent::__construct();
    }
}