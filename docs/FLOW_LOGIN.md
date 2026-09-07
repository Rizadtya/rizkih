# Flowchart - Proses Login

## Alur Login Sistem Perpustakaan

```mermaid
flowchart TD
    A[Start: User membuka halaman login] --> B[Input Email dan Password]
    B --> C{Validasi Input}
    C -->|Invalid| D[Tampilkan Error: Field wajib diisi]
    D --> B
    C -->|Valid| E[Kirim request ke server]
    E --> F{Cek Kredensial di Database}
    F -->|Tidak Ditemukan| G[Tampilkan Error: Email atau password salah]
    G --> B
    F -->|Ditemukan| H[Generate Session]
    H --> I{Cek Role User}
    I -->|Role = admin| J[Redirect ke Admin Dashboard]
    I -->|Role = user| K[Redirect ke User Dashboard]
    J --> L[End: User masuk ke sistem sebagai Admin]
    K --> M[End: User masuk ke sistem sebagai User]
```

## Deskripsi Proses

### Input
- Email user
- Password user
- Remember me (optional)

### Proses
1. **Validasi Form**: 
   - Email harus format email valid
   - Password tidak boleh kosong
   
2. **Autentikasi**:
   - Cari user berdasarkan email
   - Verifikasi password menggunakan hash
   - Jika cocok, buat session baru
   
3. **Authorization**:
   - Cek role user (admin atau user)
   - Redirect sesuai role
   
4. **Session Management**:
   - Regenerate session ID untuk keamanan
   - Set remember token jika user checklist "Ingat Saya"

### Output
- **Success**: 
  - Admin → Dashboard Admin
  - User → Dashboard User
  - Session aktif
- **Failed**: 
  - Error message
  - Redirect kembali ke form login

### Keamanan
- Password di-hash menggunakan bcrypt
- CSRF protection aktif
- Session regeneration setelah login
- Rate limiting untuk mencegah brute force

## File Terkait
- Controller: `app/Http/Controllers/Auth/LoginController.php`
- View: `resources/views/auth/login.blade.php`
- Route: `routes/web.php`
- Middleware: Session, CSRF
