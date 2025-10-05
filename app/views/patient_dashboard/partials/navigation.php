    <!-- Sidebar Navigation -->
    <aside class="patient-sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i data-lucide="smile" class="logo-icon"></i>
                <span>DentalCare</span>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <a href="/dl/public/patient_dashboard" class="nav-item <?php echo (!isset($_GET['url']) || $_GET['url'] === 'patient_dashboard') ? 'active' : ''; ?>">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="/dl/public/patient_dashboard/appointments" class="nav-item">
                <i data-lucide="calendar"></i>
                <span>My Appointments</span>
            </a>
            
            <a href="/dl/public/patient_dashboard/book" class="nav-item">
                <i data-lucide="calendar-plus"></i>
                <span>Book Appointment</span>
            </a>
            
            <a href="/dl/public/patient_dashboard/records" class="nav-item">
                <i data-lucide="file-text"></i>
                <span>Medical Records</span>
            </a>
            
            <a href="/dl/public/patient_dashboard/profile" class="nav-item">
                <i data-lucide="user"></i>
                <span>My Profile</span>
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <a href="/dl/public/auth/logout" class="nav-item logout">
                <i data-lucide="log-out"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>
