<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LibraryService
{
    public function borrowBook(Book $book, Member $member, int $userId, int $durasiHari = 7): Transaction
    {
        return DB::transaction(function () use ($book, $member, $userId, $durasiHari) {
            // Check if book is available
            if ($book->jumlah_tersedia <= 0) {
                throw new \Exception('Buku tidak tersedia untuk dipinjam');
            }

            // Check if member is active
            if ($member->status !== 'aktif') {
                throw new \Exception('Anggota tidak aktif');
            }

            // Generate transaction code
            $kodeTransaksi = 'TRX-' . now()->format('YmdHis') . '-' . rand(1000, 9999);

            // Create transaction
            $transaction = Transaction::create([
                'kode_transaksi' => $kodeTransaksi,
                'book_id' => $book->id,
                'member_id' => $member->id,
                'user_id' => $userId,
                'tanggal_pinjam' => now(),
                'tanggal_jatuh_tempo' => now()->addDays($durasiHari),
                'status' => 'dipinjam',
            ]);

            // Decrease available stock
            $book->decrement('jumlah_tersedia');

            return $transaction;
        });
    }

    public function returnBook(Transaction $transaction): Transaction
    {
        return DB::transaction(function () use ($transaction) {
            // Check if already returned
            if ($transaction->status === 'dikembalikan') {
                throw new \Exception('Buku sudah dikembalikan');
            }

            // Set return date
            $transaction->tanggal_kembali = now();

            // Calculate fine if late
            $tanggalJatuhTempo = Carbon::parse($transaction->tanggal_jatuh_tempo);
            $tanggalKembali = Carbon::parse($transaction->tanggal_kembali);

            if ($tanggalKembali->greaterThan($tanggalJatuhTempo)) {
                $hariTerlambat = $tanggalKembali->diffInDays($tanggalJatuhTempo);
                $dendaPerHari = 1000; // Rp 1.000 per hari
                $transaction->denda = $hariTerlambat * $dendaPerHari;
                $transaction->status = 'terlambat';
            } else {
                $transaction->status = 'dikembalikan';
            }

            $transaction->save();

            // Increase available stock
            $transaction->book->increment('jumlah_tersedia');

            return $transaction;
        });
    }

    public function updateLateTransactions(): int
    {
        $today = now()->startOfDay();

        return Transaction::where('status', 'dipinjam')
            ->whereDate('tanggal_jatuh_tempo', '<', $today)
            ->update(['status' => 'terlambat']);
    }
}
