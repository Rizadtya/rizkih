@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('admin.dashboard') }}">
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
            <a class="nav-link" href="{{ route('admin.transactions.index') }}">
                <i class="bi bi-arrow-left-right"></i> Transaksi
            </a>
        </li>
    </ul>
@endsection

@section('content')
<style>
/* Admin Dashboard - Newsprint Design System */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-8);
    padding-bottom: var(--space-6);
    border-bottom: 1px solid var(--color-border);
}

.dashboard-title {
    font-family: var(--font-display);
    font-size: var(--text-4xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
    margin: 0;
    line-height: var(--leading-tight);
}

.dashboard-subtitle {
    font-size: var(--text-sm);
    color: var(--color-ink-2);
    margin-top: var(--space-2);
}

.dashboard-date {
    font-size: var(--text-sm);
    color: var(--color-ink-3);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: var(--space-6);
    margin-bottom: var(--space-8);
}

/* Stat Card - NO gradients */
.stat-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-left: 3px solid var(--color-accent);
    border-radius: var(--radius-md);
    padding: var(--space-6);
    transition: var(--transition-colors), var(--transition-shadow);
}

.stat-card:hover {
    border-color: var(--color-border-emphasis);
    box-shadow: var(--shadow-sm);
}

.stat-card-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.stat-card-info {
    flex: 1;
}

.stat-card-label {
    font-family: var(--font-body);
    font-size: var(--text-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-ink-2);
    text-transform: uppercase;
    letter-spacing: var(--tracking-wider);
    margin-bottom: var(--space-2);
}

.stat-card-value {
    font-family: var(--font-display);
    font-size: var(--text-4xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
    line-height: var(--leading-tight);
}

.stat-card-icon {
    font-size: 2rem;
    color: var(--color-ink-3);
    opacity: 0.3;
}

/* Stat variants */
.stat-card.stat-success {
    border-left-color: var(--color-success);
}

.stat-card.stat-info {
    border-left-color: var(--color-info);
}

.stat-card.stat-warning {
    border-left-color: var(--color-warning);
}

.stat-card.stat-danger {
    border-left-color: var(--color-danger);
}

/* Secondary Stats */
.secondary-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-4);
    margin-bottom: var(--space-8);
}

.secondary-stat-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: var(--space-5);
    display: flex;
    align-items: center;
    gap: var(--space-4);
}

.secondary-stat-icon {
    font-size: 2rem;
    flex-shrink: 0;
}

.secondary-stat-icon.text-primary {
    color: var(--color-accent);
}

.secondary-stat-icon.text-success {
    color: var(--color-success);
}

.secondary-stat-icon.text-danger {
    color: var(--color-danger);
}

.secondary-stat-content {
    flex: 1;
}

.secondary-stat-label {
    font-size: var(--text-xs);
    color: var(--color-ink-2);
    margin-bottom: var(--space-1);
}

.secondary-stat-value {
    font-family: var(--font-display);
    font-size: var(--text-2xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
}

.secondary-stat-value.text-danger {
    color: var(--color-danger);
}

/* Transactions Section */
.transactions-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.transactions-header {
    padding: var(--space-6);
    border-bottom: 1px solid var(--color-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.transactions-title {
    font-family: var(--font-display);
    font-size: var(--text-xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.transactions-link {
    font-size: var(--text-sm);
    color: var(--color-accent);
    text-decoration: none;
    font-weight: var(--font-weight-medium);
    display: flex;
    align-items: center;
    gap: var(--space-1);
    transition: var(--transition-colors);
}

.transactions-link:hover {
    color: var(--color-accent-hover);
}

/* Table */
.table-container {
    overflow-x: auto;
}

.dashboard-table {
    width: 100%;
    border-collapse: collapse;
}

.dashboard-table thead {
    background: var(--color-paper-2);
    border-bottom: 2px solid var(--color-border-emphasis);
}

.dashboard-table th {
    padding: var(--space-3) var(--space-4);
    text-align: left;
    font-family: var(--font-body);
    font-size: var(--text-xs);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink-2);
    text-transform: uppercase;
    letter-spacing: var(--tracking-wider);
}

.dashboard-table td {
    padding: var(--space-4);
    border-bottom: 1px solid var(--color-border);
    font-size: var(--text-sm);
    color: var(--color-ink);
}

.dashboard-table tbody tr {
    transition: background-color var(--duration-fast) var(--ease-out);
}

.dashboard-table tbody tr:hover {
    background: var(--color-paper-3);
}

.dashboard-table tbody tr:last-child td {
    border-bottom: none;
}

.dashboard-table code {
    font-family: var(--font-mono);
    font-size: var(--text-xs);
    background: var(--color-paper-3);
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-sm);
}

/* Status badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: var(--space-1) var(--space-3);
    font-size: var(--text-xs);
    font-weight: var(--font-weight-medium);
    border-radius: var(--radius-full);
    text-transform: uppercase;
    letter-spacing: var(--tracking-wider);
}

.status-badge.badge-primary {
    background: var(--color-accent-subtle);
    color: var(--color-accent);
}

.status-badge.badge-success {
    background: var(--color-success-subtle);
    color: var(--color-success);
}

.status-badge.badge-danger {
    background: var(--color-danger-subtle);
    color: var(--color-danger);
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: var(--space-12) var(--space-6);
    color: var(--color-ink-3);
}

.empty-state-icon {
    font-size: 3rem;
    opacity: 0.3;
    margin-bottom: var(--space-4);
}

.empty-state-text {
    font-size: var(--text-base);
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-3);
    }

    .dashboard-title {
        font-size: var(--text-3xl);
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .secondary-stats {
        grid-template-columns: 1fr;
    }

    .transactions-header {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-3);
    }
}
</style>

<div class="dashboard-header">
    <div>
        <h1 class="dashboard-title">Dashboard</h1>
        <p class="dashboard-subtitle">Ringkasan data perpustakaan</p>
    </div>
    <div class="dashboard-date">
        <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
    </div>
</div>

<!-- Primary Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-card-info">
                <div class="stat-card-label">Total Buku</div>
                <div class="stat-card-value">{{ $totalBooks }}</div>
            </div>
            <i class="bi bi-book stat-card-icon"></i>
        </div>
    </div>

    <div class="stat-card stat-success">
        <div class="stat-card-content">
            <div class="stat-card-info">
                <div class="stat-card-label">Total Anggota</div>
                <div class="stat-card-value">{{ $totalMembers }}</div>
            </div>
            <i class="bi bi-people stat-card-icon"></i>
        </div>
    </div>

    <div class="stat-card stat-info">
        <div class="stat-card-content">
            <div class="stat-card-info">
                <div class="stat-card-label">Buku Tersedia</div>
                <div class="stat-card-value">{{ $availableBooks }}</div>
            </div>
            <i class="bi bi-check-circle stat-card-icon"></i>
        </div>
    </div>

    <div class="stat-card stat-warning">
        <div class="stat-card-content">
            <div class="stat-card-info">
                <div class="stat-card-label">Dipinjam</div>
                <div class="stat-card-value">{{ $borrowedBooks }}</div>
            </div>
            <i class="bi bi-arrow-repeat stat-card-icon"></i>
        </div>
    </div>
</div>

<!-- Secondary Statistics -->
<div class="secondary-stats">
    <div class="secondary-stat-card">
        <i class="bi bi-file-earmark-text secondary-stat-icon text-primary"></i>
        <div class="secondary-stat-content">
            <div class="secondary-stat-label">Total Transaksi</div>
            <div class="secondary-stat-value">{{ $totalTransactions }}</div>
        </div>
    </div>

    <div class="secondary-stat-card">
        <i class="bi bi-clock-history secondary-stat-icon text-success"></i>
        <div class="secondary-stat-content">
            <div class="secondary-stat-label">Transaksi Aktif</div>
            <div class="secondary-stat-value">{{ $activeTransactions }}</div>
        </div>
    </div>

    <div class="secondary-stat-card">
        <i class="bi bi-exclamation-triangle secondary-stat-icon text-danger"></i>
        <div class="secondary-stat-content">
            <div class="secondary-stat-label">Terlambat</div>
            <div class="secondary-stat-value text-danger">{{ $lateTransactions }}</div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="transactions-card">
    <div class="transactions-header">
        <h2 class="transactions-title">
            <i class="bi bi-clock-history"></i>
            Transaksi Terbaru
        </h2>
        <a href="{{ route('admin.transactions.index') }}" class="transactions-link">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="table-container">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Buku</th>
                    <th>Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $trans)
                    <tr>
                        <td><code>{{ $trans->kode_transaksi }}</code></td>
                        <td>{{ Str::limit($trans->book->judul, 40) }}</td>
                        <td>{{ $trans->member->nama }}</td>
                        <td>{{ $trans->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td>{{ $trans->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                        <td>
                            @if($trans->status === 'dipinjam')
                                <span class="status-badge badge-primary">Dipinjam</span>
                            @elseif($trans->status === 'dikembalikan')
                                <span class="status-badge badge-success">Dikembalikan</span>
                            @else
                                <span class="status-badge badge-danger">Terlambat</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="bi bi-inbox empty-state-icon"></i>
                                <p class="empty-state-text">Belum ada transaksi</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
