@extends('layouts.app')

@section('title', 'Dashboard User')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('user.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.books.catalog') }}">
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
<style>
/* User Dashboard - Newsprint Design System */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--space-6);
    padding-bottom: var(--space-4);
    border-bottom: 1px solid var(--color-border);
}

.page-header-content h1 {
    font-family: var(--font-display);
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
    margin: 0 0 var(--space-2) 0;
    line-height: var(--leading-tight);
}

.page-header-content p {
    font-size: var(--text-base);
    color: var(--color-ink-2);
    margin: 0;
}

.page-header-date {
    font-size: var(--text-sm);
    color: var(--color-ink-2);
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-4);
    margin-bottom: var(--space-6);
}

@media (min-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.stat-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-left: 3px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: var(--space-6);
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.stat-card.stat-default {
    border-left-color: var(--color-accent);
}

.stat-card.stat-warning {
    border-left-color: var(--color-warning);
}

.stat-card.stat-danger {
    border-left-color: var(--color-danger);
}

.stat-content h5 {
    font-family: var(--font-body);
    font-size: var(--text-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-ink-2);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin: 0 0 var(--space-2) 0;
}

.stat-content h2 {
    font-family: var(--font-display);
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-bold);
    color: var(--color-ink);
    margin: 0;
    line-height: 1;
}

.stat-icon {
    font-size: 2rem;
    opacity: 0.15;
    color: var(--color-ink);
}

/* Section Card */
.section-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    overflow: hidden;
    margin-bottom: var(--space-6);
}

.card-header {
    padding: var(--space-5) var(--space-6);
    border-bottom: 1px solid var(--color-border);
    background: var(--color-paper-2);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-family: var(--font-display);
    font-size: var(--text-xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-2) var(--space-4);
    font-family: var(--font-body);
    font-size: var(--text-sm);
    font-weight: var(--font-weight-medium);
    border-radius: var(--radius-sm);
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: var(--transition-colors), var(--transition-transform);
    line-height: 1;
}

.btn-outline {
    background: transparent;
    color: var(--color-accent);
    border: 1px solid var(--color-accent);
}

.btn-outline:hover {
    background: var(--color-accent-subtle);
    color: var(--color-accent);
}

.btn-success {
    background: var(--color-success);
    color: var(--color-paper);
}

.btn-success:hover {
    background: var(--color-success-hover);
    color: var(--color-paper);
}

.btn-success:active {
    transform: translateY(1px);
}

/* Table */
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

.data-table code {
    font-family: var(--font-mono);
    font-size: var(--text-xs);
    background: var(--color-paper-2);
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-sm);
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

.badge-primary {
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

.empty-state {
    padding: var(--space-12) var(--space-6);
    text-align: center;
    color: var(--color-ink-2);
}

.empty-state i {
    font-size: 2rem;
    opacity: 0.3;
    display: block;
    margin-bottom: var(--space-3);
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: var(--space-3);
    }

    .page-header-content h1 {
        font-size: var(--text-2xl);
    }

    .data-table {
        font-size: var(--text-xs);
    }

    .data-table th,
    .data-table td {
        padding: var(--space-3) var(--space-4);
    }
}
</style>

<div class="page-header">
    <div class="page-header-content">
        <h1>Dashboard</h1>
        <p>Selamat datang, {{ auth()->user()->name }}</p>
    </div>
    <div class="page-header-date">
        <i class="bi bi-calendar3"></i>
        <span>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card stat-default">
        <div class="stat-content">
            <h5>Buku Tersedia</h5>
            <h2>{{ $availableBooks }}</h2>
        </div>
        <i class="bi bi-book stat-icon"></i>
    </div>
    <div class="stat-card stat-warning">
        <div class="stat-content">
            <h5>Sedang Dipinjam</h5>
            <h2>{{ $myActiveLoans->count() }}</h2>
        </div>
        <i class="bi bi-arrow-repeat stat-icon"></i>
    </div>
    <div class="stat-card stat-danger">
        <div class="stat-content">
            <h5>Terlambat</h5>
            <h2>{{ $lateLoans }}</h2>
        </div>
        <i class="bi bi-exclamation-triangle stat-icon"></i>
    </div>
</div>

<!-- Active Loans -->
<div class="section-card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="bi bi-clock-history"></i> Peminjaman Aktif
        </h2>
        <a href="{{ route('user.loans') }}" class="btn btn-outline">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Buku</th>
                    <th>Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($myActiveLoans as $loan)
                    <tr>
                        <td><code>{{ $loan->kode_transaksi }}</code></td>
                        <td>{{ Str::limit($loan->book->judul, 40) }}</td>
                        <td>{{ $loan->member->nama }}</td>
                        <td>{{ $loan->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>{{ $loan->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                        <td>
                            @if($loan->status === 'terlambat')
                                <span class="badge badge-danger">Terlambat</span>
                            @else
                                <span class="badge badge-primary">Dipinjam</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('user.transactions.return', $loan) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Kembalikan buku ini?')">
                                    <i class="bi bi-check-circle"></i> Kembalikan
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Tidak ada peminjaman aktif</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Transaction History -->
<div class="section-card">
    <div class="card-header">
        <h2 class="card-title">
            <i class="bi bi-file-earmark-text"></i> Riwayat Peminjaman
        </h2>
    </div>
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($myTransactions as $trans)
                    <tr>
                        <td><code>{{ $trans->kode_transaksi }}</code></td>
                        <td>{{ Str::limit($trans->book->judul, 40) }}</td>
                        <td>{{ $trans->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>{{ $trans->tanggal_kembali ? $trans->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($trans->status === 'dipinjam')
                                <span class="badge badge-primary">Dipinjam</span>
                            @elseif($trans->status === 'dikembalikan')
                                <span class="badge badge-success">Dikembalikan</span>
                            @else
                                <span class="badge badge-danger">Terlambat</span>
                            @endif
                        </td>
                        <td>{{ $trans->denda > 0 ? 'Rp ' . number_format($trans->denda, 0, ',', '.') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada riwayat</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
