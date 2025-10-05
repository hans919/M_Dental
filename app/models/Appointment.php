<?php

class Appointment {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all appointments
    public function getAppointments($limit = null) {
        $sql = "SELECT a.*, 
                       CONCAT(u.first_name, ' ', u.last_name) as patient_name,
                       u.email as patient_email,
                       d.first_name as dentist_first_name, 
                       d.last_name as dentist_last_name
                FROM appointments a
                LEFT JOIN users u ON a.patient_user_id = u.id
                JOIN dentists d ON a.dentist_id = d.id
                ORDER BY a.appointment_date DESC, a.appointment_time DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        
        $this->db->query($sql);
        if ($limit) {
            $this->db->bind(':limit', $limit);
        }
        return $this->db->resultSet();
    }
    
    // Get appointment by ID
    public function getAppointmentById($id) {
        $this->db->query("SELECT a.*, 
                         CONCAT(u.first_name, ' ', u.last_name) as patient_name,
                         u.email as patient_email,
                         u.first_name as patient_first_name,
                         u.last_name as patient_last_name,
                         d.first_name as dentist_first_name, 
                         d.last_name as dentist_last_name
                         FROM appointments a
                         LEFT JOIN users u ON a.patient_user_id = u.id
                         JOIN dentists d ON a.dentist_id = d.id
                         WHERE a.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get appointments by patient (for backward compatibility - now uses user_id)
    public function getAppointmentsByPatient($user_id) {
        $this->db->query("SELECT a.*, 
                         d.first_name as dentist_first_name, 
                         d.last_name as dentist_last_name
                         FROM appointments a
                         JOIN dentists d ON a.dentist_id = d.id
                         WHERE a.patient_user_id = :user_id
                         ORDER BY a.appointment_date DESC, a.appointment_time DESC");
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }
    
    // Get today's appointments
    public function getTodayAppointments() {
        $this->db->query("SELECT a.*, 
                         CONCAT(u.first_name, ' ', u.last_name) as patient_name,
                         u.email as patient_email,
                         d.first_name as dentist_first_name, 
                         d.last_name as dentist_last_name
                         FROM appointments a
                         LEFT JOIN users u ON a.patient_user_id = u.id
                         JOIN dentists d ON a.dentist_id = d.id
                         WHERE a.appointment_date = CURDATE()
                         ORDER BY a.appointment_time ASC");
        return $this->db->resultSet();
    }
    
    // Add appointment
    public function addAppointment($data) {
        $this->db->query("INSERT INTO appointments (patient_user_id, dentist_id, appointment_date, appointment_time, duration, reason, status) 
                         VALUES (:patient_user_id, :dentist_id, :appointment_date, :appointment_time, :duration, :reason, :status)");
        
        $this->db->bind(':patient_user_id', $data['patient_user_id']);
        $this->db->bind(':dentist_id', $data['dentist_id']);
        $this->db->bind(':appointment_date', $data['appointment_date']);
        $this->db->bind(':appointment_time', $data['appointment_time']);
        $this->db->bind(':duration', $data['duration']);
        $this->db->bind(':reason', $data['reason']);
        $this->db->bind(':status', $data['status']);
        
        return $this->db->execute();
    }
    
    // Update appointment
    public function updateAppointment($id, $data) {
        $this->db->query("UPDATE appointments SET 
                         patient_user_id = :patient_user_id,
                         dentist_id = :dentist_id,
                         appointment_date = :appointment_date,
                         appointment_time = :appointment_time,
                         duration = :duration,
                         reason = :reason,
                         status = :status,
                         notes = :notes
                         WHERE id = :id");
        
        $this->db->bind(':id', $id);
        $this->db->bind(':patient_user_id', $data['patient_user_id']);
        $this->db->bind(':dentist_id', $data['dentist_id']);
        $this->db->bind(':appointment_date', $data['appointment_date']);
        $this->db->bind(':appointment_time', $data['appointment_time']);
        $this->db->bind(':duration', $data['duration']);
        $this->db->bind(':reason', $data['reason']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':notes', $data['notes']);
        
        return $this->db->execute();
    }
    
    // Delete appointment
    public function deleteAppointment($id) {
        $this->db->query("DELETE FROM appointments WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Get appointment count
    public function getTodayAppointmentCount() {
        $this->db->query("SELECT COUNT(*) as count FROM appointments WHERE appointment_date = CURDATE()");
        $result = $this->db->single();
        return $result->count;
    }
    
    // Create patient appointment (for patient booking)
    public function createPatientAppointment($data) {
        $this->db->query("INSERT INTO appointments (patient_user_id, dentist_id, appointment_date, appointment_time, reason, status) 
                         VALUES (:patient_user_id, :dentist_id, :appointment_date, :appointment_time, :reason, :status)");
        
        $this->db->bind(':patient_user_id', $data['patient_user_id']);
        $this->db->bind(':dentist_id', $data['dentist_id']);
        $this->db->bind(':appointment_date', $data['appointment_date']);
        $this->db->bind(':appointment_time', $data['appointment_time']);
        $this->db->bind(':reason', $data['reason']);
        $this->db->bind(':status', $data['status']);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    // Get appointments by user ID (for patients)
    public function getAppointmentsByUserId($user_id) {
        $this->db->query("SELECT a.*, 
                         d.first_name as dentist_first_name, 
                         d.last_name as dentist_last_name,
                         d.specialization
                         FROM appointments a
                         JOIN dentists d ON a.dentist_id = d.id
                         WHERE a.patient_user_id = :user_id
                         ORDER BY a.appointment_date DESC, a.appointment_time DESC");
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }
    
    // Update appointment status
    public function updateStatus($id, $status, $notes = null) {
        $sql = "UPDATE appointments SET status = :status";
        if ($notes !== null) {
            $sql .= ", notes = :notes";
        }
        $sql .= " WHERE id = :id";
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        if ($notes !== null) {
            $this->db->bind(':notes', $notes);
        }
        
        return $this->db->execute();
    }
    
    // Get pending appointments (for admin)
    public function getPendingAppointments() {
        $this->db->query("SELECT a.*, 
                         u.first_name as patient_first_name, 
                         u.last_name as patient_last_name,
                         u.email as patient_email,
                         d.first_name as dentist_first_name, 
                         d.last_name as dentist_last_name
                         FROM appointments a
                         JOIN users u ON a.patient_user_id = u.id
                         JOIN dentists d ON a.dentist_id = d.id
                         WHERE a.status = 'pending'
                         ORDER BY a.created_at DESC");
        return $this->db->resultSet();
    }
    
    // Get all appointments with user info (for admin)
    public function getAllAppointmentsWithUsers($limit = null) {
        $sql = "SELECT a.*, 
                CONCAT(u.first_name, ' ', u.last_name) as patient_name,
                u.email as patient_email,
                d.first_name as dentist_first_name, 
                d.last_name as dentist_last_name
                FROM appointments a
                LEFT JOIN users u ON a.patient_user_id = u.id
                JOIN dentists d ON a.dentist_id = d.id
                ORDER BY 
                    CASE a.status 
                        WHEN 'pending' THEN 1
                        WHEN 'approved' THEN 2
                        WHEN 'confirmed' THEN 3
                        ELSE 4
                    END,
                    a.appointment_date DESC, 
                    a.appointment_time DESC";
        
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        
        $this->db->query($sql);
        if ($limit) {
            $this->db->bind(':limit', $limit);
        }
        return $this->db->resultSet();
    }
}
