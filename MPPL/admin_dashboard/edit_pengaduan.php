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
$error = '';
$success = '';

// --- LOGIKA UPDATE STATUS (HANDLE POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status_baru = trim($_POST['status']);

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Permintaan tidak valid (CSRF Token mismatch).";
    } elseif (empty($status_baru)) {
        $error = "Status baru harus dipilih.";
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE pengaduan SET status = ?, updated_at = NOW() WHERE id = ?");
            if ($stmt->execute([$status_baru, $id_pengaduan])) {
                $success = "Status pengaduan ID {$id_pengaduan} berhasil diperbarui menjadi " . ucfirst($status_baru) . ".";
                header("Location: data_pengaduan.php"); 
                exit;
            } else {
                $error = "Gagal menyimpan status ke database.";
            }
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}
// --- END LOGIKA UPDATE STATUS ---


try {
    $stmt_load = $pdo->prepare("SELECT id, jenis_pencemaran, status FROM pengaduan WHERE id = ?");
    $stmt_load->execute([$id_pengaduan]);
    $pengaduan = $stmt_load->fetch(PDO::FETCH_ASSOC);

    if (!$pengaduan) {
        $error = "Pengaduan tidak ditemukan.";
    }
} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
}

$status_options = ['baru', 'proses', 'selesai'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Status #<?= $id_pengaduan ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Ubah Status Pengaduan #<?= $id_pengaduan ?></h5>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <?php if ($pengaduan): ?>
                    <p><strong>Judul:</strong> <?= htmlspecialchars($pengaduan['jenis_pencemaran']) ?></p>
                    <p><strong>Status Saat Ini:</strong> <span class="badge bg-secondary"><?= htmlspecialchars(ucfirst($pengaduan['status'])) ?></span></p>

                    <form method="POST" action="edit_pengaduan.php?id=<?= $id_pengaduan ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Baru</label>
                            <select id="status" name="status" class="form-select" required>
                                <?php foreach ($status_options as $opt): ?>
                                    <option value="<?= $opt ?>" <?= ($opt == $pengaduan['status']) ? 'selected' : '' ?>>
                                        <?= ucfirst($opt) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="data_pengaduan.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">Pengaduan tidak valid.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>