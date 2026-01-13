<?php
require_once 'config.php';

// Cek apakah sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

// Proses Tambah Testimoni
if (isset($_POST['tambah_testimoni'])) {
    $nama_pelanggan = $conn->real_escape_string($_POST['nama_pelanggan']);
    $profesi = $conn->real_escape_string($_POST['profesi']);
    $testimoni = $conn->real_escape_string($_POST['testimoni']);
    $rating = (int)$_POST['rating'];
    $urutan = (int)$_POST['urutan'];
    $status = isset($_POST['status']) ? 1 : 0;
    
    // Upload foto
    $foto = 'default-avatar.jpg';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = 'testimoni_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $new_filename)) {
                $foto = $new_filename;
            }
        }
    }
    
    $sql = "INSERT INTO testimoni (nama_pelanggan, profesi, foto, testimoni, rating, urutan, status) 
            VALUES ('$nama_pelanggan', '$profesi', '$foto', '$testimoni', $rating, $urutan, $status)";
    
    if ($conn->query($sql)) {
        $success = "Testimoni berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan testimoni: " . $conn->error;
    }
}

// Ambil semua data testimoni
$sql = "SELECT * FROM testimoni ORDER BY urutan ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Testimoni - Admin Service AC</title>
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
            margin-bottom: 30px;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }
        .testimoni-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }
        .rating-stars {
            color: #ffc107;
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
                    <h2><i class="fas fa-comments"></i> Kelola Testimoni</h2>
                    <a href="admin_dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> <?= $success ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Form Tambah Testimoni -->
                <div class="content-card">
                    <h4 class="mb-4"><i class="fas fa-plus-circle"></i> Tambah Testimoni Baru</h4>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Pelanggan *</label>
                                    <input type="text" class="form-control" name="nama_pelanggan" required placeholder="Contoh: Budi Santoso">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Profesi</label>
                                    <input type="text" class="form-control" name="profesi" placeholder="Contoh: Pengusaha">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto Pelanggan</label>
                                    <input type="file" class="form-control" name="foto" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF (Maks 2MB)</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Rating *</label>
                                    <select class="form-control" name="rating" required>
                                        <option value="5" selected>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                                        <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                                        <option value="3">⭐⭐⭐ (3 Bintang)</option>
                                        <option value="2">⭐⭐ (2 Bintang)</option>
                                        <option value="1">⭐ (1 Bintang)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Urutan *</label>
                                    <input type="number" class="form-control" name="urutan" required value="0" min="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                                        <label class="form-check-label" for="status">Aktif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Testimoni *</label>
                            <textarea class="form-control" name="testimoni" rows="4" required placeholder="Tulis testimoni pelanggan di sini..."></textarea>
                        </div>
                        
                        <button type="submit" name="tambah_testimoni" class="btn btn-gradient">
                            <i class="fas fa-save"></i> Simpan Testimoni
                        </button>
                    </form>
                </div>
                
                <!-- Tabel Daftar Testimoni -->
                <div class="content-card">
                    <h4 class="mb-4"><i class="fas fa-list"></i> Daftar Testimoni</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="60">Foto</th>
                                    <th>Nama</th>
                                    <th>Profesi</th>
                                    <th>Testimoni</th>
                                    <th width="100">Rating</th>
                                    <th width="80">Urutan</th>
                                    <th width="80">Status</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <img src="uploads/<?= $row['foto'] ?>" alt="<?= $row['nama_pelanggan'] ?>" class="testimoni-img">
                                    </td>
                                    <td><strong><?= htmlspecialchars($row['nama_pelanggan']) ?></strong></td>
                                    <td><?= htmlspecialchars($row['profesi']) ?></td>
                                    <td><?= substr(htmlspecialchars($row['testimoni']), 0, 100) ?>...</td>
                                    <td>
                                        <span class="rating-stars">
                                            <?php for($i = 0; $i < $row['rating']; $i++) echo '⭐'; ?>
                                        </span>
                                    </td>
                                    <td><span class="badge bg-secondary"><?= $row['urutan'] ?></span></td>
                                    <td>
                                        <?php if ($row['status']): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="admin_edit_testimoni.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="admin_delete_testimoni.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus testimoni ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                
                                <?php if ($result->num_rows == 0): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada data testimoni</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>