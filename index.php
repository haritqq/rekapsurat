<?php
session_start();
if($_SESSION['status'] != "login"){ header("location:login.php"); }
include 'koneksi.php';

// Hitung Statistik Dashboard
$bulan_ini = date('m');
$masuk = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM surat_masuk WHERE MONTH(tgl_terima) = '$bulan_ini'"));
$keluar = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM surat_keluar WHERE MONTH(tgl_surat) = '$bulan_ini'"));

$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$sk_pages = ['izin_testing', 'tugas_belajar', 'skmi', 'skmta', 'skttb'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Arsip | Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --dark-bg: #1a1c23;
            --sidebar-width: 260px;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--dark-bg);
            transition: all 0.3s;
            z-index: 1000;
        }

        #sidebar.active {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-header {
            padding: 20px;
            background: #111317;
            text-align: center;
            color: #fff;
        }

        .sidebar a {
            padding: 12px 20px;
            display: block;
            color: #949ba2;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.95rem;
        }

        .sidebar a:hover, .sidebar a.active {
            color: #fff;
            background: rgba(255,255,255,0.05);
            border-left: 4px solid var(--primary-color);
        }

        .sidebar .dropdown-toggle::after {
            display: inline-block;
            margin-left: auto;
            float: right;
            margin-top: 7px;
        }

        /* Content Styling */
        #content {
            width: 100%;
            transition: all 0.3s;
        }

        .navbar {
            padding: 15px 25px;
            background: #fff;
            border: none;
            border-radius: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .card-stats {
            border: none;
            border-left: 5px solid var(--primary-color);
            border-radius: 10px;
            transition: transform 0.2s;
        }

        .card-stats:hover {
            transform: translateY(-5px);
        }

        @media (max-width: 768px) {
            #sidebar { margin-left: calc(-1 * var(--sidebar-width)); }
            #sidebar.active { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0 fw-bold"><i class="fas fa-archive me-2"></i>E-Arsip</h4>
        </div>
        
    <div class="py-3">
        <a href="index.php" class="<?= ($current_page == 'dashboard') ? 'active' : ''; ?>">
            <i class="fas fa-home me-3"></i> Dashboard
        </a>

        <div class="text-uppercase px-4 small fw-bold mt-3 mb-2" style="color: #4e535a; font-size: 0.7rem;">Manajemen Surat</div>
        <a href="index.php?page=surat_masuk" class="<?= ($current_page == 'surat_masuk') ? 'active' : ''; ?>">
            <i class="fas fa-download me-3"></i> Surat Masuk
        </a>
        <a href="#skeluarSubmenu" data-bs-toggle="collapse" class="dropdown-toggle <?= in_array($current_page, $sk_pages) ? 'active' : ''; ?>">
            <i class="fas fa-upload me-3"></i> Surat Keluar
        </a>

        <div class="collapse <?= in_array($current_page, $sk_pages) ? 'show' : ''; ?> bg-black bg-opacity-10" id="skeluarSubmenu">
            <a href="index.php?page=izin_testing" class="ps-5 small <?= ($current_page == 'izin_testing') ? 'active' : ''; ?>">Izin Testing</a>
            <a href="index.php?page=tugas_belajar" class="ps-5 small <?= ($current_page == 'tugas_belajar') ? 'active' : ''; ?>">Tugas Belajar</a>
            <a href="index.php?page=skmi" class="ps-5 small <?= ($current_page == 'skmi') ? 'active' : ''; ?>">SKMI</a>
            <a href="index.php?page=skmta" class="ps-5 small <?= ($current_page == 'skmta') ? 'active' : ''; ?>">SKMTA</a>
            <a href="index.php?page=skttb" class="ps-5 small <?= ($current_page == 'skttb') ? 'active' : ''; ?>">SKTTB</a>
        </div>

        <a href="#refSubmenu" data-bs-toggle="collapse" class="dropdown-toggle <?= (strpos($current_page, 'ref_') !== false) ? 'active' : ''; ?>">
            <i class="fas fa-tags me-3"></i> Referensi
        </a>
        <div class="collapse <?= (strpos($current_page, 'ref_') !== false) ? 'show' : ''; ?> bg-black bg-opacity-10" id="refSubmenu">
            <a href="index.php?page=ref_masuk" class="ps-5 small <?= ($current_page == 'ref_masuk') ? 'active' : ''; ?>">Kode Masuk</a>
            <a href="index.php?page=ref_keluar" class="ps-5 small <?= ($current_page == 'ref_keluar') ? 'active' : ''; ?>">Kode Keluar</a>
        </div>

        <a href="index.php?page=laporan" class="<?= ($current_page == 'laporan') ? 'active' : ''; ?>">
            <i class="fas fa-chart-line me-3"></i> Laporan
        </a>

        <hr class="mx-3 my-4 border-secondary">
        <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-3"></i> Logout</a>
    </div>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-outline-primary border-0">
                    <i class="fas fa-align-left"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3 text-muted small d-none d-md-block">Halo, <strong>Admin</strong></span>
                    <img src="https://ui-avatars.com/api/?name=Admin&background=4e73df&color=fff" class="rounded-circle" width="35" alt="Profile">
                </div>
            </div>
        </nav>

        <div class="container-fluid p-4">
            <?php
            if(isset($_GET['page'])){
                $page = $_GET['page'];
                if(file_exists($page.".php")){
                    include $page.".php";
                } else {
                    echo "<div class='alert alert-warning'>Halaman <b>$page</b> tidak ditemukan.</div>";
                }
            } else {
            ?>
                <h3 class="fw-bold mb-4">Dashboard Overview</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-stats shadow-sm mb-4">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 small fw-bold">SURAT MASUK BULAN INI</p>
                                        <h2 class="fw-bold mb-0"><?= $masuk; ?></h2>
                                    </div>
                                    <i class="fas fa-envelope-open-text fa-2x text-primary opacity-25"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stats shadow-sm mb-4" style="border-left-color: #1cc88a;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted mb-1 small fw-bold text-uppercase">Surat Keluar Bulan Ini</p>
                                        <h2 class="fw-bold mb-0"><?= $keluar; ?></h2>
                                    </div>
                                    <i class="fas fa-paper-plane fa-2x text-success opacity-25"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarCollapse = document.getElementById('sidebarCollapse');

        // Toggle Sidebar
        sidebarCollapse.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });

        // Close other collapses when one opens
        const collapses = document.querySelectorAll('.sidebar .collapse');
        collapses.forEach(c => {
            c.addEventListener('show.bs.collapse', function() {
                collapses.forEach(other => {
                    if (other !== c) {
                        const bsCollapse = bootstrap.Collapse.getInstance(other);
                        if (bsCollapse) bsCollapse.hide();
                    }
                });
            });
        });
    });
</script>
</body>
</html>