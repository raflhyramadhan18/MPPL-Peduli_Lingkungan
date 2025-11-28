<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<nav id="sidebar" class="fixed z-20 top-0 left-0 w-72 h-screen bg-green-700 text-white flex flex-col p-6 transform sidebar-open shadow-lg transition-transform duration-300 ease-in-out">
  <h1 class="text-2xl font-bold mb-8 tracking-wide">🌿 Menu Utama</h1>

  <a href="../User/dashboard_user.php" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-green-600 hover:scale-[1.02] transition duration-200 mb-2">
    <span class="material-symbols-outlined text-3xl">dashboard</span>
    <span class="text-lg font-medium">Dashboard</span>
  </a>

  <a href="../User/lapor_form.php" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-green-600 hover:scale-[1.02] transition duration-200 mb-2">
    <span class="material-symbols-outlined text-3xl">campaign</span>
    <span class="text-lg font-medium">Lapor Pencemaran</span>
  </a>

  <a href="../User/laporan_progress.php" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-green-600 hover:scale-[1.02] transition duration-200 mb-2">
    <span class="material-symbols-outlined text-3xl">track_changes</span>
    <span class="text-lg font-medium">Progress Laporan</span>
  </a>

  <a href="../User/edukasi_interaktif.php" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-green-600 hover:scale-[1.02] transition duration-200 mb-2">
    <span class="material-symbols-outlined text-3xl">lightbulb</span>
    <span class="text-lg font-medium">Edukasi & Tips</span>
  </a>

  <a href="../Akses/logout.php" id="logout-btn" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-red-500 hover:bg-red-600 hover:scale-[1.03] transition duration-200 mt-auto">
    <span class="material-symbols-outlined text-3xl">logout</span>
    <span class="text-lg font-medium">Logout</span>
  </a>
</nav>