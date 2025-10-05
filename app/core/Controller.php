<?php

class Controller {
    // Load model
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }
    
    // Load view
    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }
    
    // Redirect helper
    public function redirect($url) {
        header('Location: ' . APP_URL . '/' . $url);
        exit();
    }
    
    // Check if user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Get current user
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'role' => $_SESSION['role']
            ];
        }
        return null;
    }
    
    // RBAC: Check if user has specific role
    public function hasRole($role) {
        if (!$this->isLoggedIn()) {
            return false;
        }
        
        if (is_array($role)) {
            return in_array($_SESSION['role'], $role);
        }
        
        return $_SESSION['role'] === $role;
    }
    
    // RBAC: Require authentication
    public function requireAuth() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
    }
    
    // RBAC: Require specific role(s)
    public function requireRole($role) {
        $this->requireAuth();
        
        if (!$this->hasRole($role)) {
            // Redirect based on actual role
            if ($_SESSION['role'] === 'patient') {
                $this->redirect('patient_dashboard');
            } else {
                $this->redirect('home');
            }
        }
    }
    
    // RBAC: Check if user is admin
    public function isAdmin() {
        return $this->hasRole('admin');
    }
    
    // RBAC: Check if user is patient
    public function isPatient() {
        return $this->hasRole('patient');
    }
    
    // RBAC: Check if user is staff (admin, dentist, receptionist)
    public function isStaff() {
        return $this->hasRole(['admin', 'dentist', 'receptionist']);
    }
}
