<?php require_once '../app/views/layouts/header.php'; ?>

<div class="header">
    <h1>Schedule Appointment</h1>
    <a href="<?php echo APP_URL; ?>/public/appointment" class="btn btn-outline">Back to List</a>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Appointment Details</h2>
        <p class="card-description">Fill in the appointment information</p>
    </div>
    <div class="card-content">
        <form method="POST" action="<?php echo APP_URL; ?>/public/appointment/add">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                <div class="form-group">
                    <label for="patient_id" class="form-label">Patient *</label>
                    <select name="patient_id" id="patient_id" class="form-select" required>
                        <option value="">Select Patient</option>
                        <?php foreach ($data['patients'] as $patient): ?>
                            <option value="<?php echo $patient->id; ?>">
                                <?php echo $patient->patient_code . ' - ' . $patient->first_name . ' ' . $patient->last_name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="dentist_id" class="form-label">Dentist *</label>
                    <select name="dentist_id" id="dentist_id" class="form-select" required>
                        <option value="">Select Dentist</option>
                        <?php foreach ($data['dentists'] as $dentist): ?>
                            <option value="<?php echo $dentist->id; ?>">
                                Dr. <?php echo $dentist->first_name . ' ' . $dentist->last_name . ' - ' . $dentist->specialization; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="appointment_date" class="form-label">Date *</label>
                    <input type="date" name="appointment_date" id="appointment_date" class="form-input" min="<?php echo date('Y-m-d'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="appointment_time" class="form-label">Time *</label>
                    <input type="time" name="appointment_time" id="appointment_time" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="duration" class="form-label">Duration (minutes) *</label>
                    <select name="duration" id="duration" class="form-select" required>
                        <option value="30">30 minutes</option>
                        <option value="45">45 minutes</option>
                        <option value="60">1 hour</option>
                        <option value="90">1.5 hours</option>
                        <option value="120">2 hours</option>
                    </select>
                </div>
                
                <div class="form-group" style="grid-column: span 2;">
                    <label for="reason" class="form-label">Reason for Visit *</label>
                    <textarea name="reason" id="reason" class="form-textarea" placeholder="Describe the reason for this appointment" required></textarea>
                </div>
            </div>
            
            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary btn-lg">Schedule Appointment</button>
                <a href="<?php echo APP_URL; ?>/public/appointment" class="btn btn-outline btn-lg">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
