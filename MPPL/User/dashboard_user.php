<?php
require '../Akses/auth_check.php';
$username = $_SESSION['username'];

// --- SIMULASI DATA UNTUK DASHBOARD ---
// Di tahap ini, data disimulasikan karena belum ada database relasional yang lengkap.
$total_laporan = 18;
$laporan_pending = 3;
$laporan_selesai = 12;

$laporan_terbaru = [
    [
        'id' => 101,
        'tanggal' => '2025-11-25',
        'jenis' => 'Sampah Liar',
        'status' => 'Pending',
        'lokasi' => 'Jl. Mawar No. 5',
    ],
    [
        'id' => 102,
        'tanggal' => '2025-11-20',
        'jenis' => 'Limbah Cair',
        'status' => 'Verifikasi',
        'lokasi' => 'Sungai Citarum',
    ],
];
// --- AKHIR SIMULASI DATA ---
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Peduli Lingkungan</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<style>
/* CSS dari dashboard_user.php */
#sidebar { transition: transform 0.3s ease; }
.sidebar-open { transform: translateX(0) !important; }
.sidebar-closed { transform: translateX(-18rem) !important; }

@media (max-width: 767px) {
    .sidebar-open { transform: translateX(-18rem) !important; }
    #sidebar.sidebar-open { transform: translateX(0) !important; }
}
@media (min-width: 768px) {
    .sidebar-closed { transform: translateX(-18rem) !important; }
    #sidebar.sidebar-open { transform: translateX(0) !important; }
}

body {
  background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1920&q=80');
  background-size: cover;
  background-position: center;
}
.backdrop-card {
  background-color: rgba(255,255,255,0.85); /* Ditingkatkan transparansi untuk kontras */
  backdrop-filter: blur(10px);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.backdrop-card:hover {
  transform: translateY(-2px); /* Dikecilkan efek hover agar tidak mengganggu */
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  border-color: #10B981; /* Border hijau saat hover */
}
</style>
<?php
// Fungsi Helper untuk Status Badge
function get_status_class($status) {
    switch ($status) {
        case 'Selesai': return 'bg-green-100 text-green-700';
        case 'Verifikasi': return 'bg-yellow-100 text-yellow-700';
        case 'Pending': return 'bg-red-100 text-red-700';
        default: return 'bg-gray-100 text-gray-700';
    }
}
?>
</head>

<body class="min-h-screen flex pt-16 text-gray-800">

<div id="overlay" class="fixed inset-0 bg-black/50 hidden z-10 md:hidden"></div>

<?php include '../Navigasi/navmain.php'; ?>

<?php include '../Navigasi/navbar.php'; ?>

<main id="main-content" class="flex-1 p-10 ml-0 md:ml-72 transition-all duration-300">
  
  <h2 class="text-4xl font-bold text-green-800 mb-2">Selamat datang, <?= htmlspecialchars($username) ?>!</h2>
  <p class="text-gray-600 mb-8">Ini adalah ringkasan aktivitas lingkungan Anda.</p>

  <div class="grid md:grid-cols-3 gap-6 mb-10">
    
    <div class="backdrop-card p-6 rounded-2xl shadow-xl border border-green-300">
        <div class="flex justify-between items-center">
            <span class="material-symbols-outlined text-4xl text-green-600">list_alt</span>
            <p class="text-5xl font-extrabold text-green-700"><?= $total_laporan ?></p>
        </div>
        <h3 class="text-xl font-semibold mt-3 text-gray-700">Total Laporan</h3>
        <p class="text-sm text-gray-500">Jumlah laporan yang pernah Anda buat.</p>
    </div>

    <div class="backdrop-card p-6 rounded-2xl shadow-xl border border-yellow-300">
        <div class="flex justify-between items-center">
            <span class="material-symbols-outlined text-4xl text-yellow-600">pending_actions</span>
            <p class="text-5xl font-extrabold text-yellow-700"><?= $laporan_pending ?></p>
        </div>
        <h3 class="text-xl font-semibold mt-3 text-gray-700">Laporan Aktif</h3>
        <p class="text-sm text-gray-500">Menunggu verifikasi dan tindak lanjut.</p>
    </div>

    <div class="backdrop-card p-6 rounded-2xl shadow-xl border border-blue-300">
        <div class="flex justify-between items-center">
            <span class="material-symbols-outlined text-4xl text-blue-600">task_alt</span>
            <p class="text-5xl font-extrabold text-blue-700"><?= $laporan_selesai ?></p>
        </div>
        <h3 class="text-xl font-semibold mt-3 text-gray-700">Laporan Selesai</h3>
        <p class="text-sm text-gray-500">Masalah sudah ditindaklanjuti.</p>
    </div>
  </div>

  <div class="grid md:grid-cols-3 gap-6">

    <div class="md:col-span-2 space-y-6">
        <div class="backdrop-card p-6 rounded-2xl shadow-xl">
            <h3 class="text-2xl font-bold text-green-700 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined">history</span> Aktivitas Laporan Terbaru
            </h3>
            
            <?php if (empty($laporan_terbaru)) : ?>
                <p class="text-gray-500 italic">Belum ada laporan terbaru. Mari buat laporan pertama Anda!</p>
            <?php else : ?>
                <ul class="space-y-4">
                    <?php foreach ($laporan_terbaru as $lapor) : ?>
                    <li class="border-b pb-4 last:border-b-0 last:pb-0">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="text-lg font-semibold"><?= htmlspecialchars($lapor['jenis']) ?> (<?= htmlspecialchars($lapor['lokasi']) ?>)</p>
                                <p class="text-sm text-gray-500 mt-1">Dilaporkan pada: <?= htmlspecialchars($lapor['tanggal']) ?></p>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full <?= get_status_class($lapor['status']) ?>">
                                <?= htmlspecialchars($lapor['status']) ?>
                            </span>
                        </div>
                        <a href="laporan_progress.php" class="text-green-600 hover:text-green-700 text-sm mt-1 inline-block font-medium">Lihat Detail Progress &rarr;</a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        
        <a href="lapor_form.php" class="backdrop-card p-6 rounded-2xl shadow-xl border-2 border-green-500 bg-green-50 hover:bg-green-100 transition duration-300 flex items-center justify-between">
            <h4 class="text-xl font-bold text-green-800">Ada Pencemaran Baru?</h4>
            <button class="bg-green-600 text-white py-2 px-4 rounded-lg font-semibold flex items-center gap-2 hover:bg-green-700">
                <span class="material-symbols-outlined">campaign</span> Lapor Sekarang
            </button>
        </a>
    </div>

    <div class="md:col-span-1 space-y-6">
      
        <div class="backdrop-card p-6 rounded-2xl shadow-xl border border-gray-300">
            <h3 class="text-xl font-bold text-green-700 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined">person</span> Profil Pengguna
            </h3>
            <p><span class="font-medium text-gray-700">Username:</span> <?= htmlspecialchars($username) ?></p>
            <p><span class="font-medium text-gray-700">Role:</span> User</p>
        </div>

        <div class="backdrop-card p-6 rounded-2xl shadow-xl border border-gray-300">
            <h3 class="text-xl font-bold text-green-700 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined">lightbulb</span> Tips Harian
            </h3>
            <p id="daily-tips" class="text-gray-700 italic mt-2"></p>
            <a href="edukasi_interaktif.php" class="text-green-600 hover:text-green-700 text-sm mt-3 inline-block font-medium">Lihat Kamus Sampah &rarr;</a>
        </div>
        
    </div>
  </div>
</main>

<script src="../Assets/js/script.js"></script>

</body>
</html>