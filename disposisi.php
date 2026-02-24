<div class="card">
    <div class="card-header">
        <h5>Disposisi Surat Masuk</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="proses_surat.php?act=tambah_disposisi">
            <div class="row">
                <div class="col-md-6">
                    <label>Pilih Surat Masuk</label>
                    <select name="id_surat_masuk" class="form-control">
                        <?php
                        $q = mysqli_query($koneksi, "SELECT * FROM surat_masuk");
                        while($row = mysqli_fetch_array($q)){
                            echo "<option value='".$row['id']."'>".$row['no_surat']." - ".$row['perihal']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Diteruskan Kepada</label>
                    <input type="text" name="diteruskan_kepada" class="form-control">
                </div>
            </div>
            <div class="mt-3">
                <label>Isi Instruksi</label>
                <textarea name="instruksi" class="form-control"></textarea>
            </div>
            <div class="mt-3">
                <label>Status Tindak Lanjut</label>
                <select name="status" class="form-control">
                    <option value="Belum">Belum</option>
                    <option value="Proses">Proses</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>
            <button class="btn btn-success mt-3">Simpan Disposisi</button>
        </form>
        
        <hr>
        <h6>Riwayat Disposisi</h6>
        <table class="table table-sm">
            <tr><th>No Surat</th><th>Tgl Disposisi</th><th>Kepada</th><th>Instruksi</th><th>Status</th></tr>
            <?php
            $q_dis = mysqli_query($koneksi, "SELECT disposisi.*, surat_masuk.no_surat FROM disposisi JOIN surat_masuk ON disposisi.id_surat_masuk = surat_masuk.id");
            while($d = mysqli_fetch_array($q_dis)){
                echo "<tr>
                    <td>{$d['no_surat']}</td>
                    <td>{$d['tgl_disposisi']}</td>
                    <td>{$d['diteruskan_kepada']}</td>
                    <td>{$d['instruksi']}</td>
                    <td><span class='badge bg-info'>{$d['status_tindak_lanjut']}</span></td>
                </tr>";
            }
            ?>
        </table>
    </div>
</div>