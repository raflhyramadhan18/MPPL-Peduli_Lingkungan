<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data User - Admin</title>

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
          <li class="nav-item"><a class="nav-link" href="data_pengaduan.php"><i class="bi bi-clipboard-data"></i> Pengaduan</a></li>
          <li class="nav-item"><a class="nav-link active" href="data_user.php"><i class="bi bi-people"></i> User</a></li>
          <li class="nav-item"><a class="nav-link text-warning" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ✅ Konten utama -->
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="fw-bold text-success"><i class="bi bi-people"></i> Data User</h3>
      <button class="btn btn-success"><i class="bi bi-person-plus"></i> Tambah User (Dummy)</button>
    </div>

    <div class="card shadow-sm">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Lengkap</th>
              <th>Email</th>
              <th>No. Telepon</th>
              <th>Tanggal Daftar</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="tabel-user">
            <tr>
              <td colspan="7" class="text-center text-muted">Memuat data...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ✅ Script Dummy -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      // Data user dummy
      const users = [
        { id: 1, nama: "Rizki Santoso", email: "rizki@mail.com", telp: "081234567890", tanggal: "2025-09-20", status: "aktif" },
        { id: 2, nama: "Siti Aulia", email: "siti@mail.com", telp: "085612341234", tanggal: "2025-09-21", status: "aktif" },
        { id: 3, nama: "Budi Hartono", email: "budi@mail.com", telp: "081293847565", tanggal: "2025-09-22", status: "nonaktif" },
        { id: 4, nama: "Ayu Lestari", email: "ayu@mail.com", telp: "089512345678", tanggal: "2025-09-23", status: "aktif" },
        { id: 5, nama: "Dedi Mulyana", email: "dedi@mail.com", telp: "081998877665", tanggal: "2025-09-24", status: "nonaktif" }
      ];

      const tbody = document.getElementById("tabel-user");
      tbody.innerHTML = "";

      users.forEach((u, i) => {
        const statusBadge =
          u.status === "aktif" ? "bg-success" : "bg-secondary";

        tbody.innerHTML += `
          <tr>
            <td>${i + 1}</td>
            <td>${u.nama}</td>
            <td>${u.email}</td>
            <td>${u.telp}</td>
            <td>${u.tanggal}</td>
            <td><span class="badge ${statusBadge}">${u.status}</span></td>
            <td>
              <button class="btn btn-sm btn-outline-primary" title="Edit User">
                <i class="bi bi-pencil-square"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" title="Hapus User" onclick="return confirm('Hapus user ini?')">
                <i class="bi bi-trash"></i>
              </button>
            </td>
          </tr>
        `;
      });
    });
  </script>

</body>
</html>
