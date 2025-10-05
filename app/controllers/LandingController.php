<?php

class LandingController extends Controller {
    
    public function index() {
        // Check if user is logged in
        if (isset($_SESSION['user'])) {
            header('Location: ' . APP_URL . '/public/home');
            exit();
        }
        
        $this->view('landing/index');
    }
    
}
