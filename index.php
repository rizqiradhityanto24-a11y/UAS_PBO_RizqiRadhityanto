<?php
// index.php

// Memanggil semua file yang dibutuhkan
require_once 'koneksi.php';
require_once 'Karyawan.php';
require_once 'KaryawanTetap.php';
require_once 'KaryawanKontrak.php';
require_once 'KaryawanMagang.php';

// Array penampung untuk pengelompokkan objek karyawan
$daftarTetap = [];
$daftarKontrak = [];
$daftarMagang = [];

// Query untuk mengambil seluruh data dari tabel_karyawan
$query = "SELECT * FROM tabel_karyawan";
$result = $koneksi->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        // Asumsi departemen default karena belum ada di table database saat ini
        $departemenDefault = "Operasional"; 

        // Polimorfisme: Instansiasi objek berdasarkan jenis_karyawan
        if ($row['jenis_karyawan'] == 'tetap') {
            // Berikan nilai simulasi untuk tunjangan kesehatan dan opsi saham ID
            $tunjanganKesehatan = 500000.00; 
            $opsiSahamId = "ESOP-" . $row['id_karyawan'];

            $daftarTetap[] = new KaryawanTetap(
                $row['id_karyawan'], $row['nama_karyawan'], $departemenDefault,
                $row['hari_kerja_masuk'], $row['gaji_dasar_perhari'],
                $tunjanganKesehatan, $opsiSahamId
            );

        } elseif ($row['jenis_karyawan'] == 'kontrak') {
            // Ambil durasi_kontrak_bulan dari DB, agensi penyalur disimulasikan
            $durasi = $row['durasi_kontrak_bulan'] ?? 0;
            $agensi = "PT Sinergi Mitra";

            $daftarKontrak[] = new KaryawanKontrak(
                $row['id_karyawan'], $row['nama_karyawan'], $departemenDefault,
                $row['hari_kerja_masuk'], $row['gaji_dasar_perhari'],
                $durasi, $agensi
            );

        } elseif ($row['jenis_karyawan'] == 'magang') {
            // Ambil data spesifik magang dari DB
            $uangSaku = $row['uang_saku_bulanan'] ?? 0;
            $sertifikat = $row['sertifikat_kampus_merdeka'] ?? 'Tidak';

            $daftarMagang[] = new KaryawanMagang(
                $row['id_karyawan'], $row['nama_karyawan'], $departemenDefault,
                $row['hari_kerja_masuk'], $row['gaji_dasar_perhari'],
                $uangSaku, $sertifikat
            );
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Slip Gaji & Informasi Karyawan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f4f6f9; color: #333; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        h2 { color: #2980b9; border-bottom: 2px solid #2980b9; padding-bottom: 5px; margin-top: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #34495e; color: #fff; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .text-right { text-align: right; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white; }
        .badge-tetap { background-color: #2ecc71; }
        .badge-kontrak { background-color: #f1c40f; color: #333; }
        .badge-magang { background-color: #9b59b6; }
    </style>
</head>
<body>

    <h1>Sistem Informasi Slip Gaji Karyawan</h1>

    <h2><span class="badge badge-tetap">Tetap</span> Karyawan Tetap</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Karyawan</th>
                <th>Departemen</th>
                <th>Hari Masuk</th>
                <th>Gaji Pokok/Hari</th>
                <th>Tunjangan Kesehatan</th>
                <th>Opsi Saham ID</th>
                <th>Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($daftarTetap)): ?>
                <tr><td colspan="8" style="text-align:center;">Tidak ada data.</td></tr>
            <?php else: foreach($daftarTetap as $kt): ?>
                <tr>
                    <td><?= $kt->getIdKaryawan(); ?></td>
                    <td><strong><?= $kt->getNamaKaryawan(); ?></strong></td>
                    <td><?= $kt->getDepartemen(); ?></td>
                    <td><?= $kt->getHariKerjaMasuk(); ?> hari</td>
                    <td class="text-right">Rp <?= number_format($kt->getGajiDasarPerhari(), 0, ',', '.'); ?></td>
                    <td class="text-right">Rp <?= number_format($kt->getTunjanganKesehatan(), 0, ',', '.'); ?></td>
                    <td><?= $kt->getOpsiSahamId(); ?></td>
                    <td class="text-right" style="font-weight:bold; color:#27ae60;">Rp <?= number_format($kt->hitungGajiBersih(), 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

    <h2><span class="badge badge-kontrak">Kontrak</span> Karyawan Kontrak</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Karyawan</th>
                <th>Departemen</th>
                <th>Hari Masuk</th>
                <th>Gaji Pokok/Hari</th>
                <th>Durasi Kontrak</th>
                <th>Agensi Penyalur</th>
                <th>Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($daftarKontrak)): ?>
                <tr><td colspan="8" style="text-align:center;">Tidak ada data.</td></tr>
            <?php else: foreach($daftarKontrak as $kk): ?>
                <tr>
                    <td><?= $kk->getIdKaryawan(); ?></td>
                    <td><strong><?= $kk->getNamaKaryawan(); ?></strong></td>
                    <td><?= $kk->getDepartemen(); ?></td>
                    <td><?= $kk->getHariKerjaMasuk(); ?> hari</td>
                    <td class="text-right">Rp <?= number_format($kk->getGajiDasarPerhari(), 0, ',', '.'); ?></td>
                    <td><?= $kk->getDurasiKontrakBulan(); ?> Bulan</td>
                    <td><?= $kk->getAgensiPenyalur(); ?></td>
                    <td class="text-right" style="font-weight:bold; color:#27ae60;">Rp <?= number_format($kk->hitungGajiBersih(), 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

    <h2><span class="badge badge-magang">Magang</span> Karyawan Magang (Intern)</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Karyawan</th>
                <th>Departemen</th>
                <th>Hari Masuk</th>
                <th>Gaji Pokok/Hari (Gross)</th>
                <th>Sertifikat Kampus Merdeka</th>
                <th>Keterangan Potongan</th>
                <th>Gaji Bersih (Net)</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($daftarMagang)): ?>
                <tr><td colspan="8" style="text-align:center;">Tidak ada data.</td></tr>
            <?php else: foreach($daftarMagang as $km): ?>
                <tr>
                    <td><?= $km->getIdKaryawan(); ?></td>
                    <td><strong><?= $km->getNamaKaryawan(); ?></strong></td>
                    <td><?= $km->getDepartemen(); ?></td>
                    <td><?= $km->getHariKerjaMasuk(); ?> hari</td>
                    <td class="text-right">Rp <?= number_format($km->getGajiDasarPerhari(), 0, ',', '.'); ?></td>
                    <td><?= $km->getSertifikatKampusMerdeka(); ?></td>
                    <td style="color: #e74c3c; font-size: 13px;">Potongan Orientasi 20%</td>
                    <td class="text-right" style="font-weight:bold; color:#27ae60;">Rp <?= number_format($km->hitungGajiBersih(), 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

</body>
</html>