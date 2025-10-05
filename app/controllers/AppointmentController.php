<?php

class AppointmentController extends Controller {
    
    public function __construct() {
        // RBAC: Require staff role (admin, dentist, receptionist)
        $this->requireRole(['admin', 'dentist', 'receptionist']);
    }
    
    public function index() {
        $appointmentModel = $this->model('Appointment');
        $appointments = $appointmentModel->getAppointments();
        
        $data = [
            'title' => 'Appointments',
            'appointments' => $appointments
        ];
        
        $this->view('appointments/index', $data);
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $appointmentModel = $this->model('Appointment');
            
            $data = [
                'patient_id' => $_POST['patient_id'],
                'dentist_id' => $_POST['dentist_id'],
                'appointment_date' => $_POST['appointment_date'],
                'appointment_time' => $_POST['appointment_time'],
                'duration' => $_POST['duration'],
                'reason' => trim($_POST['reason']),
                'status' => 'scheduled'
            ];
            
            if ($appointmentModel->addAppointment($data)) {
                $_SESSION['message'] = 'Appointment added successfully';
                $this->redirect('appointment');
            } else {
                $_SESSION['error'] = 'Something went wrong';
            }
        }
        
        $patientModel = $this->model('Patient');
        $dentistModel = $this->model('Dentist');
        
        $data = [
            'title' => 'Add Appointment',
            'patients' => $patientModel->getPatients(),
            'dentists' => $dentistModel->getDentists()
        ];
        
        $this->view('appointments/add', $data);
    }
    
    public function updateStatus() {
        // Only allow POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }
        
        $appointmentModel = $this->model('Appointment');
        
        $appointment_id = $_POST['appointment_id'] ?? null;
        $status = $_POST['status'] ?? null;
        
        // Validate input
        if (!$appointment_id || !$status) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
            exit;
        }
        
        // Validate status value
        $validStatuses = ['pending', 'approved', 'confirmed', 'rescheduled', 'declined', 
                         'cancelled_by_patient', 'cancelled_by_clinic', 'completed', 'no-show'];
        
        if (!in_array($status, $validStatuses)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid status value']);
            exit;
        }
        
        // Update the appointment status
        $notes = "Status updated to {$status} by " . ($_SESSION['username'] ?? 'admin');
        $result = $appointmentModel->updateStatus($appointment_id, $status, $notes);
        
        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Appointment status updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update appointment status']);
        }
        exit;
    }
}
