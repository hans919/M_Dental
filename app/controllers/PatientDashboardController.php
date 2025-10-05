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
        $userModel = $this->model('User');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle profile update
            $errors = [];
            
            // Get form data
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone'] ?? '');
            $current_password = trim($_POST['current_password'] ?? '');
            $new_password = trim($_POST['new_password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');
            
            // Validate basic info
            if (empty($first_name)) {
                $errors[] = 'First name is required';
            }
            if (empty($last_name)) {
                $errors[] = 'Last name is required';
            }
            if (empty($email)) {
                $errors[] = 'Email is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            } else {
                // Check if email already exists for another user
                if ($userModel->emailExistsExcludingUser($email, $_SESSION['user_id'])) {
                    $errors[] = 'Email is already taken by another user';
                }
            }
            
            // Validate password change if provided
            if (!empty($current_password) || !empty($new_password) || !empty($confirm_password)) {
                if (empty($current_password)) {
                    $errors[] = 'Please enter your current password to change your password';
                } elseif (!$userModel->verifyPassword($_SESSION['user_id'], $current_password)) {
                    $errors[] = 'Current password is incorrect';
                }
                
                if (empty($new_password)) {
                    $errors[] = 'Please enter a new password';
                } elseif (strlen($new_password) < 6) {
                    $errors[] = 'New password must be at least 6 characters';
                }
                
                if ($new_password !== $confirm_password) {
                    $errors[] = 'New passwords do not match';
                }
            }
            
            // Update profile if no errors
            if (empty($errors)) {
                $profileData = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'phone' => $phone
                ];
                
                if ($userModel->updateProfile($_SESSION['user_id'], $profileData)) {
                    // Update session variables
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['last_name'] = $last_name;
                    $_SESSION['email'] = $email;
                    
                    // Update password if provided
                    if (!empty($new_password)) {
                        $userModel->updatePassword($_SESSION['user_id'], $new_password);
                        $_SESSION['success'] = 'Profile and password updated successfully!';
                    } else {
                        $_SESSION['success'] = 'Profile updated successfully!';
                    }
                    
                    $this->redirect('patient_dashboard/profile');
                } else {
                    $errors[] = 'Failed to update profile. Please try again.';
                }
            }
            
            // If there are errors, show form with errors
            $user = $userModel->getUserProfile($_SESSION['user_id']);
            $data = [
                'title' => 'My Profile',
                'user' => [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'username' => $user->username,
                    'email' => $email,
                    'phone' => $phone
                ],
                'errors' => $errors
            ];
            
            $this->view('patient_dashboard/profile', $data);
        } else {
            // Load profile data
            $user = $userModel->getUserProfile($_SESSION['user_id']);
            
            $data = [
                'title' => 'My Profile',
                'user' => [
                    'first_name' => $user->first_name ?? '',
                    'last_name' => $user->last_name ?? '',
                    'username' => $user->username ?? '',
                    'email' => $user->email ?? '',
                    'phone' => $user->phone ?? ''
                ]
            ];
            
            $this->view('patient_dashboard/profile', $data);
        }
    }
    
    // View medical records
    public function records() {
        // TODO: Connect to actual medical records database tables
        // For now, showing structure with placeholder data
        
        $data = [
            'title' => 'Medical Records',
            'total_visits' => 0,
            'total_treatments' => 0,
            'total_prescriptions' => 0,
            'last_visit' => null,
            'treatments' => [],
            'prescriptions' => [],
            'notes' => []
        ];
        
        // TODO: Replace with actual database queries
        // Example queries to implement:
        // $appointmentModel = $this->model('Appointment');
        // $data['total_visits'] = $appointmentModel->countCompletedAppointments($_SESSION['user_id']);
        // $data['treatments'] = $treatmentModel->getTreatmentsByUserId($_SESSION['user_id']);
        // $data['prescriptions'] = $prescriptionModel->getPrescriptionsByUserId($_SESSION['user_id']);
        
        $this->view('patient_dashboard/records', $data);
    }
}
