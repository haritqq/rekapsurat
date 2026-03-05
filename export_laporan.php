<?php
include 'koneksi.php';

// 1. Tangkap Input
$jenis      = $_POST['jenis'] ?? 'masuk';
$aksi       = $_POST['aksi'] ?? 'pdf';
$start_date = mysqli_real_escape_string($koneksi, $_POST['start_date']);
$end_date   = mysqli_real_escape_string($koneksi, $_POST['end_date']);

$lokasi     = htmlspecialchars($_POST['lokasi']);
$tgl_ttd    = htmlspecialchars($_POST['tgl_ttd']);

$jabatan_1  = htmlspecialchars($_POST['jabatan_1']);
$nama_1     = htmlspecialchars($_POST['nama_1']);
$nip_1      = htmlspecialchars($_POST['nip_1']);

$jabatan_2  = htmlspecialchars($_POST['jabatan_2']);
$nama_2     = htmlspecialchars($_POST['nama_2']);
$nip_2      = htmlspecialchars($_POST['nip_2']);

// Helper: Format Tanggal Indonesia
function tgl_indo($tanggal){
    if(empty($tanggal) || $tanggal == '0000-00-00') return '-';
    $bulan = array (1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

// 2. Set Header jika Export Excel
if($aksi == 'excel'){
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Surat_".ucfirst($jenis)."_".$start_date."_sd_".$end_date.".xls");
}

// 3. Logic Query Database
$kolom = "no_surat, tgl_msk_bidang, tgl_terima, pengirim, perihal, no_agenda, diteruskan_kepada";
// 3. Logic Query Database
$col_date = 'tgl_terima'; 

if ($jenis == 'masuk') {
    // Surat Masuk (Kolom asli)
    $sql = "SELECT no_surat, tgl_msk_bidang, tgl_terima, pengirim, perihal, no_agenda, diteruskan_kepada 
            FROM surat_masuk 
            WHERE $col_date BETWEEN '$start_date' AND '$end_date' 
            ORDER BY $col_date ASC";
} else {
    // Surat Keluar: Kita petakan kolom yang ada agar cocok dengan tabel laporan
    // Contoh: no_sk dianggap sebagai no_surat, nama dianggap pengirim, dst.
    $tables = ['izin_testing', 'tugas_bel', 'skmi', 'skmta', 'skttb'];
    $query_parts = [];
    
    foreach ($tables as $tbl) {
        // Kita gunakan AS untuk menyamakan nama kolom
        // Karena tabel ini tidak punya tgl_terima, kita gunakan created_at sebagai pengganti filter
        $query_parts[] = "SELECT 
                            no_sk AS no_surat, 
                            DATE(created_at) AS tgl_msk_bidang, 
                            DATE(created_at) AS tgl_terima, 
                            nama AS pengirim, 
                            CONCAT('Lembaga: ', lembaga) AS perihal, 
                            '-' AS no_agenda, 
                            ttd AS diteruskan_kepada 
                          FROM $tbl 
                          WHERE DATE(created_at) BETWEEN '$start_date' AND '$end_date'";
    }
    
    // Khusus skttb (karena tidak ada kolom 'lembaga' di SQL Anda)
    $query_parts[4] = "SELECT 
                            no_sk AS no_surat, 
                            DATE(created_at) AS tgl_msk_bidang, 
                            DATE(created_at) AS tgl_terima, 
                            nama AS pengirim, 
                            'SKTTB' AS perihal, 
                            '-' AS no_agenda, 
                            ttd AS diteruskan_kepada 
                          FROM skttb 
                          WHERE DATE(created_at) BETWEEN '$start_date' AND '$end_date'";

    $sql = implode(" UNION ALL ", $query_parts) . " ORDER BY tgl_terima ASC";
}

$query = mysqli_query($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Surat <?= ucfirst($jenis) ?></title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 11pt; color: #000; }
        .header-laporan { text-align: center; margin-bottom: 20px; }
        .header-laporan h2, .header-laporan h4 { margin: 3px 0; }
        
        .table-data { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .table-data th, .table-data td { border: 1px solid #000; padding: 6px 8px; vertical-align: top; }
        .table-data th { background-color: #f0f0f0; text-align: center; font-weight: bold; }
        
        /* Layout Tanda Tangan */
        .ttd-container { width: 100%; display: table; margin-top: 30px; page-break-inside: avoid; }
        .ttd-box { display: table-cell; width: 50%; text-align: center; vertical-align: top; }
        .ttd-name { font-weight: bold; text-decoration: underline; margin-top: 80px; margin-bottom: 2px; }
        
        /* Pengaturan Kertas PDF / Print (Landscape) */
        @media print {
            @page { size: landscape; margin: 15mm; }
            body { background: #fff; }
        }
    </style>
</head>
<body>

    <div class="header-laporan">
        <h2>LAPORAN SURAT <?= strtoupper($jenis) ?></h2>
        <h4>Periode: <?= tgl_indo($start_date) ?> s/d <?= tgl_indo($end_date) ?></h4>
    </div>

    <table class="table-data">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="14%">No Surat</th>
                <th width="12%">Tgl Msk Bidang</th>
                <th width="12%">Tgl Terima</th>
                <th width="15%">Pengirim</th>
                <th width="20%">Perihal</th>
                <th width="10%">No Agenda</th>
                <th width="13%">Diteruskan Kpd</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(mysqli_num_rows($query) > 0){
                $no = 1;
                while($row = mysqli_fetch_assoc($query)){
                    echo "<tr>
                            <td style='text-align:center;'>".$no++."</td>
                            <td>".$row['no_surat']."</td>
                            <td style='text-align:center;'>".tgl_indo($row['tgl_msk_bidang'])."</td>
                            <td style='text-align:center;'>".tgl_indo($row['tgl_terima'])."</td>
                            <td>".$row['pengirim']."</td>
                            <td>".$row['perihal']."</td>
                            <td style='text-align:center;'>".$row['no_agenda']."</td>
                            <td>".$row['diteruskan_kepada']."</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8' style='text-align:center;'>Tidak ada data surat pada periode tersebut.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="ttd-container">
        <div class="ttd-box">
            <p>Mengetahui,<br><?= $jabatan_2 ?></p>
            <p class="ttd-name"><?= $nama_2 ?></p>
            <p>NIP. <?= $nip_2 ?></p>
        </div>
        <div class="ttd-box">
            <p><?= $lokasi ?>, <?= tgl_indo($tgl_ttd) ?><br><?= $jabatan_1 ?></p>
            <p class="ttd-name"><?= $nama_1 ?></p>
            <p>NIP. <?= $nip_1 ?></p>
        </div>
    </div>

    <?php 
    // Trigger Print Otomatis jika mode PDF/Cetak
    if($aksi == 'pdf'){ 
        echo "<script>window.onload = function() { window.print(); }</script>";
    } 
    ?>

</body>
</html>