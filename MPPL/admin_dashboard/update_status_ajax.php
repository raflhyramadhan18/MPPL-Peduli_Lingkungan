<?php
session_start();
require '../Akses/auth_check.php';
require '../Akses/config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Akses ditolak.']);
    exit;
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metode tidak diizinkan.']);
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'CSRF Token mismatch. Permintaan ditolak.']);
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$status_baru = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

if (!$id || empty($status_baru)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID atau status tidak valid.']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE pengaduan SET status = ?, updated_at = NOW() WHERE id = ?");

    $result = $stmt->execute([$status_baru, $id]);
    $row_count = $stmt->rowCount();

    if ($result && $row_count > 0) {
        echo json_encode(['success' => true, 'message' => 'Status berhasil diperbarui!', 'new_status' => $status_baru]);
    } else if ($row_count === 0) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'ID laporan tidak ditemukan atau status sudah sama.']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status di database.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Kesalahan Database: ' . $e->getMessage()]);
}
