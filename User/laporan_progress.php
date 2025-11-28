<?php
// Pastikan user sudah login
require '../Akses/auth_check.php';
$username = $_SESSION['username'];
require '../Akses/config.php'; // Digunakan untuk koneksi DB

// --- SIMULASI DATA LAPORAN (Ganti dengan Query DB nyata Anda) ---
// Di tahap pengembangan front-end, kita simulasikan data dummy yang akan diambil dari database nanti.
$reports = [
    [
        'id' => 101,
        'tanggal' => '2025-11-25',
        'jenis' => 'Penumpukan Sampah Liar',
        'lokasi' => 'Jl. Mawar No. 5, belakang pabrik A',
        'status' => 'Pending', // Status Awal
        'catatan_admin' => 'Laporan sedang menunggu verifikasi awal.',
    ],
    [
        'id' => 102,
        'tanggal' => '2025-11-20',
        'jenis' => 'Pembuangan Limbah Cair',
        'lokasi' => 'Sungai Citarum, dekat jembatan lama',
        'status' => 'Verifikasi', // Status Tengah
        'catatan_admin' => 'Tim sudah di lokasi untuk pengecekan kebenaran laporan.',
    ],
    [
        'id' => 103,
        'tanggal' => '2025-11-15',
        'jenis' => 'Polusi Udara (Asap)',
        'lokasi' => 'Pabrik Kimia Utama',
        'status' => 'Selesai', // Status Akhir
        'catatan_admin' => 'Masalah telah diselesaikan. Pabrik telah menerima peringatan keras dan solusi sudah diimplementasikan.',
    ],
];
// --- AKHIR SIMULASI DATA ---
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Progress Laporan - Peduli Lingkungan</title>
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
  background-color: rgba(255,255,255,0.7);
  backdrop-filter: blur(10px);
}

/* Helper function untuk warna status */
<?php
function get_status_class($status) {
    switch ($status) {
        case 'Selesai': return 'bg-green-500 text-white';
        case 'Verifikasi': return 'bg-yellow-500 text-gray-800';
        case 'Pending': return 'bg-red-500 text-white';
        default: return 'bg-gray-400 text-white';
    }
}
?>
</style>
</head>

<body class="min-h-screen flex pt-16 text-gray-800">

<div id="overlay" class="fixed inset-0 bg-black/50 hidden z-10 md:hidden"></div>

<?php include '../Navigasi/navmain.php'; ?>

<?php include '../Navigasi/navbar.php'; ?>

<main id="main-content" class="flex-1 p-10 ml-0 md:ml-72 transition-all duration-300">
  
  <h2 class="text-4xl font-bold text-green-800 mb-8">Progress Laporan Anda 📈</h2>
  
  <?php if (empty($reports)) : ?>
      <div class="backdrop-card p-6 rounded-lg text-center text-gray-700">
          <p class="font-semibold text-lg">Anda belum memiliki laporan yang tercatat.</p>
          <p class="mt-2">Ayo laporkan pencemaran pertama Anda!</p>
      </div>
  <?php else : ?>
      
      <div class="space-y-6">
          
          <?php foreach ($reports as $report) : ?>
              <div class="backdrop-card p-6 rounded-xl shadow-lg border-l-4 border-green-600">
                  <div class="flex justify-between items-start mb-3">
                      <h3 class="text-xl font-bold text-green-700">Laporan #<?= $report['id'] ?></h3>
                      
                      <span class="px-3 py-1 text-sm font-semibold rounded-full <?= get_status_class($report['status']) ?>">
                          <?= $report['status'] ?>
                      </span>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700 border-t pt-3">
                      <div>
                          <p class="font-medium">Jenis:</p>
                          <p class="ml-2"><?= $report['jenis'] ?></p>
                      </div>
                      <div>
                          <p class="font-medium">Tanggal Lapor:</p>
                          <p class="ml-2"><?= date('d F Y', strtotime($report['tanggal'])) ?></p>
                      </div>
                      <div class="md:col-span-2">
                          <p class="font-medium">Lokasi:</p>
                          <p class="ml-2 italic"><?= $report['lokasi'] ?></p>
                      </div>
                      
                      <div class="md:col-span-2 mt-3 p-3 bg-gray-100 rounded-lg border-l-2 border-gray-400">
                          <p class="font-semibold text-sm text-gray-800">Progress Terkini:</p>
                          <p class="text-sm"><?= $report['catatan_admin'] ?></p>
                      </div>
                      
                  </div>
              </div>
          <?php endforeach; ?>

      </div>

  <?php endif; ?>

</main>

<script src="../Assets/js/script.js"></script>

</body>
</html>