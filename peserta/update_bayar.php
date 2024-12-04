<?php
session_start();
include '../config.php';

// Pastikan hanya peserta yang dapat mengakses halaman ini
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'peserta') {
    http_response_code(403);
    exit();
}

$idLogin = $_SESSION['idLogin'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPaket = $_POST['idPaket'];
    $metode = $_POST['metode'];
    $statusBayar = 'proses';

    // Variabel tambahan untuk metode transfer
    $tglBayar = null;
    $nm = null;
    $bank = null;
    $upload = null;

    // Cek jika metode pembayaran adalah transfer, maka ambil data yang diperlukan
    if ($metode == 'Transfer') {
        $tglBayar = $_POST['tglBayar'];
        $nm = $_POST['nm'];
        $bank = $_POST['bank'];

        // Proses upload bukti pembayaran
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            $uploadFile = $uploadDir . basename($_FILES['upload']['name']);
            if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadFile)) {
                $upload = $uploadFile;
            } else {
                die("Error uploading file.");
            }
        } else {
            die("Error: No file uploaded.");
        }
    }

    // Update data pembayaran dalam database
    $sql = "UPDATE bayar SET idPaket = ?, metode = ?, tglBayar = ?, nm = ?, bank = ?, upload = ?, statusBayar = ? WHERE idBayar = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Perbaiki string parameter bind_param
        $stmt->bind_param(
            "issssssi",
            $idPaket,    // i - integer
            $metode,     // s - string
            $tglBayar,   // s - string (date)
            $nm,         // s - string
            $bank,       // s - string
            $upload,     // s - string (path file)
            $statusBayar,// s - string
            $idLogin     // i - integer
        );

        if ($stmt->execute()) {
            // Redirect ke halaman sukses
            header("Location: bayar.php?status=success");
            exit();
        } else {
            die("Error executing query: " . $stmt->error);
        }
    } else {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->close();
}

$conn->close();
?>
