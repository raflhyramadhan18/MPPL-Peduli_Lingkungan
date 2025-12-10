<?php
session_start();
require 'config.php';

$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email'] ?? '');
    $telp = trim($_POST['telp'] ?? '');
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($password) || empty($confirm_password) || empty($email) || empty($telp)) {
        $error = "Semua field harus diisi (Username, Email, No. Telepon, Password)!";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak sama!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            $error = "Username sudah terdaftar!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (username, email, telp, password, role) VALUES (?, ?, ?, ?, 'user')");
            
            if ($stmt->execute([$username, $email, $telp, $hashed])) {
                $_SESSION['flash_status'] = 'success';
                $_SESSION['flash_message'] = 'Akun Anda berhasil dibuat! Silakan masuk (login) menggunakan kredensial Anda.';

                header("Location: login.php");
                exit();
            } else {
                $error = "Terjadi kesalahan saat menyimpan data. Coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - MPPL Peduli Lingkungan</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<style>
body {
    background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
</head>

<body class="flex justify-center items-center min-h-screen backdrop-blur-md bg-black/30">

<div class="flex flex-col md:flex-row w-[900px] bg-white/10 rounded-2xl overflow-hidden shadow-2xl border border-white/20 backdrop-blur-xl">

    <div class="md:w-1/2 flex flex-col justify-center items-center bg-gradient-to-br from-green-700/70 to-green-500/60 text-white p-10">
        <h1 class="text-4xl font-bold tracking-wide">Peduli Lingkungan</h1>
        <p class="text-lg mt-2 text-green-100 italic">Bersama menjaga bumi untuk masa depan 🌿</p>
    </div>

    <div class="md:w-1/2 p-10 flex flex-col justify-center bg-white/70 backdrop-blur-xl">
        <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">Create Account</h2>

        <?php if (!empty($error)) : ?>
            <div class="text-red-600 text-center text-sm font-semibold mb-4"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label for="username" class="block text-gray-700 font-medium mb-1">Username</label>
                <input type="text" id="username" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>
            
            <div>
                <label for="telp" class="block text-gray-700 font-medium mb-1">No. Telepon</label>
                <input type="text" id="telp" name="telp" required value="<?= htmlspecialchars($_POST['telp'] ?? '') ?>"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 pr-10 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-green-600 cursor-pointer select-none toggle-password" data-target="password">
                        visibility
                    </span>
                </div>
            </div>

            <div>
                <label for="confirm_password" class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                <div class="relative">
                    <input type="password" id="confirm_password" name="confirm_password" required
                        class="w-full px-4 py-2 pr-10 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-green-600 cursor-pointer select-none toggle-password" data-target="confirm_password">
                        visibility
                    </span>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition duration-200">
                Register Now
            </button>

            <p class="text-center text-sm text-gray-700">
                Already have an account?
                <a href="login.php" class="text-green-700 font-semibold hover:underline">Login here</a>
            </p>
        </form>
    </div>
</div>

<script>
document.querySelectorAll(".toggle-password").forEach(icon => {
    icon.addEventListener("click", () => {
        const targetId = icon.dataset.target;
        const input = document.getElementById(targetId);
        if (!input) return;

        const type = input.type === "password" ? "text" : "password";
        input.type = type;
        icon.textContent = type === "password" ? "visibility" : "visibility_off";
    });
});
</script>

</body>
</html>