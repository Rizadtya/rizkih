@extends('layouts.app')

@section('title', 'Detail Buku')

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
/* Book Detail - Newsprint Design System */
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
    color: var(--color-paper);
}

.btn-warning:hover {
    background: oklch(from var(--color-warning) calc(l * 0.9) c h);
    color: var(--color-paper);
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

.detail-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-6);
}

@media (min-width: 768px) {
    .detail-grid {
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

.info-table {
    width: 100%;
}

.info-table tr {
    border-bottom: 1px solid var(--color-border);
}

.info-table tr:last-child {
    border-bottom: none;
}

.info-table th {
    padding: var(--space-3) 0;
    font-family: var(--font-body);
    font-size: var(--text-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-ink-2);
    text-align: left;
    width: 40%;
    vertical-align: top;
}

.info-table td {
    padding: var(--space-3) 0;
    font-family: var(--font-body);
    font-size: var(--text-base);
    color: var(--color-ink);
}

.info-table td strong {
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
}

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

/* Availability Stats */
.availability-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--space-4);
}

.availability-stat {
    background: var(--color-paper-2);
    border-radius: var(--radius-sm);
    padding: var(--space-5);
    text-align: center;
}

.availability-stat.highlight {
    background: var(--color-success-subtle);
}

.availability-stat.highlight .stat-value {
    color: var(--color-success);
}

.availability-stat.warning {
    background: var(--color-danger-subtle);
}

.availability-stat.warning .stat-value {
    color: var(--color-danger);
}

.stat-value {
    font-family: var(--font-display);
    font-size: var(--text-4xl);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
    line-height: var(--leading-tight);
    margin-bottom: var(--space-1);
}

.stat-label {
    font-size: var(--text-xs);
    color: var(--color-ink-2);
    text-transform: uppercase;
    letter-spacing: var(--tracking-wider);
    font-weight: var(--font-weight-medium);
}

/* Transactions Section */
.transactions-section {
    grid-column: 1 / -1;
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

.badge-warning {
    background: var(--color-warning-subtle);
    color: oklch(from var(--color-warning) calc(l * 0.7) c h);
}

.badge-success {
    background: var(--color-success-subtle);
    color: var(--color-success);
}

.badge-danger {
    background: var(--color-danger-subtle);
    color: var(--color-danger);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: var(--space-12) var(--space-6);
    color: var(--color-ink-3);
}

.empty-state-icon {
    font-size: 3rem;
    opacity: 0.3;
    margin-bottom: var(--space-3);
}

.empty-state-text {
    font-size: var(--text-base);
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

    .page-actions {
        width: 100%;
    }

    .page-actions .btn {
        flex: 1;
    }

    .availability-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="page-header">
    <h1 class="page-title">Detail Buku</h1>
    <div class="page-actions">
        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="detail-grid">
    <!-- Book Information -->
    <div class="info-card">
        <div class="card-header">
            <h2 class="card-title">Informasi Buku</h2>
        </div>
        <div class="card-body">
            <table class="info-table">
                <tr>
                    <th>Kode Buku</th>
                    <td>
                        <code style="font-family: var(--font-mono); font-size: var(--text-sm); background: var(--color-paper-3); padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm);">
                            {{ $book->kode_buku }}
                        </code>
                    </td>
                </tr>
                <tr>
                    <th>Judul</th>
                    <td><strong>{{ $book->judul }}</strong></td>
                </tr>
                <tr>
                    <th>Penulis</th>
                    <td>{{ $book->penulis }}</td>
                </tr>
                <tr>
                    <th>Penerbit</th>
                    <td>{{ $book->penerbit }}</td>
                </tr>
                <tr>
                    <th>Tahun Terbit</th>
                    <td>{{ $book->tahun_terbit }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td><span class="badge badge-info">{{ $book->kategori }}</span></td>
                </tr>
                <tr>
                    <th>Lokasi Rak</th>
                    <td>{{ $book->lokasi_rak ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $book->deskripsi ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Availability Status -->
    <div class="info-card">
        <div class="card-header">
            <h2 class="card-title">Status Ketersediaan</h2>
        </div>
        <div class="card-body">
            <div class="availability-grid">
                <div class="availability-stat">
                    <div class="stat-value">{{ $book->jumlah_stok }}</div>
                    <div class="stat-label">Total Stok</div>
                </div>

                <div class="availability-stat {{ $book->jumlah_tersedia > 0 ? 'highlight' : 'warning' }}">
                    <div class="stat-value">{{ $book->jumlah_tersedia }}</div>
                    <div class="stat-label">Tersedia</div>
                </div>

                <div class="availability-stat">
                    <div class="stat-value">{{ $book->jumlah_stok - $book->jumlah_tersedia }}</div>
                    <div class="stat-label">Sedang Dipinjam</div>
                </div>

                <div class="availability-stat">
                    <div class="stat-value">{{ $book->transactions->count() }}</div>
                    <div class="stat-label">Total Peminjaman</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="transactions-section info-card">
        <div class="card-header">
            <h2 class="card-title">Riwayat Peminjaman</h2>
        </div>
        <div class="card-body" style="padding: 0;">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Anggota</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($book->transactions as $transaction)
                            <tr>
                                <td>
                                    <code style="font-family: var(--font-mono); font-size: var(--text-xs); background: var(--color-paper-3); padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm);">
                                        {{ $transaction->kode_transaksi }}
                                    </code>
                                </td>
                                <td>{{ $transaction->member->nama }}</td>
                                <td>{{ $transaction->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td>{{ $transaction->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                                <td>{{ $transaction->tanggal_kembali ? $transaction->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($transaction->status === 'dipinjam')
                                        <span class="badge badge-warning">Dipinjam</span>
                                    @elseif($transaction->status === 'dikembalikan')
                                        <span class="badge badge-success">Dikembalikan</span>
                                    @else
                                        <span class="badge badge-danger">Terlambat</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->denda > 0 ? 'Rp ' . number_format($transaction->denda, 0, ',', '.') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox empty-state-icon"></i>
                                        <p class="empty-state-text">Belum ada riwayat peminjaman</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
