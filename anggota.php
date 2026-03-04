    <header class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
        <h4 class="mb-0">Data Pegawai</h4><div><span>Halo, Admin!</span></div>
    </header>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Table Data Pegawai</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Referensi</button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>NIP</th>
                    <th>Pangkat/Gol</th>
                    <th>Jenis Kelamin</th>
                    <th>Posisi Ruang</th>
                    <th>No. Handphone</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM ref_anggota ORDER BY id DESC");
                while($data = mysqli_fetch_array($query)){
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['nama']?? '-';; ?></td>
                    <td><?= $data['jabatan']?? '-';; ?></td>
                    <td><?= $data['nip']?? '-';; ?></td>
                    <td><?= $data['pangkat_gol']?? '-';; ?></td>
                    <td><?= $data['jenis_kelamin']?? '-';; ?></td>
                    <td><?= $data['posisi_ruang']?? '-';; ?></td>
                    <td><?= $data['no_telp']?? '-';; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['id']; ?>"><i class="fas fa-edit"></i></button>
                        <a href="proses_surat.php?act=hapus_ref_anggota&id=<?= $data['id']; ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>

                <div class="modal fade" id="modalEdit<?= $data['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Anggota</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="proses_surat.php?act=edit_ref_anggota">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                    <div class="mb-2">
                                        <label>Nama</label>
                                        <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control" value="<?= $data['jabatan']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>NIP</label>
                                        <input type="text" name="nip" class="form-control" value="<?= $data['nip']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Pangkat / Gol</label>
                                        <input type="text" name="pangkat_gol" class="form-control" value="<?= $data['pangkat_gol']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-select" required>
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="Laki-laki" <?= ($data['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                            <option value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label>Posisi Ruang</label>
                                        <input type="text" name="posisi_ruang" class="form-control" value="<?= $data['posisi_ruang']; ?>" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Pengirim</label>
                                        <input type="text" name="no_telp" class="form-control" value="<?= $data['no_telp']; ?>" required>
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
                <h5 class="modal-title">Tambah Data Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="proses_surat.php?act=tambah_ref_anggota">
            <div class="modal-body">              
                <div class="mb-2"><label>Nama</label><input type="text" name="nama" class="form-control" required></div>
                <div class="mb-2"><label>Jabatan</label><input type="text" name="jabatan" class="form-control" required></div>
                <div class="mb-2"><label>NIP</label><input type="text" name="nip" class="form-control" required></div>
                <div class="mb-2"><label>Pangkat / Gol</label><input type="text" name="pangkat_gol" class="form-control" required></div>
                <div class="mb-2">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">--Pilih--</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="mb-2"><label>Posisi Ruang</label><input type="text" name="posisi_ruang" class="form-control" required></div>
                <div class="mb-2"><label>No. Hp</label><input type="text" name="no_telp" class="form-control" required></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>