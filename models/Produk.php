<?php

// ===========================================
// FILE: models/Produk.php
// ===========================================
class Produk {
    private $conn;
    private $table = 'produk';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT p.*, k.nama_kategori 
                  FROM " . $this->table . " p 
                  LEFT JOIN kategori k ON p.kategori_id = k.id 
                  ORDER BY p.nama_produk";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchByKode($kode) {
        $query = "SELECT * FROM " . $this->table . " WHERE kode_produk = :kode LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':kode', $kode);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (kode_produk, nama_produk, kategori_id, harga, stok) 
                  VALUES (:kode_produk, :nama_produk, :kategori_id, :harga, :stok)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':kode_produk', $data['kode_produk']);
        $stmt->bindParam(':nama_produk', $data['nama_produk']);
        $stmt->bindParam(':kategori_id', $data['kategori_id']);
        $stmt->bindParam(':harga', $data['harga']);
        $stmt->bindParam(':stok', $data['stok']);
        
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET kode_produk = :kode_produk, nama_produk = :nama_produk, 
                      kategori_id = :kategori_id, harga = :harga, stok = :stok 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':kode_produk', $data['kode_produk']);
        $stmt->bindParam(':nama_produk', $data['nama_produk']);
        $stmt->bindParam(':kategori_id', $data['kategori_id']);
        $stmt->bindParam(':harga', $data['harga']);
        $stmt->bindParam(':stok', $data['stok']);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function updateStok($id, $jumlah, $operation = 'subtract') {
        if ($operation == 'subtract') {
            $query = "UPDATE " . $this->table . " SET stok = stok - :jumlah WHERE id = :id";
        } else {
            $query = "UPDATE " . $this->table . " SET stok = stok + :jumlah WHERE id = :id";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':jumlah', $jumlah);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
