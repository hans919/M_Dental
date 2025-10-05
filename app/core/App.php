<?php

class App {
    protected $controller = 'LandingController';
    protected $method = 'index';
    protected $params = [];
    
    public function __construct() {
        // Start session only if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $url = $this->parseUrl();
        
        // If no URL and user is logged in, redirect to home
        if (empty($url) && isset($_SESSION['user'])) {
            $this->controller = 'HomeController';
        }
        
        // Check for controller (handle underscore to camelCase conversion)
        if (isset($url[0])) {
            // Convert patient_dashboard to PatientDashboard
            $controllerName = str_replace('_', '', ucwords($url[0], '_'));
            if (file_exists('../app/controllers/' . $controllerName . 'Controller.php')) {
                $this->controller = $controllerName . 'Controller';
                unset($url[0]);
            }
        }
        
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        
        // Check for method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        
        // Get params
        $this->params = $url ? array_values($url) : [];
        
        // Call method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    
    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
