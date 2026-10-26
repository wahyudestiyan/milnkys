<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f7f1">
    <title>Jenis Purchase - TokoAlma</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --primary: #718765;
            --primary-dark: #465b3d;
            --primary-soft: #e8eee2;
            --bg: #f5f7f1;
            --text: #263326;
            --muted: #899184;
            --border: #e8ece3;
            --danger: #b42318;
            --danger-soft: #fce8e6;
        }

        body {
            margin: 0;
            padding: 24px 16px 40px;
            background: var(--bg);
            color: var(--text);
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .container { max-width: 900px; margin: auto; }

        .back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 24px;
            color: #526b48;
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

        h1 { margin: 9px 0; font-size: 27px; letter-spacing: -.6px; }
        .muted { color: var(--muted); font-size: 13px; line-height: 1.7; }

        .card {
            margin-top: 20px;
            padding: 23px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: 0 6px 24px #26332606;
        }

        .card h2 { margin: 0 0 8px; font-size: 17px; }
        .card-description { margin: 0 0 16px; }

        label {
            display: block;
            margin: 17px 0 8px;
            font-size: 12px;
            font-weight: 700;
        }

        input, textarea, select {
            display: block;
            width: 100%;
            min-height: 46px;
            padding: 12px 13px;
            border: 1px solid #dfe5d9;
            border-radius: 12px;
            background: #fbfcf9;
            color: var(--text);
            font: inherit;
            font-size: 14px;
            outline: none;
        }

        textarea { min-height: 82px; resize: vertical; }
        input:focus, textarea:focus, select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px #71876520;
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
            color: white;
            font-family: inherit;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s, transform .2s;
        }

        .button:hover { background: #526b48; }
        .button:active { transform: scale(.98); }
        .button-full { width: 100%; min-height: 48px; margin-top: 17px; }
        .button-secondary { background: var(--primary-soft); color: var(--primary-dark); }
        .button-secondary:hover { background: #dce6d4; }
        .button-danger { background: var(--danger-soft); color: var(--danger); }
        .button-danger:hover { background: #f7d8d5; }

        .success, .errors {
            margin-top: 18px;
            padding: 14px 16px;
            border-radius: 13px;
            font-size: 13px;
        }

        .success { background: var(--primary-soft); color: var(--primary-dark); }
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

        .purchase-list { display: grid; gap: 12px; }

        .purchase-item {
            padding: 17px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #fff;
        }

        .purchase-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .purchase-name {
            min-width: 0;
            overflow-wrap: anywhere;
            font-size: 14px;
            font-weight: 800;
        }

        .purchase-description {
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
            background: #718765;
        }

        .status.inactive { background: #f1f1ef; color: #777; }
        .status.inactive::before { background: #999; }

        .purchase-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid #f0f2ed;
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
            border: 1px dashed #dfe5d9;
            border-radius: 15px;
            color: var(--muted);
            text-align: center;
            font-size: 13px;
            line-height: 1.7;
        }

        @media (max-width: 480px) {
            body { padding: 20px 12px 30px; }
            .card { padding: 17px; border-radius: 19px; }
            h1 { font-size: 24px; }
            .purchase-item { padding: 14px; }
            .purchase-top { gap: 8px; }
            .purchase-actions .button { flex: 1; }
            .edit-panel { padding: 13px; }
        }
    </style>
</head>

<body>
<main class="container">
    <a href="{{ route('dashboard') }}" class="back">← Kembali ke Dashboard</a>

    <header>
        <div class="eyebrow">TOKOALMA · PENGATURAN</div>
        <h1>Jenis Purchase</h1>
        <p class="muted">Kelola jenis pembelian yang digunakan dalam pencatatan pesanan.</p>
    </header>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

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
        <h2>Tambah Jenis Purchase</h2>
        <p class="muted card-description">Contoh: Personal Shopper, Titip Beli, atau Pembelian Sendiri.</p>

        <form action="{{ route('purchase-types.store') }}" method="POST">
            @csrf

            <label for="name">Nama Jenis Purchase</label>
            <input
                id="name"
                name="name"
                type="text"
                maxlength="255"
                value="{{ old('name') }}"
                placeholder="Contoh: Personal Shopper"
                required
            >

            <label for="description">Deskripsi (opsional)</label>
            <textarea
                id="description"
                name="description"
                placeholder="Keterangan jenis pembelian"
            >{{ old('description') }}</textarea>

            <button type="submit" class="button button-full">＋ Tambah Jenis Purchase</button>
        </form>
    </section>

    <section class="card">
        <div class="list-header">
            <div>
                <h2>Daftar Jenis Purchase</h2>
                <p class="muted" style="margin:6px 0 0">Jenis pembelian yang tersedia di TokoAlma.</p>
            </div>
            <span class="count">{{ $purchaseTypes->count() }}</span>
        </div>

        @if ($purchaseTypes->isEmpty())
            <div class="empty">
                Belum ada jenis purchase.<br>
                Silakan tambahkan melalui formulir di atas.
            </div>
        @else
            <div class="purchase-list">
                @foreach ($purchaseTypes as $purchaseType)
                    <article class="purchase-item">
                        <div class="purchase-top">
                            <div style="min-width:0">
                                <div class="purchase-name">{{ $purchaseType->name }}</div>
                                <div class="purchase-description">
                                    {{ $purchaseType->description ?: 'Tidak ada deskripsi' }}
                                </div>
                            </div>

                            <span class="status {{ $purchaseType->is_active ? '' : 'inactive' }}">
                                {{ $purchaseType->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>

                        <div class="purchase-actions">
                            <button
                                type="button"
                                class="button button-secondary"
                                onclick="toggleEdit('edit-{{ $purchaseType->id }}', this)"
                                aria-expanded="false"
                            >✎ Edit</button>

                            
                            <button
                                type="button"
                                class="button button-danger"
                                onclick="openPurchaseDeleteModal(
                                    '{{ route('purchase-types.destroy', $purchaseType) }}',
                                    @js($purchaseType->name)
                                )">
                                Hapus
                            </button>

                        </div>

                        <div class="edit-panel" id="edit-{{ $purchaseType->id }}">
                            <p class="edit-heading">Edit Jenis Purchase</p>
                            <p class="edit-help">Perbarui nama, deskripsi, atau status jenis purchase.</p>

                            <form
                                action="{{ route('purchase-types.update', $purchaseType) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PUT')

                                <label for="name-{{ $purchaseType->id }}">Nama</label>
                                <input
                                    id="name-{{ $purchaseType->id }}"
                                    name="name"
                                    type="text"
                                    maxlength="255"
                                    value="{{ $purchaseType->name }}"
                                    required
                                >

                                <label for="description-{{ $purchaseType->id }}">Deskripsi</label>
                                <textarea
                                    id="description-{{ $purchaseType->id }}"
                                    name="description"
                                >{{ $purchaseType->description }}</textarea>

                                <label for="active-{{ $purchaseType->id }}">Status</label>
                                <select id="active-{{ $purchaseType->id }}" name="is_active" required>
                                    <option value="1" @selected($purchaseType->is_active)>Aktif</option>
                                    <option value="0" @selected(!$purchaseType->is_active)>Nonaktif</option>
                                </select>

                                <div class="edit-actions">
                                    <button type="submit" class="button">Simpan Perubahan</button>
                                    <button
                                        type="button"
                                        class="button button-secondary"
                                        onclick="toggleEdit('edit-{{ $purchaseType->id }}', this, true)"
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

<div id="purchaseDeleteModal"
     class="delete-modal"
     aria-hidden="true">

    <div class="delete-modal-backdrop"
         onclick="closePurchaseDeleteModal()"></div>

    <div class="delete-modal-card"
         role="dialog"
         aria-modal="true"
         aria-labelledby="purchaseDeleteTitle">

        <div class="delete-modal-icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M12 8v5m0 3h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

        <h3 id="purchaseDeleteTitle">Hapus Jenis Purchase?</h3>

        <p class="delete-modal-description">
            Apakah Anda yakin ingin menghapus jenis purchase ini?
            Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="delete-order-info">
            <span>Nama Jenis Purchase</span>
            <strong id="purchaseDeleteName">-</strong>
        </div>

        <div class="delete-modal-actions">
            <button type="button"
                    class="modal-btn modal-btn-cancel"
                    onclick="closePurchaseDeleteModal()">
                Batal
            </button>

            <form id="purchaseDeleteForm" method="POST">
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
    background: rgba(20, 29, 22, .48);
    backdrop-filter: blur(3px);
}

.delete-modal-card {
    position: relative;
    width: 100%;
    max-width: 420px;
    padding: 28px;
    background: #fff;
    border: 1px solid #e8ece3;
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
    color: #b42318;
    background: #fce8e6;
    border-radius: 14px;
}

.delete-modal-icon svg {
    width: 25px;
    height: 25px;
}

.delete-modal-card h3 {
    margin: 0 0 8px;
    color: #263326;
    font-size: 21px;
    font-weight: 800;
}

.delete-modal-description {
    margin: 0 0 20px;
    color: #899184;
    font-size: 13px;
    line-height: 1.7;
}

.delete-order-info {
    display: grid;
    gap: 7px;
    padding: 14px;
    margin-bottom: 22px;
    background: #f5f7f1;
    border: 1px solid #e8ece3;
    border-radius: 12px;
}

.delete-order-info span {
    color: #899184;
    font-size: 11px;
}

.delete-order-info strong {
    color: #344331;
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
    color: #465b3d;
    background: #e8eee2;
    border-color: #dce6d4;
}

.modal-btn-delete {
    color: #fff;
    background: #b42318;
    border-color: #a31f15;
}

.modal-btn-delete:hover {
    background: #921c13;
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
    function toggleEdit(panelId, button, forceClose = false) {
        const panel = document.getElementById(panelId);
        if (!panel) return;

        const willOpen = forceClose ? false : !panel.classList.contains('open');
        panel.classList.toggle('open', willOpen);

        const editButton = panel.closest('.purchase-item').querySelector('[aria-controls="' + panelId + '"]');
        if (editButton) editButton.setAttribute('aria-expanded', String(willOpen));

        if (willOpen) {
            panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    document.querySelectorAll('.purchase-actions button[onclick]').forEach(function (button) {
        const match = button.getAttribute('onclick').match(/'([^']+)'/);
        if (match) button.setAttribute('aria-controls', match[1]);
    });
    
function openPurchaseDeleteModal(url, purchaseName) {
    const modal = document.getElementById('purchaseDeleteModal');
    const form = document.getElementById('purchaseDeleteForm');

    form.action = url;

    document.getElementById('purchaseDeleteName').textContent =
        purchaseName;

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    modal.querySelector('.modal-btn-cancel').focus();
}

function closePurchaseDeleteModal() {
    const modal = document.getElementById('purchaseDeleteModal');

    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function (event) {
    const modal = document.getElementById('purchaseDeleteModal');

    if (event.key === 'Escape' && modal?.classList.contains('is-open')) {
        closePurchaseDeleteModal();
    }
});

</script>
</body>
</html>
