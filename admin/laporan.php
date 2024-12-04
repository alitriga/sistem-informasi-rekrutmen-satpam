<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'direktur') {
    header("Location: ../index.php"); // Redirect ke halaman login jika belum login
    exit();
}
// Menghubungkan ke database
include '../config.php';

// Query untuk mengambil data peserta
$sql = "SELECT 
diklat.idDiklat, diklat.idDaftar, diklat.idJadwal,
pendaftaran.nik, pendaftaran.nama, pendaftaran.tglDaftar,
jadwal.nmJadwal,
paket.nmPaket, paket.harga,
bayar.metode, bayar.tglBayar
FROM diklat 
JOIN pendaftaran ON pendaftaran.idDaftar = diklat.idDaftar
JOIN bayar ON bayar.idBayar = diklat.idDaftar
JOIN paket ON paket.idPaket = bayar.idPaket
JOIN jadwal ON jadwal.idJadwal = diklat.idJadwal";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array
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
  <link href="../asset/images/13.png" rel="icon">
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
  <div class="row">
    <div class="col">
      <h1 class="text-center mt-5">Laporan Data Pembayaran</h1>
      <div class="d-flex justify-content-between mb-3">
        <!-- Input pencarian -->
        <input type="text" id="search" class="form-control me-2" placeholder="Search...">
        <!-- Filter bulan -->
        <select id="filter-bulan" class="form-select me-2">
          <option value="">Pilih Bulan</option>
          <option value="01">Januari</option>
          <option value="02">Februari</option>
          <option value="03">Maret</option>
          <option value="04">April</option>
          <option value="05">Mei</option>
          <option value="06">Juni</option>
          <option value="07">Juli</option>
          <option value="08">Agustus</option>
          <option value="09">September</option>
          <option value="10">Oktober</option>
          <option value="11">November</option>
          <option value="12">Desember</option>
        </select>
        <!-- Filter tahun -->
        <select id="filter-tahun" class="form-select">
          <option value="">Pilih Tahun</option>
          <option value="2021">2021</option>
          <option value="2022">2022</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
        </select>
      </div>
      <div class="card">
        <div class="card-body">
          <table class="table table-bordered" id="data-table">
            <thead>
              <tr>
                <th>No.</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Gel. Diklat</th>
                <th>Paket</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal Pendaftaran</th>
                <th>Tanggal Pembayaran</th>
                <th>Total Biaya</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php foreach ($data as $dt) : ?>
              <tr>
                <td> <?= $no++; ?> </td>
                <td> <?= $dt['nik']; ?> </td>
                <td> <?= $dt['nama']; ?> </td>
                <td> <?= $dt['nmJadwal']; ?> </td>
                <td> <?= $dt['nmPaket']; ?> </td>
                <td> <?= $dt['metode']; ?> </td>
                <td> <?= $dt['tglDaftar']; ?> </td>
                <td> <?= $dt['tglBayar']; ?> </td>
                <td> <?= number_format($dt['harga'], 0, ',', '.'); ?> </td>
              </tr>
              <?php endforeach ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="8" class="text-end">Jumlah Total Biaya:</th>
                <th id="total-biaya">0</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div class="text-center mt-3">
        <!-- Tombol kembali -->
        <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
      </div>
    </div>
  </div>
</div>
<!-- Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
  function filterData() {
    var search = $('#search').val().toLowerCase();
    var filterBulan = $('#filter-bulan').val();
    var filterTahun = $('#filter-tahun').val();
    
    $('#data-table tbody tr').filter(function() {
      var text = $(this).text().toLowerCase();
      var tanggal = $(this).find('td:eq(6)').text(); // Menggunakan kolom tanggal pendaftaran
      var bulan = tanggal.substring(5, 7);
      var tahun = tanggal.substring(0, 4);

      $(this).toggle(
        text.includes(search) &&
        (filterBulan === "" || filterBulan === bulan) &&
        (filterTahun === "" || filterTahun === tahun)
      );
    });

    // Update total biaya setelah filtering
    var totalBiaya = 0;
    $('#data-table tbody tr:visible').each(function() {
      var biaya = $(this).find('td:eq(8)').text().replace(/[^0-9]/g, ''); // Hapus karakter non-digit
      totalBiaya += parseInt(biaya, 10);
    });
    $('#total-biaya').text(totalBiaya.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })); // Format angka dengan format IDR
  }

  // Event listener untuk input pencarian
  $('#search').on('keyup', function() {
    filterData();
  });

  // Event listener untuk filter bulan
  $('#filter-bulan').on('change', function() {
    filterData();
  });

  // Event listener untuk filter tahun
  $('#filter-tahun').on('change', function() {
    filterData();
  });

  // Inisialisasi total biaya saat halaman dimuat
  filterData();
});
</script>

</body>
</html>
