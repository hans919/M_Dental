<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Admin Password - Dental Clinic</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #3eb489 0%, #008ba3 100%);
            padding: 2rem;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 { color: #008ba3; margin-bottom: 1.5rem; }
        .status { 
            padding: 1rem; 
            margin: 1rem 0; 
            border-radius: 8px;
            border-left: 4px solid;
        }
        .success { 
            background: #d4edda; 
            color: #155724; 
            border-left-color: #28a745;
        }
        .error { 
            background: #f8d7da; 
            color: #721c24; 
            border-left-color: #dc3545;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border-left-color: #17a2b8;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #3eb489;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 1rem;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
        }
        .btn:hover { background: #2d9470; }
        pre {
            background: #f4f4f4;
            padding: 1rem;
            border-radius: 4px;
            overflow-x: auto;
        }
        code {
            background: #f4f4f4;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Fix Admin Password</h1>
        
        <?php
        require_once '../config/config.php';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fix_password'])) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
                $pdo = new PDO($dsn, DB_USER, DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Generate new password hash
                $password = 'admin123';
                $hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Update the password
                $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE username = 'admin'");
                $stmt->bindParam(':password', $hash);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    echo '<div class="status success">';
                    echo '<strong>✓ Password Updated Successfully!</strong><br><br>';
                    echo 'Username: <code>admin</code><br>';
                    echo 'Password: <code>admin123</code><br><br>';
                    echo '<a href="' . APP_URL . '/public/auth/login" class="btn">Go to Login Page</a>';
                    echo '</div>';
                } else {
                    echo '<div class="status error">';
                    echo '<strong>✗ No user found with username "admin"</strong><br>';
                    echo 'Please make sure you have imported the database.sql file.';
                    echo '</div>';
                }
                
            } catch (PDOException $e) {
                echo '<div class="status error">';
                echo '<strong>✗ Database Error!</strong><br>';
                echo 'Error: ' . htmlspecialchars($e->getMessage());
                echo '</div>';
            }
        } else {
            // Show test and fix button
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
                $pdo = new PDO($dsn, DB_USER, DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Check if admin user exists
                $stmt = $pdo->query("SELECT username, email FROM users WHERE username = 'admin'");
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($admin) {
                    echo '<div class="status info">';
                    echo '<strong>Admin User Found:</strong><br>';
                    echo 'Username: <code>' . htmlspecialchars($admin['username']) . '</code><br>';
                    echo 'Email: <code>' . htmlspecialchars($admin['email']) . '</code>';
                    echo '</div>';
                    
                    // Test current password
                    $stmt = $pdo->query("SELECT password FROM users WHERE username = 'admin'");
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $currentHash = $result['password'];
                    
                    if (password_verify('admin123', $currentHash)) {
                        echo '<div class="status success">';
                        echo '<strong>✓ Password is already correct!</strong><br>';
                        echo 'You can login with: <code>admin</code> / <code>admin123</code><br><br>';
                        echo '<a href="' . APP_URL . '/public/auth/login" class="btn">Go to Login Page</a>';
                        echo '</div>';
                    } else {
                        echo '<div class="status error">';
                        echo '<strong>✗ Password verification failed!</strong><br>';
                        echo 'The current password hash does not match "admin123".<br><br>';
                        echo 'Click the button below to fix it:';
                        echo '</div>';
                        
                        echo '<form method="POST">';
                        echo '<button type="submit" name="fix_password" class="btn">Fix Password Now</button>';
                        echo '</form>';
                    }
                } else {
                    echo '<div class="status error">';
                    echo '<strong>✗ Admin user not found!</strong><br>';
                    echo 'Please import the database.sql file first.<br><br>';
                    echo '1. Go to <a href="http://localhost/phpmyadmin" target="_blank">phpMyAdmin</a><br>';
                    echo '2. Select "dental_clinic" database<br>';
                    echo '3. Click Import and select: <code>c:\\xampp\\htdocs\\dl\\database.sql</code>';
                    echo '</div>';
                }
                
            } catch (PDOException $e) {
                echo '<div class="status error">';
                echo '<strong>✗ Database Connection Failed!</strong><br>';
                echo 'Error: ' . htmlspecialchars($e->getMessage()) . '<br><br>';
                echo 'Make sure:<br>';
                echo '1. XAMPP MySQL is running<br>';
                echo '2. Database "dental_clinic" exists<br>';
                echo '3. Database credentials in config/config.php are correct';
                echo '</div>';
            }
        }
        ?>
        
        <hr style="margin: 2rem 0;">
        
        <h3>Alternative: Manual SQL Fix</h3>
        <p>If the button doesn't work, run this SQL in phpMyAdmin:</p>
        <pre>UPDATE users SET password = '$2y$10$rGHQyLPZOyOmXEqb2j3LheJlOmBhkIBqKvFxPCLKLw6WQxvZKlQci' WHERE username = 'admin';</pre>
        
        <p style="margin-top: 1rem;">
            <a href="install-check.php" style="color: #008ba3;">← Back to Installation Check</a>
        </p>
    </div>
</body>
</html>
