<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Sekolah Digital</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/tokens.css">
    <style>
        /* Login Page - Newsprint Design System */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: var(--color-paper);
            color: var(--color-ink);
            line-height: var(--leading-normal);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-6);
        }

        .login-container {
            width: 100%;
            max-width: 440px;
        }

        .login-header {
            text-align: center;
            margin-bottom: var(--space-8);
        }

        .app-icon {
            width: 64px;
            height: 64px;
            background: var(--color-paper);
            border: 2px solid var(--color-border);
            border-radius: var(--radius-md);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--color-accent);
            font-size: 2rem;
            margin-bottom: var(--space-4);
        }

        .login-title {
            font-family: var(--font-display);
            font-size: var(--text-3xl);
            font-weight: var(--font-weight-semibold);
            color: var(--color-ink);
            margin-bottom: var(--space-2);
            line-height: var(--leading-tight);
        }

        .login-subtitle {
            font-size: var(--text-base);
            color: var(--color-ink-2);
        }

        .login-card {
            background: var(--color-paper);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: var(--space-8);
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: var(--space-3);
            padding: var(--space-4);
            border-left: 3px solid;
            border-radius: var(--radius-sm);
            margin-bottom: var(--space-6);
            font-size: var(--text-sm);
        }

        .alert-success {
            background: var(--color-success-subtle);
            border-color: var(--color-success);
            color: var(--color-ink);
        }

        .alert-danger {
            background: var(--color-danger-subtle);
            border-color: var(--color-danger);
            color: var(--color-ink);
        }

        .alert i {
            flex-shrink: 0;
        }

        .form-group {
            margin-bottom: var(--space-6);
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: var(--text-sm);
            font-weight: var(--font-weight-medium);
            color: var(--color-ink);
            margin-bottom: var(--space-2);
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

        .invalid-feedback {
            display: block;
            margin-top: var(--space-2);
            font-size: var(--text-xs);
            color: var(--color-danger);
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            margin-bottom: var(--space-6);
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition-colors);
        }

        .form-check-input:checked {
            background: var(--color-accent);
            border-color: var(--color-accent);
        }

        .form-check-input:focus {
            outline: 2px solid var(--color-focus);
            outline-offset: 2px;
        }

        .form-check-label {
            font-size: var(--text-sm);
            color: var(--color-ink-2);
            cursor: pointer;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            width: 100%;
            padding: var(--space-4) var(--space-6);
            font-family: var(--font-body);
            font-size: var(--text-base);
            font-weight: var(--font-weight-medium);
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition-colors), var(--transition-transform);
            line-height: 1;
            background: var(--color-accent);
            color: var(--color-paper);
        }

        .btn:hover {
            background: var(--color-accent-hover);
        }

        .btn:active {
            transform: translateY(1px);
        }

        .btn:focus-visible {
            outline: 2px solid var(--color-focus);
            outline-offset: 2px;
        }

        .demo-accounts {
            background: var(--color-paper-2);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-sm);
            padding: var(--space-5);
            margin-top: var(--space-8);
        }

        .demo-accounts-title {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: var(--text-sm);
            font-weight: var(--font-weight-semibold);
            color: var(--color-ink);
            margin-bottom: var(--space-4);
        }

        .demo-account {
            font-size: var(--text-sm);
            color: var(--color-ink-2);
            line-height: var(--leading-relaxed);
        }

        .demo-account + .demo-account {
            margin-top: var(--space-4);
            padding-top: var(--space-4);
            border-top: 1px solid var(--color-border);
        }

        .demo-account strong {
            color: var(--color-ink);
            font-weight: var(--font-weight-medium);
        }

        .demo-account code {
            font-family: var(--font-mono);
            font-size: var(--text-xs);
            background: var(--color-paper);
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius-sm);
            color: var(--color-accent);
            border: 1px solid var(--color-border);
        }

        @media (max-width: 640px) {
            body {
                padding: var(--space-4);
            }

            .login-card {
                padding: var(--space-6);
            }

            .login-title {
                font-size: var(--text-2xl);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="app-icon">
                <i class="bi bi-book-fill"></i>
            </div>
            <h1 class="login-title">Perpustakaan Sekolah Digital</h1>
            <p class="login-subtitle">Sistem Manajemen Perpustakaan</p>
        </div>

        <div class="login-card">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope"></i> Email
                    </label>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock"></i> Password
                    </label>
                    <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                </button>
            </form>

            <div class="demo-accounts">
                <div class="demo-accounts-title">
                    <i class="bi bi-info-circle"></i> Akun Demo
                </div>
                <div class="demo-account">
                    <strong>Administrator</strong><br>
                    Email: <code>admin@example.com</code><br>
                    Password: <code>password</code>
                </div>
                <div class="demo-account">
                    <strong>User</strong><br>
                    Email: <code>user@example.com</code><br>
                    Password: <code>password</code>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
