@extends('layouts.app')

@section('title', 'Detail Anggota')

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
            <a class="nav-link active" href="{{ route('admin.members.index') }}">
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
/* Member Detail - Newsprint Design System */
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

.page-actions {
    display: flex;
    gap: var(--space-3);
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

.btn-warning {
    background: var(--color-warning);
    color: var(--color-ink);
}

.btn-warning:hover {
    background: var(--color-warning-hover);
    color: var(--color-ink);
}

.btn-warning:active {
    transform: translateY(1px);
}

.btn-warning:focus-visible {
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

/* Main Layout */
.detail-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-6);
    margin-bottom: var(--space-6);
}

@media (min-width: 768px) {
    .detail-layout {
        grid-template-columns: 1fr 1fr;
    }
}

.info-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.card-header {
    padding: var(--space-5) var(--space-6);
    border-bottom: 1px solid var(--color-border);
    background: var(--color-paper-2);
}

.card-title {
    font-family: var(--font-display);
    font-size: var(--text-xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
    margin: 0;
}

.card-body {
    padding: var(--space-6);
}

/* Info Table */
.info-table {
    width: 100%;
    border-collapse: collapse;
}

.info-table tr {
    border-bottom: 1px solid var(--color-border);
}

.info-table tr:last-child {
    border-bottom: none;
}

.info-table th {
    padding: var(--space-4) var(--space-2) var(--space-4) 0;
    text-align: left;
    font-family: var(--font-body);
    font-size: var(--text-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-ink-2);
    width: 40%;
    vertical-align: top;
}

.info-table td {
    padding: var(--space-4) 0 var(--space-4) var(--space-2);
    font-size: var(--text-sm);
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

.badge-success {
    background: var(--color-success-subtle);
    color: var(--color-success);
}

.badge-secondary {
    background: var(--color-paper-3);
    color: var(--color-ink-2);
}

.badge-warning {
    background: var(--color-warning-subtle);
    color: var(--color-warning);
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--space-4);
}

.stat-box {
    background: var(--color-paper-2);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-sm);
    padding: var(--space-5);
    text-align: center;
}

.stat-value {
    font-family: var(--font-display);
    font-size: var(--text-3xl);
    font-weight: var(--font-weight-bold);
    color: var(--color-ink);
    margin: 0 0 var(--space-2) 0;
    line-height: 1;
}

.stat-label {
    font-size: var(--text-xs);
    color: var(--color-ink-2);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Transaction History */
.history-card {
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

.empty-state {
    padding: var(--space-12) var(--space-6);
    text-align: center;
    color: var(--color-ink-2);
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

    .page-actions {
        width: 100%;
        flex-direction: column;
    }

    .page-actions .btn {
        width: 100%;
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
    <h1 class="page-title">Detail Anggota</h1>
    <div class="page-actions">
        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="detail-layout">
    <!-- Member Information -->
    <div class="info-card">
        <div class="card-header">
            <h2 class="card-title">Informasi Anggota</h2>
        </div>
        <div class="card-body">
            <table class="info-table">
                <tr>
                    <th>Kode Anggota</th>
                    <td>{{ $member->kode_anggota }}</td>
                </tr>
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $member->nama }}</td>
                </tr>
                <tr>
                    <th>NIS</th>
                    <td>{{ $member->nis }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $member->kelas }}</td>
                </tr>
                <tr>
                    <th>No. Telepon</th>
                    <td>{{ $member->no_telepon ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($member->status == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $member->alamat ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Borrowing Statistics -->
    <div class="info-card">
        <div class="card-header">
            <h2 class="card-title">Statistik Peminjaman</h2>
        </div>
        <div class="card-body">
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-value">{{ $member->transactions->count() }}</div>
                    <div class="stat-label">Total Peminjaman</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">{{ $member->activeTransactions->count() }}</div>
                    <div class="stat-label">Sedang Dipinjam</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transaction History -->
<div class="history-card">
    <div class="card-header">
        <h2 class="card-title">Riwayat Peminjaman</h2>
    </div>
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal Pinjam</th>
                    <th>Buku</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($member->transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->tanggal_pinjam }}</td>
                        <td>{{ $transaction->book->judul }}</td>
                        <td>{{ $transaction->tanggal_kembali ?? '-' }}</td>
                        <td>
                            @if($transaction->status == 'dipinjam')
                                <span class="badge badge-warning">Dipinjam</span>
                            @else
                                <span class="badge badge-success">Dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">
                            Belum ada riwayat peminjaman
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
