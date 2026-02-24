<div class="card">
    <div class="card-header"><h5>Cetak Laporan</h5></div>
    <div class="card-body">
        <form action="export_excel.php" method="GET" target="_blank">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label>Jenis Laporan</label>
                    <select name="jenis" class="form-control">
                        <option value="masuk">Surat Masuk</option>
                        <option value="keluar">Surat Keluar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Bulan</label>
                    <input type="month" name="periode" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="aksi" value="cetak" class="btn btn-secondary">Cetak (Print)</button>
                    <button type="submit" name="aksi" value="excel" class="btn btn-success">Export Excel</button>
                </div>
            </div>
        </form>
    </div>
</div>