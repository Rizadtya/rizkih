# Debugging Log

## Perpustakaan Sekolah Digital - Issue Tracking & Resolution

---

## Issue #1: Docker Container Startup Failure

### Tanggal
2026-08-03

### Deskripsi Error
```
HTTP/1.1 502 Bad Gateway
```

Container app stuck dalam infinite loop dengan error:
```
nc: command not found
Waiting for database connection...
```

### Root Cause
- Dockerfile menggunakan PHP 8.4-fpm base image
- Entrypoint script menggunakan `nc` (netcat) untuk wait-for-database
- Package `netcat-openbsd` tidak terinstall di image

### Impact
- PHP-FPM tidak pernah start
- Nginx tidak dapat forward request ke PHP-FPM
- Aplikasi tidak accessible (502 Bad Gateway)

### Solution
**File Modified**: `Dockerfile`

Menambahkan `netcat-openbsd` ke daftar package yang diinstall:

```dockerfile
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    netcat-openbsd    # ← Added this line
```

### Steps Taken
1. Identifikasi error dari container logs
2. Update Dockerfile dengan netcat package
3. Rebuild Docker image: `docker compose down && docker compose up -d --build`
4. Verify containers running: `docker compose ps`
5. Test application: `curl -I http://localhost` → Success (HTTP 302)

### Result
✅ **RESOLVED**
- All containers running properly
- PHP-FPM started successfully
- Application accessible via http://localhost
- Proper redirect from / to /login

### Files Modified
- `Dockerfile` (line 7-16)

### Verification
```bash
docker compose ps
# All containers: Up X minutes

curl -I http://localhost
# HTTP/1.1 302 Found
```

---

## Issue #2: File Ownership Permissions

### Tanggal
2026-08-03

### Deskripsi Error
```
EACCES: permission denied
```

Tidak dapat edit file yang dibuat oleh Docker container (LoginController.php, AdminMiddleware.php, dll)

### Root Cause
- Files created by `php artisan make:*` commands run inside Docker
- Files owned by root or www-data user
- Host user tidak memiliki write permission

### Impact
- Tidak dapat edit/write file tertentu dari host
- Development workflow terhambat

### Solution
Menggunakan Docker alpine container untuk fix ownership:

```bash
docker run --rm -v "$(pwd):/app" alpine sh -c "chown -R $(id -u):$(id -g) /app"
```

### Steps Taken
1. Identifikasi files dengan ownership issue
2. Check ownership: `ls -la file.php` → root:root
3. Run chown via Docker alpine
4. Verify: `ls -la file.php` → rizkuy:rizkuy
5. Dapat edit file normally

### Result
✅ **RESOLVED**
- Semua files dapat diedit dari host
- Ownership sesuai dengan host user

### Best Practice
Run ownership fix command setelah:
- `php artisan make:*` commands
- Any Docker operation yang create files
- Before editing files created by container

---

## Issue #3: Laravel Version & Security Advisories

### Tanggal
2026-08-03 (Awal project)

### Deskripsi Error
```
Your requirements could not be resolved to an installable set of packages.
Root composer.json requires laravel/framework ^11.31, found versions affected by security advisories
```

### Root Cause
- Project requirement: Laravel 11
- Laravel 11.31-11.55 memiliki security advisories
- Composer blocks installation by default

### Decision Made
**DO NOT bypass security checks**

User explicitly instructed:
- Jangan gunakan `--ignore-platform-reqs`
- Jangan bypass security advisories
- Gunakan versi yang aman

### Solution
Install Laravel tanpa version constraint → Latest version (Laravel 13.23.0)

Reasoning:
- Laravel 13 adalah versi terbaru (2026)
- Tidak ada security advisories
- Compatible dengan PHP 8.4
- More secure dan modern features

### Trade-off
- Requirement awal: Laravel 11
- Actual implementation: Laravel 13
- Acceptable karena security > version constraint

### Result
✅ **RESOLVED**
- Laravel 13.23.0 installed
- No security advisories
- PHP 8.4 compatible
- Application working properly

---

## Issue #4: Database Connection String

### Tanggal
2026-08-03

### Deskripsi
Initial .env menggunakan SQLite, perlu diganti ke MySQL

### Root Cause
Laravel 13 default database driver: SQLite

### Solution
Update `.env` dan `.env.example`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql          # ← Important: use service name, not localhost
DB_PORT=3306
DB_DATABASE=perpustakaan
DB_USERNAME=perpustakaan_user
DB_PASSWORD=perpustakaan_pass
```

### Key Point
**DB_HOST harus "mysql"** (nama service di docker-compose), bukan "localhost" atau "127.0.0.1"

### Result
✅ **RESOLVED**
- Migrations run successfully
- Database connection established
- All queries working

---

## Non-Issues (Verifikasi Berhasil)

### ✅ Authentication System
- Login admin: Working
- Login user: Working
- Session management: Working
- Role-based redirect: Working

### ✅ Authorization
- Admin middleware: Working
- Role middleware: Working
- HTTP 403 untuk unauthorized access: Working

### ✅ CRUD Operations
- Books CRUD: Verified
- Members CRUD: Verified  
- Transactions CRUD: Verified

### ✅ Business Logic
- Borrowing: Stock decreases correctly
- Returning: Stock increases correctly
- Fine calculation: Working (Rp 1000/day)
- Transaction status updates: Working

### ✅ Database
- Migrations: All success
- Seeders: Demo data created
- Foreign keys: Constraints working
- Indexes: Applied correctly

### ✅ Views
- Login page: Rendered correctly
- Admin dashboard: Working with stats
- User dashboard: Working with loans
- Bootstrap 5: Styling applied
- Responsive: Mobile-friendly

---

## Lessons Learned

### 1. Docker Dependencies
**Lesson**: Always check if base image includes required system tools
**Application**: Install netcat atau equivalent untuk database waiting

### 2. File Ownership in Docker
**Lesson**: Docker operations create files as root
**Application**: Run chown fix after Docker file operations

### 3. Security Over Convenience
**Lesson**: Never bypass security checks
**Application**: Use latest secure versions, not vulnerable legacy versions

### 4. Container Networking
**Lesson**: Use service names, not localhost, in Docker Compose
**Application**: DB_HOST=mysql, not DB_HOST=localhost

---

## Debug Commands Reference

### Check Container Status
```bash
docker compose ps
```

### View Container Logs
```bash
docker compose logs app --tail=50
docker compose logs mysql --tail=50
docker compose logs nginx --tail=50
```

### Execute Commands in Container
```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan tinker
docker compose exec mysql mysql -u root -p
```

### Check Application Status
```bash
curl -I http://localhost
```

### Fix File Ownership
```bash
docker run --rm -v "$(pwd):/app" alpine sh -c "chown -R $(id -u):$(id -g) /app"
```

### Rebuild Containers
```bash
docker compose down
docker compose up -d --build
```

---

## Conclusion

Semua issue yang ditemukan telah berhasil diselesaikan. Aplikasi berjalan dengan baik dan siap untuk demonstrasi/presentasi.

**Final Status**: ✅ All Systems Operational
