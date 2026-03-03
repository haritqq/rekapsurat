    <header class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
        <h4 class="mb-0">Surat Keluar</h4><div><span>Halo, Admin!</span></div>
    </header>
    
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Table Surat Masuk</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Surat</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Surat</th>
                        <th>No Agenda</th>
                        <th>Tgl Terima</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Penanggung Jawab</th>
                        <th>Tgl Masuk Bidang</th>
                        <th>Diteruskan Kepada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM surat_keluar ORDER BY id DESC");
                    while($data = mysqli_fetch_array($query)){
                        
                        // Membuat format pesan WhatsApp secara dinamis
                        $pesanWA = "Halo, ada pemberitahuan Surat Masuk untuk Anda.\n\n";
                        $pesanWA .= "*No Surat:* " . $data['no_surat'] . "\n";
                        $pesanWA .= "*Tanggal Terima:* " . $data['tgl_terima'] . "\n";
                        $pesanWA .= "*Pengirim:* " . $data['pengirim'] . "\n";
                        $pesanWA .= "*Perihal:* " . $data['perihal'];
                        
                        // Encode URL agar enter dan spasi terbaca oleh WhatsApp
                        $pesanEncoded = urlencode($pesanWA);
                        // Link WhatsApp API (Pastikan nomor WA ada dan formatnya 628...)
                        $linkWA = "https://wa.me/" . ($data['no_wa'] ?? '') . "?text=" . $pesanEncoded;
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['no_surat']; ?></td>
                        <td><?= $data['no_agenda'] ?? '-'; ?></td>
                        <td><?= $data['tgl_terima']; ?></td>
                        <td><?= $data['pengirim']; ?></td>
                        <td><?= $data['perihal']; ?></td>
                        <td><?= $data['penaggung_jwb'] ?? '-'; ?></td>
                        <td><?= $data['masuk_ke'] ?? '-'; ?></td>
                        <td>
                            <?php if(!empty($data['no_wa'])): ?>
                            <a href="<?= $linkWA; ?>" target="_blank" class="btn btn-success btn-sm mb-1" title="Teruskan via WA">
                                💬 <strong><?= $data['diteruskan_kepada'] ?? '-'; ?></strong>
                            </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?page=edit_ref_keluark&id=<?= $data['id']; ?>" class="btn btn-warning btn-sm mb-1"><i class="fas fa-edit"></i></a>
                            <a href="proses_surat.php?act=hapus_ref_keluark&id=<?= $data['id']; ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin hapus?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
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
                <div class="mb-2"><label>Tgl Surat</label><input type="date" name="tgl_surat" class="form-control" required></div>
                <div class="mb-2"><label>Tgl Terima</label><input type="date" name="tgl_terima" class="form-control" required></div>
                <div class="mb-2"><label>Pengirim</label><input type="text" name="pengirim" class="form-control" required></div>
                <div class="mb-2"><label>Perihal</label><textarea name="perihal" class="form-control" required></textarea></div>
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