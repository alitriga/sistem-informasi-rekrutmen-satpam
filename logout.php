<?php
session_start();

// Menghapus semua session
session_unset();

// Menghancurkan session
session_destroy();

// Redirect ke halaman login
header("Location: index.php#about");
exit();
?>
