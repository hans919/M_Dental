<?php

class Appointment {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Get all appointments
    public function getAppointments($limit = null) {
        $sql = "SELECT a.*, 
                       p.first_name as patient_first_name, 
                       p.last_name as patient_last_name,
                       p.patient_code,
                       d.first_name as dentist_first_name, 
                       d.last_name as dentist_last_name
                FROM appointments a
                JOIN patients p ON a.patient_id = p.id
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
                         p.first_name as patient_first_name, 
                         p.last_name as patient_last_name,
                         p.patient_code,
                         d.first_name as dentist_first_name, 
                         d.last_name as dentist_last_name
                         FROM appointments a
                         JOIN patients p ON a.patient_id = p.id
                         JOIN dentists d ON a.dentist_id = d.id
                         WHERE a.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get appointments by patient
    public function getAppointmentsByPatient($patient_id) {
        $this->db->query("SELECT a.*, 
                         d.first_name as dentist_first_name, 
                         d.last_name as dentist_last_name
                         FROM appointments a
                         JOIN dentists d ON a.dentist_id = d.id
                         WHERE a.patient_id = :patient_id
                         ORDER BY a.appointment_date DESC, a.appointment_time DESC");
        $this->db->bind(':patient_id', $patient_id);
        return $this->db->resultSet();
    }
    
    // Get today's appointments
    public function getTodayAppointments() {
        $this->db->query("SELECT a.*, 
                         p.first_name as patient_first_name, 
                         p.last_name as patient_last_name,
                         p.patient_code,
                         d.first_name as dentist_first_name, 
                         d.last_name as dentist_last_name
                         FROM appointments a
                         JOIN patients p ON a.patient_id = p.id
                         JOIN dentists d ON a.dentist_id = d.id
                         WHERE a.appointment_date = CURDATE()
                         ORDER BY a.appointment_time ASC");
        return $this->db->resultSet();
    }
    
    // Add appointment
    public function addAppointment($data) {
        $this->db->query("INSERT INTO appointments (patient_id, dentist_id, appointment_date, appointment_time, duration, reason, status) 
                         VALUES (:patient_id, :dentist_id, :appointment_date, :appointment_time, :duration, :reason, :status)");
        
        $this->db->bind(':patient_id', $data['patient_id']);
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
                         patient_id = :patient_id,
                         dentist_id = :dentist_id,
                         appointment_date = :appointment_date,
                         appointment_time = :appointment_time,
                         duration = :duration,
                         reason = :reason,
                         status = :status,
                         notes = :notes
                         WHERE id = :id");
        
        $this->db->bind(':id', $id);
        $this->db->bind(':patient_id', $data['patient_id']);
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
}
