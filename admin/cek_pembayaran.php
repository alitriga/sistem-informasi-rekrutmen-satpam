<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Menghubungkan ke database
include '../config.php';

// Mendapatkan idDaftar dari parameter URL
$idDaftar = isset($_GET['idDaftar']) ? intval($_GET['idDaftar']) : 0;

if ($idDaftar <= 0) {
    die("Invalid ID");
}

// Query untuk mengambil data pembayaran berdasarkan idDaftar
$sql = "SELECT * FROM bayar 
        JOIN pendaftaran ON bayar.idBayar = pendaftaran.idDaftar 
        JOIN paket ON bayar.idPaket = paket.idPaket
        WHERE bayar.idBayar = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $idDaftar);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc(); // Fetch single row as associative array
    
    // Periksa apakah data ditemukan
    if (!$data) {
        die("Data tidak ditemukan untuk ID yang diberikan.");
    }
    
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran - PT. Nutrido Nusa Kampita</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../asset/images/13.png" rel="icon">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <main>
            <h1 class="mb-4">Detail Pembayaran</h1>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Metode Pembayaran</th>
                                <td colspan="3"><?= htmlspecialchars($data['metode']); ?></td>
                            </tr>
                            <tr>
                                <th>Nominal</th>
                                <td colspan="3">Rp<?= number_format($data['harga'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Status Pembayaran</th>
                                <td colspan="3"><?= htmlspecialchars($data['statusBayar']); ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Pembayaran</th>
                                <td colspan="3">
                                    <?= ($data['tglBayar']); ?>
                                    <button type="button" class="btn btn-sm btn-warning ml-2" data-toggle="modal" data-target="#editStatusModal">
                                        Edit
                                    </button>
                                </td>

                            </tr>
                            <tr>
                                <th>Bukti Pembayaran</th>
                                <td><?= ($data['nm']); ?></td>
                                <td><?= ($data['bank']); ?></td>
                                <td><img src="<?= $data['upload']; ?>" alt="" class="img-fluid" width="150"></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="peserta_detail.php?idDaftar=<?= urlencode($idDaftar); ?>" class="btn btn-primary">Kembali</a>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="update_tglBayar.php" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStatusModalLabel">Edit Tanggal Bayar</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="idDaftar" value="<?= htmlspecialchars($data['idDaftar']); ?>">
                                    <div class="form-group">
                                        <label for="tglBayar">Tanggal Pembayaran</label>
                                        <input type="date" class="form-control" id="tglBayar" name="tglBayar" value="<?= $data['tglBayar'] ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
