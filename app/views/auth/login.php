<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?? 'Login'; ?> - Dental Clinic</title>
    <link rel="stylesheet" href="<?php echo ASSETS; ?>/css/style.css">
    <style>
        .login-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }
        
        .login-hero {
            background: linear-gradient(135deg, hsl(158, 64%, 52%) 0%, hsl(186, 100%, 35%) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .login-hero::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -250px;
        }
        
        .login-hero::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }
        
        .hero-logo {
            font-size: 6rem;
            margin-bottom: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .hero-content p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 400px;
        }
        
        .login-form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: hsl(210, 40%, 98%);
        }
        
        .login-card {
            background: white;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 450px;
            border: 1px solid hsl(214, 32%, 91%);
        }
        
        .login-header {
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            font-size: 1.875rem;
            font-weight: 700;
            color: hsl(222, 47%, 11%);
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: hsl(215, 16%, 47%);
            font-size: 0.95rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: hsl(222, 47%, 11%);
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: hsl(215, 16%, 47%);
            width: 20px;
            height: 20px;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            font-size: 0.95rem;
            border: 2px solid hsl(214, 32%, 91%);
            border-radius: 8px;
            background: white;
            transition: all 0.2s ease;
            font-family: inherit;
        }
        
        .form-input:focus {
            outline: none;
            border-color: hsl(158, 64%, 52%);
            box-shadow: 0 0 0 3px hsla(158, 64%, 52%, 0.1);
        }
        
        .form-input:hover {
            border-color: hsl(158, 64%, 52%);
        }
        
        .btn-login {
            width: 100%;
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            background: linear-gradient(135deg, hsl(158, 64%, 52%) 0%, hsl(158, 64%, 42%) 100%);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, hsl(158, 64%, 42%) 0%, hsl(158, 64%, 32%) 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px hsla(158, 64%, 52%, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: start;
            gap: 0.75rem;
            font-size: 0.875rem;
        }
        
        .alert-error {
            background: hsl(0, 72%, 97%);
            color: hsl(0, 72%, 41%);
            border: 1px solid hsl(0, 72%, 90%);
        }
        
        .alert-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }
        
        .login-footer {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid hsl(214, 32%, 91%);
            text-align: center;
        }
        
        .credential-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: hsl(210, 40%, 96%);
            border-radius: 6px;
            font-size: 0.813rem;
            color: hsl(215, 16%, 47%);
            margin: 0.25rem;
        }
        
        .credential-badge strong {
            color: hsl(158, 64%, 42%);
            font-weight: 600;
        }
        
        @media (max-width: 968px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }
            
            .login-hero {
                display: none;
            }
            
            .login-form-side {
                padding: 2rem 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left Side - Hero -->
        <div class="login-hero">
            <div class="hero-content">
                <div class="hero-logo">🦷</div>
                <h1>Dental Clinic</h1>
                <p>Modern patient management system for dental professionals</p>
            </div>
        </div>
        
        <!-- Right Side - Form -->
        <div class="login-form-side">
            <div class="login-card">
                <div class="login-header">
                    <h2>Welcome Back</h2>
                    <p>Enter your credentials to access your account</p>
                </div>

                <?php if (isset($data['error'])): ?>
                    <div class="alert alert-error">
                        <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?php echo $data['error']; ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo APP_URL; ?>/public/auth/login">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input type="email" name="email" id="email" class="form-input" placeholder="Enter your email" required autofocus>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input type="password" name="password" id="password" class="form-input" placeholder="Enter your password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        Sign In
                    </button>
                </form>

                <div class="login-footer">
                    <p style="color: hsl(215, 16%, 47%); font-size: 0.875rem; margin-bottom: 0.75rem;">Demo Credentials</p>
                    <div>
                        <span class="credential-badge">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <strong>admin@dental.com</strong>
                        </span>
                        <span class="credential-badge">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <strong>admin123</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
