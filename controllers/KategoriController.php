<?php
// ===========================================
// FILE: controllers/KategoriController.php
// ===========================================
class KategoriController {
    private $db;
    private $kategoriModel;

    public function __construct() {
        AuthController::checkAuth();
        AuthController::checkRole(['admin']);
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->kategoriModel = new Kategori($this->db);
    }

    public function index() {
        $kategori = $this->kategoriModel->getAll();
        include 'views/kategori/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_kategori = $_POST['nama_kategori'];
            
            if ($this->kategoriModel->create($nama_kategori)) {
                $_SESSION['success'] = 'Kategori berhasil ditambahkan!';
            } else {
                $_SESSION['error'] = 'Gagal menambahkan kategori!';
            }
            header("Location: index.php?page=kategori");
            exit();
        }
        
        $action = 'create';
        include 'views/kategori/form.php';
    }

    public function edit() {
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_kategori = $_POST['nama_kategori'];
            
            if ($this->kategoriModel->update($id, $nama_kategori)) {
                $_SESSION['success'] = 'Kategori berhasil diupdate!';
            } else {
                $_SESSION['error'] = 'Gagal mengupdate kategori!';
            }
            header("Location: index.php?page=kategori");
            exit();
        }
        
        $kategori = $this->kategoriModel->getById($id);
        $action = 'edit';
        include 'views/kategori/form.php';
    }

    public function delete() {
        $id = $_GET['id'];
        
        if ($this->kategoriModel->delete($id)) {
            $_SESSION['success'] = 'Kategori berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus kategori!';
        }
        header("Location: index.php?page=kategori");
        exit();
    }
}
?>