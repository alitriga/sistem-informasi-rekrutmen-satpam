<?php
session_start();
include '../config.php';

// Pastikan hanya peserta yang dapat mengakses halaman ini
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'peserta') {
    http_response_code(403);
    exit();
}

$idLogin = $_SESSION['idLogin'];

// Ambil data pembayaran yang terkait dengan pengguna yang sedang login
$sql = "SELECT * FROM bayar WHERE idBayar = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $idLogin);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
} else {
    http_response_code(500);
}

$sql = "SELECT * FROM paket WHERE statusPaket = 'aktif' ";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    $paket = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h1 class="text-center">Paket dan Pembayaran</h1>
        <div class="card">
            <div class="card-body">
                <form id="registrationForm" class="row g-3 needs-validation" novalidate method="POST" action="update_bayar.php" enctype="multipart/form-data">
                    <div class="col-md-4">
                        <label for="idPaket" class="form-label">Pilihan Paket Biaya</label>
                        <select class="form-select" id="idPaket" name="idPaket" required>
                        <option selected disabled value="">Pilih Paket</option>
                            <?php foreach($paket as $pk): ?>
                                <option value="<?= htmlspecialchars($pk['idPaket']) ?>" data-harga="<?= htmlspecialchars($pk['harga']) ?>">
                                    <?= htmlspecialchars($pk['nmPaket']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            Mohon pilih Paket Biaya.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="harga" class="form-label">Total Biaya</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            <input type="text" class="form-control" id="harga" name="harga" required value="" disabled readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="metode" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="metode" name="metode" required>
                            <option selected disabled value="">Pilih Metode</option>
                            <option value="Transfer">Transfer</option>
                            <option value="Cash">Cash</option>
                        </select>
                        <div class="invalid-feedback">
                            Mohon pilih Metode Pembayaran.
                        </div>
                    </div>
                    <div class="col-md-3 payment-info">
                        <label for="tglBayar" class="form-label">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" id="tglBayar" name="tglBayar" required>
                        <div class="invalid-feedback">
                            Mohon isi Tanggal Pembayaran dengan benar.
                        </div>
                    </div>
                    <div class="col-md-3 payment-info">
                        <label for="nm" class="form-label">Nama Pengirim</label>
                        <input type="text" class="form-control" id="nm" name="nm" required>
                        <div class="invalid-feedback">
                            Mohon isi Nama Pengirim dengan benar.
                        </div>
                    </div>
                    <div class="col-md-3 payment-info">
                        <label for="bank" class="form-label">Nama Bank Pengiriman</label>
                        <select class="form-select" id="bank" name="bank" required>
                            <option selected disabled value="">Pilih Bank</option>
                            <option>Bank A</option>
                            <option>Bank B</option>
                            <!-- Tambahkan lebih banyak opsi bank di sini -->
                        </select>
                        <div class="invalid-feedback">
                            Mohon pilih Bank Pengiriman.
                        </div>
                    </div>
                    <div class="col-md-3 payment-info">
                        <label for="upload" class="form-label">Upload Bukti Pembayaran</label>
                        <input type="file" class="form-control" id="upload" name="upload" required>
                        <div class="invalid-feedback">
                            Mohon isi Upload Bukti Pembayaran dengan benar.
                        </div>
                    </div>
                    <div class="col-md-9">
                        <p>Pembayaran Transfer</p>
                        <hr>
                        <p>Bank Nagari : 21000210553593</p>
                        <p>Atas Nama    : Wira Nur Triatma</p>
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="submit" class="btn btn-secondary" id="saveButton">
                            <span class="material-icons-sharp">save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </div>
    <!-- End Registration Form -->
</div>
<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('idPaket').addEventListener('change', function() {
        // Get the selected option
        const selectedOption = this.options[this.selectedIndex];
        // Get the price from the data attribute
        const harga = selectedOption.getAttribute('data-harga');
        // Update the Total Biaya field
        document.getElementById('harga').value = `Rp. ${harga}`;
    });
    document.getElementById('metode').addEventListener('change', function() {
        const metodeValue = this.value;
        const paymentInfoElements = document.querySelectorAll('.payment-info');
        const tglBayar = document.getElementById('tgl_bayar');
        const pengirim = document.getElementById('pengirim');
        const bank = document.getElementById('bank');
        const bukti = document.getElementById('bukti');

        if (metodeValue === 'Cash') {
            paymentInfoElements.forEach(element => {
                element.style.display = 'none';
            });
            tglBayar.value = '';
            tglBayar.required = false;
            pengirim.value = '';
            pengirim.required = false;
            bank.value = '';
            bank.required = false;
            bukti.value = '';
            bukti.required = false;
        } else {
            paymentInfoElements.forEach(element => {
                element.style.display = 'block';
            });
            tglBayar.required = true;
            pengirim.required = true;
            bank.required = true;
            bukti.required = true;
        }
    });

    // Initial setup to hide transfer-specific fields
    document.getElementById('metode').dispatchEvent(new Event('change'));
</script>

</body>
</html>
