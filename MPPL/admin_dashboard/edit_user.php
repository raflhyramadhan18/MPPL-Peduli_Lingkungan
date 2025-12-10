<?php
session_start();
require '../Akses/auth_check.php';
require '../Akses/config.php';

// Cek Role Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header("Location: ../User/dashboard_user.php"); exit; }

if (!isset($_GET['username']) || empty($_GET['username'])) { header("Location: data_user.php"); exit; }

$username_target = trim($_GET['username']);
$error = '';
$success = '';
$user = null;

// --- LOGIKA UPDATE DATA USER (HANDLE POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_baru = trim($_POST['email']);
    $telp_baru = trim($_POST['telp']);
    
    // Safety Check: CSRF Token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Permintaan tidak valid (CSRF Token mismatch).";
    } elseif (empty($email_baru) || empty($telp_baru)) {
        $error = "Email dan No. Telepon harus diisi.";
    } elseif (!filter_var($email_baru, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } else {
        try {
            // Update data user
            $stmt = $pdo->prepare("UPDATE users SET email = ?, telp = ? WHERE username = ? AND role = 'user'");
            if ($stmt->execute([$email_baru, $telp_baru, $username_target])) {
                $success = "Data pengguna {$username_target} berhasil diperbarui.";
                header("Location: data_user.php"); // Redirect kembali ke list setelah update berhasil
                exit;
            } else {
                $error = "Gagal menyimpan perubahan ke database.";
            }
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    }
}
// --- END LOGIKA UPDATE ---


// Load data user untuk ditampilkan di form
try {
    $stmt_load = $pdo->prepare("SELECT username, email, telp FROM users WHERE username = ? AND role = 'user'");
    $stmt_load->execute([$username_target]);
    $user = $stmt_load->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error = "Pengguna tidak ditemukan atau bukan user biasa.";
    }
} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
}

// Jika terjadi POST error, isi kembali field dengan nilai POST agar tidak hilang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {
    $user['email'] = $_POST['email'];
    $user['telp'] = $_POST['telp'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User: <?= htmlspecialchars($username_target) ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Edit Data Pengguna: <?= htmlspecialchars($username_target) ?></h5>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <?php if ($user): ?>
                    <form method="POST" action="edit_user.php?username=<?= urlencode($username_target) ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>"> 
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" disabled>
                            <div class="form-text">Username tidak dapat diubah.</div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="telp" class="form-label">No. Telepon</label>
                            <input type="text" id="telp" name="telp" class="form-control" value="<?= htmlspecialchars($user['telp']) ?>" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="data_user.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">Pengguna tidak valid.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>