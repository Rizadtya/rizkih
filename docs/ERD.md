# Entity Relationship Diagram (ERD)

## Perpustakaan Sekolah Digital

### Entities and Relationships

```mermaid
erDiagram
    USERS ||--o{ TRANSACTIONS : creates
    BOOKS ||--o{ TRANSACTIONS : "borrowed in"
    MEMBERS ||--o{ TRANSACTIONS : borrows
    
    USERS {
        bigint id PK
        string name
        string email UK
        string password
        enum role
        timestamp email_verified_at
        timestamp created_at
        timestamp updated_at
    }
    
    BOOKS {
        bigint id PK
        string kode_buku UK
        string judul
        string penulis
        string penerbit
        year tahun_terbit
        string kategori
        int jumlah_stok
        int jumlah_tersedia
        string lokasi_rak
        text deskripsi
        timestamp created_at
        timestamp updated_at
    }
    
    MEMBERS {
        bigint id PK
        string kode_anggota UK
        string nama
        string nis UK
        string kelas
        text alamat
        string no_telepon
        enum status
        timestamp created_at
        timestamp updated_at
    }
    
    TRANSACTIONS {
        bigint id PK
        string kode_transaksi UK
        bigint book_id FK
        bigint member_id FK
        bigint user_id FK
        date tanggal_pinjam
        date tanggal_jatuh_tempo
        date tanggal_kembali
        enum status
        decimal denda
        text catatan
        timestamp created_at
        timestamp updated_at
    }
```

## Relationship Details

### 1. USERS → TRANSACTIONS (One to Many)
- **Relationship**: One user can create multiple transactions
- **Foreign Key**: `transactions.user_id` references `users.id`
- **On Delete**: RESTRICT (cannot delete user who has transactions)

### 2. BOOKS → TRANSACTIONS (One to Many)
- **Relationship**: One book can be borrowed in multiple transactions
- **Foreign Key**: `transactions.book_id` references `books.id`
- **On Delete**: RESTRICT (cannot delete book with active transactions)

### 3. MEMBERS → TRANSACTIONS (One to Many)
- **Relationship**: One member can have multiple transactions
- **Foreign Key**: `transactions.member_id` references `members.id`
- **On Delete**: RESTRICT (cannot delete member with active transactions)

## Indexes

### USERS
- Primary Key: `id`
- Unique: `email`

### BOOKS
- Primary Key: `id`
- Unique: `kode_buku`
- Index: `kategori`
- Index: `judul`

### MEMBERS
- Primary Key: `id`
- Unique: `kode_anggota`, `nis`
- Index: `status`

### TRANSACTIONS
- Primary Key: `id`
- Unique: `kode_transaksi`
- Index: `status`
- Composite Index: `(book_id, status)`
- Composite Index: `(member_id, status)`
- Foreign Keys: `book_id`, `member_id`, `user_id`

## Business Rules

1. **Book Stock Management**:
   - `jumlah_tersedia` must always be ≤ `jumlah_stok`
   - When a book is borrowed, `jumlah_tersedia` decreases by 1
   - When a book is returned, `jumlah_tersedia` increases by 1

2. **Transaction Status**:
   - `dipinjam`: Book is currently borrowed
   - `dikembalikan`: Book has been returned on time
   - `terlambat`: Book was returned after due date or is still borrowed past due date

3. **Member Status**:
   - `aktif`: Member can borrow books
   - `nonaktif`: Member cannot borrow books

4. **User Roles**:
   - `admin`: Full access to all features
   - `user`: Limited access (can create transactions, view catalogs)

## Data Integrity Constraints

1. Books cannot be deleted if they have active transactions (status = 'dipinjam')
2. Members cannot be deleted if they have active transactions
3. Users cannot be deleted if they have transactions
4. `kode_buku`, `kode_anggota`, `kode_transaksi`, `nis`, `email` must be unique
5. All foreign key constraints use RESTRICT on delete
