<?php

class Patient {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all patients
    public function getPatients($limit = null, $offset = 0) {
        $sql = "SELECT * FROM patients ORDER BY created_at DESC";
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        $this->db->query($sql);
        if ($limit) {
            $this->db->bind(':limit', $limit);
            $this->db->bind(':offset', $offset);
        }
        return $this->db->resultSet();
    }
    
    // Get patient by ID
    public function getPatientById($id) {
        $this->db->query("SELECT * FROM patients WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Search patients
    public function searchPatients($search) {
        $this->db->query("SELECT * FROM patients 
                         WHERE patient_code LIKE :search 
                         OR first_name LIKE :search 
                         OR last_name LIKE :search 
                         OR phone LIKE :search 
                         OR email LIKE :search
                         ORDER BY created_at DESC");
        $this->db->bind(':search', '%' . $search . '%');
        return $this->db->resultSet();
    }
    
    // Add patient
    public function addPatient($data) {
        $this->db->query("INSERT INTO patients (patient_code, first_name, last_name, date_of_birth, gender, phone, email, address, emergency_contact_name, emergency_contact_phone, blood_type, allergies, medical_conditions) 
                         VALUES (:patient_code, :first_name, :last_name, :date_of_birth, :gender, :phone, :email, :address, :emergency_contact_name, :emergency_contact_phone, :blood_type, :allergies, :medical_conditions)");
        
        $this->db->bind(':patient_code', $data['patient_code']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':date_of_birth', $data['date_of_birth']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':emergency_contact_name', $data['emergency_contact_name']);
        $this->db->bind(':emergency_contact_phone', $data['emergency_contact_phone']);
        $this->db->bind(':blood_type', $data['blood_type']);
        $this->db->bind(':allergies', $data['allergies']);
        $this->db->bind(':medical_conditions', $data['medical_conditions']);
        
        return $this->db->execute();
    }
    
    // Update patient
    public function updatePatient($id, $data) {
        $this->db->query("UPDATE patients SET 
                         first_name = :first_name,
                         last_name = :last_name,
                         date_of_birth = :date_of_birth,
                         gender = :gender,
                         phone = :phone,
                         email = :email,
                         address = :address,
                         emergency_contact_name = :emergency_contact_name,
                         emergency_contact_phone = :emergency_contact_phone,
                         blood_type = :blood_type,
                         allergies = :allergies,
                         medical_conditions = :medical_conditions,
                         status = :status
                         WHERE id = :id");
        
        $this->db->bind(':id', $id);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':date_of_birth', $data['date_of_birth']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':emergency_contact_name', $data['emergency_contact_name']);
        $this->db->bind(':emergency_contact_phone', $data['emergency_contact_phone']);
        $this->db->bind(':blood_type', $data['blood_type']);
        $this->db->bind(':allergies', $data['allergies']);
        $this->db->bind(':medical_conditions', $data['medical_conditions']);
        $this->db->bind(':status', $data['status']);
        
        return $this->db->execute();
    }
    
    // Delete patient
    public function deletePatient($id) {
        $this->db->query("DELETE FROM patients WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Generate patient code
    public function generatePatientCode() {
        $this->db->query("SELECT patient_code FROM patients ORDER BY id DESC LIMIT 1");
        $result = $this->db->single();
        
        if ($result) {
            $lastCode = $result->patient_code;
            $number = intval(substr($lastCode, -3)) + 1;
        } else {
            $number = 1;
        }
        
        return 'PAT-' . date('Y') . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
    
    // Get patient count
    public function getPatientCount() {
        $this->db->query("SELECT COUNT(*) as count FROM patients WHERE status = 'active'");
        $result = $this->db->single();
        return $result->count;
    }
}
