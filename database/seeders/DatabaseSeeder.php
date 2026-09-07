<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        $user = User::create([
            'name' => 'User Demo',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Books
        $books = [
            [
                'kode_buku' => 'BK-001',
                'judul' => 'Pemrograman Web dengan Laravel',
                'penulis' => 'John Doe',
                'penerbit' => 'Tech Publisher',
                'tahun_terbit' => 2023,
                'kategori' => 'Teknologi',
                'jumlah_stok' => 5,
                'jumlah_tersedia' => 4,
                'lokasi_rak' => 'A1',
                'deskripsi' => 'Buku panduan lengkap Laravel framework',
            ],
            [
                'kode_buku' => 'BK-002',
                'judul' => 'Database Management Systems',
                'penulis' => 'Jane Smith',
                'penerbit' => 'Database Press',
                'tahun_terbit' => 2022,
                'kategori' => 'Teknologi',
                'jumlah_stok' => 3,
                'jumlah_tersedia' => 3,
                'lokasi_rak' => 'A2',
                'deskripsi' => 'Konsep dan implementasi DBMS',
            ],
            [
                'kode_buku' => 'BK-003',
                'judul' => 'Algoritma dan Struktur Data',
                'penulis' => 'Robert Johnson',
                'penerbit' => 'Algorithm Books',
                'tahun_terbit' => 2024,
                'kategori' => 'Teknologi',
                'jumlah_stok' => 4,
                'jumlah_tersedia' => 4,
                'lokasi_rak' => 'A3',
                'deskripsi' => 'Dasar-dasar algoritma pemrograman',
            ],
            [
                'kode_buku' => 'BK-004',
                'judul' => 'Bahasa Indonesia untuk SMK',
                'penulis' => 'Sri Wahyuni',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2023,
                'kategori' => 'Bahasa',
                'jumlah_stok' => 10,
                'jumlah_tersedia' => 10,
                'lokasi_rak' => 'B1',
                'deskripsi' => 'Buku pelajaran Bahasa Indonesia',
            ],
            [
                'kode_buku' => 'BK-005',
                'judul' => 'Matematika Dasar',
                'penulis' => 'Budi Santoso',
                'penerbit' => 'Erlangga',
                'tahun_terbit' => 2022,
                'kategori' => 'Matematika',
                'jumlah_stok' => 8,
                'jumlah_tersedia' => 8,
                'lokasi_rak' => 'C1',
                'deskripsi' => 'Matematika untuk SMK',
            ],
            [
                'kode_buku' => 'BK-006',
                'judul' => 'Fisika untuk SMK',
                'penulis' => 'Drs. Ahmad',
                'penerbit' => 'Yudhistira',
                'tahun_terbit' => 2023,
                'kategori' => 'Sains',
                'jumlah_stok' => 6,
                'jumlah_tersedia' => 6,
                'lokasi_rak' => 'C2',
                'deskripsi' => 'Buku pelajaran Fisika',
            ],
            [
                'kode_buku' => 'BK-007',
                'judul' => 'Desain Grafis dengan Photoshop',
                'penulis' => 'Maya Sari',
                'penerbit' => 'Media Kom',
                'tahun_terbit' => 2024,
                'kategori' => 'Teknologi',
                'jumlah_stok' => 5,
                'jumlah_tersedia' => 5,
                'lokasi_rak' => 'A4',
                'deskripsi' => 'Panduan desain grafis praktis',
            ],
            [
                'kode_buku' => 'BK-008',
                'judul' => 'Jaringan Komputer',
                'penulis' => 'Andi Wijaya',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2023,
                'kategori' => 'Teknologi',
                'jumlah_stok' => 4,
                'jumlah_tersedia' => 3,
                'lokasi_rak' => 'A5',
                'deskripsi' => 'Konsep dan praktik jaringan',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Create Members
        $members = [
            [
                'kode_anggota' => 'A-001',
                'nama' => 'Andi Pratama',
                'nis' => '2023001',
                'kelas' => 'XII RPL 1',
                'alamat' => 'Jl. Merdeka No. 123',
                'no_telepon' => '081234567890',
                'status' => 'aktif',
            ],
            [
                'kode_anggota' => 'A-002',
                'nama' => 'Siti Nurhaliza',
                'nis' => '2023002',
                'kelas' => 'XII RPL 1',
                'alamat' => 'Jl. Sudirman No. 45',
                'no_telepon' => '081234567891',
                'status' => 'aktif',
            ],
            [
                'kode_anggota' => 'A-003',
                'nama' => 'Budi Setiawan',
                'nis' => '2023003',
                'kelas' => 'XI RPL 2',
                'alamat' => 'Jl. Gatot Subroto No. 78',
                'no_telepon' => '081234567892',
                'status' => 'aktif',
            ],
            [
                'kode_anggota' => 'A-004',
                'nama' => 'Dewi Lestari',
                'nis' => '2023004',
                'kelas' => 'XI RPL 2',
                'alamat' => 'Jl. Ahmad Yani No. 90',
                'no_telepon' => '081234567893',
                'status' => 'aktif',
            ],
            [
                'kode_anggota' => 'A-005',
                'nama' => 'Eko Prasetyo',
                'nis' => '2023005',
                'kelas' => 'X RPL 1',
                'alamat' => 'Jl. Diponegoro No. 12',
                'no_telepon' => '081234567894',
                'status' => 'aktif',
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }

        // Create sample transactions
        $book1 = Book::where('kode_buku', 'BK-001')->first();
        $book2 = Book::where('kode_buku', 'BK-008')->first();
        $member1 = Member::where('kode_anggota', 'A-001')->first();
        $member2 = Member::where('kode_anggota', 'A-002')->first();

        // Active transaction
        Transaction::create([
            'kode_transaksi' => 'TRX-' . now()->format('Ymd') . '-001',
            'book_id' => $book1->id,
            'member_id' => $member1->id,
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->subDays(3),
            'tanggal_jatuh_tempo' => now()->addDays(4),
            'status' => 'dipinjam',
        ]);

        // Another active transaction
        Transaction::create([
            'kode_transaksi' => 'TRX-' . now()->format('Ymd') . '-002',
            'book_id' => $book2->id,
            'member_id' => $member2->id,
            'user_id' => $user->id,
            'tanggal_pinjam' => now()->subDays(5),
            'tanggal_jatuh_tempo' => now()->addDays(2),
            'status' => 'dipinjam',
        ]);

        // Completed transaction
        Transaction::create([
            'kode_transaksi' => 'TRX-' . now()->subDays(10)->format('Ymd') . '-001',
            'book_id' => $book1->id,
            'member_id' => $member1->id,
            'user_id' => $admin->id,
            'tanggal_pinjam' => now()->subDays(15),
            'tanggal_jatuh_tempo' => now()->subDays(8),
            'tanggal_kembali' => now()->subDays(10),
            'status' => 'dikembalikan',
            'denda' => 0,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('User: user@example.com / password');
    }
}
