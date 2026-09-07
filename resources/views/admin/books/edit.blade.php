@extends('layouts.app')

@section('title', 'Edit Buku')

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
/* Book Edit Form - Newsprint Design System */
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

.edit-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-6);
}

@media (min-width: 768px) {
    .edit-layout {
        grid-template-columns: 2fr 1fr;
    }
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

.alert {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
    padding: var(--space-4);
    border-left: 3px solid;
    border-radius: var(--radius-sm);
    margin-bottom: var(--space-6);
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

/* Sidebar Cards */
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
    padding: var(--space-4) var(--space-5);
    border-bottom: 1px solid var(--color-border);
    background: var(--color-paper-2);
}

.card-title {
    font-family: var(--font-display);
    font-size: var(--text-lg);
    font-weight: var(--font-weight-semibold);
    color: var(--color-ink);
    margin: 0;
}

.card-body {
    padding: var(--space-5);
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: var(--space-2);
    font-size: var(--text-sm);
    color: var(--color-ink-2);
}

.info-item + .info-item {
    margin-top: var(--space-3);
}

.info-item strong {
    color: var(--color-ink);
    font-weight: var(--font-weight-medium);
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
    <h1 class="page-title">Edit Buku</h1>
    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="edit-layout">
    <!-- Main Form -->
    <div class="form-card">
        <form action="{{ route('admin.books.update', $book) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Kode Buku & Kategori -->
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
                            value="{{ old('kode_buku', $book->kode_buku) }}"
                            required
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
                            value="{{ old('kategori', $book->kategori) }}"
                            required
                        >
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-helper">Contoh: Fiksi, Non-Fiksi, Teknologi, dll.</small>
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
                        value="{{ old('judul', $book->judul) }}"
                        required
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
                            value="{{ old('penulis', $book->penulis) }}"
                            required
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
                            value="{{ old('penerbit', $book->penerbit) }}"
                            required
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
                            value="{{ old('tahun_terbit', $book->tahun_terbit) }}"
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
                            value="{{ old('jumlah_stok', $book->jumlah_stok) }}"
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
                            value="{{ old('lokasi_rak', $book->lokasi_rak) }}"
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
                    >{{ old('deskripsi', $book->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Info Alert -->
                <div class="alert alert-info">
                    <i class="bi bi-info-circle" style="font-size: 1.25rem; flex-shrink: 0;"></i>
                    <div>
                        <strong>Info:</strong> Stok tersedia saat ini: <strong>{{ $book->jumlah_tersedia }}</strong>.
                        Perubahan stok akan menyesuaikan jumlah tersedia secara otomatis.
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.books.show', $book) }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Sidebar -->
    <div>
        <div class="info-card">
            <div class="card-header">
                <h6 class="card-title">Informasi</h6>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <i class="bi bi-clock"></i>
                    <span>Dibuat: <strong>{{ $book->created_at->format('d/m/Y H:i') }}</strong></span>
                </div>
                <div class="info-item">
                    <i class="bi bi-clock-history"></i>
                    <span>Diubah: <strong>{{ $book->updated_at->format('d/m/Y H:i') }}</strong></span>
                </div>
            </div>
        </div>

        <div class="info-card">
            <div class="card-header">
                <h6 class="card-title">Status Peminjaman</h6>
            </div>
            <div class="card-body">
                <div class="info-item" style="flex-direction: column; align-items: flex-start; gap: var(--space-1);">
                    <strong>Sedang Dipinjam: {{ $book->jumlah_stok - $book->jumlah_tersedia }}</strong>
                    <small style="font-size: var(--text-xs); color: var(--color-ink-3);">
                        Buku tidak dapat dihapus jika masih ada yang dipinjam
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
