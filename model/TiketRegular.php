<?php
// model/TiketRegular.php

require_once 'Tiket.php';

class TiketRegular extends Tiket {
    
    // [Tahap 4] Method Static dengan Query WHERE sesuai instruksi dosen
    public static function ambilDataBerdasarkanJenis($db, $kataKunci = '') {
        $daftarTiket = [];
        if ($db === null) return $daftarTiket;

        // Query dasar: Memfilter data berdasarkan jenis_studio = 'Regular'
        $query = "SELECT * FROM tabel_tiket WHERE jenis_studio = 'Regular'";
        
        // Jika ada pencarian (Tahap 6), kita tambahkan kondisi WHERE ganda dengan AND
        if (!empty($kataKunci)) {
            $query .= " AND nama_film LIKE '%" . $db->real_escape_string($kataKunci) . "%'";
        }
        
        $result = $db->query($query);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Membuat objek instansiasi dari data database
                $daftarTiket[] = new TiketRegular(
                    $row['id_tiket'],
                    $row['nama_film'],
                    $row['jadwal_tayang'],
                    $row['jumlah_kursi'],
                    $row['hargaDasarTiket']
                );
            }
        }
        return $daftarTiket;
    }

    // [Tahap 5] Overriding hitungTotalHarga
    public function hitungTotalHarga() {
        return $this->jumlah_kursi * $this->hargaDasarTiket;
    }

    public function tampilkanInfoFasilitas() {
        return "Fasilitas Regular: Kursi Standar & Standard Sound System.";
    }
}
?>