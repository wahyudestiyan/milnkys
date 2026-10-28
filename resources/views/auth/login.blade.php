
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="theme-color" content="{{ $themeColors['background'] ?? config('theme.colors.background', '#F5F8FF') }}">
    <title>Login - Milnkys</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --primary: {{ $themeColors['primary'] ?? config('theme.colors.primary', '#2563EB') }};
            --primary-dark: {{ $themeColors['primary_dark'] ?? config('theme.colors.primary_dark', '#1D4ED8') }};
            --primary-soft: {{ $themeColors['primary_soft'] ?? config('theme.colors.primary_soft', '#DBEAFE') }};
            --bg: {{ $themeColors['background'] ?? config('theme.colors.background', '#F5F8FF') }};
            --surface: {{ $themeColors['surface'] ?? config('theme.colors.surface', '#FFFFFF') }};
            --text: {{ $themeColors['text'] ?? config('theme.colors.text', '#1E293B') }};
            --muted: {{ $themeColors['muted'] ?? config('theme.colors.muted', '#64748B') }};
            --border: {{ $themeColors['border'] ?? config('theme.colors.border', '#E2E8F0') }};
            --danger: {{ $themeColors['danger'] ?? config('theme.colors.danger', '#DC2626') }};
            --danger-soft: {{ $themeColors['danger_soft'] ?? config('theme.colors.danger_soft', '#FEE2E2') }};
            --success: {{ $themeColors['success'] ?? config('theme.colors.success', '#16A34A') }};
            --success-soft: {{ $themeColors['success_soft'] ?? config('theme.colors.success_soft', '#DCFCE7') }};
        }

        body {
            background: var(--bg);
            color: var(--text);
        }

        .login-logo {
            background: var(--primary);
            box-shadow: 0 10px 20px color-mix(in srgb, var(--primary) 20%, transparent);
        }

        .login-title {
            color: var(--text);
        }

        .login-subtitle {
            color: var(--muted);
        }

        .login-card {
            background: var(--surface);
        }

        .login-label {
            color: var(--text);
        }

        .login-input {
            width: 100%;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--text);
        }

        .login-input::placeholder {
            color: var(--muted);
            opacity: .8;
        }

        .login-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary) 20%, transparent);
        }

        .password-toggle {
            color: var(--muted);
        }

        .password-toggle:hover {
            color: var(--primary-dark);
        }

        .password-toggle:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: -4px;
        }

        .remember-checkbox {
            accent-color: var(--primary);
        }

        .login-button {
            background: var(--primary);
            box-shadow: 0 4px 10px color-mix(in srgb, var(--primary) 20%, transparent);
        }

        .login-button:hover {
            background: var(--primary-dark);
        }

        .login-button:focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }

        .login-error {
            background: var(--danger-soft);
            color: var(--danger);
        }

        .login-success {
            background: var(--success-soft);
            color: var(--success);
        }

        .login-footer {
            color: var(--muted);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-5">

    <main class="w-full max-w-md">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="login-logo mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl text-3xl text-white">
                🛍️
            </div>

            <h1 class="login-title text-3xl font-bold">Milnkys</h1>

            <p class="login-subtitle mt-2 text-sm">
                Silakan login untuk melanjutkan
            </p>
        </div>

        <!-- Login Card -->
        <div class="login-card rounded-3xl p-7 shadow-sm sm:p-9">

            @if ($errors->any())
                <div
                    role="alert"
                    class="login-error mb-5 rounded-xl p-3 text-sm"
                >
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="login-success mb-5 rounded-xl p-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form
                action="{{ route('login.store') }}"
                method="POST"
                class="space-y-5"
            >
                @csrf

                <!-- Email -->
                <div>
                    <label
                        for="email"
                        class="login-label mb-2 block text-sm font-medium"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="nama@email.com"
                        class="login-input rounded-xl px-4 py-3 transition"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label
                        for="password"
                        class="login-label mb-2 block text-sm font-medium"
                    >
                        Password
                    </label>

                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="login-input rounded-xl py-3 pl-4 pr-14 transition"
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                            aria-pressed="false"
                            class="password-toggle absolute inset-y-0 right-0 flex items-center px-4 transition focus:outline-none"
                        >
                            <svg
                                id="eyeIcon"
                                xmlns="http://www.w3.org/2000/svg"
                                width="22"
                                height="22"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <label class="login-subtitle flex items-center gap-2 text-sm">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="remember-checkbox rounded"
                    >
                    Ingat saya
                </label>

                <!-- Submit -->
                <button
                    type="submit"
                    class="login-button w-full rounded-xl px-4 py-3 font-semibold text-white transition focus:outline-none"
                >
                    Masuk ke Milnkys
                </button>
            </form>
        </div>

        <p class="login-footer mt-6 text-center text-xs">
            &copy; {{ date('Y') }} Milnkys
        </p>

    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';

            togglePassword.setAttribute(
                'aria-label',
                isHidden ? 'Sembunyikan password' : 'Tampilkan password'
            );

            togglePassword.setAttribute(
                'aria-pressed',
                isHidden ? 'true' : 'false'
            );

            eyeIcon.innerHTML = isHidden
                ? '<path d="M3 3l18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.4 0 10 7 10 7a15 15 0 0 1-3.1 3.9"/><path d="M6.6 6.6C3.6 8.5 2 12 2 12s3.6 7 10 7a10.8 10.8 0 0 0 4-.8"/>'
                : '<path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>';
        });
    </script>

</body>
</html>
