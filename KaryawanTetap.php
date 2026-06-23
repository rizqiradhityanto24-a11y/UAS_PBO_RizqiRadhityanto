<?php
// KaryawanTetap.php
require_once 'Karyawan.php';

class KaryawanTetap extends Karyawan {
    private $tunjanganKesehatan;
    private $opsiSahamId;

    public function __construct($id, $nama, $dept, $hariMasuk, $gajiDasar, $tunjangan, $sahamId) {
        parent::__construct($id, $nama, $dept, $hariMasuk, $gajiDasar);
        $this->tunjanganKesehatan = $tunjangan;
        $this->opsiSahamId = $sahamId;
    }

    // OVERRIDING: Menghitung gaji sesuai logika karyawan tetap
    public function hitungGajiBersih() {
        return ($this->hariKerjaMasuk * $this->gajiDasarPerhari) + $this->tunjanganKesehatan;
    }

    public function tampilkanProfilKaryawan() {
        echo "=== PROFIL KARYAWAN TETAP ===<br>";
        echo "ID: " . $this->id_karyawan . "<br>";
        echo "Nama: " . $this->nama_karyawan . "<br>";
        echo "Departemen: " . $this->departemen . "<br>";
        echo "Tunjangan Kesehatan: Rp " . number_format($this->tunjanganKesehatan, 0, ',', '.') . "<br>";
        echo "Opsi Saham ID: " . $this->opsiSahamId . "<br>";
        echo "Gaji Bersih: Rp " . number_format($this->hitungGajiBersih(), 0, ',', '.') . "<br><br>";
    }
}
?>