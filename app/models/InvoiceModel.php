<?php
// app/models/InvoiceModel.php

require_once __DIR__ . '/BaseModel.php';

class InvoiceModel extends BaseModel {
    protected $table = "invoices";

    public function __construct() {
        parent::__construct();
    }
    
    public function create($professorId, $paoId, $amount, $status, $paymentProofPath = null) {
        $query = "INSERT INTO " . $this->table . " (professor_id, pao_id, invoice_date, amount, status, payment_proof_path) VALUES (?, ?, CURDATE(), ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $professorId);
        $stmt->bindParam(2, $paoId);
        $stmt->bindParam(3, $amount);
        $stmt->bindParam(4, $status);
        $stmt->bindParam(5, $paymentProofPath);
        return $stmt->execute();
    }
    
    public function update($id, $amount, $status, $paymentProofPath = null) {
        $query = "UPDATE " . $this->table . " SET amount = ?, status = ?, payment_proof_path = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $amount);
        $stmt->bindParam(2, $status);
        $stmt->bindParam(3, $paymentProofPath);
        $stmt->bindParam(4, $id);
        return $stmt->execute();
    }

    public function getInvoicesWithDetails() {
        $query = "SELECT 
                    i.id,
                    i.invoice_date,
                    i.amount,
                    i.status,
                    i.payment_proof_path,
                    u.name AS professor_name,
                    pao.name AS pao_name
                  FROM invoices i
                  JOIN users u ON i.professor_id = u.id
                  JOIN pao ON i.pao_id = pao.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}