<?php require_once '../app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-title">
            <div class="page-icon">
                <i data-lucide="user"></i>
            </div>
            <div>
                <h1>Patient Profile</h1>
                <p class="page-subtitle">Complete patient information and medical history</p>
            </div>
        </div>
        <div class="page-header-actions">
            <a href="<?php echo APP_URL; ?>/public/patient" class="btn btn-outline">
                <i data-lucide="arrow-left"></i>
                Back to List
            </a>
            <a href="<?php echo APP_URL; ?>/public/patient/edit/<?php echo $data['patient']->id; ?>" class="btn btn-primary">
                <i data-lucide="edit-3"></i>
                Edit Profile
            </a>
        </div>
    </div>
</div>

<!-- Patient Profile Card -->
<div class="patient-profile-card">
    <div class="profile-header">
        <div class="profile-avatar-section">
            <div class="profile-avatar-large">
                <?php echo strtoupper(substr($data['patient']->first_name, 0, 1) . substr($data['patient']->last_name, 0, 1)); ?>
                <div class="avatar-ring"></div>
            </div>
            <div class="profile-status">
                <span class="status-badge status-<?php echo $data['patient']->status; ?>">
                    <i data-lucide="<?php echo $data['patient']->status == 'active' ? 'check-circle' : 'x-circle'; ?>"></i>
                    <?php echo ucfirst($data['patient']->status); ?>
                </span>
            </div>
        </div>
        
        <div class="profile-main-info">
            <div class="profile-name-section">
                <h1 class="profile-name">
                    <?php echo htmlspecialchars($data['patient']->first_name . ' ' . $data['patient']->last_name); ?>
                </h1>
                <p class="profile-id">Patient ID: <span><?php echo $data['patient']->patient_code; ?></span></p>
            </div>
            
            <div class="profile-quick-stats">
                <div class="quick-stat">
                    <i data-lucide="calendar"></i>
                    <div>
                        <span class="stat-label">Age</span>
                        <span class="stat-value">
                            <?php 
                                $birthDate = new DateTime($data['patient']->date_of_birth);
                                $today = new DateTime('today');
                                echo $birthDate->diff($today)->y . ' years';
                            ?>
                        </span>
                    </div>
                </div>
                <div class="quick-stat">
                    <i data-lucide="users"></i>
                    <div>
                        <span class="stat-label">Gender</span>
                        <span class="stat-value"><?php echo ucfirst($data['patient']->gender); ?></span>
                    </div>
                </div>
                <div class="quick-stat">
                    <i data-lucide="droplet"></i>
                    <div>
                        <span class="stat-label">Blood Type</span>
                        <span class="stat-value"><?php echo $data['patient']->blood_type ?: 'Unknown'; ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="profile-actions">
            <button class="action-btn" title="Call Patient">
                <i data-lucide="phone"></i>
            </button>
            <button class="action-btn" title="Send Email">
                <i data-lucide="mail"></i>
            </button>
            <button class="action-btn" title="Schedule Appointment">
                <i data-lucide="calendar-plus"></i>
            </button>
        </div>
    </div>
</div>

<!-- Information Grid -->
<div class="info-grid"compositeContent>
    <!-- Personal Details Card -->
    <div class="card info-card">
        <div class="card-header">
            <div class="card-header-content">
                <h2 class="card-title">
                    <i data-lucide="user" class="card-icon"></i>
                    Personal Details
                </h2>
            </div>
        </div>
        <div class="card-content">
            <div class="detail-list">
                <div class="detail-item">
                    <div class="detail-icon">
                        <i data-lucide="calendar"></i>
                    </div>
                    <div class="detail-content">
                        <span class="detail-label">Date of Birth</span>
                        <span class="detail-value"><?php echo date('F j, Y', strtotime($data['patient']->date_of_birth)); ?></span>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-icon">
                        <i data-lucide="users"></i>
                    </div>
                    <div class="detail-content">
                        <span class="detail-label">Gender</span>
                        <span class="detail-value"><?php echo ucfirst($data['patient']->gender); ?></span>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-icon">
                        <i data-lucide="user-check"></i>
                    </div>
                    <div class="detail-content">
                        <span class="detail-label">Patient Since</span>
                        <span class="detail-value"><?php echo date('F j, Y', strtotime($data['patient']->created_at)); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information Card -->
    <div class="card info-card">
        <div class="card-header">
            <div class="card-header-content">
                <h2 class="card-title">
                    <i data-lucide="phone" class="card-icon"></i>
                    Contact Information
                </h2>
            </div>
        </div>
        <div class="card-content">
            <div class="detail-list">
                <div class="detail-item">
                    <div class="detail-icon">
                        <i data-lucide="phone"></i>
                    </div>
                    <div class="detail-content">
                        <span class="detail-label">Phone Number</span>
                        <span class="detail-value">
                            <a href="tel:<?php echo $data['patient']->phone; ?>" class="contact-link">
                                <?php echo $data['patient']->phone; ?>
                            </a>
                        </span>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-icon">
                        <i data-lucide="mail"></i>
                    </div>
                    <div class="detail-content">
                        <span class="detail-label">Email Address</span>
                        <span class="detail-value">
                            <?php if ($data['patient']->email): ?>
                                <a href="mailto:<?php echo $data['patient']->email; ?>" class="contact-link">
                                    <?php echo htmlspecialchars($data['patient']->email); ?>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">Not provided</span>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-icon">
                        <i data-lucide="map-pin"></i>
                    </div>
                    <div class="detail-content">
                        <span class="detail-label">Home Address</span>
                        <span class="detail-value">
                            <?php if ($data['patient']->address): ?>
                                <?php echo nl2br(htmlspecialchars($data['patient']->address)); ?>
                            <?php else: ?>
                                <span class="text-muted">Not provided</span>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Emergency Contact Card -->
<div class="card info-card">
    <div class="card-header">
        <div class="card-header-content">
            <h2 class="card-title">
                <i data-lucide="phone-call" class="card-icon"></i>
                Emergency Contact
            </h2>
        </div>
    </div>
    <div class="card-content">
        <div class="detail-list">
            <div class="detail-item">
                <div class="detail-icon">
                    <i data-lucide="user-check"></i>
                </div>
                <div class="detail-content">
                    <span class="detail-label">Contact Name</span>
                    <span class="detail-value">
                        <?php if ($data['patient']->emergency_contact_name): ?>
                            <?php echo htmlspecialchars($data['patient']->emergency_contact_name); ?>
                        <?php else: ?>
                            <span class="text-muted">Not provided</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-icon">
                    <i data-lucide="phone-call"></i>
                </div>
                <div class="detail-content">
                    <span class="detail-label">Contact Phone</span>
                    <span class="detail-value">
                        <?php if ($data['patient']->emergency_contact_phone): ?>
                            <a href="tel:<?php echo $data['patient']->emergency_contact_phone; ?>" class="contact-link">
                                <?php echo $data['patient']->emergency_contact_phone; ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Not provided</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Medical Information Card -->
<div class="card info-card">
    <div class="card-header">
        <div class="card-header-content">
            <h2 class="card-title">
                <i data-lucide="heart-pulse" class="card-icon"></i>
                Medical Information
            </h2>
        </div>
    </div>
    <div class="card-content">
        <div class="detail-list">
            <div class="detail-item">
                <div class="detail-icon">
                    <i data-lucide="droplet"></i>
                </div>
                <div class="detail-content">
                    <span class="detail-label">Blood Type</span>
                    <span class="detail-value">
                        <?php if ($data['patient']->blood_type): ?>
                            <span class="blood-type-badge"><?php echo $data['patient']->blood_type; ?></span>
                        <?php else: ?>
                            <span class="text-muted">Not specified</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-icon">
                    <i data-lucide="alert-circle"></i>
                </div>
                <div class="detail-content">
                    <span class="detail-label">Known Allergies</span>
                    <span class="detail-value">
                        <?php if ($data['patient']->allergies): ?>
                            <div class="medical-text"><?php echo nl2br(htmlspecialchars($data['patient']->allergies)); ?></div>
                        <?php else: ?>
                            <span class="text-muted">No known allergies</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-icon">
                    <i data-lucide="activity"></i>
                </div>
                <div class="detail-content">
                    <span class="detail-label">Medical Conditions</span>
                    <span class="detail-value">
                        <?php if ($data['patient']->medical_conditions): ?>
                            <div class="medical-text"><?php echo nl2br(htmlspecialchars($data['patient']->medical_conditions)); ?></div>
                        <?php else: ?>
                            <span class="text-muted">No medical conditions reported</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment History Card -->
<div class="card appointment-history-card">
    <div class="card-header">
        <div class="card-header-content">
            <h2 class="card-title">
                <i data-lucide="calendar-check" class="card-icon"></i>
                Appointment History
            </h2>
            <p class="card-description">Patient's past and upcoming appointments</p>
        </div>
        <div class="card-header-actions">
            <button class="btn btn-outline btn-sm">
                <i data-lucide="plus"></i>
                Schedule Appointment
            </button>
        </div>
    </div>
    <div class="card-content">
        <?php if (!empty($data['appointments'])): ?>
            <div class="appointment-list">
                <?php foreach ($data['appointments'] as $appointment): ?>
                    <div class="appointment-item">
                        <div class="appointment-date">
                            <div class="date-month"><?php echo date('M', strtotime($appointment->appointment_date)); ?></div>
                            <div class="date-day"><?php echo date('d', strtotime($appointment->appointment_date)); ?></div>
                        </div>
                        
                        <div class="appointment-details">
                            <div class="appointment-time">
                                <i data-lucide="clock"></i>
                                <?php echo date('g:i A', strtotime($appointment->appointment_time)); ?>
                            </div>
                            <div class="appointment-dentist">
                                <i data-lucide="user-round-cog"></i>
                                Dr. <?php echo htmlspecialchars($appointment->dentist_last_name); ?>
                            </div>
                            <div class="appointment-reason">
                                <?php echo htmlspecialchars($appointment->reason); ?>
                            </div>
                        </div>
                        
                        <div class="appointment-status">
                            <span class="status-badge status-<?php echo $appointment->status; ?>">
                                <i data-lucide="<?php 
                                    echo $appointment->status == 'completed' ? 'check-circle' : 
                                        ($appointment->status == 'cancelled' ? 'x-circle' : 
                                        ($appointment->status == 'pending' ? 'clock' : 'calendar')); 
                                ?>"></i>
                                <?php echo ucfirst($appointment->status); ?>
                            </span>
                        </div>
                        
                        <div class="appointment-actions">
                            <button class="action-btn" title="View Details">
                                <i data-lucide="eye"></i>
                            </button>
                            <?php if ($appointment->status == 'scheduled'): ?>
                                <button class="action-btn" title="Reschedule">
                                    <i data-lucide="calendar"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i data-lucide="calendar-x"></i>
                </div>
                <div class="empty-state-content">
                    <h3>No Appointments Found</h3>
                    <p>This patient hasn't had any appointments yet.</p>
                    <button class="btn btn-primary">
                        <i data-lucide="plus"></i>
                        Schedule First Appointment
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
