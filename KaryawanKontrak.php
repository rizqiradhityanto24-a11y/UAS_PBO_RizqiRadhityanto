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

    // OVERRIDING: Menghitung gaji sesuai logika karyawan kontrak
    public function hitungGajiBersih() {
        return $this->hariKerjaMasuk * $this->gajiDasarPerhari;
    }

    public function tampilkanProfilKaryawan() {
        echo "=== PROFIL KARYAWAN KONTRAK ===<br>";
        echo "ID: " . $this->id_karyawan . "<br>";
        echo "Nama: " . $this->nama_karyawan . "<br>";
        echo "Departemen: " . $this->departemen . "<br>";
        echo "Durasi Kontrak: " . $this->durasiKontrakBulan . " Bulan<br>";
        echo "Agensi Penyalur: " . $this->agensiPenyalur . "<br>";
        echo "Gaji Bersih: Rp " . number_format($this->hitungGajiBersih(), 0, ',', '.') . "<br><br>";
    }
}
?>