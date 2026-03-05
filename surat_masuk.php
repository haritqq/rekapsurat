    <header class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
        <h4 class="mb-0">Surat Masuk</h4><div><span>Halo, Admin!</span></div>
    </header>
    
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Table Surat Masuk</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Surat</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead style="text-align: center; vertical-align: middle;">
                    <tr>
                        <th>No</th>
                        <th>No Surat</th>
                        <th>No Agenda</th>
                        <th>Diterima</th>
                        <th>Pengirim / Instansi</th>
                        <th>Perihal</th>
                        <th>Masuk Bidang</th>                        
                        <th>Diteruskan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM surat_masuk ORDER BY id DESC");
                while($data = mysqli_fetch_array($query)){
                    
                    $pesanWA = "Halo, ada pemberitahuan Surat Masuk untuk Anda.\n\n";
                    $pesanWA .= "*No Surat:* " . $data['no_surat'] . "\n";
                    $pesanWA .= "*Tanggal Terima:* " . $data['tgl_terima'] . "\n";
                    $pesanWA .= "*Pengirim:* " . $data['pengirim'] . "\n";
                    $pesanWA .= "*Perihal:* " . $data['perihal'];
                    
                    $pesanEncoded = urlencode($pesanWA);
                    $linkWA = "https://wa.me/" . ($data['no_wa'] ?? '') . "?text=" . $pesanEncoded;
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['no_surat']; ?></td>
                    <td><?= $data['no_agenda'] ?? '-'; ?></td>
                    <td><?= $data['tgl_terima']; ?></td>
                    <td><?= $data['pengirim']; ?></td>
                    <td><?= $data['perihal']; ?></td>
                    <td><?= $data['tgl_msk_bidang'] ?? '-'; ?></td>
                    <td>
                        <?php if(!empty($data['no_wa'])): ?>
                        <a href="<?= $linkWA; ?>" target="_blank" class="btn btn-success btn-sm mb-1" title="Teruskan via WA">
                            💬 <strong><?= $data['diteruskan_kepada'] ?? '-'; ?></strong>
                        </a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $data['id']; ?>"><i class="fas fa-edit"></i></button>
                        <a href="proses_surat.php?act=hapus_masuk&id=<?= $data['id']; ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
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
                                    <label>Diteruskan Kepada (Nama Pegawai)</label>
                                    <select name="diteruskan_kepada" id="edit_pilih_pegawai" class="form-select">
                                        <option value="">-- Pilih Pegawai --</option>
                                        <?php
                                        // Ambil data dari tabel ref_anggota
                                        $sql_anggota = mysqli_query($koneksi, "SELECT nama, no_telp FROM ref_anggota ORDER BY nama ASC");
                                        while($row = mysqli_fetch_array($sql_anggota)){
                                            // Cek apakah nama ini adalah yang sebelumnya dipilih
                                            $selected = ($row['nama'] == $data['diteruskan_kepada']) ? 'selected' : '';
                                            
                                            echo "<option value='".$row['nama']."' data-wa='".$row['no_telp']."' $selected>".$row['nama']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label>Nomor WhatsApp</label>
                                    <input type="number" name="no_wa" id="edit_no_wa" class="form-control" value="<?= $data['no_wa']; ?>" readonly>
                                    <small class="text-danger">*Nomor akan terupdate otomatis saat nama pegawai diganti</small>
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
                    <select name="diteruskan_kepada" id="pilih_pegawai" class="form-select">
                        <option value="">-- Pilih Pegawai (Opsional) --</option>
                        <?php
                        // Ambil data nama dan no_telp dari tabel ref_anggota
                        $sql_anggota = mysqli_query($koneksi, "SELECT nama, no_telp FROM ref_anggota ORDER BY nama ASC");
                        while($row = mysqli_fetch_array($sql_anggota)){
                            // Simpan nomor telepon di atribut data-wa
                            echo "<option value='".$row['nama']."' data-wa='".$row['no_telp']."'>".$row['nama']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label>Nomor WhatsApp</label>
                    <input type="number" name="no_wa" id="no_wa" class="form-control" placeholder="Otomatis terisi" readonly>
                    <small class="text-danger">*Nomor otomatis muncul berdasarkan data anggota yang dipilih</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>