<?php
session_start();
include '../config.php';

if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'peserta') {
    http_response_code(403);
    exit();
}

$idLogin = $_SESSION['idLogin'];
$sql = "SELECT * FROM berkas WHERE idBerkas = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $idLogin);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    http_response_code(500);
}

$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <title>PT. Nutrido Nusa Kampita</title>
    <link href="../assets/img/13.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-auto">
                <p>
                    <img src="../assets/img/13.png" alt="" class="img-fluid" width="150">
                </p>
            </div>
            <div class="col-auto">
                <h1 class="text-danger">PT. Nutrido Nusa Kampita</h1>
                <h3 class="text-primary">NUTRIDO SECURITY GUARD SERVICE & TRAINING</h3>
                <h5>Jalan Bandar Purus No.19 Padang (samping Pasca Sarjana UNES Padang)</h5>
            </div>
            <hr class="border border-dark border-3 opacity-75">
            <hr class="border border-dark">
        </div>
        <!-- Registration Form -->
        <div class="row">
            <h1 class="text-center">Formulir Pendaftaran</h1>
            <div class="card">
                <div class="card-body">
                    <!-- Button Edit -->
                    <div class="text-end mb-3">
                        <a href="edit_berkas.php" class="btn btn-warning">Upload Berkas</a>
                    </div>
                    <!-- Tabel untuk menampilkan data berkas -->
                    <table class="table table-bordered" id="berkasTable">
                        <thead>
                            <tr>
                                <th>ID Berkas</th>
                                <th>ID Daftar</th>
                                <th>Foto</th>
                                <th>KTP</th>
                                <th>SKCK</th>
                                <th>S. Sehat</th>
                                <th>Status Berkas</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($data as $dt) : ?>
                        <tr>
                            <td> <?= $dt['idBerkas']; ?> </td>
                            <td> <?= $dt['idDaftar']; ?> </td>
                            <td> <img src="<?= $dt['foto']; ?>" alt="" class="img-fluid" width="150"> </td>
                            <td> <img src="<?= $dt['ktp']; ?>" alt="" class="img-fluid" width="150"> </td>
                            <td> <img src="<?= $dt['skck']; ?>" alt="" class="img-fluid" width="150"> </td>
                            <td> <img src="<?= $dt['sSehat']; ?>" alt="" class="img-fluid" width="150"> </td>
                            <td> <?= $dt['statusBerkas']; ?> </td>
                        </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
        <!-- End Registration Form -->
    </div>
    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

