<!-- Use landing page layout -->
<?php require_once '../app/views/landing/partials/header.php'; ?>

<?php require_once '../app/views/landing/partials/navigation.php'; ?>

<!-- Page Content -->
<section style="min-height: 100vh; padding: 6rem 2rem 4rem; background: linear-gradient(135deg, hsla(var(--primary), 0.05) 0%, hsla(var(--accent), 0.05) 100%);">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: 700; color: hsl(var(--foreground)); margin-bottom: 1rem;">
                <i data-lucide="calendar-plus" style="width: 40px; height: 40px; display: inline-block; vertical-align: middle; color: hsl(var(--primary));"></i>
                Book an Appointment
            </h1>
            <p style="font-size: 1.125rem; color: hsl(var(--muted-foreground)); max-width: 600px; margin: 0 auto;">
                Schedule your dental appointment with our professional dentists
            </p>
        </div>
        
        <!-- Booking Form Container -->
        <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            
            <?php if (isset($data['errors']) && !empty($data['errors'])): ?>
                <div class="alert alert-error">
                    <i data-lucide="alert-circle"></i>
                    <div>
                        <strong>Please correct the following errors:</strong>
                        <ul>
                            <?php foreach ($data['errors'] as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            <form action="<?php echo APP_URL; ?>/public/patient_dashboard/book" method="POST" class="booking-form">
                <!-- Dentist Selection -->
                <div class="form-section">
                    <h3>
                        <i data-lucide="user-check"></i>
                        Select Dentist
                    </h3>
                    
                    <div class="dentist-grid">
                        <?php if (!empty($data['dentists'])): ?>
                            <?php foreach ($data['dentists'] as $dentist): ?>
                                <label class="dentist-card">
                                    <input type="radio" name="dentist_id" value="<?php echo $dentist->id; ?>" required>
                                    <div class="dentist-info">
                                        <div class="dentist-avatar">
                                            <?php echo strtoupper(substr($dentist->first_name, 0, 1)); ?>
                                        </div>
                                        <div>
                                            <h4><?php echo $dentist->first_name . ' ' . $dentist->last_name; ?></h4>
                                            <p class="specialization"><?php echo $dentist->specialization ?? 'General Dentistry'; ?></p>
                                        </div>
                                    </div>
                                    <div class="checkmark">
                                        <i data-lucide="check"></i>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="no-data">No dentists available. Please contact the clinic.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Date and Time -->
                <div class="form-section">
                    <h3>
                        <i data-lucide="calendar"></i>
                        Select Date & Time
                    </h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="appointment_date">
                                <i data-lucide="calendar-days"></i>
                                Appointment Date
                            </label>
                            <input 
                                type="date" 
                                id="appointment_date" 
                                name="appointment_date" 
                                min="<?php echo date('Y-m-d'); ?>"
                                value="<?php echo $data['appointment_date'] ?? ''; ?>"
                                required
                                class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label for="appointment_time">
                                <i data-lucide="clock"></i>
                                Appointment Time
                            </label>
                            <select id="appointment_time" name="appointment_time" required class="form-control">
                                <option value="">Select time</option>
                                <option value="09:00:00">9:00 AM</option>
                                <option value="09:30:00">9:30 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="10:30:00">10:30 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="11:30:00">11:30 AM</option>
                                <option value="13:00:00">1:00 PM</option>
                                <option value="13:30:00">1:30 PM</option>
                                <option value="14:00:00">2:00 PM</option>
                                <option value="14:30:00">2:30 PM</option>
                                <option value="15:00:00">3:00 PM</option>
                                <option value="15:30:00">3:30 PM</option>
                                <option value="16:00:00">4:00 PM</option>
                                <option value="16:30:00">4:30 PM</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Reason for Visit -->
                <div class="form-section">
                    <h3>
                        <i data-lucide="file-text"></i>
                        Reason for Visit
                    </h3>
                    
                    <div class="form-group">
                        <label for="reason">Please describe your dental concern or reason for appointment</label>
                        <textarea 
                            id="reason" 
                            name="reason" 
                            rows="4" 
                            required
                            class="form-control"
                            placeholder="e.g., Tooth pain, Dental checkup, Teeth cleaning..."><?php echo $data['reason'] ?? ''; ?></textarea>
                    </div>
                </div>
                
                <!-- Submit -->
                <div class="form-actions">
                    <a href="<?php echo APP_URL; ?>/public/" class="btn btn-outline">
                        <i data-lucide="x"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="check"></i>
                        Submit Appointment Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once '../app/views/landing/partials/footer.php'; ?>
