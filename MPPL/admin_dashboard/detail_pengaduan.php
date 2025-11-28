?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Pengaduan - Admin</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
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
        <li class="nav-item"><a class="nav-link text-warning" href="../auth/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
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
      <div id="detail-content" class="p-2 text-center text-muted">Memuat data...</div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  // Ambil ID dari URL (tidak wajib di versi dummy, tapi tetap dipertahankan)
  const id = new URLSearchParams(window.location.search).get("id");

  // Data dummy (nanti ganti kalau be udh jadi)
  const data = {
    id: 1,
    nama_pelapor: "Rizki Santoso",
    judul: "Sampah Menumpuk di Sungai",
    tanggal: "2025-10-13",
    status: "proses",
    isi: "Terjadi penumpukan sampah di sungai dekat jalan raya. Mohon segera ditindak.",
    foto: "contoh.jpg"
  };

  // Ambil elemen container detail
  const el = document.getElementById("detail-content");

  // Masukkan HTML ke dalam elemen
  el.innerHTML = `
    <div class="row">
      <div class="col-md-6">
        <h5 class="fw-bold text-success mb-2">${data.judul}</h5>
        <p><strong>Nama Pelapor:</strong> ${data.nama_pelapor}</p>
        <p><strong>Tanggal:</strong> ${data.tanggal}</p>
        <p><strong>Status:</strong> 
          <span class="badge ${
            data.status === 'selesai' ? 'bg-success' :
            data.status === 'proses' ? 'bg-info' : 'bg-warning text-dark'
          }">${data.status}</span>
        </p>
        <p><strong>Isi Laporan:</strong><br>${data.isi}</p>
      </div>
      <div class="col-md-6 text-center">
        <h6 class="fw-bold">Bukti Foto</h6>
        ${
          data.foto
            ? `<img src="../assets/img/${data.foto}" alt="Bukti Pengaduan" class="img-fluid rounded shadow-sm" style="max-height:300px;">`
            : `<p class="text-muted fst-italic">Tidak ada foto dilampirkan.</p>`
        }
      </div>
    </div>
    <hr>
    <div class="d-flex justify-content-end gap-2">
      <a href="#" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Ubah Status</a>
      <a href="#" class="btn btn-danger"><i class="bi bi-trash"></i> Hapus</a>
    </div>
  `;
});
</script>

</body>
</html>
