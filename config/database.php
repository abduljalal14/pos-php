<?php
/*
STRUKTUR FOLDER APLIKASI POS:

pos_kasir/
│
├── config/
│   └── database.php          # Konfigurasi database
│
├── controllers/
│   ├── AuthController.php    # Controller autentikasi
│   ├── DashboardController.php
│   ├── ProdukController.php
│   ├── KategoriController.php
│   ├── TransaksiController.php
│   └── UserController.php
│
├── models/
│   ├── User.php
│   ├── Produk.php
│   ├── Kategori.php
│   └── Transaksi.php
│
├── views/
│   ├── auth/
│   │   └── login.php
│   ├── dashboard/
│   │   └── index.php
│   ├── produk/
│   │   ├── index.php
│   │   └── form.php
│   ├── kategori/
│   │   ├── index.php
│   │   └── form.php
│   ├── transaksi/
│   │   ├── kasir.php
│   │   └── laporan.php
│   ├── user/
│   │   ├── index.php
│   │   └── form.php
│   └── layouts/
│       ├── header.php
│       └── footer.php
│
├── public/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── script.js
│
├── .htaccess                 # URL rewriting
└── index.php                 # Entry point
*/

// ===========================================
// FILE: config/database.php
// ===========================================
class Database {
    private $host = 'localhost';
    private $db_name = 'pos_kasir';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>