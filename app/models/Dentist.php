<?php

class Dentist {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all dentists
    public function getDentists() {
        $this->db->query("SELECT * FROM dentists WHERE status = 'active' ORDER BY first_name ASC");
        return $this->db->resultSet();
    }
    
    // Get dentist by ID
    public function getDentistById($id) {
        $this->db->query("SELECT * FROM dentists WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Add dentist
    public function addDentist($data) {
        $this->db->query("INSERT INTO dentists (user_id, first_name, last_name, specialization, license_number, phone, email, address, date_of_birth, gender) 
                         VALUES (:user_id, :first_name, :last_name, :specialization, :license_number, :phone, :email, :address, :date_of_birth, :gender)");
        
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':specialization', $data['specialization']);
        $this->db->bind(':license_number', $data['license_number']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':date_of_birth', $data['date_of_birth']);
        $this->db->bind(':gender', $data['gender']);
        
        return $this->db->execute();
    }
    
    // Update dentist
    public function updateDentist($id, $data) {
        $this->db->query("UPDATE dentists SET 
                         first_name = :first_name,
                         last_name = :last_name,
                         specialization = :specialization,
                         license_number = :license_number,
                         phone = :phone,
                         email = :email,
                         address = :address,
                         date_of_birth = :date_of_birth,
                         gender = :gender,
                         status = :status
                         WHERE id = :id");
        
        $this->db->bind(':id', $id);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':specialization', $data['specialization']);
        $this->db->bind(':license_number', $data['license_number']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':date_of_birth', $data['date_of_birth']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':status', $data['status']);
        
        return $this->db->execute();
    }
    
    // Delete dentist
    public function deleteDentist($id) {
        $this->db->query("UPDATE dentists SET status = 'inactive' WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get dentist count
    public function getDentistCount() {
        $this->db->query("SELECT COUNT(*) as count FROM dentists WHERE status = 'active'");
        $result = $this->db->single();
        return $result->count;
    }
}
