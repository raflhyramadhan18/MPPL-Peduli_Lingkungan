<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pengaduan - Admin</title>

  <!-- ✅ Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { background-color: #f8f9fa; }
    .card { border: none; border-radius: 12px; }
    .table thead th { background-color: #198754 !important; color: white; }
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
          <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link active" href="data_pengaduan.php"><i class="bi bi-clipboard-data"></i> Pengaduan</a></li>
          <li class="nav-item"><a class="nav-link" href="data_user.php"><i class="bi bi-people"></i> User</a></li>
          <li class="nav-item"><a class="nav-link text-warning" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ✅ Konten utama -->
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-success"><i class="bi bi-clipboard-data"></i> Data Pengaduan</h3>
      <button class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Data (Dummy)</button>
    </div>

    <div class="card shadow-sm">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
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
          <tbody id="tabel-data">
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
      // Data dummy
      const pengaduan = [
        { id: 1, judul: "Sampah di Sungai", nama: "Rizki Santoso", tanggal: "2025-10-12", status: "proses" },
        { id: 2, judul: "Pohon Tumbang", nama: "Siti Aulia", tanggal: "2025-10-10", status: "selesai" },
        { id: 3, judul: "Bau Limbah Pabrik", nama: "Dedi Mulyana", tanggal: "2025-10-08", status: "menunggu" },
        { id: 4, judul: "Saluran Air Mampet", nama: "Budi Hartono", tanggal: "2025-10-07", status: "proses" },
        { id: 5, judul: "Sampah Plastik Berserakan", nama: "Ayu Lestari", tanggal: "2025-10-05", status: "selesai" },
      ];

      const tbody = document.getElementById("tabel-data");
      tbody.innerHTML = "";

      pengaduan.forEach((p, i) => {
        const statusBadge =
          p.status === "selesai"
            ? "bg-success"
            : p.status === "proses"
            ? "bg-info"
            : "bg-warning text-dark";

        tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${p.judul}</td>
            <td>${p.nama}</td>
            <td>${p.tanggal}</td>
            <td><span class="badge ${statusBadge}">${p.status}</span></td>
            <td>
              <a href="detail_pengaduan.php?id=${p.id}" class="btn btn-sm btn-outline-success"><i class="bi bi-eye"></i></a>
              <a href="update_status.php?id=${p.id}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil-square"></i></a>
              <a href="delete_pengaduan.php?id=${p.id}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus laporan ini?')"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
        `;
      });
    });
  </script>

</body>
</html>
