<!-- Use landing page layout -->
<?php require_once '../app/views/landing/partials/header.php'; ?>

<?php require_once '../app/views/landing/partials/navigation.php'; ?>

<!-- Page Content -->
<section style="min-height: 100vh; padding: 6rem 2rem 4rem; background: linear-gradient(135deg, hsla(var(--primary), 0.05) 0%, hsla(var(--accent), 0.05) 100%);">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: 700; color: hsl(var(--foreground)); margin-bottom: 1rem;">
                <i data-lucide="calendar" style="width: 40px; height: 40px; display: inline-block; vertical-align: middle; color: hsl(var(--primary));"></i>
                My Appointments
            </h1>
            <p style="font-size: 1.125rem; color: hsl(var(--muted-foreground)); max-width: 600px; margin: 0 auto;">
                View and manage your dental appointments
            </p>
        </div>
        
        <!-- Content Container -->
        <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            
            <!-- Action Bar -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid hsl(var(--border));">
                <h2 style="font-size: 1.25rem; font-weight: 600; margin: 0;">Your Appointments</h2>
                <a href="<?php echo APP_URL; ?>/public/patient_dashboard/book" class="btn btn-primary">
                    <i data-lucide="calendar-plus"></i>
                    Book New Appointment
                </a>
            </div>
            
            <?php if (!empty($data['appointments'])): ?>
                <div style="display: grid; gap: 1rem;">
                    <?php foreach ($data['appointments'] as $apt): ?>
                        <div style="border: 1px solid hsl(var(--border)); border-radius: 0.75rem; padding: 1.5rem; transition: all 0.2s; display: flex; gap: 1.5rem; align-items: start;">
                            <!-- Date Badge -->
                            <div style="min-width: 80px; text-align: center; padding: 1rem; background: hsl(var(--primary) / 0.1); border-radius: 0.5rem;">
                                <div style="font-size: 2rem; font-weight: 700; color: hsl(var(--primary)); line-height: 1;">
                                    <?php echo date('d', strtotime($apt->appointment_date)); ?>
                                </div>
                                <div style="font-size: 0.875rem; font-weight: 600; color: hsl(var(--primary)); text-transform: uppercase;">
                                    <?php echo date('M', strtotime($apt->appointment_date)); ?>
                                </div>
                                <div style="font-size: 0.75rem; color: hsl(var(--muted-foreground)); margin-top: 0.25rem;">
                                    <?php echo date('Y', strtotime($apt->appointment_date)); ?>
                                </div>
                            </div>
                            
                            <!-- Appointment Details -->
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                                    <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0; color: hsl(var(--foreground));">
                                        <?php echo htmlspecialchars($apt->reason); ?>
                                    </h3>
                                    <?php
                                    $statusClass = '';
                                    $statusText = ucfirst(str_replace('_', ' ', $apt->status));
                                    
                                    switch($apt->status) {
                                        case 'pending':
                                            $statusClass = 'background: hsl(38, 92%, 50% / 0.1); color: hsl(38, 92%, 40%);';
                                            break;
                                        case 'approved':
                                        case 'confirmed':
                                            $statusClass = 'background: hsl(142, 76%, 36% / 0.1); color: hsl(142, 76%, 30%);';
                                            break;
                                        case 'completed':
                                            $statusClass = 'background: hsl(210, 40%, 96%); color: hsl(var(--muted-foreground));';
                                            break;
                                        case 'declined':
                                        case 'cancelled_by_patient':
                                        case 'cancelled_by_clinic':
                                            $statusClass = 'background: hsl(0, 84%, 60% / 0.1); color: hsl(0, 84%, 45%);';
                                            break;
                                        default:
                                            $statusClass = 'background: hsl(221, 83%, 53% / 0.1); color: hsl(221, 83%, 45%);';
                                    }
                                    ?>
                                    <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; <?php echo $statusClass; ?>">
                                        <?php echo $statusText; ?>
                                    </span>
                                </div>
                                
                                <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; color: hsl(var(--muted-foreground)); font-size: 0.875rem; margin-bottom: 0.5rem;">
                                    <span style="display: flex; align-items: center; gap: 0.375rem;">
                                        <i data-lucide="clock" style="width: 14px; height: 14px;"></i>
                                        <?php echo date('g:i A', strtotime($apt->appointment_time)); ?>
                                    </span>
                                    <span style="display: flex; align-items: center; gap: 0.375rem;">
                                        <i data-lucide="user" style="width: 14px; height: 14px;"></i>
                                        Dr. <?php echo $apt->dentist_first_name . ' ' . $apt->dentist_last_name; ?>
                                    </span>
                                    <?php if (!empty($apt->specialization)): ?>
                                        <span style="display: flex; align-items: center; gap: 0.375rem;">
                                            <i data-lucide="stethoscope" style="width: 14px; height: 14px;"></i>
                                            <?php echo $apt->specialization; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($apt->status === 'pending'): ?>
                                    <div style="margin-top: 0.75rem; padding: 0.75rem; background: hsl(38, 92%, 50% / 0.05); border-radius: 0.5rem; border-left: 3px solid hsl(38, 92%, 50%);">
                                        <span style="font-size: 0.875rem; color: hsl(38, 92%, 40%);">
                                            <i data-lucide="info" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle;"></i>
                                            Waiting for clinic confirmation
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 4rem 2rem;">
                    <div style="width: 80px; height: 80px; margin: 0 auto 1.5rem; border-radius: 50%; background: hsl(var(--muted)); display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="calendar-x" style="width: 40px; height: 40px; color: hsl(var(--muted-foreground)); opacity: 0.5;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">No Appointments Yet</h3>
                    <p style="color: hsl(var(--muted-foreground)); margin-bottom: 1.5rem;">You haven't booked any appointments yet.</p>
                    <a href="<?php echo APP_URL; ?>/public/patient_dashboard/book" class="btn btn-primary">
                        <i data-lucide="calendar-plus"></i>
                        Book Your First Appointment
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once '../app/views/landing/partials/footer.php'; ?>
