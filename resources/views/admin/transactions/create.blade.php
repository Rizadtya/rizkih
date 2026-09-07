@extends('layouts.app')

@section('title', 'Tambah Transaksi')

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
/* Transaction Create Form - Newsprint Design System */
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

.btn-primary:disabled {
    opacity: 0.5;
    cursor: not-allowed;
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

.form-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: var(--space-8);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-6);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-6);
}

@media (min-width: 768px) {
    .form-row.cols-2 {
        grid-template-columns: repeat(2, 1fr);
    }
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.form-label {
    font-family: var(--font-body);
    font-size: var(--text-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-ink);
}

.form-label .required {
    color: var(--color-danger);
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

.form-control.is-invalid {
    border-color: var(--color-danger);
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 3px var(--color-danger-subtle);
}

.form-helper {
    font-size: var(--text-xs);
    color: var(--color-ink-2);
}

.invalid-feedback {
    font-size: var(--text-xs);
    color: var(--color-danger);
}

.alert {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
    padding: var(--space-4);
    border-left: 3px solid;
    border-radius: var(--radius-sm);
}

.alert-info {
    background: var(--color-info-subtle);
    border-color: var(--color-info);
    color: var(--color-ink);
}

.form-actions {
    display: flex;
    gap: var(--space-3);
    padding-top: var(--space-6);
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

    .form-card {
        padding: var(--space-6);
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .form-actions .btn {
        width: 100%;
    }
}
</style>

<div class="page-header">
    <h1 class="page-title">Tambah Transaksi</h1>
    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.transactions.store') }}">
        @csrf

        <div class="form-grid">
            <!-- Book & Member Selection -->
            <div class="form-row cols-2">
                <div class="form-group">
                    <label for="book_id" class="form-label">
                        Buku <span class="required">*</span>
                    </label>
                    <select
                        class="form-control @error('book_id') is-invalid @enderror"
                        id="book_id"
                        name="book_id"
                        required
                    >
                        <option value="">Pilih Buku</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->kode_buku }} - {{ $book->judul }} (Tersedia: {{ $book->jumlah_tersedia }})
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($books->isEmpty())
                        <small class="form-helper">Tidak ada buku yang tersedia untuk dipinjam</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="member_id" class="form-label">
                        Anggota <span class="required">*</span>
                    </label>
                    <select
                        class="form-control @error('member_id') is-invalid @enderror"
                        id="member_id"
                        name="member_id"
                        required
                    >
                        <option value="">Pilih Anggota</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->kode_anggota }} - {{ $member->nama }} ({{ $member->kelas }})
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($members->isEmpty())
                        <small class="form-helper">Tidak ada anggota aktif</small>
                    @endif
                </div>
            </div>

            <!-- Duration -->
            <div class="form-group">
                <label for="durasi_hari" class="form-label">
                    Durasi Peminjaman (Hari)
                </label>
                <input
                    type="number"
                    class="form-control @error('durasi_hari') is-invalid @enderror"
                    id="durasi_hari"
                    name="durasi_hari"
                    value="{{ old('durasi_hari', 7) }}"
                    min="1"
                    max="30"
                    style="max-width: 200px;"
                >
                @error('durasi_hari')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-helper">Default: 7 hari (maksimal 30 hari)</small>
            </div>

            <!-- Info Alert -->
            <div class="alert alert-info">
                <i class="bi bi-info-circle" style="font-size: 1.25rem; flex-shrink: 0;"></i>
                <div>
                    <strong>Catatan:</strong> Kode transaksi, tanggal pinjam, dan tanggal jatuh tempo akan dibuat otomatis oleh sistem.
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button
                type="submit"
                class="btn btn-primary"
                {{ ($books->isEmpty() || $members->isEmpty()) ? 'disabled' : '' }}
            >
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
