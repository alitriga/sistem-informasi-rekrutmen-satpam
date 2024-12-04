<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Connect to the database
include '../config.php';

$idPaket = $_GET['idPaket'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nmPaket = $_POST['nmPaket'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    $sql = "UPDATE paket SET nmPaket=?, harga=?, status=? WHERE idPaket=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $nmPaket, $harga, $status, $idPaket);
        if ($stmt->execute()) {
            header("Location: paket.php");
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

$sql = "SELECT * FROM paket WHERE idPaket=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idPaket);
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
    <title>Edit Paket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Paket</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nmPaket">Name:</label>
                <input type="text" class="form-control" id="nmPaket" name="nmPaket" value="<?= $data['nmPaket'] ?>" required>
            </div>
            <div class="form-group">
                <label for="harga">Price:</label>
                <input type="text" class="form-control" id="harga" name="harga" value="<?= $data['harga'] ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" class="form-control" id="status" name="status" value="<?= $data['status'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="paket.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $('#harga').on('input', function () {
                let value = $(this).val().replace(/\D/g, '');
                $(this).val(value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
            });
        });
    </script>
</body>
</html>
