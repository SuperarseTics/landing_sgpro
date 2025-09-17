<?php
// app/models/InvoiceModel.php
require_once __DIR__ . '/BaseModel.php';

class InvoiceModel extends BaseModel {
    protected $table = 'invoices';

    public function __construct() {
        parent::__construct();
    }
}