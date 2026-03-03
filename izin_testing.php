    <header class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
        <h4 class="mb-0">Surat Keluar</h4><div><span>Halo, Admin!</span></div>
    </header>
    
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Table IZIN TESTING</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Izin Testing</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Pangkat / Gol</th>
                    <th>Instansi</th>
                    <th>No. SK</th>
                    <th>Lembaga</th>
                    <th>Penanda Tangan</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM izin_testing ORDER BY id DESC");
                while($data = mysqli_fetch_array($query)){
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['nama']?? '-';; ?></td>
                    <td><?= $data['nip']?? '-';; ?></td>
                    <td><?= $data['pangkat_gol']?? '-';; ?></td>
                    <td><?= $data['asal_instansi']?? '-';; ?></td>
                    <td><?= $data['no_sk']?? '-';; ?></td>
                    <td><?= $data['lembaga']?? '-';; ?></td>
                    <td><?= $data['ttd']?? '-';; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['id']; ?>"><i class="fas fa-edit"></i></button>
                        <a href="proses_surat.php?act=hapus_izin_testing&id=<?= $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>

                <div class="modal fade" id="modalEdit<?= $data['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Tugas Belajar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="proses_surat.php?act=edit_izin_testing">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                    <div class="mb-2">
                                        <label>Nama</label>
                                        <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>NIP</label>
                                        <input type="text" name="nip" class="form-control" value="<?= $data['nip']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Pangkat / Gol</label>
                                        <input type="text" name="pangkat" class="form-control" value="<?= $data['pangkat_gol']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Asal Instansi</label>
                                        <input type="text" name="instansi" class="form-control" value="<?= $data['asal_instansi']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>No SK</label>
                                        <input type="text" name="sk" class="form-control" value="<?= $data['no_sk']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Lembaga</label>
                                        <input type="text" name="lembaga" class="form-control" value="<?= $data['lembaga']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Penanda Tangan</label>
                                        <input type="text" name="tandatangan" class="form-control" value="<?= $data['ttd']; ?>">
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
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tugas Belajar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="proses_surat.php?act=tambah_izin_testing">
            <div class="modal-body">
                <div class="mb-2"><label>Nama</label><input type="text" name="nama" class="form-control" required></div>
                <div class="mb-2"><label>NIP</label><input type="text" name="nip" class="form-control" required></div>
                <div class="mb-2"><label>Pangkat / Gol</label><input type="text" name="pangkat" class="form-control" required></div>
                <div class="mb-2"><label>Instansi</label><input type="text" name="instansi" class="form-control" required></div>
                <div class="mb-2"><label>No. SK</label><input type="text" name="sk" class="form-control" required></div>
                <div class="mb-2"><label>Lembaga</label><input type="text" name="lembaga" class="form-control" required></div>
                <div class="mb-2"><label>Penanda Tangan</label><input type="text" name="tandatangan" class="form-control"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>