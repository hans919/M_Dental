-- Migration: Add phone column to users table
-- Date: 2025-10-05
-- Description: Add phone field to users table for profile management

USE dental_clinic;

-- Add phone column to users table
ALTER TABLE users 
ADD COLUMN phone VARCHAR(20) NULL AFTER email;

-- Update existing users with NULL phone numbers (they can update later)
UPDATE users SET phone = NULL WHERE phone IS NULL;
