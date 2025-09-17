<?php
// app/models/ContractModel.php
require_once __DIR__ . '/BaseModel.php';

class ContractModel extends BaseModel {
    protected $table = 'contracts';

    public function __construct() {
        parent::__construct();
    }
}