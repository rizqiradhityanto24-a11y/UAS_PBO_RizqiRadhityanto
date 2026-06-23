<?php
// KaryawanTetap.php
require_once 'Karyawan.php';

class KaryawanTetap extends Karyawan {
    // Properti tambahan khusus karyawan tetap
    private $tunjanganKesehatan;
    private $opsiSahamId;

    public function __construct($id, $nama, $dept, $hariMasuk, $gajiDasar, $tunjangan, $sahamId) {
        parent::__construct($id, $nama, $dept, $hariMasuk, $gajiDasar);
        $this->tunjanganKesehatan = $tunjangan;
        $this->opsiSahamId = $sahamId;
    }

    // Implementasi metode abstrak hitungGajiBersih
    public function hitungGajiBersih() {
        // Rumus: (Hari Masuk x Gaji Dasar) + Tunjangan Kesehatan
        return ($this->hariKerjaMasuk * $this->gajiDasarPerhari) + $this->tunjanganKesehatan;
    }

    // Implementasi metode abstrak tampilkanProfilKaryawan
    public function tampilkanProfilKaryawan() {
        echo "=== PROFIL KARYAWAN TETAP ===<br>";
        echo "ID: " . $this->id_karyawan . "<br>";
        echo "Nama: " . $this->nama_karyawan . "<br>";
        echo "Departemen: " . $this->departemen . "<br>";
        echo "Tunjangan Kesehatan: Rp " . number_format($this->tunjanganKesehatan, 0, ',', '.') . "<br>";
        echo "Opsi Saham ID: " . $this->opsiSahamId . "<br>";
        echo "Gaji Bersih Bulan Ini: Rp " . number_format($this->hitungGajiBersih(), 0, ',', '.') . "<br><br>";
    }

    // Getter dan Setter Khusus
    public function getTunjanganKesehatan() { return $this->tunjanganKesehatan; }
    public function setTunjanganKesehatan($tunjangan) { $this->tunjanganKesehatan = $tunjangan; }
    public function getOpsiSahamId() { return $this->opsiSahamId; }
    public function setOpsiSahamId($sahamId) { $this->opsiSahamId = $sahamId; }
}
?>