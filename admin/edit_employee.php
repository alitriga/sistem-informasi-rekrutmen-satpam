<?php
session_start();

// Memeriksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Menghubungkan ke database
include '../config.php';

$idKaryawan = $_GET['idKaryawan'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $username = $_POST['username'];
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $_POST['old_password']; // Enkripsi password jika diubah
    $role = $_POST['role'];

    $sql = "UPDATE karyawan SET nama=?, jabatan=?, username=?, password=?, role=? WHERE idKaryawan=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssi", $nama, $jabatan, $username, $password, $role, $idKaryawan);
        if ($stmt->execute()) {
            header("Location: employee.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}

$sql = "SELECT * FROM karyawan WHERE idKaryawan=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idKaryawan);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Employee</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nama">Name:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama'] ?>" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Position:</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= $data['jabatan'] ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $data['username'] ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <input type="hidden" name="old_password" value="<?= $data['password'] ?>"> <!-- Hidden field to keep old password -->
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <input type="text" class="form-control" id="role" name="role" value="<?= $data['role'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="karyawan.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
