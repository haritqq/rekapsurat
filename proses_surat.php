<?php
include 'koneksi.php';

// Cek apakah parameter act ada
if (isset($_GET['act'])) {
    $act = $_GET['act'];

    // ====================================================
    // 1. CRUD SURAT MASUK (Termasuk Diteruskan & WA)
    // ====================================================
    
    // TAMBAH SURAT MASUK
    if ($act == 'tambah_masuk') {
        $no = $_POST['no_surat'];
        $no_agen = $_POST['no_agenda'];
        $tgl_t = $_POST['tgl_terima'];
        $pengirim = $_POST['pengirim'];
        $perihal = $_POST['perihal'];
        $tgl_s = $_POST['tgl_msk_bidang'];
        $diteruskan = $_POST['diteruskan_kepada'];
        $no_wa = $_POST['no_wa'];

        // Disarankan menyebutkan nama kolom spesifik agar terhindar dari error "Column count doesn't match"
        $query = "INSERT INTO surat_masuk (no_surat, no_agenda, tgl_terima, pengirim, perihal, tgl_msk_bidang, diteruskan_kepada, no_wa) 
                  VALUES ('$no', '$no_agen', '$tgl_t', '$pengirim', '$perihal', '$tgl_s', '$diteruskan', '$no_wa')";
        
        mysqli_query($koneksi, $query);
        header("location:index.php?page=surat_masuk");
    }

    // EDIT SURAT MASUK
    elseif ($act == 'edit_masuk') {
        $id = $_POST['id'];
        $no = $_POST['no_surat'];
        $tgl_s = $_POST['tgl_surat'];
        $tgl_t = $_POST['tgl_terima'];
        $pengirim = $_POST['pengirim'];
        $perihal = $_POST['perihal'];
        $diteruskan = $_POST['diteruskan_kepada'];
        $no_wa = $_POST['no_wa'];

        $query = "UPDATE surat_masuk SET 
                    no_surat = '$no', 
                    tgl_surat = '$tgl_s', 
                    tgl_terima = '$tgl_t', 
                    pengirim = '$pengirim', 
                    perihal = '$perihal', 
                    diteruskan_kepada = '$diteruskan', 
                    no_wa = '$no_wa' 
                  WHERE id = '$id'";

        mysqli_query($koneksi, $query);
        header("location:index.php?page=surat_masuk");
    }

    // HAPUS SURAT MASUK
    elseif ($act == 'hapus_masuk') {
        $id = $_GET['id'];
        mysqli_query($koneksi, "DELETE FROM surat_masuk WHERE id = '$id'");
        header("location:index.php?page=surat_masuk");
    }


    // ====================================================
    // 2. CRUD REFERENSI SURAT MASUK
    // ====================================================
    
    // TAMBAH REF MASUK
    elseif ($act == 'tambah_ref_masuk') {
        $kode = $_POST['kode_surat'];
        $nama_i = $_POST['nama_instansi'];
        $perihal = $_POST['perihal'];
        $tujuan = $_POST['tujuan'];
        $ditunjuk = $_POST['ditunjukan'];

        mysqli_query($koneksi, "INSERT INTO ref_masuk (kode_surat, nama_instansi, perihal, tujuan, ditunjukan) 
                  VALUES ('$kode', '$nama_i', '$perihal', '$tujuan', '$ditunjuk')");
        header("location:index.php?page=ref_masuk");
    }

    // EDIT REF MASUK
    elseif ($act == 'edit_ref_masuk') {
        $id = $_POST['id'];
        $kode = $_POST['kode_surat'];
        $nama_i = $_POST['nama_instansi'];
        $perihal = $_POST['perihal'];
        $tujuan = $_POST['tujuan'];
        $ditunjuk = $_POST['ditunjukan'];

        $query = "UPDATE ref_masuk SET 
                    kode_surat = '$kode', 
                    nama_instansi = '$nama_i', 
                    perihal = '$perihal', 
                    tujuan = '$tujuan', 
                    ditunjukan = '$ditunjuk' 
                  WHERE id = '$id'";

        mysqli_query($koneksi, $query);
        header("location:index.php?page=ref_masuk");
    }

    // HAPUS REF MASUK
    elseif ($act == 'hapus_ref_masuk') {
        $id = $_GET['id'];
        mysqli_query($koneksi, "DELETE FROM ref_masuk WHERE id = '$id'");
        header("location:index.php?page=ref_masuk");
    }


    // ====================================================
    // 3. CRUD SURAT KELUAR (Sebagai Pelengkap)
    // ====================================================
    // TAMBAH SURAT KELUAR
    elseif ($act == 'tambah_izin') {
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $pangkat = $_POST['pangkat'];
        $instansi = $_POST['instansi'];
        $sk = $_POST['sk'];
        $lembaga = $_POST['lembaga'];
        $tandatangan = $_POST['tandatangan'];

        mysqli_query($koneksi, "INSERT INTO izin_testing (nama, nip, pangkat_gol, asal_instansi, no_sk, lembaga, ttd) 
                                VALUES ('$nama', '$nip', '$pangkat', '$instansi', '$sk', '$lembaga', '$tandatangan')");
        header("location:index.php?page=izin_testing");
    }    
    // HAPUS
    elseif ($act == 'hapus_izin') {
        $id = $_GET['id'];
        mysqli_query($koneksi, "DELETE FROM izin_testing WHERE id = '$id'");
        header("location:index.php?page=izin_testing");
    }

    
    // TAMBAH SURAT KELUAR
    elseif ($act == 'tambah_keluar') {
        $no_surat = $_POST['no_surat'];
        $tgl_surat = $_POST['tgl_surat'];
        $tujuan = $_POST['tujuan'];
        $perihal = $_POST['perihal'];

        mysqli_query($koneksi, "INSERT INTO surat_keluar (no_surat, tgl_surat, tujuan, perihal) 
                                VALUES ('$no_surat', '$tgl_surat', '$tujuan', '$perihal')");
        header("location:index.php?page=surat_keluar");
    }

    // EDIT SURAT KELUAR
    elseif ($act == 'edit_keluar') {
        $id = $_POST['id'];
        $no_surat = $_POST['no_surat'];
        $tgl_surat = $_POST['tgl_surat'];
        $tujuan = $_POST['tujuan'];
        $perihal = $_POST['perihal'];

        mysqli_query($koneksi, "UPDATE surat_keluar SET 
                                no_surat='$no_surat', tgl_surat='$tgl_surat', tujuan='$tujuan', perihal='$perihal' 
                                WHERE id='$id'");
        header("location:index.php?page=surat_keluar");
    }

    // HAPUS SURAT KELUAR
    elseif ($act == 'hapus_keluar') {
        $id = $_GET['id'];
        mysqli_query($koneksi, "DELETE FROM surat_keluar WHERE id = '$id'");
        header("location:index.php?page=surat_keluar");
    }
}
?>