<?php
// index.php

// 1. Import semua file koneksi dan subclass model yang dibutuhkan
require_once 'koneksi/database.php';
require_once 'model/TiketRegular.php';
require_once 'model/TiketIMAX.php';
require_once 'model/TiketVelvet.php';

// 2. Buat koneksi ke database
$database = new Database();
$db = $database->getConnection();

// 3. Tangkap kata kunci pencarian jika user mengetik sesuatu di kolom Cari (Tahap 6)
$kataKunci = isset($_GET['cari']) ? $_GET['cari'] : '';

// 4. Ambil data spesifik berdasarkan jenisnya lewat Query WHERE masing-masing subclass (Tahap 4)
// Parameter $kataKunci dilemparkan agar fitur searching langsung menyaring query SQL
$dataRegular = TiketRegular::ambilDataBerdasarkanJenis($db, $kataKunci);
$dataIMAX    = TiketIMAX::ambilDataBerdasarkanJenis($db, $kataKunci);
$dataVelvet  = TiketVelvet::ambilDataBerdasarkanJenis($db, $kataKunci);

// 5. Gabungkan semua objek tiket ke dalam satu array besar (Konsep Polimorfisme)
$semuaTiket = array_merge($dataRegular, $dataIMAX, $dataVelvet);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Tiket Bioskop - Muhammad Fadhel Aqila</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="card shadow-sm border-0 p-4 mb-4 bg-white text-center">
        <h2 class="text-primary fw-bold mb-1">🎬 SISTEM MANAJEMEN TIKET CINEMA</h2>
        <p class="text-muted mb-3">Simulasi UAS PBO - Temuan OOP Komplit</p>
        <div class="badge bg-secondary p-2 fs-6">Nama: Muhammad Fadhel Aqila</div>
        <hr class="mt-4">

        <form action="" method="GET" class="row g-2 justify-content-center my-2">
            <div class="col-md-6">
                <input type="text" name="cari" class="form-control form-control-lg" placeholder="Masukkan judul film yang ingin dicari..." value="<?php echo htmlspecialchars($kataKunci); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-lg w-100">🔍 Cari</button>
            </div>
            <?php if (!empty($kataKunci)): ?>
                <div class="col-md-1">
                    <a href="index.php" class="btn btn-outline-danger btn-lg w-100">Reset</a>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <div class="card shadow-sm border-0 p-4 bg-white">
        <h5 class="mb-3 text-secondary fw-bold">Daftar Transaksi Tiket Terdaftar</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID Tiket</th>
                        <th>Judul Film</th>
                        <th>Jadwal Tayang</th>
                        <th>Jumlah Kursi</th>
                        <th>Harga Dasar</th>
                        <th class="table-primary text-dark text-center">Total Bayar (Override)</th>
                        <th>Fasilitas & Detail Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($semuaTiket) > 0): ?>
                        <?php foreach ($semuaTiket as $tiket): ?>
                            <tr>
                                <td><strong>#<?php echo $tiket->getIdTiket(); ?></strong></td>
                                <td class="fw-semibold text-dark"><?php echo $tiket->getNamaFilm(); ?></td>
                                <td><small class="text-muted"><?php echo $tiket->getJadwalTayang(); ?></small></td>
                                <td><span class="badge bg-info text-dark px-3 py-2"><?php echo $tiket->getJumlahKursi(); ?> Kursi</span></td>
                                <td>Rp <?php echo number_format($tiket->getHargaDasar(), 0, ',', '.'); ?></td>
                                
                                <td class="text-center fw-bold text-success fs-5">
                                    Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?>
                                </td>
                                
                                <td>
                                    <span class="d-block mb-1 fw-bold text-secondary">
                                        ✨ <?php echo get_class($tiket); ?> </span>
                                    <small class="text-muted"><?php echo $tiket->tampilkanInfoFasilitas(); ?></small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-danger py-5 fw-semibold">
                                ❌ Film dengan kata kunci "<strong><?php echo htmlspecialchars($kataKunci); ?></strong>" tidak dapat ditemukan!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>