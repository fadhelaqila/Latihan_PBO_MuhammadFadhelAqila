<?php
// index.php

require_once 'koneksi/database.php';
require_once 'model/TiketRegular.php';
require_once 'model/TiketIMAX.php';
require_once 'model/TiketVelvet.php';

// Inisialisasi koneksi database
$database = new Database();
$db = $database->getConnection();

// [Tahap 6] Mengambil kata kunci pencarian dari form input
$kataKunci = isset($_GET['cari']) ? $_GET['cari'] : '';

// [Tahap 4] Mengambil data per jenis studio dari database secara OOP
$dataRegular = TiketRegular::ambilDataBerdasarkanJenis($db, $kataKunci);
$dataIMAX    = TiketIMAX::ambilDataBerdasarkanJenis($db, $kataKunci);
$dataVelvet  = TiketVelvet::ambilDataBerdasarkanJenis($db, $kataKunci);

// Menggabungkan semua objek ke dalam satu array besar polimorfisme
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
        <h2 class="text-primary fw-bold mb-1">🎬 SISTEM INFORMASI TIKET BIOSKOP</h2>
        <p class="text-muted mb-3">Simulasi UAS PBO - Aplikasi Basis Data Terpadu</p>
        <div class="badge bg-dark p-2 fs-6 mb-2">Nama: Muhammad Fadhel Aqila</div>
        <hr>

        <form action="" method="GET" class="row g-2 justify-content-center my-2">
            <div class="col-md-6">
                <input type="text" name="cari" class="form-control" placeholder="Ketik judul film yang ingin dicari..." value="<?php echo htmlspecialchars($kataKunci); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">🔍 Cari Film</button>
            </div>
            <?php if (!empty($kataKunci)): ?>
                <div class="col-md-1">
                    <a href="index.php" class="btn btn-outline-danger w-100">Reset</a>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <div class="card shadow-sm border-0 p-4 bg-white">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID Tiket</th>
                        <th>Judul Film</th>
                        <th>Jadwal Tayang</th>
                        <th>Jumlah Kursi</th>
                        <th>Harga Dasar</th>
                        <th class="text-success">Total Bayar (Override)</th>
                        <th>Tipe Kelas & Fasilitas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($semuaTiket) > 0): ?>
                        <?php foreach ($semuaTiket as $tiket): ?>
                            <tr>
                                <td><strong>#<?php echo $tiket->id_tiket; ?></strong></td>
                                <td class="fw-bold text-dark"><?php echo $tiket->nama_film; ?></td>
                                <td><?php echo $tiket->jadwal_tayang; ?></td>
                                <td><span class="badge bg-info text-dark"><?php echo $tiket->jumlah_kursi; ?> Kursi</span></td>
                                <td>Rp <?php echo number_format($tiket->hargaDasarTiket, 0, ',', '.'); ?></td>
                                
                                <td class="fw-bold text-success">
                                    Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?>
                                </td>
                                
                                <td>
                                    <span class="badge bg-secondary mb-1"><?php echo get_class($tiket); ?></span>
                                    <br>
                                    <small class="text-muted"><?php echo $tiket->tampilkanInfoFasilitas(); ?></small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-danger py-4">Film "<strong><?php echo htmlspecialchars($kataKunci); ?></strong>" tidak ditemukan.</td>
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