<?php

class PatientController extends Controller {
    
    public function __construct() {
        // RBAC: Require staff role (admin, dentist, receptionist)
        $this->requireRole(['admin', 'dentist', 'receptionist']);
    }
    
    public function index() {
        $patientModel = $this->model('Patient');
        
        // Handle search
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        
        if ($search) {
            $patients = $patientModel->searchPatients($search);
        } else {
            $patients = $patientModel->getPatients();
        }
        
        $data = [
            'title' => 'Patients',
            'patients' => $patients,
            'search' => $search
        ];
        
        $this->view('patients/index', $data);
    }
    
    public function detail($id) {
        $patientModel = $this->model('Patient');
        $appointmentModel = $this->model('Appointment');
        
        $patient = $patientModel->getPatientById($id);
        
        if (!$patient) {
            $this->redirect('patient');
        }
        
        $appointments = $appointmentModel->getAppointmentsByPatient($id);
        
        $data = [
            'title' => 'Patient Profile',
            'patient' => $patient,
            'appointments' => $appointments
        ];
        
        $this->view('patients/view', $data);
    }
    
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $patientModel = $this->model('Patient');
            
            $data = [
                'patient_code' => $patientModel->generatePatientCode(),
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'date_of_birth' => $_POST['date_of_birth'],
                'gender' => $_POST['gender'],
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'address' => trim($_POST['address']),
                'emergency_contact_name' => trim($_POST['emergency_contact_name']),
                'emergency_contact_phone' => trim($_POST['emergency_contact_phone']),
                'blood_type' => trim($_POST['blood_type']),
                'allergies' => trim($_POST['allergies']),
                'medical_conditions' => trim($_POST['medical_conditions'])
            ];
            
            if ($patientModel->addPatient($data)) {
                $_SESSION['message'] = 'Patient added successfully';
                $this->redirect('patient');
            } else {
                $_SESSION['error'] = 'Something went wrong';
            }
        }
        
        $data = ['title' => 'Add Patient'];
        $this->view('patients/add', $data);
    }
    
    public function edit($id) {
        $patientModel = $this->model('Patient');
        $patient = $patientModel->getPatientById($id);
        
        if (!$patient) {
            $this->redirect('patient');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'date_of_birth' => $_POST['date_of_birth'],
                'gender' => $_POST['gender'],
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'address' => trim($_POST['address']),
                'emergency_contact_name' => trim($_POST['emergency_contact_name']),
                'emergency_contact_phone' => trim($_POST['emergency_contact_phone']),
                'blood_type' => trim($_POST['blood_type']),
                'allergies' => trim($_POST['allergies']),
                'medical_conditions' => trim($_POST['medical_conditions']),
                'status' => $_POST['status']
            ];
            
            if ($patientModel->updatePatient($id, $data)) {
                $_SESSION['message'] = 'Patient updated successfully';
                $this->redirect('patient/detail/' . $id);
            } else {
                $_SESSION['error'] = 'Something went wrong';
            }
        }
        
        $data = [
            'title' => 'Edit Patient',
            'patient' => $patient
        ];
        
        $this->view('patients/edit', $data);
    }
    
    public function delete($id) {
        $patientModel = $this->model('Patient');
        
        if ($patientModel->deletePatient($id)) {
            $_SESSION['message'] = 'Patient deleted successfully';
        } else {
            $_SESSION['error'] = 'Something went wrong';
        }
        
        $this->redirect('patient');
    }
}
