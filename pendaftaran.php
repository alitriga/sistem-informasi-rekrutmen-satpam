<?php
// Database connection
include 'config.php';

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $namaLengkap = $_POST['namaLengkap'];
    $jenisKelamin = $_POST['jenisKelamin'];
    $tempatLahir = $_POST['tempatLahir'];
    $tanggalLahir = $_POST['tanggalLahir'];
    $alamat = $_POST['alamat'];
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $kabupatenKota = $_POST['kabupatenKota'];
    $provinsi = $_POST['provinsi'];
    $pend_terakhir = $_POST['pend_terakhir'];
    $tinggi = $_POST['tinggi'];
    $berat = $_POST['berat'];
    $nomorHpWa = $_POST['nomorHpWa'];

    // Insert data into pendaftaran table
    $sql = "INSERT INTO pendaftaran (nik, nama, jenkel, tLahir, tglLahir, alamat, kel, kec, kabkota, prov, hp, tb, bb, penddk, tglDaftar, statusDaftar)
            VALUES ('$nik', '$namaLengkap', '$jenisKelamin', '$tempatLahir', '$tanggalLahir', '$alamat', '$kelurahan', '$kecamatan', '$kabupatenKota', '$provinsi', '$nomorHpWa', '$tinggi', '$berat', '$pend_terakhir', NOW(), 'proses')";

    if ($conn->query($sql) === TRUE) {
        // Get the id of the newly inserted record
        $idDaftar = $conn->insert_id;

        // Redirect to register.php with idDaftar
        header("Location: register.php?idDaftar=$idDaftar");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PT. Nutrido Nusa Kampita</title>
    <link href="assets/img/13.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-auto">
          <p>
            <img src="assets/img/13.png" alt="" class="img-fluid" width="150">
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
          <p>Biaya Paket :</p>
          <?php foreach($paket as $pk): ?>
              <p value="<?= htmlspecialchars($pk['idPaket']) ?>" >
                  *<?= htmlspecialchars($pk['nmPaket']) ?>, Harga = <?= 'Rp.'.number_format($pk['harga']) ?>
              </p>
          <?php endforeach; ?>
          <hr>
          <form id="registrationForm" class="row g-3 needs-validation" method="POST" action="" novalidate>
              <div class="col-md-4">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" required>
                <div class="invalid-feedback">
                  Mohon isi NIK dengan benar.
                </div>
              </div>
              <div class="col-md-4">
                <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="namaLengkap" name="namaLengkap" required>
                <div class="invalid-feedback">
                  Mohon isi Nama Lengkap dengan benar.
                </div>
              </div>
              <div class="col-md-4">
                <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenisKelamin" name="jenisKelamin" required>
                  <option selected disabled value="">Pilih...</option>
                  <option>Laki-Laki</option>
                  <option>Perempuan</option>
                </select>
                <div class="invalid-feedback">
                  Mohon pilih Jenis Kelamin.
                </div>
              </div>
              <div class="col-md-3">
                <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" id="tempatLahir" name="tempatLahir" required>
                <div class="invalid-feedback">
                  Mohon isi Tempat Lahir dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir" required>
                <div class="invalid-feedback">
                  Mohon pilih Tanggal Lahir.
                </div>
              </div>
              <div class="col-md-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <select class="form-select" id="provinsi" name="provinsi" required>
                  <option selected disabled value="">Pilih...</option>
                  
                </select>
                <div class="invalid-feedback">
                  Mohon isi Provinsi dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="kabupatenKota" class="form-label">Kab/Kota</label>
                <select class="form-select" id="kabupatenKota" name="kabupatenKota" required>
                  <option selected disabled value="">Pilih...</option>
                  
                </select>
                <div class="invalid-feedback">
                  Mohon isi Kabupaten/Kota dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <select class="form-select" id="kecamatan" name="kecamatan" required>
                  <option selected disabled value="">Pilih...</option>
                  
                </select>
                <div class="invalid-feedback">
                  Mohon isi Kecamatan dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="kelurahan" class="form-label">Kelurahan</label>
                <select class="form-select" id="kelurahan" name="kelurahan" required>
                  <option selected disabled value="">Pilih...</option>
                  
                </select>
                <div class="invalid-feedback">
                  Mohon isi Kelurahan dengan benar.
                </div>
              </div>
              <div class="col-md-6">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
                <div class="invalid-feedback">
                  Mohon isi Alamat dengan benar.
                </div>
              </div>
              <div class="col-md-3">
                <label for="pend_terakhir" class="form-label">Pendidikan Terakhir</label>
                <select class="form-select" id="pend_terakhir" name="pend_terakhir" required>
                  <option selected disabled value="">Pilih...</option>
                  <option>SMA</option>
                  <option>SMK</option>
                  <option>MA</option>
                  <option>D3</option>
                  <option>D4</option>
                  <option>S1</option>
                  <option>S2</option>
                </select>
                <div class="invalid-feedback">
                  Mohon pilih Pendidikan Terakhir.
                </div>
              </div>
              <div class="col-md-3">
                <label for="tinggi" class="form-label">Tinggi Badan</label>
                <div class="input-group has-validation">
                  <input type="number" class="form-control" id="tinggi" name="tinggi" aria-describedby="inputGroupPrepend" required>
                  <span class="input-group-text" id="inputGroupPrepend">Cm</span>
                  <div class="invalid-feedback">
                    Mohon isi Tinggi Badan dengan benar.
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <label for="berat" class="form-label">Berat Badan</label>
                <div class="input-group has-validation">
                  <input type="number" class="form-control" id="berat" name="berat" aria-describedby="inputGroupPrepend" required>
                  <span class="input-group-text" id="inputGroupPrepend">Kg</span>
                  <div class="invalid-feedback">
                    Mohon isi Berat Badan dengan benar.
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <label for="nomorHpWa" class="form-label">Nomor HP/WA</label>
                <input type="text" class="form-control" id="nomorHpWa" name="nomorHpWa" required>
                <div class="invalid-feedback">
                  Mohon isi Nomor HP/WA dengan benar.
                </div>
              </div>
              <div class="col-12 text-end">
                <button class="btn btn-primary" type="submit">Submit form</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="text-center mt-3">
          <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
      </div>
      <hr class="border border-dark border-3 opacity-75">
      <hr class="border border-dark">
      <footer>
        <div class="row">
          <div class="col-md-4">
            <p><strong>PT. Nutrido Nusa Kampita</strong></p>
            <p>Jl. Bandar Purus No.19 Padang</p>
          </div>
          <div class="col-md-4">
            <p><strong>Kontak Kami:</strong></p>
            <p>Telepon: (0751) 123-456</p>
            <p>Email: info@nutrido.com</p>
          </div>
          <div class="col-md-4">
            <p><strong>Media Sosial:</strong></p>
            <p>
              <a href="#">Facebook</a> |
              <a href="#">Twitter</a> |
              <a href="#">Instagram</a>
            </p>
          </div>
        </div>
      </footer>
    </div>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
          .forEach(function (form) {
            form.addEventListener('submit', function (event) {
              if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
              }
              form.classList.add('was-validated')
            }, false)
          })
      })()
    </script>
    <script>
    fetch('https://kanglerian.github.io/api-wilayah-indonesia/api/provinces.json')
        .then(response => response.json())
        .then(provinces => {
            var data = provinces;
            var tampung = '<option selected disabled value="">Pilih...</option>';
            data.forEach(element => {
                tampung += `<option data-reg="${element.id}" value="${element.name}">${element.name}</option>`;
            });
            document.getElementById('provinsi').innerHTML = tampung;
        });
    </script>
    <script>
    const selectProvinsi = document.getElementById('provinsi');
    selectProvinsi.addEventListener('change', (e) => {
        var provinsi = e.target.options[e.target.selectedIndex].dataset.reg;
        fetch(`https://kanglerian.github.io/api-wilayah-indonesia/api/regencies/${provinsi}.json`)
            .then(response => response.json())
            .then(regencies => {
                var data = regencies;
                var tampung = '<option selected disabled value="">Pilih...</option>';
                data.forEach(element => {
                    tampung += `<option data-dist="${element.id}" value="${element.name}">${element.name}</option>`;
                });
                document.getElementById('kabupatenKota').innerHTML = tampung;
            });
    });
    const selectkabupatenKota = document.getElementById('kabupatenKota');
    selectkabupatenKota.addEventListener('change', (e) => {
        var kabupatenKota = e.target.options[e.target.selectedIndex].dataset.dist;
        fetch(`https://kanglerian.github.io/api-wilayah-indonesia/api/districts/${kabupatenKota}.json`)
            .then(response => response.json())
            .then(districts => {
                var data = districts;
                var tampung = '<option selected disabled value="">Pilih...</option>';
                data.forEach(element => {
                    tampung += `<option data-vill="${element.id}" value="${element.name}">${element.name}</option>`;
                });
                document.getElementById('kecamatan').innerHTML = tampung;
            });
    });
    const selectKecamatan = document.getElementById('kecamatan');
    selectKecamatan.addEventListener('change', (e) => {
        var kecamatan = e.target.options[e.target.selectedIndex].dataset.vill;
        fetch(`https://kanglerian.github.io/api-wilayah-indonesia/api/villages/${kecamatan}.json`)
        .then(response => response.json())
        .then(villages => {
            var data = villages;
            var tampung = '<option selected disabled value="">Pilih...</option>';
            data.forEach(element => {
                tampung += `<option value="${element.name}">${element.name}</option>`;
            });
            document.getElementById('kelurahan').innerHTML = tampung;
        });
    });
    </script>
  </body>
</html>
