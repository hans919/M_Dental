    <!-- Upcoming Appointments -->
    <section class="appointments-section">
        <div class="section-header">
            <h3>Upcoming Appointments</h3>
            <a href="/dl/public/patient_dashboard/appointments" class="btn-link">View All</a>
        </div>
        
        <div class="appointments-list">
            <?php if (!empty($data['appointments'])): ?>
                <?php 
                $upcomingShown = 0;
                foreach ($data['appointments'] as $apt): 
                    if (($apt->status == 'pending' || $apt->status == 'approved' || $apt->status == 'confirmed') 
                        && strtotime($apt->appointment_date) >= strtotime(date('Y-m-d')) 
                        && $upcomingShown < 3):
                        $upcomingShown++;
                ?>
                    <div class="appointment-card">
                        <div class="appointment-date">
                            <span class="date-day"><?php echo date('d', strtotime($apt->appointment_date)); ?></span>
                            <span class="date-month"><?php echo date('M', strtotime($apt->appointment_date)); ?></span>
                        </div>
                        <div class="appointment-details">
                            <h4><?php echo htmlspecialchars($apt->reason); ?></h4>
                            <div class="appointment-meta">
                                <span><i data-lucide="clock"></i> <?php echo date('g:i A', strtotime($apt->appointment_time)); ?></span>
                                <span><i data-lucide="user"></i> Dr. <?php echo $apt->dentist_first_name . ' ' . $apt->dentist_last_name; ?></span>
                            </div>
                            <div class="appointment-status">
                                <span class="badge badge-<?php echo $apt->status; ?>"><?php echo ucfirst($apt->status); ?></span>
                            </div>
                        </div>
                    </div>
                <?php 
                    endif;
                endforeach;
                
                if ($upcomingShown == 0):
                ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i data-lucide="calendar-x"></i>
                        </div>
                        <h4>No Upcoming Appointments</h4>
                        <p>You don't have any scheduled appointments yet</p>
                        <a href="/dl/public/patient_dashboard/book" class="btn btn-primary">
                            <i data-lucide="calendar-plus"></i>
                            Book Your First Appointment
                        </a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">
                        <i data-lucide="calendar-x"></i>
                    </div>
                    <h4>No Upcoming Appointments</h4>
                    <p>You don't have any scheduled appointments yet</p>
                    <a href="/dl/public/patient_dashboard/book" class="btn btn-primary">
                        <i data-lucide="calendar-plus"></i>
                        Book Your First Appointment
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
