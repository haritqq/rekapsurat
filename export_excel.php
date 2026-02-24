<?php
include 'koneksi.php';
$jenis = $_GET['jenis'];
$aksi = $_GET['aksi'];
$periode = $_GET['periode']; // format YYYY-MM

if($aksi == 'excel'){
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Surat.xls");
}

// Logic Query berdasarkan jenis
$table = ($jenis == 'masuk') ? 'surat_masuk' : 'surat_keluar';
$col_date = ($jenis == 'masuk') ? 'tgl_terima' : 'tgl_surat';

$query = mysqli_query($koneksi, "SELECT * FROM $table WHERE $col_date LIKE '$periode%'");

echo "<h3>Laporan Surat ".ucfirst($jenis)." - Periode $periode</h3>";
echo "<table border='1' width='100%'>
        <thead><tr><th>No Surat</th><th>Tanggal</th><th>Perihal</th></tr></thead>
        <tbody>";

while($row = mysqli_fetch_array($query)){
    echo "<tr>
            <td>'".$row['no_surat']."</td>
            <td>".$row[$col_date]."</td>
            <td>".$row['perihal']."</td>
          </tr>";
}
echo "</tbody></table>";

if($aksi == 'cetak'){
    echo "<script>window.print()</script>";
}
?>