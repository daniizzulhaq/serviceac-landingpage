<?php
require_once 'config.php';

// Cek apakah sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

// Ambil semua data pricing
$sql = "SELECT * FROM pricing ORDER BY urutan ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Service AC</title>
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
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .pricing-table {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .pricing-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }
        .badge-featured {
            background: linear-gradient(135deg, #0066cc 0%, #004999 100%);
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
                        <a class="nav-link active" href="admin_dashboard.php">
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
                    <h2>Dashboard</h2>
                    <div>
                        <span class="text-muted">Selamat datang, </span>
                        <strong><?= $_SESSION['admin_name'] ?></strong>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="stats-card text-center">
                            <i class="fas fa-box text-primary"></i>
                            <h3><?= $result->num_rows ?></h3>
                            <p class="text-muted mb-0">Total Paket</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card text-center">
                            <i class="fas fa-star text-warning"></i>
                            <h3>
                                <?php
                                $featured = $conn->query("SELECT COUNT(*) as count FROM pricing WHERE is_featured = 1");
                                echo $featured->fetch_assoc()['count'];
                                ?>
                            </h3>
                            <p class="text-muted mb-0">Paket Featured</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card text-center">
                            <i class="fas fa-check-circle text-success"></i>
                            <h3>
                                <?php
                                $features = $conn->query("SELECT COUNT(*) as count FROM pricing_features");
                                echo $features->fetch_assoc()['count'];
                                ?>
                            </h3>
                            <p class="text-muted mb-0">Total Fitur</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card text-center">
                            <i class="fas fa-map-marker-alt text-info"></i>
                            <h3>
                                <?php
                                $lokasi = $conn->query("SELECT COUNT(*) as count FROM lokasi WHERE status = 1");
                                echo $lokasi->fetch_assoc()['count'];
                                ?>
                            </h3>
                            <p class="text-muted mb-0">Total Lokasi</p>
                        </div>
                    </div>
                </div>
                
                <!-- Pricing Table -->
                <div class="pricing-table">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4>Daftar Paket Pricing</h4>
                        <a href="admin_pricing.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Paket
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Paket</th>
                                    <th>Badge</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <img src="uploads/<?= $row['gambar'] ?>" alt="<?= $row['nama_paket'] ?>" class="pricing-img">
                                    </td>
                                    <td><strong><?= $row['nama_paket'] ?></strong></td>
                                    <td><span class="badge bg-secondary"><?= $row['badge'] ?></span></td>
                                    <td><strong><?= $row['harga'] ?></strong></td>
                                    <td>
                                        <?php if ($row['is_featured']): ?>
                                            <span class="badge badge-featured">Featured</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark">Normal</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="admin_edit_pricing.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="admin_delete_pricing.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus paket ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>