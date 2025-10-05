<?php

class HomeController extends Controller {
    
    public function __construct() {
        // RBAC: Require staff role (admin, dentist, receptionist)
        $this->requireRole(['admin', 'dentist', 'receptionist']);
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
            'recent_appointments' => $appointmentModel->getAllAppointmentsWithUsers(5),
            'recent_patients' => $patientModel->getPatients(5)
        ];
        
        $this->view('home/index', $data);
    }
}
