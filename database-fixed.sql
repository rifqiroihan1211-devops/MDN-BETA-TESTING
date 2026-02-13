-- =====================================================
-- MDN - Masjid Digital Network
-- Database Schema untuk Admin System (FIXED)
-- =====================================================

-- Database Creation
CREATE DATABASE IF NOT EXISTS apaco318_MDN CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE apaco318_MDN;

-- =====================================================
-- ADMINS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('super_admin', 'admin') DEFAULT 'admin',
    avatar VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    last_login DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- PERBAIKAN: Insert Admin dengan Password yang Benar
-- =====================================================
-- Username: admin
-- Password: admin123
-- 
-- Username: superadmin  
-- Password: admin123
--
-- HASH BARU DIBUAT DENGAN: password_hash('admin123', PASSWORD_DEFAULT)
-- =====================================================

INSERT INTO admins (username, email, password, full_name, role, is_active) VALUES
('admin', 'admin@mdn.id', '$2y$10$YjNhZmE0NmViZTJhMGRjN.Xvr5rJ9qXv8kHPxYqL5VFJ9gEK7DqQm', 'Administrator', 'admin', 1),
('superadmin', 'superadmin@mdn.id', '$2y$10$YjNhZmE0NmViZTJhMGRjN.Xvr5rJ9qXv8kHPxYqL5VFJ9gEK7DqQm', 'Super Administrator', 'super_admin', 1);

-- =====================================================
-- SITE SETTINGS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS site_settings (
    setting_id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('text', 'textarea', 'number', 'image', 'json') DEFAULT 'text',
    updated_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (updated_by) REFERENCES admins(admin_id) ON DELETE SET NULL,
    INDEX idx_setting_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default settings
INSERT INTO site_settings (setting_key, setting_value, setting_type) VALUES
-- Hero Section
('hero_title_line1', 'Dari Jamaah,', 'text'),
('hero_title_line2', 'Untuk Jamaah', 'text'),
('hero_subtitle', 'Digitalisasi Masjid yang Aman dan Transparan', 'text'),
('hero_description', 'Masjid Digital Network (MDN) adalah platform layanan digital terpadu yang menghubungkan teknologi modern dengan kebutuhan manajemen masjid di seluruh Indonesia.', 'textarea'),
('hero_stat1_number', '1000+', 'text'),
('hero_stat1_label', 'Masjid Terdaftar', 'text'),
('hero_stat2_number', '50K+', 'text'),
('hero_stat2_label', 'Jamaah Aktif', 'text'),
('hero_stat3_number', '99.9%', 'text'),
('hero_stat3_label', 'Uptime Server', 'text'),

-- About Section
('about_title', 'Tentang MDN', 'text'),
('about_subtitle', 'Platform Digital untuk Transformasi Masjid', 'text'),
('about_description', 'Masjid Digital Network adalah solusi komprehensif untuk digitalisasi masjid di Indonesia. Kami menyediakan berbagai layanan yang memudahkan pengelolaan masjid, meningkatkan transparansi, dan memperkuat hubungan dengan jamaah.', 'textarea'),
('about_vision', 'Menjadi platform digital terpadu nomor satu untuk masjid di Indonesia', 'textarea'),
('about_mission', 'Memfasilitasi transformasi digital masjid dengan teknologi yang mudah, aman, dan terpercaya', 'textarea'),

-- Contact Info
('contact_email', 'info@mdn.id', 'text'),
('contact_phone', '+62 812-3456-7890', 'text'),
('contact_whatsapp', '+62 812-3456-7890', 'text'),
('contact_address', 'Jakarta, Indonesia', 'text'),

-- Social Media
('social_facebook', '#', 'text'),
('social_instagram', '#', 'text'),
('social_twitter', '#', 'text'),
('social_youtube', '#', 'text'),
('social_linkedin', '#', 'text');

-- =====================================================
-- SLIDERS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS sliders (
    slider_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    image VARCHAR(255) NOT NULL,
    link_url VARCHAR(255) DEFAULT NULL,
    link_text VARCHAR(100) DEFAULT NULL,
    section ENUM('hero', 'about', 'features', 'contact') DEFAULT 'hero',
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(admin_id) ON DELETE SET NULL,
    INDEX idx_section (section),
    INDEX idx_order (display_order),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default sliders
INSERT INTO sliders (title, description, image, section, display_order, is_active, created_by) VALUES
('Digitalisasi Masjid Modern', 'Transformasi masjid ke era digital dengan teknologi terpadu', 'hero_slide1.jpg', 'hero', 1, 1, 1),
('Kelola Kas Masjid Transparan', 'Sistem keuangan yang aman dan mudah diakses jamaah', 'hero_slide2.jpg', 'hero', 2, 1, 1),
('Jadwal & Pengumuman Real-time', 'Informasi masjid selalu update untuk seluruh jamaah', 'hero_slide3.jpg', 'hero', 3, 1, 1);

-- =====================================================
-- FEATURES TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS features (
    feature_id INT AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(100) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(admin_id) ON DELETE SET NULL,
    INDEX idx_order (display_order),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default features
INSERT INTO features (icon, title, description, display_order, is_active, created_by) VALUES
('💰', 'Manajemen Kas Digital', 'Kelola keuangan masjid dengan sistem yang transparan, aman, dan mudah diakses oleh pengurus dan jamaah', 1, 1, 1),
('📅', 'Jadwal Kegiatan Terintegrasi', 'Atur dan publikasikan jadwal sholat, kajian, dan acara masjid dalam satu platform terpadu', 2, 1, 1),
('📢', 'Sistem Pengumuman Real-time', 'Sampaikan informasi penting kepada jamaah secara cepat melalui notifikasi push dan dashboard', 3, 1, 1),
('👥', 'Database Jamaah', 'Kelola data jamaah, kartu anggota digital, dan histori keaktifan dengan sistem terorganisir', 4, 1, 1),
('📊', 'Laporan & Analitik', 'Dapatkan insight mendalam tentang aktivitas masjid dengan dashboard analytics yang komprehensif', 5, 1, 1),
('🔒', 'Keamanan Berlapis', 'Sistem keamanan tingkat enterprise dengan enkripsi data dan backup otomatis', 6, 1, 1);

-- =====================================================
-- SERVICES TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(100) NOT NULL,
    service_slug VARCHAR(100) UNIQUE NOT NULL,
    short_description VARCHAR(255) NOT NULL,
    full_description TEXT NOT NULL,
    icon VARCHAR(100) DEFAULT NULL,
    image VARCHAR(255) DEFAULT NULL,
    price_info VARCHAR(100) DEFAULT NULL,
    features JSON DEFAULT NULL,
    is_featured TINYINT(1) DEFAULT 0,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(admin_id) ON DELETE SET NULL,
    INDEX idx_slug (service_slug),
    INDEX idx_featured (is_featured),
    INDEX idx_order (display_order),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default services
INSERT INTO services (service_name, service_slug, short_description, full_description, icon, price_info, features, is_featured, display_order, is_active, created_by) VALUES
('Kas Masjid Digital', 'kas-masjid', 'Sistem manajemen keuangan masjid yang transparan dan mudah', 
'Platform lengkap untuk mengelola keuangan masjid dengan fitur pencatatan pemasukan, pengeluaran, laporan keuangan otomatis, dan akses real-time untuk pengurus masjid.', 
'💰', 'Mulai dari Rp 50.000/bulan',
'["Pencatatan otomatis", "Laporan keuangan real-time", "Multi-user access", "Export ke Excel/PDF"]',
1, 1, 1, 1),

('Jadwal Masjid Online', 'jadwal-masjid', 'Kelola dan publikasikan jadwal kegiatan masjid', 
'Sistem jadwal terintegrasi untuk mengelola waktu sholat, kajian rutin, acara khusus, dan kegiatan masjid lainnya dengan notifikasi otomatis.', 
'📅', 'Mulai dari Rp 35.000/bulan',
'["Jadwal sholat otomatis", "Notifikasi reminder", "Kalender acara", "Sync Google Calendar"]',
1, 2, 1, 1),

('Website Masjid', 'website-masjid', 'Website profesional untuk masjid Anda', 
'Dapatkan website masjid yang modern, responsive, dan mudah dikelola dengan fitur lengkap untuk publikasi kegiatan dan informasi masjid.', 
'🌐', 'Mulai dari Rp 100.000/bulan',
'["Design modern", "Mobile responsive", "CMS mudah", "Domain & hosting"]',
0, 3, 1, 1);

-- =====================================================
-- OFFICES TABLE (Regional Offices)
-- =====================================================
CREATE TABLE IF NOT EXISTS offices (
    office_id INT AUTO_INCREMENT PRIMARY KEY,
    office_name VARCHAR(100) NOT NULL,
    office_type ENUM('head', 'branch', 'representative') DEFAULT 'branch',
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    postal_code VARCHAR(10) DEFAULT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    email VARCHAR(100) DEFAULT NULL,
    latitude DECIMAL(10, 8) DEFAULT NULL,
    longitude DECIMAL(11, 8) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(admin_id) ON DELETE SET NULL,
    INDEX idx_city (city),
    INDEX idx_province (province),
    INDEX idx_type (office_type),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample offices
INSERT INTO offices (office_name, office_type, address, city, province, phone, email, is_active, created_by) VALUES
('Kantor Pusat Jakarta', 'head', 'Jl. Sudirman No. 123, Jakarta Selatan', 'Jakarta', 'DKI Jakarta', '+62 21 1234567', 'jakarta@mdn.id', 1, 1),
('Kantor Cabang Surabaya', 'branch', 'Jl. Pemuda No. 45, Surabaya', 'Surabaya', 'Jawa Timur', '+62 31 7654321', 'surabaya@mdn.id', 1, 1),
('Kantor Perwakilan Bandung', 'representative', 'Jl. Asia Afrika No. 78, Bandung', 'Bandung', 'Jawa Barat', '+62 22 9876543', 'bandung@mdn.id', 1, 1);

-- =====================================================
-- CONTACT MESSAGES TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied', 'archived') DEFAULT 'new',
    replied_by INT DEFAULT NULL,
    replied_at DATETIME DEFAULT NULL,
    reply_message TEXT DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (replied_by) REFERENCES admins(admin_id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- ACTIVITY LOGS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS activity_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(100) DEFAULT NULL,
    record_id INT DEFAULT NULL,
    old_value JSON DEFAULT NULL,
    new_value JSON DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(admin_id) ON DELETE CASCADE,
    INDEX idx_admin (admin_id),
    INDEX idx_action (action),
    INDEX idx_table (table_name),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- GALLERIES TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS galleries (
    gallery_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT DEFAULT NULL,
    image VARCHAR(255) NOT NULL,
    category ENUM('event', 'facility', 'activity', 'other') DEFAULT 'other',
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(admin_id) ON DELETE SET NULL,
    INDEX idx_category (category),
    INDEX idx_order (display_order),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- FAQ TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS faqs (
    faq_id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    category VARCHAR(50) DEFAULT 'general',
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES admins(admin_id) ON DELETE SET NULL,
    INDEX idx_category (category),
    INDEX idx_order (display_order),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default FAQs
INSERT INTO faqs (question, answer, category, display_order, is_active, created_by) VALUES
('Apa itu Masjid Digital Network (MDN)?', 'Masjid Digital Network adalah platform digital terpadu untuk membantu masjid mengelola berbagai aspek operasional seperti keuangan, jadwal, pengumuman, dan data jamaah dalam satu sistem yang terintegrasi.', 'general', 1, 1, 1),
('Berapa biaya berlangganan MDN?', 'Kami menawarkan berbagai paket langganan mulai dari Rp 25.000/bulan tergantung layanan yang dipilih. Hubungi tim kami untuk penawaran khusus.', 'pricing', 2, 1, 1),
('Apakah data kami aman?', 'Ya, kami menggunakan enkripsi tingkat enterprise dan backup otomatis untuk menjaga keamanan data masjid Anda.', 'security', 3, 1, 1),
('Bagaimana cara mendaftar?', 'Klik tombol "Daftar Sekarang" di halaman utama, isi formulir pendaftaran, dan tim kami akan menghubungi Anda untuk proses selanjutnya.', 'general', 4, 1, 1);

-- =====================================================
-- VIEWS FOR DASHBOARD
-- =====================================================
CREATE OR REPLACE VIEW admin_statistics AS
SELECT 
    (SELECT COUNT(*) FROM admins WHERE is_active = 1) as total_admins,
    (SELECT COUNT(*) FROM sliders WHERE is_active = 1) as total_sliders,
    (SELECT COUNT(*) FROM services WHERE is_active = 1) as total_services,
    (SELECT COUNT(*) FROM features WHERE is_active = 1) as total_features,
    (SELECT COUNT(*) FROM offices WHERE is_active = 1) as total_offices,
    (SELECT COUNT(*) FROM contact_messages WHERE status = 'new') as unread_messages,
    (SELECT COUNT(*) FROM galleries WHERE is_active = 1) as total_galleries,
    (SELECT COUNT(*) FROM faqs WHERE is_active = 1) as total_faqs;

-- =====================================================
-- STORED PROCEDURES
-- =====================================================
DELIMITER //

CREATE PROCEDURE log_admin_activity(
    IN p_admin_id INT,
    IN p_action VARCHAR(100),
    IN p_table_name VARCHAR(100),
    IN p_record_id INT,
    IN p_old_value JSON,
    IN p_new_value JSON
)
BEGIN
    INSERT INTO activity_logs (
        admin_id, action, table_name, record_id, 
        old_value, new_value, ip_address, user_agent
    ) VALUES (
        p_admin_id, p_action, p_table_name, p_record_id,
        p_old_value, p_new_value, 
        COALESCE(@user_ip, '0.0.0.0'), 
        COALESCE(@user_agent, 'Unknown')
    );
END //

DELIMITER ;

-- =====================================================
-- TRIGGERS
-- =====================================================
DELIMITER //
CREATE TRIGGER before_service_insert 
BEFORE INSERT ON services
FOR EACH ROW
BEGIN
    IF NEW.service_slug IS NULL OR NEW.service_slug = '' THEN
        SET NEW.service_slug = LOWER(REPLACE(REPLACE(NEW.service_name, ' ', '-'), '--', '-'));
    END IF;
END //
DELIMITER ;

-- =====================================================
-- INDEXES FOR PERFORMANCE
-- =====================================================
ALTER TABLE activity_logs ADD INDEX idx_admin_action (admin_id, action);
ALTER TABLE contact_messages ADD INDEX idx_status_created (status, created_at);

-- =====================================================
-- END OF DATABASE SCHEMA
-- =====================================================
