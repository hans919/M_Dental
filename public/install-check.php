<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Check - Dental Clinic System</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #3eb489 0%, #008ba3 100%);
            padding: 2rem;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 { color: #008ba3; margin-bottom: 1.5rem; }
        .status { padding: 1rem; margin: 1rem 0; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        .warning { background: #fff3cd; color: #856404; border-left: 4px solid #ffc107; }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #3eb489;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 1rem;
        }
        .btn:hover { background: #2d9470; }
        pre {
            background: #f4f4f4;
            padding: 1rem;
            border-radius: 4px;
            overflow-x: auto;
        }
        .step {
            background: #f8f9fa;
            padding: 1rem;
            margin: 1rem 0;
            border-left: 4px solid #3eb489;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🦷 Dental Clinic System - Installation Check</h1>
        
        <?php
        require_once '../config/config.php';
        
        // Check 1: Database Connection
        echo '<h2>1. Database Connection</h2>';
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $pdo = new PDO($dsn, DB_USER, DB_PASS);
            echo '<div class="status success">✓ Database connection successful!</div>';
            
            // Check 2: Tables exist
            echo '<h2>2. Database Tables</h2>';
            $tables = ['users', 'patients', 'dentists', 'appointments', 'medical_records'];
            $allTablesExist = true;
            
            foreach ($tables as $table) {
                $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
                if ($stmt->rowCount() > 0) {
                    echo '<div class="status success">✓ Table <strong>' . $table . '</strong> exists</div>';
                } else {
                    echo '<div class="status error">✗ Table <strong>' . $table . '</strong> does NOT exist</div>';
                    $allTablesExist = false;
                }
            }
            
            if (!$allTablesExist) {
                echo '<div class="status warning">';
                echo '<strong>⚠ Database not fully set up!</strong><br>';
                echo 'Please import the database.sql file:<br>';
                echo '<div class="step">';
                echo '1. Open phpMyAdmin: <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a><br>';
                echo '2. Create database "dental_clinic" if it doesn\'t exist<br>';
                echo '3. Select the database<br>';
                echo '4. Click "Import" tab<br>';
                echo '5. Choose file: <code>c:\\xampp\\htdocs\\dl\\database.sql</code><br>';
                echo '6. Click "Go" button';
                echo '</div>';
                echo '</div>';
            } else {
                // Check 3: Sample data
                echo '<h2>3. Sample Data</h2>';
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
                $userCount = $stmt->fetch(PDO::FETCH_OBJ)->count;
                
                if ($userCount > 0) {
                    echo '<div class="status success">✓ Found ' . $userCount . ' user(s) in database</div>';
                    
                    $stmt = $pdo->query("SELECT username FROM users WHERE role = 'admin' LIMIT 1");
                    $admin = $stmt->fetch(PDO::FETCH_OBJ);
                    if ($admin) {
                        echo '<div class="status success">';
                        echo '<strong>Default Login Credentials:</strong><br>';
                        echo 'Username: <code>' . $admin->username . '</code><br>';
                        echo 'Password: <code>admin123</code>';
                        echo '</div>';
                    }
                    
                    echo '<h2>✅ System Ready!</h2>';
                    echo '<a href="' . APP_URL . '/public/auth/login" class="btn">Go to Login Page</a>';
                } else {
                    echo '<div class="status warning">⚠ No users found. Please import database.sql</div>';
                }
            }
            
        } catch (PDOException $e) {
            echo '<div class="status error">';
            echo '<strong>✗ Database Connection Failed!</strong><br>';
            echo 'Error: ' . $e->getMessage() . '<br><br>';
            echo '<strong>Common Solutions:</strong><br>';
            echo '<div class="step">';
            echo '1. Make sure XAMPP MySQL is running<br>';
            echo '2. Check database name is "dental_clinic"<br>';
            echo '3. Verify database credentials in config/config.php:<br>';
            echo '<pre>';
            echo 'DB_HOST: ' . DB_HOST . "\n";
            echo 'DB_USER: ' . DB_USER . "\n";
            echo 'DB_NAME: ' . DB_NAME;
            echo '</pre>';
            echo '</div>';
            echo '</div>';
        }
        
        // Check 4: URL Configuration
        echo '<h2>4. URL Configuration</h2>';
        echo '<div class="status success">';
        echo 'App URL: <code>' . APP_URL . '</code><br>';
        echo 'Current URL: <code>' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]</code>';
        echo '</div>';
        
        // Check 5: File Permissions
        echo '<h2>5. File Structure</h2>';
        $requiredDirs = ['app', 'app/controllers', 'app/models', 'app/views', 'config', 'public', 'assets'];
        foreach ($requiredDirs as $dir) {
            $path = '../' . $dir;
            if (is_dir($path)) {
                echo '<div class="status success">✓ Directory <strong>' . $dir . '</strong> exists</div>';
            } else {
                echo '<div class="status error">✗ Directory <strong>' . $dir . '</strong> missing</div>';
            }
        }
        ?>
        
        <hr style="margin: 2rem 0;">
        <p><strong>Need Help?</strong> Check the README.md file for complete installation instructions.</p>
    </div>
</body>
</html>
