<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaduan Lingkungan</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  
  <style>
    body {
      background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .hero-card {
      background: white;
      border-radius: 20px;
      margin-top: 20px;
      padding: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      width: 90%;
    }
    .btn-lg {
      padding: 12px 30px;
      font-size: 1.1rem;
    }
  </style>
</head>

<body>

  <div class="hero-card text-center m">
    <img src="assets/img/logo.png" alt="Logo" width="200" >
    <h1 class="fw-bold text-success mb-3">Sistem Pengaduan Lingkungan</h1>
    <p class="text-muted mb-4">
      Laporkan permasalahan lingkungan di sekitar Anda secara cepat dan mudah.
    </p>

    <div class="d-flex justify-content-center gap-3 mb-3">
      <a href="Akses/login.php" class="btn btn-success btn-lg">
        <i class="bi bi-box-arrow-in-right"></i> Login
      </a>
      <a href="Akses/register.php" class="btn btn-outline-success btn-lg">
        <i class="bi bi-person-plus"></i> Register
      </a>
    </div>

    <hr class="my-4">

    <a href="admin_dashboard/dashboard.php" class="btn btn-warning">
      <i class="bi bi-speedometer2"></i> Masuk Dashboard Admin (Demo)
    </a>
  </div>

  <footer class="text-center text-muted mt-4 small">
    &copy; <?= date("Y") ?> Sistem Pengaduan Lingkungan — Kelompok MPPL
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
