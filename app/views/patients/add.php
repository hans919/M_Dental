<?php require_once '../app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-title">
            <div class="page-icon">
                <i data-lucide="user-plus"></i>
            </div>
            <div>
                <h1>Add New Patient</h1>
                <p class="page-subtitle">Create a new patient profile in the system</p>
            </div>
        </div>
        <div class="page-header-actions">
            <a href="<?php echo APP_URL; ?>/public/patient" class="btn btn-outline">
                <i data-lucide="arrow-left"></i>
                Back to List
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
    <div class="form-step">
        <div class="form-step-number">2</div>
        <div class="form-step-label">Contact Details</div>
    </div>
    <div class="form-step-line"></div>
    <div class="form-step">
        <div class="form-step-number">3</div>
        <div class="form-step-label">Medical Info</div>
    </div>
</div>

<form method="POST" action="<?php echo APP_URL; ?>/public/patient/add" class="form-container">
    <!-- Personal Information Section -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-content">
                <h2 class="card-title">
                    <i data-lucide="user" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 0.5rem;"></i>
                    Personal Information
                </h2>
                <p class="card-description">Basic patient details and identification</p>
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
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <span class="form-helper">Patient's biological gender</span>
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
                <p class="card-description">How to reach the patient</p>
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
                        ></textarea>
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
                <p class="card-description">Health records and medical history</p>
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
                            <option value="A+">A+ (A Positive)</option>
                            <option value="A-">A- (A Negative)</option>
                            <option value="B+">B+ (B Positive)</option>
                            <option value="B-">B- (B Negative)</option>
                            <option value="AB+">AB+ (AB Positive)</option>
                            <option value="AB-">AB- (AB Negative)</option>
                            <option value="O+">O+ (O Positive)</option>
                            <option value="O-">O- (O Negative)</option>
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
                        ></textarea>
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
                        ></textarea>
                    </div>
                    <span class="form-helper">Existing health conditions</span>
                </div>
            </div>
            
            <!-- Info Alert -->
            <div class="alert alert-info" style="margin-top: 1.5rem;">
                <i data-lucide="info" class="alert-icon"></i>
                <div>
                    <strong>Privacy Notice:</strong> All medical information is stored securely and only accessible to authorized medical staff.
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
                Reset Form
            </button>
            <button type="submit" class="btn btn-primary btn-lg">
                <i data-lucide="check"></i>
                Create Patient
            </button>
        </div>
    </div>
</form>

<?php require_once '../app/views/layouts/footer.php'; ?>
