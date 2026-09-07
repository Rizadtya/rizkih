<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Services\LibraryService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(protected LibraryService $libraryService) {}

    public function index(Request $request)
    {
        $query = Transaction::with(['book', 'member', 'user']);

        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('book', fn($q) => $q->where('judul', 'like', "%{$search}%"))
                  ->orWhereHas('member', fn($q) => $q->where('nama', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $transactions = $query->latest()->paginate(15);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $books = Book::where('jumlah_tersedia', '>', 0)->get();
        $members = Member::where('status', 'aktif')->get();
        return view('admin.transactions.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'durasi_hari' => 'integer|min:1|max:30',
        ]);

        try {
            $this->libraryService->borrowBook(
                Book::findOrFail($validated['book_id']),
                Member::findOrFail($validated['member_id']),
                auth()->id(),
                $validated['durasi_hari'] ?? 7
            );
            return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['book', 'member', 'user']);
        return view('admin.transactions.show', compact('transaction'));
    }

    public function return(Transaction $transaction)
    {
        try {
            $this->libraryService->returnBook($transaction);
            return back()->with('success', 'Buku berhasil dikembalikan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function myLoans(Request $request)
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->with(['book', 'member'])
            ->when($request->get('status', 'dipinjam'), function($q, $status) {
                if ($status !== 'all') $q->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('user.loans.index', compact('transactions'));
    }

    public function userReturn(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }

        try {
            $this->libraryService->returnBook($transaction);
            return back()->with('success', 'Buku berhasil dikembalikan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
