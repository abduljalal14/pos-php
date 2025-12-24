<?php
// ===========================================
// FILE: index.php (Entry Point & Router)
// ===========================================
session_start();

require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Kategori.php';
require_once 'models/Produk.php';
require_once 'models/Transaksi.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/ProdukController.php';
require_once 'controllers/KategoriController.php';
require_once 'controllers/TransaksiController.php';
require_once 'controllers/UserController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'login';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($page) {
    case 'login':
        $controller = new AuthController();
        if ($action == 'process') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;
        
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
        
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
        break;
        
    case 'produk':
        $controller = new ProdukController();
        switch ($action) {
            case 'create':
                $controller->create();
                break;
            case 'edit':
                $controller->edit();
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                $controller->index();
        }
        break;
        
    case 'kategori':
        $controller = new KategoriController();
        switch ($action) {
            case 'create':
                $controller->create();
                break;
            case 'edit':
                $controller->edit();
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                $controller->index();
        }
        break;
        
    case 'kasir':
        $controller = new TransaksiController();
        $controller->kasir();
        break;
        
    case 'transaksi':
        $controller = new TransaksiController();
        switch ($action) {
            case 'cari':
                $controller->cariProduk();
                break;
            case 'simpan':
                $controller->simpanTransaksi();
                break;
            case 'laporan':
                $controller->laporan();
                break;
            case 'detail':
                $controller->detail();
                break;
            default:
                $controller->kasir();
        }
        break;
        
    case 'user':
        $controller = new UserController();
        switch ($action) {
            case 'create':
                $controller->create();
                break;
            case 'edit':
                $controller->edit();
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                $controller->index();
        }
        break;
        
    default:
        header("Location: index.php?page=login");
        exit();
}
?>