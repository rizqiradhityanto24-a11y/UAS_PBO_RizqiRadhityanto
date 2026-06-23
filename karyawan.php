<?php
// Karyawan.php

abstract class Karyawan {
    protected $id_karyawan;
    protected $nama_karyawan;
    protected $departemen;
    protected $hariKerjaMasuk;
    protected $gajiDasarPerhari;

    public function __construct($id, $nama, $dept, $hariMasuk, $gajiDasar) {
        $this->id_karyawan = $id;
        $this->nama_karyawan = $nama;
        $this->departemen = $dept;
        $this->hariKerjaMasuk = $hariMasuk;
        $this->gajiDasarPerhari = $gajiDasar;
    }

    abstract public function hitungGajiBersih();
    abstract public function tampilkanProfilKaryawan();

    // Getter & Setter Utama
    public function getIdKaryawan() { return $this->id_karyawan; }
    public function getNamaKaryawan() { return $this->nama_karyawan; }
    public function getDepartemen() { return $this->departemen; }
    public function getHariKerjaMasuk() { return $this->hariKerjaMasuk; }
    public function getGajiDasarPerhari() { return $this->gajiDasarPerhari; }
}
?>