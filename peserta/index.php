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
$sql = "SELECT * FROM pendaftaran 
JOIN berkas ON berkas.idDaftar = pendaftaran.idDaftar 
JOIN bayar ON bayar.idBayar = pendaftaran.idDaftar 
WHERE pendaftaran.idDaftar = ?";
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
// Menentukan status untuk jadwal
$scheduleStatus = ($data['statusBayar'] === 'lulus') ? 'dibuka' : 'belum';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../asset/images/13.png" rel="icon">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
  <title>PT. Nutrido Nusa Kampita</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .material-icons-sharp {
      font-size: 3rem; /* Adjust the size as needed */
    }
    .border-primary {
      border: 2px solid blue;
    }
    .border-success {
      border: 2px solid green;
    }
    .border-warning {
      border: 2px solid orange;
    }
    .border-danger {
      border: 2px solid red;
    }
    .border-secondary {
      border: 2px solid gray;
    }
    .disabled {
      pointer-events: none;
      opacity: 0.6;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">PT. Nutrido Nusa Kampita</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link disabled" aria-disabled="true">Disabled</a>
            </li>
          </ul>
          <!-- Back link -->
          <form class="d-flex" role="search">
            <a href="../logout.php" class="btn btn-warning">Logout</a>
          </form>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <br>
    <h1> <?php echo "Selamat datang, " . $_SESSION['username'] . " di Dashboard Peserta!";?> </h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title text-center" data-status="<?php echo htmlspecialchars($data['statusDaftar']); ?>"><a href="formulir.php?idLogin=<?= $_SESSION['idLogin']; ?>" id="link-app-registration"><span class="material-icons-sharp">app_registration</span></a></h6>
            <p class="card-text text-center">Formulir</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title text-center" data-status="<?php echo htmlspecialchars($data['statusBerkas']); ?>"><a href="berkas.php?idLogin=<?= $_SESSION['idLogin']; ?>" id="link-folder"><span class="material-icons-sharp">folder</span></a></h6>
            <p class="card-text text-center">Berkas</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title text-center" data-status="<?php echo htmlspecialchars($data['statusBayar']); ?>"><a href="bayar.php" id="link-paid"><span class="material-icons-sharp">paid</span></a></h6>
            <p class="card-text text-center">Pembayaran</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title text-center" data-status="belum"><a href="kartu.php" id="link-card-membership"><span class="material-icons-sharp">card_membership</span></a></h6>
            <p class="card-text text-center">Kartu Peserta</p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title text-center" data-status="<?php echo htmlspecialchars($scheduleStatus); ?>"><a href="jadwal.php" id="link-schedule"><span class="material-icons-sharp">schedule</span></a></h6>
            <p class="card-text text-center">Jadwal Diklat</p>
          </div>
        </div>
      </div>
    </div>
  </div>
    
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      // Mengubah warna berdasarkan status
      $('h6.card-title').each(function() {
        var status = $(this).data('status'); // Ambil status dari atribut data
        var icon = $(this).find('span.material-icons-sharp').text().trim();
        
        // Terapkan warna dan border berdasarkan status
        var card = $(this).closest('.card');
        var link = $(this).find('a');
        
        switch(status) {
          case 'dibuka':
            $(this).find('span.material-icons-sharp').addClass('text-primary');
            card.addClass('border-primary');
            break;
          case 'lulus':
            $(this).find('span.material-icons-sharp').addClass('text-success');
            card.addClass('border-success');
            break;
          case 'proses':
            $(this).find('span.material-icons-sharp').addClass('text-warning');
            card.addClass('border-warning');
            break;
          case 'gagal':
            $(this).find('span.material-icons-sharp').addClass('text-danger');
            card.addClass('border-danger');
            break;
          case 'belum':
            $(this).find('span.material-icons-sharp').addClass('text-secondary');
            card.addClass('border-secondary');
            // Nonaktifkan link jika status belum diproses
            link.removeAttr('href').addClass('disabled');
            break;
          default:
            break;
        }
      });
    });
  </script>
</body>
</html>
