
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Karyawan - TokoAlma</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">

        <header class="mb-6 flex items-center justify-between gap-3">
            <div>
                <a href="{{ route('dashboard') }}"
                   class="text-sm text-slate-500 hover:text-slate-800">
                    ← Kembali ke Dashboard
                </a>
                <h1 class="mt-2 text-2xl font-bold">Akun Karyawan</h1>
                <p class="mt-1 text-sm text-slate-500">
                    Kelola akun staff TokoAlma.
                </p>
            </div>

            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                Admin
            </span>
        </header>

        @if (session('success'))
            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-semibold">Data belum bisa disimpan:</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- Form tambah karyawan -->
            <section class="h-fit rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-bold">Tambah Karyawan</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Buat akun untuk karyawan yang bertugas menginput barang arrived.
                </p>

                <form action="{{ route('employees.store') }}" method="POST" class="mt-5 space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="mb-1 block text-sm font-medium">
                            Nama karyawan
                        </label>
                        <input id="name" name="name" type="text"
                               value="{{ old('name') }}" required maxlength="255"
                               autocomplete="name"
                               class="w-full rounded-xl border border-slate-300 px-3 py-2.5 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-100">
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium">
                            Email login
                        </label>
                        <input id="email" name="email" type="email"
                               value="{{ old('email') }}" required maxlength="255"
                               autocomplete="email"
                               class="w-full rounded-xl border border-slate-300 px-3 py-2.5 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-100">
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-medium">
                            Password
                        </label>
                        <input id="password" name="password" type="password"
                               required minlength="8" autocomplete="new-password"
                               class="w-full rounded-xl border border-slate-300 px-3 py-2.5 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-100">
                        <p class="mt-1 text-xs text-slate-500">Minimal 8 karakter.</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1 block text-sm font-medium">
                            Ulangi password
                        </label>
                        <input id="password_confirmation" name="password_confirmation"
                               type="password" required minlength="8"
                               autocomplete="new-password"
                               class="w-full rounded-xl border border-slate-300 px-3 py-2.5 outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-100">
                    </div>

                    <div class="rounded-xl bg-slate-50 p-3 text-sm">
                        <span class="font-medium">Peran akun:</span>
                        <span class="ml-1 rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-700">
                            Staff
                        </span>
                        <p class="mt-2 text-xs text-slate-500">
                            Staff hanya diperuntukkan bagi input barang arrived, bukan pengelolaan pengaturan.
                        </p>
                    </div>

                    <button type="submit"
                            class="w-full rounded-xl bg-amber-500 px-4 py-3 font-semibold text-white hover:bg-amber-600">
                        + Tambah Karyawan
                    </button>
                </form>
            </section>

            <!-- Daftar karyawan -->
            <section class="lg:col-span-2">
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-200 p-5">
                        <div>
                            <h2 class="text-lg font-bold">Daftar Karyawan</h2>
                            <p class="mt-1 text-sm text-slate-500">
                                Akun staff yang terdaftar di TokoAlma.
                            </p>
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold">
                            {{ $employees->count() }} staff
                        </span>
                    </div>

                    @forelse ($employees as $employee)
                        <div class="border-b border-slate-100 p-5 last:border-b-0">
                            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-amber-100 font-bold text-amber-700">
                                        {{ strtoupper(substr($employee->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold">{{ $employee->name }}</h3>
                                        <p class="break-all text-sm text-slate-500">{{ $employee->email }}</p>
                                        <span class="mt-2 inline-block rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                            Staff
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <button type="button"
                                            onclick="document.getElementById('edit-employee-{{ $employee->id }}').classList.toggle('hidden')"
                                            class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium hover:bg-slate-50">
                                        Edit
                                    </button>

                                    <form action="{{ route('employees.destroy', $employee) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus akun {{ addslashes($employee->name) }}? Akun ini tidak dapat login lagi.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Form edit -->
                            <div id="edit-employee-{{ $employee->id }}"
                                 class="mt-4 hidden rounded-xl bg-slate-50 p-4">
                                <h4 class="mb-3 font-semibold">Edit {{ $employee->name }}</h4>

                                <form action="{{ route('employees.update', $employee) }}"
                                      method="POST" class="space-y-3">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="mb-1 block text-sm font-medium">Nama</label>
                                        <input name="name" type="text" required maxlength="255"
                                               value="{{ $employee->name }}"
                                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2">
                                    </div>

                                    <div>
                                        <label class="mb-1 block text-sm font-medium">Email</label>
                                        <input name="email" type="email" required maxlength="255"
                                               value="{{ $employee->email }}"
                                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2">
                                    </div>

                                    <div>
                                        <label class="mb-1 block text-sm font-medium">
                                            Password baru (opsional)
                                        </label>
                                        <input name="password" type="password" minlength="8"
                                               autocomplete="new-password"
                                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2">
                                    </div>

                                    <div>
                                        <label class="mb-1 block text-sm font-medium">
                                            Ulangi password baru
                                        </label>
                                        <input name="password_confirmation" type="password" minlength="8"
                                               autocomplete="new-password"
                                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2">
                                    </div>

                                    <button type="submit"
                                            class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center">
                            <div class="text-4xl">👥</div>
                            <h3 class="mt-3 font-semibold">Belum ada akun karyawan</h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Tambahkan akun staff menggunakan formulir di sebelah kiri.
                            </p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</body>
</html>
