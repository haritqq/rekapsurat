    <header class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
        <h4 class="mb-0">Surat Keluar</h4><div><span>Halo, Admin!</span></div>
    </header>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Kode Surat Masuk</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Referensi Masuk</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Masuk</th>
                    <th>Nama Instansi</th>
                    <th>Perihal</th>
                    <th>Tujuan</th>
                    <th>Ditujukan</th>
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
                        <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['id']; ?>"><i class="fas fa-edit"></i></button>
                        <a href="proses_surat.php?act=hapus_ref_masuk&id=<?= $data['id']; ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>

                <div class="modal fade" id="modalEdit<?= $data['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Ref. Surat Masuk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="proses_surat.php?act=edit_ref_masuk">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                    <div class="mb-2">
                                        <label>Kode Masuk</label>
                                        <input type="text" name="kode_masuk" class="form-control" value="<?= $data['kode_masuk']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Nama Instansi</label>
                                        <input type="text" name="nama_instansi" class="form-control" value="<?= $data['nama_instansi']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Perihal</label>
                                        <input type="text" name="perihal" class="form-control" value="<?= $data['perihal']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Tujuan</label>
                                        <input type="text" name="tujuan" class="form-control" value="<?= $data['tujuan']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Di Tujukan</label>
                                        <input type="text" name="ditujukan" class="form-control" value="<?= $data['ditujukan']; ?>" required>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

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
                <div class="mb-2"><label>Kode Surat</label><input type="text" name="kode_masuk" class="form-control" required></div>
                <div class="mb-2"><label>Nama Instansi</label><input type="text" name="nama_instansi" class="form-control" required></div>
                <div class="mb-2"><label>Perihal</label><input type="text" name="perihal" class="form-control" required></div>
                <div class="mb-2"><label>Tujuan</label><input type="text" name="tujuan" class="form-control" required></div>
                <div class="mb-2"><label>Ditujukan</label><input type="text" name="ditujukan" class="form-control" required></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>