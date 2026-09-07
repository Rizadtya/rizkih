@extends('layouts.app')

@section('title', 'Tambah Anggota')

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
/* Member Create Form - Newsprint Design System */
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

textarea.form-control {
    min-height: 100px;
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
        flex-direction: column-reverse;
    }

    .form-actions .btn {
        width: 100%;
    }
}
</style>

<div class="page-header">
    <h1 class="page-title">Tambah Anggota</h1>
    <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.members.store') }}">
        @csrf

        <div class="form-grid">
            <!-- Kode Anggota & Nama -->
            <div class="form-row cols-2">
                <div class="form-group">
                    <label for="kode_anggota" class="form-label">
                        Kode Anggota <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('kode_anggota') is-invalid @enderror"
                        id="kode_anggota"
                        name="kode_anggota"
                        value="{{ old('kode_anggota') }}"
                        required
                    >
                    @error('kode_anggota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama" class="form-label">
                        Nama Lengkap <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('nama') is-invalid @enderror"
                        id="nama"
                        name="nama"
                        value="{{ old('nama') }}"
                        required
                    >
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- NIS & Kelas -->
            <div class="form-row cols-2">
                <div class="form-group">
                    <label for="nis" class="form-label">
                        NIS <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('nis') is-invalid @enderror"
                        id="nis"
                        name="nis"
                        value="{{ old('nis') }}"
                        required
                    >
                    @error('nis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kelas" class="form-label">
                        Kelas <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        class="form-control @error('kelas') is-invalid @enderror"
                        id="kelas"
                        name="kelas"
                        value="{{ old('kelas') }}"
                        placeholder="Contoh: X RPL 1"
                        required
                    >
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- No. Telepon & Status -->
            <div class="form-row cols-2">
                <div class="form-group">
                    <label for="no_telepon" class="form-label">
                        No. Telepon
                    </label>
                    <input
                        type="text"
                        class="form-control @error('no_telepon') is-invalid @enderror"
                        id="no_telepon"
                        name="no_telepon"
                        value="{{ old('no_telepon') }}"
                    >
                    @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">
                        Status <span class="required">*</span>
                    </label>
                    <select
                        class="form-control @error('status') is-invalid @enderror"
                        id="status"
                        name="status"
                        required
                    >
                        <option value="">Pilih Status</option>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Alamat -->
            <div class="form-group">
                <label for="alamat" class="form-label">
                    Alamat
                </label>
                <textarea
                    class="form-control @error('alamat') is-invalid @enderror"
                    id="alamat"
                    name="alamat"
                    rows="3"
                >{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
