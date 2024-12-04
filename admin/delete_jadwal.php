<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Menghubungkan ke database
include '../config.php';

$idJadwal = $_GET['idJadwal'];

$sql = "DELETE FROM jadwal WHERE idJadwal=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idJadwal);

if ($stmt->execute()) {
    header("Location: jadwal.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
