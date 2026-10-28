@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<style>
/* Pengguna: warna mengikuti variabel tema layouts.app */
.user-settings-page { color: var(--text); }
.user-settings-page .text-gray-900,
.user-settings-page .text-gray-800,
.user-settings-page .text-gray-700 { color: var(--text) !important; }
.user-settings-page .text-gray-600,
.user-settings-page .text-gray-500,
.user-settings-page .text-gray-400 { color: var(--muted) !important; }
.user-settings-page .bg-white { background-color: var(--surface) !important; }
.user-settings-page .bg-gray-50 { background-color: var(--bg) !important; }
.user-settings-page .border-gray-200,
.user-settings-page .border-gray-300 { border-color: var(--border) !important; }
.user-settings-page .bg-green-100 { background-color: var(--primary-soft) !important; }
.user-settings-page .text-green-700 { color: var(--primary-dark) !important; }
.user-settings-page .border-green-200 { border-color: var(--border) !important; }
.user-settings-page .bg-green-50 { background-color: var(--primary-soft) !important; }
.user-settings-page .text-green-800 { color: var(--text) !important; }
.user-settings-page .focus\:border-green-600:focus { border-color: var(--primary) !important; }
.user-settings-page .focus\:ring-green-100:focus { --tw-ring-color: var(--primary-soft) !important; }
.user-settings-page .bg-blue-600 { background-color: var(--primary) !important; }
.user-settings-page .hover\:bg-blue-700:hover { background-color: var(--primary-dark) !important; }
.user-settings-page .focus\:ring-blue-600:focus { --tw-ring-color: var(--primary) !important; }
.user-settings-page .hover\:bg-gray-100:hover { background-color: var(--primary-soft) !important; }
.user-settings-page input { color: var(--text); }
.user-settings-page input::placeholder { color: var(--muted); }
.user-settings-page .text-red-600,
.user-settings-page .text-red-700 { color: var(--danger) !important; }
.user-settings-page .border-red-200 { border-color: var(--danger) !important; }
.user-settings-page .bg-red-50 { background-color: var(--danger-soft) !important; }
</style>

<main class="user-settings-page max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8">

        {{-- Informasi halaman --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900">
                Pengaturan Akun
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Perbarui informasi akun dan password Anda.
            </p>
        </div>

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

                        <div class="relative">
                            <input id="current_password"
                                   name="current_password"
                                   type="password"
                                   required
                                   autocomplete="current-password"
                                   class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 pr-12 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100">
                            <button type="button" onclick="togglePasswordVisibility('current_password', this)"
                                    class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 transition hover:text-gray-800"
                                    aria-label="Tampilkan password lama" aria-pressed="false">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>

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

                            <div class="relative">
                                <input id="password"
                                       name="password"
                                       type="password"
                                       autocomplete="new-password"
                                       minlength="8"
                                       class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 pr-12 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100">
                                <button type="button" onclick="togglePasswordVisibility('password', this)"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 transition hover:text-gray-800"
                                        aria-label="Tampilkan password baru" aria-pressed="false">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>

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

                            <div class="relative">
                                <input id="password_confirmation"
                                       name="password_confirmation"
                                       type="password"
                                       autocomplete="new-password"
                                       class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 pr-12 text-sm outline-none transition focus:border-green-600 focus:ring-2 focus:ring-green-100">
                                <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 transition hover:text-gray-800"
                                        aria-label="Tampilkan konfirmasi password" aria-pressed="false">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
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
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                    <span>✓</span>
                    Simpan Perubahan
                </button>
            </footer>

        </form>

        <p class="mt-5 text-center text-xs text-gray-400">
            Milnkys &copy; {{ date('Y') }}
        </p>

    </main>
@endsection


<script>
    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        if (!input) return;

        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(isHidden));
        button.setAttribute(
            'aria-label',
            (isHidden ? 'Sembunyikan ' : 'Tampilkan ') + 'password'
        );

        button.innerHTML = isHidden
            ? `<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 3l18 18M10.6 10.6a2 2 0 0 0 2.8 2.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.9 5.2A10.9 10.9 0 0 1 12 5c6.4 0 10 7 10 7a16 16 0 0 1-3.1 3.9M6.2 6.2C3.5 8 2 12 2 12s3.6 7 10 7c1.4 0 2.7-.3 3.8-.8" stroke-linecap="round" stroke-linejoin="round"/></svg>`
            : `<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3"/></svg>`;
    }
</script>