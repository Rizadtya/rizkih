<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\LibraryService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(
        protected LibraryService $libraryService
    ) {}

    // Admin: List all books
    public function index(Request $request)
    {
        $query = Book::query();

        // Search
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('kode_buku', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($kategori = $request->get('kategori')) {
            $query->where('kategori', $kategori);
        }

        $books = $query->latest()->paginate(15);
        $categories = Book::distinct()->pluck('kategori');

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|unique:books',
            'judul' => 'required|max:200',
            'penulis' => 'required|max:100',
            'penerbit' => 'required|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'kategori' => 'required|max:50',
            'jumlah_stok' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable|max:50',
            'deskripsi' => 'nullable',
        ]);

        $validated['jumlah_tersedia'] = $validated['jumlah_stok'];

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Book $book)
    {
        $book->load('transactions.member');
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|unique:books,kode_buku,' . $book->id,
            'judul' => 'required|max:200',
            'penulis' => 'required|max:100',
            'penerbit' => 'required|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'kategori' => 'required|max:50',
            'jumlah_stok' => 'required|integer|min:0',
            'lokasi_rak' => 'nullable|max:50',
            'deskripsi' => 'nullable',
        ]);

        // Adjust available stock based on stock change
        $stockDiff = $validated['jumlah_stok'] - $book->jumlah_stok;
        $validated['jumlah_tersedia'] = max(0, $book->jumlah_tersedia + $stockDiff);

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Book $book)
    {
        // Check if book has active transactions
        if ($book->activeTransactions()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus buku yang masih dipinjam');
        }

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus');
    }

    // User: Book catalog
    public function catalog(Request $request)
    {
        $query = Book::where('jumlah_tersedia', '>', 0);

        // Search
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($kategori = $request->get('kategori')) {
            $query->where('kategori', $kategori);
        }

        $books = $query->latest()->paginate(12);
        $categories = Book::distinct()->pluck('kategori');

        return view('user.books.catalog', compact('books', 'categories'));
    }

    // User: Borrow a book
    public function borrow(Request $request, Book $book)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        try {
            $this->libraryService->borrowBook(
                $book,
                \App\Models\Member::findOrFail($request->member_id),
                auth()->id()
            );

            return back()->with('success', 'Buku berhasil dipinjam');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
