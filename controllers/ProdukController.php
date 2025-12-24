<?php
// ===========================================
// FILE: controllers/ProdukController.php
// ===========================================
class ProdukController {
    private $db;
    private $produkModel;
    private $kategoriModel;

    public function __construct() {
        AuthController::checkAuth();
        AuthController::checkRole(['admin']);
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->produkModel = new Produk($this->db);
        $this->kategoriModel = new Kategori($this->db);
    }

    public function index() {
        $produk = $this->produkModel->getAll();
        include 'views/produk/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'kode_produk' => $_POST['kode_produk'],
                'nama_produk' => $_POST['nama_produk'],
                'kategori_id' => $_POST['kategori_id'],
                'harga' => $_POST['harga'],
                'stok' => $_POST['stok']
            ];
            
            if ($this->produkModel->create($data)) {
                $_SESSION['success'] = 'Produk berhasil ditambahkan!';
            } else {
                $_SESSION['error'] = 'Gagal menambahkan produk!';
            }
            header("Location: index.php?page=produk");
            exit();
        }
        
        $kategori = $this->kategoriModel->getAll();
        $action = 'create';
        include 'views/produk/form.php';
    }

    public function edit() {
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'kode_produk' => $_POST['kode_produk'],
                'nama_produk' => $_POST['nama_produk'],
                'kategori_id' => $_POST['kategori_id'],
                'harga' => $_POST['harga'],
                'stok' => $_POST['stok']
            ];
            
            if ($this->produkModel->update($id, $data)) {
                $_SESSION['success'] = 'Produk berhasil diupdate!';
            } else {
                $_SESSION['error'] = 'Gagal mengupdate produk!';
            }
            header("Location: index.php?page=produk");
            exit();
        }
        
        $produk = $this->produkModel->getById($id);
        $kategori = $this->kategoriModel->getAll();
        $action = 'edit';
        include 'views/produk/form.php';
    }

    public function delete() {
        $id = $_GET['id'];
        
        if ($this->produkModel->delete($id)) {
            $_SESSION['success'] = 'Produk berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus produk!';
        }
        header("Location: index.php?page=produk");
        exit();
    }
}
