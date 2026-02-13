<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDN - Masjid Digital Network | Platform Digital Terpadu untuk Masjid Indonesia</title>
    <meta name="description" content="Masjid Digital Network (MDN) adalah platform layanan digital terpadu untuk transformasi masjid ke era digital. Kelola kas, jadwal, pengumuman, dan layanan jamaah dalam satu sistem terintegrasi.">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <div class="logo-icon">
                        <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M25 5L5 15V25C5 35 15 43 25 45C35 43 45 35 45 25V15L25 5Z" fill="currentColor"/>
                            <path d="M25 15L20 18V35H30V18L25 15Z" fill="white"/>
                            <circle cx="25" cy="12" r="3" fill="white"/>
                        </svg>
                    </div>
                    <span class="logo-text">MDN</span>
                </div>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="#beranda" class="nav-link">Beranda</a></li>
                    <li><a href="#tentang" class="nav-link">Tentang</a></li>
                    <li><a href="#fitur" class="nav-link">Fitur</a></li>
                    <li><a href="#layanan" class="nav-link">Layanan</a></li>
                    <li><a href="#kontak" class="nav-link">Kontak</a></li>
                </ul>
                <div class="nav-actions">
                    <a href="#daftar" class="btn btn-primary">Daftar Sekarang</a>
                    <button class="menu-toggle" id="menuToggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="hero-bg">
            <div class="hero-pattern"></div>
            <div class="hero-gradient"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <span class="title-line">Dari Jamaah,</span>
                        <span class="title-line">Untuk Jamaah</span>
                    </h1>
                    <p class="hero-subtitle">Digitalisasi Masjid yang Aman dan Transparan</p>
                    <p class="hero-description">
                        Masjid Digital Network (MDN) adalah platform layanan digital terpadu yang menghubungkan 
                        teknologi modern dengan kebutuhan manajemen masjid di seluruh Indonesia.
                    </p>
                    <div class="hero-buttons">
                        <a href="#daftar" class="btn btn-hero-primary">Mulai Sekarang</a>
                        <a href="#tentang" class="btn btn-hero-secondary">Pelajari Lebih Lanjut</a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-number">1000+</div>
                            <div class="stat-label">Masjid Terdaftar</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">50K+</div>
                            <div class="stat-label">Jamaah Aktif</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">99.9%</div>
                            <div class="stat-label">Uptime Server</div>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="mosque-illustration">
                        <div class="mosque-glow"></div>
                        <svg viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Masjid Illustration -->
                            <defs>
                                <linearGradient id="mosqueGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#1a5f3f;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#0d3d28;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <!-- Main Dome -->
                            <ellipse cx="200" cy="150" rx="80" ry="60" fill="url(#mosqueGrad)"/>
                            <circle cx="200" cy="90" r="15" fill="#d4af37"/>
                            <rect x="197" y="70" width="6" height="40" fill="#d4af37"/>
                            <!-- Building -->
                            <rect x="120" y="200" width="160" height="150" fill="url(#mosqueGrad)" rx="5"/>
                            <!-- Minarets -->
                            <rect x="90" y="180" width="30" height="170" fill="url(#mosqueGrad)" rx="3"/>
                            <rect x="280" y="180" width="30" height="170" fill="url(#mosqueGrad)" rx="3"/>
                            <circle cx="105" cy="170" r="12" fill="#d4af37"/>
                            <circle cx="295" cy="170" r="12" fill="#d4af37"/>
                            <!-- Windows -->
                            <rect x="150" y="230" width="30" height="40" fill="#d4af37" opacity="0.3" rx="15"/>
                            <rect x="220" y="230" width="30" height="40" fill="#d4af37" opacity="0.3" rx="15"/>
                            <rect x="185" y="290" width="30" height="50" fill="#d4af37" opacity="0.5" rx="3"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="tentang">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Apa Itu <span class="highlight">MDN</span>?</h2>
            </div>
            <div class="about-content">
                <div class="about-logo">
                    <div class="logo-large">
                        <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="100" cy="100" r="90" fill="#1a5f3f" opacity="0.1"/>
                            <path d="M100 30L40 60V100C40 130 70 155 100 160C130 155 160 130 160 100V60L100 30Z" fill="#1a5f3f"/>
                            <path d="M100 60L80 72V130H120V72L100 60Z" fill="white"/>
                            <circle cx="100" cy="50" r="8" fill="#d4af37"/>
                        </svg>
                    </div>
                </div>
                <div class="about-text">
                    <p class="about-description">
                        <strong>Masjid Digital Network (MDN)</strong> adalah platform layanan digital terpadu yang dirancang khusus 
                        untuk membantu masjid bertransformasi ke era digital. MDN menghubungkan teknologi modern dengan 
                        kebutuhan manajemen masjid, sehingga pengelolaan administrasi, informasi, dan layanan jamaah 
                        menjadi lebih mudah, transparan, dan profesional.
                    </p>
                    <p class="about-description">
                        Melalui MDN, masjid dapat mengelola <strong>kas dan keuangan</strong>, <strong>jadwal sholat & kegiatan</strong>, 
                        <strong>pengumuman digital</strong>, hingga <strong>layanan jamaah berbasis online</strong> dalam satu sistem terintegrasi.
                    </p>
                    <p class="about-description">
                        Platform ini hadir sebagai solusi bagi DKM dan pengurus masjid agar fokus pada kemakmuran masjid 
                        tanpa terbebani urusan teknis. MDN tidak hanya menyediakan sistem, tetapi juga jaringan layanan 
                        digital yang mendukung kebutuhan masjid masa kini.
                    </p>
                    <div class="about-highlight">
                        <div class="highlight-icon">✨</div>
                        <div class="highlight-text">
                            Dengan <strong>MDN – Masjid Digital Network</strong>, masjid menjadi lebih informatif, 
                            akuntabel, dan dekat dengan jamaah melalui teknologi.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="fitur">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Fitur Unggulan</h2>
                <p class="section-subtitle">
                    Dengan MDN, pengelolaan keuangan masjid menjadi lebih efektif dan transparan, 
                    berkat keunggulan-keunggulan berikut:
                </p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="30" r="25" fill="#1a5f3f" opacity="0.1"/>
                            <path d="M30 10C18.95 10 10 18.95 10 30C10 41.05 18.95 50 30 50C41.05 50 50 41.05 50 30C50 18.95 41.05 10 30 10ZM30 45C21.73 45 15 38.27 15 30C15 21.73 21.73 15 30 15C38.27 15 45 21.73 45 30C45 38.27 38.27 45 30 45Z" fill="#1a5f3f"/>
                            <path d="M35 25L27.5 32.5L25 30" stroke="#d4af37" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Akses Kapan Saja</h3>
                    <p class="feature-description">
                        Bisa digunakan dari mana saja dan kapan saja selama terhubung ke internet.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="30" r="25" fill="#1a5f3f" opacity="0.1"/>
                            <rect x="15" y="20" width="30" height="25" rx="2" stroke="#1a5f3f" stroke-width="2.5" fill="none"/>
                            <path d="M20 15H40V20H20V15Z" fill="#d4af37"/>
                            <line x1="20" y1="28" x2="40" y2="28" stroke="#1a5f3f" stroke-width="2"/>
                            <line x1="20" y1="33" x2="35" y2="33" stroke="#1a5f3f" stroke-width="2"/>
                            <line x1="20" y1="38" x2="32" y2="38" stroke="#1a5f3f" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Data Terpisah & Terlindungi</h3>
                    <p class="feature-description">
                        Setiap masjid memiliki data yang terpisah dan terlindungi dengan sistem keamanan tingkat tinggi.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="30" r="25" fill="#1a5f3f" opacity="0.1"/>
                            <path d="M25 20C25 17.24 27.24 15 30 15C32.76 15 35 17.24 35 20C35 22.76 32.76 25 30 25C27.24 25 25 22.76 25 20Z" fill="#1a5f3f"/>
                            <path d="M20 35C20 31.13 23.13 28 27 28H33C36.87 28 40 31.13 40 35V42C40 43.1 39.1 44 38 44H22C20.9 44 20 43.1 20 42V35Z" fill="#d4af37"/>
                            <circle cx="15" cy="25" r="3" fill="#1a5f3f" opacity="0.5"/>
                            <circle cx="45" cy="25" r="3" fill="#1a5f3f" opacity="0.5"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Bukan untuk Akuntan</h3>
                    <p class="feature-description">
                        Dirancang ramah pengguna, bahkan untuk takmir atau pengurus yang bukan ahli akuntansi.
                    </p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="30" cy="30" r="25" fill="#1a5f3f" opacity="0.1"/>
                            <rect x="15" y="18" width="30" height="24" rx="2" stroke="#1a5f3f" stroke-width="2.5" fill="none"/>
                            <path d="M15 24H45" stroke="#1a5f3f" stroke-width="2.5"/>
                            <circle cx="22" cy="32" r="2" fill="#d4af37"/>
                            <circle cx="30" cy="32" r="2" fill="#d4af37"/>
                            <circle cx="38" cy="32" r="2" fill="#d4af37"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Laporan Jelas & Akurat</h3>
                    <p class="feature-description">
                        Memudahkan penyusunan laporan yang jelas dan akurat bagi jamaah maupun auditor.
                    </p>
                </div>
            </div>

            <!-- Illustration Section -->
            <div class="features-illustration">
                <div class="illustration-card">
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us Section -->
    <section class="why-us">
        <div class="container">
            <div class="why-us-content">
                <div class="why-us-main">
                    <h2 class="why-us-title">Kenapa Harus MDN?</h2>
                    <p class="why-us-description">
                        <strong>MDN</strong> adalah solusi modern untuk pengelolaan keuangan masjid yang lebih aman, 
                        efisien, dan transparan dibanding metode manual. Dengan teknologi berbasis web, semua data 
                        keuangan dapat diakses kapan saja dan di mana saja, sehingga memudahkan pengurus dalam 
                        memantau pemasukan dan pengeluaran.
                    </p>
                    <p class="why-us-description">
                        Pencatatan menjadi lebih cepat, perhitungan otomatis mengurangi risiko kesalahan, dan 
                        laporan dapat disajikan secara jelas kepada jamaah, menciptakan kepercayaan serta 
                        keterbukaan yang lebih tinggi.
                    </p>
                </div>
                <div class="why-us-cards">
                    <div class="why-card">
                        <div class="why-card-icon">
                            <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="25" cy="25" r="20" fill="#1a5f3f" opacity="0.1"/>
                                <path d="M25 10L15 18V32C15 37 20 41 25 42C30 41 35 37 35 32V18L25 10Z" stroke="#1a5f3f" stroke-width="2.5" fill="none"/>
                                <path d="M20 25L23 28L30 21" stroke="#d4af37" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="why-card-title">Akses Keamanan Maksimal</h3>
                        <p class="why-card-description">
                            Data tersimpan aman di server dan bisa diakses secara real-time dari berbagai perangkat.
                        </p>
                    </div>
                    <div class="why-card">
                        <div class="why-card-icon">
                            <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="25" cy="25" r="20" fill="#1a5f3f" opacity="0.1"/>
                                <rect x="15" y="18" width="20" height="20" rx="2" stroke="#1a5f3f" stroke-width="2.5" fill="none"/>
                                <path d="M15 24H35" stroke="#1a5f3f" stroke-width="2.5"/>
                                <path d="M20 30H30" stroke="#d4af37" stroke-width="2" stroke-linecap="round"/>
                                <path d="M20 33H28" stroke="#d4af37" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3 class="why-card-title">Transparansi dan Efisiensi</h3>
                        <p class="why-card-description">
                            <span class="badge-highlight">Laporan keuangan tersaji</span> rapi dan akurat, memudahkan 
                            pelaporan kepada jamaah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="layanan">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Layanan yang Tersedia di <span class="highlight">MDN</span></h2>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-image">
                        <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="400" height="300" fill="#f8f9fa"/>
                            <rect x="50" y="50" width="300" height="200" rx="10" fill="white" stroke="#e0e0e0" stroke-width="2"/>
                            <circle cx="100" cy="90" r="20" fill="#1a5f3f" opacity="0.2"/>
                            <rect x="80" y="130" width="240" height="15" rx="7" fill="#1a5f3f" opacity="0.1"/>
                            <rect x="80" y="160" width="200" height="12" rx="6" fill="#1a5f3f" opacity="0.1"/>
                            <rect x="80" y="185" width="220" height="12" rx="6" fill="#1a5f3f" opacity="0.1"/>
                            <path d="M200 50L180 30L220 30L200 50Z" fill="#d4af37"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Website Masjid</h3>
                    <p class="service-description">
                        Platform informasi online untuk masjid dengan desain modern dan responsif, 
                        memudahkan jamaah mengakses informasi jadwal, kegiatan, dan pengumuman.
                    </p>
                </div>
                <div class="service-card">
                    <div class="service-image">
                        <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="400" height="300" fill="#f8f9fa"/>
                            <rect x="50" y="50" width="300" height="200" rx="10" fill="white" stroke="#e0e0e0" stroke-width="2"/>
                            <rect x="80" y="80" width="80" height="60" rx="5" fill="#1a5f3f" opacity="0.2"/>
                            <rect x="180" y="80" width="80" height="60" rx="5" fill="#d4af37" opacity="0.2"/>
                            <rect x="280" y="80" width="50" height="60" rx="5" fill="#1a5f3f" opacity="0.1"/>
                            <rect x="80" y="160" width="120" height="60" rx="5" fill="#d4af37" opacity="0.1"/>
                            <rect x="220" y="160" width="110" height="60" rx="5" fill="#1a5f3f" opacity="0.15"/>
                        </svg>
                    </div>
                    <h3 class="service-title">Aplikasi Manajemen Masjid</h3>
                    <p class="service-description">
                        Sistem manajemen terintegrasi untuk mengelola kas, inventaris, jadwal kegiatan, 
                        dan administrasi masjid secara digital dan efisien.
                    </p>
                </div>
                <div class="service-card">
                    <div class="service-image">
                        <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="400" height="300" fill="#f8f9fa"/>
                            <rect x="50" y="50" width="300" height="200" rx="10" fill="white" stroke="#e0e0e0" stroke-width="2"/>
                            <rect x="80" y="80" width="100" height="80" rx="8" fill="#1a5f3f" opacity="0.1" stroke="#1a5f3f" stroke-width="2"/>
                            <text x="130" y="125" font-family="Arial" font-size="20" fill="#1a5f3f" text-anchor="middle">SALE</text>
                            <rect x="200" y="80" width="100" height="80" rx="8" fill="#d4af37" opacity="0.1" stroke="#d4af37" stroke-width="2"/>
                            <circle cx="250" cy="120" r="25" fill="#d4af37" opacity="0.3"/>
                            <rect x="140" y="180" width="120" height="40" rx="20" fill="#1a5f3f"/>
                            <text x="200" y="205" font-family="Arial" font-size="14" fill="white" text-anchor="middle">BELI</text>
                        </svg>
                    </div>
                    <h3 class="service-title">Marketplace Masjid</h3>
                    <p class="service-description">
                        Platform jual beli produk islami dan kebutuhan masjid, menghubungkan jamaah dengan 
                        penjual terpercaya dalam satu ekosistem digital.
                    </p>
                </div>
                <div class="service-card">
                    <div class="service-image">
                        <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="400" height="300" fill="#f8f9fa"/>
                            <rect x="50" y="50" width="300" height="200" rx="10" fill="white" stroke="#e0e0e0" stroke-width="2"/>
                            <circle cx="120" cy="110" r="30" fill="#1a5f3f" opacity="0.2"/>
                            <path d="M120 95C115 95 110 100 110 105C110 112 120 120 120 120C120 120 130 112 130 105C130 100 125 95 120 95Z" fill="#1a5f3f"/>
                            <circle cx="200" cy="140" r="25" fill="#d4af37" opacity="0.2"/>
                            <rect x="195" y="125" width="10" height="30" fill="#d4af37"/>
                            <circle cx="280" cy="110" r="30" fill="#1a5f3f" opacity="0.15"/>
                            <path d="M270 110L280 100L290 110L280 120Z" fill="#1a5f3f"/>
                            <rect x="80" y="180" width="240" height="40" rx="20" fill="#1a5f3f"/>
                            <text x="200" y="205" font-family="Arial" font-size="16" fill="white" text-anchor="middle">Daftar Training</text>
                        </svg>
                    </div>
                    <h3 class="service-title">Pelatihan Masjid Go Digital</h3>
                    <p class="service-description">
                        Program pelatihan dan pendampingan untuk pengurus masjid dalam mengadopsi 
                        teknologi digital dan mengoptimalkan penggunaan sistem MDN.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="daftar">
        <div class="cta-bg">
            <div class="cta-pattern"></div>
        </div>
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Siap Membawa Masjid Anda ke Era Digital?</h2>
                <p class="cta-description">
                    Bergabunglah dengan ribuan masjid di Indonesia yang telah merasakan manfaat 
                    transformasi digital bersama MDN. Daftar sekarang dan dapatkan konsultasi gratis!
                </p>
                <div class="cta-buttons">
                    <a href="#" class="btn btn-cta-primary">Daftar Gratis</a>
                    <a href="#kontak" class="btn btn-cta-secondary">Hubungi Kami</a>
                </div>
                <div class="cta-trust">
                    <div class="trust-item">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L3 7V12C3 17 7 21 12 22C17 21 21 17 21 12V7L12 2Z" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Aman & Terpercaya</span>
                    </div>
                    <div class="trust-item">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>Support 24/7</span>
                    </div>
                    <div class="trust-item">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 7H4C2.9 7 2 7.9 2 9V19C2 20.1 2.9 21 4 21H20C21.1 21 22 20.1 22 19V9C22 7.9 21.1 7 20 7Z" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path d="M16 7V5C16 3.9 15.1 3 14 3H10C8.9 3 8 3.9 8 5V7" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <span>Gratis Trial</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="kontak">
        <div class="container">
            <div class="footer-content">
                <div class="footer-col">
                    <div class="footer-logo">
                        <div class="logo-icon">
                            <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M25 5L5 15V25C5 35 15 43 25 45C35 43 45 35 45 25V15L25 5Z" fill="currentColor"/>
                                <path d="M25 15L20 18V35H30V18L25 15Z" fill="white"/>
                                <circle cx="25" cy="12" r="3" fill="white"/>
                            </svg>
                        </div>
                        <span class="logo-text">MDN</span>
                    </div>
                    <p class="footer-description">
                        Platform digital terpadu untuk transformasi masjid Indonesia menuju era digital 
                        yang lebih modern, transparan, dan profesional.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="YouTube">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Layanan</h4>
                    <ul class="footer-links">
                        <li><a href="#layanan">Website Masjid</a></li>
                        <li><a href="#layanan">Aplikasi Manajemen</a></li>
                        <li><a href="#layanan">Marketplace</a></li>
                        <li><a href="#layanan">Pelatihan Digital</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Perusahaan</h4>
                    <ul class="footer-links">
                        <li><a href="#tentang">Tentang Kami</a></li>
                        <li><a href="#fitur">Fitur</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Karir</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4 class="footer-title">Kontak</h4>
                    <ul class="footer-contact">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>Jakarta, Indonesia</span>
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <span>info@mdn.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 MDN - Masjid Digital Network. Semua hak dilindungi.</p>
                <div class="footer-bottom-links">
                    <a href="#">Syarat & Ketentuan</a>
                    <a href="#">Kebijakan Privasi</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>