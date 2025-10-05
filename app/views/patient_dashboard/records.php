<!-- Use landing page layout -->
<?php require_once '../app/views/landing/partials/header.php'; ?>

<?php require_once '../app/views/landing/partials/navigation.php'; ?>

<!-- Page Content -->
<section style="min-height: 100vh; padding: 6rem 2rem 4rem; background: linear-gradient(135deg, hsla(var(--primary), 0.05) 0%, hsla(var(--accent), 0.05) 100%);">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: 700; color: hsl(var(--foreground)); margin-bottom: 1rem;">
                <i data-lucide="file-text" style="width: 40px; height: 40px; display: inline-block; vertical-align: middle; color: hsl(var(--primary));"></i>
                Medical Records
            </h1>
            <p style="font-size: 1.125rem; color: hsl(var(--muted-foreground)); max-width: 600px; margin: 0 auto;">
                View your dental treatment history and medical records
            </p>
        </div>
        
        <!-- Records Overview Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <!-- Total Visits Card -->
            <div style="background: white; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 1rem;">
                <div style="width: 60px; height: 60px; border-radius: 0.75rem; background: linear-gradient(135deg, hsl(221, 83%, 53%), hsl(221, 83%, 63%)); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="calendar-check" style="width: 28px; height: 28px; color: white;"></i>
                </div>
                <div>
                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.25rem;">Total Visits</p>
                    <p style="font-size: 1.75rem; font-weight: 700; color: hsl(var(--foreground)); line-height: 1;">
                        <?php echo isset($data['total_visits']) ? $data['total_visits'] : '0'; ?>
                    </p>
                </div>
            </div>
            
            <!-- Treatments Card -->
            <div style="background: white; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 1rem;">
                <div style="width: 60px; height: 60px; border-radius: 0.75rem; background: linear-gradient(135deg, hsl(142, 76%, 36%), hsl(142, 76%, 46%)); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="activity" style="width: 28px; height: 28px; color: white;"></i>
                </div>
                <div>
                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.25rem;">Treatments</p>
                    <p style="font-size: 1.75rem; font-weight: 700; color: hsl(var(--foreground)); line-height: 1;">
                        <?php echo isset($data['total_treatments']) ? $data['total_treatments'] : '0'; ?>
                    </p>
                </div>
            </div>
            
            <!-- Prescriptions Card -->
            <div style="background: white; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 1rem;">
                <div style="width: 60px; height: 60px; border-radius: 0.75rem; background: linear-gradient(135deg, hsl(280, 80%, 50%), hsl(280, 80%, 60%)); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="pill" style="width: 28px; height: 28px; color: white;"></i>
                </div>
                <div>
                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.25rem;">Prescriptions</p>
                    <p style="font-size: 1.75rem; font-weight: 700; color: hsl(var(--foreground)); line-height: 1;">
                        <?php echo isset($data['total_prescriptions']) ? $data['total_prescriptions'] : '0'; ?>
                    </p>
                </div>
            </div>
            
            <!-- Last Visit Card -->
            <div style="background: white; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 1rem;">
                <div style="width: 60px; height: 60px; border-radius: 0.75rem; background: linear-gradient(135deg, hsl(24, 90%, 55%), hsl(24, 90%, 65%)); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-lucide="clock" style="width: 28px; height: 28px; color: white;"></i>
                </div>
                <div>
                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.25rem;">Last Visit</p>
                    <p style="font-size: 1.125rem; font-weight: 600; color: hsl(var(--foreground)); line-height: 1.2;">
                        <?php echo isset($data['last_visit']) ? date('M d, Y', strtotime($data['last_visit'])) : 'N/A'; ?>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Treatment History Section -->
        <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="history" style="width: 24px; height: 24px; color: hsl(var(--primary));"></i>
                Treatment History
            </h2>
            <p style="color: hsl(var(--muted-foreground)); margin-bottom: 2rem;">
                Complete history of your dental treatments and procedures
            </p>
            
            <?php if (isset($data['treatments']) && !empty($data['treatments'])): ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: hsl(var(--muted) / 0.3); border-bottom: 2px solid hsl(var(--border));">
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: hsl(var(--foreground));">Date</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: hsl(var(--foreground));">Treatment</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: hsl(var(--foreground));">Dentist</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: hsl(var(--foreground));">Notes</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: hsl(var(--foreground));">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['treatments'] as $treatment): ?>
                                <tr style="border-bottom: 1px solid hsl(var(--border));">
                                    <td style="padding: 1rem; color: hsl(var(--foreground));">
                                        <?php echo date('M d, Y', strtotime($treatment->date)); ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <strong style="color: hsl(var(--foreground)); display: block;"><?php echo htmlspecialchars($treatment->treatment_name); ?></strong>
                                        <span style="font-size: 0.875rem; color: hsl(var(--muted-foreground));"><?php echo htmlspecialchars($treatment->treatment_type); ?></span>
                                    </td>
                                    <td style="padding: 1rem; color: hsl(var(--foreground));">
                                        <?php echo htmlspecialchars($treatment->dentist_name); ?>
                                    </td>
                                    <td style="padding: 1rem; color: hsl(var(--muted-foreground)); max-width: 300px;">
                                        <?php echo htmlspecialchars($treatment->notes ?? 'No notes'); ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <span style="padding: 0.375rem 0.75rem; background: hsl(142, 76%, 36% / 0.1); color: hsl(142, 76%, 36%); border-radius: 9999px; font-size: 0.875rem; font-weight: 500;">
                                            <?php echo ucfirst($treatment->status); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div style="text-align: center; padding: 3rem 2rem;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: hsl(var(--muted) / 0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <i data-lucide="folder-open" style="width: 36px; height: 36px; color: hsl(var(--muted-foreground));"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.5rem;">
                        No Treatment History
                    </h3>
                    <p style="color: hsl(var(--muted-foreground)); margin-bottom: 1.5rem;">
                        You don't have any treatment records yet. Your treatment history will appear here after your first visit.
                    </p>
                    <a href="<?php echo APP_URL; ?>/public/patient_dashboard/book" 
                       style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: hsl(var(--primary)); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 500; transition: all 0.2s;"
                       onmouseover="this.style.background='hsl(var(--primary) / 0.9)'; this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.background='hsl(var(--primary))'; this.style.transform='translateY(0)'">
                        <i data-lucide="calendar-plus" style="width: 18px; height: 18px;"></i>
                        Book Your First Appointment
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Prescriptions Section -->
        <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="pill" style="width: 24px; height: 24px; color: hsl(var(--primary));"></i>
                Prescriptions
            </h2>
            <p style="color: hsl(var(--muted-foreground)); margin-bottom: 2rem;">
                Your prescribed medications and supplements
            </p>
            
            <?php if (isset($data['prescriptions']) && !empty($data['prescriptions'])): ?>
                <div style="display: grid; gap: 1rem;">
                    <?php foreach ($data['prescriptions'] as $prescription): ?>
                        <div style="border: 1px solid hsl(var(--border)); border-radius: 0.75rem; padding: 1.5rem; transition: all 0.2s;"
                             onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.08)'; this.style.borderColor='hsl(var(--primary))'"
                             onmouseout="this.style.boxShadow='none'; this.style.borderColor='hsl(var(--border))'">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                <div style="flex: 1;">
                                    <h3 style="font-size: 1.125rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.25rem;">
                                        <?php echo htmlspecialchars($prescription->medication_name); ?>
                                    </h3>
                                    <p style="color: hsl(var(--muted-foreground)); font-size: 0.875rem;">
                                        Prescribed by Dr. <?php echo htmlspecialchars($prescription->dentist_name); ?>
                                    </p>
                                </div>
                                <span style="padding: 0.375rem 0.75rem; background: hsl(142, 76%, 36% / 0.1); color: hsl(142, 76%, 36%); border-radius: 9999px; font-size: 0.875rem; font-weight: 500;">
                                    <?php echo ucfirst($prescription->status); ?>
                                </span>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; padding: 1rem; background: hsl(var(--muted) / 0.2); border-radius: 0.5rem;">
                                <div>
                                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.25rem;">Dosage</p>
                                    <p style="font-weight: 600; color: hsl(var(--foreground));"><?php echo htmlspecialchars($prescription->dosage); ?></p>
                                </div>
                                <div>
                                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.25rem;">Frequency</p>
                                    <p style="font-weight: 600; color: hsl(var(--foreground));"><?php echo htmlspecialchars($prescription->frequency); ?></p>
                                </div>
                                <div>
                                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.25rem;">Duration</p>
                                    <p style="font-weight: 600; color: hsl(var(--foreground));"><?php echo htmlspecialchars($prescription->duration); ?></p>
                                </div>
                                <div>
                                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.25rem;">Date Prescribed</p>
                                    <p style="font-weight: 600; color: hsl(var(--foreground));"><?php echo date('M d, Y', strtotime($prescription->date)); ?></p>
                                </div>
                            </div>
                            
                            <?php if (!empty($prescription->instructions)): ?>
                                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid hsl(var(--border));">
                                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.5rem;">
                                        <i data-lucide="info" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle;"></i>
                                        Instructions
                                    </p>
                                    <p style="color: hsl(var(--foreground));"><?php echo htmlspecialchars($prescription->instructions); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div style="text-align: center; padding: 3rem 2rem;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: hsl(var(--muted) / 0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <i data-lucide="pill" style="width: 36px; height: 36px; color: hsl(var(--muted-foreground));"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.5rem;">
                        No Prescriptions
                    </h3>
                    <p style="color: hsl(var(--muted-foreground));">
                        You don't have any active prescriptions at this time.
                    </p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Medical Notes Section -->
        <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="clipboard" style="width: 24px; height: 24px; color: hsl(var(--primary));"></i>
                Medical Notes
            </h2>
            <p style="color: hsl(var(--muted-foreground)); margin-bottom: 2rem;">
                Important medical information and notes from your dentist
            </p>
            
            <?php if (isset($data['notes']) && !empty($data['notes'])): ?>
                <div style="display: grid; gap: 1rem;">
                    <?php foreach ($data['notes'] as $note): ?>
                        <div style="border-left: 4px solid hsl(var(--primary)); background: hsl(var(--muted) / 0.2); padding: 1.5rem; border-radius: 0.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                                <div>
                                    <p style="font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.25rem;">
                                        Dr. <?php echo htmlspecialchars($note->dentist_name); ?>
                                    </p>
                                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground));">
                                        <?php echo date('F d, Y', strtotime($note->date)); ?>
                                    </p>
                                </div>
                                <?php if (!empty($note->category)): ?>
                                    <span style="padding: 0.25rem 0.75rem; background: hsl(var(--primary) / 0.1); color: hsl(var(--primary)); border-radius: 9999px; font-size: 0.75rem; font-weight: 500;">
                                        <?php echo htmlspecialchars($note->category); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <p style="color: hsl(var(--foreground)); line-height: 1.6;">
                                <?php echo nl2br(htmlspecialchars($note->content)); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div style="text-align: center; padding: 3rem 2rem;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: hsl(var(--muted) / 0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <i data-lucide="clipboard" style="width: 36px; height: 36px; color: hsl(var(--muted-foreground));"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.5rem;">
                        No Medical Notes
                    </h3>
                    <p style="color: hsl(var(--muted-foreground));">
                        No medical notes have been added to your record yet.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once '../app/views/landing/partials/footer.php'; ?>
