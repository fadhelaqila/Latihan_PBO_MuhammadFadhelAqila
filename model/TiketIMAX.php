<?php
// model/TiketIMAX.php

require_once 'Tiket.php';

class TiketIMAX extends Tiket {
    
    // [Tahap 4] Method Static dengan Query WHERE untuk jenis IMAX
    public static function ambilDataBerdasarkanJenis($db, $kataKunci = '') {
        $daftarTiket = [];
        if ($db === null) return $daftarTiket;
        
        // Query WHERE khusus untuk mengambil data tiket IMAX
        $query = "SELECT * FROM db_latihan_pbo WHERE jenis_tiket = 'IMAX'";
        
        if (!empty($kataKunci)) {
            $query .= " AND nama_film LIKE '%" . $db->real_escape_string($kataKunci) . "%'";
        }
        
        $result = $db->query($query);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $daftarTiket[] = new TiketIMAX(
                    $row['id_tiket'],
                    $row['nama_film'],
                    $row['jadwal_tayang'],
                    $row['jumlah_kursi'],
                    $row['harga_dasar_tiket']
                );
            }
        }
        return $daftarTiket;
    }

    // [Tahap 5] Overriding hitungTotalHarga 
    public function hitungTotalHarga() {
        return ($this->jumlah_kursi * $this->hargaDasarTiket) + 35000;
    }

    public function tampilkanInfoFasilitas() {
        return "Fasilitas IMAX: Layar Lebar IMAX, Audio Dolby Atmos, & Kacamata 3D.";
    }
}
?>