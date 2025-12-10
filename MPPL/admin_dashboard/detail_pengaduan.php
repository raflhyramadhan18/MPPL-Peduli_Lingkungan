<?php
session_start();
require '../Akses/auth_check.php';
require '../Akses/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: data_pengaduan.php");
  exit;
}

// Cek hak akses Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../User/dashboard_user.php");
  exit;
}

$id_pengaduan = (int) $_GET['id'];
$pengaduan = null;

try {
  $stmt = $pdo->prepare("SELECT 
    p.id, 
    p.jenis_pencemaran AS judul, 
    p.lokasi, 
    p.keterangan AS isi, 
    p.bukti_gambar_path AS foto, 
    p.created_at AS tanggal, 
    p.status,
    p.pelapor_username AS nama_pelapor
    FROM pengaduan p
    WHERE p.id = ?");

  $stmt->execute([$id_pengaduan]);
  $pengaduan = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$pengaduan) {
    $error = "Data pengaduan tidak ditemukan.";
  }
} catch (PDOException $e) {
  $error = "Terjadi kesalahan database: " . $e->getMessage();
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
  <title>Detail Pengaduan - Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel-stylesheet">
</head>

<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-leaf"></i> Admin Panel</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
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

  <div class="container py-4">
    <a href="data_pengaduan.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>

    <div class="card shadow-sm border-0">
      <div class="card-header bg-success text-white">
        <h4 class="mb-0"><i class="bi bi-info-circle"></i> Detail Pengaduan</h4>
      </div>
      <div class="card-body">
        <?php if (isset($error)): ?>
          <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($pengaduan): ?>
          <div class="row">
            <div class="col-md-6">
              <h5 class="fw-bold text-success mb-2"><?= htmlspecialchars($pengaduan['judul']) ?></h5>
              <p><strong>Nama Pelapor:</strong> <?= htmlspecialchars($pengaduan['nama_pelapor']) ?></p>
              <p><strong>Tanggal:</strong> <?= date('Y-m-d H:i', strtotime($pengaduan['tanggal'])) ?></p>
              <p><strong>Status:</strong>
                <span class="badge <?= get_status_class($pengaduan['status']) ?>">
                  <?= htmlspecialchars(ucfirst($pengaduan['status'])) ?>
                </span>
              </p>
              <p><strong>Isi Laporan:</strong><br><?= nl2br(htmlspecialchars($pengaduan['isi'])) ?></p>
            </div>
            <div class="col-md-6 text-center">
              <h6 class="fw-bold">Bukti Foto</h6>
              <?php if ($pengaduan['foto']): ?>
                <img src="../Assets/uploads/<?= htmlspecialchars($pengaduan['foto']) ?>" alt="Bukti Pengaduan" class="img-fluid rounded shadow-sm" style="max-height:300px;">
              <?php else: ?>
                <p class="text-muted fst-italic">Tidak ada foto dilampirkan.</p>
              <?php endif; ?>
            </div>
          </div>
          <hr>
          <div class="d-flex justify-content-end gap-2">
            <a href="edit_pengaduan.php?id=<?= $pengaduan['id'] ?>" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Ubah Status</a>
            <a href="delete_pengaduan.php?id=<?= $pengaduan['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus pengaduan ID <?= $pengaduan['id'] ?>?')"><i class="bi bi-trash"></i> Hapus</a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

</body>

</html>