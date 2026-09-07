@extends('layouts.app')

@section('title', 'Data Buku')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.books.index') }}">
                <i class="bi bi-book"></i> Data Buku
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.members.index') }}">
                <i class="bi bi-people"></i> Data Anggota
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.transactions.index') }}">
                <i class="bi bi-arrow-left-right"></i> Transaksi
            </a>
        </li>
    </ul>
@endsection

@section('content')
<style>
/* Books Index - Newsprint Design System */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
    padding-bottom: var(--space-4);
    border-bottom: 1px solid var(--color-border);
}

.page-title {
    font-family: var(--font-display);
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
    margin: 0;
    line-height: var(--leading-tight);
}

/* Search & Filter Card */
.filter-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: var(--space-6);
    margin-bottom: var(--space-6);
}

.filter-form {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-4);
}

@media (min-width: 768px) {
    .filter-form {
        grid-template-columns: 2fr 1.5fr auto;
    }
}

.form-input {
    width: 100%;
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-sm);
    padding: var(--space-3) var(--space-4);
    font-family: var(--font-body);
    font-size: var(--text-base);
    color: var(--color-ink);
    transition: var(--transition-colors), var(--transition-shadow);
}

.form-input:hover {
    border-color: var(--color-border-emphasis);
}

.form-input:focus {
    border-color: var(--color-accent);
    box-shadow: var(--shadow-focus);
    outline: none;
}

.form-input::placeholder {
    color: var(--color-ink-3);
}

.form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='%23666' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right var(--space-4) center;
    padding-right: var(--space-10);
}

.filter-actions {
    display: flex;
    gap: var(--space-2);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-3) var(--space-6);
    font-family: var(--font-body);
    font-size: var(--text-base);
    font-weight: var(--font-weight-medium);
    border-radius: var(--radius-sm);
    border: none;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    transition: var(--transition-colors), var(--transition-transform);
    line-height: 1;
}

.btn-primary {
    background: var(--color-accent);
    color: var(--color-paper);
}

.btn-primary:hover {
    background: var(--color-accent-hover);
    color: var(--color-paper);
}

.btn-primary:active {
    transform: translateY(1px);
}

.btn-primary:focus-visible {
    outline: 2px solid var(--color-focus);
    outline-offset: 2px;
}

.btn-secondary {
    background: transparent;
    color: var(--color-ink);
    border: 1px solid var(--color-border-emphasis);
}

.btn-secondary:hover {
    background: var(--color-paper-3);
    color: var(--color-ink);
}

.btn-sm {
    padding: var(--space-2) var(--space-4);
    font-size: var(--text-sm);
}

.btn-info {
    background: var(--color-info);
    color: var(--color-paper);
}

.btn-info:hover {
    background: oklch(from var(--color-info) calc(l * 0.9) c h);
    color: var(--color-paper);
}

.btn-warning {
    background: var(--color-warning);
    color: var(--color-paper);
}

.btn-warning:hover {
    background: oklch(from var(--color-warning) calc(l * 0.9) c h);
    color: var(--color-paper);
}

.btn-danger {
    background: var(--color-danger);
    color: var(--color-paper);
}

.btn-danger:hover {
    background: oklch(from var(--color-danger) calc(l * 0.9) c h);
    color: var(--color-paper);
}

/* Table Card */
.table-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: var(--color-paper-2);
    border-bottom: 2px solid var(--color-border-emphasis);
}

.data-table th {
    padding: var(--space-3) var(--space-4);
    text-align: left;
    font-family: var(--font-body);
    font-size: var(--text-xs);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink-2);
    text-transform: uppercase;
    letter-spacing: var(--tracking-wider);
    white-space: nowrap;
}

.data-table td {
    padding: var(--space-4);
    border-bottom: 1px solid var(--color-border);
    font-size: var(--text-sm);
    color: var(--color-ink);
}

.data-table tbody tr {
    transition: background-color var(--duration-fast) var(--ease-out);
}

.data-table tbody tr:hover {
    background: var(--color-paper-3);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

/* Badge */
.badge {
    display: inline-flex;
    align-items: center;
    padding: var(--space-1) var(--space-3);
    font-size: var(--text-xs);
    font-weight: var(--font-weight-medium);
    border-radius: var(--radius-full);
    text-transform: uppercase;
    letter-spacing: var(--tracking-wider);
}

.badge-info {
    background: var(--color-info-subtle);
    color: var(--color-info);
}

.badge-success {
    background: var(--color-success-subtle);
    color: var(--color-success);
}

.badge-danger {
    background: var(--color-danger-subtle);
    color: var(--color-danger);
}

/* Button Group */
.btn-group {
    display: inline-flex;
    gap: var(--space-1);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: var(--space-16) var(--space-6);
    color: var(--color-ink-3);
}

.empty-state-icon {
    font-size: 4rem;
    opacity: 0.3;
    margin-bottom: var(--space-4);
}

.empty-state-title {
    font-family: var(--font-display);
    font-size: var(--text-xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink-2);
    margin-bottom: var(--space-2);
}

.empty-state-text {
    font-size: var(--text-base);
    color: var(--color-ink-3);
    margin-bottom: var(--space-6);
}

/* Pagination */
.pagination-container {
    padding: var(--space-6);
    border-top: 1px solid var(--color-border);
    display: flex;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-4);
    }

    .page-title {
        font-size: var(--text-2xl);
    }

    .filter-actions {
        width: 100%;
    }

    .filter-actions .btn {
        flex: 1;
    }
}
</style>

<div class="page-header">
    <h1 class="page-title">Data Buku</h1>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Buku
    </a>
</div>

<!-- Search & Filter -->
<div class="filter-card">
    <form method="GET" class="filter-form">
        <input
            type="text"
            class="form-input"
            name="search"
            placeholder="Cari buku (kode, judul, penulis, penerbit)..."
            value="{{ request('search') }}"
        >

        <select class="form-input form-select" name="kategori">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>
                    {{ $cat }}
                </option>
            @endforeach
        </select>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Cari
            </button>
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Books Table -->
<div class="table-card">
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Tersedia</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>
                            <code style="font-family: var(--font-mono); font-size: var(--text-xs); background: var(--color-paper-3); padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm);">
                                {{ $book->kode_buku }}
                            </code>
                        </td>
                        <td style="font-weight: var(--font-weight-medium);">{{ $book->judul }}</td>
                        <td>{{ $book->penulis }}</td>
                        <td>{{ $book->penerbit }}</td>
                        <td>{{ $book->tahun_terbit }}</td>
                        <td>
                            <span class="badge badge-info">{{ $book->kategori }}</span>
                        </td>
                        <td>{{ $book->jumlah_stok }}</td>
                        <td>
                            @if($book->jumlah_tersedia > 0)
                                <span class="badge badge-success">{{ $book->jumlah_tersedia }}</span>
                            @else
                                <span class="badge badge-danger">0</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.books.show', $book) }}" class="btn btn-info btn-sm" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus buku ini?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <i class="bi bi-inbox empty-state-icon"></i>
                                <h3 class="empty-state-title">Tidak ada data buku</h3>
                                <p class="empty-state-text">
                                    @if(request('search') || request('kategori'))
                                        Tidak ada buku yang sesuai dengan pencarian Anda.
                                    @else
                                        Mulai dengan menambahkan buku pertama Anda.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($books->hasPages())
        <div class="pagination-container">
            {{ $books->links() }}
        </div>
    @endif
</div>
@endsection
