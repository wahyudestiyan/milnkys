@extends('layouts.app')

@section('title', 'Akun Karyawan')
@section('page-title', 'Akun Karyawan')
@section('page-subtitle', 'Kelola akun staff Milnkys.')

@section('content')

<div class="employee-page">

    {{-- Notifikasi validasi --}}
    @if ($errors->any())
        <div class="employee-alert employee-alert-error">
            <p class="employee-font-semibold">
                Data belum bisa disimpan:
            </p>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="employee-header">
        <div>
            <h2>Akun Karyawan</h2>
            <p>Kelola akun staff Milnkys.</p>
        </div>

        <span class="employee-badge employee-badge-primary">
            Admin
        </span>
    </div>

    <div class="employee-layout">

        {{-- Form tambah karyawan --}}
        <section class="employee-card employee-add-card">

            <div class="employee-card-heading">
                <h3>Tambah Karyawan</h3>
                <p>
                    Buat akun untuk karyawan yang bertugas
                    menginput barang arrived.
                </p>
            </div>

            <form
                action="{{ route('employees.store') }}"
                method="POST"
                class="employee-form"
            >
                @csrf

                <div class="employee-field">
                    <label for="name">Nama karyawan</label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        maxlength="255"
                        autocomplete="name"
                    >
                </div>

                <div class="employee-field">
                    <label for="email">Email login</label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        maxlength="255"
                        autocomplete="email"
                    >
                </div>

                <div class="employee-field">
                    
                    <div class="employee-password-wrapper">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            class="employee-password-toggle"
                            onclick="toggleEmployeePassword('password', this)"
                            aria-label="Tampilkan password"
                            title="Tampilkan password"
                        >
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"
                                    stroke="currentColor" stroke-width="1.8"/>
                                <circle cx="12" cy="12" r="3"
                                        stroke="currentColor" stroke-width="1.8"/>
                            </svg>
                        </button>
                    </div>
                    <small>Minimal 8 karakter.</small>

                </div>

                <div class="employee-field">
                    
                    <div class="employee-password-wrapper">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            class="employee-password-toggle"
                            onclick="toggleEmployeePassword('password_confirmation', this)"
                            aria-label="Tampilkan password"
                            title="Tampilkan password"
                        >
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"
                                    stroke="currentColor" stroke-width="1.8"/>
                                <circle cx="12" cy="12" r="3"
                                        stroke="currentColor" stroke-width="1.8"/>
                            </svg>
                        </button>
                    </div>

                </div>

                <div class="employee-role-info">
                    <div class="employee-role-heading">
                        <span>Peran akun:</span>

                        <span class="employee-badge employee-badge-primary">
                            Staff
                        </span>
                    </div>

                    <p>
                        Staff hanya diperuntukkan bagi input barang
                        arrived, bukan pengelolaan pengaturan.
                    </p>
                </div>

                <button
                    type="submit"
                    class="employee-button employee-button-primary employee-button-full"
                >
                    + Tambah Karyawan
                </button>
            </form>
        </section>

        {{-- Daftar karyawan --}}
        <section class="employee-card employee-list-card">

            <div class="employee-list-heading">
                <div>
                    <h3>Daftar Karyawan</h3>
                    <p>Akun staff yang terdaftar di Milnkys.</p>
                </div>

                <span class="employee-count">
                    {{ $employees->count() }} staff
                </span>
            </div>

            @forelse ($employees as $employee)
                <div class="employee-item">

                    <div class="employee-item-main">

                        <div class="employee-avatar">
                            {{ strtoupper(substr($employee->name, 0, 1)) }}
                        </div>

                        <div class="employee-identity">
                            <h4>{{ $employee->name }}</h4>

                            <p>{{ $employee->email }}</p>

                            <span class="employee-badge employee-badge-primary">
                                Staff
                            </span>
                        </div>

                    </div>

                    <div class="employee-actions">

                        <button
                            type="button"
                            class="employee-button employee-button-secondary"
                            onclick="document.getElementById('edit-employee-{{ $employee->id }}').classList.toggle('hidden')"
                        >
                            Edit
                        </button>

                        <form
                            action="{{ route('employees.destroy', $employee) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus akun {{ addslashes($employee->name) }}? Akun ini tidak dapat login lagi.')"
                        >
                            @csrf
                            @method('DELETE')

                          
                            <button
                                type="button"
                                class="employee-button employee-button-danger"
                                onclick="openDeleteModal(
                                    {{ $employee->id }},
                                    @js($employee->name),
                                    @js(route('employees.destroy', $employee))
                                )"
                            >
                                Hapus
                            </button>

                        </form>

                    </div>

                    {{-- Form edit karyawan --}}
                    <div
                        id="edit-employee-{{ $employee->id }}"
                        class="employee-edit-form hidden"
                    >
                        <h4>Edit {{ $employee->name }}</h4>

                        <form
                            action="{{ route('employees.update', $employee) }}"
                            method="POST"
                            class="employee-form"
                        >
                            @csrf
                            @method('PUT')

                            <div class="employee-field">
                                <label for="edit-name-{{ $employee->id }}">
                                    Nama
                                </label>

                                <input
                                    id="edit-name-{{ $employee->id }}"
                                    name="name"
                                    type="text"
                                    required
                                    maxlength="255"
                                    value="{{ $employee->name }}"
                                >
                            </div>

                            <div class="employee-field">
                                <label for="edit-email-{{ $employee->id }}">
                                    Email
                                </label>

                                <input
                                    id="edit-email-{{ $employee->id }}"
                                    name="email"
                                    type="email"
                                    required
                                    maxlength="255"
                                    value="{{ $employee->email }}"
                                >
                            </div>

                            <div class="employee-field">
                                <label for="edit-password-{{ $employee->id }}">
                                    Password baru (opsional)
                                </label>

                                <input
                                    id="edit-password-{{ $employee->id }}"
                                    name="password"
                                    type="password"
                                    minlength="8"
                                    autocomplete="new-password"
                                >
                            </div>

                            <div class="employee-field">
                                <label for="edit-password-confirmation-{{ $employee->id }}">
                                    Ulangi password baru
                                </label>

                                <input
                                    id="edit-password-confirmation-{{ $employee->id }}"
                                    name="password_confirmation"
                                    type="password"
                                    minlength="8"
                                    autocomplete="new-password"
                                >
                            </div>

                            <button
                                type="submit"
                                class="employee-button employee-button-primary"
                            >
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="employee-empty">
                    <div class="employee-empty-icon">👥</div>

                    <h4>Belum ada akun karyawan</h4>

                    <p>
                        Tambahkan akun staff menggunakan formulir
                        tambah karyawan.
                    </p>
                </div>
            @endforelse

        </section>

    </div>
</div>
{{-- Modal konfirmasi hapus karyawan --}}

{{-- Modal konfirmasi hapus karyawan --}}
<div
    id="deleteEmployeeModal"
    class="employee-modal hidden"
    aria-hidden="true"
>
    <div
        class="employee-modal-backdrop"
        onclick="closeDeleteModal()"
    ></div>

    <div
        class="employee-modal-content"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deleteModalTitle"
    >
        <div class="employee-modal-icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path
                    d="M12 8v5m0 3h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
        </div>

        <h3 id="deleteModalTitle">
            Hapus Akun Karyawan?
        </h3>

        <p class="employee-modal-description">
            Apakah Anda yakin ingin menghapus akun karyawan ini?
            Akun yang dihapus tidak dapat login lagi.
        </p>

        <div class="employee-delete-info">
            <span>Nama Karyawan</span>
            <strong id="deleteEmployeeName">-</strong>
        </div>

        <div class="employee-modal-actions">
            <button
                type="button"
                class="employee-button employee-button-secondary"
                onclick="closeDeleteModal()"
            >
                Batal
            </button>

            <form
                id="deleteEmployeeForm"
                method="POST"
                action=""
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="employee-button employee-button-danger employee-button-confirm-delete"
                >
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        aria-hidden="true"
                    >
                        <path
                            d="M4 7h16M10 11v6m4-6v6M6 7l1 14h10l1-14M9 7V4h6v3"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
<style>
    .employee-page {
        width: 100%;
        color: var(--text);
    }

    .employee-page,
    .employee-page * {
        box-sizing: border-box;
    }

    .employee-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 24px;
    }

    .employee-header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: var(--text);
    }

    .employee-header p,
    .employee-card-heading p,
    .employee-list-heading p {
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 13px;
        line-height: 1.6;
    }

    .employee-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 24px;
        align-items: start;
    }

    .employee-card {
        min-width: 0;
        overflow: hidden;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }

    .employee-add-card {
        padding: 20px;
    }

    .employee-card-heading h3,
    .employee-list-heading h3 {
        margin: 0;
        color: var(--text);
        font-size: 17px;
        font-weight: 700;
    }

    .employee-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 20px;
    }

    .employee-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
        min-width: 0;
    }

    .employee-field label {
        color: var(--text);
        font-size: 13px;
        font-weight: 600;
    }

    .employee-field input {
        display: block;
        width: 100%;
        min-width: 0;
        min-height: 42px;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: var(--surface);
        color: var(--text);
        font: inherit;
        font-size: 14px;
        outline: none;
    }

    .employee-field input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-soft);
    }

    .employee-field input::placeholder {
        color: var(--muted);
    }

    .employee-field small {
        color: var(--muted);
        font-size: 12px;
    }

    .employee-role-info {
        padding: 13px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--bg);
    }

    .employee-role-heading {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        color: var(--text);
        font-size: 13px;
        font-weight: 600;
    }

    .employee-role-info p {
        margin: 9px 0 0;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .employee-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: fit-content;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .employee-badge-primary {
        background: var(--primary-soft);
        color: var(--primary-dark);
    }

    .employee-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 36px;
        padding: 8px 12px;
        border: 1px solid transparent;
        border-radius: 9px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.4;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.15s ease, opacity 0.15s ease;
    }

    .employee-button-primary {
        background: var(--primary);
        color: #fff;
    }

    .employee-button-primary:hover {
        background: var(--primary-dark);
    }

    .employee-button-full {
        width: 100%;
        min-height: 44px;
        padding: 11px 16px;
        font-size: 13px;
    }

    .employee-button-secondary {
        border-color: var(--border);
        background: var(--surface);
        color: var(--text);
    }

    .employee-button-secondary:hover {
        background: var(--bg);
    }

    .employee-button-danger {
        border-color: var(--danger-soft);
        background: var(--surface);
        color: var(--danger);
    }

    .employee-button-danger:hover {
        background: var(--danger-soft);
    }

    .employee-list-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 20px;
        border-bottom: 1px solid var(--border);
    }

    .employee-count {
        flex-shrink: 0;
        padding: 6px 10px;
        border-radius: 999px;
        background: var(--bg);
        color: var(--text);
        font-size: 12px;
        font-weight: 600;
    }

    .employee-item {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 20px;
        border-bottom: 1px solid var(--border);
    }

    .employee-item:last-child {
        border-bottom: 0;
    }

    .employee-item-main {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        min-width: 0;
        flex: 1 1 180px;
    }

    .employee-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        flex-shrink: 0;
        border-radius: 50%;
        background: var(--primary-soft);
        color: var(--primary-dark);
        font-size: 16px;
        font-weight: 700;
    }

    .employee-identity {
        min-width: 0;
    }

    .employee-identity h4 {
        margin: 0;
        color: var(--text);
        font-size: 14px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .employee-identity p {
        margin: 5px 0 0;
        color: var(--muted);
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .employee-identity .employee-badge {
        margin-top: 9px;
    }

    .employee-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
    }

    .employee-actions form {
        margin: 0;
    }

    .employee-edit-form {
        flex-basis: 100%;
        width: 100%;
        min-width: 0;
        margin-top: 4px;
        padding: 16px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--bg);
    }

    .employee-edit-form h4 {
        margin: 0;
        color: var(--text);
        font-size: 14px;
        font-weight: 700;
    }

    .employee-empty {
        padding: 36px 20px;
        text-align: center;
    }

    .employee-empty-icon {
        font-size: 32px;
    }

    .employee-empty h4 {
        margin: 12px 0 0;
        color: var(--text);
        font-size: 14px;
        font-weight: 700;
    }

    .employee-empty p {
        margin: 7px 0 0;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.6;
    }

    .employee-alert {
        margin-bottom: 20px;
        padding: 14px 16px;
        border: 1px solid;
        border-radius: 12px;
        font-size: 13px;
        line-height: 1.6;
    }

    .employee-alert-success {
        border-color: var(--success);
        background: var(--success-soft);
        color: var(--success);
    }

    .employee-alert-error {
        border-color: var(--danger);
        background: var(--danger-soft);
        color: var(--danger);
    }

    .employee-alert ul {
        margin: 8px 0 0;
        padding-left: 20px;
        list-style: disc;
    }

    .employee-font-semibold {
        font-weight: 600;
    }

    .hidden {
        display: none !important;
    }

    @media (min-width: 900px) {
        .employee-layout {
            grid-template-columns: minmax(0, 1fr) minmax(0, 2fr);
        }
    }

    @media (max-width: 600px) {
        .employee-header {
            margin-bottom: 18px;
        }

        .employee-add-card {
            padding: 16px;
        }

        .employee-list-heading {
            padding: 16px;
        }

        .employee-item {
            padding: 16px;
        }

        .employee-actions {
            width: 100%;
        }

        .employee-actions .employee-button {
            min-width: 64px;
        }

        .employee-edit-form {
            padding: 12px;
        }
    }
    
.employee-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.employee-modal.hidden {
    display: none !important;
}

.employee-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(3px);
}

.employee-modal-content {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 420px;
    padding: 24px;
    border: 1px solid var(--border);
    border-radius: 18px;
    background: var(--surface);
    color: var(--text);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18);
    animation: employeeModalIn 0.18s ease-out;
}

.employee-modal-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    margin-bottom: 16px;
    border-radius: 50%;
    background: var(--danger-soft);
    color: var(--danger);
}

.employee-modal-icon svg {
    width: 25px;
    height: 25px;
}

.employee-modal-content h3 {
    margin: 0;
    color: var(--text);
    font-size: 18px;
    font-weight: 700;
    line-height: 1.4;
}

.employee-modal-description {
    margin: 10px 0 18px;
    color: var(--muted);
    font-size: 13px;
    line-height: 1.7;
}

.employee-delete-info {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 22px;
    padding: 13px 14px;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: var(--bg);
}

.employee-delete-info span {
    color: var(--muted);
    font-size: 12px;
}

.employee-delete-info strong {
    color: var(--text);
    font-size: 14px;
    font-weight: 700;
    overflow-wrap: anywhere;
}

.employee-modal-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}

.employee-modal-actions form {
    display: flex;
    margin: 0;
}

.employee-modal-actions .employee-button {
    min-height: 38px;
    padding: 9px 14px;
    font-size: 12px;
}

.employee-button-confirm-delete {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    background: var(--danger);
    border-color: var(--danger);
    color: #fff;
}

.employee-button-confirm-delete:hover {
    opacity: 0.9;
}

.employee-button-confirm-delete svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

@keyframes employeeModalIn {
    from {
        opacity: 0;
        transform: translateY(8px) scale(0.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@media (max-width: 480px) {
    .employee-modal-content {
        padding: 20px;
        border-radius: 16px;
    }

    .employee-modal-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .employee-modal-actions > button,
    .employee-modal-actions > form,
    .employee-modal-actions > form button {
        width: 100%;
    }
}

.employee-password-wrapper {
    position: relative;
    width: 100%;
    min-width: 0;
}

.employee-password-wrapper input {
    padding-right: 42px;
}

.employee-password-toggle {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    padding: 0;
    border: none;
    background: transparent;
    color: var(--muted);
    cursor: pointer;
}

.employee-password-toggle:hover {
    color: var(--primary);
}

.employee-password-toggle svg {
    width: 19px;
    height: 19px;
}


</style>
<script>
    
function openDeleteModal(id, name, deleteUrl) {
    const modal = document.getElementById('deleteEmployeeModal');
    const form = document.getElementById('deleteEmployeeForm');
    const nameElement = document.getElementById('deleteEmployeeName');

    if (!modal || !form || !nameElement) return;

    form.action = deleteUrl;
    nameElement.textContent = name;

    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteEmployeeModal');

    if (!modal) return;

    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');
}

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeDeleteModal();
    }
});


function toggleEmployeePassword(inputId, button) {
    const input = document.getElementById(inputId);

    if (!input) return;

    const isPassword = input.type === 'password';

    input.type = isPassword ? 'text' : 'password';

    button.setAttribute(
        'aria-label',
        isPassword ? 'Sembunyikan password' : 'Tampilkan password'
    );

    button.setAttribute(
        'title',
        isPassword ? 'Sembunyikan password' : 'Tampilkan password'
    );
}


</script>
@endsection