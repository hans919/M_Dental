<?php require_once '../app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-title">
            <div class="page-icon">
                <i data-lucide="user-pen"></i>
            </div>
            <div>
                <h1>Edit Patient Profile</h1>
                <p class="page-subtitle">Update patient information for <?php echo htmlspecialchars($data['patient']->first_name . ' ' . $data['patient']->last_name); ?></p>
            </div>
        </div>
        <div class="page-header-actions">
            <a href="<?php echo APP_URL; ?>/public/patient/detail/<?php echo $data['patient']->id; ?>" class="btn btn-outline">
                <i data-lucide="arrow-left"></i>
                Back to Profile
            </a>
        </div>
    </div>
</div>

<!-- Progress Steps -->
<div class="form-steps">
    <div class="form-step active">
        <div class="form-step-number">1</div>
        <div class="form-step-label">Personal Info</div>
    </div>
    <div class="form-step-line"></div>
    <div class="form-step active">
        <div class="form-step-number">2</div>
        <div class="form-step-label">Contact Details</div>
    </div>
    <div class="form-step-line"></div>
    <div class="form-step active">
        <div class="form-step-number">3</div>
        <div class="form-step-label">Medical Info</div>
    </div>
</div>

<form method="POST" action="<?php echo APP_URL; ?>/public/patient/edit/<?php echo $data['patient']->id; ?>" class="form-container">
    <!-- Personal Information Section -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-content">
                <h2 class="card-title">
                    <i data-lucide="user" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 0.5rem;"></i>
                    Personal Information
                </h2>
                <p class="card-description">Update basic patient details and identification</p>
            </div>
        </div>
        <div class="card-content">
            <div class="form-grid">
                <div class="form-group">
                    <label for="first_name" class="form-label">
                        First Name <span class="required">*</span>
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="user" class="input-icon"></i>
                        <input 
                            type="text" 
                            name="first_name" 
                            id="first_name" 
                            class="form-input" 
                            value="<?php echo htmlspecialchars($data['patient']->first_name); ?>"
                            placeholder="Enter first name"
                            required
                        >
                    </div>
                    <span class="form-helper">Patient's legal first name</span>
                </div>
                
                <div class="form-group">
                    <label for="last_name" class="form-label">
                        Last Name <span class="required">*</span>
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="user" class="input-icon"></i>
                        <input 
                            type="text" 
                            name="last_name" 
                            id="last_name" 
                            class="form-input" 
                            value="<?php echo htmlspecialchars($data['patient']->last_name); ?>"
                            placeholder="Enter last name"
                            required
                        >
                    </div>
                    <span class="form-helper">Patient's legal last name</span>
                </div>
                
                <div class="form-group">
                    <label for="date_of_birth" class="form-label">
                        Date of Birth <span class="required">*</span>
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="calendar" class="input-icon"></i>
                        <input 
                            type="date" 
                            name="date_of_birth" 
                            id="date_of_birth" 
                            class="form-input" 
                            value="<?php echo $data['patient']->date_of_birth; ?>"
                            required
                        >
                    </div>
                    <span class="form-helper">Used to calculate patient age</span>
                </div>
                
                <div class="form-group">
                    <label for="gender" class="form-label">
                        Gender <span class="required">*</span>
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="users" class="input-icon"></i>
                        <select name="gender" id="gender" class="form-select" required>
                            <option value="">Select gender</option>
                            <option value="male" <?php echo $data['patient']->gender == 'male' ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo $data['patient']->gender == 'female' ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo $data['patient']->gender == 'other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <span class="form-helper">Patient's biological gender</span>
                </div>
                
                <div class="form-group">
                    <label for="status" class="form-label">
                        Account Status <span class="required">*</span>
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="user-check" class="input-icon"></i>
                        <select name="status" id="status" class="form-select" required>
                            <option value="active" <?php echo $data['patient']->status == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $data['patient']->status == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    <span class="form-helper">Patient's account status in the system</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Information Section -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-content">
                <h2 class="card-title">
                    <i data-lucide="phone" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 0.5rem;"></i>
                    Contact Information
                </h2>
                <p class="card-description">Update contact details and emergency contacts</p>
            </div>
        </div>
        <div class="card-content">
            <div class="form-grid">
                <div class="form-group">
                    <label for="phone" class="form-label">
                        Phone Number <span class="required">*</span>
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="phone" class="input-icon"></i>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            class="form-input" 
                            value="<?php echo htmlspecialchars($data['patient']->phone); ?>"
                            placeholder="+1 (555) 000-0000"
                            required
                        >
                    </div>
                    <span class="form-helper">Primary contact number</span>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        Email Address
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="mail" class="input-icon"></i>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-input" 
                            value="<?php echo htmlspecialchars($data['patient']->email); ?>"
                            placeholder="patient@example.com"
                        >
                    </div>
                    <span class="form-helper">For appointment reminders</span>
                </div>
                
                <div class="form-group full-width">
                    <label for="address" class="form-label">
                        Home Address
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="map-pin" class="input-icon"></i>
                        <textarea 
                            name="address" 
                            id="address" 
                            class="form-textarea" 
                            rows="3"
                            placeholder="Street address, city, state, zip code"
                        ><?php echo htmlspecialchars($data['patient']->address); ?></textarea>
                    </div>
                    <span class="form-helper">Full residential address</span>
                </div>
                
                <div class="form-group">
                    <label for="emergency_contact_name" class="form-label">
                        Emergency Contact Name
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="user-check" class="input-icon"></i>
                        <input 
                            type="text" 
                            name="emergency_contact_name" 
                            id="emergency_contact_name" 
                            class="form-input" 
                            value="<?php echo htmlspecialchars($data['patient']->emergency_contact_name); ?>"
                            placeholder="Full name"
                        >
                    </div>
                    <span class="form-helper">Person to contact in emergency</span>
                </div>
                
                <div class="form-group">
                    <label for="emergency_contact_phone" class="form-label">
                        Emergency Contact Phone
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="phone-call" class="input-icon"></i>
                        <input 
                            type="tel" 
                            name="emergency_contact_phone" 
                            id="emergency_contact_phone" 
                            class="form-input" 
                            value="<?php echo htmlspecialchars($data['patient']->emergency_contact_phone); ?>"
                            placeholder="+1 (555) 000-0000"
                        >
                    </div>
                    <span class="form-helper">Emergency contact number</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Information Section -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-content">
                <h2 class="card-title">
                    <i data-lucide="heart-pulse" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 0.5rem;"></i>
                    Medical Information
                </h2>
                <p class="card-description">Update health records and medical history</p>
            </div>
        </div>
        <div class="card-content">
            <div class="form-grid">
                <div class="form-group">
                    <label for="blood_type" class="form-label">
                        Blood Type
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="droplet" class="input-icon"></i>
                        <select name="blood_type" id="blood_type" class="form-select">
                            <option value="">Select blood type</option>
                            <option value="A+" <?php echo $data['patient']->blood_type == 'A+' ? 'selected' : ''; ?>>A+ (A Positive)</option>
                            <option value="A-" <?php echo $data['patient']->blood_type == 'A-' ? 'selected' : ''; ?>>A- (A Negative)</option>
                            <option value="B+" <?php echo $data['patient']->blood_type == 'B+' ? 'selected' : ''; ?>>B+ (B Positive)</option>
                            <option value="B-" <?php echo $data['patient']->blood_type == 'B-' ? 'selected' : ''; ?>>B- (B Negative)</option>
                            <option value="AB+" <?php echo $data['patient']->blood_type == 'AB+' ? 'selected' : ''; ?>>AB+ (AB Positive)</option>
                            <option value="AB-" <?php echo $data['patient']->blood_type == 'AB-' ? 'selected' : ''; ?>>AB- (AB Negative)</option>
                            <option value="O+" <?php echo $data['patient']->blood_type == 'O+' ? 'selected' : ''; ?>>O+ (O Positive)</option>
                            <option value="O-" <?php echo $data['patient']->blood_type == 'O-' ? 'selected' : ''; ?>>O- (O Negative)</option>
                        </select>
                    </div>
                    <span class="form-helper">Patient's blood type if known</span>
                </div>
                
                <div class="form-group full-width">
                    <label for="allergies" class="form-label">
                        Known Allergies
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="alert-circle" class="input-icon"></i>
                        <textarea 
                            name="allergies" 
                            id="allergies" 
                            class="form-textarea" 
                            rows="3"
                            placeholder="List any known allergies (medications, food, environmental, etc.)"
                        ><?php echo htmlspecialchars($data['patient']->allergies); ?></textarea>
                    </div>
                    <span class="form-helper">Important for treatment planning</span>
                </div>
                
                <div class="form-group full-width">
                    <label for="medical_conditions" class="form-label">
                        Medical Conditions
                    </label>
                    <div class="input-with-icon">
                        <i data-lucide="activity" class="input-icon"></i>
                        <textarea 
                            name="medical_conditions" 
                            id="medical_conditions" 
                            class="form-textarea" 
                            rows="3"
                            placeholder="List any chronic conditions, diseases, or ongoing treatments"
                        ><?php echo htmlspecialchars($data['patient']->medical_conditions); ?></textarea>
                    </div>
                    <span class="form-helper">Existing health conditions</span>
                </div>
            </div>
            
            <!-- Warning Alert -->
            <div class="alert alert-warning" style="margin-top: 1.5rem;">
                <i data-lucide="alert-triangle" class="alert-icon"></i>
                <div>
                    <strong>Important:</strong> Changes to medical information will be recorded in the patient's history. Ensure all updates are accurate.
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-actions">
        <div class="form-actions-left">
            <button type="button" class="btn btn-ghost" onclick="window.history.back()">
                <i data-lucide="x"></i>
                Cancel
            </button>
        </div>
        <div class="form-actions-right">
            <button type="reset" class="btn btn-outline">
                <i data-lucide="rotate-ccw"></i>
                Reset Changes
            </button>
            <button type="submit" class="btn btn-primary btn-lg">
                <i data-lucide="save"></i>
                Save Changes
            </button>
        </div>
    </div>
</form>

<?php require_once '../app/views/layouts/footer.php'; ?>
