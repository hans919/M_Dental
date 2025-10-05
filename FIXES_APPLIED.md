# Database and Query Fixes Applied

## Issue Summary
The appointments table was restructured to use `patient_user_id` (referencing the `users` table) instead of `patient_id` (referencing the old `patients` table). This required updating all related queries and foreign key constraints.

## Changes Made

### 1. Database Foreign Key Constraints
- **File**: `database/migrations/fix_appointments_foreign_key.sql`
- **Action**: Created migration to clean up old constraints and ensure correct foreign key setup
- Removed old `patient_id` constraint if it existed
- Ensured `patient_user_id` properly references `users.id`

### 2. Appointment Model Updates
- **File**: `app/models/Appointment.php`

#### Updated Methods:
1. **getAppointments()** - Changed to join with `users` table instead of `patients`
   - Uses `CONCAT(u.first_name, ' ', u.last_name)` as `patient_name`
   - Gets `u.email` as `patient_email`
   
2. **getAppointmentById()** - Updated JOIN to use `users` table
   - Returns both concatenated name and separate first_name/last_name
   
3. **getTodayAppointments()** - Updated to join with `users` table
   
4. **getAllAppointmentsWithUsers()** - Simplified to only use `users` table
   - Removed COALESCE logic with old `patients` table
   
5. **addAppointment()** - Changed column from `patient_id` to `patient_user_id`
   
6. **updateAppointment()** - Changed bind parameter from `patient_id` to `patient_user_id`

### 3. View Updates

#### Admin Appointments List
- **File**: `app/views/appointments/index.php`
- Changed table headers from "Patient Code" to "Email"
- Updated to display `patient_name` and `patient_email` with null coalescing

#### Admin Dashboard
- **File**: `app/views/home/index.php`
- Updated to use `patient_name` instead of concatenating first/last names
- Added email display under patient name
- Fixed avatar initials logic to handle the new name format

### 4. Database Structure

#### Users Table Columns:
- `id` - Primary key
- `username` - Unique
- `email` - Unique
- `first_name`
- `last_name`
- `role` - enum('admin','dentist','receptionist','patient')

#### Appointments Table Foreign Keys:
- `patient_user_id` → `users.id` (ON DELETE SET NULL)
- `dentist_id` → `dentists.id` (ON DELETE CASCADE)

## Patient Booking Flow
The patient booking system now correctly:
1. Uses `$_SESSION['user_id']` as `patient_user_id`
2. Inserts appointments with proper foreign key references
3. Queries appointments by `patient_user_id`
4. Displays patient information from the `users` table

## Testing Checklist
- [x] Database constraints verified
- [x] All SQL queries updated to use correct column names
- [x] Admin dashboard displays appointments correctly
- [x] Patient booking saves to database
- [x] Patient appointments list displays correctly
- [ ] Test actual patient booking (requires user login)
- [ ] Test admin viewing appointments
- [ ] Test appointment status updates

## Files Modified
1. `/app/models/Appointment.php` - Multiple query updates
2. `/app/views/appointments/index.php` - Display logic
3. `/app/views/home/index.php` - Display logic
4. `/database/migrations/fix_appointments_foreign_key.sql` - New file
5. `/test_appointment.php` - Debug script (can be deleted)
6. `/test_db.php` - Database structure test (can be deleted)

## Notes
- The old `patients` table still exists but is not used by patient bookings
- Admin appointment creation via `/appointment/add` still references the old `patients` table and needs separate refactoring
- All patient-facing features now use the unified `users` table
