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

// Mengambil data pendaftaran berdasarkan idLogin
$idLogin = $_SESSION['idLogin'];
$sql = "SELECT * FROM pendaftaran WHERE idDaftar = ?";
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
        ?>
        <div class="card">
          <div class="card-body">
          <form id="registrationForm" class="row g-3 needs-validation" action="update_formulir.php" method="POST" novalidate>
              <input type="hidden" class="form-control" id="status" name="statusDaftar" required value="<?php echo htmlspecialchars($data['statusDaftar']); ?>" disabled readonly>
              <div class="col-md-4">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" required value="<?php echo htmlspecialchars($data['nik']); ?>" disabled>
                <div class="invalid-feedback">
                  Mohon isi NIK dengan benar.
                </div>
              </div>
              <div class="col-md-4">
                <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="namaLengkap" name="nama" required value="<?php echo htmlspecialchars($data['nama']); ?>" disabled readonly>
                <div class="invalid-feedback">
                  Mohon isi Nama Lengkap dengan benar.
                </div>
              </div>
              <div class="col-md-4">
                <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenisKelamin" name="jenkel" required disabled readonly>
                  <option selected value="<?php echo htmlspecialchars($data['jenkel']); ?>"><?php echo htmlspecialchars($data['jenkel']); ?></option>
                  <option value="Laki-Laki">Laki-Laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
                <div class="invalid-feedback">
                  Mohon pilih Jenis Kelamin.
                </div>
              </div>
              <div class="col-md-3">
                <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempatLahir" name="tLahir" required value="<?php echo htmlspecialchars($data['tLahir']); ?>" disabled readonly>
                <div class="invalid-feedback">
                  Mohon isi Tempat Lahir dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggalLahir" name="tglLahir" required value="<?php echo htmlspecialchars($data['tglLahir']); ?>" disabled readonly>
                <div class="invalid-feedback">
                  Mohon pilih Tanggal Lahir.
                </div>
              </div>
              <div class="col-md-6">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required value="<?php echo htmlspecialchars($data['alamat']); ?>" disabled readonly>
                <div class="invalid-feedback">
                  Mohon isi Alamat dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="kelurahan" class="form-label">Kelurahan</label>
                <input type="text" class="form-control" id="kelurahan" name="kel" required value="<?php echo htmlspecialchars($data['kel']); ?>" disabled readonly>
                <div class="invalid-feedback">
                  Mohon isi Kelurahan dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan" name="kec" required value="<?php echo htmlspecialchars($data['kec']); ?>" disabled readonly>
                <div class="invalid-feedback">
                  Mohon isi Kecamatan dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="kabupatenKota" class="form-label">Kab/Kota</label>
                <input type="text" class="form-control" id="kabupatenKota" name="kabkota" required value="<?php echo htmlspecialchars($data['kabkota']); ?>" disabled readonly>
                <div class="invalid-feedback">
                  Mohon isi Kabupaten/Kota dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" name="prov" required value="<?php echo htmlspecialchars($data['prov']); ?>" disabled readonly>
                <div class="invalid-feedback">
                  Mohon isi Provinsi dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="pend_terakhir" class="form-label">Pendidikan Terakhir</label>
                <select class="form-select" id="pend_terakhir" name="penddk" required disabled readonly>
                  <option selected value="<?php echo htmlspecialchars($data['penddk']); ?>"><?php echo htmlspecialchars($data['penddk']); ?></option>
                  <option value="SMA">SMA</option>
                  <option value="SMK">SMK</option>
                  <option value="MA">MA</option>
                  <option value="D3">D3</option>
                  <option value="D4">D4</option>
                  <option value="S1">S1</option>
                  <option value="S2">S2</option>
                </select>
                <div class="invalid-feedback">
                  Mohon pilih Pendidikan Terakhir.
                </div>
              </div>
              <div class="col-md-3">
                <label for="tinggi" class="form-label">Tinggi Badan</label>
                <div class="input-group has-validation">
                  <input type="number" class="form-control" id="tinggi" name="tb" aria-describedby="inputGroupPrepend" required value="<?php echo htmlspecialchars($data['tb']); ?>" disabled readonly>
                  <span class="input-group-text" id="inputGroupPrepend">Cm</span>
                  <div class="invalid-feedback">
                    Mohon isi Tinggi Badan dengan benar.
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <label for="berat" class="form-label">Berat Badan</label>
                <div class="input-group has-validation">
                  <input type="number" class="form-control" id="berat" name="bb" aria-describedby="inputGroupPrepend" required value="<?php echo htmlspecialchars($data['bb']); ?>" disabled readonly>
                  <span class="input-group-text" id="inputGroupPrepend">Kg</span>
                  <div class="invalid-feedback">
                    Mohon isi Berat Badan dengan benar.
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <label for="nomorHpWa" class="form-label">Nomor HP/ WA</label>
                <div class="input-group has-validation">
                  <span class="input-group-text" id="inputGroupPrepend">+62</span>
                  <input type="text" class="form-control" id="nomorHpWa" name="hp" aria-describedby="inputGroupPrepend" required value="<?php echo htmlspecialchars($data['hp']); ?>" disabled readonly>
                  <div class="invalid-feedback">
                    Mohon isi Nomor HP/ WA dengan benar.
                  </div>
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
