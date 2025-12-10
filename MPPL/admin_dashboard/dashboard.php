<?php
session_start();
require '../Akses/auth_check.php';
require '../Akses/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../User/dashboard_user.php");
  exit;
}

$total_pengaduan = 0;
$pengaduan_proses = 0;
$pengaduan_selesai = 0;
$laporan_terbaru = [];

try {
  $stmt_stats = $pdo->prepare("SELECT 
        COUNT(id) AS total,
        COUNT(CASE WHEN status IN ('baru', 'menunggu', 'proses') THEN 1 END) AS proses,
        COUNT(CASE WHEN status = 'selesai' THEN 1 END) AS selesai
        FROM pengaduan");

  $stmt_stats->execute();
  $stats = $stmt_stats->fetch(PDO::FETCH_ASSOC);

  if ($stats) {
    $total_pengaduan = $stats['total'];
    $pengaduan_proses = $stats['proses'];
    $pengaduan_selesai = $stats['selesai'];
  }

  $stmt_recent = $pdo->prepare("SELECT 
        p.id, 
        p.jenis_pencemaran AS judul, 
        p.created_at AS tanggal, 
        p.status,
        p.pelapor_username AS nama_pelapor 
        FROM pengaduan p
        ORDER BY p.created_at DESC 
        LIMIT 5");

  $stmt_recent->execute();
  $laporan_terbaru = $stmt_recent->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $error = "Gagal mengambil data: " . $e->getMessage();
}

function get_status_class($status)
{
  switch (strtolower($status)) {
    case 'selesai':
      return 'bg-success';
    case 'proses':
    case 'menunggu':
    case 'baru':
      return 'bg-info text-dark';
    default:
      return 'bg-warning text-dark';
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Pengaduan Lingkungan</title>

  <!-- ✅ Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
    }

    .card {
      border: none;
      border-radius: 12px;
    }

    .card:hover {
      transform: scale(1.02);
      transition: 0.2s;
    }
  </style>
</head>

<body>

  <!-- ✅ Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="dashboard.php">
        <i class="bi bi-leaf"></i> Admin Panel
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="data_pengaduan.php"><i class="bi bi-clipboard-data"></i> Pengaduan</a></li>
          <li class="nav-item"><a class="nav-link" href="data_user.php"><i class="bi bi-people"></i> User</a></li>
          <li class="nav-item"><a class="nav-link text-warning" href="../Akses/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ✅ Konten Dashboard -->
  <div class="container py-4">
    <h3 class="fw-bold text-success mb-4"><i class="bi bi-speedometer2"></i> Dashboard Admin</h3>

    <!-- Statistik Ringkas -->
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
          <div class="card-body">
            <i class="bi bi-clipboard-data text-success" style="font-size: 2.5rem;"></i>
            <h5 class="mt-3">Total Pengaduan</h5>
            <h3 id="total-pengaduan" class="fw-bold text-dark"><?= $total_pengaduan ?></h3>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
          <div class="card-body">
            <i class="bi bi-hourglass-split text-info" style="font-size: 2.5rem;"></i>
            <h5 class="mt-3">Sedang Diproses</h5>
            <h3 id="pengaduan-proses" class="fw-bold text-dark"><?= $pengaduan_proses ?></h3>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
          <div class="card-body">
            <i class="bi bi-check-circle text-success" style="font-size: 2.5rem;"></i>
            <h5 class="mt-3">Selesai</h5>
            <h3 id="pengaduan-selesai" class="fw-bold text-dark"><?= $pengaduan_selesai ?></h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabel Ringkasan -->
    <div class="card shadow-sm border-0 mt-5">
      <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-list-task"></i> Ringkasan Pengaduan Terbaru</h5>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-success">
            <tr>
              <th>#</th>
              <th>Judul Pengaduan</th>
              <th>Nama Pelapor</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tabel-pengaduan">
            <?php if (!empty($laporan_terbaru)): ?>
              <?php $no = 1;
              foreach ($laporan_terbaru as $p): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($p['judul']) ?></td>
                  <td><?= htmlspecialchars($p['nama_pelapor']) ?></td>
                  <td><?= date('Y-m-d', strtotime($p['tanggal'])) ?></td>
                  <td>
                    <span class="badge <?= get_status_class($p['status']) ?>">
                      <?= htmlspecialchars(ucfirst($p['status'])) ?>
                    </span>
                  </td>
                  <td>
                    <a href="detail_pengaduan.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-success">
                      <i class="bi bi-eye"></i> Detail
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted">Tidak ada pengaduan terbaru.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>

</html>