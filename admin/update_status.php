<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Menghubungkan ke database
include '../config.php';

// Mendapatkan data dari form
$idDaftar = isset($_POST['idDaftar']) ? intval($_POST['idDaftar']) : 0;
$statusDaftar = isset($_POST['statusDaftar']) ? $_POST['statusDaftar'] : '';

if ($idDaftar <= 0 || empty($statusDaftar)) {
    die("Invalid input");
}

// Query untuk memperbarui statusDaftar
$sql = "UPDATE pendaftaran SET statusDaftar = ? WHERE idDaftar = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("si", $statusDaftar, $idDaftar);
    if ($stmt->execute()) {
        header("Location: peserta_detail.php?idDaftar=" . $idDaftar . "&update=success");
    } else {
        die("Error updating record: " . $conn->error);
    }
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}
$conn->close();
?>
