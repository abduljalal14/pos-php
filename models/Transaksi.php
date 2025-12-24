<?php
// ===========================================
// FILE: models/Transaksi.php
// ===========================================
class Transaksi {
    private $conn;
    private $table = 'transaksi';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function generateKode() {
        $date = date('Ymd');
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE DATE(tanggal) = CURDATE()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $nomor = str_pad($result['total'] + 1, 4, '0', STR_PAD_LEFT);
        return 'TRX' . $date . $nomor;
    }

    public function create($data) {
        try {
            $this->conn->beginTransaction();
            
            $query = "INSERT INTO " . $this->table . " 
                      (kode_transaksi, user_id, total, bayar, kembalian) 
                      VALUES (:kode_transaksi, :user_id, :total, :bayar, :kembalian)";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':kode_transaksi', $data['kode_transaksi']);
            $stmt->bindParam(':user_id', $data['user_id']);
            $stmt->bindParam(':total', $data['total']);
            $stmt->bindParam(':bayar', $data['bayar']);
            $stmt->bindParam(':kembalian', $data['kembalian']);
            
            $stmt->execute();
            $transaksi_id = $this->conn->lastInsertId();
            
            foreach ($data['items'] as $item) {
                $query_detail = "INSERT INTO detail_transaksi 
                                 (transaksi_id, produk_id, jumlah, harga, subtotal) 
                                 VALUES (:transaksi_id, :produk_id, :jumlah, :harga, :subtotal)";
                $stmt_detail = $this->conn->prepare($query_detail);
                
                $stmt_detail->bindParam(':transaksi_id', $transaksi_id);
                $stmt_detail->bindParam(':produk_id', $item['produk_id']);
                $stmt_detail->bindParam(':jumlah', $item['jumlah']);
                $stmt_detail->bindParam(':harga', $item['harga']);
                $stmt_detail->bindParam(':subtotal', $item['subtotal']);
                
                $stmt_detail->execute();
                
                $query_stok = "UPDATE produk SET stok = stok - :jumlah WHERE id = :produk_id";
                $stmt_stok = $this->conn->prepare($query_stok);
                $stmt_stok->bindParam(':jumlah', $item['jumlah']);
                $stmt_stok->bindParam(':produk_id', $item['produk_id']);
                $stmt_stok->execute();
            }
            
            $this->conn->commit();
            return $transaksi_id;
        } catch(Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getAll($tanggal_awal = null, $tanggal_akhir = null) {
        $query = "SELECT t.*, u.nama_lengkap 
                  FROM " . $this->table . " t 
                  LEFT JOIN users u ON t.user_id = u.id";
        
        if ($tanggal_awal && $tanggal_akhir) {
            $query .= " WHERE DATE(t.tanggal) BETWEEN :tanggal_awal AND :tanggal_akhir";
        }
        
        $query .= " ORDER BY t.tanggal DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if ($tanggal_awal && $tanggal_akhir) {
            $stmt->bindParam(':tanggal_awal', $tanggal_awal);
            $stmt->bindParam(':tanggal_akhir', $tanggal_akhir);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT t.*, u.nama_lengkap 
                  FROM " . $this->table . " t 
                  LEFT JOIN users u ON t.user_id = u.id 
                  WHERE t.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDetail($transaksi_id) {
        $query = "SELECT dt.*, p.nama_produk, p.kode_produk 
                  FROM detail_transaksi dt 
                  LEFT JOIN produk p ON dt.produk_id = p.id 
                  WHERE dt.transaksi_id = :transaksi_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':transaksi_id', $transaksi_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>