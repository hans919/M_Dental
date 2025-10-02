<?php

class HomeController extends Controller {
    
    public function __construct() {
        // Check if user is logged in, if not redirect to login
        if (!$this->isLoggedIn() && $_SERVER['REQUEST_URI'] != '/dl/public/auth/login') {
            $this->redirect('auth/login');
        }
    }
    
    public function index() {
        // Load models
        $patientModel = $this->model('Patient');
        $dentistModel = $this->model('Dentist');
        $appointmentModel = $this->model('Appointment');
        
        // Get dashboard data
        $data = [
            'title' => 'Dashboard',
            'patient_count' => $patientModel->getPatientCount(),
            'dentist_count' => $dentistModel->getDentistCount(),
            'today_appointments' => $appointmentModel->getTodayAppointmentCount(),
            'recent_appointments' => $appointmentModel->getAppointments(5),
            'recent_patients' => $patientModel->getPatients(5)
        ];
        
        $this->view('home/index', $data);
    }
}
