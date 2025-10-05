<?php
// Debug script to test appointment creation
session_start();

// Include necessary files
require_once 'app/core/Database.php';
require_once 'app/models/Appointment.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in first. Go to <a href='/dl/auth/login'>login page</a>");
}

echo "<h2>Testing Appointment Creation</h2>";
echo "<p>User ID from session: " . $_SESSION['user_id'] . "</p>";
echo "<p>User Role: " . ($_SESSION['role'] ?? 'not set') . "</p>";

// Create appointment model
$appointmentModel = new Appointment();

// Test data
$testData = [
    'patient_user_id' => $_SESSION['user_id'],
    'dentist_id' => 1, // Assuming dentist ID 1 exists
    'appointment_date' => date('Y-m-d', strtotime('+1 day')),
    'appointment_time' => '10:00:00',
    'reason' => 'Test appointment - debugging',
    'status' => 'pending'
];

echo "<h3>Test Data:</h3>";
echo "<pre>";
print_r($testData);
echo "</pre>";

try {
    $result = $appointmentModel->createPatientAppointment($testData);
    
    if ($result) {
        echo "<p style='color: green;'>✓ Appointment created successfully! ID: " . $result . "</p>";
        echo "<p><a href='/dl/patient_dashboard/appointments'>View Appointments</a></p>";
    } else {
        echo "<p style='color: red;'>✗ Failed to create appointment (returned false)</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
