<?php require_once '../app/views/layouts/header.php'; ?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <span class="alert-icon">✓</span>
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon"><i data-lucide="users"></i></div>
            <div class="stat-trend">
                <i data-lucide="trending-up" style="width: 12px; height: 12px;"></i>
                <span>12%</span>
            </div>
        </div>
        <div class="stat-label">Total Patients</div>
        <div class="stat-value"><?php echo $data['patient_count']; ?></div>
        <div class="stat-description">Active registered patients</div>
    </div>
    
    <div class="stat-card accent">
        <div class="stat-header">
            <div class="stat-icon"><i data-lucide="stethoscope"></i></div>
            <div class="stat-trend">
                <i data-lucide="trending-up" style="width: 12px; height: 12px;"></i>
                <span>5%</span>
            </div>
        </div>
        <div class="stat-label">Active Dentists</div>
        <div class="stat-value"><?php echo $data['dentist_count']; ?></div>
        <div class="stat-description">Professional dentists</div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-icon"><i data-lucide="calendar-check"></i></div>
            <div class="stat-trend">
                <i data-lucide="trending-up" style="width: 12px; height: 12px;"></i>
                <span>8%</span>
            </div>
        </div>
        <div class="stat-label">Today's Appointments</div>
        <div class="stat-value"><?php echo $data['today_appointments']; ?></div>
        <div class="stat-description">Scheduled for today</div>
    </div>
</div>

<!-- Recent Appointments -->
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <div class="card-header-content">
            <h2 class="card-title">
                <i data-lucide="clipboard-list" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 0.5rem;"></i>
                Recent Appointments
            </h2>
            <p class="card-description">Latest appointments scheduled in the system</p>
        </div>
        <div class="card-header-actions">
            <a href="<?php echo APP_URL; ?>/public/appointment" class="btn btn-primary btn-sm">
                <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                New Appointment
            </a>
        </div>
    </div>
    <div class="card-content">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Dentist</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['recent_appointments'])): ?>
                        <?php foreach ($data['recent_appointments'] as $appointment): ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--gradient-primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem;">
                                            <?php echo strtoupper(substr($appointment->patient_first_name, 0, 1) . substr($appointment->patient_last_name, 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;"><?php echo $appointment->patient_first_name . ' ' . $appointment->patient_last_name; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: hsl(var(--primary));">
                                        Dr. <?php echo $appointment->dentist_last_name; ?>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <i data-lucide="calendar" style="width: 16px; height: 16px; color: hsl(var(--muted-foreground));"></i>
                                        <span><?php echo date('M d, Y', strtotime($appointment->appointment_date)); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <i data-lucide="clock" style="width: 16px; height: 16px; color: hsl(var(--muted-foreground));"></i>
                                        <span><?php echo date('h:i A', strtotime($appointment->appointment_time)); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-<?php 
                                        echo $appointment->status == 'completed' ? 'success' : 
                                            ($appointment->status == 'cancelled' ? 'error' : 'primary'); 
                                    ?>">
                                        <?php echo ucfirst($appointment->status); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 3rem; color: hsl(var(--muted-foreground));">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">
                                    <i data-lucide="calendar-x" style="width: 64px; height: 64px; margin: 0 auto; opacity: 0.3;"></i>
                                </div>
                                <div style="font-weight: 600; font-size: 1.125rem; margin-bottom: 0.5rem;">No appointments found</div>
                                <div style="font-size: 0.875rem;">Start by creating a new appointment</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Patients -->
<div class="card">
    <div class="card-header">
        <div class="card-header-content">
            <h2 class="card-title">
                <i data-lucide="users" style="width: 24px; height: 24px; display: inline-block; vertical-align: middle; margin-right: 0.5rem;"></i>
                Recent Patients
            </h2>
            <p class="card-description">Newly registered patients in the system</p>
        </div>
        <div class="card-header-actions">
            <a href="<?php echo APP_URL; ?>/public/patient/add" class="btn btn-success btn-sm">
                <i data-lucide="user-plus" style="width: 16px; height: 16px;"></i>
                Add Patient
            </a>
            <a href="<?php echo APP_URL; ?>/public/patient" class="btn btn-outline btn-sm">
                View All
            </a>
        </div>
    </div>
    <div class="card-content">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['recent_patients'])): ?>
                        <?php foreach ($data['recent_patients'] as $patient): ?>
                            <tr>
                                <td>
                                    <span style="font-family: 'Courier New', monospace; font-weight: 700; color: hsl(var(--primary)); background: hsla(var(--primary), 0.1); padding: 0.25rem 0.75rem; border-radius: 6px;">
                                        <?php echo $patient->patient_code; ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--gradient-success); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem;">
                                            <?php echo strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;"><?php echo $patient->first_name . ' ' . $patient->last_name; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <i data-lucide="phone" style="width: 16px; height: 16px; color: hsl(var(--muted-foreground));"></i>
                                        <span><?php echo $patient->phone; ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <i data-lucide="calendar" style="width: 16px; height: 16px; color: hsl(var(--muted-foreground));"></i>
                                        <span><?php echo date('M d, Y', strtotime($patient->created_at)); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="<?php echo APP_URL; ?>/public/patient/detail/<?php echo $patient->id; ?>" class="btn btn-sm btn-outline">
                                            <i data-lucide="eye" style="width: 14px; height: 14px;"></i>
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 3rem; color: hsl(var(--muted-foreground));">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">
                                    <i data-lucide="user-x" style="width: 64px; height: 64px; margin: 0 auto; opacity: 0.3;"></i>
                                </div>
                                <div style="font-weight: 600; font-size: 1.125rem; margin-bottom: 0.5rem;">No patients found</div>
                                <div style="font-size: 0.875rem;">Start by adding your first patient</div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
