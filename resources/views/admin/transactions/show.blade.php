@extends('layouts.app')

@section('title', 'Detail Transaksi')

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
/* Transaction Detail - Newsprint Design System */
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

.btn-secondary {
    background: transparent;
    color: var(--color-ink);
    border: 1px solid var(--color-border-emphasis);
}

.btn-secondary:hover {
    background: var(--color-paper-3);
    color: var(--color-ink);
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

.btn-success:focus-visible {
    outline: 2px solid var(--color-focus);
    outline-offset: 2px;
}

.btn-sm {
    padding: var(--space-2) var(--space-4);
    font-size: var(--text-sm);
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

/* Main Layout */
.detail-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-6);
}

@media (min-width: 768px) {
    .detail-layout {
        grid-template-columns: 2fr 1fr;
    }
}

.info-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.info-card + .info-card {
    margin-top: var(--space-6);
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
    display: flex;
    align-items: center;
    gap: var(--space-2);
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
    width: 35%;
    vertical-align: top;
}

.info-table td {
    padding: var(--space-4) 0 var(--space-4) var(--space-2);
    font-size: var(--text-sm);
    color: var(--color-ink);
}

.info-table code {
    font-family: var(--font-mono);
    font-size: var(--text-base);
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

.badge-info {
    background: var(--color-info-subtle);
    color: var(--color-info);
}

.badge-secondary {
    background: var(--color-paper-3);
    color: var(--color-ink-2);
}

.text-danger {
    color: var(--color-danger);
}

.text-muted {
    color: var(--color-ink-2);
}

.alert {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
    padding: var(--space-4);
    border-left: 3px solid;
    border-radius: var(--radius-sm);
}

.alert-warning {
    background: var(--color-warning-subtle);
    border-color: var(--color-warning);
    color: var(--color-ink);
}

.alert-success {
    background: var(--color-success-subtle);
    border-color: var(--color-success);
    color: var(--color-ink);
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--color-border);
}

.timeline-item {
    position: relative;
    margin-bottom: var(--space-5);
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-badge {
    position: absolute;
    left: -30px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: var(--color-paper);
}

.timeline-badge.bg-primary {
    background: var(--color-info);
}

.timeline-badge.bg-info {
    background: var(--color-info);
}

.timeline-badge.bg-success {
    background: var(--color-success);
}

.timeline-content {
    padding-bottom: var(--space-2);
}

.timeline-label {
    font-size: var(--text-xs);
    color: var(--color-ink-2);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: var(--space-1);
}

.timeline-value {
    font-size: var(--text-sm);
    color: var(--color-ink);
    margin: 0;
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

    .btn {
        width: 100%;
    }
}
</style>

<div class="page-header">
    <h1 class="page-title">Detail Transaksi</h1>
    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="detail-layout">
    <!-- Left Column -->
    <div>
        <!-- Transaction Information -->
        <div class="info-card">
            <div class="card-header">
                <h2 class="card-title">Informasi Transaksi</h2>
            </div>
            <div class="card-body">
                <table class="info-table">
                    <tr>
                        <th>Kode Transaksi</th>
                        <td><code>{{ $transaction->kode_transaksi }}</code></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($transaction->status === 'dipinjam')
                                <span class="badge badge-primary">Dipinjam</span>
                            @elseif($transaction->status === 'dikembalikan')
                                <span class="badge badge-success">Dikembalikan</span>
                            @else
                                <span class="badge badge-danger">Terlambat</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Pinjam</th>
                        <td>{{ $transaction->tanggal_pinjam->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Jatuh Tempo</th>
                        <td>{{ $transaction->tanggal_jatuh_tempo->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Kembali</th>
                        <td>
                            @if($transaction->tanggal_kembali)
                                {{ $transaction->tanggal_kembali->format('d/m/Y') }}
                            @else
                                <span class="text-muted">Belum dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Denda</th>
                        <td>
                            @if($transaction->denda > 0)
                                <span class="text-danger" style="font-weight: var(--font-weight-semibold);">Rp {{ number_format($transaction->denda, 0, ',', '.') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @if($transaction->catatan)
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $transaction->catatan }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>Diproses Oleh</th>
                        <td>{{ $transaction->user->name }} ({{ $transaction->user->email }})</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Book Information -->
        <div class="info-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-book"></i> Informasi Buku
                </h2>
            </div>
            <div class="card-body">
                <table class="info-table">
                    <tr>
                        <th>Kode Buku</th>
                        <td>{{ $transaction->book->kode_buku }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td style="font-weight: var(--font-weight-semibold);">{{ $transaction->book->judul }}</td>
                    </tr>
                    <tr>
                        <th>Penulis</th>
                        <td>{{ $transaction->book->penulis }}</td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>{{ $transaction->book->penerbit }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td><span class="badge badge-info">{{ $transaction->book->kategori }}</span></td>
                    </tr>
                </table>
                <div style="margin-top: var(--space-4);">
                    <a href="{{ route('admin.books.show', $transaction->book) }}" class="btn btn-sm btn-outline">
                        <i class="bi bi-eye"></i> Lihat Detail Buku
                    </a>
                </div>
            </div>
        </div>

        <!-- Member Information -->
        <div class="info-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="bi bi-person"></i> Informasi Anggota
                </h2>
            </div>
            <div class="card-body">
                <table class="info-table">
                    <tr>
                        <th>Kode Anggota</th>
                        <td>{{ $transaction->member->kode_anggota }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td style="font-weight: var(--font-weight-semibold);">{{ $transaction->member->nama }}</td>
                    </tr>
                    <tr>
                        <th>NIS</th>
                        <td>{{ $transaction->member->nis }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $transaction->member->kelas }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($transaction->member->status === 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                </table>
                <div style="margin-top: var(--space-4);">
                    <a href="{{ route('admin.members.show', $transaction->member) }}" class="btn btn-sm btn-outline">
                        <i class="bi bi-eye"></i> Lihat Detail Anggota
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div>
        <!-- Action Card -->
        <div class="info-card">
            <div class="card-header">
                <h6 class="card-title" style="font-size: var(--text-base);">Aksi</h6>
            </div>
            <div class="card-body">
                @if($transaction->status === 'dipinjam' || $transaction->status === 'terlambat')
                    <form action="{{ route('admin.transactions.return', $transaction) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success" style="width: 100%; margin-bottom: var(--space-3);" onclick="return confirm('Proses pengembalian buku ini?')">
                            <i class="bi bi-check-circle"></i> Kembalikan Buku
                        </button>
                    </form>

                    @if($transaction->status === 'terlambat')
                        <div class="alert alert-warning" style="margin-bottom: 0;">
                            <i class="bi bi-exclamation-triangle" style="font-size: 1rem; flex-shrink: 0;"></i>
                            <small>Buku ini sudah melewati jatuh tempo. Denda akan dihitung otomatis saat pengembalian.</small>
                        </div>
                    @endif
                @else
                    <div class="alert alert-success" style="margin-bottom: 0;">
                        <i class="bi bi-check-circle-fill" style="font-size: 1rem; flex-shrink: 0;"></i>
                        <span>Buku sudah dikembalikan</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Timeline Card -->
        <div class="info-card">
            <div class="card-header">
                <h6 class="card-title" style="font-size: var(--text-base);">Timeline</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-badge bg-primary">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-label">Dibuat</div>
                            <p class="timeline-value">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-badge bg-info">
                            <i class="bi bi-calendar"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-label">Jatuh Tempo</div>
                            <p class="timeline-value">{{ $transaction->tanggal_jatuh_tempo->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    @if($transaction->tanggal_kembali)
                        <div class="timeline-item">
                            <div class="timeline-badge bg-success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-label">Dikembalikan</div>
                                <p class="timeline-value">{{ $transaction->tanggal_kembali->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
