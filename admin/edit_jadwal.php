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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nmJadwal = $_POST['nmJadwal'];
    $tglAwal = $_POST['tglAwal'];
    $tglAkhir = $_POST['tglAkhir'];
    $kegiatan = $_POST['kegiatan'];
    $statusJadwal = $_POST['statusJadwal'];

    $sql = "UPDATE jadwal SET nmJadwal=?, tglAwal=?, tglAkhir=?, kegiatan=?, statusJadwal=? WHERE idJadwal=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssi", $nmJadwal, $tglAwal, $tglAkhir, $kegiatan, $statusJadwal, $idJadwal);
        if ($stmt->execute()) {
            header("Location: jadwal.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}

$sql = "SELECT * FROM jadwal WHERE idJadwal=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idJadwal);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Jadwal</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nmJadwal">Nama:</label>
                <input type="text" class="form-control" id="nmJadwal" name="nmJadwal" value="<?= $data['nmJadwal'] ?>" required>
            </div>
            <div class="form-group">
                <label for="tglAwal">Tanggal Awal:</label>
                <input type="date" class="form-control" id="tglAwal" name="tglAwal" value="<?= $data['tglAwal'] ?>" required>
            </div>
            <div class="form-group">
                <label for="tglAkhir">Tanggal Akhir:</label>
                <input type="date" class="form-control" id="tglAkhir" name="tglAkhir" value="<?= $data['tglAkhir'] ?>" required>
            </div>
            <div class="form-group">
                <label for="kegiatan">Kegiatan:</label>
                <input type="text" class="form-control" id="kegiatan" name="kegiatan" value="<?= $data['kegiatan'] ?>" required>
            </div>
            <div class="form-group">
                <label for="statusJadwal">Status:</label>
                <input type="text" class="form-control" id="statusJadwal" name="statusJadwal" value="<?= $data['statusJadwal'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="jadwal.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
