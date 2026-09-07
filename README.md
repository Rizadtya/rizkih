# Perpustakaan Sekolah Digital

Aplikasi perpustakaan sekolah berbasis web untuk mengelola peminjaman dan pengembalian buku dengan sistem terkomputerisasi.

![Laravel](https://img.shields.io/badge/Laravel-13.23-red)
![PHP](https://img.shields.io/badge/PHP-8.4-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange)
![Docker](https://img.shields.io/badge/Docker-Compose-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple)

## 📋 Deskripsi

**Perpustakaan Sekolah Digital** adalah aplikasi web modern yang memudahkan pengelolaan perpustakaan sekolah. Aplikasi ini menyediakan sistem terkomputerisasi untuk:
- Manajemen data buku
- Manajemen data anggota perpustakaan
- Transaksi peminjaman dan pengembalian
- Perhitungan denda keterlambatan otomatis
- Tracking ketersediaan buku real-time
- Role-based access control (Admin & User)

## ✨ Fitur Utama

### 👨‍💼 Administrator
- Dashboard dengan statistik lengkap
- CRUD Buku (Tambah, Edit, Hapus, Lihat)
- CRUD Anggota Perpustakaan
- Manajemen Transaksi
- Pencarian dan Filter
- Laporan Transaksi

### 👤 User (Siswa/Staff)
- Dashboard peminjaman
- Katalog buku dengan pencarian
- Peminjaman buku
- Pengembalian buku
- Riwayat peminjaman
- Notifikasi keterlambatan

## 🛠️ Teknologi

### Backend
- **Framework**: Laravel 13.23.0
- **Language**: PHP 8.4
- **Database**: MySQL 8.0
- **Authentication**: Laravel Session Auth
- **Authorization**: Custom Middleware

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Bootstrap 5.3.0
- **Icons**: Bootstrap Icons
- **JavaScript**: Bootstrap Bundle

### Infrastructure
- **Containerization**: Docker & Docker Compose
- **Web Server**: Nginx (Alpine)
- **PHP Runtime**: PHP-FPM 8.4

## 📦 Requirements

**PENTING**: Aplikasi ini tidak membutuhkan instalasi PHP atau MySQL di host system.

Yang diperlukan hanya:
- Docker Desktop
- Docker Compose

Aplikasi berjalan 100% di dalam Docker containers.

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd perpustakaan-sekolah
```

### 2. Setup Environment

```bash
# Copy .env.example ke .env (sudah include config MySQL)
cp .env.example .env
```

### 3. Build & Run dengan Docker

```bash
# Build dan start semua containers
docker compose up -d --build
```

Tunggu hingga semua containers running (sekitar 1-2 menit untuk first build).

### 4. Verifikasi

Cek status containers:

```bash
docker compose ps
```

Output yang diharapkan:
```
NAME                 STATUS
perpustakaan_app     Up X minutes
perpustakaan_mysql   Up X minutes (healthy)
perpustakaan_nginx   Up X minutes
```

### 5. Akses Aplikasi

Buka browser dan akses:
```
http://localhost
```

## 👥 Akun Demo

### Administrator
```
Email: admin@example.com
Password: password
```

### User
```
Email: user@example.com
Password: password
```

## 🐳 Docker Commands

### Start aplikasi
```bash
docker compose up -d
```

### Stop aplikasi
```bash
docker compose down
```

### View logs
```bash
# All containers
docker compose logs -f

# Specific container
docker compose logs -f app
docker compose logs -f mysql
docker compose logs -f nginx
```

### Check container status
```bash
docker compose ps
```

### Restart aplikasi
```bash
docker compose restart
```

### Rebuild (setelah code changes)
```bash
docker compose down
docker compose up -d --build
```

## 🔧 Laravel Commands (via Docker)

### Run migrations
```bash
docker compose exec app php artisan migrate
```

### Run migrations with seed
```bash
docker compose exec app php artisan migrate:fresh --seed
```

### Generate app key
```bash
docker compose exec app php artisan key:generate
```

### Clear cache
```bash
docker compose exec app php artisan cache:clear
docker compose exec app php artisan config:clear
docker compose exec app php artisan route:clear
docker compose exec app php artisan view:clear
```

### Run Tinker (REPL)
```bash
docker compose exec app php artisan tinker
```

### Run tests
```bash
docker compose exec app php artisan test
```

## 📚 Dokumentasi

Dokumentasi lengkap tersedia di folder `/docs`:

- **ERD.md** - Entity Relationship Diagram
- **FLOW_LOGIN.md** - Flowchart proses login
- **FLOW_PEMINJAMAN.md** - Flowchart proses peminjaman
- **DESKRIPSI_PROGRAM.md** - Deskripsi lengkap program
- **MODUL.md** - Dokumentasi modul/fungsi
- **DEBUGGING.md** - Log debugging dan troubleshooting
- **EVALUASI.md** - Evaluasi dan analisis project

## 📊 Database

### Export SQL
```bash
docker compose exec mysql mysqldump -u perpustakaan_user -pperpustakaan_pass perpustakaan > database/library.sql
```

### Import SQL
```bash
docker compose exec -T mysql mysql -u perpustakaan_user -pperpustakaan_pass perpustakaan < database/library.sql
```

### Access MySQL CLI
```bash
docker compose exec mysql mysql -u perpustakaan_user -pperpustakaan_pass perpustakaan
```

## 🗂️ Struktur Project

```
perpustakaan-sekolah/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controllers
│   │   └── Middleware/      # Custom middleware
│   ├── Models/              # Eloquent models
│   └── Services/            # Business logic services
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── library.sql          # SQL export
├── docker/
│   ├── nginx/               # Nginx config
│   └── php/                 # PHP config
├── docs/                    # Dokumentasi
├── resources/
│   └── views/               # Blade templates
├── routes/
│   └── web.php              # Routes definition
├── tests/                   # Automated tests
├── docker-compose.yml       # Docker Compose config
├── Dockerfile               # Docker image config
└── README.md                # This file
```

## 🔐 Security Features

- ✅ Password hashing (Bcrypt)
- ✅ CSRF protection
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade escaping)
- ✅ Session security
- ✅ Role-based authorization
- ✅ Input validation

## 🎯 Business Rules

### Peminjaman Buku
- Stok buku harus > 0
- Anggota harus berstatus "aktif"
- Durasi peminjaman default: 7 hari (configurable max 30 hari)

### Pengembalian Buku
- Denda keterlambatan: Rp 1.000/hari
- Denda dihitung otomatis saat pengembalian
- Status otomatis diupdate (dikembalikan/terlambat)

### Stok Management
- `jumlah_tersedia` berkurang saat peminjaman
- `jumlah_tersedia` bertambah saat pengembalian
- `jumlah_tersedia` ≤ `jumlah_stok` (enforced)

## 🐛 Troubleshooting

### Container tidak start
```bash
# Check logs
docker compose logs app

# Rebuild
docker compose down
docker compose up -d --build
```

### Permission issues dengan files
```bash
# Fix ownership (dari host)
docker run --rm -v "$(pwd):/app" alpine sh -c "chown -R $(id -u):$(id -g) /app"
```

### Database connection error
Pastikan `DB_HOST=mysql` di `.env` (bukan localhost)

### Port 80 sudah digunakan
Edit `docker-compose.yml`:
```yaml
ports:
  - "8080:80"  # Ganti 80 menjadi port lain
```
Lalu akses via `http://localhost:8080`

## 📈 Development

### Menambah dependencies
```bash
docker compose exec app composer require <package-name>
```

### Create migration
```bash
docker compose exec app php artisan make:migration <migration_name>
```

### Create controller
```bash
docker compose exec app php artisan make:controller <ControllerName>
```

### Create model
```bash
docker compose exec app php artisan make:model <ModelName> -m
```

## 🧪 Testing

### Run all tests
```bash
docker compose exec app php artisan test
```

### Run specific test
```bash
docker compose exec app php artisan test --filter=<TestName>
```

## 📝 License

This project is open-sourced for educational purposes (UKK/P4 SMK Rekayasa Perangkat Lunak).

## 👨‍💻 Author

Dibuat untuk project UKK/P4 - Rekayasa Perangkat Lunak

## 🤝 Contributing

Ini adalah project educational. Feel free to fork dan customize sesuai kebutuhan.

## 📞 Support

Jika menemui masalah:
1. Cek dokumentasi di folder `/docs`
2. Cek `docs/DEBUGGING.md` untuk troubleshooting
3. Verifikasi semua containers running: `docker compose ps`
4. Check logs: `docker compose logs -f`

---

**Status**: ✅ Production Ready

**Last Updated**: 2026-08-03

**Version**: 1.0.0
