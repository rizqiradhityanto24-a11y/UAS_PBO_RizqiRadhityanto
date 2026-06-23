<?php
// KaryawanMagang.php
require_once 'Karyawan.php';

class KaryawanMagang extends Karyawan {
    private $uangSakuBulanan; // Tetap ada sebagai properti, namun rumus mengacu pada plafon harian sesuai instruksi
    private $sertifikatKampusMerdeka;

    public function __construct($id, $nama, $dept, $hariMasuk, $gajiDasar, $uangSaku, $sertifikat) {
        parent::__construct($id, $nama, $dept, $hariMasuk, $gajiDasar);
        $this->uangSakuBulanan = $uangSaku;
        $this->sertifikatKampusMerdeka = $sertifikat;
    }

    // OVERRIDING: Menghitung gaji magang dengan potongan 20% (dikali 0.80)
    public function hitungGajiBersih() {
        return $this->hariKerjaMasuk * $this->gajiDasarPerhari * 0.80;
    }

    public function tampilkanProfilKaryawan() {
        echo "=== PROFIL KARYAWAN MAGANG ===<br>";
        echo "ID: " . $this->id_karyawan . "<br>";
        echo "Nama: " . $this->nama_karyawan . "<br>";
        echo "Departemen: " . $this->departemen . "<br>";
        echo "Sertifikat Kampus Merdeka: " . $this->sertifikatKampusMerdeka . "<br>";
        echo "Gaji Bersih (Setelah Potongan 20%): Rp " . number_format($this->hitungGajiBersih(), 0, ',', '.') . "<br><br>";
    }
}
?>