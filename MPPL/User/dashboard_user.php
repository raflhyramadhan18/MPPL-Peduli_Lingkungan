<?php
require '../Akses/auth_check.php';
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Peduli Lingkungan</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
#sidebar {
  transition: transform 0.3s ease;
}
.sidebar-open {
  transform: translateX(0) !important;
}
.sidebar-closed {
  transform: translateX(-18rem) !important;
}
</style>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<style>
body {
  background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1920&q=80');
  background-size: cover;
  background-position: center;
}
.backdrop-card {
  background-color: rgba(255,255,255,0.7);
  backdrop-filter: blur(10px);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.backdrop-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}
.sidebar-open { transform: translateX(0); }
.sidebar-closed { transform: translateX(-18rem); }
</style>
</head>

<body class="min-h-screen flex pt-16 text-gray-800">

<!-- Overlay (mobile) -->
<div id="overlay" class="fixed inset-0 bg-black/50 hidden z-10 md:hidden"></div>

<!-- Sidebar -->
<?php include '../Navigasi/navmain.php'; ?>

<!-- Navbar -->
<?php include '../Navigasi/navbar.php'; ?>

<!-- Main content -->
<main id="main-content" class="flex-1 p-10 ml-72 transition-all duration-300">
  <h2 class="text-4xl font-bold text-green-800 mb-6">Selamat datang, <?= htmlspecialchars($username) ?>! 🌿</h2>

  <div class="grid md:grid-cols-2 gap-6">
    <div class="backdrop-card p-6 rounded-2xl shadow-lg">
      <h3 class="text-2xl font-semibold mb-4 text-green-900">Profil Anda</h3>
      <p><span class="font-medium">Username:</span> <?= htmlspecialchars($username) ?></p>
      <p><span class="font-medium">Role:</span> User</p>
    </div>

    <div class="backdrop-card p-6 rounded-2xl shadow-lg">
      <h3 class="text-2xl font-semibold mb-4 text-green-900">Tips Harian Peduli Lingkungan</h3>
      <p id="daily-tips" class="text-green-800 font-medium mt-2"></p>
    </div>
  </div>
</main>

<script>
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const toggle = document.getElementById("sidebar-toggle");
const mainContent = document.getElementById("main-content");

// Toggle sidebar (desktop & mobile)
toggle.addEventListener("click", () => {
  const closed = sidebar.classList.toggle("sidebar-closed");
  mainContent.classList.toggle("ml-72", !closed);
  mainContent.classList.toggle("ml-0", closed);
  overlay.classList.toggle("hidden");
});

overlay.addEventListener("click", () => {
  sidebar.classList.add("sidebar-closed");
  mainContent.classList.remove("ml-72");
  mainContent.classList.add("ml-0");
  overlay.classList.add("hidden");
});

// Tips harian
const tips = [
  "Kurangi penggunaan plastik sekali pakai 🌏",
  "Matikan lampu saat tidak digunakan 💡",
  "Gunakan transportasi umum atau sepeda 🚴",
  "Tanam satu pohon setiap tahun 🌳",
  "Gunakan botol minum isi ulang 💧"
];
document.getElementById("daily-tips").textContent = tips[Math.floor(Math.random() * tips.length)];
</script>

</body>
</html>
