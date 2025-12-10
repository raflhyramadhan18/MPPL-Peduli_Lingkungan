<?php
session_start();
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $stmt = $pdo->prepare("SELECT username, password, role FROM users WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] === 'admin') {
      header("Location: ../admin_dashboard/dashboard.php");
    } else {
      header("Location: ../User/dashboard_user.php");
    }
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}

$flash_status = $_SESSION['flash_status'] ?? null;
$flash_message = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_status']);
unset($_SESSION['flash_message']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - MPPL Peduli Lingkungan</title>
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
    <h2 class="text-3xl font-bold text-green-700 mb-6 text-center">Welcome Back</h2>

    <?php if (!empty($error)) : ?>
      <div class="text-red-600 text-center text-sm font-semibold mb-4"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($flash_status === 'success') : ?>
        <div id="flash-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Registrasi Berhasil!</strong>
            <span class="block sm:inline"><?= $flash_message ?></span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="document.getElementById('flash-message').style.display='none';">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.191l-2.651 3.658a1.2 1.2 0 0 1-1.697-1.697l2.846-3.918L5.651 7.151a1.2 1.2 0 0 1 1.697-1.697L10 8.809l2.651-3.658a1.2 1.2 0 0 1 1.697 1.697L11.191 10l3.658 2.651a1.2 1.2 0 0 1 0 1.697z"/></svg>
            </span>
        </div>
    <?php endif; ?>
    <form method="POST" class="space-y-5">
      <div>
        <label for="username" class="block text-gray-700 font-medium mb-1">Username</label>
        <input type="text" id="username" name="username" required
          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
      </div>

      <div>
        <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
        <div class="relative">
          <input type="password" id="password" name="password" required
            class="w-full px-4 py-2 pr-10 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:outline-none">
          <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-green-600 cursor-pointer select-none toggle-password">
            visibility
          </span>
        </div>
      </div>

      <button type="submit"
        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition duration-200">
        Login Now
      </button>

      <p class="text-center text-sm text-gray-700">
        Don’t have an account? 
        <a href="register.php" class="text-green-700 font-semibold hover:underline">Register here</a>
      </p>
    </form>
  </div>
</div>

<script>
// Toggle password visibility
const togglePassword = document.querySelector(".toggle-password");
const passwordInput = document.getElementById("password");

togglePassword.addEventListener("click", () => {
  const type = passwordInput.type === "password" ? "text" : "password";
  passwordInput.type = type;
  togglePassword.textContent = type === "password" ? "visibility" : "visibility_off";
});
</script>

</body>
</html>
