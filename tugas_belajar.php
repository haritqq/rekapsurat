    <header class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
        <h4 class="mb-0">Surat Keluar</h4><div><span>Halo, Admin!</span></div>
    </header>
    
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Table Tugas Belajar</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Tugas Belajar</button>
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
                $query = mysqli_query($koneksi, "SELECT * FROM tugas_bel ORDER BY id DESC");
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
                        <a href="index.php?page=edit_surat_masuk&id=<?= $data['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> <br>
                        <a href="proses_surat.php?act=hapus_izin&id=<?= $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>

                <div class="modal fade" id="modalEdit<?= $data['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Surat Masuk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="proses_surat.php?act=edit_masuk">
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                <div class="mb-2"><label>No Surat</label><input type="text" name="no_surat" class="form-control" value="<?= $data['no_surat']; ?>" required></div>
                                <div class="mb-2"><label>No Agenda</label><input type="text" name="no_agenda" class="form-control" value="<?= $data['no_agenda']; ?>" required></div>
                                <div class="mb-2"><label>Tgl Terima</label><input type="date" name="tgl_terima" class="form-control" value="<?= $data['tgl_terima']; ?>" required></div>
                                <div class="mb-2"><label>Pengirim</label><input type="text" name="pengirim" class="form-control" value="<?= $data['pengirim']; ?>" required></div>
                                <div class="mb-2"><label>Perihal</label><textarea name="perihal" class="form-control" required><?= $data['perihal']; ?></textarea></div>
                                <div class="mb-2"><label>Tgl Masuk Bidang</label><input type="date" name="tgl_msk_bidang" class="form-control" value="<?= $data['tgl_msk_bidang']; ?>" required></div>
                                <hr>
                                <h6>Disposisi & Teruskan</h6>
                                <div class="mb-2">
                                    <label>Diteruskan Kepada</label>
                                    <input type="text" name="diteruskan_kepada" class="form-control" value="<?= $data['diteruskan_kepada']; ?>">
                                </div>
                                <div class="mb-2">
                                    <label>Nomor WhatsApp</label>
                                    <input type="number" name="no_wa" class="form-control" value="<?= $data['no_wa']; ?>">
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
                <h5 class="modal-title">Tambah Surat Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="proses_surat.php?act=tambah_masuk">
            <div class="modal-body">
                <div class="mb-2"><label>No Surat</label><input type="text" name="no_surat" class="form-control" required></div>
                <div class="mb-2"><label>No Agenda</label><input type="text" name="no_agenda" class="form-control" required></div>
                <div class="mb-2"><label>Tgl Terima</label><input type="date" name="tgl_terima" class="form-control" required></div>
                <div class="mb-2"><label>Pengirim</label><input type="text" name="pengirim" class="form-control" required></div>
                <div class="mb-2"><label>Perihal</label><textarea name="perihal" class="form-control" required></textarea></div>
                <div class="mb-2"><label>Tgl Masuk Bidang</label><input type="date" name="tgl_msk_bidang" class="form-control" required></div>
                <hr>
                <h6>Disposisi & Teruskan</h6>
                <div class="mb-2">
                    <label>Diteruskan Kepada (Nama Pegawai)</label>
                    <input type="text" name="diteruskan_kepada" class="form-control" placeholder="Opsional">
                </div>
                <div class="mb-2">
                    <label>Nomor WhatsApp</label>
                    <input type="number" name="no_wa" class="form-control" placeholder="Contoh: 628123456789">
                    <small class="text-danger">*Awali dengan angka 62 (Kode Negara) agar link berfungsi</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>