<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dental_clinic');

// Application Configuration
define('APP_NAME', 'Dental Clinic System');
define('APP_URL', 'http://localhost/M_Dental');
define('ROOT', dirname(__DIR__));

// Path Configuration
define('ASSETS', APP_URL . '/assets');
define('UPLOADS', ROOT . '/public/uploads');

// Session Configuration
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
