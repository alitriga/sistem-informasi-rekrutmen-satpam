<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role yang sesuai
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'peserta') {
    header("Location: ../index.php"); // Redirect ke halaman login jika belum login
    exit();
}
// Menghubungkan ke database
include '../config.php';
// Mengambil data pendaftaran berdasarkan idLogin
$idLogin = $_SESSION['idLogin'];
$sql = "SELECT 
diklat.idDiklat, diklat.idDaftar, diklat.idJadwal,
pendaftaran.nik, pendaftaran.nama, pendaftaran.tglDaftar,
jadwal.nmJadwal,jadwal.tglAwal,jadwal.tglAkhir,
paket.nmPaket, paket.harga,
bayar.metode, bayar.tglBayar
FROM diklat 
JOIN pendaftaran ON pendaftaran.idDaftar = diklat.idDaftar
JOIN bayar ON bayar.idBayar = diklat.idDaftar
JOIN paket ON paket.idPaket = bayar.idPaket
JOIN jadwal ON jadwal.idJadwal = diklat.idJadwal
WHERE idDiklat = ?";
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
            <img src="../assets/img/13.png" alt="" class="img-fluid" width="100">
          </p>  
        </div>
        <div class="col-auto">
          <h3 class="text-danger">PT. Nutrido Nusa Kampita</h3>
          <h6 class="text-primary">NUTRIDO SECURITY GUARD SERVICE & TRAINING</h6>
          <h7>Jalan Bandar Purus No.19 Padang (samping Pasca Sarjana UNES Padang)</h7>
        </div>
        <div class="col text-end">
            <h2>JADWAL KEGIATAN</h2>
            <h4 class="text-secondary">Schedule of Activities</h4>
        </div>
        <hr class="border border-dark border-3 opacity-75">
        <hr class="border border-dark">
      </div>  
      <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h5 class="text text-center"><?= htmlspecialchars($data['nmJadwal']); ?></h5>
                    </div>
                    <div class="row text-center">
                        <h5>Dilaksanakan pada tanggal</h5><br><br>
                        <h6><?= htmlspecialchars($data['tglAwal']).' s/d '.htmlspecialchars($data['tglAkhir']);?></h6>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-secondary" id="editButton">
                                <span class="material-icons-sharp">picture_as_pdf</span>
                            </button>
                            <p>Kegiatan Diklat</p>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col text-end">
                            <p>Contact Person : 0751 4670 014</p>
                            <p>0878 9599 0005</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
            </div>
      </div>  
    </div>
    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
  </body>
</html>
