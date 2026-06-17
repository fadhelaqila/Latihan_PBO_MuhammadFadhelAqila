<?php
// model/TiketVelvet.php

require_once 'Tiket.php';

class TiketVelvet extends Tiket {
    
    // [Tahap 4] Method Static dengan Query WHERE untuk jenis Velvet
    public static function ambilDataBerdasarkanJenis($db, $kataKunci = '') {
        $daftarTiket = [];
        if ($db === null) return $daftarTiket;

        // Query WHERE khusus untuk mengambil data tiket Velvet
        $query = "SELECT * FROM tabel_tiket WHERE jenis_studio = 'Velvet'";
        
        if (!empty($kataKunci)) {
            $query .= " AND nama_film LIKE '%" . $db->real_escape_string($kataKunci) . "%'";
        }
        
        $result = $db->query($query);
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $daftarTiket[] = new TiketVelvet(
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

    // [Tahap 5] Overriding hitungTotalHarga - (Surcharge 50% / dikali 1.50)
    public function hitungTotalHarga() {
        return ($this->jumlah_kursi * $this->hargaDasarTiket) * 1.50;
    }

    public function tampilkanInfoFasilitas() {
        return "Fasilitas Velvet: Sofa Bed Mewah, Bantal, Selimut, & Butler Service.";
    }
}
?>