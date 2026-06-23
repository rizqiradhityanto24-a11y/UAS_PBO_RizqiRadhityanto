<?php
// index.php
// gunakan nama file yang ada di proyek (case sesuai file system yang disediakan)
require_once 'koneksi.php';
require_once 'karyawan.php';
require_once 'KaryawanTetap.php';
require_once 'KaryawanKontrak.php';
require_once 'KaryawanMagang.php';

$daftarTetap = [];
$daftarKontrak = [];
$daftarMagang = [];

$query = "SELECT * FROM tabel_karyawan";
$result = $koneksi->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departemenDefault = isset($row['departemen']) && $row['departemen'] !== '' ? $row['departemen'] : "IT & Development";
        $jenis = $row['jenis_karyawan'] ?? '';
        // cast nilai agar konsisten
        $id = $row['id_karyawan'] ?? '';
        $nama = $row['nama_karyawan'] ?? '';
        $hari = isset($row['hari_kerja_masuk']) ? (int)$row['hari_kerja_masuk'] : 0;
        $gaji = isset($row['gaji_dasar_perhari']) ? (float)$row['gaji_dasar_perhari'] : 0.0;

        if ($jenis === 'tetap') {
            $tunjanganKesehatan = isset($row['tunjangan_kesehatan']) ? (float)$row['tunjangan_kesehatan'] : 500000.00;
            $opsiSahamId = "ESOP-" . $id;
            $daftarTetap[] = new KaryawanTetap($id, $nama, $departemenDefault, $hari, $gaji, $tunjanganKesehatan, $opsiSahamId);

        } elseif ($jenis === 'kontrak') {
            $durasi = isset($row['durasi_kontrak_bulan']) ? (int)$row['durasi_kontrak_bulan'] : 0;
            $agensi = $row['agensi_penyalur'] ?? "PT Outsourcing Mandiri";
            $daftarKontrak[] = new KaryawanKontrak($id, $nama, $departemenDefault, $hari, $gaji, $durasi, $agensi);

        } elseif ($jenis === 'magang') {
            $uangSaku = isset($row['uang_saku_bulanan']) ? (float)$row['uang_saku_bulanan'] : 0.0;
            $sertifikat = $row['sertifikat_kampus_merdeka'] ?? 'Tidak';
            $daftarMagang[] = new KaryawanMagang($id, $nama, $departemenDefault, $hari, $gaji, $uangSaku, $sertifikat);
        }
    }
} else {
    // jika query gagal, Anda bisa men-debug: uncomment baris berikut saat pengembangan
    // error_log("Query gagal: " . $koneksi->error);
}

// ===== Tambahan: hitung statistik untuk dashboard =====
$countTetap   = count($daftarTetap);
$countKontrak  = count($daftarKontrak);
$countMagang   = count($daftarMagang);
$totalKaryawan = $countTetap + $countKontrak + $countMagang;

function formatRp($n) {
    return 'Rp ' . number_format($n, 0, ',', '.');
}

$totalGajiTetap = 0; $totalGajiKontrak = 0; $totalGajiMagang = 0;
foreach ($daftarTetap as $t)  { $totalGajiTetap += (float)$t->hitungGajiBersih(); }
foreach ($daftarKontrak as $k) { $totalGajiKontrak += (float)$k->hitungGajiBersih(); }
foreach ($daftarMagang as $m)  { $totalGajiMagang += (float)$m->hitungGajiBersih(); }
$totalPayroll = $totalGajiTetap + $totalGajiKontrak + $totalGajiMagang;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Slip Gaji Karyawan - Dashboard</title>
    <style>
        body { font-family: sans-serif; margin: 24px; background-color: #f4f7fb; color:#23303b; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; background: #fff; margin-bottom: 30px; }
        th, td { padding: 12px; border: 1px solid #dee2e6; text-align: left; }
        th { background-color: #34495e; color: white; }
        .text-right { text-align: right; }

        /* Tambahan untuk dashboard */
        .dashboard { display: grid; grid-template-columns: repeat(auto-fit,minmax(200px,1fr)); gap: 16px; margin-bottom: 22px; }
        .card { background: linear-gradient(180deg,#ffffff,#f7fbff); border:1px solid #e6eef8; padding:16px; border-radius:8px; box-shadow: 0 6px 18px rgba(20,40,60,0.04); }
        .card .label { font-size:13px; color:#61707a; margin-bottom:6px; }
        .card .value { font-size:20px; font-weight:700; color:#0d3b66; }
        .card.small { padding:10px; text-align:center; }
        .controls { display:flex; gap:12px; align-items:center; margin-bottom:18px; flex-wrap:wrap; }
        .tabs { display:flex; gap:8px; }
        .tab-btn { background:#fff; border:1px solid #d6e1f2; padding:8px 12px; border-radius:6px; cursor:pointer; color:#0d3b66; }
        .tab-btn.active { background:#0d3b66; color:#fff; border-color:#0d3b66; }
        .search { padding:8px 12px; border-radius:6px; border:1px solid #d6e1f2; min-width:220px; }
        .table-wrap { background:#fff; padding:8px; border-radius:8px; border:1px solid #e6eef8; }
        .hidden { display:none; }
        @media (max-width:640px){ .controls { flex-direction:column; align-items:stretch } }
    </style>
</head>
<body>

    <h1>Sistem Informasi Slip Gaji Karyawan</h1>

    <!-- Dashboard ringkasan -->
    <div class="dashboard" role="region" aria-label="Dashboard ringkasan">
        <div class="card">
            <div class="label">Total Karyawan</div>
            <div class="value"><?= htmlspecialchars($totalKaryawan); ?></div>
        </div>
        <div class="card">
            <div class="label">Total Payroll Bulanan</div>
            <div class="value"><?= htmlspecialchars(formatRp($totalPayroll)); ?></div>
        </div>
        <div class="card">
            <div class="label">Karyawan Tetap</div>
            <div class="value"><?= htmlspecialchars($countTetap); ?> — <?= htmlspecialchars(formatRp($totalGajiTetap)); ?></div>
        </div>
        <div class="card">
            <div class="label">Karyawan Kontrak</div>
            <div class="value"><?= htmlspecialchars($countKontrak); ?> — <?= htmlspecialchars(formatRp($totalGajiKontrak)); ?></div>
        </div>
        <div class="card">
            <div class="label">Karyawan Magang</div>
            <div class="value"><?= htmlspecialchars($countMagang); ?> — <?= htmlspecialchars(formatRp($totalGajiMagang)); ?></div>
        </div>
    </div>

    <!-- Kontrol tabs + search -->
    <div class="controls">
        <div class="tabs" role="tablist" aria-label="Tampilkan jenis karyawan">
            <button class="tab-btn active" data-target="all" onclick="switchTab(event)">Semua</button>
            <button class="tab-btn" data-target="tetap" onclick="switchTab(event)">Tetap</button>
            <button class="tab-btn" data-target="kontrak" onclick="switchTab(event)">Kontrak</button>
            <button class="tab-btn" data-target="magang" onclick="switchTab(event)">Magang</button>
        </div>
        <input class="search" id="searchInput" placeholder="Cari nama karyawan..." oninput="filterTables()" />
    </div>

    <!-- Tables area (bungkus agar mudah toggle) -->
    <div id="all" class="table-wrap">
        <h2>Semua Karyawan</h2>
        <p style="margin-top:-10px;color:#6b7a86;font-size:13px;">Jumlah: <?= htmlspecialchars($totalKaryawan); ?></p>
        <!-- Gabungkan semua tabel ringkas -->
        <table>
            <thead>
                <tr><th>ID</th><th>Nama</th><th>Tipe</th><th>Hari Masuk</th><th>Gaji Bersih</th></tr>
            </thead>
            <tbody id="tblAllBody">
                <?php foreach($daftarTetap as $kt): ?>
                <tr class="row-item" data-name="<?= htmlspecialchars(strtolower($kt->getNamaKaryawan())); ?>" data-type="tetap">
                    <td><?= htmlspecialchars($kt->getIdKaryawan()); ?></td>
                    <td><?= htmlspecialchars($kt->getNamaKaryawan()); ?></td>
                    <td>Tetap</td>
                    <td><?= $kt->getHariKerjaMasuk(); ?></td>
                    <td><?= htmlspecialchars(formatRp($kt->hitungGajiBersih())); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php foreach($daftarKontrak as $kk): ?>
                <tr class="row-item" data-name="<?= htmlspecialchars(strtolower($kk->getNamaKaryawan())); ?>" data-type="kontrak">
                    <td><?= htmlspecialchars($kk->getIdKaryawan()); ?></td>
                    <td><?= htmlspecialchars($kk->getNamaKaryawan()); ?></td>
                    <td>Kontrak</td>
                    <td><?= $kk->getHariKerjaMasuk(); ?></td>
                    <td><?= htmlspecialchars(formatRp($kk->hitungGajiBersih())); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php foreach($daftarMagang as $km): ?>
                <tr class="row-item" data-name="<?= htmlspecialchars(strtolower($km->getNamaKaryawan())); ?>" data-type="magang">
                    <td><?= htmlspecialchars($km->getIdKaryawan()); ?></td>
                    <td><?= htmlspecialchars($km->getNamaKaryawan()); ?></td>
                    <td>Magang</td>
                    <td><?= $km->getHariKerjaMasuk(); ?></td>
                    <td><?= htmlspecialchars(formatRp($km->hitungGajiBersih())); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Tetap -->
    <div id="tetap" class="table-wrap hidden">
        <h2>Karyawan Tetap</h2>
        <table>
            <thead><tr><th>ID</th><th>Nama</th><th>Departemen</th><th>Hari Masuk</th><th>Gaji Bersih</th></tr></thead>
            <tbody id="tblTetap">
                <?php foreach($daftarTetap as $kt): ?>
                <tr class="row-item" data-name="<?= htmlspecialchars(strtolower($kt->getNamaKaryawan())); ?>">
                    <td><?= htmlspecialchars($kt->getIdKaryawan()); ?></td>
                    <td><?= htmlspecialchars($kt->getNamaKaryawan()); ?></td>
                    <td><?= htmlspecialchars($kt->getDepartemen()); ?></td>
                    <td><?= $kt->getHariKerjaMasuk(); ?></td>
                    <td><?= htmlspecialchars(formatRp($kt->hitungGajiBersih())); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Kontrak -->
    <div id="kontrak" class="table-wrap hidden">
        <h2>Karyawan Kontrak</h2>
        <table>
            <thead><tr><th>ID</th><th>Nama</th><th>Departemen</th><th>Hari Masuk</th><th>Durasi</th><th>Gaji Bersih</th></tr></thead>
            <tbody id="tblKontrak">
                <?php foreach($daftarKontrak as $kk): ?>
                <tr class="row-item" data-name="<?= htmlspecialchars(strtolower($kk->getNamaKaryawan())); ?>">
                    <td><?= htmlspecialchars($kk->getIdKaryawan()); ?></td>
                    <td><?= htmlspecialchars($kk->getNamaKaryawan()); ?></td>
                    <td><?= htmlspecialchars($kk->getDepartemen()); ?></td>
                    <td><?= $kk->getHariKerjaMasuk(); ?></td>
                    <td><?= $kk->getDurasiKontrakBulan(); ?> bulan</td>
                    <td><?= htmlspecialchars(formatRp($kk->hitungGajiBersih())); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Magang -->
    <div id="magang" class="table-wrap hidden">
        <h2>Karyawan Magang</h2>
        <table>
            <thead><tr><th>ID</th><th>Nama</th><th>Departemen</th><th>Hari Masuk</th><th>Uang Saku</th><th>Gaji Bersih</th></tr></thead>
            <tbody id="tblMagang">
                <?php foreach($daftarMagang as $km): ?>
                <tr class="row-item" data-name="<?= htmlspecialchars(strtolower($km->getNamaKaryawan())); ?>">
                    <td><?= htmlspecialchars($km->getIdKaryawan()); ?></td>
                    <td><?= htmlspecialchars($km->getNamaKaryawan()); ?></td>
                    <td><?= htmlspecialchars($km->getDepartemen()); ?></td>
                    <td><?= $km->getHariKerjaMasuk(); ?></td>
                    <td><?= htmlspecialchars(formatRp($km->getUangSakuBulanan())); ?></td>
                    <td><?= htmlspecialchars(formatRp($km->hitungGajiBersih())); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Tab switching
        function switchTab(e){
            const target = e.currentTarget.getAttribute('data-target');
            document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
            e.currentTarget.classList.add('active');
            ['all','tetap','kontrak','magang'].forEach(id=>{
                const el = document.getElementById(id);
                if(!el) return;
                el.classList.toggle('hidden', id !== target);
            });
            // if all selected, show 'all'
            if(target === 'all') {
                document.getElementById('all').classList.remove('hidden');
            } else {
                document.getElementById('all').classList.add('hidden');
            }
            filterTables(); // reapply search filter
        }

        // Simple search filter (by nama)
        function filterTables(){
            const q = document.getElementById('searchInput').value.trim().toLowerCase();
            document.querySelectorAll('.row-item').forEach(row=>{
                const name = row.getAttribute('data-name') || '';
                const visibleBySearch = q === '' || name.indexOf(q) !== -1;
                // also hide if currently tab filtered and not matching
                let visibleByTab = true;
                const activeTab = document.querySelector('.tab-btn.active').getAttribute('data-target');
                if(activeTab !== 'all'){
                    const type = row.getAttribute('data-type') || row.closest('.table-wrap').id;
                    visibleByTab = (type === activeTab);
                }
                row.style.display = (visibleBySearch && visibleByTab) ? '' : 'none';
            });
        }

        // Initialize: show 'all' tab
        document.addEventListener('DOMContentLoaded', function(){ 
            // ensure all wrapper visibility correct
            document.querySelectorAll('.table-wrap').forEach(w=>{
                if(w.id !== 'all') w.classList.add('hidden');
            });
        });
    </script>

</body>
</html>