# Deskripsi Program
## Perpustakaan Sekolah Digital

### Pendahuluan

**Perpustakaan Sekolah Digital** adalah aplikasi berbasis web yang dirancang untuk memudahkan pengelolaan perpustakaan sekolah. Aplikasi ini menyediakan sistem terkomputerisasi untuk mengelola data buku, anggota perpustakaan, dan transaksi peminjaman/pengembalian buku.

### Latar Belakang Masalah

Perpustakaan sekolah sering menghadapi kendala dalam pengelolaan manual seperti:
- Pencatatan peminjaman dan pengembalian buku yang masih manual
- Kesulitan tracking ketersediaan buku
- Penghitungan denda keterlambatan yang rawan error
- Pencarian data buku dan anggota yang memakan waktu
- Laporan statistik yang sulit dibuat secara real-time

### Tujuan Aplikasi

1. **Digitalisasi Pengelolaan**: Mengubah sistem manual menjadi terkomputerisasi
2. **Efisiensi Operasional**: Mempercepat proses peminjaman dan pengembalian
3. **Akurasi Data**: Mengurangi human error dalam pencatatan
4. **Kemudahan Akses**: Memudahkan siswa dalam mencari dan meminjam buku
5. **Transparansi**: Menyediakan tracking real-time untuk semua transaksi

### Fitur Utama

#### Untuk Administrator

1. **Dashboard Admin**
   - Statistik perpustakaan (total buku, anggota, transaksi)
   - Grafik ketersediaan buku
   - Daftar transaksi terbaru
   - Alert untuk transaksi terlambat

2. **Manajemen Buku**
   - CRUD (Create, Read, Update, Delete) data buku
   - Upload informasi lengkap buku (kode, judul, penulis, penerbit, tahun, kategori, stok, lokasi rak)
   - Pencarian dan filter berdasarkan kategori
   - Tracking stok dan ketersediaan

3. **Manajemen Anggota**
   - CRUD data anggota perpustakaan
   - Informasi lengkap (kode anggota, nama, NIS, kelas, alamat, telepon, status)
   - Filter berdasarkan status (aktif/nonaktif)
   - Pencarian cepat anggota

4. **Manajemen Transaksi**
   - Membuat transaksi peminjaman baru
   - Proses pengembalian buku
   - Perhitungan denda otomatis untuk keterlambatan
   - Filter berdasarkan status dan tanggal
   - View detail transaksi

#### Untuk User (Siswa/Staff)

1. **Dashboard User**
   - Ringkasan peminjaman aktif
   - Notifikasi keterlambatan
   - Riwayat peminjaman

2. **Katalog Buku**
   - Browse semua buku yang tersedia
   - Pencarian buku by judul, penulis, atau kategori
   - Informasi ketersediaan real-time
   - Detail lengkap buku

3. **Peminjaman**
   - Pinjam buku langsung dari katalog
   - Pilih anggota peminjam
   - Konfirmasi otomatis

4. **Pengembalian**
   - View daftar peminjaman aktif
   - Proses pengembalian mandiri
   - Informasi denda (jika ada)

### Teknologi yang Digunakan

#### Backend
- **Framework**: Laravel 13.23.0
- **Bahasa**: PHP 8.4
- **Database**: MySQL 8.0
- **Authentication**: Laravel Auth (Session-based)
- **Authorization**: Custom Middleware (AdminMiddleware, RoleMiddleware)

#### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Bootstrap 5.3.0
- **Icons**: Bootstrap Icons 1.11.0
- **JavaScript**: Bootstrap Bundle (vanilla JS)

#### Infrastructure
- **Containerization**: Docker & Docker Compose
- **Web Server**: Nginx (Alpine)
- **PHP Runtime**: PHP-FPM 8.4
- **Development**: Docker-based (no local PHP/MySQL required)

### Arsitektur Sistem

```
┌─────────────────────────────────────────┐
│           Browser (Client)              │
└─────────────┬───────────────────────────┘
              │ HTTP Request (Port 80)
┌─────────────▼───────────────────────────┐
│        Nginx Container                  │
│  - Reverse Proxy                        │
│  - Static File Serving                  │
└─────────────┬───────────────────────────┘
              │ FastCGI
┌─────────────▼───────────────────────────┐
│    PHP-FPM Container (App)              │
│  - Laravel Application                  │
│  - Business Logic                       │
│  - Authentication & Authorization       │
└─────────────┬───────────────────────────┘
              │ PDO/MySQL
┌─────────────▼───────────────────────────┐
│     MySQL Container (Database)          │
│  - Persistent Data Storage              │
│  - Transaction Management               │
└─────────────────────────────────────────┘
```

### Alur Kerja Sistem

#### 1. Proses Login
1. User membuka halaman login
2. Input email dan password
3. Sistem memvalidasi kredensial
4. Jika valid, generate session dan redirect sesuai role
5. Admin → Admin Dashboard, User → User Dashboard

#### 2. Proses Peminjaman
1. User/Admin pilih buku dari katalog/form
2. Sistem cek ketersediaan stok
3. Sistem cek status anggota (harus aktif)
4. Generate kode transaksi unik
5. Buat record transaksi dengan status "dipinjam"
6. Kurangi stok buku yang tersedia
7. Set tanggal jatuh tempo (default: +7 hari)

#### 3. Proses Pengembalian
1. User/Admin pilih transaksi yang akan dikembalikan
2. Sistem catat tanggal pengembalian
3. Sistem bandingkan dengan tanggal jatuh tempo
4. Jika terlambat: hitung denda (Rp 1.000/hari)
5. Update status transaksi
6. Tambah kembali stok buku yang tersedia

### Business Rules

1. **Stok Buku**
   - `jumlah_tersedia` ≤ `jumlah_stok`
   - Stok berkurang saat peminjaman, bertambah saat pengembalian
   - Buku tidak dapat dipinjam jika stok = 0

2. **Status Anggota**
   - Hanya anggota dengan status "aktif" yang dapat meminjam
   - Anggota nonaktif tidak dapat melakukan peminjaman

3. **Status Transaksi**
   - `dipinjam`: Buku sedang dipinjam
   - `dikembalikan`: Buku dikembalikan tepat waktu
   - `terlambat`: Buku dikembalikan melewati jatuh tempo

4. **Perhitungan Denda**
   - Denda = Hari Keterlambatan × Rp 1.000
   - Dihitung otomatis saat pengembalian
   - Tidak ada denda jika tepat waktu

5. **Durasi Peminjaman**
   - Default: 7 hari
   - Dapat dikonfigurasi admin (max 30 hari)

### Keamanan

1. **Authentication**
   - Password di-hash menggunakan bcrypt
   - Session-based authentication
   - Session regeneration setelah login

2. **Authorization**
   - Role-based access control (Admin/User)
   - Middleware protection untuk routes
   - HTTP 403 untuk akses tidak authorized

3. **Data Protection**
   - CSRF token untuk semua form
   - SQL Injection prevention via Eloquent ORM
   - XSS protection via Blade escaping
   - Input validation untuk semua request

4. **Database Security**
   - Foreign key constraints
   - Transaction untuk operasi critical
   - Prepared statements

### Database Schema

**4 Tabel Utama:**

1. **users**: Menyimpan data user (admin & user)
2. **books**: Menyimpan data buku perpustakaan
3. **members**: Menyimpan data anggota perpustakaan
4. **transactions**: Menyimpan data transaksi peminjaman

Lihat `docs/ERD.md` untuk detail lengkap struktur database dan relasi.

### Cara Menjalankan Aplikasi

#### Prerequisites
- Docker Desktop
- Docker Compose
- Git (optional)

#### Instalasi

```bash
# Clone repository
git clone <repository-url>
cd perpustakaan-sekolah

# Jalankan Docker containers
docker compose up -d --build

# Tunggu hingga semua container running

# Akses aplikasi
http://localhost
```

#### Akun Demo

**Administrator:**
- Email: admin@example.com
- Password: password

**User:**
- Email: user@example.com
- Password: password

### Target Pengguna

1. **Sekolah Menengah Kejuruan (SMK)**
   - Khususnya jurusan Rekayasa Perangkat Lunak
   - Sebagai project UKK/P4

2. **Administrator Perpustakaan**
   - Pustakawan sekolah
   - Staff admin perpustakaan

3. **Siswa dan Guru**
   - User yang ingin meminjam buku
   - Melihat katalog dan ketersediaan

### Kelebihan Sistem

1. **Containerized**: Tidak perlu install PHP/MySQL di host
2. **User-Friendly**: Interface sederhana dan intuitif
3. **Real-Time**: Tracking ketersediaan buku secara langsung
4. **Otomatis**: Perhitungan denda dan status otomatis
5. **Scalable**: Arsitektur yang dapat dikembangkan
6. **Secure**: Implementasi best practices keamanan web

### Pengembangan Selanjutnya

Fitur yang dapat ditambahkan di masa depan:
1. Sistem notifikasi via email/WhatsApp
2. Barcode scanner untuk buku
3. Export laporan ke PDF/Excel
4. Dashboard analytics dengan chart
5. Multi-language support
6. Mobile app (React Native/Flutter)
7. Integrasi dengan sistem sekolah lain

### Kesimpulan

Perpustakaan Sekolah Digital adalah solusi modern untuk manajemen perpustakaan yang efisien, aman, dan mudah digunakan. Dengan teknologi containerization dan framework modern, aplikasi ini dapat di-deploy dengan mudah tanpa dependency kompleks pada host system.
