<?php
// Database connection
include 'config.php';

$idDaftar = $_GET['idDaftar'];

// Fetch data from pendaftaran table based on idDaftar
$sql = "SELECT username, password FROM login WHERE idLogin = $idDaftar";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $password = $row['password']; // In a real application, never display passwords
} else {
    echo "No record found.";
}

$conn->close();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Complete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <h1 class="text-center">Registration Complete</h1>
      <div class="text-center mt-4">
        <p>Username: <?php echo htmlspecialchars($username); ?></p>
        <p>Password: <?php echo htmlspecialchars($password); // Never display passwords in a real application ?></p>
        <a href="index.php#about" class="btn btn-primary">Back to Home</a>
      </div>
    </div>
  </body>
</html>
