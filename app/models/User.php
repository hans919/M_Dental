<?php

class User {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Login user
    public function login($username, $password) {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);
        $user = $this->db->single();
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }
    
    // Register user
    public function register($data) {
        $this->db->query("INSERT INTO users (username, password, email, role) 
                         VALUES (:username, :password, :email, :role)");
        
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':role', $data['role']);
        
        return $this->db->execute();
    }
    
    // Find user by username
    public function findUserByUsername($username) {
        $this->db->query("SELECT * FROM users WHERE username = :username");
        $this->db->bind(':username', $username);
        return $this->db->single();
    }
    
    // Alias for findUserByUsername
    public function findByUsername($username) {
        return $this->findUserByUsername($username);
    }
    
    // Create user
    public function create($data) {
        $this->db->query("INSERT INTO users (username, password, email, first_name, last_name, role) 
                         VALUES (:username, :password, :email, :first_name, :last_name, :role)");
        
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':role', $data['role']);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }
    
    // Get user by ID
    public function getUserById($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Get user profile (excludes sensitive data)
    public function getUserProfile($id) {
        $this->db->query("SELECT id, username, email, first_name, last_name, role, phone, created_at 
                         FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
    
    // Update user profile
    public function updateProfile($id, $data) {
        $this->db->query("UPDATE users 
                         SET first_name = :first_name,
                             last_name = :last_name,
                             email = :email,
                             phone = :phone
                         WHERE id = :id");
        
        $this->db->bind(':id', $id);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        
        return $this->db->execute();
    }
    
    // Update password
    public function updatePassword($id, $newPassword) {
        $this->db->query("UPDATE users SET password = :password WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->bind(':password', password_hash($newPassword, PASSWORD_DEFAULT));
        
        return $this->db->execute();
    }
    
    // Verify current password
    public function verifyPassword($id, $password) {
        $this->db->query("SELECT password FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        $user = $this->db->single();
        
        if ($user && password_verify($password, $user->password)) {
            return true;
        }
        return false;
    }
    
    // Check if email exists (excluding current user)
    public function emailExistsExcludingUser($email, $userId) {
        $this->db->query("SELECT id FROM users WHERE email = :email AND id != :user_id");
        $this->db->bind(':email', $email);
        $this->db->bind(':user_id', $userId);
        return $this->db->single() ? true : false;
    }
}
