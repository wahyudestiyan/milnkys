@extends('layouts.app')

@section('content')
<style>
* { box-sizing: border-box; }



        .container { max-width: 900px; margin: auto; }

        .back {
            display: inline-block;
            margin-bottom: 24px;
            color: var(--primary-dark);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .eyebrow {
            color: var(--primary);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.4px;
        }

        .container h1 { margin: 9px 0; font-size: 27px; letter-spacing: -.6px; }
        .muted { color: var(--muted); font-size: 13px; line-height: 1.7; }

        .card {
            margin-top: 20px;
            padding: 23px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.04);
        }

        .card h2 { margin: 0 0 8px; font-size: 17px; }
        .card-description { margin: 0 0 16px; }

        label {
            display: block;
            margin: 17px 0 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .container input, .container textarea, .container select {
            display: block;
            width: 100%;
            min-height: 46px;
            padding: 12px 13px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--surface);
            color: var(--text);
            font: inherit;
            font-size: 14px;
            outline: none;
        }

        .container textarea { min-height: 82px; resize: vertical; }

        .container input:focus, .container textarea:focus, .container select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary) 18%, transparent);
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 40px;
            padding: 10px 14px;
            border: 0;
            border-radius: 11px;
            background: var(--primary);
            color: var(--surface);
            font-family: inherit;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .button:hover { background: var(--primary-dark); }
        .button-full { width: 100%; min-height: 48px; margin-top: 17px; }
        .button-secondary { background: var(--primary-soft); color: var(--primary-dark); }
        .button-secondary:hover { background: var(--primary-soft); }
        .button-danger { background: var(--danger-soft); color: var(--danger); }
        .button-danger:hover { background: var(--danger-soft); }

        .success, .errors {
            margin-top: 18px;
            padding: 14px 16px;
            border-radius: 13px;
            font-size: 13px;
        }

        .success { background: var(--success-soft); color: var(--success); border: 1px solid var(--border); }
        .errors { background: var(--danger-soft); color: var(--danger); }
        .errors ul { margin-bottom: 0; padding-left: 20px; }

        .list-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 30px;
            padding: 0 10px;
            border-radius: 20px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-size: 12px;
            font-weight: 800;
        }

        .payment-list { display: grid; gap: 12px; }

        .payment-item {
            padding: 17px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: var(--surface);
        }

        .payment-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .payment-name {
            min-width: 0;
            overflow-wrap: anywhere;
            font-size: 14px;
            font-weight: 800;
        }

        .payment-description {
            margin-top: 5px;
            overflow-wrap: anywhere;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .status {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 20px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-size: 11px;
            font-weight: 800;
        }

        .status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--primary);
        }

        .status.inactive { background: var(--bg); color: var(--muted); }
        .status.inactive::before { background: var(--muted); }

        .payment-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .edit-panel {
            display: none;
            margin-top: 14px;
            padding: 16px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--bg);
        }

        .edit-panel.open { display: block; }
        .edit-heading { margin: 0 0 5px; font-size: 13px; font-weight: 800; }
        .edit-help { margin: 0 0 12px; color: var(--muted); font-size: 11px; }
        .edit-actions { display: flex; gap: 8px; margin-top: 14px; }
        .edit-actions .button { flex: 1; }

        .empty {
            padding: 30px 15px;
            border: 1px dashed var(--border);
            border-radius: 15px;
            color: var(--muted);
            text-align: center;
            font-size: 13px;
            line-height: 1.7;
        }

        @media (max-width: 480px) {
            body { padding: 20px 12px 30px; }
            .card { padding: 17px; border-radius: 19px; }
            .container h1 { font-size: 24px; }
            .payment-item { padding: 14px; }
            .payment-top { gap: 8px; }
            .payment-actions .button { flex: 1; }
            .edit-panel { padding: 13px; }
        }
</style>

<main class="container">
    <a href="{{ route('dashboard') }}" class="back">← Kembali ke Dashboard</a>

    <header>
        <div class="eyebrow">MILNKYS· PENGATURAN</div>
        <h1>Jenis Payment</h1>
        <p class="muted">Kelola metode pembayaran yang digunakan untuk transaksi Milnkys.</p>
    </header>
@if ($errors->any())
        <div class="errors">
            <strong>Periksa kembali data yang diisi:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="card">
        <h2>Tambah Jenis Payment</h2>
        <p class="muted card-description">Contoh: Transfer Bank, QRIS, atau Kartu Kredit.</p>

        <form action="{{ route('payment-types.store') }}" method="POST">
            @csrf

            <label for="name">Nama Metode Pembayaran</label>
            <input
                id="name"
                name="name"
                type="text"
                maxlength="255"
                value="{{ old('name') }}"
                placeholder="Contoh: Transfer Bank"
                required
            >

            <label for="description">Deskripsi (opsional)</label>
            <textarea
                id="description"
                name="description"
                placeholder="Keterangan metode pembayaran"
            >{{ old('description') }}</textarea>

            <button type="submit" class="button button-full">＋ Tambah Jenis Payment</button>
        </form>
    </section>

    <section class="card">
        <div class="list-header">
            <div>
                <h2>Daftar Jenis Payment</h2>
                <p class="muted" style="margin:6px 0 0">Metode pembayaran yang tersedia.</p>
            </div>
            <span class="count">{{ $paymentTypes->count() }}</span>
        </div>

        @if ($paymentTypes->isEmpty())
            <div class="empty">
                Belum ada jenis payment.<br>
                Silakan tambahkan melalui formulir di atas.
            </div>
        @else
            <div class="payment-list">
                @foreach ($paymentTypes as $paymentType)
                    <article class="payment-item">
                        <div class="payment-top">
                            <div style="min-width:0">
                                <div class="payment-name">{{ $paymentType->name }}</div>
                                <div class="payment-description">
                                    {{ $paymentType->description ?: 'Tidak ada deskripsi' }}
                                </div>
                            </div>

                            <span class="status {{ $paymentType->is_active ? '' : 'inactive' }}">
                                {{ $paymentType->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>

                        <div class="payment-actions">
                            <button
                                type="button"
                                class="button button-secondary"
                                onclick="toggleEdit('edit-{{ $paymentType->id }}')"
                                aria-controls="edit-{{ $paymentType->id }}"
                                aria-expanded="false"
                            >✎ Edit</button>

                            
                            <button
                                type="button"
                                class="button button-danger"
                                onclick="openPaymentDeleteModal(
                                    '{{ route('payment-types.destroy', $paymentType) }}',
                                    @js($paymentType->name)
                                )">
                                Hapus
                            </button>

                        </div>

                        <div class="edit-panel" id="edit-{{ $paymentType->id }}">
                            <p class="edit-heading">Edit Jenis Payment</p>
                            <p class="edit-help">Perbarui nama, deskripsi, atau status metode pembayaran.</p>

                            <form
                                action="{{ route('payment-types.update', $paymentType) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PUT')

                                <label for="name-{{ $paymentType->id }}">Nama</label>
                                <input
                                    id="name-{{ $paymentType->id }}"
                                    name="name"
                                    type="text"
                                    maxlength="255"
                                    value="{{ $paymentType->name }}"
                                    required
                                >

                                <label for="description-{{ $paymentType->id }}">Deskripsi</label>
                                <textarea
                                    id="description-{{ $paymentType->id }}"
                                    name="description"
                                >{{ $paymentType->description }}</textarea>

                                <label for="active-{{ $paymentType->id }}">Status</label>
                                <select id="active-{{ $paymentType->id }}" name="is_active" required>
                                    <option value="1" @selected($paymentType->is_active)>Aktif</option>
                                    <option value="0" @selected(!$paymentType->is_active)>Nonaktif</option>
                                </select>

                                <div class="edit-actions">
                                    <button type="submit" class="button">Simpan Perubahan</button>
                                    <button
                                        type="button"
                                        class="button button-secondary"
                                        onclick="toggleEdit('edit-{{ $paymentType->id }}', true)"
                                    >Batal</button>
                                </div>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</main>

<div id="paymentDeleteModal" class="delete-modal" aria-hidden="true">
    <div class="delete-modal-backdrop"
         onclick="closePaymentDeleteModal()"></div>

    <div class="delete-modal-card"
         role="dialog"
         aria-modal="true"
         aria-labelledby="paymentDeleteTitle">

        <div class="delete-modal-icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M12 8v5m0 3h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

        <h3 id="paymentDeleteTitle">Hapus Jenis Payment?</h3>

        <p class="delete-modal-description">
            Apakah Anda yakin ingin menghapus metode pembayaran ini?
            Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="delete-order-info">
            <span>Nama Metode Pembayaran</span>
            <strong id="deletePaymentName">-</strong>
        </div>

        <div class="delete-modal-actions">
            <button type="button"
                    class="modal-btn modal-btn-cancel"
                    onclick="closePaymentDeleteModal()">
                Batal
            </button>

            <form id="deletePaymentForm" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="modal-btn modal-btn-delete">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 7h16M10 11v6m4-6v6M6 7l1 14h10l1-14M9 7V4h6v3"
                              stroke="currentColor"
                              stroke-width="1.7"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
<style>
    
/* Modal hapus modern */
.delete-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    visibility: hidden;
    transition: opacity .2s ease, visibility .2s ease;
}

.delete-modal.is-open {
    opacity: 1;
    visibility: visible;
}

.delete-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, .48);
    backdrop-filter: blur(3px);
}

.delete-modal-card {
    position: relative;
    width: 100%;
    max-width: 420px;
    padding: 28px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 18px;
    box-shadow: 0 24px 70px rgba(0, 0, 0, .18);
    transform: translateY(12px) scale(.98);
    transition: transform .2s ease;
}

.delete-modal.is-open .delete-modal-card {
    transform: translateY(0) scale(1);
}

.delete-modal-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    margin-bottom: 18px;
    color: var(--danger);
    background: var(--danger-soft);
    border-radius: 14px;
}

.delete-modal-icon svg {
    width: 25px;
    height: 25px;
}

.delete-modal-card h3 {
    margin: 0 0 8px;
    color: var(--text);
    font-size: 21px;
    font-weight: 800;
}

.delete-modal-description {
    margin: 0 0 20px;
    color: var(--muted);
    font-size: 13px;
    line-height: 1.7;
}

.delete-order-info {
    display: grid;
    gap: 7px;
    padding: 14px;
    margin-bottom: 22px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 12px;
}

.delete-order-info span {
    color: var(--muted);
    font-size: 11px;
}

.delete-order-info strong {
    color: var(--primary-dark);
    font-size: 13px;
    overflow-wrap: anywhere;
}

.delete-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.delete-modal-actions form {
    margin: 0;
}

.modal-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 38px;
    padding: 9px 13px;
    border: 1px solid transparent;
    border-radius: 9px;
    font-family: inherit;
    font-size: 12px;
    font-weight: 800;
    cursor: pointer;
}

.modal-btn-cancel {
    color: var(--primary-dark);
    background: var(--primary-soft);
    border-color: var(--border);
}

.modal-btn-delete {
    color: #fff;
    background: var(--danger);
    border-color: var(--danger);
}

.modal-btn-delete:hover {
    background: var(--danger);
}

.modal-btn svg {
    width: 15px;
    height: 15px;
}

@media (max-width: 480px) {
    .delete-modal-card {
        padding: 22px;
    }

    .delete-modal-actions {
        flex-direction: column-reverse;
    }

    .delete-modal-actions form,
    .delete-modal-actions .modal-btn {
        width: 100%;
    }
}
</style>
<script>
    function toggleEdit(panelId, forceClose = false) {
        const panel = document.getElementById(panelId);
        if (!panel) return;

        const willOpen = forceClose ? false : !panel.classList.contains('open');
        panel.classList.toggle('open', willOpen);

        const editButton = document.querySelector('[aria-controls="' + panelId + '"]');
        if (editButton) editButton.setAttribute('aria-expanded', String(willOpen));

        if (willOpen) {
            panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
    
function openPaymentDeleteModal(url, paymentName) {
    const modal = document.getElementById('paymentDeleteModal');
    const form = document.getElementById('deletePaymentForm');

    form.action = url;
    document.getElementById('deletePaymentName').textContent = paymentName;

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    modal.querySelector('.modal-btn-cancel').focus();
}

function closePaymentDeleteModal() {
    const modal = document.getElementById('paymentDeleteModal');

    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function (event) {
    const modal = document.getElementById('paymentDeleteModal');

    if (event.key === 'Escape' && modal?.classList.contains('is-open')) {
        closePaymentDeleteModal();
    }
});

</script>

@endsection