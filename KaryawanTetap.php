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

    public function hitungGajiBersih() {
        return ($this->hariKerjaMasuk * $this->gajiDasarPerhari) + $this->tunjanganKesehatan;
    }

    public function tampilkanProfilKaryawan() {
        // Implementasi opsional jika dipanggil langsung
    }

    // GETTER KHUSUS YANG DIPANGGIL DI VIEW
    public function getTunjanganKesehatan() { 
        return $this->tunjanganKesehatan; 
    }
    
    public function getOpsiSahamId() { 
        return $this->opsiSahamId; 
    }
}
?>