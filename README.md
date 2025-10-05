# 🦷 DentalCare Clinic Management System

<div align="center">

![Dental Clinic](https://img.shields.io/badge/Healthcare-Dental%20Clinic-blue?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**A comprehensive web-based dental clinic management system built with PHP MVC architecture**

[Features](#-features) • [Installation](#-installation) • [Usage](#-usage) • [Documentation](#-documentation) • [Screenshots](#-screenshots)

</div>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Usage](#-usage)
- [User Roles](#-user-roles)
- [Project Structure](#-project-structure)
- [Database Schema](#-database-schema)
- [Screenshots](#-screenshots)
- [Documentation](#-documentation)
- [Contributing](#-contributing)
- [License](#-license)

---

## 🎯 Overview

**DentalCare Clinic Management System** is a modern, full-featured web application designed to streamline dental clinic operations. Built with a custom PHP MVC framework, it provides comprehensive tools for managing patients, appointments, dentists, and medical records.

### Why This System?

- ✅ **Modern UI/UX** - Clean, responsive interface with smooth animations
- ✅ **Role-Based Access Control (RBAC)** - Secure multi-user system
- ✅ **Patient Portal** - Dedicated interface for patient self-service
- ✅ **Admin Dashboard** - Comprehensive management tools
- ✅ **Appointment Management** - Smart scheduling system
- ✅ **Medical Records** - Complete patient history tracking

---

## ✨ Features

### 👨‍⚕️ Admin & Staff Features

- **Dashboard Analytics**
  - Real-time statistics and metrics
  - Patient growth charts
  - Appointment overview
  - Quick action buttons

- **Patient Management**
  - Complete patient profiles
  - Medical history tracking
  - Emergency contacts
  - Blood type & allergies tracking
  - Advanced search & filtering
  - Bulk operations support

- **Appointment System**
  - Calendar-based scheduling
  - Status management (Scheduled, Confirmed, Completed, Cancelled, No-show)
  - Conflict prevention
  - Appointment history
  - Real-time updates

- **Dentist Management**
  - Dentist profiles
  - Specialization tracking
  - License information
  - Contact details
  - Schedule management

- **User Account Integration**
  - Unified view of patient records and registered users
  - Automatic linking between user accounts and patient profiles
  - Dual-source patient listing

### 👤 Patient Portal Features

- **Modern Landing Page**
  - Eye-catching hero section
  - Service showcase
  - About us section
  - Contact form
  - Responsive design

- **Personal Dashboard**
  - View upcoming appointments
  - Book new appointments
  - Access medical records
  - View treatment history
  - Manage profile information

- **Profile Management**
  - Update personal information
  - Change contact details
  - Manage email & phone
  - Secure account settings

- **Medical Records Access**
  - View diagnosis history
  - Treatment records
  - Prescription information
  - Download capabilities (coming soon)

### 🔐 Security Features

- **Role-Based Access Control (RBAC)**
  - Admin, Dentist, Receptionist, Patient roles
  - Protected routes
  - Permission-based access

- **Secure Authentication**
  - Password hashing (bcrypt)
  - Session management
  - CSRF protection ready
  - XSS prevention

- **Data Protection**
  - Prepared SQL statements
  - Input sanitization
  - Output escaping
  - Secure password storage

---

## 🛠 Tech Stack

### Backend
- **PHP 7.4+** - Core language
- **Custom MVC Framework** - Clean architecture
- **MySQL 8.0+** - Database management
- **PDO** - Database abstraction

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling with CSS variables
- **Vanilla JavaScript** - Interactive features
- **Lucide Icons** - Beautiful icon system
- **Responsive Design** - Mobile-first approach

### Architecture
- **MVC Pattern** - Model-View-Controller separation
- **OOP** - Object-oriented programming
- **RESTful Routing** - Clean URL structure
- **Database Migrations** - Version-controlled schema

---

## 📥 Installation

### Prerequisites

- **XAMPP/WAMP/LAMP** (or similar) with:
  - PHP 7.4 or higher
  - MySQL 8.0 or higher
  - Apache Web Server
- **Git** (optional, for cloning)
- Modern web browser

### Step-by-Step Installation

1. **Clone or Download the Repository**
   ```bash
   git clone https://github.com/hans919/M_Dental.git
   cd M_Dental
   ```

2. **Move to Web Server Directory**
   ```bash
   # For XAMPP on Windows
   move M_Dental C:\xampp\htdocs\dl

   # For LAMP on Linux
   sudo mv M_Dental /var/www/html/dl
   ```

3. **Create Database**
   ```bash
   # Using MySQL command line
   mysql -u root -p
   ```
   
   ```sql
   CREATE DATABASE dental_clinic;
   EXIT;
   ```

4. **Import Database Schema**
   ```bash
   # Using command line
   mysql -u root dental_clinic < database.sql

   # Or use phpMyAdmin to import database.sql
   ```

5. **Run Database Migrations** (Optional - if not included in main SQL)
   ```bash
   mysql -u root dental_clinic < database/migrations/add_phone_to_users.sql
   mysql -u root dental_clinic < database/migrations/add_user_id_to_patients.sql
   ```

6. **Configure Application**
   
   Edit `config/config.php`:
   ```php
   // Database Configuration
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', ''); // Your MySQL password
   define('DB_NAME', 'dental_clinic');

   // App Configuration
   define('APP_URL', 'http://localhost/dl');
   define('APP_NAME', 'DentalCare Clinic');
   ```

7. **Set Permissions** (Linux/Mac only)
   ```bash
   chmod -R 755 /path/to/dl
   chown -R www-data:www-data /path/to/dl
   ```

8. **Start Web Server**
   - Start XAMPP/WAMP/LAMP
   - Start Apache and MySQL services

9. **Access the Application**
   ```
   http://localhost/dl/public
   ```

### Default Login Credentials

**Admin Account:**
- Username: `admin`
- Password: `admin123`

> ⚠️ **Important:** Change the default password after first login!

---

## ⚙️ Configuration

### Application Settings

Edit `config/config.php` to customize:

```php
// Application Settings
define('APP_NAME', 'DentalCare Clinic');
define('APP_URL', 'http://localhost/dl');
define('APP_ROOT', dirname(dirname(__FILE__)));

// Database Settings
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dental_clinic');

// Session Settings (optional)
define('SESSION_TIMEOUT', 3600); // 1 hour
```

### Environment Setup

For production deployment:
1. Change `DB_PASS` to a secure password
2. Update `APP_URL` to your domain
3. Enable HTTPS
4. Set proper file permissions
5. Disable error display
6. Enable PHP OPcache

---

## 🚀 Usage

### For Administrators

1. **Login** to the admin panel at `/public/auth/login`
2. **Dashboard** - View clinic statistics and metrics
3. **Manage Patients** - Add, edit, view patient records
4. **Schedule Appointments** - Book and manage appointments
5. **Manage Dentists** - Add dentist profiles
6. **View Reports** - Access analytics and reports

### For Patients

1. **Register** at `/public/auth/register`
2. **Login** to access patient portal
3. **View Dashboard** - See upcoming appointments
4. **Book Appointments** - Schedule new visits
5. **View Records** - Access medical history
6. **Update Profile** - Manage personal information

---

## 👥 User Roles

### 🔴 Admin
- Full system access
- User management
- System configuration
- All CRUD operations
- Analytics & reports

### 🟡 Dentist
- View patient records
- Manage appointments
- Add medical records
- View schedule
- Update treatments

### 🟢 Receptionist
- Manage appointments
- Register patients
- View patient information
- Handle scheduling
- Print reports

### 🔵 Patient
- View own appointments
- Book appointments
- Access medical records
- Update profile
- View treatment history

---

## 📁 Project Structure

```
dl/
├── app/
│   ├── controllers/          # Application controllers
│   │   ├── AppointmentController.php
│   │   ├── AuthController.php
│   │   ├── DentistController.php
│   │   ├── HomeController.php
│   │   ├── LandingController.php
│   │   ├── PatientController.php
│   │   └── PatientDashboardController.php
│   ├── core/                 # Core framework files
│   │   ├── App.php          # Main application class
│   │   ├── Controller.php   # Base controller
│   │   └── Database.php     # Database handler
│   ├── models/              # Data models
│   │   ├── Appointment.php
│   │   ├── Dentist.php
│   │   ├── Patient.php
│   │   └── User.php
│   └── views/               # View templates
│       ├── appointments/
│       ├── auth/
│       ├── dentists/
│       ├── home/
│       ├── landing/
│       ├── layouts/
│       ├── patient_dashboard/
│       └── patients/
├── assets/
│   ├── css/                 # Stylesheets
│   │   ├── auth.css
│   │   ├── landing.css
│   │   ├── patient-dashboard.css
│   │   └── style.css
│   └── js/                  # JavaScript files
├── config/
│   └── config.php           # Configuration file
├── database/
│   ├── migrations/          # Database migrations
│   │   ├── add_phone_to_users.sql
│   │   └── add_user_id_to_patients.sql
│   ├── database.sql         # Main schema
│   └── database_migration.sql
├── public/
│   └── index.php           # Application entry point
├── .gitignore
├── README.md
└── LICENSE
```

---

## 🗄️ Database Schema

### Main Tables

#### Users Table
```sql
- id (PK)
- username
- password (hashed)
- email
- phone
- first_name
- last_name
- role (admin, dentist, receptionist, patient)
- created_at
- updated_at
```

#### Patients Table
```sql
- id (PK)
- user_id (FK to users)
- patient_code (unique)
- first_name
- last_name
- date_of_birth
- gender
- phone
- email
- address
- emergency_contact_name
- emergency_contact_phone
- blood_type
- allergies
- medical_conditions
- status
- created_at
- updated_at
```

#### Appointments Table
```sql
- id (PK)
- patient_id (FK to patients)
- dentist_id (FK to dentists)
- appointment_date
- appointment_time
- duration
- reason
- status
- notes
- created_at
- updated_at
```

#### Dentists Table
```sql
- id (PK)
- user_id (FK to users)
- first_name
- last_name
- specialization
- license_number
- phone
- email
- status
- created_at
- updated_at
```

#### Medical Records Table
```sql
- id (PK)
- patient_id (FK to patients)
- dentist_id (FK to dentists)
- appointment_id (FK to appointments)
- visit_date
- diagnosis
- treatment
- prescription
- notes
- created_at
- updated_at
```

### Entity Relationships

```
users (1) -----> (0..1) patients
users (1) -----> (0..1) dentists
patients (1) --> (N) appointments
dentists (1) --> (N) appointments
patients (1) --> (N) medical_records
dentists (1) --> (N) medical_records
appointments (1) --> (0..1) medical_records
```

---

## 📸 Screenshots

### Landing Page
Beautiful, modern landing page with service showcase and contact information.

### Admin Dashboard
Comprehensive dashboard with analytics, charts, and quick actions.

### Patient Management
Advanced patient list with search, filters, and bulk operations.

### Appointment Calendar
Intuitive appointment scheduling with calendar view.

### Patient Portal
Clean, user-friendly patient dashboard for self-service.

### Profile Management
Easy-to-use profile editing with validation.

---

## 📚 Documentation

Additional documentation files:

- **[RBAC_DOCUMENTATION.md](RBAC_DOCUMENTATION.md)** - Role-Based Access Control guide
- **[PATIENT_PAGES_IMPLEMENTATION.md](PATIENT_PAGES_IMPLEMENTATION.md)** - Patient portal implementation
- **[FIXES_APPLIED.md](FIXES_APPLIED.md)** - Bug fixes and updates log
- **[QUICK_FIX.md](QUICK_FIX.md)** - Quick troubleshooting guide

### API Endpoints

#### Authentication
```
POST /public/auth/login       - User login
POST /public/auth/register    - User registration
GET  /public/auth/logout      - User logout
```

#### Patient Dashboard
```
GET  /public/patient_dashboard              - Dashboard home
GET  /public/patient_dashboard/appointments - View appointments
GET  /public/patient_dashboard/book        - Book appointment
GET  /public/patient_dashboard/profile     - View/Edit profile
GET  /public/patient_dashboard/records     - View medical records
```

#### Admin Panel
```
GET  /public/home                          - Admin dashboard
GET  /public/patient                       - Patient list
GET  /public/patient/detail/:id            - Patient details
GET  /public/appointment                   - Appointment list
GET  /public/dentist                       - Dentist list
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/AmazingFeature
   ```
3. **Commit your changes**
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```
4. **Push to the branch**
   ```bash
   git push origin feature/AmazingFeature
   ```
5. **Open a Pull Request**

### Development Guidelines

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add comments for complex logic
- Test thoroughly before submitting
- Update documentation as needed

---

## 🐛 Bug Reports & Feature Requests

Found a bug or have a feature idea? Please open an issue!

**Bug Report Template:**
- Description of the bug
- Steps to reproduce
- Expected behavior
- Screenshots (if applicable)
- Environment details

**Feature Request Template:**
- Feature description
- Use case
- Proposed implementation
- Additional context

---

## 🔮 Future Enhancements

- [ ] SMS/Email notifications
- [ ] Online payment integration
- [ ] Telemedicine support
- [ ] Mobile application
- [ ] Advanced reporting & analytics
- [ ] Multi-language support
- [ ] Treatment plan management
- [ ] Insurance claim processing
- [ ] Document management system
- [ ] REST API for mobile apps
- [ ] Two-factor authentication
- [ ] Backup & restore functionality

---

## 📝 Changelog

### Version 1.0.0 (October 2025)
- ✅ Initial release
- ✅ Admin dashboard
- ✅ Patient management
- ✅ Appointment system
- ✅ Dentist management
- ✅ Patient portal
- ✅ RBAC implementation
- ✅ Landing page
- ✅ Profile management
- ✅ Medical records view

---

## 🙏 Acknowledgments

- **Lucide Icons** - Beautiful icon system
- **PHP Community** - Excellent documentation and support
- **Open Source Contributors** - For inspiration and learning

---

## 👨‍💻 Author

**Hans**
- GitHub: [@hans919](https://github.com/hans919)
- Repository: [M_Dental](https://github.com/hans919/M_Dental)

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

### MIT License Summary

```
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software.
```

---

## 💼 Support

Need help? Here are some ways to get support:

- 📖 Check the [Documentation](#-documentation)
- 🐛 Open an [Issue](https://github.com/hans919/M_Dental/issues)
- 💬 Start a [Discussion](https://github.com/hans919/M_Dental/discussions)

---

## ⭐ Show Your Support

If you find this project helpful, please consider giving it a star ⭐️

**Built with ❤️ for the dental community**

---

<div align="center">

### 🦷 Making Dental Clinic Management Easy and Efficient

**[Report Bug](https://github.com/hans919/M_Dental/issues)** • **[Request Feature](https://github.com/hans919/M_Dental/issues)** • **[View Demo](#)**

</div>

