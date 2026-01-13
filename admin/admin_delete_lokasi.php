<?php
require_once 'config.php';

// Cek apakah sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Hapus lokasi
    $sql = "DELETE FROM lokasi WHERE id = $id";
    
    if ($conn->query($sql)) {
        header('Location: admin_lokasi.php');
        exit();
    } else {
        die("Error: " . $conn->error);
    }
} else {
    header('Location: admin_lokasi.php');
    exit();
}
?>