    <!-- Navigation -->
    <nav class="landing-nav">
        <div class="nav-container">
            <div class="nav-brand">
                <a href="<?php echo APP_URL; ?>/public/landing" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: inherit;">
                    <div class="brand-icon">
                        <i data-lucide="heart-pulse"></i>
                    </div>
                    <span class="brand-name">DentalCare Clinic</span>
                </a>
            </div>
            <div class="nav-menu">
                <a href="<?php echo APP_URL; ?>/public/landing#home" class="nav-link">Home</a>
                <a href="<?php echo APP_URL; ?>/public/landing#services" class="nav-link">Services</a>
                <a href="<?php echo APP_URL; ?>/public/landing#about" class="nav-link">About Us</a>
                <a href="<?php echo APP_URL; ?>/public/landing#contact" class="nav-link">Contact</a>
            </div>
            <div class="nav-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Logged in user -->
                    <div class="user-profile-nav">
                        <button class="profile-btn" id="profileDropdownBtn">
                            <div class="profile-avatar">
                                <?php echo strtoupper(substr($_SESSION['first_name'] ?? $_SESSION['username'], 0, 1)); ?>
                            </div>
                            <span class="profile-name"><?php echo $_SESSION['first_name'] ?? $_SESSION['username']; ?></span>
                            <i data-lucide="chevron-down"></i>
                        </button>
                        <div class="profile-dropdown" id="profileDropdown">
                            <div class="dropdown-header">
                                <div class="dropdown-avatar">
                                    <?php echo strtoupper(substr($_SESSION['first_name'] ?? $_SESSION['username'], 0, 1)); ?>
                                </div>
                                <div class="dropdown-info">
                                    <span class="dropdown-name"><?php echo ($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? ''); ?></span>
                                    <span class="dropdown-email"><?php echo $_SESSION['email'] ?? ''; ?></span>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-menu">
                                <?php if ($_SESSION['role'] === 'patient'): ?>
                                    <a href="<?php echo APP_URL; ?>/public/patient_dashboard/appointments" class="dropdown-item">
                                        <i data-lucide="calendar"></i>
                                        My Appointments
                                    </a>
                                    <a href="<?php echo APP_URL; ?>/public/patient_dashboard/book" class="dropdown-item">
                                        <i data-lucide="calendar-plus"></i>
                                        Book Appointment
                                    </a>
                                    <a href="<?php echo APP_URL; ?>/public/patient_dashboard/records" class="dropdown-item">
                                        <i data-lucide="file-text"></i>
                                        Medical Records
                                    </a>
                                    <a href="<?php echo APP_URL; ?>/public/patient_dashboard/profile" class="dropdown-item">
                                        <i data-lucide="user"></i>
                                        My Profile
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo APP_URL; ?>/public/home" class="dropdown-item">
                                        <i data-lucide="layout-dashboard"></i>
                                        Admin Dashboard
                                    </a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a href="<?php echo APP_URL; ?>/public/auth/logout" class="dropdown-item text-danger">
                                    <i data-lucide="log-out"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Guest user -->
                    <a href="<?php echo APP_URL; ?>/public/auth/login" class="btn btn-outline">
                        <i data-lucide="log-in"></i>
                        Login
                    </a>
                    <a href="<?php echo APP_URL; ?>/public/auth/register" class="btn btn-primary">
                        <i data-lucide="user-plus"></i>
                        Register
                    </a>
                <?php endif; ?>
            </div>
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </nav>
