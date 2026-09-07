@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.books.index') }}">
                <i class="bi bi-book"></i> Data Buku
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.members.index') }}">
                <i class="bi bi-people"></i> Data Anggota
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.transactions.index') }}">
                <i class="bi bi-arrow-left-right"></i> Transaksi
            </a>
        </li>
    </ul>
@endsection

@section('content')
<style>
/* Transactions Index - Newsprint Design System */
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
    background: var(--color-info-hover);
    color: var(--color-paper);
}

.btn-success {
    background: var(--color-success);
    color: var(--color-paper);
}

.btn-success:hover {
    background: var(--color-success-hover);
    color: var(--color-paper);
}

/* Filter Card */
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
        align-items: end;
    }
}

.form-control {
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

.form-control:hover {
    border-color: var(--color-border-emphasis);
}

.form-control:focus {
    border-color: var(--color-accent);
    box-shadow: var(--shadow-focus);
    outline: none;
}

.filter-actions {
    display: flex;
    gap: var(--space-3);
}

@media (max-width: 767px) {
    .filter-actions {
        grid-column: 1 / -1;
    }

    .filter-actions .btn {
        flex: 1;
    }
}

/* Table Card */
.table-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.table-wrapper {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: var(--text-sm);
}

.data-table thead {
    background: var(--color-paper-2);
    border-bottom: 1px solid var(--color-border);
}

.data-table th {
    padding: var(--space-4) var(--space-5);
    text-align: left;
    font-family: var(--font-body);
    font-size: var(--text-xs);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink-2);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.data-table tbody tr {
    border-bottom: 1px solid var(--color-border);
    transition: background-color var(--transition-fast);
}

.data-table tbody tr:hover {
    background: var(--color-paper-2);
}

.data-table tbody tr:last-child {
    border-bottom: none;
}

.data-table td {
    padding: var(--space-4) var(--space-5);
    color: var(--color-ink);
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: var(--space-1) var(--space-3);
    font-size: var(--text-xs);
    font-weight: var(--font-weight-medium);
    border-radius: var(--radius-full);
    line-height: 1;
}

.badge-warning {
    background: var(--color-warning-subtle);
    color: var(--color-warning);
}

.badge-success {
    background: var(--color-success-subtle);
    color: var(--color-success);
}

.badge-danger {
    background: var(--color-danger-subtle);
    color: var(--color-danger);
}

.action-group {
    display: flex;
    gap: var(--space-2);
}

.action-group form {
    display: contents;
}

.empty-state {
    padding: var(--space-12) var(--space-6);
    text-align: center;
    color: var(--color-ink-2);
}

.pagination-wrapper {
    padding: var(--space-5) var(--space-6);
    border-top: 1px solid var(--color-border);
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-4);
    }

    .page-title {
        font-size: var(--text-2xl);
    }

    .data-table {
        font-size: var(--text-xs);
    }

    .data-table th,
    .data-table td {
        padding: var(--space-3) var(--space-4);
    }

    .action-group {
        flex-direction: column;
    }

    .btn-sm {
        padding: var(--space-2) var(--space-3);
        font-size: var(--text-xs);
    }
}
</style>

<div class="page-header">
    <h1 class="page-title">Data Transaksi</h1>
    <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Transaksi
    </a>
</div>

<!-- Filter Card -->
<div class="filter-card">
    <form method="GET" class="filter-form">
        <input
            type="text"
            class="form-control"
            name="search"
            placeholder="Cari transaksi..."
            value="{{ request('search') }}"
        >
        <select class="form-control" name="status">
            <option value="">Semua Status</option>
            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
        </select>
        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Cari
            </button>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="table-card">
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Buku</th>
                    <th>Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->kode_transaksi }}</td>
                        <td>{{ $transaction->book->judul ?? '-' }}</td>
                        <td>{{ $transaction->member->nama ?? '-' }}</td>
                        <td>{{ $transaction->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>{{ $transaction->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                        <td>{{ $transaction->tanggal_kembali ? $transaction->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($transaction->status == 'dipinjam')
                                <span class="badge badge-warning">Dipinjam</span>
                            @elseif($transaction->status == 'dikembalikan')
                                <span class="badge badge-success">Dikembalikan</span>
                            @else
                                <span class="badge badge-danger">Terlambat</span>
                            @endif
                        </td>
                        <td>{{ $transaction->denda > 0 ? 'Rp ' . number_format($transaction->denda, 0, ',', '.') : '-' }}</td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($transaction->status == 'dipinjam' || $transaction->status == 'terlambat')
                                    <form action="{{ route('admin.transactions.return', $transaction) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi pengembalian buku?')">
                                            <i class="bi bi-arrow-return-left"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="empty-state">
                            Tidak ada data transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
    <div class="pagination-wrapper">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
