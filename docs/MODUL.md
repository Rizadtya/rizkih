# Dokumentasi Modul

## Perpustakaan Sekolah Digital - Dokumentasi Fungsi & Prosedur

---

## 1. MODUL AUTHENTICATION (Login)

### Nama Modul
Login System

### Input
- Email (string, required, format email)
- Password (string, required, min 8 karakter)
- Remember Me (boolean, optional)

### Proses
1. Validasi input (email format, password tidak kosong)
2. Cari user berdasarkan email di database
3. Verifikasi password dengan hash (bcrypt)
4. Jika cocok, buat session baru
5. Regenerate session ID (keamanan)
6. Cek role user (admin/user)
7. Redirect sesuai role

### Output
- **Success**: Session aktif, redirect ke dashboard sesuai role
- **Failed**: Error message "Email atau password salah", redirect ke login

### Fungsi/Method Terkait
- `LoginController@showLoginForm()` - Tampilkan form login
- `LoginController@login()` - Proses authentication
- `LoginController@logout()` - Proses logout

### File
- Controller: `app/Http/Controllers/Auth/LoginController.php`
- View: `resources/views/auth/login.blade.php`
- Route: `routes/web.php` (GET /login, POST /login, POST /logout)

### Validasi
- Email: required, email format
- Password: required

### Database
Table: `users`
- Query: `SELECT * FROM users WHERE email = ?`

---

## 2. MODUL DASHBOARD

### 2.1 Dashboard Admin

### Input
- User session (authenticated admin)

### Proses
1. Cek authentication dan role
2. Query statistik:
   - Total buku: `COUNT(*) FROM books`
   - Total anggota: `COUNT(*) FROM members`
   - Buku tersedia: `SUM(jumlah_tersedia) FROM books`
   - Buku dipinjam: `COUNT(*) FROM transactions WHERE status='dipinjam'`
   - Total transaksi: `COUNT(*) FROM transactions`
   - Transaksi terlambat: `COUNT(*) FROM transactions WHERE status='terlambat'`
3. Query transaksi terbaru (10 records)
4. Render view dengan data

### Output
- Dashboard dengan cards statistik
- Tabel transaksi terbaru
- Visual indicators (badges, colors)

### Fungsi/Method
- `DashboardController@adminDashboard()`

### File
- Controller: `app/Http/Controllers/DashboardController.php`
- View: `resources/views/admin/dashboard.blade.php`
- Route: `/admin/dashboard`

### 2.2 Dashboard User

### Input
- User session (authenticated user)

### Proses
1. Cek authentication
2. Query data user:
   - Buku tersedia: `COUNT(*) FROM books WHERE jumlah_tersedia > 0`
   - Peminjaman aktif user: `WHERE user_id=? AND status='dipinjam'`
   - Riwayat peminjaman: Last 10 transactions
   - Count terlambat: `WHERE user_id=? AND status='terlambat'`
3. Render view

### Output
- Dashboard dengan statistik user
- Tabel peminjaman aktif dengan tombol kembalikan
- Riwayat peminjaman

### Fungsi/Method
- `DashboardController@userDashboard()`

### File
- Controller: `app/Http/Controllers/DashboardController.php`
- View: `resources/views/user/dashboard.blade.php`
- Route: `/user/dashboard`

---

## 3. MODUL BUKU (Books)

### 3.1 List Buku (Index)

### Input
- Search query (optional)
- Filter kategori (optional)
- Pagination page (optional)

### Proses
1. Query books dengan filter
2. Apply search (kode_buku, judul, penulis, penerbit)
3. Apply filter kategori
4. Pagination (15 items per page)
5. Get distinct categories untuk dropdown

### Output
- Tabel daftar buku
- Search form
- Filter kategori
- Pagination links

### Fungsi/Method
- `BookController@index()`

### Database
- SELECT dengan WHERE LIKE untuk search
- Pagination: LIMIT 15 OFFSET ?

### 3.2 Tambah Buku (Create/Store)

### Input
- kode_buku (string, unique, required)
- judul (string, max 200, required)
- penulis (string, max 100, required)
- penerbit (string, max 100, required)
- tahun_terbit (integer, required)
- kategori (string, required)
- jumlah_stok (integer, min 0, required)
- lokasi_rak (string, optional)
- deskripsi (text, optional)

### Proses
1. Validasi input
2. Set jumlah_tersedia = jumlah_stok
3. INSERT ke table books

### Output
- Success: Redirect ke index dengan success message
- Failed: Kembali ke form dengan error messages

### Fungsi/Method
- `BookController@create()` - Show form
- `BookController@store()` - Process insert

### Validasi
- kode_buku: unique in books table
- tahun_terbit: min 1900, max current_year+1
- jumlah_stok: integer, min 0

### 3.3 Edit Buku (Update)

### Input
- Book ID
- Same fields as create (kode_buku unique kecuali current record)

### Proses
1. Find book by ID
2. Validasi input
3. Adjust jumlah_tersedia based on stok change
4. UPDATE record

### Output
- Success: Redirect ke index
- Failed: Kembali dengan error

### Fungsi/Method
- `BookController@edit()` - Show form
- `BookController@update()` - Process update

### 3.4 Hapus Buku (Delete)

### Input
- Book ID

### Proses
1. Find book
2. Check active transactions
3. If has active transactions: reject
4. DELETE record

### Output
- Success: Redirect dengan success message
- Failed: Error "buku masih dipinjam"

### Fungsi/Method
- `BookController@destroy()`

### Business Rule
- Buku tidak dapat dihapus jika memiliki transaksi aktif

---

## 4. MODUL ANGGOTA (Members)

### 4.1 List Anggota

### Input
- Search query (optional)
- Filter status (optional)

### Proses
1. Query members dengan filter
2. Search by kode_anggota, nama, nis, kelas
3. Filter by status (aktif/nonaktif)
4. Pagination

### Output
- Tabel daftar anggota

### Fungsi/Method
- `MemberController@index()`

### 4.2 Tambah Anggota

### Input
- kode_anggota (unique, required)
- nama (max 100, required)
- nis (unique, required)
- kelas (required)
- alamat (optional)
- no_telepon (optional)
- status (enum: aktif/nonaktif)

### Proses
1. Validasi input
2. INSERT ke table members

### Output
- Success: Redirect ke index
- Failed: Kembali dengan error

### Fungsi/Method
- `MemberController@create()` - Show form
- `MemberController@store()` - Process insert

### Validasi
- kode_anggota: unique in members
- nis: unique in members

### 4.3 Edit Anggota

### Input
- Member ID
- Same fields as create

### Proses
1. Find member
2. Validasi (unique kecuali current)
3. UPDATE record

### Fungsi/Method
- `MemberController@edit()` - Show form
- `MemberController@update()` - Process update

### 4.4 Hapus Anggota

### Input
- Member ID

### Proses
1. Find member
2. Check active transactions
3. If has active: reject
4. DELETE

### Output
- Success atau error jika masih ada peminjaman aktif

### Fungsi/Method
- `MemberController@destroy()`

---

## 5. MODUL TRANSAKSI (Transactions)

### 5.1 List Transaksi

### Input
- Search (kode_transaksi, nama anggota, judul buku)
- Filter status (dipinjam/dikembalikan/terlambat)
- Filter tanggal (from, to)

### Proses
1. Query dengan eager loading (book, member, user)
2. Apply filters
3. Pagination

### Output
- Tabel transaksi dengan detail

### Fungsi/Method
- `TransactionController@index()`

### 5.2 Buat Transaksi (Peminjaman)

### Input
- book_id (required)
- member_id (required)
- durasi_hari (integer, 1-30, default 7)

### Proses
1. Validasi input
2. Cek stok buku (harus > 0)
3. Cek status anggota (harus aktif)
4. Start DB transaction
5. Generate kode_transaksi unik
6. INSERT transaction record
7. Decrement jumlah_tersedia buku
8. Commit transaction

### Output
- Success: Transaksi dibuat, stok berkurang
- Failed: Rollback, error message

### Fungsi/Method
- `TransactionController@create()` - Form
- `TransactionController@store()` - Process
- `LibraryService@borrowBook()` - Business logic

### Business Logic (LibraryService)
```php
borrowBook(Book $book, Member $member, int $userId, int $durasi = 7)
```

1. Check availability
2. Check member status
3. Generate code: TRX-YYYYMMDDHHMMSS-XXXX
4. Create transaction
5. Decrease stock
6. All in DB transaction

### Validasi
- Stok > 0
- Member status = aktif
- Book exists
- Member exists

### Database
- INSERT transactions
- UPDATE books SET jumlah_tersedia = jumlah_tersedia - 1

### 5.3 Pengembalian

### Input
- Transaction ID

### Proses
1. Find transaction
2. Check status (harus 'dipinjam')
3. Set tanggal_kembali = today
4. Compare dengan tanggal_jatuh_tempo
5. If late:
   - Calculate days late
   - Calculate denda (days * 1000)
   - Set status = 'terlambat'
6. If on time:
   - Set status = 'dikembalikan'
   - Set denda = 0
7. Update transaction
8. Increment jumlah_tersedia buku

### Output
- Success: Buku dikembalikan, stok bertambah
- Info denda jika ada

### Fungsi/Method
- `TransactionController@return()` - Admin
- `TransactionController@userReturn()` - User
- `LibraryService@returnBook()` - Business logic

### Business Logic
```php
returnBook(Transaction $transaction)
```

1. Validate status
2. Set return date
3. Calculate late days
4. Calculate fine (Rp 1000/day)
5. Update status
6. Increase stock
7. All in DB transaction

### Perhitungan Denda
- Denda per hari: Rp 1.000
- Formula: (tanggal_kembali - tanggal_jatuh_tempo) * 1000
- Hanya jika terlambat

---

## 6. MODUL PENCARIAN

### 6.1 Pencarian Buku

### Input
- Search keyword
- Filter kategori (optional)

### Proses
1. Search in: kode_buku, judul, penulis, penerbit
2. WHERE LIKE '%keyword%'
3. Apply kategori filter if set

### Output
- Filtered book list

### Fungsi/Method
- Diintegrasikan di `BookController@index()` dan `BookController@catalog()`

### 6.2 Pencarian Anggota

### Input
- Search keyword

### Proses
- Search in: kode_anggota, nama, nis, kelas
- WHERE LIKE '%keyword%'

### Output
- Filtered member list

### Fungsi/Method
- Diintegrasikan di `MemberController@index()`

### 6.3 Pencarian Transaksi

### Input
- Search keyword
- Filter status
- Filter tanggal

### Proses
- Search in: kode_transaksi, nama anggota (via relation), judul buku (via relation)
- Use whereHas() untuk search di related tables

### Output
- Filtered transaction list

### Fungsi/Method
- Diintegrasikan di `TransactionController@index()`

---

## 7. MODUL AUTHORIZATION

### 7.1 Admin Middleware

### Input
- HTTP Request
- User session

### Proses
1. Check if authenticated
2. Check if role = 'admin'
3. If not: abort(403)
4. If yes: continue request

### Output
- Access granted atau 403 Forbidden

### Fungsi/Method
- `AdminMiddleware@handle()`

### File
- `app/Http/Middleware/AdminMiddleware.php`

### 7.2 Role Middleware

### Input
- HTTP Request
- User session
- Required role (parameter)

### Proses
1. Check authenticated
2. Check user role matches required role
3. If not: abort(403)
4. If yes: continue

### Output
- Access granted atau 403

### Fungsi/Method
- `RoleMiddleware@handle(Request $request, Closure $next, string $role)`

### File
- `app/Http/Middleware/RoleMiddleware.php`

---

## 8. DATABASE TRANSACTIONS

Semua operasi yang mengubah stok menggunakan Database Transaction untuk ensure data consistency:

### Peminjaman
```php
DB::transaction(function() {
    // Create transaction record
    // Decrease stock
    // Commit atau rollback jika error
});
```

### Pengembalian
```php
DB::transaction(function() {
    // Update transaction
    // Increase stock
    // Commit atau rollback
});
```

---

## Summary Fungsi Utama

| Modul | Fungsi Create | Fungsi Read | Fungsi Update | Fungsi Delete |
|-------|---------------|-------------|---------------|---------------|
| Books | store() | index(), show() | update() | destroy() |
| Members | store() | index(), show() | update() | destroy() |
| Transactions | store() | index(), show() | - | destroy() |

## Business Logic Services

### LibraryService
- `borrowBook()` - Handle peminjaman dengan validasi lengkap
- `returnBook()` - Handle pengembalian dengan perhitungan denda
- `updateLateTransactions()` - Update status transaksi yang terlambat

Semua service method menggunakan DB transaction untuk data integrity.
