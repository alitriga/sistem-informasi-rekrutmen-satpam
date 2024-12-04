<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Menghubungkan ke database
include '../config.php';

$idKaryawan = $_GET['idKaryawan'];

$sql = "DELETE FROM karyawan WHERE idKaryawan=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idKaryawan);

if ($stmt->execute()) {
    header("Location: karyawan.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
