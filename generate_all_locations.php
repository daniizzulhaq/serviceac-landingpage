<?php
/**
 * Script Generator Otomatis - Service Elektronik Mitra Jaya Teknik
 * Untuk 25 Lokasi di Jakarta & Bekasi
 * ENHANCED VERSION - Dengan Lebih Banyak Layanan
 * 
 * CARA PAKAI:
 * 1. Upload file ini ke root website Anda
 * 2. Upload folder assets/images (dari website utama) ke root juga
 * 3. Akses via browser: http://yoursite.com/generate_all_locations.php
 * 4. Script akan otomatis membuat 25 folder dan file index.php
 * 5. Hapus file ini setelah selesai generate
 */

// Data 25 lokasi dengan konten unik
$lokasi_list = [
    // JAKARTA UTARA
    ['slug' => 'kelapa-gading', 'nama' => 'Kelapa Gading', 'wilayah' => 'Jakarta Utara', 'keunikan' => 'kawasan mall dan perumahan elite dengan banyak gedung perkantoran', 'karakteristik' => 'Kelapa Gading dikenal sebagai pusat perbelanjaan dan bisnis dengan mall besar seperti Mall of Indonesia dan Kelapa Gading Mall'],
    
    ['slug' => 'tanjung-priok', 'nama' => 'Tanjung Priok', 'wilayah' => 'Jakarta Utara', 'keunikan' => 'kawasan pelabuhan tersibuk di Indonesia dengan area industri dan perdagangan', 'karakteristik' => 'Tanjung Priok merupakan sentra logistik dengan aktivitas bisnis 24 jam dan banyak gudang serta pabrik'],
    
    ['slug' => 'koja', 'nama' => 'Koja', 'wilayah' => 'Jakarta Utara', 'keunikan' => 'kawasan padat penduduk dengan aktivitas perdagangan yang ramai', 'karakteristik' => 'Koja memiliki banyak pasar tradisional dan ruko dengan tingkat hunian yang tinggi'],
    
    ['slug' => 'cilincing', 'nama' => 'Cilincing', 'wilayah' => 'Jakarta Utara', 'keunikan' => 'daerah pesisir dengan banyak kawasan industri dan permukiman nelayan', 'karakteristik' => 'Cilincing berkembang pesat dengan perumahan baru dan fasilitas umum yang modern'],
    
    ['slug' => 'pademangan', 'nama' => 'Pademangan', 'wilayah' => 'Jakarta Utara', 'keunikan' => 'kawasan strategis dekat pelabuhan dengan campuran area residential dan komersial', 'karakteristik' => 'Pademangan memiliki akses mudah ke berbagai area dan banyak perumahan menengah'],
    
    ['slug' => 'penjaringan', 'nama' => 'Penjaringan', 'wilayah' => 'Jakarta Utara', 'keunikan' => 'daerah pesisir dengan perkembangan properti yang pesat', 'karakteristik' => 'Penjaringan terus berkembang dengan pembangunan apartemen dan perumahan modern'],
    
    // JAKARTA TIMUR
    ['slug' => 'pulogadung', 'nama' => 'Pulogadung', 'wilayah' => 'Jakarta Timur', 'keunikan' => 'kawasan industri terbesar dengan banyak pabrik dan gudang', 'karakteristik' => 'Pulogadung adalah pusat industri dengan Kawasan Industri Pulogadung yang menampung ratusan perusahaan'],
    
    ['slug' => 'cakung', 'nama' => 'Cakung', 'wilayah' => 'Jakarta Timur', 'keunikan' => 'area strategis dekat Tol Jakarta-Cikampek dengan banyak perumahan baru', 'karakteristik' => 'Cakung berkembang pesat sebagai kawasan hunian dengan infrastruktur yang terus dibangun'],
    
    ['slug' => 'duren-sawit', 'nama' => 'Duren Sawit', 'wilayah' => 'Jakarta Timur', 'keunikan' => 'kawasan padat penduduk dengan campuran perumahan tradisional dan modern', 'karakteristik' => 'Duren Sawit memiliki komunitas yang kuat dengan banyak sekolah dan fasilitas umum'],
    
    ['slug' => 'jatinegara', 'nama' => 'Jatinegara', 'wilayah' => 'Jakarta Timur', 'keunikan' => 'pusat perdagangan dengan Pasar Jatinegara yang terkenal', 'karakteristik' => 'Jatinegara ramai dengan aktivitas bisnis dan dekat dengan stasiun kereta api utama'],
    
    ['slug' => 'matraman', 'nama' => 'Matraman', 'wilayah' => 'Jakarta Timur', 'keunikan' => 'kawasan strategis di jalur utama Jakarta dengan akses mudah', 'karakteristik' => 'Matraman dilalui banyak kendaraan umum dan dekat dengan berbagai fasilitas kota'],
    
    ['slug' => 'makasar', 'nama' => 'Makasar', 'wilayah' => 'Jakarta Timur', 'keunikan' => 'area berkembang dengan banyak perumahan cluster dan apartemen', 'karakteristik' => 'Makasar menawarkan hunian nyaman dengan harga relatif terjangkau'],
    
    ['slug' => 'kramatjati', 'nama' => 'Kramatjati', 'wilayah' => 'Jakarta Timur', 'keunikan' => 'kawasan dengan Pasar Induk Kramatjati sebagai pusat distribusi sayur dan buah', 'karakteristik' => 'Kramatjati adalah sentra logistik pangan dengan aktivitas 24 jam'],
    
    // JAKARTA PUSAT
    ['slug' => 'johar-baru', 'nama' => 'Johar Baru', 'wilayah' => 'Jakarta Pusat', 'keunikan' => 'kawasan padat dengan banyak gedung perkantoran dan apartemen', 'karakteristik' => 'Johar Baru adalah area bisnis yang ramai dengan akses mudah ke pusat kota'],
    
    ['slug' => 'cempaka-putih', 'nama' => 'Cempaka Putih', 'wilayah' => 'Jakarta Pusat', 'keunikan' => 'area strategis dekat dengan berbagai fasilitas pendidikan dan kesehatan', 'karakteristik' => 'Cempaka Putih memiliki banyak rumah sakit dan sekolah ternama'],
    
    ['slug' => 'kemayoran', 'nama' => 'Kemayoran', 'wilayah' => 'Jakarta Pusat', 'keunikan' => 'kawasan berkembang dengan Jakarta International Expo (JIExpo)', 'karakteristik' => 'Kemayoran adalah pusat pameran dan convention dengan banyak hotel dan gedung bisnis'],
    
    ['slug' => 'senen', 'nama' => 'Senen', 'wilayah' => 'Jakarta Pusat', 'keunikan' => 'pusat perdagangan tradisional dengan Pasar Senen yang ikonik', 'karakteristik' => 'Senen ramai dengan aktivitas bisnis dan dekat dengan stasiun kereta api Senen'],
    
    ['slug' => 'sawah-besar', 'nama' => 'Sawah Besar', 'wilayah' => 'Jakarta Pusat', 'keunikan' => 'kawasan Chinatown Jakarta dengan banyak toko dan gedung bersejarah', 'karakteristik' => 'Sawah Besar kaya akan budaya Tionghoa dengan Glodok sebagai pusat elektronik'],
    
    ['slug' => 'menteng', 'nama' => 'Menteng', 'wilayah' => 'Jakarta Pusat', 'keunikan' => 'kawasan elite heritage dengan arsitektur kolonial dan perumahan mewah', 'karakteristik' => 'Menteng adalah area prestisius dengan banyak kedutaan dan rumah pejabat'],
    
    ['slug' => 'gambir', 'nama' => 'Gambir', 'wilayah' => 'Jakarta Pusat', 'keunikan' => 'jantung kota dengan Monas dan berbagai gedung pemerintahan', 'karakteristik' => 'Gambir adalah pusat pemerintahan dan wisata dengan akses ke seluruh Jakarta'],
    
    ['slug' => 'tanah-abang', 'nama' => 'Tanah Abang', 'wilayah' => 'Jakarta Pusat', 'keunikan' => 'pusat perdagangan tekstil terbesar di Asia Tenggara', 'karakteristik' => 'Tanah Abang sangat ramai dengan ribuan pedagang dan pembeli setiap hari'],
    
    // JAKARTA BARAT
    ['slug' => 'taman-sari', 'nama' => 'Taman Sari', 'wilayah' => 'Jakarta Barat', 'keunikan' => 'kawasan padat dengan banyak rumah susun dan area perdagangan', 'karakteristik' => 'Taman Sari memiliki komunitas yang beragam dengan berbagai usaha kecil menengah'],
    
    // BEKASI KOTA
    ['slug' => 'medan-satria', 'nama' => 'Medan Satria', 'wilayah' => 'Bekasi Kota', 'keunikan' => 'kawasan berkembang pesat dengan banyak perumahan dan mall modern', 'karakteristik' => 'Medan Satria menjadi primadona hunian di Bekasi dengan akses mudah ke Jakarta'],
    
    ['slug' => 'bintara-jaya', 'nama' => 'Bintara Jaya', 'wilayah' => 'Bekasi Kota', 'keunikan' => 'area strategis dengan campuran perumahan dan area komersial', 'karakteristik' => 'Bintara Jaya terus berkembang dengan infrastruktur yang memadai'],
    
    ['slug' => 'pondok-gede', 'nama' => 'Pondok Gede', 'wilayah' => 'Bekasi Kota', 'keunikan' => 'kawasan dekat perbatasan Jakarta dengan akses transportasi lengkap', 'karakteristik' => 'Pondok Gede populer karena lokasinya yang strategis dan harga properti yang kompetitif']
];

// Daftar layanan lengkap
$services = [
    [
        'icon' => 'fa-fan',
        'title' => 'Service AC',
        'slug' => 'service-ac',
        'desc' => 'Cuci AC, isi freon, service berkala, perbaikan AC tidak dingin',
        'details' => 'Service AC semua merk (Daikin, Panasonic, LG, Sharp, Samsung, dll)'
    ],
    [
        'icon' => 'fa-broom',
        'title' => 'Cuci AC / Maintenance',
        'slug' => 'cuci-ac',
        'desc' => 'Pembersihan menyeluruh AC, maintenance rutin, sanitasi AC',
        'details' => 'Cuci AC dengan cairan khusus, cek komponen, perawatan berkala'
    ],
    [
        'icon' => 'fa-temperature-low',
        'title' => 'Service Kulkas',
        'slug' => 'service-kulkas',
        'desc' => 'Perbaikan kulkas tidak dingin, isi freon, ganti komponen',
        'details' => 'Service kulkas 1 pintu, 2 pintu, side by side, showcase'
    ],
    [
        'icon' => 'fa-pump-soap',
        'title' => 'Service Pompa Air',
        'slug' => 'service-pompa-air',
        'desc' => 'Perbaikan pompa air mati, lemah, berisik, ganti sparepart',
        'details' => 'Service pompa air shimizu, sanyo, wasser, grundfos, semua merk'
    ],
    [
        'icon' => 'fa-soap',
        'title' => 'Service Mesin Cuci',
        'slug' => 'service-mesin-cuci',
        'desc' => 'Perbaikan mesin cuci error, tidak berputar, bocor',
        'details' => 'Service mesin cuci 1 tabung, 2 tabung, front loading, top loading'
    ],
    [
        'icon' => 'fa-plug',
        'title' => 'Instalasi Bongkar Pasang',
        'slug' => 'bongkar-pasang',
        'desc' => 'Bongkar pasang AC, pindah lokasi, instalasi baru',
        'details' => 'Jasa bongkar pasang AC lengkap dengan material dan garansi'
    ],
    [
        'icon' => 'fa-wrench',
        'title' => 'Service Water Heater',
        'slug' => 'service-water-heater',
        'desc' => 'Perbaikan water heater listrik, gas, tidak panas',
        'details' => 'Service water heater Ariston, Rinnai, Modena, Wika, semua merk'
    ],
    [
        'icon' => 'fa-wind',
        'title' => 'Service Dispenser',
        'slug' => 'service-dispenser',
        'desc' => 'Perbaikan dispenser tidak panas/dingin, bocor, rusak',
        'details' => 'Service dispenser galon atas, bawah, semua tipe dan merk'
    ],
    [
        'icon' => 'fa-blender',
        'title' => 'Service Alat Dapur',
        'slug' => 'service-alat-dapur',
        'desc' => 'Kompor gas, oven, microwave, rice cooker, blender',
        'details' => 'Service berbagai alat elektronik dapur dan rumah tangga'
    ],
    [
        'icon' => 'fa-tv',
        'title' => 'Service TV & Elektronik',
        'slug' => 'service-tv',
        'desc' => 'Perbaikan TV LED, LCD, Smart TV, home theater',
        'details' => 'Service TV tidak ada gambar, suara, rusak panel'
    ],
    [
        'icon' => 'fa-snowflake',
        'title' => 'Isi Freon AC & Kulkas',
        'slug' => 'isi-freon',
        'desc' => 'Pengisian freon R22, R32, R410A untuk AC dan kulkas',
        'details' => 'Isi freon dengan tekanan tepat dan freon original'
    ],
    [
        'icon' => 'fa-tools',
        'title' => 'Service Panggilan',
        'slug' => 'service-panggilan',
        'desc' => 'Teknisi datang ke lokasi Anda dengan peralatan lengkap',
        'details' => 'Layanan service panggilan untuk area Jakarta dan Bekasi'
    ]
];

// Template index.php untuk setiap lokasi
function getTemplate($nama_lokasi, $slug_lokasi, $wilayah, $keunikan, $karakteristik, $services) {
    $whatsapp = "6281381473461";
    
    $artikel_intro = "Melayani warga <strong>$nama_lokasi, $wilayah</strong> dengan layanan service elektronik profesional dan terpercaya. Sebagai <em>$keunikan</em>, kami memahami kebutuhan masyarakat di area ini yang memerlukan teknisi handal untuk <strong>service AC, kulkas, pompa air, mesin cuci, dan elektronik lainnya</strong>. Tim kami siap datang ke lokasi Anda dengan peralatan lengkap dan harga transparan.";
    
    $artikel_konten = "$karakteristik. Untuk mendukung kenyamanan hidup Anda, <strong>Mitra Jaya Teknik</strong> hadir sebagai solusi terpercaya untuk semua kebutuhan perawatan dan perbaikan elektronik rumah tangga. Dari <em>cuci AC rutin</em>, <em>isi freon kulkas</em>, <em>perbaikan pompa air</em>, <em>service mesin cuci</em>, hingga <em>instalasi bongkar pasang AC</em> – kami siap melayani dengan profesional. Hubungi kami sekarang untuk konsultasi gratis dan dapatkan teknisi berpengalaman yang datang langsung ke rumah Anda di $nama_lokasi!";
    
    // Generate service cards HTML
    $services_html = '';
    foreach ($services as $service) {
        $services_html .= <<<HTML
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon">
                            <i class="fas {$service['icon']}"></i>
                        </div>
                        <h4>{$service['title']}</h4>
                        <p class="mb-2">{$service['desc']}</p>
                        <small class="text-muted">{$service['details']}</small>
                    </div>
                </div>
HTML;
    }
    
    // Generate price list
    $price_items = [
        ['service' => 'Cuci AC 1/2 - 1 PK', 'price' => '60.000 - 80.000'],
        ['service' => 'Cuci AC 1.5 - 2 PK', 'price' => '100.000 - 150.000'],
        ['service' => 'Service AC Tidak Dingin', 'price' => '150.000 - 300.000'],
        ['service' => 'Isi Freon AC R32/R410A', 'price' => '400.000 - 600.000'],
        ['service' => 'Bongkar Pasang AC', 'price' => '250.000 - 500.000'],
        ['service' => 'Service Kulkas', 'price' => '150.000 - 350.000'],
        ['service' => 'Service Pompa Air', 'price' => '150.000 - 300.000'],
        ['service' => 'Service Mesin Cuci', 'price' => '150.000 - 300.000']
    ];
    
    $price_html = '';
    foreach ($price_items as $item) {
        $price_html .= <<<HTML
                        <tr>
                            <td class="text-start">{$item['service']}</td>
                            <td class="text-end"><strong>Rp {$item['price']}</strong></td>
                        </tr>
HTML;
    }
    
    return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service AC $nama_lokasi - Cuci AC, Kulkas, Pompa Air | Mitra Jaya Teknik</title>
    <meta name="description" content="Service AC $nama_lokasi $wilayah ✓ Cuci AC ✓ Service Kulkas ✓ Pompa Air ✓ Mesin Cuci ✓ Bongkar Pasang ✓ Teknisi profesional, harga terjangkau, garansi. Hubungi: 0813-8147-3461">
    <meta name="keywords" content="service ac $nama_lokasi, cuci ac $wilayah, service kulkas $nama_lokasi, pompa air $nama_lokasi, teknisi ac $wilayah, bongkar pasang ac $nama_lokasi, service mesin cuci $wilayah">
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
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }
        
        .navbar-brand {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--primary) !important;
        }
        
        .navbar-brand i {
            color: var(--accent);
        }
        
        .nav-link {
            color: var(--dark) !important;
            font-weight: 500;
            margin: 0 10px;
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
        
        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 30px;
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
        }
        
        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        
        section {
            padding: 80px 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 50px;
            position: relative;
            padding-bottom: 20px;
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
            padding: 30px 20px;
            text-align: center;
            border: 2px solid var(--light);
            transition: all 0.4s ease;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 102, 204, 0.3);
            border-color: var(--primary);
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, var(--light) 0%, #e3f2fd 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .service-icon i {
            font-size: 2rem;
            color: var(--primary);
        }
        
        .service-card h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
        }
        
        .service-card p {
            font-size: 0.9rem;
            color: #666;
        }
        
        .price-table {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .price-table table {
            margin-bottom: 0;
        }
        
        .price-table th {
            background: var(--primary);
            color: white;
            padding: 15px;
        }
        
        .price-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
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
        }
        
        footer a:hover {
            color: white;
        }
        
        .wa-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
        
        .wa-float a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: #25D366;
            color: white;
            border-radius: 50%;
            font-size: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            transition: all 0.3s;
        }
        
        .wa-float a:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../">
                <i class="fas fa-fan"></i> Mitra Jaya Teknik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#harga">Harga</a></li>
                    <li class="nav-item"><a class="nav-link" href="#keunggulan">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link" href="../#lokasi">Lokasi Lain</a></li>
                </ul>
                <a href="https://wa.me/$whatsapp?text=Halo, saya dari $nama_lokasi ingin konsultasi service elektronik" class="btn btn-cta ms-3">
                    <i class="fas fa-phone"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </nav>

    <section id="home" class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1>Service AC $nama_lokasi - $wilayah</h1>
                    <p>Teknisi Profesional untuk Service AC, Kulkas, Pompa Air, Mesin Cuci & Elektronik Lainnya di $nama_lokasi. Harga Terjangkau, Garansi Terpercaya, Buka 24 Jam</p>
                    <a href="https://wa.me/$whatsapp?text=Halo, saya dari $nama_lokasi ingin konsultasi service" class="btn btn-hero">
                        <i class="fas fa-phone"></i> Konsultasi Gratis Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan">
        <div class="container">
            <h2 class="text-center section-title">Layanan Lengkap Kami di $nama_lokasi</h2>
            <div class="row">
$services_html
            </div>
        </div>
    </section>

    <section id="harga" class="bg-light">
        <div class="container">
            <h2 class="text-center section-title">Daftar Harga Service</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="price-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Jenis Layanan</th>
                                    <th class="text-end">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
$price_html
                            </tbody>
                        </table>
                        <div class="text-center mt-4">
                            <p class="text-muted mb-3"><small>*Harga dapat berubah tergantung kondisi dan kerusakan</small></p>
                            <a href="https://wa.me/$whatsapp?text=Halo, saya mau tanya harga service di $nama_lokasi" class="btn btn-cta">
                                <i class="fab fa-whatsapp"></i> Tanya Harga Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="keunggulan">
        <div class="container">
            <h2 class="text-center section-title">Mengapa Pilih Kami?</h2>
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <p class="lead text-center mb-5">$artikel_intro</p>
                    <p class="text-center mb-5">$artikel_konten</p>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3"><i class="fas fa-check-circle fa-2x" style="color: var(--primary)"></i></div>
                                <div>
                                    <h5>Teknisi Bersertifikat</h5>
                                    <p class="text-muted">Tim profesional dengan pengalaman puluhan tahun di bidang elektronik</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3"><i class="fas fa-check-circle fa-2x" style="color: var(--primary)"></i></div>
                                <div>
                                    <h5>Harga Transparan</h5>
                                    <p class="text-muted">Tanpa biaya tersembunyi, konsultasi dan survey gratis</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3"><i class="fas fa-check-circle fa-2x" style="color: var(--primary)"></i></div>
                                <div>
                                    <h5>Garansi Terpercaya</h5>
                                    <p class="text-muted">Bergaransi untuk semua pekerjaan service dan sparepart</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3"><i class="fas fa-check-circle fa-2x" style="color: var(--primary)"></i></div>
                                <div>
                                    <h5>Buka 24 Jam</h5>
                                    <p class="text-muted">Siap melayani kapan saja Anda butuhkan, termasuk hari libur</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3"><i class="fas fa-check-circle fa-2x" style="color: var(--primary)"></i></div>
                                <div>
                                    <h5>Sparepart Original</h5>
                                    <p class="text-muted">Menggunakan sparepart original dan berkualitas tinggi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="me-3"><i class="fas fa-check-circle fa-2x" style="color: var(--primary)"></i></div>
                                <div>
                                    <h5>Pelayanan Cepat</h5>
                                    <p class="text-muted">Respon cepat dan teknisi siap datang ke lokasi Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-5">
                        <a href="https://wa.me/$whatsapp?text=Halo, saya dari $nama_lokasi ingin pesan service" class="btn btn-cta btn-lg">
                            <i class="fab fa-whatsapp"></i> Hubungi Kami: 0813-8147-3461
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="area" class="bg-light">
        <div class="container">
            <h2 class="text-center section-title">Area Layanan di $nama_lokasi</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <p class="lead mb-4">Kami melayani seluruh area <strong>$nama_lokasi, $wilayah</strong> dan sekitarnya:</p>
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="p-3 bg-white rounded">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                                <p class="mb-0 mt-2">Perumahan</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="p-3 bg-white rounded">
                                <i class="fas fa-building text-primary"></i>
                                <p class="mb-0 mt-2">Apartemen</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="p-3 bg-white rounded">
                                <i class="fas fa-store text-primary"></i>
                                <p class="mb-0 mt-2">Ruko & Toko</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="p-3 bg-white rounded">
                                <i class="fas fa-briefcase text-primary"></i>
                                <p class="mb-0 mt-2">Kantor</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="p-3 bg-white rounded">
                                <i class="fas fa-hospital text-primary"></i>
                                <p class="mb-0 mt-2">Klinik</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="p-3 bg-white rounded">
                                <i class="fas fa-school text-primary"></i>
                                <p class="mb-0 mt-2">Sekolah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="fas fa-fan"></i> Mitra Jaya Teknik</h5>
                    <p>Service Elektronik Profesional dan Terpercaya di $wilayah</p>
                    <p class="mb-1"><i class="fas fa-map-marker-alt"></i> Melayani: $nama_lokasi</p>
                    <p class="mb-1"><i class="fas fa-clock"></i> Buka: 24 Jam</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Layanan Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#layanan">Service AC</a></li>
                        <li class="mb-2"><a href="#layanan">Cuci AC</a></li>
                        <li class="mb-2"><a href="#layanan">Service Kulkas</a></li>
                        <li class="mb-2"><a href="#layanan">Service Pompa Air</a></li>
                        <li class="mb-2"><a href="#layanan">Service Mesin Cuci</a></li>
                        <li class="mb-2"><a href="#layanan">Bongkar Pasang AC</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Hubungi Kami</h5>
                    <p class="mb-2"><i class="fab fa-whatsapp"></i> WhatsApp: <a href="https://wa.me/$whatsapp">0813-8147-3461</a></p>
                    <p class="mb-3">Konsultasi Gratis - Survey Gratis</p>
                    <a href="https://wa.me/$whatsapp?text=Halo, saya dari $nama_lokasi" class="btn btn-cta">
                        <i class="fab fa-whatsapp"></i> Chat WhatsApp
                    </a>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2)">
            <div class="text-center">
                <p class="mb-0">&copy; 2024 Mitra Jaya Teknik - Service Elektronik $nama_lokasi. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <div class="wa-float">
        <a href="https://wa.me/$whatsapp?text=Halo, saya dari $nama_lokasi ingin konsultasi" target="_blank" title="Chat WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
HTML;
}

// Proses generate
echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Generator 25 Lokasi Service Elektronik - Enhanced</title>";
echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>";
echo "<style>
body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
.main-card { background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
.progress-bar { transition: width 0.3s ease; }
</style>";
echo "</head><body>";
echo "<div class='container py-5'>";
echo "<div class='main-card p-5'>";
echo "<h1 class='text-center mb-2' style='color: #667eea'><i class='fas fa-cog fa-spin'></i> Enhanced Generator</h1>";
echo "<h4 class='text-center mb-4 text-muted'>25 Lokasi Service Elektronik - 12 Layanan Lengkap</h4>";
echo "<div class='alert alert-info mb-4'><strong>🎯 Target:</strong> Membuat 25 folder dan file index.php untuk Jakarta & Bekasi dengan 12 jenis layanan</div>";

echo "<div class='mb-4'>";
echo "<h5>Progress Generate:</h5>";
echo "<div class='progress' style='height: 30px'>";
echo "<div class='progress-bar progress-bar-striped progress-bar-animated bg-success' role='progressbar' style='width: 0%' id='progressBar'>";
echo "<span id='progressText'>0%</span>";
echo "</div></div></div>";

echo "<hr>";

$success = 0;
$failed = 0;
$logs = [];
$total = count($lokasi_list);

foreach ($lokasi_list as $index => $lok) {
    $folder = $lok['slug'];
    $nama = $lok['nama'];
    $progress = round((($index + 1) / $total) * 100);
    
    $logs[] = "<div class='card mb-3 border-0 shadow-sm'>";
    $logs[] = "<div class='card-header' style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white'>";
    $logs[] = "<strong><i class='fas fa-map-marker-alt'></i> {$lok['wilayah']}</strong> - {$nama}";
    $logs[] = "</div>";
    $logs[] = "<div class='card-body'>";
    
    // Buat folder
    if (!file_exists($folder)) {
        if (mkdir($folder, 0755, true)) {
            $logs[] = "<p class='text-success mb-2'><i class='fas fa-check-circle'></i> ✓ Folder <code>{$folder}</code> berhasil dibuat</p>";
        } else {
            $logs[] = "<p class='text-danger mb-2'><i class='fas fa-times-circle'></i> ✗ Gagal membuat folder <code>{$folder}</code></p>";
            $logs[] = "</div></div>";
            $failed++;
            continue;
        }
    } else {
        $logs[] = "<p class='text-warning mb-2'><i class='fas fa-info-circle'></i> ⚠ Folder <code>{$folder}</code> sudah ada</p>";
    }
    
    // Buat file index.php
    $filepath = $folder . '/index.php';
    $content = getTemplate($lok['nama'], $lok['slug'], $lok['wilayah'], $lok['keunikan'], $lok['karakteristik'], $services);
    
    if (file_put_contents($filepath, $content)) {
        $filesize = round(filesize($filepath) / 1024, 2);
        $logs[] = "<p class='text-success mb-2'><i class='fas fa-check-circle'></i> ✓ File <code>{$filepath}</code> berhasil dibuat ({$filesize} KB)</p>";
        $logs[] = "<p class='text-muted mb-0'><small>📦 Berisi: 12 layanan, tabel harga, area layanan, WhatsApp float button</small></p>";
        $success++;
    } else {
        $logs[] = "<p class='text-danger mb-2'><i class='fas fa-times-circle'></i> ✗ Gagal membuat file <code>{$filepath}</code></p>";
        $failed++;
    }
    
    $logs[] = "</div></div>";
    
    // Update progress bar dengan JavaScript
    echo "<script>
        document.getElementById('progressBar').style.width = '{$progress}%';
        document.getElementById('progressText').textContent = '{$progress}%';
    </script>";
    flush();
    ob_flush();
}

// Tampilkan logs
echo "<div id='logs'>";
foreach($logs as $log) {
    echo $log;
}
echo "</div>";

// Summary
echo "<div class='card border-0 shadow-lg mt-5' style='border-left: 5px solid #667eea !important'>";
echo "<div class='card-header' style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white'>";
echo "<h4 class='mb-0'><i class='fas fa-chart-pie'></i> Hasil Generate</h4>";
echo "</div>";
echo "<div class='card-body p-4'>";
echo "<div class='row text-center mb-4'>";
echo "<div class='col-md-4'><div class='p-4 bg-success bg-opacity-10 rounded'><h2 style='color: #28a745; font-size: 3rem'>{$success}</h2><p class='mb-0'><strong>✓ Berhasil</strong></p></div></div>";
echo "<div class='col-md-4'><div class='p-4 bg-danger bg-opacity-10 rounded'><h2 style='color: #dc3545; font-size: 3rem'>{$failed}</h2><p class='mb-0'><strong>✗ Gagal</strong></p></div></div>";
echo "<div class='col-md-4'><div class='p-4 bg-primary bg-opacity-10 rounded'><h2 style='color: #667eea; font-size: 3rem'>" . count($lokasi_list) . "</h2><p class='mb-0'><strong>📍 Total</strong></p></div></div>";
echo "</div>";
echo "</div></div>";

if ($success > 0) {
    echo "<div class='alert alert-success mt-4 shadow-sm'>";
    echo "<h4><i class='fas fa-check-circle'></i> Generate Selesai!</h4>";
    echo "<p class='mb-3'><strong>$success dari " . count($lokasi_list) . " lokasi berhasil digenerate dengan 12 layanan lengkap!</strong></p>";
    
    echo "<div class='row g-3 mb-3'>";
    echo "<div class='col-md-3 text-center'><div class='p-3 bg-white rounded'><i class='fas fa-fan fa-2x text-primary mb-2'></i><p class='mb-0'><small>Service AC</small></p></div></div>";
    echo "<div class='col-md-3 text-center'><div class='p-3 bg-white rounded'><i class='fas fa-broom fa-2x text-primary mb-2'></i><p class='mb-0'><small>Cuci AC</small></p></div></div>";
    echo "<div class='col-md-3 text-center'><div class='p-3 bg-white rounded'><i class='fas fa-temperature-low fa-2x text-primary mb-2'></i><p class='mb-0'><small>Service Kulkas</small></p></div></div>";
    echo "<div class='col-md-3 text-center'><div class='p-3 bg-white rounded'><i class='fas fa-pump-soap fa-2x text-primary mb-2'></i><p class='mb-0'><small>Pompa Air</small></p></div></div>";
    echo "</div>";
    
    echo "<p><strong>📋 Akses halaman per lokasi:</strong></p>";
    
    // Group by wilayah
    $grouped = [];
    foreach ($lokasi_list as $lok) {
        $grouped[$lok['wilayah']][] = $lok;
    }
    
    echo "<div class='row'>";
    foreach($grouped as $wilayah => $loks) {
        echo "<div class='col-md-6 mb-4'>";
        echo "<div class='card border-0 shadow-sm'>";
        echo "<div class='card-header' style='background: #f8f9fa'>";
        echo "<h5 class='mb-0' style='color: #667eea'><i class='fas fa-map-marker-alt'></i> $wilayah</h5>";
        echo "</div>";
        echo "<div class='card-body'>";
        echo "<div class='list-group list-group-flush'>";
        foreach($loks as $lok) {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $lok['slug'] . '/';
            echo "<a href='{$url}' target='_blank' class='list-group-item list-group-item-action'>";
            echo "<i class='fas fa-external-link-alt text-primary'></i> {$lok['nama']}";
            echo "</a>";
        }
        echo "</div></div></div></div>";
    }
    echo "</div>";
    
    echo "<hr class='my-4'>";
    echo "<div class='alert alert-warning mb-0'>";
    echo "<h5><i class='fas fa-exclamation-triangle'></i> Langkah Selanjutnya:</h5>";
    echo "<ol class='mb-0'>";
    echo "<li>✅ Pastikan folder <code>assets/images</code> sudah ada di root website</li>";
    echo "<li>✅ Update file website utama untuk menambahkan link ke 25 lokasi</li>";
    echo "<li>✅ Test setiap halaman untuk memastikan tampil dengan baik</li>";
    echo "<li>✅ Submit sitemap-locations.xml ke Google Search Console</li>";
    echo "<li><strong class='text-danger'>🔥 PENTING: Hapus file generator ini untuk keamanan!</strong></li>";
    echo "</ol>";
    echo "</div>";
    echo "</div>";
    
    // Buat sitemap
    $sitemap = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    $sitemap .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
    
    foreach($lokasi_list as $lok) {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/' . $lok['slug'] . '/';
        $sitemap .= "  <url>\n";
        $sitemap .= "    <loc>" . htmlspecialchars($url) . "</loc>\n";
        $sitemap .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
        $sitemap .= "    <changefreq>weekly</changefreq>\n";
        $sitemap .= "    <priority>0.8</priority>\n";
        $sitemap .= "  </url>\n";
    }
    
    $sitemap .= "</urlset>";
    
    if (file_put_contents('sitemap-locations.xml', $sitemap)) {
        echo "<div class='alert alert-info mt-4'>";
        echo "<i class='fas fa-sitemap'></i> <strong>Bonus SEO:</strong> File <code>sitemap-locations.xml</code> telah dibuat!";
        echo "<p class='mb-0 mt-2'><small>Submit file ini ke Google Search Console untuk indexing lebih cepat</small></p>";
        echo "</div>";
    }
}

echo "</div></div></body></html>";
?>