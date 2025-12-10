<?php
session_start();
require '../Akses/auth_check.php';
require '../Akses/config.php';

if ($_SESSION['role'] !== 'admin') {
  header("Location: ../User/dashboard_user.php");
  exit;
}

try {
  $stmt = $pdo->prepare("SELECT 
 p.id, 
 p.jenis_pencemaran AS judul, 
 p.pelapor_username AS nama, 
p.created_at AS tanggal, 
 p.status
 FROM pengaduan p
 ORDER BY p.created_at DESC");

  $stmt->execute();
  $pengaduan = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $error = "Gagal mengambil data: " . $e->getMessage();
  $pengaduan = [];
}
function get_status_class($status)
{
  switch (strtolower($status)) {
    case 'selesai':
      return 'bg-success';
    case 'proses':
      return 'bg-info text-dark';
    case 'menunggu':
    case 'baru':
      return 'bg-warning text-dark';
    default:
      return 'bg-secondary';
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pengaduan - Admin</title>
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

    .table thead th {
      background-color: #198754 !important;
      color: white;
    }

    /* Tambahan style untuk badge/dropdown agar bisa diklik */
    .dropdown-menu {
      z-index: 1050;
      /* Pastikan dropdown muncul di atas elemen lain */
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
    <div class="container-fluid"> <a class="navbar-brand fw-bold" href="dashboard.php"> <i class="bi bi-leaf"></i> Admin Panel </a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link active" href="data_pengaduan.php"><i class="bi bi-clipboard-data"></i> Pengaduan</a></li>
          <li class="nav-item"><a class="nav-link" href="data_user.php"><i class="bi bi-people"></i> User</a></li>
          <li class="nav-item"><a class="nav-link text-warning" href="../Akses/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <input type="hidden" id="csrf-token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-success"><i class="bi bi-clipboard-data"></i> Data Pengaduan</h3>
    </div>
    <div class="card shadow-sm">
      <div class="card-body table-responsive"> <?php if (isset($error)): ?> <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div> <?php endif; ?> <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Judul</th>
              <th>Nama Pelapor</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tabel-data"> <?php if (!empty($pengaduan)): ?> <?php $no = 1;
                                                                    foreach ($pengaduan as $p): ?> <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($p['judul']) ?></td>
                  <td><?= htmlspecialchars($p['nama']) ?></td>
                  <td><?= date('Y-m-d', strtotime($p['tanggal'])) ?></td>
                  <td>
                    <span class="badge <?= get_status_class($p['status']) ?>">
                      <?= htmlspecialchars(ucfirst($p['status'])) ?>
                    </span>
                  </td>
                  <td>
                    <a href="detail_pengaduan.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-success"><i class="bi bi-eye"></i></a>
                    <a href="edit_pengaduan.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-warning" title="Ubah Status"><i class="bi bi-pencil-square"></i></a>
                    <a href="delete_pengaduan.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus laporan ini?')"><i class="bi bi-trash"></i></a>
                  </td>
                </tr> <?php endforeach; ?> <?php else: ?> <tr>
                <td colspan="6" class="text-center text-muted">Tidak ada data pengaduan.</td>
              </tr> <?php endif; ?> </tbody>
        </table>
      </div>
      <script src="../Assets/js/script.js"></script>
    </div>
  </div>
</body>

</html>