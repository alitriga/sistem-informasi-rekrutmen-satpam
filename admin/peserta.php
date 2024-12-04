<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// Menghubungkan ke database
include '../config.php';

// Query untuk mengambil data peserta
$sql = "SELECT pendaftaran.idDaftar, pendaftaran.nik, pendaftaran.nama, pendaftaran.statusDaftar, berkas.statusBerkas, bayar.statusBayar
        FROM pendaftaran 
        JOIN berkas ON berkas.idDaftar = pendaftaran.idDaftar 
        JOIN bayar ON bayar.idBayar = pendaftaran.idDaftar";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="../asset/style.css">
    <title>PT. Nutrido Nusa Kampita</title>
    <link href="../asset/images/13.png" rel="icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="../asset/images/13.png" alt="PT. Nutrido Nusa Kampita">
                    <h2><span class="danger">PT.Nutrido</span> NusaKampita</h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="index.php">
                    <span class="material-icons-sharp">dashboard</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="user.php">
                    <span class="material-icons-sharp">person_outline</span>
                    <h3>Users</h3>
                </a>
                <a href="peserta.php" class="active">
                    <span class="material-icons-sharp">recent_actors</span>
                    <h3>Peserta List</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">insights</span>
                    <h3>Analytics</h3>
                </a>
                <a href="jadwal.php">
                    <span class="material-icons-sharp">date_range</span>
                    <h3>Jadwal Diklat</h3>
                </a>
                <a href="karyawan.php">
                    <span class="material-icons-sharp">badge</span>
                    <h3>Data Karyawan</h3>
                </a>
                <a href="paket.php">
                    <span class="material-icons-sharp">inventory</span>
                    <h3>Data Paket</h3>
                </a>
                <a href="laporan.php">
                    <span class="material-icons-sharp">report_gmailerrorred</span>
                    <h3>Laporan</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">settings</span>
                    <h3>Settings</h3>
                </a>
                <a href="../logout.php">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Data Peserta</h1>
            <div class="search-box">
                <input type="text" id="search-input" placeholder="Search...">
            </div>
            <div class="recent-orders">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Formulir</th>
                            <th>Berkas</th>
                            <th>Pembayaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; ?>
                    <?php foreach($data as $dt): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($dt['nik']); ?></td>
                            <td><?= htmlspecialchars($dt['nama']); ?></td>
                            <td class="<?= htmlspecialchars($dt['statusDaftar']); ?>"><?= htmlspecialchars($dt['statusDaftar']); ?></td>
                            <td class="<?= htmlspecialchars($dt['statusBerkas']); ?>"><?= htmlspecialchars($dt['statusBerkas']); ?></td>
                            <td class="<?= htmlspecialchars($dt['statusBayar']); ?>"><?= htmlspecialchars($dt['statusBayar']); ?></td>
                            <td>
                                <a href="peserta_detail.php?idDaftar=<?= urlencode($dt['idDaftar']); ?>">
                                    <span class="material-icons-sharp">info</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Admin</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="../asset/images/person-circle.svg" alt="Profile">
                    </div>
                </div>
            </div>
            <div class="user-profile">
                <div class="logo">
                    <img src="../asset/images/person-circle.svg" alt="Profile">
                    <h2>PT. Nutrido Nusa Kampita</h2>
                    <p>Admin</p>
                </div>
            </div>
        </div>
    </div>
    <script src="../asset/index.js"></script>
    <script src="../asset/search.js"></script>
</body>
</html>
