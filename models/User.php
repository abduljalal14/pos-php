<?php
// ===========================================
// FILE: models/User.php
// ===========================================
class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getAll() {
        $query = "SELECT id, username, nama_lengkap, role, created_at FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT id, username, nama_lengkap, role FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (username, password, nama_lengkap, role) 
                  VALUES (:username, :password, :nama_lengkap, :role)";
        $stmt = $this->conn->prepare($query);
        
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':role', $data['role']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        if (!empty($data['password'])) {
            $query = "UPDATE " . $this->table . " 
                      SET username = :username, password = :password, 
                          nama_lengkap = :nama_lengkap, role = :role 
                      WHERE id = :id";
            $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            $query = "UPDATE " . $this->table . " 
                      SET username = :username, nama_lengkap = :nama_lengkap, role = :role 
                      WHERE id = :id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':id', $id);
        
        if (!empty($data['password'])) {
            $stmt->bindParam(':password', $password_hash);
        }
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
