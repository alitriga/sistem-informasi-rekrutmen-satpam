<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Connect to the database
include '../config.php';

$idPaket = $_GET['idPaket'];

$sql = "DELETE FROM paket WHERE idPaket=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idPaket);

if ($stmt->execute()) {
    header("Location: paket.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
