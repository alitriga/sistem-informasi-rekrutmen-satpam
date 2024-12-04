<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role yang sesuai
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'peserta') {
    header("Location: ../index.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Menghubungkan ke database
include '../config.php';

// Mendapatkan status dari query string
$status = $_GET['status'] ?? '';
$message = $_GET['message'] ?? '';

// Mengambil data berkas berdasarkan idLogin
$idLogin = $_SESSION['idLogin'];
$sql = "SELECT * FROM berkas WHERE idBerkas = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $idLogin);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
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
            <?php
            if ($status === 'success') {
                echo '<div class="alert alert-success">Data berhasil diperbarui!</div>';
            } elseif ($status === 'error') {
                echo '<div class="alert alert-danger">Gagal memperbarui data: ' . htmlspecialchars($message) . '</div>';
            }

            if ($data) {
                ?>
                <div class="card">
                    <div class="card-body">
                        <form id="registrationForm" class="row g-3 needs-validation" action="update_berkas.php" method="POST" enctype="multipart/form-data" novalidate>
                            <div class="col-md-4">
                                <label for="foto" class="form-label">Foto</label><br>
                                <img src="<?= htmlspecialchars($data['foto']); ?>" alt="Current Foto" class="img-fluid mb-2" width="150"><br>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <div class="invalid-feedback">
                                    Mohon isi Foto dengan benar.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="ktp" class="form-label">KTP</label><br>
                                <img src="<?= htmlspecialchars($data['ktp']); ?>" alt="Current KTP" class="img-fluid mb-2" width="150"><br>
                                <input type="file" class="form-control" id="ktp" name="ktp" accept="image/*">
                                <div class="invalid-feedback">
                                    Mohon isi KTP dengan benar.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="skck" class="form-label">SKCK</label><br>
                                <img src="<?= htmlspecialchars($data['skck']); ?>" alt="Current SKCK" class="img-fluid mb-2" width="150"><br>
                                <input type="file" class="form-control" id="skck" name="skck" accept="image/*">
                                <div class="invalid-feedback">
                                    Mohon isi SKCK dengan benar.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="sSehat" class="form-label">Surat Sehat</label><br>
                                <img src="<?= htmlspecialchars($data['sSehat']); ?>" alt="Current Surat Sehat" class="img-fluid mb-2" width="150"><br>
                                <input type="file" class="form-control" id="sSehat" name="sSehat" accept="image/*">
                                <div class="invalid-feedback">
                                    Mohon isi Surat Sehat dengan benar.
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="button" class="btn btn-secondary" id="editButton">
                                    <span class="material-icons-sharp">edit</span>
                                </button>
                                <button type="submit" class="btn btn-primary" id="saveButton" style="display:none;">
                                    <span class="material-icons-sharp">save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            } else {
                echo '<div class="alert alert-warning">Data tidak ditemukan.</div>';
            }
            ?>
            <div class="text-center mt-3">
                <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
        </div>
        <!-- End Registration Form -->
    </div>
    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Custom JavaScript -->
    <script>
    document.getElementById('editButton').addEventListener('click', function() {
        const form = document.getElementById('registrationForm');
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.readOnly = false;
            input.disabled = false;
        });
        document.getElementById('saveButton').style.display = 'inline-block';
    });
    </script>
</body>
</html>
