<?php
require_once 'config.php';

// Cek apakah sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data testimoni
$sql = "SELECT * FROM testimoni WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header('Location: admin_testimoni.php');
    exit();
}

$testimoni = $result->fetch_assoc();

// Proses Update
if (isset($_POST['update_testimoni'])) {
    $nama_pelanggan = $conn->real_escape_string($_POST['nama_pelanggan']);
    $profesi = $conn->real_escape_string($_POST['profesi']);
    $testimoni_text = $conn->real_escape_string($_POST['testimoni']);
    $rating = (int)$_POST['rating'];
    $urutan = (int)$_POST['urutan'];
    $status = isset($_POST['status']) ? 1 : 0;
    
    // Upload foto baru jika ada
    $foto = $testimoni['foto'];
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = 'testimoni_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $new_filename)) {
                // Hapus foto lama jika bukan default
                if ($testimoni['foto'] != 'default-avatar.jpg' && file_exists('uploads/' . $testimoni['foto'])) {
                    unlink('uploads/' . $testimoni['foto']);
                }
                $foto = $new_filename;
            }
        }
    }
    
    $sql = "UPDATE testimoni SET 
            nama_pelanggan = '$nama_pelanggan',
            profesi = '$profesi',
            foto = '$foto',
            testimoni = '$testimoni_text',
            rating = $rating,
            urutan = $urutan,
            status = $status
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        header('Location: admin_testimoni.php');
        exit();
    } else {
        $error = "Gagal mengupdate testimoni: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Testimoni - Admin Service AC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
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
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .main-content {
            padding: 30px;
        }
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        .current-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #667eea;
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
                    <small>Admin Panel</small>
                </div>
                <hr class="bg-white">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_pricing.php">
                            <i class="fas fa-tags"></i> Kelola Pricing
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_lokasi.php">
                            <i class="fas fa-map-marker-alt"></i> Kelola Lokasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_testimoni.php">
                            <i class="fas fa-comments"></i> Kelola Testimoni
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
                <hr class="bg-white">
                <div class="text-center">
                    <small>Login sebagai:</small>
                    <p class="mb-0"><strong><?= $_SESSION['admin_name'] ?></strong></p>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-edit"></i> Edit Testimoni</h2>
                    <a href="admin_testimoni.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Form Edit Testimoni -->
                <div class="content-card">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Pelanggan *</label>
                                    <input type="text" class="form-control" name="nama_pelanggan" required value="<?= htmlspecialchars($testimoni['nama_pelanggan']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Profesi</label>
                                    <input type="text" class="form-control" name="profesi" value="<?= htmlspecialchars($testimoni['profesi']) ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto Saat Ini</label>
                                    <div class="mb-2">
                                        <img src="uploads/<?= $testimoni['foto'] ?>" alt="Foto" class="current-img">
                                    </div>
                                    <input type="file" class="form-control" name="foto" accept="image/*">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Rating *</label>
                                    <select class="form-control" name="rating" required>
                                        <option value="5" <?= $testimoni['rating'] == 5 ? 'selected' : '' ?>>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                                        <option value="4" <?= $testimoni['rating'] == 4 ? 'selected' : '' ?>>⭐⭐⭐⭐ (4 Bintang)</option>
                                        <option value="3" <?= $testimoni['rating'] == 3 ? 'selected' : '' ?>>⭐⭐⭐ (3 Bintang)</option>
                                        <option value="2" <?= $testimoni['rating'] == 2 ? 'selected' : '' ?>>⭐⭐ (2 Bintang)</option>
                                        <option value="1" <?= $testimoni['rating'] == 1 ? 'selected' : '' ?>>⭐ (1 Bintang)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Urutan *</label>
                                    <input type="number" class="form-control" name="urutan" required value="<?= $testimoni['urutan'] ?>" min="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="status" id="status" <?= $testimoni['status'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="status">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Testimoni *</label>
                            <textarea class="form-control" name="testimoni" rows="4" required><?= htmlspecialchars($testimoni['testimoni']) ?></textarea>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" name="update_testimoni" class="btn btn-gradient">
                                <i class="fas fa-save"></i> Update Testimoni
                            </button>
                            <a href="admin_testimoni.php" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>