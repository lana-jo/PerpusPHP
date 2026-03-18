-- ─── Inisialisasi database PerpusPHP ─────────────────────────────────────
-- File ini dieksekusi otomatis saat container MySQL pertama kali dijalankan.
-- Jika Anda sudah punya file .sql dari repo, ganti isi file ini dengan dump Anda.

CREATE DATABASE IF NOT EXISTS `perpus_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `db_perpus`;

-- Contoh tabel dasar (sesuaikan dengan schema repo Anda)
-- Hapus atau ganti bagian ini jika Anda punya dump SQL sendiri

CREATE TABLE IF NOT EXISTS `buku` (
  `id`        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `judul`     VARCHAR(255)  NOT NULL,
  `pengarang` VARCHAR(255)  NOT NULL,
  `penerbit`  VARCHAR(255)  DEFAULT NULL,
  `tahun`     YEAR          DEFAULT NULL,
  `stok`      INT UNSIGNED  DEFAULT 1,
  `created_at` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `anggota` (
  `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nama`       VARCHAR(255) NOT NULL,
  `email`      VARCHAR(255) UNIQUE NOT NULL,
  `telepon`    VARCHAR(20)  DEFAULT NULL,
  `alamat`     TEXT         DEFAULT NULL,
  `created_at` TIMESTAMP   DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `buku_id`       INT UNSIGNED NOT NULL,
  `anggota_id`    INT UNSIGNED NOT NULL,
  `tgl_pinjam`    DATE         NOT NULL,
  `tgl_kembali`   DATE         DEFAULT NULL,
  `status`        ENUM('dipinjam','dikembalikan') DEFAULT 'dipinjam',
  `created_at`    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`buku_id`)    REFERENCES `buku`(`id`)    ON DELETE CASCADE,
  FOREIGN KEY (`anggota_id`) REFERENCES `anggota`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;