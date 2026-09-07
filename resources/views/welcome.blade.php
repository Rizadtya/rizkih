<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Sekolah Digital</title>
    <style>
        /* Newsprint Design System — Library Sienna accent
         * Aligned with admin interface design tokens
         * Motion-cut philosophy: 150–200ms transitions only
         */

        :root {
            /* Newsprint theme — OKLCH palette with Library Sienna accent */
            --color-paper: oklch(98% 0.002 85);
            --color-paper-2: oklch(96% 0.003 85);
            --color-paper-3: oklch(94% 0.004 85);
            --color-ink: oklch(20% 0.008 85);
            --color-ink-muted: oklch(45% 0.012 85);
            --color-ink-light: oklch(65% 0.015 85);
            --color-accent: oklch(52% 0.12 35);
            --color-accent-hover: oklch(48% 0.13 35);
            --color-rule: oklch(88% 0.005 85);

            /* Typography */
            --font-display: 'Instrument Serif', Georgia, serif;
            --font-body: 'Instrument Sans', system-ui, sans-serif;
            --font-mono: ui-monospace, 'SF Mono', monospace;

            /* Type scale */
            --text-xs: 0.75rem;
            --text-sm: 0.875rem;
            --text-base: 1rem;
            --text-lg: 1.125rem;
            --text-xl: 1.25rem;
            --text-2xl: 1.5rem;
            --text-3xl: 1.875rem;
            --text-4xl: 2.25rem;
            --text-display: 3.5rem;

            /* Spacing — 4pt scale */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;
            --space-16: 4rem;
            --space-20: 5rem;
            --space-24: 6rem;

            /* Transitions — motion-cut */
            --dur-fast: 150ms;
            --dur-base: 200ms;
            --ease-out: cubic-bezier(0, 0, 0.2, 1);
            --ease-in-out: cubic-bezier(0.4, 0, 0.2, 1);

            /* Layout */
            --radius-sm: 2px;
            --radius-md: 4px;
            --content-width: 72rem;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --color-paper: oklch(15% 0.008 85);
                --color-paper-2: oklch(18% 0.01 85);
                --color-paper-3: oklch(22% 0.012 85);
                --color-ink: oklch(92% 0.008 85);
                --color-ink-muted: oklch(68% 0.012 85);
                --color-ink-light: oklch(52% 0.015 85);
                --color-accent: oklch(62% 0.13 35);
                --color-accent-hover: oklch(66% 0.14 35);
                --color-rule: oklch(28% 0.012 85);
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            overflow-x: clip;
        }

        body {
            overflow-x: clip;
            font-family: var(--font-body);
            font-size: var(--text-base);
            line-height: 1.6;
            color: var(--color-ink);
            background: var(--color-paper);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Nav */
        .nav {
            border-bottom: 1px solid var(--color-rule);
            background: var(--color-paper);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-inner {
            max-width: var(--content-width);
            margin: 0 auto;
            padding: var(--space-4) var(--space-6);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--space-8);
        }

        .nav-brand {
            font-family: var(--font-display);
            font-size: var(--text-lg);
            font-weight: 500;
            color: var(--color-ink);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .nav-links {
            display: flex;
            gap: var(--space-6);
            list-style: none;
        }

        .nav-link {
            font-size: var(--text-sm);
            color: var(--color-ink-muted);
            text-decoration: none;
            transition: color var(--dur-fast) var(--ease-out);
        }

        .nav-link:hover {
            color: var(--color-ink);
        }

        .nav-cta {
            display: inline-flex;
            align-items: center;
            padding: var(--space-2) var(--space-4);
            font-size: var(--text-sm);
            font-weight: 500;
            color: var(--color-paper);
            background: var(--color-accent);
            border: none;
            border-radius: var(--radius-sm);
            text-decoration: none;
            cursor: pointer;
            transition: background var(--dur-fast) var(--ease-out), transform var(--dur-fast) var(--ease-out);
        }

        .nav-cta:hover {
            background: var(--color-accent-hover);
        }

        .nav-cta:focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
        }

        .nav-cta:active {
            transform: translateY(1px);
        }

        /* Main container */
        .container {
            max-width: var(--content-width);
            margin: 0 auto;
            padding: var(--space-16) var(--space-6);
        }

        /* Hero */
        .hero {
            margin-bottom: var(--space-20);
            padding-bottom: var(--space-16);
            border-bottom: 1px solid var(--color-rule);
        }

        .hero-kicker {
            font-size: var(--text-sm);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--color-ink-muted);
            margin-bottom: var(--space-3);
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: var(--text-display);
            font-weight: 400;
            line-height: 1.1;
            color: var(--color-ink);
            margin-bottom: var(--space-6);
            overflow-wrap: anywhere;
            min-width: 0;
        }

        .hero-intro {
            font-size: var(--text-xl);
            line-height: 1.5;
            color: var(--color-ink-muted);
            max-width: 48rem;
            margin-bottom: var(--space-8);
        }

        /* Section */
        .section {
            margin-bottom: var(--space-16);
        }

        .section-head {
            display: flex;
            align-items: baseline;
            gap: var(--space-4);
            margin-bottom: var(--space-8);
        }

        .section-title {
            font-family: var(--font-display);
            font-size: var(--text-2xl);
            font-weight: 500;
            color: var(--color-ink);
        }

        .section-rule {
            flex: 1;
            height: 1px;
            background: var(--color-rule);
            align-self: center;
        }

        /* Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-8);
        }

        /* Card */
        .card {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }

        .card-icon {
            width: var(--space-10);
            height: var(--space-10);
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--color-paper-2);
            border: 1px solid var(--color-rule);
            border-radius: var(--radius-md);
            font-size: var(--text-2xl);
        }

        .card-title {
            font-family: var(--font-display);
            font-size: var(--text-lg);
            font-weight: 500;
            color: var(--color-ink);
        }

        .card-body {
            font-size: var(--text-sm);
            line-height: 1.6;
            color: var(--color-ink-muted);
        }

        .card-link {
            font-size: var(--text-sm);
            font-weight: 500;
            color: var(--color-accent);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            transition: color var(--dur-fast) var(--ease-out);
        }

        .card-link:hover {
            color: var(--color-accent-hover);
        }

        .card-link:focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
            border-radius: var(--radius-sm);
        }

        /* List */
        .list {
            display: flex;
            flex-direction: column;
            gap: var(--space-6);
            list-style: none;
        }

        .list-item {
            display: flex;
            gap: var(--space-4);
            padding-bottom: var(--space-6);
            border-bottom: 1px solid var(--color-rule);
        }

        .list-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .list-number {
            font-family: var(--font-mono);
            font-size: var(--text-xs);
            color: var(--color-ink-light);
            min-width: var(--space-8);
        }

        .list-content {
            flex: 1;
        }

        .list-title {
            font-weight: 500;
            color: var(--color-ink);
            margin-bottom: var(--space-2);
        }

        .list-body {
            font-size: var(--text-sm);
            color: var(--color-ink-muted);
        }

        /* Footer */
        .footer {
            margin-top: var(--space-24);
            padding: var(--space-12) var(--space-6);
            border-top: 1px solid var(--color-rule);
            background: var(--color-paper-2);
        }

        .footer-inner {
            max-width: var(--content-width);
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: var(--space-8);
        }

        .footer-brand {
            font-family: var(--font-display);
            font-size: var(--text-lg);
            font-weight: 500;
            color: var(--color-ink);
        }

        .footer-links {
            display: flex;
            gap: var(--space-6);
            list-style: none;
            flex-wrap: wrap;
        }

        .footer-link {
            font-size: var(--text-sm);
            color: var(--color-ink-muted);
            text-decoration: none;
            transition: color var(--dur-fast) var(--ease-out);
        }

        .footer-link:hover {
            color: var(--color-ink);
        }

        .footer-meta {
            font-size: var(--text-xs);
            color: var(--color-ink-light);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: var(--text-4xl);
            }

            .hero-intro {
                font-size: var(--text-lg);
            }

            .nav-links {
                display: none;
            }

            .section-head {
                flex-direction: column;
                align-items: flex-start;
                gap: var(--space-2);
            }

            .section-rule {
                width: 100%;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <!-- Nav -->
    <nav class="nav">
        <div class="nav-inner">
            <a href="/" class="nav-brand">
                <span>📚</span>
                <span>Perpustakaan Sekolah</span>
            </a>
            <ul class="nav-links">
                <li><a href="#fitur" class="nav-link">Fitur</a></li>
                <li><a href="#mulai" class="nav-link">Memulai</a></li>
                <li><a href="#bantuan" class="nav-link">Bantuan</a></li>
            </ul>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-cta">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-cta">Masuk</a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Main -->
    <main class="container">
        <!-- Hero -->
        <section class="hero">
            <div class="hero-kicker">Sistem Manajemen Perpustakaan</div>
            <h1 class="hero-title">Kelola koleksi buku sekolah dengan mudah</h1>
            <p class="hero-intro">Platform digital untuk mengelola katalog buku, peminjaman, dan laporan perpustakaan sekolah — dirancang sederhana untuk pustakawan dan administrator.</p>
        </section>

        <!-- Features -->
        <section class="section" id="fitur">
            <div class="section-head">
                <h2 class="section-title">Fitur Utama</h2>
                <div class="section-rule"></div>
            </div>
            <div class="grid">
                <div class="card">
                    <div class="card-icon">📖</div>
                    <h3 class="card-title">Katalog Digital</h3>
                    <p class="card-body">Kelola koleksi buku dengan sistem pencarian, kategori, dan ISBN terintegrasi.</p>
                </div>
                <div class="card">
                    <div class="card-icon">🔄</div>
                    <h3 class="card-title">Peminjaman Otomatis</h3>
                    <p class="card-body">Catat transaksi peminjaman dan pengembalian dengan pengingat otomatis.</p>
                </div>
                <div class="card">
                    <div class="card-icon">📊</div>
                    <h3 class="card-title">Laporan & Analitik</h3>
                    <p class="card-body">Pantau statistik peminjaman, buku populer, dan aktivitas perpustakaan.</p>
                </div>
            </div>
        </section>

        <!-- Getting Started -->
        <section class="section" id="mulai">
            <div class="section-head">
                <h2 class="section-title">Memulai</h2>
                <div class="section-rule"></div>
            </div>
            <ul class="list">
                <li class="list-item">
                    <span class="list-number">01</span>
                    <div class="list-content">
                        <div class="list-title">Buat akun administrator</div>
                        <div class="list-body">Daftar sebagai admin untuk mengakses panel kontrol lengkap sistem perpustakaan.</div>
                    </div>
                </li>
                <li class="list-item">
                    <span class="list-number">02</span>
                    <div class="list-content">
                        <div class="list-title">Tambahkan koleksi buku</div>
                        <div class="list-body">Masukkan data buku, ISBN, kategori, dan informasi penerbit ke dalam katalog digital.</div>
                    </div>
                </li>
                <li class="list-item">
                    <span class="list-number">03</span>
                    <div class="list-content">
                        <div class="list-title">Kelola peminjaman</div>
                        <div class="list-body">Catat peminjaman siswa, atur batas waktu, dan kirim pengingat pengembalian.</div>
                    </div>
                </li>
            </ul>
        </section>

        <!-- Help -->
        <section class="section" id="bantuan">
            <div class="section-head">
                <h2 class="section-title">Bantuan</h2>
                <div class="section-rule"></div>
            </div>
            <div class="grid">
                <div class="card">
                    <h3 class="card-title">Dokumentasi</h3>
                    <p class="card-body">Panduan lengkap penggunaan sistem perpustakaan.</p>
                    <a href="https://laravel.com/docs" class="card-link">
                        <span>Baca dokumentasi</span>
                        <span>→</span>
                    </a>
                </div>
                <div class="card">
                    <h3 class="card-title">Video Tutorial</h3>
                    <p class="card-body">Pelajari fitur sistem melalui video panduan.</p>
                    <a href="https://laracasts.com" class="card-link">
                        <span>Tonton tutorial</span>
                        <span>→</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">Perpustakaan Sekolah Digital</div>
            <ul class="footer-links">
                <li><a href="#" class="footer-link">Tentang</a></li>
                <li><a href="#" class="footer-link">Kontak</a></li>
                <li><a href="#" class="footer-link">Privasi</a></li>
                <li><a href="https://github.com/laravel/framework" class="footer-link">GitHub</a></li>
            </ul>
            <div class="footer-meta">
                Versi {{ app()->version() }} · Laravel {{ app()->version() }}
            </div>
        </div>
    </footer>
</body>
</html>
