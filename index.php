<?php
session_start();
if($_SESSION['status'] != "login"){ header("location:login.php"); }
include 'koneksi.php';

// Hitung Statistik Dashboard
$bulan_ini = date('m');
$masuk = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM surat_masuk WHERE MONTH(tgl_terima) = '$bulan_ini'"));
$keluar = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM surat_keluar WHERE MONTH(tgl_surat) = '$bulan_ini'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Rekap Surat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { min-height: 100vh; background: #343a40; color: white; }
        .sidebar a { color: #c2c7d0; text-decoration: none; padding: 10px 20px; display: block; }
        .sidebar a:hover, .sidebar a.active { background-color: #565d65; color: white; }
        .content { padding: 20px; }
    </style>
</head>
<body>

<div class="d-flex">
    <?php 
    $current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; 
    $current_type = isset($_GET['type']) ? $_GET['type'] : 'izin';
    ?>
    
    <div class="sidebar col-md-2">
    <h4 class="text-center py-3">E-Arsip</h4>
    <hr>
    
    <a href="index.php" class="<?= ($current_page == 'dashboard') ? 'active' : ''; ?>">
        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </a>

    <a href="index.php?page=surat_masuk" class="<?= ($current_page == 'surat_masuk') ? 'active' : ''; ?>">
        <i class="fas fa-inbox me-2"></i> Surat Masuk
    </a>

    <a href="#skeluarSubmenu" data-bs-toggle="collapse" 
       class="dropdown-toggle <?= ($current_page == 'surat_keluar') ? 'active' : ''; ?>" 
       aria-expanded="<?= ($current_page == 'surat_keluar') ? 'true' : 'false'; ?>">
        <i class="fas fa-paper-plane me-2"></i> Surat Keluar
    </a>
    <div class="collapse <?= ($current_page == 'surat_keluar') ? 'show' : ''; ?>" id="skeluarSubmenu" data-bs-parent=".sidebar">
        <a href="index.php?page=izin_testing" class="ps-5 <?= ($current_type == 'izin_testing') ? 'active' : ''; ?>">
            <i class="fas fa-angle-right me-2"></i> Izin Testing
        </a>
        <a href="index.php?page=surat_keluar&type=tugas_belajar" class="ps-5 <?= ($current_type == 'tugas_belajar') ? 'active' : ''; ?>">
            <i class="fas fa-angle-right me-2"></i> Tugas Belajar
        </a>
        <a href="index.php?page=surat_keluar&type=skmi" class="ps-5 <?= ($current_type == 'skmi') ? 'active' : ''; ?>">
            <i class="fas fa-angle-right me-2"></i> SKMI
        </a>
        <a href="index.php?page=surat_keluar&type=skmta" class="ps-5 <?= ($current_type == 'skmta') ? 'active' : ''; ?>">
            <i class="fas fa-angle-right me-2"></i> SKMTA
        </a>
        <a href="index.php?page=surat_keluar&type=skttb" class="ps-5 <?= ($current_type == 'skttb') ? 'active' : ''; ?>">
            <i class="fas fa-angle-right me-2"></i> SKTTB
        </a>
    </div>
    
    <a href="#refSubmenu" data-bs-toggle="collapse" 
       class="dropdown-toggle <?= (strpos($current_page, 'ref_') !== false) ? 'active' : ''; ?>">
        <i class="fas fa-book me-2"></i> Referensi
    </a>
    <div class="collapse <?= (strpos($current_page, 'ref_') !== false) ? 'show' : ''; ?>" id="refSubmenu" data-bs-parent=".sidebar">
        <a href="index.php?page=ref_masuk" class="ps-5 <?= ($current_page == 'ref_masuk') ? 'active' : ''; ?>">
            <i class="fas fa-angle-right me-2"></i> Kode Surat Masuk
        </a>
        <a href="index.php?page=ref_keluar" class="ps-5 <?= ($current_page == 'ref_keluar') ? 'active' : ''; ?>">
            <i class="fas fa-angle-right me-2"></i> Kode Surat Keluar
        </a>
    </div>

    <a href="index.php?page=laporan" class="<?= ($current_page == 'laporan') ? 'active' : ''; ?>">
        <i class="fas fa-print me-2"></i> Laporan
    </a>

        <a href="logout.php" class="text-danger mt-5"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </div>

    <div class="col-md-10 bg-light content">
        <?php
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            if(file_exists($page.".php")){
                include $page.".php";
            } else {
                echo "<h3>Halaman tidak ditemukan</h3>";
            }
        } else {
            // DASHBOARD VIEW (Poin 3)
        ?>
            <header class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
                <h4 class="mb-0">Dashboard</h4><div><span>Halo, Admin!</span></div>
            </header>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Surat Masuk (Bulan Ini)</h5>
                            <h1 class="display-4 fw-bold"><?= $masuk; ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Surat Keluar (Bulan Ini)</h5>
                            <h1 class="display-4 fw-bold"><?= $keluar; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var myCollapsibles = document.querySelectorAll('.sidebar .collapse');
    
    myCollapsibles.forEach(function(collapse) {
        collapse.addEventListener('show.bs.collapse', function () {
            // Tutup semua collapse lain yang sedang terbuka
            myCollapsibles.forEach(function(otherCollapse) {
                if (otherCollapse !== collapse) {
                    var bsCollapse = bootstrap.Collapse.getInstance(otherCollapse);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            });
        });
    });
});
</script>
</body>
</html>