<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - DentalCare</title>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/assets/css/landing.css">
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/assets/css/auth.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="auth-page">
    <div class="auth-container">
        <!-- Left Side - Branding -->
        <div class="auth-branding">
            <div class="auth-overlay"></div>
            <div class="auth-content">
                <div class="brand-logo">
                    <div class="brand-icon">
                        <i data-lucide="heart-pulse"></i>
                    </div>
                    <span class="brand-name">DentalCare</span>
                </div>
                <h1>Join Our Dental Family</h1>
                <p>Create an account to book appointments, manage your dental health records, and connect with our expert team.</p>
                
                <div class="auth-features">
                    <div class="auth-feature">
                        <i data-lucide="calendar-check"></i>
                        <span>Easy Appointment Booking</span>
                    </div>
                    <div class="auth-feature">
                        <i data-lucide="file-text"></i>
                        <span>Digital Health Records</span>
                    </div>
                    <div class="auth-feature">
                        <i data-lucide="bell"></i>
                        <span>Appointment Reminders</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Registration Form -->
        <div class="auth-form-container">
            <div class="auth-form-wrapper">
                <a href="<?php echo APP_URL; ?>/public/landing" class="back-link">
                    <i data-lucide="arrow-left"></i>
                    Back to Home
                </a>
                
                <div class="auth-form-header">
                    <h2>Create Account</h2>
                    <p>Fill in your details to get started</p>
                </div>
                
                <?php if (isset($data['errors']) && !empty($data['errors'])): ?>
                    <div class="alert alert-error">
                        <i data-lucide="alert-circle"></i>
                        <div>
                            <strong>Registration Failed</strong>
                            <ul class="error-list">
                                <?php foreach ($data['errors'] as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?php echo APP_URL; ?>/public/auth/register" class="auth-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name" class="form-label">
                                First Name <span class="required">*</span>
                            </label>
                            <div class="input-with-icon">
                                <i data-lucide="user" class="input-icon"></i>
                                <input 
                                    type="text" 
                                    name="first_name" 
                                    id="first_name" 
                                    class="form-input" 
                                    placeholder="John"
                                    value="<?php echo isset($data['first_name']) ? htmlspecialchars($data['first_name']) : ''; ?>"
                                    required
                                >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name" class="form-label">
                                Last Name <span class="required">*</span>
                            </label>
                            <div class="input-with-icon">
                                <i data-lucide="user" class="input-icon"></i>
                                <input 
                                    type="text" 
                                    name="last_name" 
                                    id="last_name" 
                                    class="form-input" 
                                    placeholder="Doe"
                                    value="<?php echo isset($data['last_name']) ? htmlspecialchars($data['last_name']) : ''; ?>"
                                    required
                                >
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="username" class="form-label">
                            Username <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i data-lucide="at-sign" class="input-icon"></i>
                            <input 
                                type="text" 
                                name="username" 
                                id="username" 
                                class="form-input" 
                                placeholder="johndoe"
                                value="<?php echo isset($data['username']) ? htmlspecialchars($data['username']) : ''; ?>"
                                required
                            >
                        </div>
                        <span class="form-helper">Choose a unique username for your account</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">
                            Email Address <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i data-lucide="mail" class="input-icon"></i>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-input" 
                                placeholder="john.doe@example.com"
                                value="<?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''; ?>"
                                required
                            >
                        </div>
                        <span class="form-helper">We'll send appointment confirmations to this email</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">
                            Password <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i data-lucide="lock" class="input-icon"></i>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-input" 
                                placeholder="••••••••"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <i data-lucide="eye" id="password-eye"></i>
                            </button>
                        </div>
                        <span class="form-helper">Must be at least 6 characters long</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">
                            Confirm Password <span class="required">*</span>
                        </label>
                        <div class="input-with-icon">
                            <i data-lucide="lock" class="input-icon"></i>
                            <input 
                                type="password" 
                                name="confirm_password" 
                                id="confirm_password" 
                                class="form-input" 
                                placeholder="••••••••"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePassword('confirm_password')">
                                <i data-lucide="eye" id="confirm_password-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-checkbox">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            I agree to the <a href="#" class="text-link">Terms of Service</a> and 
                            <a href="#" class="text-link">Privacy Policy</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                        <i data-lucide="user-plus"></i>
                        Create Account
                    </button>
                    
                    <div class="auth-divider">
                        <span>Already have an account?</span>
                    </div>
                    
                    <a href="<?php echo APP_URL; ?>/public/auth/login" class="btn btn-outline btn-lg btn-block">
                        <i data-lucide="log-in"></i>
                        Sign In
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-eye');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
        
        // Password strength indicator
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        
        confirmPassword.addEventListener('input', function() {
            if (this.value !== password.value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
        
        password.addEventListener('input', function() {
            if (confirmPassword.value && this.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Passwords do not match');
            } else {
                confirmPassword.setCustomValidity('');
            }
        });
    </script>
</body>
</html>
