<?php

class Patient {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all patients (from patients table + users with patient role)
    public function getPatients($limit = null, $offset = 0) {
        $sql = "SELECT 
                    p.id,
                    p.patient_code,
                    p.first_name,
                    p.last_name,
                    p.date_of_birth,
                    p.gender,
                    p.phone,
                    p.email,
                    p.address,
                    p.status,
                    p.created_at,
                    'patient_table' as source
                FROM patients p
                WHERE p.status = 'active'
                
                UNION ALL
                
                SELECT 
                    u.id,
                    CONCAT('USR-', u.id) as patient_code,
                    u.first_name,
                    u.last_name,
                    NULL as date_of_birth,
                    NULL as gender,
                    u.phone,
                    u.email,
                    NULL as address,
                    'active' as status,
                    u.created_at,
                    'user_table' as source
                FROM users u
                WHERE u.role = 'patient'
                AND u.id NOT IN (
                    SELECT user_id FROM patients WHERE user_id IS NOT NULL
                )
                
                ORDER BY created_at DESC";
                
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
    
    // Get patient by ID (check both patients table and users table)
    public function getPatientById($id, $source = null) {
        // If source is specified, query that specific table
        if ($source === 'user_table') {
            $this->db->query("SELECT 
                                u.id,
                                CONCAT('USR-', u.id) as patient_code,
                                u.first_name,
                                u.last_name,
                                NULL as date_of_birth,
                                NULL as gender,
                                u.phone,
                                u.email,
                                NULL as address,
                                NULL as emergency_contact_name,
                                NULL as emergency_contact_phone,
                                NULL as blood_type,
                                NULL as allergies,
                                NULL as medical_conditions,
                                NULL as profile_photo,
                                'active' as status,
                                u.created_at,
                                u.updated_at,
                                'user_table' as source
                            FROM users u
                            WHERE u.id = :id AND u.role = 'patient'");
            $this->db->bind(':id', $id);
            return $this->db->single();
        }
        
        // Otherwise, check patients table first
        $this->db->query("SELECT *, 'patient_table' as source FROM patients WHERE id = :id");
        $this->db->bind(':id', $id);
        $patient = $this->db->single();
        
        // If not found in patients table, check if it's a user
        if (!$patient) {
            $this->db->query("SELECT 
                                u.id,
                                CONCAT('USR-', u.id) as patient_code,
                                u.first_name,
                                u.last_name,
                                NULL as date_of_birth,
                                NULL as gender,
                                u.phone,
                                u.email,
                                NULL as address,
                                NULL as emergency_contact_name,
                                NULL as emergency_contact_phone,
                                NULL as blood_type,
                                NULL as allergies,
                                NULL as medical_conditions,
                                NULL as profile_photo,
                                'active' as status,
                                u.created_at,
                                u.updated_at,
                                'user_table' as source
                            FROM users u
                            WHERE u.id = :id AND u.role = 'patient'");
            $this->db->bind(':id', $id);
            $patient = $this->db->single();
        }
        
        return $patient;
    }
    
    // Search patients (from both tables)
    public function searchPatients($search) {
        $sql = "SELECT 
                    p.id,
                    p.patient_code,
                    p.first_name,
                    p.last_name,
                    p.date_of_birth,
                    p.gender,
                    p.phone,
                    p.email,
                    p.address,
                    p.status,
                    p.created_at,
                    'patient_table' as source
                FROM patients p
                WHERE (p.patient_code LIKE :search 
                    OR p.first_name LIKE :search 
                    OR p.last_name LIKE :search 
                    OR p.phone LIKE :search 
                    OR p.email LIKE :search)
                AND p.status = 'active'
                
                UNION ALL
                
                SELECT 
                    u.id,
                    CONCAT('USR-', u.id) as patient_code,
                    u.first_name,
                    u.last_name,
                    NULL as date_of_birth,
                    NULL as gender,
                    u.phone,
                    u.email,
                    NULL as address,
                    'active' as status,
                    u.created_at,
                    'user_table' as source
                FROM users u
                WHERE u.role = 'patient'
                AND (u.username LIKE :search
                    OR u.first_name LIKE :search 
                    OR u.last_name LIKE :search 
                    OR u.phone LIKE :search 
                    OR u.email LIKE :search)
                AND u.id NOT IN (
                    SELECT user_id FROM patients WHERE user_id IS NOT NULL
                )
                
                ORDER BY created_at DESC";
                
        $this->db->query($sql);
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
    
    // Get patient count (from both tables)
    public function getPatientCount() {
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM patients WHERE status = 'active') +
                    (SELECT COUNT(*) FROM users WHERE role = 'patient' 
                     AND id NOT IN (SELECT user_id FROM patients WHERE user_id IS NOT NULL))
                as count";
        
        $this->db->query($sql);
        $result = $this->db->single();
        return $result->count;
    }
}
