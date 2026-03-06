<?php
session_start();
if($_SESSION['status'] != "login"){ header("location:login.php"); }
include 'koneksi.php';

// Ambil username dari session
$user_logged = $_SESSION['username'] ?? ''; // Gunakan null coalescing agar tidak error jika kosong

// Ambil data lengkap user
$query_user  = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user_logged'");
$user_data   = mysqli_fetch_assoc($query_user);

// CEK: Jika user_data null (karena query gagal atau user tidak ditemukan)
if (!$user_data) {
    $user_data = [
        'id' => '', 
        'username' => '', 
        'nama_lengkap' => 'User', // Gunakan nama_lengkap sesuai DB
        'nip' => '-', 
        'jabatan' => '-', 
        'pangkat_gol' => '-'
    ];
}

$bulan_ini = date('m');
$tahun_ini = date('Y');

// Fungsi pembantu agar kode lebih bersih
function hitungData($koneksi, $tabel, $kolom_tgl, $bulan = null) {
    $query = "SELECT COUNT(*) as total FROM $tabel";
    if ($bulan) {
        $query .= " WHERE MONTH($kolom_tgl) = '$bulan' AND YEAR($kolom_tgl) = '" . date('Y') . "'";
    }
    $res = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($res);
    return $data['total'];
}

// 1. Surat Masuk
$masuk_total = hitungData($koneksi, 'surat_masuk', 'tgl_terima');
$masuk_bulan = hitungData($koneksi, 'surat_masuk', 'tgl_terima', $bulan_ini);

// 2. Rincian Surat Keluar (Total & Per Bulan)
// Asumsi semua tabel memiliki kolom 'created_at' atau ganti dengan kolom tanggal masing-masing
$izin_total  = hitungData($koneksi, 'izin_testing', 'id'); // Ganti 'id' dengan kolom tgl jika ada
$izin_bulan  = hitungData($koneksi, 'izin_testing', 'created_at', $bulan_ini);

$tugas_total = hitungData($koneksi, 'tugas_bel', 'id');
$tugas_bulan = hitungData($koneksi, 'tugas_bel', 'created_at', $bulan_ini);

$skmi_total  = hitungData($koneksi, 'skmi', 'id');
$skmi_bulan  = hitungData($koneksi, 'skmi', 'created_at', $bulan_ini);

$skmta_total = hitungData($koneksi, 'skmta', 'id');
$skmta_bulan = hitungData($koneksi, 'skmta', 'created_at', $bulan_ini);

$skttb_total = hitungData($koneksi, 'skttb', 'id');
$skttb_bulan = hitungData($koneksi, 'skttb', 'created_at', $bulan_ini);

$total_keluar = $izin_total + $tugas_total + $skmi_total + $skmta_total + $skttb_total;
$bulan_keluar = $izin_bulan + $tugas_bulan + $skmi_bulan + $skmta_bulan + $skttb_bulan;

// 3. Anggota
$anggota_total = hitungData($koneksi, 'ref_anggota', 'created_at');

$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$sk_pages = ['izin_testing', 'tugas_belajar', 'skmi', 'skmta', 'skttb'];
// pengecekan menu referensi lebih fleksibel
$is_ref_page = (strpos($current_page, 'ref_') !== false);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Arsip | Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
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

        <div class="text-uppercase px-4 small fw-bold mt-3 mb-2" style="color: #cbcbcb; font-size: 0.7rem;">Manajemen Surat</div>
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
            <a href="index.php?page=ref_masuk" class="ps-5 small <?= ($current_page == 'ref_masuk') ? 'active' : ''; ?>">No. Surat Masuk</a>
            <a href="index.php?page=ref_keluar" class="ps-5 small <?= ($current_page == 'ref_keluar') ? 'active' : ''; ?>">No. Surat Keluar</a>
        </div>

        <a href="index.php?page=anggota" class="<?= ($current_page == 'anggota') ? 'active' : ''; ?>">
            <i class="fas fa-user-tag me-3"></i> Data Pegawai
        </a>

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
                    <div class="d-flex flex-column align-items-end me-3">
                        <span class="text-muted small d-none d-md-block">
                            Selamat Datang, <strong><?= htmlspecialchars($user_data['nama_lengkap']); ?></strong>
                        </span>
                        
                        <span id="status-badge" class="badge rounded-pill px-2 py-1 bg-success" style="font-size: 10px; min-width: 60px;">
                            <i class="fas fa-circle me-1" style="font-size: 7px;"></i> 
                            <span id="status-text">Online</span>
                        </span>
                    </div>

                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalProfil">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user_data['nama_lengkap']); ?>&background=4e73df&color=fff" 
                            class="rounded-circle shadow-sm" 
                            width="40" 
                            alt="Profile">
                    </a>
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
    <div class="col-md-4 mb-4">
        <div class="card card-stats shadow-sm h-100" style="border-left: 5px solid #4e73df;">
            <div class="card-body">
                <div class="text-muted small fw-bold mb-2">SURAT KELUAR</div>
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <h2 class="fw-bold mb-0"><?= $total_keluar; ?></h2>
                        <span class="badge bg-danger-soft text-primary" style="background: #e5ecf9;">
                            <i class="fas fa-calendar-alt me-1"></i> Bulan ini: <?= $bulan_keluar; ?>
                        </span>
                    </div>
                    <i class="fas fa-paper-plane fa-2x text-primary opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card card-stats shadow-sm h-100" style="border-left: 5px solid #1cc88a;">
            <div class="card-body">
                <div class="text-muted small fw-bold mb-2">SURAT MASUK</div>
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <h2 class="fw-bold mb-0"><?= $masuk_total; ?></h2>
                        <span class="badge bg-success-soft text-success" style="background: #e5f9f0;">
                            <i class="fas fa-calendar-alt me-1"></i> Bulan ini: <?= $masuk_bulan; ?>
                        </span>
                    </div>
                    <i class="fas fa-envelope-open-text fa-2x text-success opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card card-stats shadow-sm h-100" style="border-left: 5px solid #f6c23e;">
            <div class="card-body">
                <div class="text-muted small fw-bold mb-2">DATA PEGAWAI</div>
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <h2 class="fw-bold mb-0"><?= $anggota_total; ?></h2>
                        <span class="text-muted small">Total Terdaftar</span>
                    </div>
                    <i class="fas fa-users fa-2x text-warning opacity-25"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<h5 class="fw-bold mb-3 mt-2 text-muted">Rincian Surat Keluar</h5>
<div class="row">
    <?php
    $menus = [
        ['label' => 'Izin Testing', 'total' => $izin_total, 'bulan' => $izin_bulan, 'color' => '#4e73df'],
        ['label' => 'Tugas Belajar', 'total' => $tugas_total, 'bulan' => $tugas_bulan, 'color' => '#36b9cc'],
        ['label' => 'SKMI', 'total' => $skmi_total, 'bulan' => $skmi_bulan, 'color' => '#6610f2'],
        ['label' => 'SKMTA', 'total' => $skmta_total, 'bulan' => $skmta_bulan, 'color' => '#e83e8c'],
        ['label' => 'SKTTB', 'total' => $skttb_total, 'bulan' => $skttb_bulan, 'color' => '#fd7e14'],
    ];

    foreach ($menus as $m) : ?>
    <div class="col-md-4 col-lg-2-4 mb-3" style="flex: 0 0 auto; width: 20%;"> <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-3 text-center">
                <div class="small text-muted fw-bold mb-1 text-uppercase" style="font-size: 0.7rem;"><?= $m['label']; ?></div>
                <h3 class="fw-bold mb-1" style="color: <?= $m['color']; ?>;"><?= $m['total']; ?></h3>
                <hr class="my-2 opacity-10">
                <div class="small">
                    <span class="text-muted">Bulan ini:</span> 
                    <span class="fw-bold"><?= $m['bulan']; ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProfil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user-cog me-2"></i>Pengaturan Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_profil.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_user" value="<?= $user_data['id']; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= $user_data['nama_lengkap']; ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">NIP</label>
                            <input type="text" name="nip" class="form-control" value="<?= $user_data['nip'] ?? '-'; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="<?= $user_data['jabatan'] ?? '-'; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pangkat / Golongan</label>
                        <input type="text" name="pangkat_gol" class="form-control" value="<?= $user_data['pangkat_gol'] ?? '-'; ?>">
                    </div>
                    
                    <hr>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Username Baru</label>
                        <input type="text" name="username" class="form-control" value="<?= $user_data['username']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" id="pass_baru" class="form-control" placeholder="Kosongkan jika tidak ubah">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('pass_baru', 'icon_baru')">
                                <i class="fas fa-eye" id="icon_baru"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ulangi Password Baru</label>
                        <div class="input-group">
                            <input type="password" id="pass_konfirmasi" class="form-control" placeholder="Ketik ulang password">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('pass_konfirmasi', 'icon_konf')">
                                <i class="fas fa-eye" id="icon_konf"></i>
                            </button>
                        </div>
                        <div id="msg_error" class="text-danger small mt-1" style="display:none;">Password tidak cocok!</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="update_profil" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
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

<!-- script tambah data di menu data pegawai -->
<script>
const input = document.querySelector("#phone");
const hiddenInput = document.querySelector("#full_no_wa");
const errorMsg = document.querySelector("#error-msg");

const iti = window.intlTelInput(input, {
    // Pengaturan
    initialCountry: "id", // Default Indonesia
    separateDialCode: true, // Menampilkan angka +62 di sebelah bendera
    preferredCountries: ["id", "my", "sg"], // Negara prioritas di daftar atas
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js", // Untuk validasi
});

// Fungsi untuk memperbarui hidden input setiap kali nomor berubah
const updateValue = () => {
    if (input.value.trim()) {
        if (iti.isValidNumber()) {
            // iti.getNumber() menghasilkan format internasional seperti +62812...
            // hapus tanda "+" agar sesuai dengan kebutuhan database
            const cleanNumber = iti.getNumber().replace('+', '');
            hiddenInput.value = cleanNumber;
            errorMsg.style.display = "none";
        } else {
            errorMsg.style.display = "block";
        }
    }
};

input.addEventListener('keyup', updateValue);
input.addEventListener('change', updateValue);
input.addEventListener('countrychange', updateValue);
</script>

<!-- Script edit nomor whatapp -->
<script>
    // Ambil semua elemen input dengan class phone-edit
const editInputs = document.querySelectorAll(".phone-edit");

editInputs.forEach(function(input) {
    // Cari elemen pendukung (hidden input & error msg) di dalam parent yang sama
    const container = input.closest('.mb-3');
    const hiddenInput = container.querySelector(".full-no-edit");
    const errorMsg = container.querySelector(".error-msg-edit");

    const itiEdit = window.intlTelInput(input, {
        initialCountry: "id",
        separateDialCode: true,
        preferredCountries: ["id", "my", "sg"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js",
    });

    // Fungsi update nilai
    const handleChange = () => {
        if (input.value.trim()) {
            if (itiEdit.isValidNumber()) {
                // Simpan nomor bersih (tanpa +) ke hidden input
                const cleanNumber = itiEdit.getNumber().replace('+', '');
                hiddenInput.value = cleanNumber;
                errorMsg.style.display = "none";
            } else {
                errorMsg.style.display = "block";
            }
        }
    };

    // Event listener untuk setiap perubahan
    input.addEventListener('keyup', handleChange);
    input.addEventListener('change', handleChange);
    input.addEventListener('countrychange', handleChange);
});
</script>

<!-- scrip dropdown pegawai pada menu surat masuk -->
<script>
    const selectPegawai = document.getElementById('pilih_pegawai');
    const inputWa = document.getElementById('no_wa');

    selectPegawai.addEventListener('change', function() {
        // Mengambil atribut data-wa dari opsi yang dipilih
        const selectedOption = this.options[this.selectedIndex];
        const noWa = selectedOption.getAttribute('data-wa');

        // Isi input no_wa jika data tersedia, jika tidak kosongkan
        if (noWa) {
            inputWa.value = noWa;
        } else {
            inputWa.value = '';
        }
    });
</script>

<!-- scrip edit pegawai pada surat masuk -->
<script>
// Menggunakan event delegation agar bekerja di dalam modal atau elemen dinamis
document.addEventListener('change', function (e) {
    if (e.target && e.target.id === 'edit_pilih_pegawai') {
        const select = e.target;
        const selectedOption = select.options[select.selectedIndex];
        const noWa = selectedOption.getAttribute('data-wa');
        
        // Cari input no_wa yang berada dalam satu container modal yang sama
        const modalBody = select.closest('.modal-body');
        const inputWa = modalBody.querySelector('#edit_no_wa');
        
        if (noWa) {
            inputWa.value = noWa;
        } else {
            inputWa.value = '';
        }
    }
});
</script>

<script>
    function updateOnlineStatus() {
        const badge = document.getElementById('status-badge');
        const text = document.getElementById('status-text');
        
        if (navigator.onLine) {
            // Gaya saat Online
            badge.classList.remove('bg-danger');
            badge.classList.add('bg-success');
            text.textContent = "Online";
            badge.style.opacity = "1";
        } else {
            // Gaya saat Offline
            badge.classList.remove('bg-success');
            badge.classList.add('bg-danger');
            text.textContent = "Offline";
            // Memberi efek kedip sedikit agar user sadar koneksi terputus
            badge.style.opacity = "0.8"; 
        }
    }

    // Jalankan saat halaman pertama kali dimuat
    window.addEventListener('load', updateOnlineStatus);

    // Pantau perubahan koneksi secara real-time
    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
</script>

<script>
// Fungsi untuk Lihat/Sembunyi Password
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

// Validasi Password Cocok
const passBaru = document.getElementById('pass_baru');
const passKonf = document.getElementById('pass_konfirmasi');
const msgError = document.getElementById('msg_error');
const btnSimpan = document.querySelector('button[name="update_profil"]');

function cekKesesuaian() {
    if (passKonf.value === "") {
        msgError.style.display = "none";
        btnSimpan.disabled = false;
    } else if (passBaru.value !== passKonf.value) {
        msgError.style.display = "block";
        btnSimpan.disabled = true; // Tombol simpan mati jika tidak cocok
    } else {
        msgError.style.display = "none";
        btnSimpan.disabled = false;
    }
}

passBaru.addEventListener('keyup', cekKesesuaian);
passKonf.addEventListener('keyup', cekKesesuaian);
</script>

</body>
</html>