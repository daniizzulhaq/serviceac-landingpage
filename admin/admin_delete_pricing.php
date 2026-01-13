<?php
// ==========================================
// FILE: admin_delete_pricing.php
// ==========================================
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = clean($_GET['id']);
    
    // Ambil data gambar
    $sql = "SELECT gambar FROM pricing WHERE id = $id";
    $result = $conn->query($sql);
    $pricing = $result->fetch_assoc();
    
    if ($pricing) {
        // Hapus gambar
        if (file_exists('uploads/' . $pricing['gambar'])) {
            unlink('uploads/' . $pricing['gambar']);
        }
        
        // Hapus data pricing (fitur akan terhapus otomatis karena ON DELETE CASCADE)
        $sql = "DELETE FROM pricing WHERE id = $id";
        
        if ($conn->query($sql)) {
            $_SESSION['success'] = 'Paket berhasil dihapus!';
        } else {
            $_SESSION['error'] = 'Gagal menghapus paket!';
        }
    }
}

header('Location: admin_dashboard.php');
exit();
?>