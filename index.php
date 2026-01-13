<?php
require_once 'admin/config.php';

// Ambil semua data pricing
$sql = "SELECT * FROM pricing ORDER BY urutan ASC";
$result = $conn->query($sql);
$sql_lokasi = "SELECT * FROM lokasi WHERE status = 1 ORDER BY urutan ASC";
$result_lokasi = $conn->query($sql_lokasi);

$sql_testimoni = "SELECT * FROM testimoni WHERE status = 1 ORDER BY urutan ASC LIMIT 6";
$result_testimoni = $conn->query($sql_testimoni);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra Jaya Teknik - Service Elektronik Profesional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0066CC;
            --secondary: #004C99;
            --accent: #00A3FF;
            --dark: #1a1a2e;
            --light: #f0f8ff;
            --success: #28a745;
            --warning: #ffc107;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background: #fff;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            padding: 10px 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
        }
        
        .navbar-brand {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary) !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-brand i {
            font-size: 2rem;
            color: var(--accent);
            animation: rotate 3s linear infinite;
        }
        
        @keyframes rotate {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }
        
        .nav-link {
            color: var(--dark) !important;
            font-weight: 500;
            margin: 0 10px;
            position: relative;
            transition: color 0.3s;
        }
        
        .nav-link:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: all 0.3s;
            transform: translateX(-50%);
        }
        
        .nav-link:hover:after {
            width: 80%;
        }
        
        .btn-cta {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 50px;
            padding: 10px 30px;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 102, 204, 0.3);
            transition: all 0.3s;
        }
        
        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 102, 204, 0.4);
            color: white;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 140px 0 100px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 700px;
            height: 700px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
            line-height: 1.2;
            animation: fadeInUp 0.8s ease;
        }
        
        .hero p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 30px;
            animation: fadeInUp 0.8s ease 0.2s both;
        }
        
        .hero-image {
            position: relative;
            animation: fadeInUp 0.8s ease 0.4s both;
        }
        
        .hero-image img {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 8px solid rgba(255, 255, 255, 0.2);
        }
        
        .btn-hero {
            background: white;
            color: var(--primary);
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            animation: fadeInUp 0.8s ease 0.6s both;
            margin-right: 15px;
        }
        
        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        
        .btn-secondary-hero {
            background: transparent;
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            border: 2px solid white;
            transition: all 0.3s;
            animation: fadeInUp 0.8s ease 0.7s both;
        }
        
        .btn-secondary-hero:hover {
            background: white;
            color: var(--primary);
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Stats Section */
        .stats-section {
            background: var(--dark);
            padding: 60px 0;
            margin-top: -50px;
            position: relative;
            z-index: 10;
        }
        
        .stat-card {
            text-align: center;
            color: white;
            padding: 20px;
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        
        .stat-icon i {
            font-size: 2rem;
            color: white;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 10px;
        }
        
        .stat-label {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }
        
        /* Services Section */
        section {
            padding: 80px 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            position: relative;
            padding-bottom: 20px;
            margin-bottom: 50px;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--primary));
            border-radius: 2px;
        }
        
        .service-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            border: 2px solid var(--light);
            transition: all 0.4s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            transition: left 0.5s ease;
            z-index: 0;
        }
        
        .service-card:hover::before {
            left: 0;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 102, 204, 0.3);
            border-color: var(--primary);
        }
        
        .service-card > * {
            position: relative;
            z-index: 1;
            transition: color 0.3s ease;
        }
        
        .service-card:hover h4,
        .service-card:hover p,
        .service-card:hover .service-icon i {
            color: white;
        }
        
        .service-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--light) 0%, #e3f2fd 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .service-card:hover .service-icon {
            background: white;
            transform: scale(1.1);
        }
        
        .service-icon i {
            font-size: 2.5rem;
            color: var(--primary);
            transition: color 0.3s ease;
        }
        
        .service-card h4 {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 15px;
        }
        
        .service-card p {
            color: #666;
            line-height: 1.6;
        }
        
        .service-check {
            text-align: left;
            margin-top: 20px;
        }
        
        .service-check li {
            list-style: none;
            padding: 8px 0;
            color: #666;
            transition: color 0.3s;
        }
        
        .service-card:hover .service-check li {
            color: white;
        }
        
        .service-check i {
            color: var(--success);
            margin-right: 10px;
        }
        
        .service-card:hover .service-check i {
            color: #fff;
        }
        
        /* Why Choose Section */
        .why-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            border-left: 5px solid var(--primary);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .why-card:hover {
            transform: translateX(10px);
            box-shadow: 0 8px 30px rgba(0, 102, 204, 0.2);
            background: var(--light);
        }
        
        .why-card h5 {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        
        .why-card i {
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 15px;
        }
        
        .why-card p {
            color: #666;
            margin: 0;
            line-height: 1.6;
        }
        
        /* Pricing Section */
  <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Harga Service AC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0066cc;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 50px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Harga Service AC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0066cc;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 50px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        /* Pricing Section */
         .pricing-card {
            background: white;
            border-radius: 25px;
            padding: 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            height: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .pricing-card.featured {
            border: 3px solid var(--primary);
            transform: scale(1.02);
        }

        .pricing-image {
            width: 100%;
            height: 220px;
            margin: 0 0 25px 0;
            background: white;
            border-radius: 15px 15px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: none;
            border-bottom: 3px solid #e3f2fd;
        }

        .pricing-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .pricing-card.featured .pricing-image {
            border-bottom: 3px solid #0066cc;
        }

        .pricing-content {
            padding: 25px;
        }

        .pricing-badge {
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 3px 10px rgba(255, 107, 107, 0.3);
        }

        .pricing-card.featured .pricing-badge {
            background: linear-gradient(135deg, #0066cc 0%, #004999 100%);
            box-shadow: 0 3px 10px rgba(0, 102, 204, 0.3);
        }

        .pricing-card h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        .pricing-price {
            font-size: 3rem;
            font-weight: 800;
            color: #2c3e50;
            margin-bottom: 8px;
            line-height: 1;
        }

        .pricing-period {
            color: #888;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        .pricing-features {
            text-align: left;
            margin-bottom: 25px;
            padding: 0;
        }

        .pricing-features li {
            list-style: none;
            padding: 12px 0;
            color: #555;
            font-size: 0.95rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
        }

        .pricing-features li:last-child {
            border-bottom: none;
        }

        .pricing-features i {
            margin-right: 12px;
            font-size: 1rem;
            min-width: 20px;
        }

        .pricing-features .fa-check {
            color: #28a745;
        }

        .pricing-features .fa-times {
            color: #dc3545;
        }

        .whatsapp-btn {
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        .whatsapp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.5);
            background: linear-gradient(135deg, #128C7E 0%, #075E54 100%);
            color: white;
            text-decoration: none;
        }

        .whatsapp-btn i {
            margin-right: 8px;
            font-size: 1.2rem;
        }

        .text-danger {
            color: #dc3545;
        }
        /* FAQ */
        .accordion-item {
            border: none;
            margin-bottom: 15px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }
        
        .accordion-button {
            background: white;
            color: var(--dark);
            font-weight: 600;
            padding: 20px 25px;
            font-size: 1.05rem;
            border: none;
        }
        
        .accordion-button:not(.collapsed) {
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            color: white;
            box-shadow: none;
        }
        
        .accordion-button:focus {
            box-shadow: none;
            border: none;
        }
        
        .accordion-body {
            padding: 25px;
            background: white;
            color: #666;
            line-height: 1.7;
        }

        .testimoni-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.testimoni-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') bottom center no-repeat;
    background-size: cover;
}

.testimoni-section .section-title {
    color: white;
    margin-bottom: 10px;
}

.testimoni-section .section-subtitle {
    color: rgba(255,255,255,0.9);
    margin-bottom: 50px;
}

.testimoni-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
}

.testimoni-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

.testimoni-card::before {
    content: '"';
    position: absolute;
    top: 20px;
    left: 25px;
    font-size: 60px;
    color: #667eea;
    opacity: 0.2;
    font-family: Georgia, serif;
}

.testimoni-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.testimoni-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #667eea;
    margin-right: 15px;
}

.testimoni-info h5 {
    margin: 0;
    color: #333;
    font-weight: 600;
    font-size: 18px;
}

.testimoni-info p {
    margin: 0;
    color: #666;
    font-size: 14px;
}

.testimoni-rating {
    color: #ffc107;
    font-size: 18px;
    margin-bottom: 15px;
}

.testimoni-text {
    color: #555;
    line-height: 1.8;
    font-size: 15px;
    font-style: italic;
}
        
        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--dark) 100%);
            color: white;
            padding: 60px 0 30px;
        }
        
        footer h5 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        footer a {
            color: var(--accent);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        footer a:hover {
            color: white;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .btn-hero, .btn-secondary-hero {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-fan"></i> Mitra Jaya Teknik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#keunggulan">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#harga">Harga</a></li>
                    <li class="nav-item"><a class="nav-link" href="#lokasi">Lokasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                </ul>
                <a href="https://wa.me/6281381473461" class="btn btn-cta ms-3">
                    <i class="fas fa-phone"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1>Service Elektronik Profesional & Terpercaya</h1>
                    <p>Solusi lengkap untuk perawatan AC, kulkas, pompa air, mesin cuci, dan peralatan elektronik Anda. Teknisi berpengalaman dengan harga terjangkau</p>
                    <div>
                        <button class="btn btn-hero" onclick="scrollToSection('contact')">
                            <i class="fas fa-phone"></i> Konsultasi Gratis
                        </button>
                        <button class="btn btn-secondary-hero" onclick="scrollToSection('layanan')">
                            Lihat Layanan
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 hero-image text-center">
                    <img src="image.png" class="img-fluid" alt="Service Elektronik" style="max-height: 500px; object-fit: contain;">
                </div>
            </div>
        </div>
    </section>

   

    <!-- Services Section -->
    <section id="layanan">
        <div class="container">
            <h2 class="text-center section-title">Layanan Kami</h2>
            <p class="text-center text-muted mb-5">Kami menyediakan berbagai layanan service elektronik profesional</p>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-fan"></i>
                        </div>
                        <h4>Cuci AC / Maintenance</h4>
                        <p>Service dan pembersihan AC untuk performa optimal dan udara lebih sehat</p>
                        <ul class="service-check">
                            <li><i class="fas fa-check-circle"></i> Cuci indoor & outdoor</li>
                            <li><i class="fas fa-check-circle"></i> Sterilisasi antibakteri</li>
                            <li><i class="fas fa-check-circle"></i> Cek fungsi lengkap</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-wrench"></i>
                        </div>
                        <h4>Service AC</h4>
                        <p>Perbaikan semua jenis kerusakan AC dengan diagnosa akurat dan penanganan cepat</p>
                        <ul class="service-check">
                            <li><i class="fas fa-check-circle"></i> Diagnosa gratis</li>
                            <li><i class="fas fa-check-circle"></i> Garansi perbaikan</li>
                            <li><i class="fas fa-check-circle"></i> Spare part original</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-hammer"></i>
                        </div>
                        <h4>Instalasi Bongkar Pasang</h4>
                        <p>Jasa bongkar pasang AC profesional dengan instalasi yang rapi dan aman</p>
                        <ul class="service-check">
                            <li><i class="fas fa-check-circle"></i> Survey lokasi gratis</li>
                            <li><i class="fas fa-check-circle"></i> Instalasi rapi & aman</li>
                            <li><i class="fas fa-check-circle"></i> Garansi pemasangan</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-temperature-low"></i>
                        </div>
                        <h4>Service Kulkas</h4>
                        <p>Perbaikan dan maintenance kulkas untuk performa pendinginan optimal</p>
                        <ul class="service-check">
                            <li><i class="fas fa-check-circle"></i> Cek sistem pendingin</li>
                            <li><i class="fas fa-check-circle"></i> Perbaikan kebocoran</li>
                            <li><i class="fas fa-check-circle"></i> Isi freon kulkas</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-pump-soap"></i>
                        </div>
                        <h4>Service Pompa Air</h4>
                        <p>Perbaikan dan perawatan pompa air untuk aliran air yang lancar</p>
                        <ul class="service-check">
                            <li><i class="fas fa-check-circle"></i> Cek mesin pompa</li>
                            <li><i class="fas fa-check-circle"></i> Ganti komponen rusak</li>
                            <li><i class="fas fa-check-circle"></i> Setting tekanan air</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-soap"></i>
                        </div>
                        <h4>Service Mesin Cuci</h4>
                        <p>Perbaikan mesin cuci semua jenis dengan hasil maksimal</p>
                        <ul class="service-check">
                            <li><i class="fas fa-check-circle"></i> Cek sistem pencucian</li>
                            <li><i class="fas fa-check-circle"></i> Perbaikan motor</li>
                            <li><i class="fas fa-check-circle"></i> Ganti spare part</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Section -->
    <section id="keunggulan" class="bg-light">
        <div class="container">
            <h2 class="text-center section-title">Mengapa Pilih Kami?</h2>
            <p class="text-center text-muted mb-5">Keunggulan yang membuat kami menjadi pilihan terbaik untuk service elektronik Anda</p>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="why-card">
                        <i class="fas fa-certificate"></i>
                        <h5>Teknisi Bersertifikat</h5>
                        <p>Tim teknisi profesional dengan sertifikasi resmi dan pengalaman bertahun-tahun di bidang elektronik</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card">
                        <i class="fas fa-clock"></i>
                        <h5>Layanan Cepat & Tepat</h5>
                        <p>Respon cepat dan penanganan tepat waktu. Kami siap melayani panggilan darurat Anda 24/7</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card">
                        <i class="fas fa-shield-alt"></i>
                        <h5>Garansi Terpercaya</h5>
                        <p>Semua pekerjaan kami dilengkapi garansi untuk memberikan ketenangan pikiran Anda</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card">
                        <i class="fas fa-tags"></i>
                        <h5>Harga Transparan</h5>
                        <p>Tanpa biaya tersembunyi. Harga jelas dan kompetitif dengan kualitas terbaik</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card">
                        <i class="fas fa-cog"></i>
                        <h5>Peralatan Modern</h5>
                        <p>Menggunakan peralatan canggih dan teknologi terkini untuk hasil maksimal</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card">
                        <i class="fas fa-headset"></i>
                        <h5>Customer Service 24/7</h5>
                        <p>Tim customer service kami siap membantu Anda kapan saja untuk konsultasi dan keluhan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- Pricing Section -->
    <section id="harga">
        <div class="container">
            <h2 class="text-center section-title">Paket Harga Service</h2>
            <p class="text-center text-muted mb-5">Pilih paket yang sesuai dengan kebutuhan Anda</p>
            <div class="row g-4">
                <?php while ($pricing = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="pricing-card <?= $pricing['is_featured'] ? 'featured' : '' ?>">
                        <div class="pricing-image">
                            <img src="admin/uploads/<?= $pricing['gambar'] ?>" alt="<?= $pricing['nama_paket'] ?>">
                        </div>
                        <div class="pricing-content">
                            <div class="pricing-badge"><?= $pricing['badge'] ?></div>
                            <h3><?= $pricing['nama_paket'] ?></h3>
                            <div class="pricing-price"><?= $pricing['harga'] ?></div>
                            <div class="pricing-period">per unit</div>
                            <ul class="pricing-features">
                                <?php
                                $pricing_id = $pricing['id'];
                                $sql_features = "SELECT * FROM pricing_features WHERE pricing_id = $pricing_id ORDER BY urutan ASC";
                                $features = $conn->query($sql_features);
                                while ($feature = $features->fetch_assoc()):
                                ?>
                                <li>
                                    <i class="fas fa-<?= $feature['is_available'] ? 'check' : 'times text-danger' ?>"></i> 
                                    <?= $feature['nama_fitur'] ?>
                                </li>
                                <?php endwhile; ?>
                            </ul>
                            <a href="https://wa.me/6281381473461" target="_blank" class="whatsapp-btn">
                                <i class="fab fa-whatsapp"></i> Pesan via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <div class="text-center mt-5">
                <p class="text-muted mb-3">*Harga dapat berubah tergantung kondisi elektronik dan lokasi</p>
                <p class="text-muted">Hubungi kami untuk konsultasi dan penawaran khusus!</p>
                <p class="text-muted"><strong>No Telp/WA: 0813 8147 3461</strong></p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="bg-light">
        <div class="container">
            <h2 class="text-center section-title">Pertanyaan Yang Sering Diajukan</h2>
            <p class="text-center text-muted mb-5">Temukan jawaban untuk pertanyaan umum tentang layanan kami</p>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Berapa lama waktu yang dibutuhkan untuk service AC?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Untuk cuci AC standar membutuhkan waktu sekitar 45-60 menit per unit. Untuk service lengkap atau perbaikan, waktu yang dibutuhkan bervariasi tergantung kondisi AC, biasanya 1-2 jam per unit.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Apakah ada garansi untuk service yang dilakukan?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, kami memberikan garansi untuk semua jenis layanan. Garansi 14 hari untuk paket premium dan 30 hari untuk paket lengkap. Garansi mencakup workmanship dan spare part yang diganti.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Apakah teknisi membawa peralatan lengkap?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, teknisi kami selalu membawa peralatan lengkap dan modern untuk service AC. Termasuk mesin cuci AC, vacuum pump, manifold gauge, dan tools standar lainnya.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Berapa sering AC harus di-service?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Kami merekomendasikan service AC rutin setiap 3-6 bulan sekali untuk pemakaian normal. Untuk AC yang digunakan intensif (24 jam) sebaiknya di-service setiap 2-3 bulan untuk menjaga performa optimal.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            Apakah melayani panggilan darurat?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, kami melayani panggilan darurat 24/7 untuk kasus-kasus mendesak. Tim emergency kami siap datang dengan biaya tambahan untuk panggilan di luar jam kerja normal.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                            Wilayah mana saja yang dilayani?
                        </button>
                    </h2>
                    <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Kami melayani seluruh wilayah Jakarta, Bogor, Depok, Tangerang, dan Bekasi (Jabodetabek). Untuk wilayah di luar area tersebut, silakan hubungi kami untuk konfirmasi ketersediaan layanan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lokasi Kami Section -->
    <section id="lokasi" class="bg-light">
        <div class="container">
            <h2 class="text-center section-title">Lokasi Kami</h2>
            <p class="text-center text-muted mb-5">Kami melayani berbagai wilayah dengan teknisi profesional</p>
            <div class="row g-4">
                <?php while ($lokasi = $result_lokasi->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="why-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <h5><?= htmlspecialchars($lokasi['nama_lokasi']) ?></h5>
                        <p><?= htmlspecialchars($lokasi['deskripsi']) ?></p>
                        <a href="<?= htmlspecialchars($lokasi['link_website']) ?>" class="text-primary">Kunjungi Website →</a>
                    </div>
                </div>
                <?php endwhile; ?>
                
                <?php if ($result_lokasi->num_rows == 0): ?>
                <div class="col-12">
                    <p class="text-center text-muted">Belum ada data lokasi tersedia.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Section Testimoni -->
<section class="testimoni-section" id="testimoni">
    <div class="container position-relative">
        <h2 class="text-center section-title">Testimoni Pelanggan</h2>
        <p class="text-center section-subtitle">Apa kata mereka tentang layanan kami</p>
        
        <div class="row g-4">
            <?php if ($result_testimoni->num_rows > 0): ?>
                <?php while ($testi = $result_testimoni->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="testimoni-card">
                        <div class="testimoni-header">
                            <img src="admin/uploads/<?= htmlspecialchars($testi['foto']) ?>" 
                                 alt="<?= htmlspecialchars($testi['nama_pelanggan']) ?>" 
                                 class="testimoni-avatar">
                            <div class="testimoni-info">
                                <h5><?= htmlspecialchars($testi['nama_pelanggan']) ?></h5>
                                <p><?= htmlspecialchars($testi['profesi']) ?></p>
                            </div>
                        </div>
                        
                        <div class="testimoni-rating">
                            <?php for($i = 0; $i < $testi['rating']; $i++): ?>
                                ⭐
                            <?php endfor; ?>
                        </div>
                        
                        <p class="testimoni-text">
                            "<?= htmlspecialchars($testi['testimoni']) ?>"
                        </p>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center text-white">Belum ada testimoni tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <h2 class="text-center section-title">Hubungi Kami</h2>
            <p class="text-center text-muted mb-5">Konsultasi gratis untuk kebutuhan service elektronik Anda</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="why-card text-center">
                                <i class="fas fa-phone-alt"></i>
                                <h5>Telepon</h5>
                                <p><a href="tel:+6281381473461">0813 8147 3461</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="why-card text-center">
                                <i class="fab fa-whatsapp"></i>
                                <h5>WhatsApp</h5>
                                <p><a href="https://wa.me/6281381473461" target="_blank">Chat WhatsApp</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="why-card text-center">
                                <i class="fas fa-envelope"></i>
                                <h5>Email</h5>
                                <p><a href="mailto:info@mitrajayateknik.com">info@mitrajayateknik.com</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="why-card text-center">
                                <i class="fas fa-map-marker-alt"></i>
                                <h5>Alamat</h5>
                                <p>Jakarta & Sekitarnya</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <a href="https://wa.me/6281381473461?text=Halo%2C%20saya%20ingin%20konsultasi%20service%20elektronik" target="_blank" class="btn btn-cta btn-lg">
                            <i class="fab fa-whatsapp"></i> Chat Sekarang untuk Konsultasi Gratis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-fan"></i> Mitra Jaya Teknik</h5>
                    <p>Solusi terpercaya untuk semua kebutuhan service dan perawatan elektronik Anda. Teknisi profesional dengan pengalaman puluhan tahun.</p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Layanan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#layanan">Service AC</a></li>
                        <li class="mb-2"><a href="#layanan">Service Kulkas</a></li>
                        <li class="mb-2"><a href="#layanan">Service Pompa Air</a></li>
                        <li class="mb-2"><a href="#layanan">Service Mesin Cuci</a></li>
                        <li class="mb-2"><a href="#layanan">Instalasi Bongkar Pasang</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Jam Operasional</h5>
                    <p class="mb-2"><i class="fas fa-clock"></i> Senin - Jumat: 08.00 - 18.00</p>
                    <p class="mb-2"><i class="fas fa-clock"></i> Sabtu: 08.00 - 16.00</p>
                    <p class="mb-2"><i class="fas fa-clock"></i> Minggu: 09.00 - 15.00</p>
                    <p class="mt-3"><i class="fas fa-phone"></i> Emergency 24/7</p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 30px 0;">
            <div class="text-center">
                <p class="mb-0">&copy; 2024 Mitra Jaya Teknik. All Rights Reserved.</p>
                <p class="mt-2 mb-0"><i class="fas fa-phone"></i> 0813 8147 3461 | <i class="fab fa-whatsapp"></i> WhatsApp Available</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scroll function
        function scrollToSection(sectionId) {
            const element = document.getElementById(sectionId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Counter animation for stats
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }

        // Intersection Observer for counter animation
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    animateCounter(entry.target);
                    entry.target.classList.add('animated');
                }
            });
        }, { threshold: 0.5 });

        // Observe all stat numbers
        document.querySelectorAll('.stat-number[data-target]').forEach(stat => {
            counterObserver.observe(stat);
        });

        // Add animation on scroll for cards
        const cards = document.querySelectorAll('.service-card, .why-card, .pricing-card');
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(30px)';
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.6s ease';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => {
            cardObserver.observe(card);
        });
    </script>
</body>
</html>