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
$statusBerkas = isset($_POST['statusBerkas']) ? $_POST['statusBerkas'] : '';

if ($idDaftar <= 0 || empty($statusBerkas)) {
    die("Invalid input");
}

// Query untuk memperbarui statusBerkas
$sql = "UPDATE berkas SET statusBerkas = ? WHERE idDaftar = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("si", $statusBerkas, $idDaftar);
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
