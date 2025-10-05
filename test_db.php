<?php
// Simple database test
try {
    $conn = new PDO('mysql:host=localhost;dbname=dental_clinic', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Database Connection Test</h2>";
    echo "<p style='color: green;'>✓ Connected successfully</p>";
    
    // Check appointments table structure
    $stmt = $conn->query("DESCRIBE appointments");
    echo "<h3>Appointments Table Structure:</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "<td>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check foreign keys
    $stmt = $conn->query("SELECT 
        CONSTRAINT_NAME, 
        COLUMN_NAME, 
        REFERENCED_TABLE_NAME, 
        REFERENCED_COLUMN_NAME 
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_SCHEMA = 'dental_clinic' 
        AND TABLE_NAME = 'appointments' 
        AND REFERENCED_TABLE_NAME IS NOT NULL");
    
    echo "<h3>Foreign Key Constraints:</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Constraint</th><th>Column</th><th>References Table</th><th>References Column</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['CONSTRAINT_NAME']}</td>";
        echo "<td>{$row['COLUMN_NAME']}</td>";
        echo "<td>{$row['REFERENCED_TABLE_NAME']}</td>";
        echo "<td>{$row['REFERENCED_COLUMN_NAME']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Test insert (without session)
    echo "<h3>Test Query Preparation:</h3>";
    $testQuery = "INSERT INTO appointments (patient_user_id, dentist_id, appointment_date, appointment_time, reason, status) 
                  VALUES (:patient_user_id, :dentist_id, :appointment_date, :appointment_time, :reason, :status)";
    echo "<pre>" . htmlspecialchars($testQuery) . "</pre>";
    
    $stmt = $conn->prepare($testQuery);
    echo "<p style='color: green;'>✓ Query prepared successfully</p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}
?>
