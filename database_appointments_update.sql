-- Update appointments table to include proper status workflow and patient user link
USE dental_clinic;

-- Add patient_user_id column to link with users table
ALTER TABLE appointments 
ADD COLUMN IF NOT EXISTS patient_user_id INT AFTER patient_id,
ADD FOREIGN KEY IF NOT EXISTS (patient_user_id) REFERENCES users(id) ON DELETE SET NULL;

-- Update status enum to include all workflow statuses
ALTER TABLE appointments 
MODIFY COLUMN status ENUM(
    'pending',
    'approved', 
    'confirmed',
    'rescheduled',
    'declined',
    'cancelled_by_patient',
    'cancelled_by_clinic',
    'completed',
    'no-show'
) DEFAULT 'pending';

-- Add additional tracking columns
ALTER TABLE appointments 
ADD COLUMN IF NOT EXISTS cancellation_reason TEXT AFTER notes,
ADD COLUMN IF NOT EXISTS cancelled_by INT AFTER cancellation_reason,
ADD COLUMN IF NOT EXISTS cancelled_at TIMESTAMP NULL AFTER cancelled_by,
ADD COLUMN IF NOT EXISTS old_appointment_date DATE NULL AFTER cancelled_at,
ADD COLUMN IF NOT EXISTS old_appointment_time TIME NULL AFTER old_appointment_date;

-- Update existing appointments to have 'approved' status if they're 'scheduled'
UPDATE appointments 
SET status = 'approved' 
WHERE status = 'scheduled';
