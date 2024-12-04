<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Menghubungkan ke database
include '../config.php';

$sql = "SELECT * FROM paket";
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

// // Output data in JSON format
// header('Content-Type: application/json');
// echo json_encode($data);
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .search-box {
            display: flex;
            align-items: center;
            gap: 10px; /* Jarak antara input dan tombol */
        }

        #search-input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1; /* Menggunakan ruang yang tersedia */
        }

        #jadwal-btn {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #007bff; /* Warna latar belakang biru */
            color: white;
            cursor: pointer;
        }

        #jadwal-btn:hover {
            background-color: #0056b3; /* Warna latar belakang biru gelap saat hover */
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar Section -->
        <aside>
            <div class="toggle">
                <div class="logo">
                    <img src="../asset/images/13.png">
                    <h2><span class="danger">PT.Nutrido</span> NusaKampita</h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-icons-sharp">
                        close
                    </span>
                </div>
            </div>
            <div class="sidebar">
                <a href="index.php">
                    <span class="material-icons-sharp">
                        dashboard
                    </span>
                    <h3>Dashboard</h3>
                </a>
                <a href="user.php">
                    <span class="material-icons-sharp">
                        person_outline
                    </span>
                    <h3>Users</h3>
                </a>
                <a href="peserta.php">
                    <span class="material-icons-sharp">
                        recent_actors
                    </span>
                    <h3>Peserta List</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">
                        insights
                    </span>
                    <h3>Analytics</h3>
                </a>
                <a href="jadwal.php">
                    <span class="material-icons-sharp">
                        date_range
                    </span>
                    <h3>Jadwal Diklat</h3>
                </a>
                <a href="karyawan.php">
                    <span class="material-icons-sharp">
                        badge
                    </span>
                    <h3>Data Karwayan</h3>
                </a>
                <a href="paket.php" class="active">
                    <span class="material-icons-sharp">
                        inventory
                    </span>
                    <h3>Data Paket</h3>
                </a>
                <a href="laporan.php">
                    <span class="material-icons-sharp">
                        report_gmailerrorred
                    </span>
                    <h3>Laporan</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">
                        settings
                    </span>
                    <h3>Settings</h3>
                </a>
                <a href="../logout.php">
                    <span class="material-icons-sharp">
                        logout
                    </span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <!-- End of Sidebar Section -->

        <!-- Main Content -->
        <main>
            <h1>Data Paket</h1>
            <div class="search-box">
                <input type="text" id="search-input" placeholder="Search...">
                <a href="create_paket.php" class="btn btn-primary">Tambah</a>
            </div>
            <div class="recent-orders">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $no=1;?>
                    <?php foreach($data as $dt) : ?>
                    <tr>
                        <td> <?= $no++; ?> </td>
                        <td> <?= $dt['nmPaket']; ?> </td>
                        <td>Rp. <?= number_format($dt['harga']); ?></td>
                        <td><?= $dt['statusPaket']; ?></td>
                        <td>
                            <a href="edit_paket.php?idPaket=<?= $dt['idPaket']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_paket.php?idPaket=<?= $dt['idPaket']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </main>
        <!-- End of Main Content -->

        <!-- Right Section -->
        <div class="right-section">
            <div class="nav">
                <button id="menu-btn">
                    <span class="material-icons-sharp">
                        menu
                    </span>
                </button>
                <div class="dark-mode">
                    <span class="material-icons-sharp active">
                        light_mode
                    </span>
                    <span class="material-icons-sharp">
                        dark_mode
                    </span>
                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Admin</b></p>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="profile-photo">
                        <img src="../asset/images/person-circle.svg">
                    </div>
                </div>
            </div>
            <!-- End of Nav -->
            <div class="user-profile">
                <div class="logo">
                    <img src="../asset/images/person-circle.svg">
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
