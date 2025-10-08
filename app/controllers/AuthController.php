<?php

class AuthController extends Controller {
    
    public function index() {
        // Default to login page
        $this->login();
    }
    
    public function login() {
        // If already logged in, redirect based on role
        if ($this->isLoggedIn()) {
            if ($_SESSION['role'] === 'patient') {
                $this->redirect('landing');
            } else {
                $this->redirect('home');
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            
            $user = $userModel->login($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role;
                $_SESSION['email'] = $user->email;
                $_SESSION['first_name'] = $user->first_name ?? '';
                $_SESSION['last_name'] = $user->last_name ?? '';
                
                // Redirect based on role
                if ($user->role === 'patient') {
                    $this->redirect('landing');
                } else {
                    $this->redirect('home');
                }
            } else {
                $data = [
                    'title' => 'Login',
                    'error' => 'Invalid email or password'
                ];
                $this->view('auth/login', $data);
            }
        } else {
            $data = ['title' => 'Login'];
            $this->view('auth/login', $data);
        }
    }
    
    public function register() {
        // If already logged in, redirect based on role
        if ($this->isLoggedIn()) {
            if ($_SESSION['role'] === 'patient') {
                $this->redirect('landing');
            } else {
                $this->redirect('home');
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            
            // Validate input
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            
            $errors = [];
            
            // Validation
            if (empty($username)) {
                $errors[] = 'Username is required';
            }
            if (empty($email)) {
                $errors[] = 'Email is required';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            }
            if (empty($password)) {
                $errors[] = 'Password is required';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }
            if ($password !== $confirm_password) {
                $errors[] = 'Passwords do not match';
            }
            if (empty($first_name)) {
                $errors[] = 'First name is required';
            }
            if (empty($last_name)) {
                $errors[] = 'Last name is required';
            }
            
            // Check if username already exists
            if (empty($errors)) {
                $existingUser = $userModel->findByUsername($username);
                if ($existingUser) {
                    $errors[] = 'Username already exists';
                }
            }
            
            if (empty($errors)) {
                // Create user with patient role
                $userId = $userModel->create([
                    'username' => $username,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'role' => 'patient' // Default role for registration
                ]);
                
                if ($userId) {
                    // Auto login after registration
                    $user = $userModel->findByUsername($username);
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['username'] = $user->username;
                    $_SESSION['role'] = $user->role;
                    $_SESSION['email'] = $user->email;
                    $_SESSION['first_name'] = $user->first_name;
                    $_SESSION['last_name'] = $user->last_name;
                    
                    // Redirect to landing page
                    $this->redirect('landing');
                } else {
                    $errors[] = 'Registration failed. Please try again.';
                }
            }
            
            $data = [
                'title' => 'Register',
                'errors' => $errors,
                'username' => $username,
                'email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name
            ];
            $this->view('auth/register', $data);
        } else {
            $data = ['title' => 'Register'];
            $this->view('auth/register', $data);
        }
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('landing');
    }
}
