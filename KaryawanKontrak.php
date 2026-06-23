<?php
// KaryawanKontrak.php
require_once 'Karyawan.php';

class KaryawanKontrak extends Karyawan {
    private $durasiKontrakBulan;
    private $agensiPenyalur;

    public function __construct($id, $nama, $dept, $hariMasuk, $gajiDasar, $durasi, $agensi) {
        parent::__construct($id, $nama, $dept, $hariMasuk, $gajiDasar);
        $this->durasiKontrakBulan = $durasi;
        $this->agensiPenyalur = $agensi;
    }

    public function hitungGajiBersih() {
        return $this->hariKerjaMasuk * $this->gajiDasarPerhari;
    }

    public function tampilkanProfilKaryawan() {
        // Implementasi opsional jika dipanggil langsung
    }

    // GETTER KHUSUS YANG DIPANGGIL DI VIEW
    public function getDurasiKontrakBulan() { 
        return $this->durasiKontrakBulan; 
    }
    
    public function getAgensiPenyalur() { 
        return $this->agensiPenyalur; 
    }
}
?>