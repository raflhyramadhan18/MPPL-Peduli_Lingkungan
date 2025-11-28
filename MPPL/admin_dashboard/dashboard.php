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
          <li class="nav-item"><a class="nav-link text-warning" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
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
            <h3 id="total-pengaduan" class="fw-bold text-dark">0</h3>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
          <div class="card-body">
            <i class="bi bi-hourglass-split text-info" style="font-size: 2.5rem;"></i>
            <h5 class="mt-3">Sedang Diproses</h5>
            <h3 id="pengaduan-proses" class="fw-bold text-dark">0</h3>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card shadow-sm text-center p-3">
          <div class="card-body">
            <i class="bi bi-check-circle text-success" style="font-size: 2.5rem;"></i>
            <h5 class="mt-3">Selesai</h5>
            <h3 id="pengaduan-selesai" class="fw-bold text-dark">0</h3>
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
            <tr>
              <td colspan="6" class="text-center text-muted">Memuat data...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ✅ Script Dummy -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Data Dummy
      const data = [
        { id: 1, judul: "Sampah di Sungai", nama: "Rizki Santoso", tanggal: "2025-10-12", status: "proses" },
        { id: 2, judul: "Pohon Tumbang", nama: "Siti Aulia", tanggal: "2025-10-11", status: "selesai" },
        { id: 3, judul: "Saluran Air Tersumbat", nama: "Budi Hartono", tanggal: "2025-10-10", status: "menunggu" },
      ];

      // Hitung Statistik
      document.getElementById("total-pengaduan").innerText = data.length;
      document.getElementById("pengaduan-proses").innerText = data.filter(d => d.status === "proses").length;
      document.getElementById("pengaduan-selesai").innerText = data.filter(d => d.status === "selesai").length;

      // Isi Tabel
      const tbody = document.getElementById("tabel-pengaduan");
      tbody.innerHTML = "";
      data.forEach((d, i) => {
        tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${d.judul}</td>
            <td>${d.nama}</td>
            <td>${d.tanggal}</td>
            <td>
              <span class="badge ${
                d.status === 'selesai' ? 'bg-success' :
                d.status === 'proses' ? 'bg-info' : 'bg-warning text-dark'
              }">${d.status}</span>
            </td>
            <td>
              <a href="detail_pengaduan.php?id=${d.id}" class="btn btn-sm btn-outline-success">
                <i class="bi bi-eye"></i> Detail
              </a>
            </td>
          </tr>
        `;
      });
    });
  </script>

</body>
</html>
