<?php
// KaryawanKontrak.php
require_once 'Karyawan.php';

class KaryawanKontrak extends Karyawan {
    // Properti tambahan khusus karyawan kontrak
    private $durasiKontrakBulan;
    private $agensiPenyalur;

    public function __construct($id, $nama, $dept, $hariMasuk, $gajiDasar, $durasi, $agensi) {
        // Memanggil constructor dari parent class (Karyawan)
        parent::__construct($id, $nama, $dept, $hariMasuk, $gajiDasar);
        $this->durasiKontrakBulan = $durasi;
        $this->agensiPenyalur = $agensi;
    }

    // Implementasi metode abstrak hitungGajiBersih
    public function hitungGajiBersih() {
        // Rumus: (Hari Masuk x Gaji Dasar) - Potongan Fee Agensi (misal 5%)
        $gajiKotor = $this->hariKerjaMasuk * $this->gajiDasarPerhari;
        $potonganAgensi = $gajiKotor * 0.05; 
        return $gajiKotor - $potonganAgensi;
    }

    // Implementasi metode abstrak tampilkanProfilKaryawan
    public function tampilkanProfilKaryawan() {
        echo "=== PROFIL KARYAWAN KONTRAK ===<br>";
        echo "ID: " . $this->id_karyawan . "<br>";
        echo "Nama: " . $this->nama_karyawan . "<br>";
        echo "Departemen: " . $this->departemen . "<br>";
        echo "Durasi Kontrak: " . $this->durasiKontrakBulan . " Bulan<br>";
        echo "Agensi Penyalur: " . $this->agensiPenyalur . "<br>";
        echo "Gaji Bersih Bulan Ini: Rp " . number_format($this->hitungGajiBersih(), 0, ',', '.') . "<br><br>";
    }

    // Getter dan Setter Khusus
    public function getDurasiKontrakBulan() { return $this->durasiKontrakBulan; }
    public function setDurasiKontrakBulan($durasi) { $this->durasiKontrakBulan = $durasi; }
    public function getAgensiPenyalur() { return $this->agensiPenyalur; }
    public function setAgensiPenyalur($agensi) { $this->agensiPenyalur = $agensi; }
}
?>