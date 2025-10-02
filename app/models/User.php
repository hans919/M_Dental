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
}
