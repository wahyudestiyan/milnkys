<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengguna - Milnkys</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 text-gray-800">

    {{-- Header --}}
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-4">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-700">
                        <span class="text-xl">👤</span>
                    </div>

                    <div>
                        <h1 class="text-xl font-bold text-gray-900">
                            Pengguna
                        </h1>
                        <p class="text-sm text-gray-500">
                            Pengaturan profil akun Milnkys
                        </p>
                    </div>
                </div>

                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                    <span>←</span>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
        </div>
    </header>

    {{-- Konten --}}
    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8">

        {{-- Informasi halaman --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900">
                Pengaturan Akun
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui informasi akun dan password Anda.
            </p>
        </div>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div class="mb-5 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
                <span class="text-lg">✓</span>
                <div>
                    <p class="font-semibold">Berhasil</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Notifikasi error --}}
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="mb-2 font-semibold">Periksa kembali data berikut:</p>
                <ul class="list-disc space-y-1 pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}"
              method="POST"
              class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            @csrf
            @method('PUT')

            {{-- Informasi akun --}}
            <section class="p-5 sm:p-7">
                <div class="mb-6 flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-700">
                        <span>📋</span>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-900">
                            Informasi Akun
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Informasi dasar akun yang sedang digunakan.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label for="name"
                               class="mb-2 block text-sm font-medium text-gray-700">
                            Nama pengguna
                        </label>

                        <input id="name"
                               name="name"
                               type="text"
                               value="{{ old('name', $user->name) }}"
                               required
                               maxlength="255"
                               autocomplete="name"
                               class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100">

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email"
                               class="mb-2 block text-sm font-medium text-gray-700">
                            Email
                        </label>

                        <input id="email"
                               name="email"
                               type="email"
                               value="{{ old('email', $user->email) }}"
                               required
                               maxlength="255"
                               autocomplete="email"
                               class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100">

                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <div class="border-t border-gray-200"></div>

            {{-- Ganti password --}}
            <section class="p-5 sm:p-7">
                <div class="mb-6 flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-700">
                        <span>🔒</span>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-900">
                            Ganti Password
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Gunakan password baru untuk menjaga keamanan akun.
                        </p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="current_password"
                               class="mb-2 block text-sm font-medium text-gray-700">
                            Password lama
                        </label>

                        <input id="current_password"
                               name="current_password"
                               type="password"
                               required
                               autocomplete="current-password"
                               class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100">

                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label for="password"
                                   class="mb-2 block text-sm font-medium text-gray-700">
                                Password baru
                            </label>

                            <input id="password"
                                   name="password"
                                   type="password"
                                   autocomplete="new-password"
                                   minlength="8"
                                   class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100">

                            <p class="mt-1.5 text-xs text-gray-500">
                                Minimal 8 karakter.
                            </p>

                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation"
                                   class="mb-2 block text-sm font-medium text-gray-700">
                                Konfirmasi password baru
                            </label>

                            <input id="password_confirmation"
                                   name="password_confirmation"
                                   type="password"
                                   autocomplete="new-password"
                                   class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100">
                        </div>
                    </div>

                    <p class="rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-600">
                        <span class="font-medium">Catatan:</span>
                        Kosongkan password baru jika tidak ingin menggantinya.
                    </p>
                </div>
            </section>

            {{-- Tombol aksi --}}
            <footer class="flex flex-col-reverse gap-3 border-t border-gray-200 bg-gray-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-end sm:px-7">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                    Batal
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-green-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2">
                    <span>✓</span>
                    Simpan Perubahan
                </button>
            </footer>

        </form>

        <p class="mt-5 text-center text-xs text-gray-400">
            Milnkys &copy; {{ date('Y') }}
        </p>

    </main>

</body>
</html>