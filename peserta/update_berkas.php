<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role yang sesuai
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'peserta') {
    header("Location: ../index.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Menghubungkan ke database
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idLogin = $_SESSION['idLogin'];
    $statusBerkas = 'proses';

    // Folder tujuan untuk menyimpan file
    $targetDir = "../uploads/";

    // Retrieve existing file paths from database
    $sqlSelect = "SELECT foto, ktp, skck, sSehat FROM berkas WHERE idBerkas = ?";
    $stmtSelect = $conn->prepare($sqlSelect);

    if ($stmtSelect) {
        $stmtSelect->bind_param("i", $idLogin);
        $stmtSelect->execute();
        $stmtSelect->store_result();

        if ($stmtSelect->num_rows > 0) {
            $stmtSelect->bind_result($currentFoto, $currentKtp, $currentSkck, $currentSSehat);
            $stmtSelect->fetch();
        } else {
            // Handle if no records found (optional)
            header("Location: Berkas.php?status=error&message=No record found");
            exit();
        }

        $stmtSelect->close();
    } else {
        header("Location: Berkas.php?status=error&message=" . urlencode($conn->error));
        exit();
    }

    // Prepare variables to store new paths or retain existing paths
    $fotoPath = $currentFoto;
    $ktpPath = $currentKtp;
    $skckPath = $currentSkck;
    $sSehatPath = $currentSSehat;

    // Check if new file is uploaded for foto
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto'];
        $fotoName = basename($foto['name']);
        $fotoType = strtolower(pathinfo($fotoName, PATHINFO_EXTENSION));

        // Validate file type
        $allowedTypes = array('jpg', 'jpeg', 'png', 'pdf');
        if (!in_array($fotoType, $allowedTypes)) {
            header("Location: Berkas.php?status=error&message=Invalid file type for Foto");
            exit();
        }

        // Generate unique filename
        $fotoPath = $targetDir . uniqid() . "_" . $fotoName;

        // Upload file
        if (!move_uploaded_file($foto['tmp_name'], $fotoPath)) {
            header("Location: Berkas.php?status=error&message=Error uploading Foto file");
            exit();
        }
    }

    // Check if new file is uploaded for ktp
    if (!empty($_FILES['ktp']['name'])) {
        $ktp = $_FILES['ktp'];
        $ktpName = basename($ktp['name']);
        $ktpType = strtolower(pathinfo($ktpName, PATHINFO_EXTENSION));

        // Validate file type
        if (!in_array($ktpType, $allowedTypes)) {
            header("Location: Berkas.php?status=error&message=Invalid file type for KTP");
            exit();
        }

        // Generate unique filename
        $ktpPath = $targetDir . uniqid() . "_" . $ktpName;

        // Upload file
        if (!move_uploaded_file($ktp['tmp_name'], $ktpPath)) {
            header("Location: Berkas.php?status=error&message=Error uploading KTP file");
            exit();
        }
    }

    // Check if new file is uploaded for skck
    if (!empty($_FILES['skck']['name'])) {
        $skck = $_FILES['skck'];
        $skckName = basename($skck['name']);
        $skckType = strtolower(pathinfo($skckName, PATHINFO_EXTENSION));

        // Validate file type
        if (!in_array($skckType, $allowedTypes)) {
            header("Location: Berkas.php?status=error&message=Invalid file type for SKCK");
            exit();
        }

        // Generate unique filename
        $skckPath = $targetDir . uniqid() . "_" . $skckName;

        // Upload file
        if (!move_uploaded_file($skck['tmp_name'], $skckPath)) {
            header("Location: Berkas.php?status=error&message=Error uploading SKCK file");
            exit();
        }
    }

    // Check if new file is uploaded for sSehat
    if (!empty($_FILES['sSehat']['name'])) {
        $sSehat = $_FILES['sSehat'];
        $sSehatName = basename($sSehat['name']);
        $sSehatType = strtolower(pathinfo($sSehatName, PATHINFO_EXTENSION));

        // Validate file type
        if (!in_array($sSehatType, $allowedTypes)) {
            header("Location: Berkas.php?status=error&message=Invalid file type for Surat Sehat");
            exit();
        }

        // Generate unique filename
        $sSehatPath = $targetDir . uniqid() . "_" . $sSehatName;

        // Upload file
        if (!move_uploaded_file($sSehat['tmp_name'], $sSehatPath)) {
            header("Location: Berkas.php?status=error&message=Error uploading Surat Sehat file");
            exit();
        }
    }

    // Menyimpan data ke database
    $sqlUpdate = "UPDATE berkas SET foto = ?, ktp = ?, skck = ?, sSehat = ?, statusBerkas = ? WHERE idBerkas = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);

    if ($stmtUpdate) {
        $stmtUpdate->bind_param("sssssi", $fotoPath, $ktpPath, $skckPath, $sSehatPath, $statusBerkas, $idLogin);

        if ($stmtUpdate->execute()) {
            // Redirect with success message
            header("Location: Berkas.php?status=success");
            exit();
        } else {
            // Redirect with error message
            header("Location: Berkas.php?status=error&message=" . urlencode($stmtUpdate->error));
            exit();
        }

        $stmtUpdate->close();
    } else {
        // Redirect with error message
        header("Location: Berkas.php?status=error&message=" . urlencode($conn->error));
        exit();
    }
}

$conn->close();
?>
