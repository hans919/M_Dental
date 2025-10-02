<?php require_once '../app/views/layouts/header.php'; ?>

<div class="header">
    <h1>Appointments</h1>
    <a href="<?php echo APP_URL; ?>/public/appointment/add" class="btn btn-primary">Schedule Appointment</a>
</div>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Appointment List</h2>
        <p class="card-description">All scheduled appointments</p>
    </div>
    <div class="card-content">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Patient Code</th>
                        <th>Dentist</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['appointments'])): ?>
                        <?php foreach ($data['appointments'] as $appointment): ?>
                            <tr>
                                <td><?php echo $appointment->patient_first_name . ' ' . $appointment->patient_last_name; ?></td>
                                <td><?php echo $appointment->patient_code; ?></td>
                                <td>Dr. <?php echo $appointment->dentist_last_name; ?></td>
                                <td><?php echo date('M d, Y', strtotime($appointment->appointment_date)); ?></td>
                                <td><?php echo date('h:i A', strtotime($appointment->appointment_time)); ?></td>
                                <td><?php echo $appointment->duration; ?> min</td>
                                <td>
                                    <span class="badge badge-<?php 
                                        echo $appointment->status == 'completed' ? 'success' : 
                                            ($appointment->status == 'cancelled' ? 'error' : 
                                            ($appointment->status == 'confirmed' ? 'primary' : 'warning')); 
                                    ?>">
                                        <?php echo $appointment->status; ?>
                                    </span>
                                </td>
                                <td><?php echo substr($appointment->reason, 0, 50) . (strlen($appointment->reason) > 50 ? '...' : ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">No appointments found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
