<?php
// ===========================================
// FILE: controllers/TransaksiController.php
// ===========================================
class TransaksiController {
    private $db;
    private $transaksiModel;
    private $produkModel;

    public function __construct() {
        AuthController::checkAuth();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->transaksiModel = new Transaksi($this->db);
        $this->produkModel = new Produk($this->db);
    }

    public function kasir() {
        $produk = $this->produkModel->getAll();
        include 'views/transaksi/kasir.php';
    }

    public function cariProduk() {
        if (isset($_POST['kode_produk'])) {
            $kode = $_POST['kode_produk'];
            $produk = $this->produkModel->searchByKode($kode);
            
            header('Content-Type: application/json');
            echo json_encode($produk);
            exit();
        }
    }

    public function simpanTransaksi() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'kode_transaksi' => $this->transaksiModel->generateKode(),
                'user_id' => $_SESSION['user_id'],
                'total' => $_POST['total'],
                'bayar' => $_POST['bayar'],
                'kembalian' => $_POST['kembalian'],
                'items' => json_decode($_POST['items'], true)
            ];
            
            $result = $this->transaksiModel->create($data);
            
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Transaksi berhasil disimpan',
                    'kode_transaksi' => $data['kode_transaksi']
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal menyimpan transaksi'
                ]);
            }
            exit();
        }
    }

    public function laporan() {
        AuthController::checkRole(['admin']);
        
        $tanggal_awal = isset($_GET['tanggal_awal']) ? $_GET['tanggal_awal'] : date('Y-m-d');
        $tanggal_akhir = isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : date('Y-m-d');
        
        $transaksi = $this->transaksiModel->getAll($tanggal_awal, $tanggal_akhir);
        
        include 'views/transaksi/laporan.php';
    }

    public function detail() {
        $id = $_GET['id'];
        $transaksi = $this->transaksiModel->getById($id);
        $detail = $this->transaksiModel->getDetail($id);
        
        include 'views/transaksi/detail.php';
    }
}
