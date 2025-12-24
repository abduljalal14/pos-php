<?php
// ===========================================
// FILE: controllers/DashboardController.php
// ===========================================
class DashboardController {
    private $db;

    public function __construct() {
        AuthController::checkAuth();
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        $stats = $this->getStatistics();
        include 'views/dashboard/index.php';
    }

    private function getStatistics() {
        $stats = [];
        
        $query = "SELECT COUNT(*) as total FROM produk";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['total_produk'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $query = "SELECT COUNT(*) as total FROM transaksi WHERE DATE(tanggal) = CURDATE()";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['transaksi_hari_ini'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $query = "SELECT COALESCE(SUM(total), 0) as total FROM transaksi WHERE DATE(tanggal) = CURDATE()";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['pendapatan_hari_ini'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $query = "SELECT COUNT(*) as total FROM produk WHERE stok < 10";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $stats['produk_stok_rendah'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return $stats;
    }
}
