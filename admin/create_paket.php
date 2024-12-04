<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['idLogin']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Connect to the database
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nmPaket = $_POST['nmPaket'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    $sql = "INSERT INTO paket (nmPaket, harga, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $nmPaket, $harga, $status);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Paket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Create New Paket</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nmPaket">Name:</label>
                <input type="text" class="form-control" id="nmPaket" name="nmPaket" required>
            </div>
            <div class="form-group">
                <label for="harga">Price:</label>
                <input type="text" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" class="form-control" id="status" name="status" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
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
