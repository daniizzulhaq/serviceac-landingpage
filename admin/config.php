<?php
// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'serviceac_db');

// Koneksi ke database
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Fungsi untuk keamanan
function clean($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $conn->real_escape_string($data);
    return $data;
}

// Fungsi untuk upload gambar
function uploadImage($file) {
    $target_dir = "uploads/";
    
    // Buat folder jika belum ada
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $newFileName = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $newFileName;
    
    // Cek apakah file adalah gambar
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        return ["success" => false, "message" => "File bukan gambar."];
    }
    
    // Cek ukuran file (max 5MB)
    if ($file["size"] > 5000000) {
        return ["success" => false, "message" => "Ukuran file terlalu besar (max 5MB)."];
    }
    
    // Cek format file
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        return ["success" => false, "message" => "Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan."];
    }
    
    // Upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ["success" => true, "filename" => $newFileName];
    } else {
        return ["success" => false, "message" => "Terjadi kesalahan saat upload file."];
    }
}

// Session start
session_start();
?>