<?php
session_start();
require '../Akses/auth_check.php';
require '../Akses/config.php'; // Pastikan file koneksi database di-require

// Cek Role Admin (Pencegahan Akses Langsung oleh user biasa)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
    header("Location: ../User/dashboard_user.php"); 
    exit; 
}

// Cek Username Wajib
if (!isset($_GET['username']) || empty($_GET['username'])) {
    // Jika tidak ada username di URL, kembali ke halaman list
    header("Location: data_user.php");
    exit;
}

$username_target = trim($_GET['username']);

try {
    // Pencegahan: Jangan biarkan Admin menghapus akun Admin lain
    if ($username_target === $_SESSION['username']) {
        $_SESSION['flash_status'] = 'danger';
        $_SESSION['flash_message'] = "Anda tidak dapat menghapus akun Anda sendiri.";
        header("Location: data_user.php");
        exit;
    }

    // LOGIKA PENGHAPUSAN: Hapus HANYA user dengan role='user'
    $stmt_delete = $pdo->prepare("DELETE FROM users WHERE username = ? AND role = 'user'");
    $stmt_delete->execute([$username_target]);
    
    // Cek apakah ada baris yang terhapus
    if ($stmt_delete->rowCount() > 0) {
        $_SESSION['flash_status'] = 'success';
        $_SESSION['flash_message'] = "Pengguna {$username_target} berhasil dihapus.";
    } else {
        $_SESSION['flash_status'] = 'warning';
        $_SESSION['flash_message'] = "Pengguna {$username_target} tidak ditemukan atau tidak dapat dihapus (Mungkin sudah terhapus).";
    }

} catch (PDOException $e) {
    // Penanganan Error Database
    $_SESSION['flash_status'] = 'danger';
    $_SESSION['flash_message'] = "Gagal menghapus pengguna: " . $e->getMessage();
}

// Redirect kembali ke halaman Data User
header("Location: data_user.php");
exit;
?>