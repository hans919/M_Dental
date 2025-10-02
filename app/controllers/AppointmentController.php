<?php

class AppointmentController extends Controller {
    
    public function __construct() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
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
}
