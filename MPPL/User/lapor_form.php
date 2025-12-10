<?php
require '../Akses/auth_check.php'; 
require '../Akses/config.php';

$username = $_SESSION['username'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $error = "Permintaan tidak valid (CSRF Token mismatch).";
  } else {
    $jenis_pencemaran = trim($_POST['jenis_pencemaran']);
    $lokasi           = trim($_POST['lokasi']);
    $keterangan       = trim($_POST['keterangan'] ?? '');
    $pelapor_username = $username;

    if (empty($jenis_pencemaran) || empty($lokasi)) {
      $error = "Jenis pencemaran dan lokasi wajib diisi.";
    }

    $file_info = $_FILES['bukti_gambar'];

    if (empty($error)) {
      $upload_dir = '../Assets/uploads/';
      $file_extension = pathinfo($file_info['name'], PATHINFO_EXTENSION);
      $new_file_name = uniqid('bukti_') . '.' . $file_extension;
      $upload_path = $upload_dir . $new_file_name;

      if ($file_info['error'] === UPLOAD_ERR_OK) {
        if (!move_uploaded_file($file_info['tmp_name'], $upload_path)) {
          $error = "Gagal memindahkan file yang di-upload. Cek izin tulis folder 'uploads'.";
        }
      } else {
        $error = "Upload file gagal. Kode error: " . $file_info['error'];
      }
    }

    if (empty($error)) {
      try {
        $stmt = $pdo->prepare("INSERT INTO pengaduan (pelapor_username, jenis_pencemaran, lokasi, keterangan, bukti_gambar_path, status, created_at) 

                VALUES (?, ?, ?, ?, ?, 'Baru', NOW())");
        $stmt->execute([

          $pelapor_username,
          $jenis_pencemaran,
          $lokasi,
          $keterangan,
          $new_file_name
        ]);



        $_SESSION['flash_status'] = 'success';
        $_SESSION['flash_message'] = 'Laporan Anda berhasil dikirim!';

        header("Location: laporan_progress.php");
        exit;
      } catch (PDOException $e) {
        $error = "Terjadi kesalahan database: " . $e->getMessage();
        if (file_exists($upload_path)) {
          unlink($upload_path);
        }
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lapor - Peduli Lingkungan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

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

    @media (max-width: 767px) {
      .sidebar-open {
        transform: translateX(-18rem) !important;
      }

      #sidebar.sidebar-open {
        transform: translateX(0) !important;
      }
    }

    @media (min-width: 768px) {
      .sidebar-closed {
        transform: translateX(-18rem) !important;
      }

      #sidebar.sidebar-open {
        transform: translateX(0) !important;
      }
    }

    body {
      background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1920&q=80');
      background-size: cover;
      background-position: center;
    }

    .backdrop-card {
      background-color: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(10px);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .backdrop-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
  </style>
</head>

<body class="min-h-screen flex pt-16 text-gray-800">
  <div id="overlay" class="fixed inset-0 bg-black/50 hidden z-10 md:hidden"></div>

  <?php include '../Navigasi/navmain.php'; ?>
  <?php include '../Navigasi/navbar.php'; ?>

  <main id="main-content" class="flex-1 p-10 ml-0 md:ml-72 transition-all duration-300">
    <h2 class="text-4xl font-bold text-green-800 mb-8">Lapor Pencemaran 🚨</h2>
    <div class="backdrop-card p-8 rounded-2xl shadow-xl w-full max-w-4xl mx-auto">
      <p class="text-gray-700 mb-6 italic">
        Silakan isi form di bawah ini dengan informasi sebenar-benarnya. Nama Pelapor (<?= htmlspecialchars($username) ?>) akan tercatat otomatis.
      </p>

      <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div>
          <label for="jenis_pencemaran" class="block text-gray-700 font-semibold mb-2">Jenis Pencemaran</label>
          <select id="jenis_pencemaran" name="jenis_pencemaran" required
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none bg-white">
            <option value="">-- Pilih Jenis Laporan --</option>
            <option value="sampah_liar">Penumpukan Sampah Liar</option>
            <option value="limbah_cair">Pembuangan Limbah Cair (Sungai/Laut)</option>
            <option value="polusi_udara">Polusi Udara (Asap Pabrik/Bakar)</option>
            <option value="perusakan_hutan">Perusakan Hutan/Lahan</option>
            <option value="lain_lain">Lain-lain...</option>
          </select>
        </div>

        <div>
          <label for="lokasi" class="block text-gray-700 font-semibold mb-2">Lokasi Kejadian (Alamat Detail)</label>
          <textarea id="lokasi" name="lokasi" rows="3" placeholder="Contoh: Belakang pasar X, dekat tiang listrik nomor 123" required
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none resize-none"></textarea>
        </div>

        <div>
          <label for="bukti_gambar" class="block text-gray-700 font-semibold mb-2">Upload Bukti Gambar</label>
          <input type="file" id="bukti_gambar" name="bukti_gambar" accept="image/*" required
            class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none bg-white/50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
          <p class="text-xs text-gray-500 mt-1">Maksimal 2MB. Format: JPG, PNG.</p>
        </div>

        <div>
          <label for="keterangan" class="block text-gray-700 font-semibold mb-2">Keterangan Tambahan (Opsional)</label>
          <textarea id="keterangan" name="keterangan" rows="2" placeholder="Detail lain yang perlu diketahui..."
            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none resize-none"></textarea>
        </div>

        <button type="submit"
          class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition duration-300 flex items-center justify-center gap-2">
          <span class="material-symbols-outlined">send</span>
          Kirim Laporan
        </button>
      </form>
    </div>
  </main>

  <script src="../Assets/js/script.js"></script>

</body>

</html>