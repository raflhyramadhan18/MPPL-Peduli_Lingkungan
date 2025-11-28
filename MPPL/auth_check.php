<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Kalau belum login, redirect ke login page
    header("Location: login.php");
    exit;
}
?>