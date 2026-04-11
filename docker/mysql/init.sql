CREATE
DATABASE IF NOT EXISTS db_perpus
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE
db_perpus;
SET
SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET
AUTOCOMMIT = 0;
START TRANSACTION;
SET
time_zone = "+00:00";

CREATE TABLE anggota
(
    anggota_id     INT AUTO_INCREMENT PRIMARY KEY,
    anggota_nama   VARCHAR(50) NOT NULL,
    anggota_alamat TEXT,
    nim            VARCHAR(20) NOT NULL UNIQUE,
    `semester`     INT (2) NOT NULL,
    anggota_jk     ENUM('L','P') NOT NULL,
    anggota_telp   VARCHAR(20),
    INDEX          idx_anggota_nama (anggota_nama)
) ENGINE=InnoDB;

CREATE TABLE kategori
(
    kategori_id   INT AUTO_INCREMENT PRIMARY KEY,
    kategori_nama VARCHAR(50) NOT NULL,
    UNIQUE (kategori_nama)
) ENGINE=InnoDB;

CREATE TABLE buku
(
    buku_id        INT AUTO_INCREMENT PRIMARY KEY,
    buku_judul     VARCHAR(100) NOT NULL,
    kategori_id    INT          NOT NULL,
    buku_deskripsi TEXT,
    buku_jumlah    INT UNSIGNED DEFAULT 0,
    buku_cover     VARCHAR(255),
    INDEX          idx_kategori (kategori_id),
    CONSTRAINT fk_kategori
        FOREIGN KEY (kategori_id)
            REFERENCES kategori (kategori_id)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE petugas
(
    petugas_id   INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    petugas_nama VARCHAR(50)  NOT NULL,
    username     VARCHAR(50)  NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE pinjam
(
    pinjam_id       INT AUTO_INCREMENT PRIMARY KEY,
    buku_id         INT  NOT NULL,
    anggota_id      INT  NOT NULL,
    tgl_pinjam      DATE NOT NULL,
    tgl_jatuh_tempo DATE NOT NULL,
    status          ENUM('dipinjam','kembali')
        DEFAULT 'dipinjam',
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL,
    INDEX
                    idx_buku (buku_id),
    INDEX           idx_anggota (anggota_id),
    INDEX idx_deleted_at (deleted_at),
    CONSTRAINT fk_pinjam_buku
        FOREIGN KEY (buku_id)
            REFERENCES buku (buku_id)
            ON
                UPDATE CASCADE
            ON
                DELETE
                RESTRICT,
    CONSTRAINT fk_pinjam_anggota
        FOREIGN KEY (anggota_id)
            REFERENCES anggota (anggota_id)
            ON
                UPDATE CASCADE
            ON
                DELETE
                RESTRICT
) ENGINE=InnoDB;

CREATE TABLE kembali
(
    kembali_id  INT AUTO_INCREMENT PRIMARY KEY,
    pinjam_id   INT  NOT NULL UNIQUE,
    tgl_kembali DATE NOT NULL,
    denda       INT DEFAULT 0,
    UNIQUE (pinjam_id),
    CONSTRAINT fk_kembali_pinjam
        FOREIGN KEY (pinjam_id)
            REFERENCES pinjam (pinjam_id)
            ON UPDATE CASCADE
            ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE log_transaksi
(
    log_id    INT AUTO_INCREMENT PRIMARY KEY,
    pinjam_id INT,
    aksi      ENUM('pinjam','kembali'),
    waktu     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO `petugas` (`petugas_id`, `petugas_nama`, `username`, `password`)
VALUES (1, 'Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3');

COMMIT;