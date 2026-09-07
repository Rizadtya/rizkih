@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.books.catalog') }}">
                <i class="bi bi-book"></i> Katalog Buku
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('user.loans') }}">
                <i class="bi bi-arrow-repeat"></i> Peminjaman Saya
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title">Peminjaman Saya</h1>
            <p class="text-muted mb-0">Kelola dan pantau peminjaman buku Anda</p>
        </div>
        <a href="{{ route('user.books.catalog') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Pinjam Buku
        </a>
    </div>

    <!-- Status Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="btn-group" role="group">
                <a href="{{ route('user.loans', ['status' => 'dipinjam']) }}"
                   class="btn btn-sm {{ request('status', 'dipinjam') === 'dipinjam' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-clock"></i> Sedang Dipinjam
                </a>
                <a href="{{ route('user.loans', ['status' => 'dikembalikan']) }}"
                   class="btn btn-sm {{ request('status') === 'dikembalikan' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-check-circle"></i> Dikembalikan
                </a>
                <a href="{{ route('user.loans', ['status' => 'terlambat']) }}"
                   class="btn btn-sm {{ request('status') === 'terlambat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-exclamation-triangle"></i> Terlambat
                </a>
                <a href="{{ route('user.loans', ['status' => 'all']) }}"
                   class="btn btn-sm {{ request('status') === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="bi bi-list"></i> Semua
                </a>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th>
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
                        @forelse($transactions as $trans)
                            <tr>
                                <td>
                                    <code class="small">{{ $trans->kode_transaksi }}</code>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ Str::limit($trans->book->judul, 40) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $trans->book->penulis }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{ $trans->member->nama }}
                                        <br>
                                        <small class="text-muted">{{ $trans->member->kelas }}</small>
                                    </div>
                                </td>
                                <td>{{ $trans->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td>
                                    {{ $trans->tanggal_jatuh_tempo->format('d/m/Y') }}
                                    @if($trans->status === 'dipinjam' && $trans->tanggal_jatuh_tempo->isPast())
                                        <br><span class="badge bg-danger small">Lewat tempo</span>
                                    @elseif($trans->status === 'dipinjam' && $trans->tanggal_jatuh_tempo->diffInDays(now()) <= 2)
                                        <br><span class="badge bg-warning small">Segera jatuh tempo</span>
                                    @endif
                                </td>
                                <td>
                                    @if($trans->tanggal_kembali)
                                        {{ $trans->tanggal_kembali->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($trans->status === 'dipinjam')
                                        <span class="badge bg-primary">Dipinjam</span>
                                    @elseif($trans->status === 'dikembalikan')
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @else
                                        <span class="badge bg-danger">Terlambat</span>
                                    @endif
                                </td>
                                <td>
                                    @if($trans->denda > 0)
                                        <span class="text-danger fw-bold">Rp {{ number_format($trans->denda, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($trans->status === 'dipinjam' || $trans->status === 'terlambat')
                                        <form action="{{ route('user.transactions.return', $trans) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success"
                                                    onclick="return confirm('Kembalikan buku ini?')">
                                                <i class="bi bi-check-circle"></i> Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="mb-0 mt-3">
                                        @if(request('status') === 'all')
                                            Belum ada riwayat peminjaman
                                        @elseif(request('status') === 'dikembalikan')
                                            Belum ada buku yang dikembalikan
                                        @elseif(request('status') === 'terlambat')
                                            Tidak ada peminjaman yang terlambat
                                        @else
                                            Tidak ada peminjaman aktif
                                        @endif
                                    </p>
                                    <a href="{{ route('user.books.catalog') }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="bi bi-book"></i> Lihat Katalog Buku
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="mt-3 d-flex justify-content-center">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Summary Cards -->
    @if($transactions->count() > 0)
        <div class="row g-3 mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 small">Total Peminjaman</p>
                                <h4 class="mb-0">{{ $transactions->total() }}</h4>
                            </div>
                            <div class="text-primary" style="font-size: 2rem; opacity: 0.3;">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 small">Sedang Dipinjam</p>
                                <h4 class="mb-0">{{ $transactions->where('status', 'dipinjam')->count() }}</h4>
                            </div>
                            <div class="text-warning" style="font-size: 2rem; opacity: 0.3;">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1 small">Terlambat</p>
                                <h4 class="mb-0 text-danger">{{ $transactions->where('status', 'terlambat')->count() }}</h4>
                            </div>
                            <div class="text-danger" style="font-size: 2rem; opacity: 0.3;">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
