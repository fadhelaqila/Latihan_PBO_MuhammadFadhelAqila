<?php
// koneksi/database.php

class Database {
    // 1. Menentukan atribut/properti kredensial database
    private $host = "localhost";
    private $username = "root";
    private $password = ""; // Secara default, password Laragon/XAMPP adalah kosong
    private $db_name = "db_latihan_pbo_trpl1b_muhammadfadhelaqila."; // Harus sama persis dengan nama DB di phpMyAdmin
    public $conn;

    // 2. Membuat method/fungsi untuk membuka koneksi
    public function getConnection() {
        $this->conn = null;
        
        try {
            // Membuat objek koneksi baru menggunakan Driver MySQLi bawaan PHP (gaya OOP)
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            // Memeriksa apakah terjadi error saat menghubungkan
            if ($this->conn->connect_error) {
                throw new Exception("Koneksi gagal: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            // Menampilkan pesan jika koneksi gagal bermasalah
            echo "Error Koneksi: " . $e->getMessage();
        }
        
        // Mengembalikan objek koneksi yang berhasil dibuat
        return $this->conn;
    }
}
?>