<?php
// app/models/PortfolioModel.php
require_once __DIR__ . '/BaseModel.php';

class PortfolioModel extends BaseModel {
    protected $table = 'portfolios';

    public function __construct() {
        parent::__construct();
    }
}