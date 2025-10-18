<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoComplaint - Pengaduan Lingkungan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Assets/style/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-leaf me-2"></i>EcoComplaint
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">Cara Kerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                </ul>
                <button class="btn btn-primary ms-lg-3 mt-3 mt-lg-0" onclick="window.location.href='index.php'">Laporkan Masalah</button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1>Selamat Datang di EcoComplaint</h1>
                    <p>Platform pengaduan lingkungan yang memudahkan Anda melaporkan masalah lingkungan di sekitar Anda. Bersama kita wujudkan bumi yang lebih hijau dan bersih.</p>
                    <button class="btn btn-primary btn-lg" onclick="window.location.href='index.php'">Laporkan Sekarang</button>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-app" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2>Tentang EcoComplaint</h2>
                    <div class="about-text">
                        <p>EcoComplaint adalah platform pengaduan lingkungan yang dirancang untuk membantu masyarakat menyampaikan keluhan atau laporan terkait kebersihan, pencemaran, dan permasalahan lingkungan lainnya di sekitar mereka.</p>
                        <p>Melalui sistem yang mudah digunakan, setiap laporan akan dikumpulkan dan ditampilkan agar masyarakat dapat berpartisipasi bersama dalam menjaga kelestarian lingkungan.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="Assets/img/Pohon.jpg" alt="EcoComplaint App" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Fitur Unggulan</h2>
                <p>Nikmati berbagai kemudahan dalam melaporkan masalah lingkungan dengan fitur-fitur berikut</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-pen-to-square"></i>
                        </div>
                        <h3>Pengaduan Online</h3>
                        <p>Laporkan masalah lingkungan dengan cepat tanpa proses panjang. Semua bisa dilakukan secara online.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        <h3>Unggah Foto</h3>
                        <p>Sertakan foto sebagai bukti visual untuk memperkuat laporan pengaduan lingkungan Anda.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Pantau Status</h3>
                        <p>Pantau perkembangan laporan Anda dari mulai diajukan hingga proses penanganan selesai.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-title">
                <h2>Cara Kerja</h2>
                <p>Hanya dengan 4 langkah mudah, Anda dapat berkontribusi melestarikan lingkungan</p>
            </div>
            <div class="process-container">
                <div class="process-connector d-none d-lg-block"></div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="process-step">
                            <div class="step-circle">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="step-content">
                                <h3>Daftar Akun</h3>
                                <p>Buat akun dengan mudah menggunakan email atau media sosial Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="process-step">
                            <div class="step-circle">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="step-content">
                                <h3>Laporkan Masalah</h3>
                                <p>Isi formulir pengaduan dengan detail masalah lingkungan yang ditemui.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="process-step">
                            <div class="step-circle">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div class="step-content">
                                <h3>Verifikasi</h3>
                                <p>Tim kami akan memverifikasi dan mengkategorikan laporan Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="process-step">
                            <div class="step-circle">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="step-content">
                                <h3>Tindak Lanjut</h3>
                                <p>Laporan akan diteruskan untuk ditindaklanjuti.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h2>Siap Melaporkan Masalah Lingkungan?</h2>
                    <p>Bergabunglah dengan pengguna lainnya yang telah berkontribusi menjaga kelestarian lingkungan</p>
                    <button class="btn btn-light btn-lg" onclick="window.location.href='index.php'">Mulai Laporkan Sekarang</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6 mb-4">
                    <h3>EcoComplaint</h3>
                    <p>Platform pengaduan lingkungan yang memudahkan masyarakat untuk melaporkan masalah lingkungan dan berkontribusi pada pelestarian bumi.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h3>Tautan Cepat</h3>
                    <ul class="footer-links">
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#how-it-works">Cara Kerja</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-12 mb-4">
                    <h3>Kontak Kami</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-envelope me-2"></i> pengaduanlingkungan@ecocomplaint.id</li>
                        <li><i class="fas fa-phone me-2"></i> +62 82 1234 5678</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Bandung, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Sistem Pengaduan Lingkungan — Kelompok MPPL</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Assets/js/script.js"></script>
</body>
</html>