<!-- Sidebar Navigation -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <div class="brand-icon"><i data-lucide="heart-pulse"></i></div>
            <div class="brand-text">
                <h2>Dental Clinic</h2>
                <span class="brand-subtitle">Management System</span>
            </div>
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <div class="nav-section">
            <span class="nav-section-title">Main Menu</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/public/home" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/home') !== false) ? 'active' : ''; ?>">
                        <span class="nav-icon"><i data-lucide="layout-dashboard"></i></span>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/public/patient" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/patient') !== false) ? 'active' : ''; ?>">
                        <span class="nav-icon"><i data-lucide="users"></i></span>
                        <span class="nav-text">Patients</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/public/dentist" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/dentist') !== false) ? 'active' : ''; ?>">
                        <span class="nav-icon"><i data-lucide="user-round-cog"></i></span>
                        <span class="nav-text">Dentists</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/public/appointment" class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/appointment') !== false) ? 'active' : ''; ?>">
                        <span class="nav-icon"><i data-lucide="calendar-check"></i></span>
                        <span class="nav-text">Appointments</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="nav-section">
            <span class="nav-section-title">Account</span>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?php echo APP_URL; ?>/public/auth/logout" class="nav-link nav-link-danger">
                        <span class="nav-icon"><i data-lucide="log-out"></i></span>
                        <span class="nav-text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                <?php echo strtoupper(substr($_SESSION['username'], 0, 2)); ?>
            </div>
            <div class="user-info">
                <div class="user-name"><?php echo $_SESSION['username']; ?></div>
                <div class="user-role"><?php echo ucfirst($_SESSION['role']); ?></div>
            </div>
        </div>
    </div>
</aside>
