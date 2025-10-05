<!-- Use landing page layout -->
<?php require_once '../app/views/landing/partials/header.php'; ?>

<?php require_once '../app/views/landing/partials/navigation.php'; ?>

<!-- Success/Error Messages -->
<?php if (isset($_SESSION['success'])): ?>
    <div style="position: fixed; top: 100px; right: 20px; z-index: 9999; max-width: 400px; background: hsl(142, 76%, 36% / 0.95); color: white; padding: 1rem 1.5rem; border-radius: 0.75rem; box-shadow: 0 10px 40px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 1rem; animation: slideIn 0.3s ease;">
        <i data-lucide="check-circle" style="width: 24px; height: 24px; flex-shrink: 0;"></i>
        <div><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div style="position: fixed; top: 100px; right: 20px; z-index: 9999; max-width: 400px; background: hsl(0, 84%, 60% / 0.95); color: white; padding: 1rem 1.5rem; border-radius: 0.75rem; box-shadow: 0 10px 40px rgba(0,0,0,0.2); display: flex; align-items: center; gap: 1rem; animation: slideIn 0.3s ease;">
        <i data-lucide="alert-circle" style="width: 24px; height: 24px; flex-shrink: 0;"></i>
        <div><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    </div>
<?php endif; ?>

<!-- Page Content -->
<section style="min-height: 100vh; padding: 6rem 2rem 4rem; background: linear-gradient(135deg, hsla(var(--primary), 0.05) 0%, hsla(var(--accent), 0.05) 100%);">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Page Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: 700; color: hsl(var(--foreground)); margin-bottom: 1rem;">
                <i data-lucide="user" style="width: 40px; height: 40px; display: inline-block; vertical-align: middle; color: hsl(var(--primary));"></i>
                My Profile
            </h1>
            <p style="font-size: 1.125rem; color: hsl(var(--muted-foreground)); max-width: 600px; margin: 0 auto;">
                Manage your personal information and account settings
            </p>
        </div>
        
        <div style="display: grid; gap: 2rem; grid-template-columns: 1fr 2fr;">
            <!-- Profile Info Card -->
            <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08); text-align: center; height: fit-content;">
                <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, hsl(var(--primary)), hsl(var(--accent))); color: white; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 700; margin: 0 auto 1.5rem;">
                    <?php echo strtoupper(substr($data['user']['first_name'], 0, 1)); ?>
                </div>
                
                <h2 style="font-size: 1.5rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.5rem;">
                    <?php echo htmlspecialchars($data['user']['first_name'] . ' ' . $data['user']['last_name']); ?>
                </h2>
                
                <p style="color: hsl(var(--muted-foreground)); margin-bottom: 1rem;">
                    <i data-lucide="mail" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle;"></i>
                    <?php echo htmlspecialchars($data['user']['email']); ?>
                </p>
                
                <p style="color: hsl(var(--muted-foreground)); font-size: 0.875rem; margin-bottom: 1.5rem;">
                    <i data-lucide="shield-check" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle;"></i>
                    Patient Account
                </p>
                
                <div style="padding: 1rem; background: hsl(var(--muted) / 0.3); border-radius: 0.5rem; margin-bottom: 1rem;">
                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.5rem;">Member Since</p>
                    <p style="font-weight: 600; color: hsl(var(--foreground));">
                        <?php echo date('F Y'); ?>
                    </p>
                </div>
                
                <div style="padding: 1rem; background: hsl(var(--muted) / 0.3); border-radius: 0.5rem;">
                    <p style="font-size: 0.875rem; color: hsl(var(--muted-foreground)); margin-bottom: 0.5rem;">Username</p>
                    <p style="font-weight: 600; color: hsl(var(--foreground));">
                        <?php echo htmlspecialchars($data['user']['username']); ?>
                    </p>
                </div>
            </div>
            
            <!-- Profile Edit Form -->
            <div style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <h3 style="font-size: 1.5rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="edit-3" style="width: 24px; height: 24px; color: hsl(var(--primary));"></i>
                    Edit Profile Information
                </h3>
                <p style="color: hsl(var(--muted-foreground)); margin-bottom: 2rem;">
                    Update your personal details below
                </p>
                
                <?php if (isset($data['errors']) && !empty($data['errors'])): ?>
                    <div style="background: hsl(0, 84%, 60% / 0.1); border-left: 4px solid hsl(0, 84%, 60%); padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.5rem;">
                        <div style="display: flex; align-items: start; gap: 0.75rem;">
                            <i data-lucide="alert-circle" style="width: 20px; height: 20px; color: hsl(0, 84%, 60%); flex-shrink: 0;"></i>
                            <div>
                                <strong style="color: hsl(0, 84%, 60%); display: block; margin-bottom: 0.5rem;">Please correct the following errors:</strong>
                                <ul style="margin: 0; padding-left: 1.25rem; color: hsl(0, 84%, 40%);">
                                    <?php foreach ($data['errors'] as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <form action="<?php echo APP_URL; ?>/public/patient_dashboard/profile" method="POST">
                    <!-- Personal Information Section -->
                    <div style="margin-bottom: 2rem;">
                        <h4 style="font-size: 1.125rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i data-lucide="user-circle" style="width: 20px; height: 20px;"></i>
                            Personal Information
                        </h4>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                            <div>
                                <label for="first_name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: hsl(var(--foreground));">
                                    First Name <span style="color: hsl(0, 84%, 60%);">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name" 
                                    value="<?php echo htmlspecialchars($data['user']['first_name']); ?>"
                                    required
                                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid hsl(var(--border)); border-radius: 0.5rem; font-size: 1rem; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='hsl(var(--primary))'; this.style.boxShadow='0 0 0 3px hsla(var(--primary), 0.1)'"
                                    onblur="this.style.borderColor='hsl(var(--border))'; this.style.boxShadow='none'">
                            </div>
                            
                            <div>
                                <label for="last_name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: hsl(var(--foreground));">
                                    Last Name <span style="color: hsl(0, 84%, 60%);">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="last_name" 
                                    name="last_name" 
                                    value="<?php echo htmlspecialchars($data['user']['last_name']); ?>"
                                    required
                                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid hsl(var(--border)); border-radius: 0.5rem; font-size: 1rem; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='hsl(var(--primary))'; this.style.boxShadow='0 0 0 3px hsla(var(--primary), 0.1)'"
                                    onblur="this.style.borderColor='hsl(var(--border))'; this.style.boxShadow='none'">
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <label for="email" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: hsl(var(--foreground));">
                                Email Address <span style="color: hsl(0, 84%, 60%);">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="<?php echo htmlspecialchars($data['user']['email']); ?>"
                                required
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid hsl(var(--border)); border-radius: 0.5rem; font-size: 1rem; transition: all 0.2s;"
                                onfocus="this.style.borderColor='hsl(var(--primary))'; this.style.boxShadow='0 0 0 3px hsla(var(--primary), 0.1)'"
                                onblur="this.style.borderColor='hsl(var(--border))'; this.style.boxShadow='none'">
                        </div>
                        
                        <div>
                            <label for="phone" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: hsl(var(--foreground));">
                                Phone Number
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="<?php echo htmlspecialchars($data['user']['phone'] ?? ''); ?>"
                                placeholder="(123) 456-7890"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid hsl(var(--border)); border-radius: 0.5rem; font-size: 1rem; transition: all 0.2s;"
                                onfocus="this.style.borderColor='hsl(var(--primary))'; this.style.boxShadow='0 0 0 3px hsla(var(--primary), 0.1)'"
                                onblur="this.style.borderColor='hsl(var(--border))'; this.style.boxShadow='none'">
                        </div>
                    </div>
                    
                    <!-- Password Section -->
                    <div style="margin-bottom: 2rem; padding-top: 2rem; border-top: 1px solid hsl(var(--border));">
                        <h4 style="font-size: 1.125rem; font-weight: 600; color: hsl(var(--foreground)); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i data-lucide="lock" style="width: 20px; height: 20px;"></i>
                            Change Password
                        </h4>
                        <p style="color: hsl(var(--muted-foreground)); margin-bottom: 1rem; font-size: 0.875rem;">
                            Leave blank if you don't want to change your password
                        </p>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <label for="current_password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: hsl(var(--foreground));">
                                Current Password
                            </label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password"
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid hsl(var(--border)); border-radius: 0.5rem; font-size: 1rem; transition: all 0.2s;"
                                onfocus="this.style.borderColor='hsl(var(--primary))'; this.style.boxShadow='0 0 0 3px hsla(var(--primary), 0.1)'"
                                onblur="this.style.borderColor='hsl(var(--border))'; this.style.boxShadow='none'">
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <label for="new_password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: hsl(var(--foreground));">
                                    New Password
                                </label>
                                <input 
                                    type="password" 
                                    id="new_password" 
                                    name="new_password"
                                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid hsl(var(--border)); border-radius: 0.5rem; font-size: 1rem; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='hsl(var(--primary))'; this.style.boxShadow='0 0 0 3px hsla(var(--primary), 0.1)'"
                                    onblur="this.style.borderColor='hsl(var(--border))'; this.style.boxShadow='none'">
                            </div>
                            
                            <div>
                                <label for="confirm_password" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: hsl(var(--foreground));">
                                    Confirm New Password
                                </label>
                                <input 
                                    type="password" 
                                    id="confirm_password" 
                                    name="confirm_password"
                                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid hsl(var(--border)); border-radius: 0.5rem; font-size: 1rem; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='hsl(var(--primary))'; this.style.boxShadow='0 0 0 3px hsla(var(--primary), 0.1)'"
                                    onblur="this.style.borderColor='hsl(var(--border))'; this.style.boxShadow='none'">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div style="display: flex; gap: 1rem; justify-content: flex-end; padding-top: 1.5rem; border-top: 1px solid hsl(var(--border));">
                        <a href="<?php echo APP_URL; ?>/public/" 
                           style="padding: 0.75rem 1.5rem; background: white; border: 1px solid hsl(var(--border)); border-radius: 0.5rem; font-weight: 500; cursor: pointer; transition: all 0.2s; text-decoration: none; color: hsl(var(--foreground)); display: inline-flex; align-items: center; gap: 0.5rem;"
                           onmouseover="this.style.background='hsl(var(--muted) / 0.5)'"
                           onmouseout="this.style.background='white'">
                            <i data-lucide="x" style="width: 18px; height: 18px;"></i>
                            Cancel
                        </a>
                        <button 
                            type="submit"
                            style="padding: 0.75rem 1.5rem; background: hsl(var(--primary)); color: white; border: none; border-radius: 0.5rem; font-weight: 500; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem;"
                            onmouseover="this.style.background='hsl(var(--primary) / 0.9)'; this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.background='hsl(var(--primary))'; this.style.transform='translateY(0)'">
                            <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once '../app/views/landing/partials/footer.php'; ?>
