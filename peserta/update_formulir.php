<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role yang sesuai
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'peserta') {
    header("Location: ../index.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Menghubungkan ke database
include '../config.php';

// Mendapatkan idLogin dari session
$idLogin = $_SESSION['idLogin'];

// Mengambil data dari formulir
$statusDaftar = $_POST['statusDaftar'] ?? '';
$nik = $_POST['nik'] ?? '';
$nama = $_POST['nama'] ?? '';
$jenkel = $_POST['jenkel'] ?? '';
$tLahir = $_POST['tLahir'] ?? '';
$tglLahir = $_POST['tglLahir'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$kel = $_POST['kel'] ?? '';
$kec = $_POST['kec'] ?? '';
$kabkota = $_POST['kabkota'] ?? '';
$prov = $_POST['prov'] ?? '';
$penddk = $_POST['penddk'] ?? '';
$tb = (float)($_POST['tb'] ?? '');  // Pastikan tipe data float
$bb = (float)($_POST['bb'] ?? '');  // Pastikan tipe data float
$hp = $_POST['hp'] ?? '';

// Menyiapkan query untuk memperbarui data pendaftaran
$sql = "UPDATE pendaftaran SET 
    nik = ?, 
    nama = ?, 
    jenkel = ?, 
    tLahir = ?, 
    tglLahir = ?, 
    alamat = ?, 
    kel = ?, 
    kec = ?, 
    kabkota = ?, 
    prov = ?, 
    penddk = ?, 
    tb = ?, 
    bb = ?, 
    hp = ?, 
    statusDaftar = 'proses' 
    WHERE idDaftar = ?";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssssssssssssssi", $nik, $nama, $jenkel, $tLahir, $tglLahir, $alamat, $kel, $kec, $kabkota, $prov, $penddk, $tb, $bb, $hp, $idLogin);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: formulir.php?status=success");
    } else {
        header("Location: formulir.php?status=error&message=Gagal memperbarui data.");
    }

    $stmt->close();
} else {
    header("Location: formulir.php?status=error&message=" . urlencode($conn->error));
}

$conn->close();
?>
