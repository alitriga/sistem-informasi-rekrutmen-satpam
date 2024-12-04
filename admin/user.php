<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit();
}

// Menghubungkan ke database
include '../config.php';

$sql = "SELECT * FROM `login` ORDER BY `login`.`tglDaftar` DESC";
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
        .status-admin {
            color: red;
        }

        .status-direktur {
            color: yellow;
        }

        .status-peserta {
            color: green;
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
                <a href="user.php" class="active">
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
                <a href="paket.php">
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
            <!-- <?php
                // Output data in JSON format
                echo json_encode($data);
            ?> -->
            <h1>List User</h1>
            <!-- New Users Section -->
            <div class="new-users">
                <h2>New Users</h2>
                <div class="user-list">
                    <!-- User list will be populated here by jQuery -->
                </div>
            </div>
            <!-- End of New Users Section -->

            <!-- Recent Orders Table -->
            <div class="recent-orders">
                <input type="text" id="search-input" placeholder="Search...">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- End of Recent Orders -->
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
    <script>
    $(document).ready(function() {
        const users = <?php echo json_encode($data); ?>;

        // Append users to the recent orders table
        users.forEach(user => {
            let statusClass = '';
            if (user.role.toLowerCase() === 'admin') {
                statusClass = 'status-admin';
            } else if (user.role.toLowerCase() === 'direktur') {
                statusClass = 'status-direktur';
            } else if (user.role.toLowerCase() === 'peserta') {
                statusClass = 'status-peserta';
            }

            $('tbody').append(`
            {{no++}}
                <tr>
                    <td>${user.idLogin}</td>
                    <td>${user.username}</td>
                    <td class="password-cell" data-password="${user.password}">${'*'.repeat(user.password.length)}</td>
                    <td class="${statusClass}">${user.role}</td>
                    <td><a href="#" class="toggle-password" data-password="${user.password}"><span class="material-icons-sharp">disabled_visible</span></a></td>
                </tr>
            `);
        });

        // Append users to the new users section, limit to 3 users
        users.slice(0, 3).forEach(user => {
            $('.user-list').append(`
                <div class="user">
                    <img src="../asset/images/person-circle.svg">
                    <h2>${user.username}</h2>
                    <p>${user.role}</p>
                </div>
            `);
        });

        // Toggle password visibility
        $(document).on('click', '.toggle-password', function(e) {
            e.preventDefault();
            const $passwordCell = $(this).closest('tr').find('.password-cell');
            if ($passwordCell.text().includes('*')) {
                $passwordCell.text($passwordCell.data('password'));
            } else {
                $passwordCell.text('*'.repeat($passwordCell.data('password').length));
            }
        });

        // Search functionality
        $('#search-input').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>

    <!-- <script>
        $(document).ready(function() {
            const users = [
                { no: 1, username: "admin", password: "admin", status: "Admin" },
                { no: 2, username: "direktur", password: "direktur", status: "Direktur" },
                { no: 3, username: "123", password: "123", status: "Peserta" }
            ];

            // Append users to the recent orders table
            users.forEach(user => {
                let statusClass = '';
                if (user.status.toLowerCase() === 'admin') {
                    statusClass = 'status-admin';
                } else if (user.status.toLowerCase() === 'direktur') {
                    statusClass = 'status-direktur';
                } else if (user.status.toLowerCase() === 'peserta') {
                    statusClass = 'status-peserta';
                }

                $('tbody').append(`
                    <tr>
                        <td>${user.no}</td>
                        <td>${user.username}</td>
                        <td class="password-cell" data-password="${user.password}">${'*'.repeat(user.password.length)}</td>
                        <td class="${statusClass}">${user.status}</td>
                        <td><a href="#" class="toggle-password" data-password="${user.password}"><span class="material-icons-sharp">disabled_visible</span></a></td>
                    </tr>
                `);
            });

            // Append users to the new users section, limit to 3 users
            users.slice(0, 3).forEach(user => {
                $('.user-list').append(`
                    <div class="user">
                        <img src="../asset/images/person-circle.svg">
                        <h2>${user.username}</h2>
                        <p>${user.status}</p>
                    </div>
                `);
            });

            // Toggle password visibility
            $(document).on('click', '.toggle-password', function(e) {
                e.preventDefault();
                const $passwordCell = $(this).closest('tr').find('.password-cell');
                if ($passwordCell.text().includes('*')) {
                    $passwordCell.text($passwordCell.data('password'));
                } else {
                    $passwordCell.text('*'.repeat($passwordCell.data('password').length));
                }
            });
            // Search functionality
            $('#search-input').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script> -->
    <script src="../asset/index.js"></script>
</body>

</html>
