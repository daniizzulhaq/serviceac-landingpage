<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

$id = clean($_GET['id']);
$success = '';
$error = '';

// Ambil data pricing
$sql = "SELECT * FROM pricing WHERE id = $id";
$result = $conn->query($sql);
$pricing = $result->fetch_assoc();

if (!$pricing) {
    header('Location: admin_dashboard.php');
    exit();
}

// Ambil fitur-fitur
$sql_features = "SELECT * FROM pricing_features WHERE pricing_id = $id ORDER BY urutan ASC";
$features_result = $conn->query($sql_features);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_paket = clean($_POST['nama_paket']);
    $badge = clean($_POST['badge']);
    $harga = clean($_POST['harga']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $urutan = clean($_POST['urutan']);
    
    // Cek apakah ada gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $upload = uploadImage($_FILES['gambar']);
        
        if ($upload['success']) {
            // Hapus gambar lama
            if (file_exists('uploads/' . $pricing['gambar'])) {
                unlink('uploads/' . $pricing['gambar']);
            }
            $gambar = $upload['filename'];
        } else {
            $error = $upload['message'];
            $gambar = $pricing['gambar'];
        }
    } else {
        $gambar = $pricing['gambar'];
    }
    
    // Update pricing
    $sql = "UPDATE pricing SET 
            nama_paket = '$nama_paket',
            badge = '$badge',
            harga = '$harga',
            gambar = '$gambar',
            is_featured = $is_featured,
            urutan = $urutan
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        // Hapus fitur lama
        $conn->query("DELETE FROM pricing_features WHERE pricing_id = $id");
        
        // Insert fitur baru
        if (isset($_POST['fitur_nama']) && is_array($_POST['fitur_nama'])) {
            foreach ($_POST['fitur_nama'] as $index => $fitur) {
                if (!empty($fitur)) {
                    $fitur_nama = clean($fitur);
                    $fitur_available = isset($_POST['fitur_available'][$index]) ? 1 : 0;
                    $fitur_urutan = $index + 1;
                    
                    $sql_fitur = "INSERT INTO pricing_features (pricing_id, nama_fitur, is_available, urutan) 
                                 VALUES ($id, '$fitur_nama', $fitur_available, $fitur_urutan)";
                    $conn->query($sql_fitur);
                }
            }
        }
        
        $success = 'Paket berhasil diupdate!';
        
        // Refresh data
        $result = $conn->query("SELECT * FROM pricing WHERE id = $id");
        $pricing = $result->fetch_assoc();
        $features_result = $conn->query("SELECT * FROM pricing_features WHERE pricing_id = $id ORDER BY urutan ASC");
    } else {
        $error = 'Gagal mengupdate paket: ' . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pricing - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 0;
        }
        .sidebar .nav-link:hover { background: rgba(255,255,255,0.2); color: white; }
        .main-content { padding: 30px; }
        .form-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .feature-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .current-image {
            max-width: 200px;
            border-radius: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-snowflake fa-3x mb-3"></i>
                    <h4>Service AC</h4>
                </div>
                <hr class="bg-white">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_pricing.php"><i class="fas fa-tags"></i> Kelola Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <h2 class="mb-4">Edit Paket Pricing</h2>
                
                <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> <?= $success ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                
                <div class="form-card">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Paket</label>
                                <input type="text" class="form-control" name="nama_paket" value="<?= $pricing['nama_paket'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Badge</label>
                                <input type="text" class="form-control" name="badge" value="<?= $pricing['badge'] ?>" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga</label>
                                <input type="text" class="form-control" name="harga" value="<?= $pricing['harga'] ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Urutan</label>
                                <input type="number" class="form-control" name="urutan" value="<?= $pricing['urutan'] ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block">Featured?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="featured" <?= $pricing['is_featured'] ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="featured">Ya</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Gambar Paket</label>
                            <div class="mb-2">
                                <img src="uploads/<?= $pricing['gambar'] ?>" alt="Current" class="current-image">
                            </div>
                            <input type="file" class="form-control" name="gambar" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                        </div>
                        
                        <hr>
                        
                        <h5 class="mb-3">Fitur-Fitur Paket</h5>
                        <div id="features-container">
                            <?php 
                            $feature_index = 0;
                            while ($feature = $features_result->fetch_assoc()): 
                            ?>
                            <div class="feature-item">
                                <div class="row">
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="fitur_nama[]" value="<?= $feature['nama_fitur'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fitur_available[]" value="<?= $feature_index ?>" <?= $feature['is_available'] ? 'checked' : '' ?>>
                                            <label class="form-check-label">Tersedia</label>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.parentElement.remove()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            $feature_index++;
                            endwhile; 
                            ?>
                        </div>
                        
                        <button type="button" class="btn btn-secondary mb-3" onclick="addFeature()">
                            <i class="fas fa-plus"></i> Tambah Fitur
                        </button>
                        
                        <hr>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Paket
                            </button>
                            <a href="admin_dashboard.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let featureIndex = <?= $feature_index ?>;
        
        function addFeature() {
            const container = document.getElementById('features-container');
            const featureItem = document.createElement('div');
            featureItem.className = 'feature-item';
            featureItem.innerHTML = `
                <div class="row">
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="fitur_nama[]" placeholder="Nama fitur">
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="fitur_available[]" value="${featureIndex}" checked>
                            <label class="form-check-label">Tersedia</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(featureItem);
            featureIndex++;
        }
    </script>
</body>
</html>