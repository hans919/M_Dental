<?php

class PatientDashboardController extends Controller {
    
    public function __construct() {
        // RBAC: Require patient role
        $this->requireRole('patient');
    }
    
    // Patient Dashboard
    public function index() {
        $appointmentModel = $this->model('Appointment');
        
        // Get user's appointments
        $appointments = $appointmentModel->getAppointmentsByUserId($_SESSION['user_id']);
        
        // Count stats
        $pending_count = 0;
        $completed_count = 0;
        foreach ($appointments as $apt) {
            if ($apt->status === 'pending' || $apt->status === 'approved') {
                $pending_count++;
            } elseif ($apt->status === 'completed') {
                $completed_count++;
            }
        }
        
        $data = [
            'title' => 'Patient Dashboard',
            'user' => [
                'first_name' => $_SESSION['first_name'] ?? 'Patient',
                'last_name' => $_SESSION['last_name'] ?? '',
                'username' => $_SESSION['username'] ?? '',
                'email' => $_SESSION['email'] ?? ''
            ],
            'appointments' => $appointments,
            'pending_count' => $pending_count,
            'completed_count' => $completed_count
        ];
        
        $this->view('patient_dashboard/index', $data);
    }
    
    // View appointments
    public function appointments() {
        $appointmentModel = $this->model('Appointment');
        
        $data = [
            'title' => 'My Appointments',
            'appointments' => $appointmentModel->getAppointmentsByUserId($_SESSION['user_id'])
        ];
        
        $this->view('patient_dashboard/appointments', $data);
    }
    
    // Book new appointment
    public function book() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointmentModel = $this->model('Appointment');
            
            // Validate input
            $dentist_id = trim($_POST['dentist_id']);
            $appointment_date = trim($_POST['appointment_date']);
            $appointment_time = trim($_POST['appointment_time']);
            $reason = trim($_POST['reason']);
            
            $errors = [];
            
            // Validation
            if (empty($dentist_id)) {
                $errors[] = 'Please select a dentist';
            }
            if (empty($appointment_date)) {
                $errors[] = 'Please select an appointment date';
            } elseif (strtotime($appointment_date) < strtotime(date('Y-m-d'))) {
                $errors[] = 'Appointment date cannot be in the past';
            }
            if (empty($appointment_time)) {
                $errors[] = 'Please select an appointment time';
            }
            if (empty($reason)) {
                $errors[] = 'Please provide a reason for your visit';
            }
            
            if (empty($errors)) {
                // Create appointment with pending status
                $appointmentId = $appointmentModel->createPatientAppointment([
                    'patient_user_id' => $_SESSION['user_id'],
                    'dentist_id' => $dentist_id,
                    'appointment_date' => $appointment_date,
                    'appointment_time' => $appointment_time,
                    'reason' => $reason,
                    'status' => 'pending'
                ]);
                
                if ($appointmentId) {
                    $_SESSION['success'] = 'Appointment request submitted successfully! Please wait for confirmation from the clinic.';
                    $this->redirect('landing');
                } else {
                    $errors[] = 'Failed to submit appointment request. Please try again.';
                }
            }
            
            // If errors, reload form with data
            $dentistModel = $this->model('Dentist');
            $data = [
                'title' => 'Book Appointment',
                'dentists' => $dentistModel->getDentists(),
                'errors' => $errors,
                'dentist_id' => $dentist_id,
                'appointment_date' => $appointment_date,
                'appointment_time' => $appointment_time,
                'reason' => $reason
            ];
            $this->view('patient_dashboard/book', $data);
        } else {
            // Load dentists for selection
            $dentistModel = $this->model('Dentist');
            $data = [
                'title' => 'Book Appointment',
                'dentists' => $dentistModel->getDentists()
            ];
            $this->view('patient_dashboard/book', $data);
        }
    }
    
    // View profile
    public function profile() {
        $data = [
            'title' => 'My Profile',
            'user' => [
                'first_name' => $_SESSION['first_name'] ?? '',
                'last_name' => $_SESSION['last_name'] ?? '',
                'username' => $_SESSION['username'] ?? '',
                'email' => $_SESSION['email'] ?? ''
            ]
        ];
        
        $this->view('patient_dashboard/profile', $data);
    }
    
    // View medical records
    public function records() {
        $data = [
            'title' => 'Medical Records'
        ];
        
        // TODO: Fetch patient's medical records
        
        $this->view('patient_dashboard/records', $data);
    }
}
