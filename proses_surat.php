<?php
include 'koneksi.php';

// Cek apakah parameter act ada
if (isset($_GET['act'])) {
    $act = $_GET['act'];

// ======================= SURAT MASUK ============================= 
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
        $no_agen = $_POST['no_agenda'];
        $tgl_t = $_POST['tgl_terima'];
        $pengirim = $_POST['pengirim'];
        $perihal = $_POST['perihal'];
        $tgl_s = $_POST['tgl_msk_bidang'];
        $diteruskan = $_POST['diteruskan_kepada'];
        $no_wa = $_POST['no_wa'];

        $query = "UPDATE surat_masuk SET 
                    no_surat = '$no', 
                    no_agenda = '$no_agen', 
                    tgl_terima = '$tgl_t', 
                    pengirim = '$pengirim', 
                    perihal = '$perihal', 
                    tgl_msk_bidang = '$tgl_s',
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



// ========================= IZIN TESTING ===========================
    // TAMBAH IZIN
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
    // EDIT IZIN
    elseif ($act == 'edit_izin') {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $pangkat = $_POST['pangkat_gol'];
        $instansi = $_POST['asal_instansi'];
        $sk = $_POST['no_sk'];
        $lembaga = $_POST['lembaga'];
        $ttd = $_POST['ttd'];

        $query = "UPDATE tugas_bel SET 
                    nama = '$nama', 
                    nip = '$nip', 
                    pangkat_gol = '$pangkat', 
                    asal_instansi = '$instansi', 
                    no_sk = '$sk', 
                    lembaga = '$lembaga',
                    ttd = '$ttd'
                WHERE id = '$id'";

        mysqli_query($koneksi, $query);
        header("location:index.php?page=izin_testing");
        }

    // HAPUS IZIN
    elseif ($act == 'hapus_izin') {
        $id = $_GET['id'];
        mysqli_query($koneksi, "DELETE FROM izin_testing WHERE id = '$id'");
        header("location:index.php?page=izin_testing");
    }

// ==================================================== TUGAS BELAJAR
    // TAMBAH TUGAS BELAJAR
    elseif ($act == 'tambah_tgs_bel') {
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $pangkat = $_POST['pangkat'];
        $instansi = $_POST['instansi'];
        $sk = $_POST['sk'];
        $lembaga = $_POST['lembaga'];
        $tandatangan = $_POST['tandatangan'];

        mysqli_query($koneksi, "INSERT INTO tugas_bel (nama, nip, pangkat_gol, asal_instansi, no_sk, lembaga, ttd) 
                                VALUES ('$nama', '$nip', '$pangkat', '$instansi', '$sk', '$lembaga', '$tandatangan')");
        header("location:index.php?page=tugas_belajar");
    }
    // EDIT TUGAS BELAJAR
    elseif ($act == 'edit_tgs_bel') {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $pangkat = $_POST['pangkat'];
        $instansi = $_POST['instansi'];
        $sk = $_POST['sk'];
        $lembaga = $_POST['lembaga'];
        $tandatangan = $_POST['tandatangan'];

        $query = "UPDATE tugas_bel SET 
                    nama = '$nama', 
                    nip = '$nip', 
                    pangkat_gol = '$pangkat', 
                    asal_instansi = '$instansi', 
                    no_sk = '$sk', 
                    lembaga = '$lembaga',
                    ttd = '$tandatangan'
                WHERE id = '$id'";

        mysqli_query($koneksi, $query);
        header("location:index.php?page=tugas_belajar");
        }

        // HAPUS TUGAS BELAJAR
    elseif ($act == 'hapus_tugas') {
        $id = $_GET['id'];
        mysqli_query($koneksi, "DELETE FROM tugas_bel WHERE id = '$id'");
        header("location:index.php?page=tugas_belajar");
    }


// ==================================================== SKMI
    // TAMBAH SKMI
    elseif ($act == 'tambah_skmi') {
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $pangkat = $_POST['pangkat'];
        $instansi = $_POST['instansi'];
        $sk = $_POST['sk'];
        $lembaga = $_POST['lembaga'];
        $tandatangan = $_POST['tandatangan'];

        mysqli_query($koneksi, "INSERT INTO skmi (nama, nip, pangkat_gol, asal_instansi, no_sk, lembaga, ttd) 
                                VALUES ('$nama', '$nip', '$pangkat', '$instansi', '$sk', '$lembaga', '$tandatangan')");
        header("location:index.php?page=skmi");
    }
    // EDIT SKMI
    elseif ($act == 'edit_skmi') {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $pangkat = $_POST['pangkat'];
        $instansi = $_POST['instansi'];
        $sk = $_POST['sk'];
        $lembaga = $_POST['lembaga'];
        $tandatangan = $_POST['tandatangan'];

        $query = "UPDATE skmi SET 
                    nama = '$nama', 
                    nip = '$nip', 
                    pangkat_gol = '$pangkat', 
                    asal_instansi = '$instansi', 
                    no_sk = '$sk', 
                    lembaga = '$lembaga',
                    ttd = '$tandatangan'
                WHERE id = '$id'";

        mysqli_query($koneksi, $query);
        header("location:index.php?page=skmi");
        }

        // HAPUS SKMI
    elseif ($act == 'hapus_skmi') {
        $id = $_GET['id'];
        mysqli_query($koneksi, "DELETE FROM skmi WHERE id = '$id'");
        header("location:index.php?page=skmi");
    }
        

// ==================================================== SKMTA
    // TAMBAH SKMTA
    elseif ($act == 'tambah_skmta') {
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $pangkat = $_POST['pangkat'];
        $instansi = $_POST['instansi'];
        $sk = $_POST['sk'];
        $lembaga = $_POST['lembaga'];
        $tandatangan = $_POST['tandatangan'];

        mysqli_query($koneksi, "INSERT INTO skmta (nama, nip, pangkat_gol, asal_instansi, no_sk, lembaga, ttd) 
                                VALUES ('$nama', '$nip', '$pangkat', '$instansi', '$sk', '$lembaga', '$tandatangan')");
        header("location:index.php?page=skmta");
    }
    // EDIT SKMTA
    elseif ($act == 'edit_skmta') {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $nip = $_POST['nip'];
        $pangkat = $_POST['pangkat'];
        $instansi = $_POST['instansi'];
        $sk = $_POST['sk'];
        $lembaga = $_POST['lembaga'];
        $tandatangan = $_POST['tandatangan'];

        $query = "UPDATE skmta SET 
                    nama = '$nama', 
                    nip = '$nip', 
                    pangkat_gol = '$pangkat', 
                    asal_instansi = '$instansi', 
                    no_sk = '$sk', 
                    lembaga = '$lembaga',
                    ttd = '$tandatangan'
                WHERE id = '$id'";

        mysqli_query($koneksi, $query);
        header("location:index.php?page=skmta");
        }

        // HAPUS SKMTA
    elseif ($act == 'hapus_skmta') {
        $id = $_GET['id'];
        mysqli_query($koneksi, "DELETE FROM skmta WHERE id = '$id'");
        header("location:index.php?page=skmta");
    }

    // ====================================================
    // 3. CRUD REFERENSI SURAT MASUK
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

}
?>