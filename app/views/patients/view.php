<?php require_once '../app/views/layouts/header.php'; ?>

<div class="header">
    <h1>Patient Profile</h1>
    <div>
        <a href="<?php echo APP_URL; ?>/public/patient/edit/<?php echo $data['patient']->id; ?>" class="btn btn-primary">Edit Profile</a>
        <a href="<?php echo APP_URL; ?>/public/patient" class="btn btn-outline">Back to List</a>
    </div>
</div>

<div class="profile-card" style="margin-bottom: 2rem;">
    <div class="profile-header">
        <div class="profile-avatar">
            <?php echo strtoupper(substr($data['patient']->first_name, 0, 1) . substr($data['patient']->last_name, 0, 1)); ?>
        </div>
        <div class="profile-info">
            <h2><?php echo $data['patient']->first_name . ' ' . $data['patient']->last_name; ?></h2>
            <p class="profile-meta"><?php echo $data['patient']->patient_code; ?></p>
            <span class="badge badge-<?php echo $data['patient']->status == 'active' ? 'success' : 'error'; ?>">
                <?php echo $data['patient']->status; ?>
            </span>
        </div>
    </div>
    
    <div class="profile-details">
        <div class="detail-item">
            <div class="detail-label">Date of Birth</div>
            <div class="detail-value"><?php echo date('M d, Y', strtotime($data['patient']->date_of_birth)); ?></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Gender</div>
            <div class="detail-value"><?php echo ucfirst($data['patient']->gender); ?></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Phone</div>
            <div class="detail-value"><?php echo $data['patient']->phone; ?></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Email</div>
            <div class="detail-value"><?php echo $data['patient']->email ?: 'N/A'; ?></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Blood Type</div>
            <div class="detail-value"><?php echo $data['patient']->blood_type ?: 'N/A'; ?></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Address</div>
            <div class="detail-value"><?php echo $data['patient']->address ?: 'N/A'; ?></div>
        </div>
    </div>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Emergency Contact</h2>
    </div>
    <div class="card-content">
        <div class="profile-details">
            <div class="detail-item">
                <div class="detail-label">Contact Name</div>
                <div class="detail-value"><?php echo $data['patient']->emergency_contact_name ?: 'N/A'; ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Contact Phone</div>
                <div class="detail-value"><?php echo $data['patient']->emergency_contact_phone ?: 'N/A'; ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Medical Information</h2>
    </div>
    <div class="card-content">
        <div class="profile-details">
            <div class="detail-item">
                <div class="detail-label">Allergies</div>
                <div class="detail-value"><?php echo $data['patient']->allergies ?: 'None reported'; ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Medical Conditions</div>
                <div class="detail-value"><?php echo $data['patient']->medical_conditions ?: 'None reported'; ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Appointment History</h2>
        <p class="card-description">Patient's past and upcoming appointments</p>
    </div>
    <div class="card-content">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Dentist</th>
                        <th>Reason</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['appointments'])): ?>
                        <?php foreach ($data['appointments'] as $appointment): ?>
                            <tr>
                                <td><?php echo date('M d, Y', strtotime($appointment->appointment_date)); ?></td>
                                <td><?php echo date('h:i A', strtotime($appointment->appointment_time)); ?></td>
                                <td><?php echo 'Dr. ' . $appointment->dentist_last_name; ?></td>
                                <td><?php echo $appointment->reason; ?></td>
                                <td>
                                    <span class="badge badge-<?php 
                                        echo $appointment->status == 'completed' ? 'success' : 
                                            ($appointment->status == 'cancelled' ? 'error' : 'primary'); 
                                    ?>">
                                        <?php echo $appointment->status; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No appointments found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
