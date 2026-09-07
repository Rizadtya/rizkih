@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('user.books.catalog') }}">
                <i class="bi bi-book"></i> Katalog Buku
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.loans') }}">
                <i class="bi bi-arrow-repeat"></i> Peminjaman Saya
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Katalog Buku</h1>
            <p class="text-muted mb-0">Temukan buku yang tersedia untuk dipinjam</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search"
                               placeholder="Cari judul, penulis, atau kategori..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('user.books.catalog') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Book Grid -->
    @if($books->count() > 0)
        <div class="row g-4 mb-4">
            @foreach($books as $book)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm book-card">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-info">{{ $book->kategori }}</span>
                                @if($book->jumlah_tersedia > 0)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </div>

                            <h5 class="card-title mb-2">{{ Str::limit($book->judul, 50) }}</h5>

                            <div class="text-muted small mb-3">
                                <div class="mb-1">
                                    <i class="bi bi-person"></i> {{ Str::limit($book->penulis, 30) }}
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-building"></i> {{ Str::limit($book->penerbit, 30) }}
                                </div>
                                <div class="mb-1">
                                    <i class="bi bi-calendar"></i> {{ $book->tahun_terbit }}
                                </div>
                            </div>

                            @if($book->deskripsi)
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit($book->deskripsi, 100) }}
                                </p>
                            @endif

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-stack"></i> {{ $book->jumlah_tersedia }} dari {{ $book->jumlah_stok }}
                                    </small>
                                    @if($book->lokasi_rak)
                                        <small class="text-muted">
                                            <i class="bi bi-geo-alt"></i> {{ $book->lokasi_rak }}
                                        </small>
                                    @endif
                                </div>

                                <a href="{{ route('user.books.show', $book) }}" class="btn btn-sm btn-outline-primary w-100">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $books->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; opacity: 0.3;"></i>
                <h4 class="mt-3 text-muted">Tidak ada buku ditemukan</h4>
                <p class="text-muted">Coba ubah kriteria pencarian atau filter Anda</p>
                <a href="{{ route('user.books.catalog') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-clockwise"></i> Reset Pencarian
                </a>
            </div>
        </div>
    @endif
@endsection

@push('styles')
<style>
.book-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endpush
