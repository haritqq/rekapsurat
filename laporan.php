<div class="card shadow-sm">
    <div class="card-header bg-primary text-white"><h5>Cetak Laporan Administrasi</h5></div>
    <div class="card-body">
        <form action="export_laporan.php" method="POST" target="_blank">
            
            <h6 class="mb-3 border-bottom pb-2">Filter Data Laporan</h6>
            <div class="row align-items-end mb-4">
                <div class="col-md-4 mb-2">
                    <label>Jenis Laporan</label>
                    <select name="jenis" class="form-control" required>
                        <option value="masuk">Surat Masuk</option>
                        <option value="keluar">Surat Keluar</option>
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
            </div>

            <h6 class="mb-3 border-bottom pb-2">Pengaturan Tanda Tangan</h6>
            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <label>Lokasi (Misal: Jakarta)</label>
                    <input type="text" name="lokasi" class="form-control" required>
                </div>
                <div class="col-md-6 mb-2">
                    <label>Tanggal Penandatanganan</label>
                    <input type="date" name="tgl_ttd" class="form-control" required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="text-center font-weight-bold">Penanggung Jawab</h6>
                        <label>Jabatan</label>
                        <input type="text" name="jabatan_1" class="form-control mb-2" required>
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_1" class="form-control mb-2" required>
                        <label>NIP</label>
                        <input type="text" name="nip_1" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="text-center font-weight-bold">Pimpinan / Atasan</h6>
                        <label>Jabatan</label>
                        <input type="text" name="jabatan_2" class="form-control mb-2" required>
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_2" class="form-control mb-2" required>
                        <label>NIP</label>
                        <input type="text" name="nip_2" class="form-control">
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" name="aksi" value="pdf" class="btn btn-danger px-4">
                    <i class="fas fa-print"></i> Cetak / PDF Landscape
                </button>
                <button type="submit" name="aksi" value="excel" class="btn btn-success px-4">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
            </div>
        </form>
    </div>
</div>