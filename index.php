<?php
// index.php

require_once 'koneksi/database.php';
require_once 'model/TiketRegular.php';
require_once 'model/TiketIMAX.php';
require_once 'model/TiketVelvet.php';

// Inisialisasi koneksi database
$database = new Database();
$db = $database->getConnection();

// Mengambil kata kunci pencarian dari form input
$kataKunci = isset($_GET['cari']) ? $_GET['cari'] : '';

// Mengambil data per jenis studio dari database secara OOP
$dataRegular = TiketRegular::ambilDataBerdasarkanJenis($db, $kataKunci);
$dataIMAX    = TiketIMAX::ambilDataBerdasarkanJenis($db, $kataKunci);
$dataVelvet  = TiketVelvet::ambilDataBerdasarkanJenis($db, $kataKunci);

// Menggabungkan semua objek ke dalam satu array besar polimorfisme
$semuaTiket = array_merge($dataRegular, $dataIMAX, $dataVelvet);

// Logika mendeteksi tab aktif saat searching agar layout tidak melompat
$tabAktif = "all";
if (!empty($kataKunci)) {
    if (count($dataRegular) > 0 && count($dataIMAX) == 0 && count($dataVelvet) == 0) $tabAktif = "regular";
    elseif (count($dataIMAX) > 0 && count($dataRegular) == 0 && count($dataVelvet) == 0) $tabAktif = "imax";
    elseif (count($dataVelvet) > 0 && count($dataRegular) == 0 && count($dataIMAX) == 0) $tabAktif = "velvet";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Dashboard Admin - Modern OOP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        :root {
            --bg-main: #090d16;
            --bg-sidebar: #0f1524;
            --bg-card: rgba(20, 29, 47, 0.7);
            --primary-gradient: linear-gradient(135deg, #3b82f6, #7c3aed);
            --text-muted-custom: #94a3b8;
            --border-custom: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-main);
            color: #f1f5f9;
            overflow-x: hidden;
        }

        /* LAYOUT DASHBOARD UTAMA */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR (MENU SAMPING STATIS) */
        .sidebar {
            width: 280px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-custom);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 24px;
            font-size: 1.4rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            border-bottom: 1px solid var(--border-custom);
        }

        .sidebar-menu {
            padding: 20px 14px;
            flex-grow: 1;
        }

        .nav-pills-custom .nav-link {
            color: var(--text-muted-custom);
            background: transparent;
            border: 1px solid transparent;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.25s ease;
            text-align: left;
            width: 100%;
        }

        .nav-pills-custom .nav-link i {
            font-size: 1.2rem;
            margin-right: 12px;
        }

        .nav-pills-custom .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.03);
        }

        .nav-pills-custom .nav-link.active {
            background: var(--primary-gradient);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        /* KONTEN UTAMA KANAN */
        .main-content {
            flex-grow: 1;
            margin-left: 280px; /* Memberi ruang untuk sidebar fixed */
            padding: 40px;
            min-width: 0; /* Mencegah flexbox overflow */
        }

        /* TOPBAR SEARCH */
        .top-search-bar {
            background: var(--bg-card);
            border: 1px solid var(--border-custom);
            border-radius: 12px;
            padding: 8px 16px;
        }

        .search-input {
            background: transparent;
            border: none;
            color: #ffffff;
            outline: none;
            width: 100%;
        }

        .search-input::placeholder {
            color: #64748b;
        }

        /* KARTU GLASSMORPHISM */
        .glass-panel {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-custom);
            border-radius: 16px;
            padding: 28px;
            margin-top: 30px;
        }

        /* PENGATURAN KECERAHAN TEKS TABEL */
        .table-premium th {
            background-color: #0f172a !important;
            color: #ffffff !important;
            font-weight: 600;
            border-bottom: 2px solid var(--border-custom);
        }

        .table-premium td {
            color: #e2e8f0 !important; /* Membuat data teks umum menjadi terang */
        }

        .text-id {
            color: #3b82f6 !important;
            font-weight: 600;
        }

        .text-jadwal {
            color: #cbd5e1 !important; /* Putih terang cerah */
        }

        .text-fasilitas-deskripsi {
            color: #e2e8f0 !important; /* Putih terang untuk info metode abstrak */
            font-size: 0.82rem;
            line-height: 1.4;
        }

        .badge-studio {
            padding: 6px 12px;
            font-weight: 600;
            border-radius: 6px;
        }
        .badge-reg { background-color: rgba(59, 130, 246, 0.2); color: #3b82f6; border: 1px solid #3b82f6; }
        .badge-imx { background-color: rgba(234, 179, 8, 0.2); color: #eab308; border: 1px solid #eab308; }
        .badge-vlv { background-color: rgba(236, 72, 153, 0.2); color: #ec4899; border: 1px solid #ec4899; }

        /* RESPONSIVE HANDLING */
        @media (max-width: 992px) {
            .sidebar { width: 80px; }
            .sidebar-brand span, .nav-link span { display: none; }
            .main-content { margin-left: 80px; padding: 20px; }
            .sidebar-menu { padding: 20px 8px; }
            .nav-pills-custom .nav-link i { margin-right: 0; font-size: 1.4rem; width: 100%; text-align: center; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-film me-2"></i><span>Cinema Panel</span>
        </div>
        
        <div class="sidebar-menu">
            <div class="nav flex-column nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link <?php echo ($tabAktif == 'all') ? 'active' : ''; ?>" id="v-pills-all-tab" data-bs-toggle="pill" data-bs-target="#v-pills-all" type="button" role="tab">
                    <i class="bi bi-grid-fill"></i><span>Semua Studio</span>
                </button>
                <button class="nav-link <?php echo ($tabAktif == 'regular') ? 'active' : ''; ?>" id="v-pills-regular-tab" data-bs-toggle="pill" data-bs-target="#v-pills-regular" type="button" role="tab">
                    <i class="bi bi-ticket-perforated"></i><span>Studio Regular</span>
                </button>
                <button class="nav-link <?php echo ($tabAktif == 'imax') ? 'active' : ''; ?>" id="v-pills-imax-tab" data-bs-toggle="pill" data-bs-target="#v-pills-imax" type="button" role="tab">
                    <i class="bi bi-lightning-charge"></i><span>Studio IMAX 3D</span>
                </button>
                <button class="nav-link <?php echo ($tabAktif == 'velvet') ? 'active' : ''; ?>" id="v-pills-velvet-tab" data-bs-toggle="pill" data-bs-target="#v-pills-velvet" type="button" role="tab">
                    <i class="bi bi-gem"></i><span>Studio Velvet Suite</span>
                </button>
            </div>
        </div>
        
        <div class="p-3 border-top border-secondary border-opacity-25 text-center text-white-50 small">
        </div>
    </div>

    <div class="main-content">
        
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <h2 class="fw-bold m-0 text-white">Sistem Informasi Tiket Bioskop</h2>
            </div>
            <div class="col-md-6">
                <form action="" method="GET">
                    <div class="d-flex top-search-bar align-items-center">
                        <i class="bi bi-search text-muted me-3"></i>
                        <input type="text" name="cari" class="search-input" placeholder="Cari judul film..." value="<?php echo htmlspecialchars($kataKunci); ?>">
                        <?php if (!empty($kataKunci)): ?>
                            <a href="index.php" class="text-danger me-2 text-decoration-none small">Clear</a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary btn-sm px-3 rounded-8 fw-semibold">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="tab-content" id="v-pills-tabContent">
            
            <div class="tab-pane fade <?php echo ($tabAktif == 'all') ? 'show active' : ''; ?>" id="v-pills-all" role="tabpanel">
                <?php cetakMasterTabel($semuaTiket, "Seluruh Film Bioskop (" . count($semuaTiket) . " Data)"); ?>
            </div>

            <div class="tab-pane fade <?php echo ($tabAktif == 'regular') ? 'show active' : ''; ?>" id="v-pills-regular" role="tabpanel">
                <?php cetakMasterTabel($dataRegular, "Kategori: Kelas Regular"); ?>
            </div>

            <div class="tab-pane fade <?php echo ($tabAktif == 'imax') ? 'show active' : ''; ?>" id="v-pills-imax" role="tabpanel">
                <?php cetakMasterTabel($dataIMAX, "Kategori: Kelas IMAX 3D"); ?>
            </div>

            <div class="tab-pane fade <?php echo ($tabAktif == 'velvet') ? 'show active' : ''; ?>" id="v-pills-velvet" role="tabpanel">
                <?php cetakMasterTabel($dataVelvet, "Kategori: Kelas Velvet Suite"); ?>
            </div>

        </div>

    </div>
</div>

<?php
// RENDER TABEL UTAMA (Teks dioptimalkan terang benderang & kontras)
function cetakMasterTabel($arrayObjek, $judulTabel) {
    ?>
    <div class="glass-panel shadow-lg">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="m-0 fw-bold text-white"><i class="bi bi-layers-half text-primary me-2"></i><?php echo $judulTabel; ?></h4>
        </div>
        
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle border-0 table-premium">
                <thead>
                    <tr>
                        <th class="py-3">ID TIKET</th>
                        <th class="py-3">NAMA FILM</th>
                        <th class="py-3">JADWAL TAYANG</th>
                        <th class="py-3 text-center">JUMLAH KURSI</th>
                        <th class="py-3">HARGA DASAR</th>
                        <th class="py-3 text-success">TOTAL BAYAR</th>
                        <th class="py-3">FASILITAS UNIK (OOP ABSTRACT)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($arrayObjek) > 0): ?>
                        <?php foreach ($arrayObjek as $item): 
                            $namaKelasObjek = get_class($item);
                            $badgeClass = "badge-reg";
                            if ($namaKelasObjek == 'TiketIMAX') $badgeClass = "badge-imx";
                            if ($namaKelasObjek == 'TiketVelvet') $badgeClass = "badge-vlv";
                        ?>
                            <tr>
                                <td class="text-id">#<?php echo $item->id_tiket; ?></td>
                                
                                <td class="fw-bold text-white fs-6"><i class="bi bi-play-circle-fill text-primary text-opacity-70 me-2"></i><?php echo $item->nama_film; ?></td>
                                
                                <td class="text-jadwal"><?php echo date('d M Y - H:i', strtotime($item->jadwal_tayang)); ?> WIB</td>
                                
                                <td class="text-center">
                                    <span class="badge bg-light text-dark fw-bold px-2 py-1"><?php echo $item->jumlah_kursi; ?> Kursi</span>
                                </td>
                                
                                <td class="text-white fw-medium">Rp <?php echo number_format($item->hargaDasarTiket, 0, ',', '.'); ?></td>
                                
                                <td class="fw-bold text-success fs-6">Rp <?php echo number_format($item->hitungTotalHarga(), 0, ',', '.'); ?></td>
                                
                                <td>
                                    <span class="badge-studio <?php echo $badgeClass; ?> d-inline-block mb-1 small"><?php echo $namaKelasObjek; ?></span>
                                    <div class="text-fasilitas-deskripsi mt-1">
                                        <i class="bi bi-stars text-warning me-1"></i><?php echo $item->tampilkanInfoFasilitas(); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-danger py-5">
                                <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                Data pencarian film tidak ditemukan di dalam database.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>