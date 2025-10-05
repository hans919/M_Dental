-- Migration to add first_name and last_name columns to users table
-- Run this file if you already have the database created

USE dental_clinic;

-- Add first_name and last_name columns if they don't exist
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS first_name VARCHAR(50) AFTER email,
ADD COLUMN IF NOT EXISTS last_name VARCHAR(50) AFTER first_name;

-- Modify role enum to include 'patient' role
ALTER TABLE users 
MODIFY COLUMN role ENUM('admin', 'dentist', 'receptionist', 'patient') DEFAULT 'patient';

-- Update existing users with NULL role to 'patient'
UPDATE users 
SET role = 'patient' 
WHERE role IS NULL OR role = '';

-- Update existing admin user to have first_name and last_name
UPDATE users 
SET first_name = 'Admin', last_name = 'User' 
WHERE username = 'admin' AND first_name IS NULL;
