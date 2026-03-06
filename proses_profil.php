<?php
session_start();
include 'koneksi.php';

if(isset($_POST['update_profil'])){
    $id       = $_POST['id_user'];
    // Ambil data dari form
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']); // Ini dari name="nama" di HTML
    $nip      = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $jabatan  = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $pangkat  = mysqli_real_escape_string($koneksi, $_POST['pangkat_gol']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);

    // Jika password diisi
    if(!empty($_POST['password'])){
        $password = md5($_POST['password']);
        // SESUAIKAN: nama_lengkap (kolom DB) = '$nama' (variabel PHP)
        $query = "UPDATE users SET 
                    nama_lengkap='$nama', 
                    nip='$nip', 
                    jabatan='$jabatan', 
                    pangkat_gol='$pangkat', 
                    username='$username', 
                    password='$password' 
                  WHERE id='$id'";
    } else {
        // Jika password kosong
        $query = "UPDATE users SET 
                    nama_lengkap='$nama', 
                    nip='$nip', 
                    jabatan='$jabatan', 
                    pangkat_gol='$pangkat', 
                    username='$username' 
                  WHERE id='$id'";
    }

    if(mysqli_query($koneksi, $query)){
        $_SESSION['username'] = $username;
        $_SESSION['nama'] = $nama; // Update session nama agar di header langsung berubah
        echo "<script>alert('Profil berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        // Menampilkan pesan error spesifik jika gagal lagi
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>