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
$statusBayar = isset($_POST['statusBayar']) ? $_POST['statusBayar'] : '';

if ($idDaftar <= 0 || empty($statusBayar)) {
    die("Invalid input");
}

// Query untuk memperbarui statusBayar
$sql = "UPDATE bayar SET statusBayar = ? WHERE idBayar = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("si", $statusBayar, $idDaftar);
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
