    <header class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
        <h4 class="mb-0">Surat Keluar</h4><div><span>Halo, Admin!</span></div>
    </header>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Izin Testing</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Referensi</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Surat</th>
                    <th>Nama Instansi</th>
                    <th>Perihal</th>
                    <th>Tujuan</th>
                    <th>Ditunjukan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM ref_masuk ORDER BY id DESC");
                while($data = mysqli_fetch_array($query)){
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['kode_masuk']?? '-';; ?></td>
                    <td><?= $data['nama_instansi']?? '-';; ?></td>
                    <td><?= $data['perihal']?? '-';; ?></td>
                    <td><?= $data['tujuan']?? '-';; ?></td>
                    <td><?= $data['ditujukan']?? '-';; ?></td>
                    <td>
                        <a href="index.php?page=edit_surat_masuk&id=<?= $data['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus.php?type=masuk&id=<?= $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
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
                <h5 class="modal-title">Tambah Referensi Surat Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="proses_surat.php?act=tambah_ref_masuk">
            <div class="modal-body">              
                <div class="mb-2"><label>Kode Surat</label><input type="text" name="kode_surat" class="form-control" required></div>
                <div class="mb-2"><label>Nama Instansi</label><input type="text" name="nama_instansi" class="form-control" required></div>
                <div class="mb-2"><label>Perihal</label><input type="text" name="perihal" class="form-control" required></div>
                <div class="mb-2"><label>Tujuan</label><input type="text" name="tujuan" class="form-control" required></div>
                <div class="mb-2"><label>Ditunjukan</label><input type="text" name="ditunjukan" class="form-control" required></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>