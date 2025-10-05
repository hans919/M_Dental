-- Fix appointments table foreign key constraints
-- Drop old patient_id constraint if it exists
SET @constraint_name = (
    SELECT CONSTRAINT_NAME 
    FROM information_schema.KEY_COLUMN_USAGE 
    WHERE TABLE_SCHEMA = 'dental_clinic' 
    AND TABLE_NAME = 'appointments' 
    AND COLUMN_NAME = 'patient_id'
    AND REFERENCED_TABLE_NAME IS NOT NULL
);

SET @drop_stmt = IF(@constraint_name IS NOT NULL, 
    CONCAT('ALTER TABLE appointments DROP FOREIGN KEY ', @constraint_name),
    'SELECT "No old patient_id constraint to drop"'
);

PREPARE stmt FROM @drop_stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Drop old patient_id column if it exists
SET @column_exists = (
    SELECT COUNT(*) 
    FROM information_schema.COLUMNS 
    WHERE TABLE_SCHEMA = 'dental_clinic' 
    AND TABLE_NAME = 'appointments' 
    AND COLUMN_NAME = 'patient_id'
);

SET @drop_column = IF(@column_exists > 0,
    'ALTER TABLE appointments DROP COLUMN patient_id',
    'SELECT "No patient_id column to drop"'
);

PREPARE stmt FROM @drop_column;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Ensure patient_user_id constraint exists
SET @fk_exists = (
    SELECT COUNT(*) 
    FROM information_schema.KEY_COLUMN_USAGE 
    WHERE TABLE_SCHEMA = 'dental_clinic' 
    AND TABLE_NAME = 'appointments' 
    AND COLUMN_NAME = 'patient_user_id'
    AND REFERENCED_TABLE_NAME = 'users'
);

SET @add_fk = IF(@fk_exists = 0,
    'ALTER TABLE appointments ADD CONSTRAINT appointments_user_fk FOREIGN KEY (patient_user_id) REFERENCES users(id) ON DELETE SET NULL',
    'SELECT "Foreign key already exists"'
);

PREPARE stmt FROM @add_fk;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SELECT 'Migration completed successfully' as status;
