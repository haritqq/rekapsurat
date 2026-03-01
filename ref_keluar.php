    <header class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
        <h4 class="mb-0">Referensi</h4><div><span>Halo, Admin!</span></div>
    </header>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Kode Surat Keluar</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Referensi</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Surat</th>
                    <th>Tujuan</th>
                    <th>Instansi</th>
                    <th>Pengirim</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM ref_keluar ORDER BY id DESC");
                while($data = mysqli_fetch_array($query)){
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['no_surat']?? '-';; ?></td>
                    <td><?= $data['tujuan']?? '-';; ?></td>
                    <td><?= $data['instansi']?? '-';; ?></td>
                    <td><?= $data['pengirim']?? '-';; ?></td>
                    <td>
                        <a href="index.php?page=edit_surat_keluar&id=<?= $data['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus.php?type=keluar&id=<?= $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Referensi Surat Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="proses_surat.php?act=tambah_ref_keluar">
            <div class="modal-body">              
                <div class="mb-2"><label>No. Surat</label><input type="text" name="kode_surat" class="form-control" required></div>
                <div class="mb-2"><label>Tujuan</label><input type="text" name="nama_instansi" class="form-control" required></div>
                <div class="mb-2"><label>Instansi</label><input type="text" name="perihal" class="form-control" required></div>
                <div class="mb-2"><label>Pengirim</label><input type="text" name="ditunjukan" class="form-control" required></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>