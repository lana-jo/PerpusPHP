# 🐳 Docker Setup — PerpusPHP

Stack: **PHP 8.2-FPM** + **MySQL 8.0** + **Nginx** + **phpMyAdmin**

---

## 📁 Struktur File

Letakkan file-file ini di **root folder repo** Anda:

```
PerpusPHP/
├── docker/
│   ├── nginx/
│   │   └── default.conf
│   ├── php/
│   │   └── Dockerfile
│   └── mysql/
│       └── init.sql          ← ganti dengan dump SQL Anda
├── docker-compose.yml
├── .env.example
├── .env                      ← buat dari .env.example
├── Makefile
└── index.php                 ← file PHP Anda
```

---

## 🚀 Cara Menjalankan

### 1. Install Docker di Debian

```bash
# Update & install dependencies
sudo apt update
sudo apt install -y ca-certificates curl gnupg

# Tambah Docker GPG key
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/debian/gpg | \
  sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg

# Tambah Docker repository
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
  https://download.docker.com/linux/debian \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Install Docker Engine & Compose
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin

# Jalankan Docker tanpa sudo (opsional, butuh logout/login ulang)
sudo usermod -aG docker $USER
```

### 2. Clone repo & setup

```bash
# Clone repo
git clone https://github.com/lana-jo/PerpusPHP.git
cd PerpusPHP

# Salin file Docker yang sudah disiapkan ke dalam repo
# (letakkan file docker/, docker-compose.yml, .env.example, Makefile)

# Buat file .env
cp .env.example .env
```

### 3. (Opsional) Sesuaikan database

Jika repo Anda sudah punya file **dump SQL**, ganti isi `docker/mysql/init.sql`
dengan dump tersebut, atau import manual setelah container jalan:

```bash
make import-sql FILE=db_perpus.sql
```
(sudah ada di folder database)

### 4. Jalankan!

```bash
# Build & jalankan semua container
make up

# Atau tanpa Makefile:
docker compose up -d --build
```

---

## 🌐 Akses Aplikasi

| Service     | URL                        |
|-------------|----------------------------|
| Website     | http://localhost            |
| phpMyAdmin  | http://localhost:8080       |
| MySQL port  | localhost:3306              |

---

## 🔧 Koneksi Database di PHP

Gunakan variabel berikut di kode PHP Anda (sesuaikan dengan `.env`):

```php
<?php
$host     = 'mysql';          // nama service di docker-compose
$dbname   = 'db_perpus';
$user     = 'root';
$password = '';

// PDO
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);

// MySQLi
$conn = new mysqli($host, $user, $password, $dbname);
```

> ⚠️ **Host harus `mysql`** (bukan `localhost`) karena menggunakan Docker network.

---

## 📋 Perintah Berguna

```bash
make up           # Jalankan semua container
make down         # Hentikan semua container
make build        # Build ulang image PHP
make logs         # Lihat semua log
make shell        # Masuk ke container PHP (bash)
make mysql-shell  # Masuk ke MySQL CLI
make status       # Cek status container
```

---

## 🛠️ Troubleshooting

**Container PHP gagal start?**
```bash
docker compose logs php
```

**MySQL belum siap saat PHP connect?**
Tambahkan retry loop di koneksi PHP, atau tunggu beberapa detik setelah `make up`.

**Port 80 sudah dipakai?**
Edit `docker-compose.yml` bagian nginx ports: `"8000:80"` lalu akses di `http://localhost:8000`.