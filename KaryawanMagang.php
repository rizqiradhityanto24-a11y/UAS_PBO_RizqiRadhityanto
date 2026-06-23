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
        return $this->hariKerjaMasuk * $this->gajiDasarPerhari * 0.80;
    }

    public function tampilkanProfilKaryawan() {
        // Implementasi opsional jika dipanggil langsung
    }

    // GETTER KHUSUS YANG DIPANGGIL DI VIEW
    public function getSertifikatKampusMerdeka() { 
        return $this->sertifikatKampusMerdeka; 
    }
}
?>