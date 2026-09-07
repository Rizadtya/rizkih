@extends('layouts.app')

@section('title', 'Tambah Buku')

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
/* Book Form - Newsprint Design System */
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

.form-card {
    background: var(--color-paper);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    padding: var(--space-8);
    max-width: 900px;
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

    .form-row.cols-3 {
        grid-template-columns: repeat(3, 1fr);
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

.form-control::placeholder {
    color: var(--color-ink-3);
}

.form-control.is-invalid {
    border-color: var(--color-danger);
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 3px var(--color-danger-subtle);
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

.form-helper {
    font-size: var(--text-xs);
    color: var(--color-ink-2);
}

.invalid-feedback {
    font-size: var(--text-xs);
    color: var(--color-danger);
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
        flex-direction: column;
    }

    .form-actions .btn {
        width: 100%;
    }
}
</style>

<div class="page-header">
    <h1 class="page-title">Tambah Buku</h1>
    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <form action="{{ route('admin.books.store') }}" method="POST">
        @csrf

        <div class="form-grid">
            <!-- Kode Buku & Judul -->
            <div class="form-row cols-2">
                <div class="form-group">
                    <label for="kode_buku" class="form-label">
                        Kode Buku <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('kode_buku') is-invalid @enderror"
                        id="kode_buku"
                        name="kode_buku"
                        value="{{ old('kode_buku') }}"
                        required
                        placeholder="Contoh: BK001"
                    >
                    @error('kode_buku')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kategori" class="form-label">
                        Kategori <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('kategori') is-invalid @enderror"
                        id="kategori"
                        name="kategori"
                        value="{{ old('kategori') }}"
                        required
                        placeholder="Contoh: Fiksi, Non-Fiksi"
                    >
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Judul -->
            <div class="form-group">
                <label for="judul" class="form-label">
                    Judul Buku <span class="required">*</span>
                </label>
                <input
                    type="text"
                    class="form-control @error('judul') is-invalid @enderror"
                    id="judul"
                    name="judul"
                    value="{{ old('judul') }}"
                    required
                    placeholder="Masukkan judul buku"
                >
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Penulis & Penerbit -->
            <div class="form-row cols-2">
                <div class="form-group">
                    <label for="penulis" class="form-label">
                        Penulis <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('penulis') is-invalid @enderror"
                        id="penulis"
                        name="penulis"
                        value="{{ old('penulis') }}"
                        required
                        placeholder="Nama penulis"
                    >
                    @error('penulis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="penerbit" class="form-label">
                        Penerbit <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('penerbit') is-invalid @enderror"
                        id="penerbit"
                        name="penerbit"
                        value="{{ old('penerbit') }}"
                        required
                        placeholder="Nama penerbit"
                    >
                    @error('penerbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Tahun, Stok, Lokasi -->
            <div class="form-row cols-3">
                <div class="form-group">
                    <label for="tahun_terbit" class="form-label">
                        Tahun Terbit <span class="required">*</span>
                    </label>
                    <input
                        type="number"
                        class="form-control @error('tahun_terbit') is-invalid @enderror"
                        id="tahun_terbit"
                        name="tahun_terbit"
                        value="{{ old('tahun_terbit', date('Y')) }}"
                        min="1900"
                        max="{{ date('Y') + 1 }}"
                        required
                    >
                    @error('tahun_terbit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jumlah_stok" class="form-label">
                        Jumlah Stok <span class="required">*</span>
                    </label>
                    <input
                        type="number"
                        class="form-control @error('jumlah_stok') is-invalid @enderror"
                        id="jumlah_stok"
                        name="jumlah_stok"
                        value="{{ old('jumlah_stok', 1) }}"
                        min="0"
                        required
                    >
                    @error('jumlah_stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lokasi_rak" class="form-label">
                        Lokasi Rak
                    </label>
                    <input
                        type="text"
                        class="form-control @error('lokasi_rak') is-invalid @enderror"
                        id="lokasi_rak"
                        name="lokasi_rak"
                        value="{{ old('lokasi_rak') }}"
                        placeholder="Contoh: A-12"
                    >
                    @error('lokasi_rak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="form-group">
                <label for="deskripsi" class="form-label">
                    Deskripsi
                </label>
                <textarea
                    class="form-control @error('deskripsi') is-invalid @enderror"
                    id="deskripsi"
                    name="deskripsi"
                    rows="4"
                    placeholder="Masukkan deskripsi buku (opsional)"
                >{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
