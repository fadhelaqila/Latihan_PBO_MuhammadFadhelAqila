CREATE TABLE tabel_tiket (
    id_tiket INT AUTO_INCREMENT PRIMARY KEY,
    nama_film VARCHAR(100) NOT NULL,
    jadwal_tayang DATETIME NOT NULL,
    jumlah_kursi INT NOT NULL,
    harga_dasar_tiket DECIMAL(10, 2) NOT NULL,
    jenis_studio ENUM('Regular', 'IMAX', 'Velvet') NOT NULL,
    
    -- Atribut Spesifik Anak (Bisa bernilai NULL)
    tipe_audio VARCHAR(50) NULL,
    lokasi_baris VARCHAR(10) NULL,
    kacamata_3d_id VARCHAR(50) NULL,
    efek_gerak_fitur VARCHAR(50) NULL,
    bantal_selimut_pack VARCHAR(50) NULL,
    layanan_butler VARCHAR(50) NULL
);

INSERT INTO tabel_tiket (nama_film, jadwal_tayang, jumlah_kursi, harga_dasar_tiket, jenis_studio, tipe_audio, lokasi_baris, kacamata_3d_id, efek_gerak_fitur, bantal_selimut_pack, layanan_butler) VALUES
-- 1-7: DATA STUDIO REGULAR (Hanya mengisi tipe_audio & lokasi_baris)
('Avengers: Endgame', '2026-06-20 13:00:00', 2, 40000.00, 'Regular', 'Dolby Atmos 7.1', 'Baris E-F', NULL, NULL, NULL, NULL),
('Spiderman: No Way Home', '2026-06-20 15:30:00', 3, 40000.00, 'Regular', 'Standard Stereo', 'Baris G-H', NULL, NULL, NULL, NULL),
('The Batman', '2026-06-20 19:00:00', 1, 45000.00, 'Regular', 'Dolby Atmos 7.1', 'Baris C', NULL, NULL, NULL, NULL),
('Joker: Folie a Deux', '2026-06-21 11:00:00', 4, 40000.00, 'Regular', 'Standard Stereo', 'Baris A-B', NULL, NULL, NULL, NULL),
('KKN di Desa Penari', '2026-06-21 14:15:00', 2, 35000.00, 'Regular', 'Dolby Digital 5.1', 'Baris D', NULL, NULL, NULL, NULL),
('Pengabdi Setan 2', '2026-06-21 17:00:00', 2, 35000.00, 'Regular', 'Dolby Digital 5.1', 'Baris F', NULL, NULL, NULL, NULL),
('Agak Laen', '2026-06-21 20:00:00', 5, 45000.00, 'Regular', 'Standard Stereo', 'Baris G-I', NULL, NULL, NULL, NULL),

-- 8-14: DATA STUDIO IMAX (Hanya mengisi kacamata_3d_id & efek_gerak_fitur)
('Avatar: The Way of Water', '2026-06-22 14:00:00', 2, 60000.00, 'IMAX', NULL, NULL, 'IMAX-3D-99X', 'Aktif (Getaran & Angin)', NULL, NULL),
('Interstellar', '2026-06-22 19:00:00', 1, 65000.00, 'IMAX', NULL, NULL, 'IMAX-3D-45A', 'Non-Aktif', NULL, NULL),
('Dune: Part Two', '2026-06-23 13:00:00', 2, 70000.00, 'IMAX', NULL, NULL, 'IMAX-3D-11B', 'Aktif (Guncangan Penuh)', NULL, NULL),
('Oppenheimer', '2026-06-23 16:30:00', 2, 70000.00, 'IMAX', NULL, NULL, 'IMAX-2D-NONE', 'Non-Aktif (Fokus Audio)', NULL, NULL),
('Top Gun: Maverick', '2026-06-23 20:45:00', 3, 65000.00, 'IMAX', NULL, NULL, 'IMAX-2D-NONE', 'Aktif (Simulasi Jet)', NULL, NULL),
('Godzilla x Kong', '2026-06-24 10:30:00', 2, 60000.00, 'IMAX', NULL, NULL, 'IMAX-3D-88Z', 'Aktif (Getaran Gempa)', NULL, NULL),
('Doctor Strange 2', '2026-06-24 13:45:00', 1, 60000.00, 'IMAX', NULL, NULL, 'IMAX-3D-22C', 'Aktif (Efek Ruang)', NULL, NULL),

-- 15-20: DATA STUDIO VELVET (Hanya mengisi bantal_selimut_pack & layanan_butler)
('Inception', '2026-06-25 20:00:00', 2, 100000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Premium Pack (2 Bantal, 2 Selimut)', 'Tersedia (Tombol Panggil)'),
('Titanic', '2026-06-25 16:00:00', 2, 120000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Sofa Bed Deluxe Pack', 'Tersedia (Personal Butler)'),
('La La Land', '2026-06-26 18:30:00', 2, 100000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Standard Velvet Pack', 'Tersedia (Tombol Panggil)'),
('The Godfather', '2026-06-26 21:30:00', 2, 150000.00, 'Velvet', NULL, NULL, NULL, NULL, 'VIP Gold Pack', 'Tersedia (Personal Butler)'),
('Gisaengchung (Parasite)', '2026-06-27 15:00:00', 2, 100000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Standard Velvet Pack', 'Tidak Tersedia'),
('Past Lives', '2026-06-27 19:00:00', 2, 110000.00, 'Velvet', NULL, NULL, NULL, NULL, 'Deluxe Couple Pack', 'Tersedia (Tombol Panggil)');