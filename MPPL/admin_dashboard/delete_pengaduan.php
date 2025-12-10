<?php
session_start();
require '../Akses/auth_check.php';
require '../Akses/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../User/dashboard_user.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: data_pengaduan.php");
    exit;
}

$id_pengaduan = (int) $_GET['id'];

try {
    $stmt_file = $pdo->prepare("SELECT bukti_gambar_path FROM pengaduan WHERE id = ?");
    $stmt_file->execute([$id_pengaduan]);
    $file_path = $stmt_file->fetchColumn();

    $stmt_delete = $pdo->prepare("DELETE FROM pengaduan WHERE id = ?");
    $stmt_delete->execute([$id_pengaduan]);

    if ($file_path && $file_path != 'N/A') {
        $full_path = '../Assets/uploads/' . $file_path;
        if (file_exists($full_path)) {
            unlink($full_path); 
        }
    }

    $_SESSION['flash_status'] = 'success';
    $_SESSION['flash_message'] = "Pengaduan ID {$id_pengaduan} berhasil dihapus.";
    header("Location: data_pengaduan.php");
    exit;
} catch (PDOException $e) {
    $_SESSION['flash_status'] = 'danger';
    $_SESSION['flash_message'] = "Gagal menghapus pengaduan: " . $e->getMessage();
    header("Location: data_pengaduan.php");
    exit;
}
