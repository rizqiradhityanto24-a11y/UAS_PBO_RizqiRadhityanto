<?php
// index.php

// 1. Perbaikan: Sesuaikan dengan 'Koneksi.php' (K kapital sesuai explorer kamu)
require_once 'Koneksi.php';
require_once 'Karyawan.php';
require_once 'KaryawanTetap.php';
require_once 'KaryawanKontrak.php';
require_once 'KaryawanMagang.php';

$daftarTetap = [];
$daftarKontrak = [];
$daftarMagang = [];

// Query ambil data dari database
$query = "SELECT * FROM tabel_karyawan";
$result = $koneksi->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        // Definisikan departemen default karena di DB belum ada kolom departemen
        $departemenDefault = "IT & Development"; 

        // Pengelompokan objek berdasarkan jenis_karyawan dari DB
        if ($row['jenis_karyawan'] == 'tetap') {
            // Nominal tunjangan kesehatan default untuk karyawan tetap
            $tunjanganKesehatan = 500000.00; 
            $opsiSahamId = "ESOP-" . $row['id_karyawan'];

            $daftarTetap[] = new KaryawanTetap(
                $row['id_karyawan'], 
                $row['nama_karyawan'], 
                $departemenDefault,
                $row['hari_kerja_masuk'], 
                $row['gaji_dasar_perhari'],
                $tunjanganKesehatan, 
                $opsiSahamId
            );

        } elseif ($row['jenis_karyawan'] == 'kontrak') {
            // Ambil langsung durasi_kontrak_bulan dari kolom DB
            $durasi = $row['durasi_kontrak_bulan'] ?? 0;
            $agensi = "PT Outsourcing Mandiri";

            $daftarKontrak[] = new KaryawanKontrak(
                $row['id_karyawan'], 
                $row['nama_karyawan'], 
                $departemenDefault,
                $row['hari_kerja_masuk'], 
                $row['gaji_dasar_perhari'],
                $durasi, 
                $agensi
            );

        } elseif ($row['jenis_karyawan'] == 'magang') {
            // Ambil langsung uang_saku_bulanan & sertifikat dari kolom DB
            $uangSaku = $row['uang_saku_bulanan'] ?? 0;
            $sertifikat = $row['sertifikat_kampus_merdeka'] ?? 'Tidak';

            $daftarMagang[] = new KaryawanMagang(
                $row['id_karyawan'], 
                $row['nama_karyawan'], 
                $departemenDefault,
                $row['hari_kerja_masuk'], 
                $row['gaji_dasar_perhari'],
                $uangSaku, 
                $sertifikat
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
    <title>Daftar Slip Gaji UAS PBO</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f8f9fa; color: #333; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 30px; font-weight: 700; }
        h2 { color: #2c3e50; margin-top: 40px; padding-bottom: 10px; border-bottom: 3px solid #dee2e6; display: flex; align-items: center; gap: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; }
        th, td { padding: 14px 18px; text-align: left; }
        th { background-color: #34495e; color: #fff; font-weight: 600; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; }
        td { border-bottom: 1px solid #e9ecef; }
        tr:last-child td { border-bottom: none; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        tr:hover { background-color: #f1f3f5; }
        .text-right { text-align: right; }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; color: white; }
        .badge-tetap { background-color: #2ecc71; }
        .badge-kontrak { background-color: #f1c40f; color: #2c3e50; }
        .badge-magang { background-color: #9b59b6; }
        .gaji-bersih { font-weight: bold; color: #27ae60; font-size: 15px; }
        .potongan { color: #e74c3c; font-size: 12px; font-style: italic; }
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
                <th>Gaji Pokok / Hari</th>
                <th>Tunjangan Kesehatan</th>
                <th>Opsi Saham ID</th>
                <th class="text-right">Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($daftarTetap)): ?>
                <tr><td colspan="8" style="text-align:center; color:#7f8c8d;">Tidak ada data karyawan tetap.</td></tr>
            <?php else: foreach($daftarTetap as $kt): ?>
                <tr>
                    <td><?= $kt->getIdKaryawan(); ?></td>
                    <td><strong><?= $kt->getNamaKaryawan(); ?></strong></td>
                    <td><?= $kt->getDepartemen(); ?></td>
                    <td><?= $kt->getHariKerjaMasuk(); ?> Hari</td>
                    <td>Rp <?= number_format($kt->getGajiDasarPerhari(), 0, ',', '.'); ?></td>
                    <td>Rp <?= number_format($kt->getTunjanganKesehatan(), 0, ',', '.'); ?></td>
                    <td><code><?= $kt->getOpsiSahamId(); ?></code></td>
                    <td class="text-right gaji-bersih">Rp <?= number_format($kt->hitungGajiBersih(), 0, ',', '.'); ?></td>
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
                <th>Gaji Pokok / Hari</th>
                <th>Durasi Kontrak</th>
                <th>Agensi Penyalur</th>
                <th class="text-right">Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($daftarKontrak)): ?>
                <tr><td colspan="8" style="text-align:center; color:#7f8c8d;">Tidak ada data karyawan kontrak.</td></tr>
            <?php else: foreach($daftarKontrak as $kk): ?>
                <tr>
                    <td><?= $kk->getIdKaryawan(); ?></td>
                    <td><strong><?= $kk->getNamaKaryawan(); ?></strong></td>
                    <td><?= $kk->getDepartemen(); ?></td>
                    <td><?= $kk->getHariKerjaMasuk(); ?> Hari</td>
                    <td>Rp <?= number_format($kk->getGajiDasarPerhari(), 0, ',', '.'); ?></td>
                    <td><?= $kk->getDurasiKontrakBulan(); ?> Bulan</td>
                    <td><?= $kk->getAgensiPenyalur(); ?></td>
                    <td class="text-right gaji-bersih">Rp <?= number_format($kk->hitungGajiBersih(), 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

    <h2><span class="badge badge-magang">Magang</span> Karyawan Magang</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Karyawan</th>
                <th>Departemen</th>
                <th>Hari Masuk</th>
                <th>Gaji Pokok / Hari (Gross)</th>
                <th>Sertifikat Kampus Merdeka</th>
                <th>Keterangan</th>
                <th class="text-right">Gaji Bersih (Net)</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($daftarMagang)): ?>
                <tr><td colspan="8" style="text-align:center; color:#7f8c8d;">Tidak ada data karyawan magang.</td></tr>
            <?php else: foreach($daftarMagang as $km): ?>
                <tr>
                    <td><?= $km->getIdKaryawan(); ?></td>
                    <td><strong><?= $km->getNamaKaryawan(); ?></strong></td>
                    <td><?= $km->getDepartemen(); ?></td>
                    <td><?= $km->getHariKerjaMasuk(); ?> Hari</td>
                    <td>Rp <?= number_format($km->getGajiDasarPerhari(), 0, ',', '.'); ?></td>
                    <td><?= $km->getSertifikatKampusMerdeka(); ?></td>
                    <td class="potongan">Potongan Orientasi 20%</td>
                    <td class="text-right gaji-bersih">Rp <?= number_format($km->hitungGajiBersih(), 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>

</body>
</html>