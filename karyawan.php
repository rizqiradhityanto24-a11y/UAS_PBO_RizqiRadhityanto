<?php
// Karyawan.php

abstract class Karyawan {
    // Atribut Terenkapsulasi (Protected agar bisa diwariskan ke class anak)
    protected $id_karyawan;
    protected $nama_karyawan;
    protected $departemen;
    protected $hariKerjaMasuk;
    protected $gajiDasarPerhari;

    // Constructor untuk inisialisasi data awal
    public function __construct($id, $nama, $dept, $hariMasuk, $gajiDasar) {
        $this->id_karyawan = $id;
        $this->nama_karyawan = $nama;
        $this->departemen = $dept;
        $this->hariKerjaMasuk = $hariMasuk;
        $this->gajiDasarPerhari = $gajiDasar;
    }

    // ==========================================
    // METODE ABSTRAK (Wajib di-override di class anak)
    // ==========================================
    abstract public function hitungGajiBersih();
    abstract public function tampilkanProfilKaryawan();

    // ==========================================
    // GETTER & SETTER (Enkapsulasi Akses Data)
    // ==========================================
    
    public function getIdKaryawan() { 
        return $this->id_karyawan; 
    }
    public function setIdKaryawan($id) { 
        $this->id_karyawan = $id; 
    }

    public function getNamaKaryawan() { 
        return $this->nama_karyawan; 
    }
    public function setNamaKaryawan($nama) { 
        $this->nama_karyawan = $nama; 
    }

    public function getDepartemen() { 
        return $this->departemen; 
    }
    public function setDepartemen($dept) { 
        $this->departemen = $dept; 
    }

    public function getHariKerjaMasuk() { 
        return $this->hariKerjaMasuk; 
    }
    public function setHariKerjaMasuk($hari) { 
        $this->hariKerjaMasuk = $hari; 
    }

    public function getGajiDasarPerhari() { 
        return $this->gajiDasarPerhari; 
    }
    public function setGajiDasarPerhari($gaji) { 
        $this->gajiDasarPerhari = $gaji; 
    }
}
?>