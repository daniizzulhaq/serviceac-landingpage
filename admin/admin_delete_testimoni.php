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
    
    // Ambil data testimoni untuk hapus foto
    $sql = "SELECT foto FROM testimoni WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $testimoni = $result->fetch_assoc();
        
        // Hapus testimoni dari database
        $sql_delete = "DELETE FROM testimoni WHERE id = $id";
        
        if ($conn->query($sql_delete)) {
            // Hapus foto jika bukan default
            if ($testimoni['foto'] != 'default-avatar.jpg' && file_exists('uploads/' . $testimoni['foto'])) {
                unlink('uploads/' . $testimoni['foto']);
            }
            
            header('Location: admin_testimoni.php');
            exit();
        } else {
            die("Error: " . $conn->error);
        }
    }
} else {
    header('Location: admin_testimoni.php');
    exit();
}
?>