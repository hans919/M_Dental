<?php
// Quick password hash generator for admin123
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: $password<br>";
echo "Hash: $hash<br><br>";

// Test verification
if (password_verify('admin123', $hash)) {
    echo "✓ Verification works!<br>";
}

// Test against database hash
$dbHash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
if (password_verify('admin123', $dbHash)) {
    echo "✓ Database hash verification works!";
} else {
    echo "✗ Database hash verification FAILED!<br>";
    echo "Use this new SQL to update:<br><br>";
    echo "<pre>UPDATE users SET password = '$hash' WHERE username = 'admin';</pre>";
}
?>
