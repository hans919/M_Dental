<?php

class AuthController extends Controller {
    
    public function login() {
        // If already logged in, redirect to home
        if ($this->isLoggedIn()) {
            $this->redirect('home');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            
            $user = $userModel->login($username, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role;
                
                $this->redirect('home');
            } else {
                $data = [
                    'title' => 'Login',
                    'error' => 'Invalid username or password'
                ];
                $this->view('auth/login', $data);
            }
        } else {
            $data = ['title' => 'Login'];
            $this->view('auth/login', $data);
        }
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('auth/login');
    }
}
