-- Migration: Add user_id column to patients table
-- Date: 2025-10-05
-- Description: Add user_id foreign key to link patients to user accounts

USE dental_clinic;

-- Add user_id column to patients table
ALTER TABLE patients 
ADD COLUMN user_id INT NULL AFTER id,
ADD CONSTRAINT fk_patients_user_id 
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL;

-- Add index for better performance
CREATE INDEX idx_patients_user_id ON patients(user_id);

-- Note: Existing patients will have NULL user_id (they were added manually)
-- New patient registrations should link to their user account
