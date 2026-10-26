
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <title>Login - Milnkys</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#f5f6f0] flex items-center justify-center p-5">

    <main class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-[#9CB080] text-3xl">
                🛍️
            </div>

            <h1 class="text-3xl font-bold text-gray-800">Milnkys</h1>
            <p class="mt-2 text-sm text-gray-500">
                Silakan login untuk melanjutkan
            </p>
        </div>

        <!-- Login Card -->
        <div class="rounded-3xl bg-white p-7 shadow-sm sm:p-9">

            @if ($errors->any())
                <div
                    role="alert"
                    class="mb-5 rounded-xl bg-red-50 p-3 text-sm text-red-700"
                >
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="mb-5 rounded-xl bg-green-50 p-3 text-sm text-green-700">
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
                        class="mb-2 block text-sm font-medium text-gray-700"
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
                        class="w-full rounded-xl border border-gray-200 px-4 py-3 outline-none transition focus:border-[#9CB080] focus:ring-2 focus:ring-[#9CB080]/20"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label
                        for="password"
                        class="mb-2 block text-sm font-medium text-gray-700"
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
                            class="w-full rounded-xl border border-gray-200 px-4 py-3 pr-14 outline-none transition focus:border-[#9CB080] focus:ring-2 focus:ring-[#9CB080]/20"
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            aria-label="Tampilkan password"
                            aria-pressed="false"
                            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 transition hover:text-[#71885A] focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#9CB080]"
                        >
                            <!-- Ikon mata -->
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
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="rounded border-gray-300 accent-[#9CB080]"
                    >
                    Ingat saya
                </label>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full rounded-xl bg-[#9CB080] px-4 py-3 font-semibold text-white transition hover:bg-[#879D6D] focus:outline-none focus:ring-2 focus:ring-[#9CB080] focus:ring-offset-2"
                >
                    Masuk ke Milnkys
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-gray-400">
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
