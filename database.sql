-- Dental Clinic Database
CREATE DATABASE IF NOT EXISTS dental_clinic;
USE dental_clinic;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    role ENUM('admin', 'dentist', 'receptionist', 'patient') DEFAULT 'patient',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Dentists table (profiles)
CREATE TABLE IF NOT EXISTS dentists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    specialization VARCHAR(100),
    license_number VARCHAR(50) UNIQUE,
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    profile_photo VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Patients table (profiles)
CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_code VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    address TEXT,
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    blood_type VARCHAR(5),
    allergies TEXT,
    medical_conditions TEXT,
    profile_photo VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Appointments table
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    dentist_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    duration INT DEFAULT 30,
    reason TEXT,
    status ENUM('scheduled', 'confirmed', 'completed', 'cancelled', 'no-show') DEFAULT 'scheduled',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (dentist_id) REFERENCES dentists(id) ON DELETE CASCADE
);

-- Medical Records table
CREATE TABLE IF NOT EXISTS medical_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    dentist_id INT NOT NULL,
    appointment_id INT,
    visit_date DATE NOT NULL,
    diagnosis TEXT,
    treatment TEXT,
    prescription TEXT,
    notes TEXT,
    tooth_chart TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (dentist_id) REFERENCES dentists(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL
);

-- Insert default admin user (password: admin123)
-- If this doesn't work, run: UPDATE users SET password = '$2y$10$rGHQyLPZOyOmXEqb2j3LheJlOmBhkIBqKvFxPCLKLw6WQxvZKlQci' WHERE username = 'admin';
INSERT INTO users (username, password, email, role) VALUES 
('admin', '$2y$10$rGHQyLPZOyOmXEqb2j3LheJlOmBhkIBqKvFxPCLKLw6WQxvZKlQci', 'admin@dentalclinic.com', 'admin')
ON DUPLICATE KEY UPDATE password = '$2y$10$rGHQyLPZOyOmXEqb2j3LheJlOmBhkIBqKvFxPCLKLw6WQxvZKlQci';

-- Insert sample dentist
INSERT INTO dentists (first_name, last_name, specialization, license_number, phone, email, gender) VALUES
('Dr. John', 'Smith', 'General Dentistry', 'DEN-2024-001', '555-0101', 'drsmith@dentalclinic.com', 'male'),
('Dr. Sarah', 'Johnson', 'Orthodontics', 'DEN-2024-002', '555-0102', 'drjohnson@dentalclinic.com', 'female');

-- Insert sample patients
INSERT INTO patients (patient_code, first_name, last_name, date_of_birth, gender, phone, email, address) VALUES
('PAT-2024-001', 'Michael', 'Brown', '1985-03-15', 'male', '555-0201', 'mbrown@email.com', '123 Main St, City'),
('PAT-2024-002', 'Emily', 'Davis', '1990-07-22', 'female', '555-0202', 'edavis@email.com', '456 Oak Ave, City'),
('PAT-2024-003', 'Robert', 'Wilson', '1978-11-30', 'male', '555-0203', 'rwilson@email.com', '789 Pine Rd, City');
