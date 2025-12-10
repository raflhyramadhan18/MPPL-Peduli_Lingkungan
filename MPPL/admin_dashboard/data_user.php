<?php
session_start();
require '../Akses/auth_check.php';
require '../Akses/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../User/dashboard_user.php");
  exit;
}

$users = [];
$error = '';

try {
  $stmt = $pdo->prepare("SELECT 
        username, 
        email, 
        telp, 
        created_at 
        FROM users 
        WHERE role = 'user' 
        ORDER BY created_at DESC");

  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $error = "Gagal mengambil data user: SQLSTATE[{$e->getCode()}]: {$e->getMessage()}";
}

function get_status_class($status)
{
  return (strtolower($status) == 'aktif') ? 'bg-success' : 'bg-secondary';
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data User - Admin</title>

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
  </style>
</head>

<body>

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
          <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="data_pengaduan.php"><i class="bi bi-clipboard-data"></i> Pengaduan</a></li>
          <li class="nav-item"><a class="nav-link active" href="data_user.php"><i class="bi bi-people"></i> User</a></li>
          <li class="nav-item"><a class="nav-link text-warning" href="../Akses/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-success"><i class="bi bi-people"></i> Data User</h3>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Username</th>
              <th>Email</th>
              <th>No. Telepon</th>
              <th>Tanggal Daftar</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tabel-user">
            <?php if (!empty($users)): ?>
              <?php $no = 1;
              foreach ($users as $u): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($u['username']) ?></td>
                  <td><?= htmlspecialchars($u['email']) ?></td>
                  <td><?= htmlspecialchars($u['telp']) ?></td>
                  <td><?= date('Y-m-d', strtotime($u['created_at'])) ?></td>
                  <td><span class="badge <?= get_status_class('aktif') ?>">aktif</span></td>
                  <td>
                    <a href="edit_user.php?username=<?= urlencode($u['username']) ?>" class="btn btn-sm btn-outline-primary" title="Edit User">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="delete_user.php?username=<?= urlencode($u['username']) ?>" class="btn btn-sm btn-outline-danger" title="Hapus User" onclick="return confirm('Yakin hapus user <?= htmlspecialchars($u['username']) ?>?')">
                      <i class="bi bi-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted">Tidak ada data pengguna yang terdaftar.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>

</html>