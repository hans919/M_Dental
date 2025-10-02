<?php

class DentistController extends Controller {
    
    public function __construct() {
        if (!$this->isLoggedIn()) {
            $this->redirect('auth/login');
        }
    }
    
    public function index() {
        $dentistModel = $this->model('Dentist');
        $dentists = $dentistModel->getDentists();
        
        $data = [
            'title' => 'Dentists',
            'dentists' => $dentists
        ];
        
        $this->view('dentists/index', $data);
    }
    
    public function detail($id) {
        $dentistModel = $this->model('Dentist');
        $dentist = $dentistModel->getDentistById($id);
        
        if (!$dentist) {
            $this->redirect('dentist');
        }
        
        $data = [
            'title' => 'Dentist Profile',
            'dentist' => $dentist
        ];
        
        $this->view('dentists/view', $data);
    }
}
