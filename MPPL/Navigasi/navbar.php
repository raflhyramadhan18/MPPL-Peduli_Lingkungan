<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: ../Akses/login.php");
    exit;
}

$username = $_SESSION['username'] ?? 'User';
?>

<!-- Navbar Start -->
<nav id="navbar" class="fixed top-0 left-0 right-0 h-16 bg-green-700 text-white flex items-center justify-between px-6 z-30 shadow-lg transition-all duration-300">
  <div class="flex items-center gap-3">
    <!-- Tombol toggle di sebelah tulisan -->
    <button id="sidebar-toggle" class="p-2 rounded hover:bg-green-600 transition">
      <span class="material-symbols-outlined">menu</span>
    </button>
    <span id="logo" class="font-bold text-xl tracking-wide">Peduli Lingkungan</span>
  </div>

  <div class="flex items-center space-x-4">
    <div class="text-right">
      <p class="font-semibold"><?= htmlspecialchars($username) ?></p>
      <p class="text-sm italic">User</p>
    </div>
    <img src="../Gambar/user-placeholder.png" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover border-2 border-white">
  </div>
</nav>
<!-- Navbar End -->
