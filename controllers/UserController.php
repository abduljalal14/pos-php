<?php
// ===========================================
// FILE: controllers/UserController.php
// ===========================================
class UserController {
    private $db;
    private $userModel;

    public function __construct() {
        AuthController::checkAuth();
        AuthController::checkRole(['admin']);
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
    }

    public function index() {
        $users = $this->userModel->getAll();
        include 'views/user/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'nama_lengkap' => $_POST['nama_lengkap'],
                'role' => $_POST['role']
            ];
            
            if ($this->userModel->create($data)) {
                $_SESSION['success'] = 'User berhasil ditambahkan!';
            } else {
                $_SESSION['error'] = 'Gagal menambahkan user!';
            }
            header("Location: index.php?page=user");
            exit();
        }
        
        $action = 'create';
        include 'views/user/form.php';
    }

    public function edit() {
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'nama_lengkap' => $_POST['nama_lengkap'],
                'role' => $_POST['role']
            ];
            
            if ($this->userModel->update($id, $data)) {
                $_SESSION['success'] = 'User berhasil diupdate!';
            } else {
                $_SESSION['error'] = 'Gagal mengupdate user!';
            }
            header("Location: index.php?page=user");
            exit();
        }
        
        $user = $this->userModel->getById($id);
        $action = 'edit';
        include 'views/user/form.php';
    }

    public function delete() {
        $id = $_GET['id'];
        
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'Tidak dapat menghapus user yang sedang login!';
        } else {
            if ($this->userModel->delete($id)) {
                $_SESSION['success'] = 'User berhasil dihapus!';
            } else {
                $_SESSION['error'] = 'Gagal menghapus user!';
            }
        }
        header("Location: index.php?page=user");
        exit();
    }
}
?>