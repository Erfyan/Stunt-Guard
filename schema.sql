-- =============================================
-- DATABASE: stuntguard
-- Dibuat untuk Sistem SIPANTAU STUNTING
-- MySQL / MariaDB
-- =============================================

-- --------------------------------------------------------
-- 1. Tabel User
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `user` (
    `id_user` INT(11) NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(100) NOT NULL,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL, -- gunakan bcrypt/hash
    `role` ENUM('Admin','Petugas','Kader','Ibu') NOT NULL DEFAULT 'Ibu',
    `email` VARCHAR(100) DEFAULT NULL,
    `no_hp` VARCHAR(20) DEFAULT NULL,
    `status` ENUM('Aktif','Non Aktif') NOT NULL DEFAULT 'Aktif',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 2. Tabel Posyandu
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `posyandu` (
    `id_posyandu` INT(11) NOT NULL AUTO_INCREMENT,
    `nama_posyandu` VARCHAR(100) NOT NULL,
    `desa` VARCHAR(100) DEFAULT NULL,
    `kecamatan` VARCHAR(100) DEFAULT NULL,
    `kabupaten` VARCHAR(100) DEFAULT NULL,
    `alamat` TEXT,
    `latitude` DECIMAL(10,8) DEFAULT NULL,
    `longitude` DECIMAL(11,8) DEFAULT NULL,
    `no_hp` VARCHAR(20) DEFAULT NULL,
    PRIMARY KEY (`id_posyandu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 3. Tabel Ibu (Orang Tua / Ibu Hamil)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `ibu` (
    `id_ibu` INT(11) NOT NULL AUTO_INCREMENT,
    `id_user` INT(11) NOT NULL UNIQUE, -- one-to-one dengan user
    `nik` VARCHAR(20) NOT NULL UNIQUE,
    `nama_ibu` VARCHAR(100) NOT NULL,
    `tanggal_lahir` DATE DEFAULT NULL,
    `alamat` TEXT,
    `no_hp` VARCHAR(20) DEFAULT NULL,
    PRIMARY KEY (`id_ibu`),
    CONSTRAINT `fk_ibu_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 4. Tabel Balita
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `balita` (
    `id_balita` INT(11) NOT NULL AUTO_INCREMENT,
    `id_ibu` INT(11) NOT NULL,
    `id_posyandu` INT(11) NOT NULL,
    `nama_balita` VARCHAR(100) NOT NULL,
    `nik` VARCHAR(20) DEFAULT NULL,
    `jenis_kelamin` ENUM('Laki-laki','Perempuan') NOT NULL,
    `tanggal_lahir` DATE NOT NULL,
    `berat_lahir` DECIMAL(5,2) DEFAULT NULL, -- kg
    `panjang_lahir` DECIMAL(5,2) DEFAULT NULL, -- cm
    `status` ENUM('Aktif','Non Aktif') NOT NULL DEFAULT 'Aktif',
    PRIMARY KEY (`id_balita`),
    CONSTRAINT `fk_balita_ibu` FOREIGN KEY (`id_ibu`) REFERENCES `ibu` (`id_ibu`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_balita_posyandu` FOREIGN KEY (`id_posyandu`) REFERENCES `posyandu` (`id_posyandu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 5. Tabel Pemeriksaan (Antropometri & Status Gizi)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pemeriksaan` (
    `id_pemeriksaan` INT(11) NOT NULL AUTO_INCREMENT,
    `id_balita` INT(11) NOT NULL,
    `tanggal` DATE NOT NULL,
    `umur_bulan` INT(11) NOT NULL, -- umur saat pemeriksaan dalam bulan
    `berat_badan` DECIMAL(5,2) NOT NULL, -- kg
    `tinggi_badan` DECIMAL(5,2) NOT NULL, -- cm
    `lingkar_kepala` DECIMAL(5,2) DEFAULT NULL, -- cm (perbaiki typo dari 'tingkar_kepala')
    `lingkar_lengan` DECIMAL(5,2) DEFAULT NULL, -- cm (LiLA)
    `cara_ukur` VARCHAR(50) DEFAULT NULL, -- misal: berdiri, berbaring
    `zscore` DECIMAL(5,2) DEFAULT NULL, -- Z-Score BB/U atau TB/U
    `status_gizi` VARCHAR(50) DEFAULT NULL, -- misal: Normal, Underweight, Obesitas
    `status_stunting` VARCHAR(50) DEFAULT NULL, -- misal: Stunting, Normal, Wasting
    `bb_tidak_nak` ENUM('Ya','Tidak') DEFAULT NULL, -- kemungkinan BB/TB tidak naik
    `catatan` TEXT,
    `petugas` VARCHAR(100) DEFAULT NULL, -- nama petugas yang mengukur
    PRIMARY KEY (`id_pemeriksaan`),
    CONSTRAINT `fk_pemeriksaan_balita` FOREIGN KEY (`id_balita`) REFERENCES `balita` (`id_balita`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 6. Tabel Pelayanan Kesehatan (per pemeriksaan)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `pelayanan_kesehatan` (
    `id_pelayanan` INT(11) NOT NULL AUTO_INCREMENT,
    `id_pemeriksaan` INT(11) NOT NULL,
    `asi_eksklusif` ENUM('Ya','Tidak') DEFAULT NULL,
    `vitamin_a` VARCHAR(50) DEFAULT NULL, -- misal: 'Biru', 'Merah', atau tanggal
    `obat_cacing` VARCHAR(50) DEFAULT NULL, -- misal: 'Albendazole 400 mg'
    `mt_pemulihan` ENUM('Ya','Tidak') DEFAULT NULL,
    `penyuluhan` ENUM('Ya','Tidak') DEFAULT NULL,
    `topik_penyuluhan` VARCHAR(255) DEFAULT NULL,
    `rujukan` VARCHAR(255) DEFAULT NULL, -- jika dirujuk ke puskesmas/RSUD
    `keterangan` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id_pelayanan`),
    CONSTRAINT `fk_pelayanan_pemeriksaan` FOREIGN KEY (`id_pemeriksaan`) REFERENCES `pemeriksaan` (`id_pemeriksaan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- 7. Tabel Imunisasi (terhubung ke pelayanan kesehatan)
-- Catatan: Menurut ERD, id_pelayanan UNIQUE, artinya hanya 1 imunisasi per pelayanan.
--          Jika ingin mencatat banyak jenis imunisasi, ubah UNIQUE menjadi INDEX biasa.
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `imunisasi` (
    `id_imunisasi` INT(11) NOT NULL AUTO_INCREMENT,
    `id_pelayanan` INT(11) NOT NULL UNIQUE, -- UNIQUE sesuai ERD
    `jenis_imunisasi` VARCHAR(50) NOT NULL, -- misal: BCG, DPT, Polio, Campak
    `tanggal` DATE DEFAULT NULL,
    `keterangan` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id_imunisasi`),
    CONSTRAINT `fk_imunisasi_pelayanan` FOREIGN KEY (`id_pelayanan`) REFERENCES `pelayanan_kesehatan` (`id_pelayanan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- (Opsional) Tambahkan indeks untuk performa query
-- --------------------------------------------------------
CREATE INDEX idx_user_role ON `user` (`role`);
CREATE INDEX idx_balita_ibu ON `balita` (`id_ibu`);
CREATE INDEX idx_balita_posyandu ON `balita` (`id_posyandu`);
CREATE INDEX idx_pemeriksaan_balita ON `pemeriksaan` (`id_balita`);
CREATE INDEX idx_pemeriksaan_tanggal ON `pemeriksaan` (`tanggal`);

-- =============================================
-- DATA DUMMY (untuk testing awal)
-- =============================================

-- 1. User contoh
INSERT INTO `user` (`nama`, `username`, `password`, `role`, `email`, `no_hp`, `status`) VALUES
('Admin Utama', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'admin    @stuntguard.com', '081234567890', 'Aktif'),
('Kader Posyandu Mawar', 'kader_mawar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Kader', 'kader@posyandu.com', '081298765432', 'Aktif'),
('Ibu Ani', 'ibu_ani', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ibu', 'ani@example.com', '081355667788', 'Aktif');

-- 2. Posyandu
INSERT INTO `posyandu` (`nama_posyandu`, `desa`, `kecamatan`, `kabupaten`, `alamat`, `latitude`, `longitude`, `no_hp`) VALUES
('Posyandu Mawar', 'Parang Loe', 'Tamalanrea', 'Makassar', 'Jl. Kesehatan No. 1', -5.12345678, 119.45678901, '081234567890'),
('Posyandu Melati', 'Bontoala', 'Bontoala', 'Makassar', 'Jl. Bunga No. 5', -5.13456789, 119.41234567, '081298765432');

-- 3. Ibu (terhubung ke user id 3 = Ibu Ani)
INSERT INTO `ibu` (`id_user`, `nik`, `nama_ibu`, `tanggal_lahir`, `alamat`, `no_hp`) VALUES
(3, '3273012345678901', 'Ani Sulastri', '1995-05-10', 'Jl. Mawar No. 12, Parang Loe', '081355667788');

-- 4. Balita (milik Ibu Ani, di Posyandu Mawar)
INSERT INTO `balita` (`id_ibu`, `id_posyandu`, `nama_balita`, `nik`, `jenis_kelamin`, `tanggal_lahir`, `berat_lahir`, `panjang_lahir`, `status`) VALUES
(1, 1, 'Budi Pratama', '3273012345678902', 'Laki-laki', '2022-01-15', 3.20, 49.00, 'Aktif');

-- 5. Pemeriksaan contoh (untuk Budi)
INSERT INTO `pemeriksaan` (`id_balita`, `tanggal`, `umur_bulan`, `berat_badan`, `tinggi_badan`, `lingkar_kepala`, `lingkar_lengan`, `cara_ukur`, `zscore`, `status_gizi`, `status_stunting`, `bb_tidak_nak`, `catatan`, `petugas`) VALUES
(1, '2024-06-15', 29, 12.50, 88.00, 45.00, 16.00, 'Berdiri', 0.80, 'Normal', 'Normal', 'Tidak', 'Anak sehat, aktif', 'Kader Aisyah');

-- 6. Pelayanan Kesehatan untuk pemeriksaan tersebut
INSERT INTO `pelayanan_kesehatan` (`id_pemeriksaan`, `asi_eksklusif`, `vitamin_a`, `obat_cacing`, `mt_pemulihan`, `penyuluhan`, `topik_penyuluhan`, `rujukan`, `keterangan`) VALUES
(1, 'Tidak', 'Biru', 'Albendazole 400 mg', 'Tidak', 'Ya', 'Pentingnya protein hewani', NULL, 'Imunisasi lengkap');

-- 7. Imunisasi (satu jenis sesuai ERD)
INSERT INTO `imunisasi` (`id_pelayanan`, `jenis_imunisasi`, `tanggal`, `keterangan`) VALUES
(1, 'DPT-HB-Hib', '2024-06-15', 'Dosis ke-4');

-- =============================================
-- Selesai
-- =============================================