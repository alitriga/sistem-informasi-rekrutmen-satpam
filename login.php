<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['idLogin'] = $row['idLogin'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($row['role'] == 'admin') {
            header("Location: admin/index.php");
        } elseif ($row['role'] == 'direktur') {
            header("Location: direktur/index.php");
        } elseif ($row['role'] == 'peserta') {
            header("Location: peserta/index.php?idLogin=" . $row['idLogin']);
        }
        exit();
    } else {
        $_SESSION['login_error'] = 'Username atau password salah.';
        header("Location: index.php#about");
        exit();
    }
}
?>
