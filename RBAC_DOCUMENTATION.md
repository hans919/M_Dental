# Role-Based Access Control (RBAC) Implementation

## Overview
This system implements RBAC to separate patient and staff access throughout the application.

## Roles

### 1. **admin**
- Full system access
- Access: Admin Dashboard (/home)
- Can manage: Patients, Dentists, Appointments, All Records

### 2. **dentist**
- Staff member access
- Access: Admin Dashboard (/home)
- Can manage: Appointments, Patient Records, View Patients

### 3. **receptionist**
- Front desk access
- Access: Admin Dashboard (/home)
- Can manage: Appointments, Patients (view/add)

### 4. **patient**
- Patient portal access
- Access: Patient Dashboard (/patient_dashboard)
- Can: View own appointments, Book appointments, View own records, Manage profile

## RBAC Methods (in Controller.php)

### Authentication Methods
```php
$this->requireAuth()           // Require login
$this->isLoggedIn()           // Check if logged in
```

### Role Checking Methods
```php
$this->hasRole('patient')                    // Check single role
$this->hasRole(['admin', 'dentist'])        // Check multiple roles
$this->requireRole('admin')                 // Require specific role(s)
```

### Helper Methods
```php
$this->isAdmin()     // Check if admin
$this->isPatient()   // Check if patient
$this->isStaff()     // Check if staff (admin/dentist/receptionist)
```

## Controller Protection

### Admin Controllers (Staff Only)
```php
class HomeController extends Controller {
    public function __construct() {
        $this->requireRole(['admin', 'dentist', 'receptionist']);
    }
}
```

**Protected Controllers:**
- `HomeController` - Admin dashboard
- `PatientController` - Patient management (admin side)
- `DentistController` - Dentist management
- `AppointmentController` - Appointment management (admin side)

### Patient Controllers
```php
class PatientDashboardController extends Controller {
    public function __construct() {
        $this->requireRole('patient');
    }
}
```

**Protected Controllers:**
- `PatientDashboardController` - Patient dashboard and actions

### Public Controllers
**No Role Required:**
- `LandingController` - Public website
- `AuthController` - Login/Register

## Automatic Redirects

### When User Tries to Access Wrong Area:
```
Patient tries to access /home → Redirects to /patient_dashboard
Admin tries to access /patient_dashboard → Redirects to /home
Non-logged user → Redirects to /auth/login
```

### Login Redirects:
```php
// After successful login:
if (role === 'patient') {
    redirect('/patient_dashboard')
} else {
    redirect('/home')  // admin, dentist, receptionist
}
```

## Session Variables

After login, these are stored in session:
```php
$_SESSION['user_id']      // User ID
$_SESSION['username']     // Username
$_SESSION['email']        // Email
$_SESSION['first_name']   // First Name
$_SESSION['last_name']    // Last Name
$_SESSION['role']         // User Role
```

## Database Setup

### Users Table Structure
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    role ENUM('admin', 'dentist', 'receptionist', 'patient') DEFAULT 'patient',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Default Accounts

**Admin Account:**
- Username: `admin`
- Password: `admin123`
- Role: `admin`
- Access: Full admin dashboard

**Patient Account (after registration):**
- Role: `patient` (automatically assigned)
- Access: Patient dashboard only

## Access Matrix

| Feature | Admin | Dentist | Receptionist | Patient |
|---------|-------|---------|--------------|---------|
| Admin Dashboard | ✅ | ✅ | ✅ | ❌ |
| Patient Dashboard | ❌ | ❌ | ❌ | ✅ |
| Manage Patients | ✅ | ✅ | ✅ | ❌ |
| Manage Dentists | ✅ | ❌ | ❌ | ❌ |
| Manage Appointments | ✅ | ✅ | ✅ | ❌ |
| View Medical Records | ✅ | ✅ | ✅ | Own Only |
| Book Appointment | ❌ | ❌ | ❌ | ✅ |
| View Own Profile | ✅ | ✅ | ✅ | ✅ |

## Usage Examples

### Example 1: Protect Admin-Only Action
```php
public function deletePatient($id) {
    // Only admins can delete
    if (!$this->isAdmin()) {
        $this->redirect('home');
    }
    
    // Delete logic...
}
```

### Example 2: Check Multiple Roles
```php
public function viewMedicalRecord($id) {
    // Staff can view all records, patients only their own
    if ($this->isStaff()) {
        // Show any record
    } elseif ($this->isPatient()) {
        // Show only if record belongs to patient
        if ($record->patient_id !== $_SESSION['user_id']) {
            $this->redirect('patient_dashboard');
        }
    }
}
```

### Example 3: Dynamic Navigation
```php
// In view:
<?php if ($this->isStaff()): ?>
    <a href="/home">Admin Dashboard</a>
<?php elseif ($this->isPatient()): ?>
    <a href="/patient_dashboard">My Dashboard</a>
<?php endif; ?>
```

## Testing RBAC

### Test Admin Access:
1. Login as: `admin` / `admin123`
2. Should access: `/home` (Admin Dashboard)
3. Try accessing: `/patient_dashboard` → Should redirect to `/home`

### Test Patient Access:
1. Register new account at: `/auth/register`
2. Should auto-login and redirect to: `/patient_dashboard`
3. Try accessing: `/home` → Should redirect to `/patient_dashboard`

### Test Role Switching:
```sql
-- Change user role in database
UPDATE users SET role = 'admin' WHERE username = 'test123';
-- Then logout and login again to see admin dashboard
```

## Security Notes

1. **Always check role in constructor** of protected controllers
2. **Session variables are set** during login/registration
3. **Role is stored in database** - session is just a cache
4. **Logout clears all session data** - prevents role persistence
5. **Database enum enforces** only valid roles can be stored

## Future Enhancements

- [ ] Permission-based access (more granular than roles)
- [ ] Role hierarchy (admin inherits all permissions)
- [ ] Activity logging (who accessed what and when)
- [ ] Multi-factor authentication for admin
- [ ] Password reset functionality
- [ ] Account lockout after failed attempts
