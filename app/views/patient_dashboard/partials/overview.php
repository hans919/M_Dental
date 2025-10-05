    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-content">
            <h2>Welcome back, <?php echo $data['user']['first_name']; ?>! 👋</h2>
            <p>Here's what's happening with your dental health today</p>
        </div>
        <div class="welcome-actions">
            <a href="/dl/public/patient_dashboard/book" class="btn btn-primary">
                <i data-lucide="calendar-plus"></i>
                Book Appointment
            </a>
        </div>
    </section>
    
    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <i data-lucide="check-circle"></i>
            <div><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <i data-lucide="alert-circle"></i>
            <div><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        </div>
    <?php endif; ?>
    
    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i data-lucide="calendar-check"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?php echo $data['pending_count'] ?? 0; ?></span>
                <span class="stat-label">Upcoming Appointments</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <i data-lucide="check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value"><?php echo $data['completed_count'] ?? 0; ?></span>
                <span class="stat-label">Completed Visits</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon info">
                <i data-lucide="file-text"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">0</span>
                <span class="stat-label">Medical Records</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon warning">
                <i data-lucide="clock"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">
                    <?php 
                    if (!empty($data['appointments'])) {
                        $nextApt = null;
                        foreach ($data['appointments'] as $apt) {
                            if ($apt->status == 'approved' || $apt->status == 'confirmed') {
                                if (strtotime($apt->appointment_date) >= strtotime(date('Y-m-d'))) {
                                    $nextApt = $apt;
                                    break;
                                }
                            }
                        }
                        echo $nextApt ? date('M d', strtotime($nextApt->appointment_date)) : '-';
                    } else {
                        echo '-';
                    }
                    ?>
                </span>
                <span class="stat-label">Next Checkup</span>
            </div>
        </div>
    </div>
