<?php
require_once 'config.php';

// Cek apakah sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data lokasi
$sql = "SELECT * FROM lokasi WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header('Location: admin_lokasi.php');
    exit();
}

$lokasi = $result->fetch_assoc();

// Proses Update
if (isset($_POST['update_lokasi'])) {
    $nama_lokasi = $conn->real_escape_string($_POST['nama_lokasi']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    $link_website = $conn->real_escape_string($_POST['link_website']);
    $urutan = (int)$_POST['urutan'];
    $status = isset($_POST['status']) ? 1 : 0;
    
    $sql = "UPDATE lokasi SET 
            nama_lokasi = '$nama_lokasi',
            deskripsi = '$deskripsi',
            link_website = '$link_website',
            urutan = $urutan,
            status = $status
            WHERE id = " . $conn->real_escape_string($_GET['id']);
    
    if ($conn->query($sql)) {
        header('Location: admin_lokasi.php');
        exit();
    } else {
        $error = "Gagal mengupdate lokasi: " . $conn->error;
    }
}

// Ambil data lokasi yang akan diedit
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM lokasi WHERE id = $id";
    $lokasi = $conn->query($sql)->fetch_assoc();
    
    if (!$lokasi) {
        header('Location: admin_lokasi.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lokasi - Admin Service AC</title>
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
                        <a class="nav-link active" href="admin_lokasi.php">
                            <i class="fas fa-map-marker-alt"></i> Kelola Lokasi
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
                    <h2><i class="fas fa-edit"></i> Edit Lokasi</h2>
                    <a href="admin_lokasi.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Form Edit Lokasi -->
                <div class="content-card">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lokasi *</label>
                                    <input type="text" class="form-control" name="nama_lokasi" required value="<?= htmlspecialchars($lokasi['nama_lokasi']) ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Urutan *</label>
                                    <input type="number" class="form-control" name="urutan" required value="<?= $lokasi['urutan'] ?>" min="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="status" id="status" <?= $lokasi['status'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="status">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Deskripsi *</label>
                            <textarea class="form-control" name="deskripsi" rows="2" required><?= htmlspecialchars($lokasi['deskripsi']) ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Link Website</label>
                            <input type="url" class="form-control" name="link_website" value="<?= htmlspecialchars($lokasi['link_website']) ?>">
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" name="update_lokasi" class="btn btn-gradient">
                                <i class="fas fa-save"></i> Update Lokasi
                            </button>
                            <a href="admin_lokasi.php" class="btn btn-secondary">
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