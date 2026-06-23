<?php
// KaryawanMagang.php
require_once 'Karyawan.php';

class KaryawanMagang extends Karyawan {
    private $uangSakuBulanan;
    private $sertifikatKampusMerdeka;

    public function __construct($id, $nama, $dept, $hariMasuk, $gajiDasar, $uangSaku, $sertifikat) {
        parent::__construct($id, $nama, $dept, $hariMasuk, $gajiDasar);
        $this->uangSakuBulanan = $uangSaku;
        $this->sertifikatKampusMerdeka = $sertifikat;
    }

    public function hitungGajiBersih() {
        // gaji pokok (hari * gaji per hari) ditambahkan uang saku bulanan (jika ada)
        $gajiPokok = $this->hariKerjaMasuk * $this->gajiDasarPerhari;
        return $gajiPokok + ($this->uangSakuBulanan ?? 0);
    }

    public function tampilkanProfilKaryawan() {
        // Implementasi opsional jika dipanggil langsung
    }

    // GETTER KHUSUS YANG DIPANGGIL DI VIEW
    public function getSertifikatKampusMerdeka() { 
        return $this->sertifikatKampusMerdeka; 
    }
    // tambahkan getter uang saku untuk dipakai di view
    public function getUangSakuBulanan() {
        return $this->uangSakuBulanan;
    }
}
?>