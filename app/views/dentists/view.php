<?php require_once '../app/views/layouts/header.php'; ?>

<div class="header">
    <h1>Dentist Profile</h1>
    <a href="<?php echo APP_URL; ?>/public/dentist" class="btn btn-outline">Back to List</a>
</div>

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">
            <?php echo strtoupper(substr($data['dentist']->first_name, 0, 1) . substr($data['dentist']->last_name, 0, 1)); ?>
        </div>
        <div class="profile-info">
            <h2>Dr. <?php echo $data['dentist']->first_name . ' ' . $data['dentist']->last_name; ?></h2>
            <p class="profile-meta"><?php echo $data['dentist']->specialization; ?></p>
            <span class="badge badge-success"><?php echo $data['dentist']->status; ?></span>
        </div>
    </div>
    
    <div class="profile-details">
        <div class="detail-item">
            <div class="detail-label">License Number</div>
            <div class="detail-value"><?php echo $data['dentist']->license_number; ?></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Phone</div>
            <div class="detail-value"><?php echo $data['dentist']->phone; ?></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Email</div>
            <div class="detail-value"><?php echo $data['dentist']->email; ?></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Gender</div>
            <div class="detail-value"><?php echo ucfirst($data['dentist']->gender); ?></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Date of Birth</div>
            <div class="detail-value"><?php echo $data['dentist']->date_of_birth ? date('M d, Y', strtotime($data['dentist']->date_of_birth)) : 'N/A'; ?></div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Address</div>
            <div class="detail-value"><?php echo $data['dentist']->address ?: 'N/A'; ?></div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
