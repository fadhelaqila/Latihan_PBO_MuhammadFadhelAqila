<?php
// model/Tiket.php

abstract class Tiket {
    // Properti diatur protected agar bisa diwarisi langsung oleh kelas anak
    public $id_tiket;
    public $nama_film;
    public $jadwal_tayang;
    public $jumlah_kursi;
    public $hargaDasarTiket;

    // Constructor untuk mengisi data awal objek
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $hargaDasarTiket) {
        $this->id_tiket = $id_tiket;
        $this->nama_film = $nama_film;
        $this->jadwal_tayang = $jadwal_tayang;
        $this->jumlah_kursi = $jumlah_kursi;
        $this->hargaDasarTiket = $hargaDasarTiket;
    }

    // Fungsi abstrak kosong yang WAJIB di-override oleh kelas anak
    abstract public function hitungTotalHarga();
    abstract public function tampilkanInfoFasilitas();
}
?>