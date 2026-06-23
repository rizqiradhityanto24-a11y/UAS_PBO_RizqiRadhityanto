<?php
// KaryawanMagang.php
require_once 'Karyawan.php';

class KaryawanMagang extends Karyawan {
    // Properti tambahan khusus karyawan magang
    private $uangSakuBulanan;
    private $sertifikatKampusMerdeka;

    public function __construct($id, $nama, $dept, $hariMasuk, $gajiDasar, $uangSaku, $sertifikat) {
        parent::__construct($id, $nama, $dept, $hariMasuk, $gajiDasar);
        $this->uangSakuBulanan = $uangSaku;
        $this->sertifikatKampusMerdeka = $sertifikat;
    }

    // Implementasi metode abstrak hitungGajiBersih
    public function hitungGajiBersih() {
        // Rumus: (Hari Masuk x Gaji Dasar) + Uang Saku Bulanan
        return ($this->hariKerjaMasuk * $this->gajiDasarPerhari) + $this->uangSakuBulanan;
    }

    // Implementasi metode abstrak tampilkanProfilKaryawan
    public function tampilkanProfilKaryawan() {
        echo "=== PROFIL KARYAWAN MAGANG ===<br>";
        echo "ID: " . $this->id_karyawan . "<br>";
        echo "Nama: " . $this->nama_karyawan . "<br>";
        echo "Departemen: " . $this->departemen . "<br>";
        echo "Uang Saku Bulanan: Rp " . number_format($this->uangSakuBulanan, 0, ',', '.') . "<br>";
        echo "Sertifikat Kampus Merdeka: " . ($this->sertifikatKampusMerdeka ? "Ya" : "Tidak") . "<br>";
        echo "Total Pendapatan Bulan Ini: Rp " . number_format($this->hitungGajiBersih(), 0, ',', '.') . "<br><br>";
    }

    // Getter dan Setter Khusus
    public function getUangSakuBulanan() { return $this->uangSakuBulanan; }
    public function setUangSakuBulanan($uangSaku) { $this->uangSakuBulanan = $uangSaku; }
    public function getSertifikatKampusMerdeka() { return $this->sertifikatKampusMerdeka; }
    public function setSertifikatKampusMerdeka($sertifikat) { $this->sertifikatKampusMerdeka = $sertifikat; }
}
?>