@extends('layouts.app')

@section('title', 'Daftar Arrived')
@section('page-title', 'Barang Tiba')
@section('page-subtitle', 'Daftar barang yang sudah tiba di warehouse Jepang.')

@section('content')

<div class="section-heading">
    <div>
        <h2>Daftar Barang Arrived</h2>
        <p class="page-subtitle">
            Barang dikelompokkan berdasarkan box pengiriman.
        </p>
    </div>

    <a href="{{ route('arrived-items.create') }}"
       class="btn btn-primary">
        + Input Arrived
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="panel">
    <div class="panel-header">
        <h2>Barang yang Sudah Dicatat</h2>
        <p>Foto, nomor resi, purchase, dan batch pengiriman.</p>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nomor Resi</th>
                    <th>Nomor Order</th>
                    <th>Customer</th>
                    <th>Box Pengiriman</th>
                    <th>Waktu Input</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($arrivedItems as $item)
                    <tr>
                        <td>
                            @if ($item->photo_path)
                                <a
                                    href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->photo_path) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->photo_path) }}"
                                        alt="Foto barang"
                                        loading="lazy"
                                        style="width:55px;height:55px;object-fit:cover;border-radius:8px;"
                                    >
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <strong>{{ $item->tracking_number }}</strong>
                        </td>

                        <td>
                            {{ $item->purchaseOrder?->order_number ?? '-' }}
                        </td>

                        <td>
                            {{ $item->purchaseOrder?->customer_name ?? '-' }}
                        </td>

                        <td>
                            {{ $item->shipmentBatch?->name ?? '-' }}
                        </td>

                        <td>
                            {{ $item->arrived_at?->format('d/m/Y H:i') ?? '-' }}
                        </td>
                       
                            <td>
                                <div class="purchase-actions">
                                    <a href="{{ route('arrived-items.show', $item) }}"
                                    class="btn-action btn-view">
                                        Lihat
                                    </a>

                                    
                                        @if ($item->shipmentBatch?->is_closed)

                                            {{-- Edit: batch sudah ditutup --}}
                                            <button
                                                type="button"
                                                class="btn-action btn-edit"
                                                onclick="openLockedArrivedModal(
                                                    'Edit',
                                                    @js($item->shipmentBatch?->name ?? 'Batch pengiriman')
                                                )">
                                                Edit
                                            </button>

                                            {{-- Hapus: batch sudah ditutup --}}
                                            <button
                                                type="button"
                                                class="btn-action btn-delete"
                                                onclick="openLockedArrivedModal(
                                                    'Hapus',
                                                    @js($item->shipmentBatch?->name ?? 'Batch pengiriman')
                                                )">
                                                Hapus
                                            </button>

                                        @else

                                            {{-- Edit: batch masih terbuka --}}
                                            <a href="{{ route('arrived-items.edit', $item) }}"
                                            class="btn-action btn-edit">
                                                Edit
                                            </a>

                                            {{-- Hapus: batch masih terbuka --}}
                                            <button
                                                type="button"
                                                class="btn-action btn-delete"
                                                onclick="openArrivedDeleteModal(
                                                    '{{ route('arrived-items.destroy', $item) }}',
                                                    @js($item->tracking_number),
                                                    @js($item->purchaseOrder?->order_number ?? '-'),
                                                    @js($item->purchaseOrder?->customer_name ?? '-')
                                                )">
                                                Hapus
                                            </button>

                                        @endif

                                </div>
                            </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">📦</div>
                                <strong>Belum ada barang arrived</strong>
                                <p>Barang yang diinput akan muncul di sini.</p>
                                <div style="margin-top:16px;">
                                    <a href="{{ route('arrived-items.create') }}"
                                       class="btn btn-primary">
                                        + Input Arrived Pertama
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($arrivedItems->hasPages())
        <div class="pagination-wrap">
            {{ $arrivedItems->links() }}
        </div>
    @endif
</div>

{{-- Modal konfirmasi hapus barang arrived --}}
<div id="arrivedDeleteModal" class="delete-modal" aria-hidden="true">
    <div class="delete-modal-backdrop"
         onclick="closeArrivedDeleteModal()"></div>

    <div class="delete-modal-card"
         role="dialog"
         aria-modal="true"
         aria-labelledby="arrivedDeleteModalTitle">

        <div class="delete-modal-icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M12 8v5m0 3h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

        <h3 id="arrivedDeleteModalTitle">Hapus Barang Tiba?</h3>

        <p class="delete-modal-description">
            Data barang ini akan dihapus. Pastikan nomor resi yang dipilih sudah benar.
        </p>

        <div class="delete-order-info">
            <span>Nomor Resi</span>
            <strong id="deleteArrivedTracking">-</strong>

            <span>Nomor Order</span>
            <strong id="deleteArrivedOrder">-</strong>

            <span>Customer</span>
            <strong id="deleteArrivedCustomer">-</strong>
        </div>

        <div class="delete-modal-actions">
            <button type="button"
                    class="modal-btn modal-btn-cancel"
                    onclick="closeArrivedDeleteModal()">
                Batal
            </button>

            <form id="deleteArrivedForm" method="POST">
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

<div id="lockedArrivedModal"
     class="delete-modal"
     aria-hidden="true">

    <div class="delete-modal-backdrop"
         onclick="closeLockedArrivedModal()"></div>

    <div class="delete-modal-card"
         role="dialog"
         aria-modal="true"
         aria-labelledby="lockedArrivedTitle">

        <div class="delete-modal-icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M12 8v5m0 3h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

        <h3 id="lockedArrivedTitle">Data Tidak Dapat Diubah</h3>

        <p class="delete-modal-description"
           id="lockedArrivedMessage">
            Barang sudah masuk ke batch pengiriman yang ditutup.
        </p>

        <div class="delete-order-info">
            <span>Batch Pengiriman</span>
            <strong id="lockedArrivedBatch">-</strong>
        </div>

        <div class="delete-modal-actions">
            <button type="button"
                    class="modal-btn modal-btn-cancel"
                    onclick="closeLockedArrivedModal()">
                Mengerti
            </button>
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
    border: 1px solid #e7ebe4;
    border-radius: 16px;
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
    background: #fff0ee;
    border-radius: 13px;
}

.delete-modal-icon svg {
    width: 25px;
    height: 25px;
}

.delete-modal-card h3 {
    margin: 0 0 8px;
    color: #253126;
    font-size: 21px;
    font-weight: 700;
}

.delete-modal-description {
    margin: 0 0 20px;
    color: #748075;
    font-size: 13px;
    line-height: 1.7;
}

.delete-order-info {
    display: grid;
    grid-template-columns: 1fr;
    gap: 5px;
    padding: 14px;
    margin-bottom: 22px;
    background: #f7f9f5;
    border: 1px solid #e8ede4;
    border-radius: 10px;
}

.delete-order-info span {
    color: #788174;
    font-size: 11px;
}

.delete-order-info strong {
    margin-bottom: 9px;
    color: #344331;
    font-size: 13px;
    overflow-wrap: anywhere;
}

.delete-order-info strong:last-child {
    margin-bottom: 0;
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
    min-height: 36px;
    padding: 8px 13px;
    border: 1px solid transparent;
    border-radius: 7px;
    font-family: inherit;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s ease;
}

.modal-btn-cancel {
    color: #40556f;
    background: #eff4fa;
    border-color: #d8e3f0;
}

.modal-btn-cancel:hover {
    background: #e2ebf5;
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
    const arrivedDeleteModal = document.getElementById('arrivedDeleteModal');
    const deleteArrivedForm = document.getElementById('deleteArrivedForm');

    function openArrivedDeleteModal(url, trackingNumber, orderNumber, customerName) {
        deleteArrivedForm.action = url;

        document.getElementById('deleteArrivedTracking').textContent = trackingNumber;
        document.getElementById('deleteArrivedOrder').textContent = orderNumber;
        document.getElementById('deleteArrivedCustomer').textContent = customerName;

        arrivedDeleteModal.classList.add('is-open');
        arrivedDeleteModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        arrivedDeleteModal.querySelector('.modal-btn-cancel').focus();
    }

    function closeArrivedDeleteModal() {
        arrivedDeleteModal.classList.remove('is-open');
        arrivedDeleteModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (event) {
        if (
            event.key === 'Escape' &&
            arrivedDeleteModal.classList.contains('is-open')
        ) {
            closeArrivedDeleteModal();
        }
    });
    
function openLockedArrivedModal(action, batchName) {
    const modal = document.getElementById('lockedArrivedModal');

    document.getElementById('lockedArrivedTitle').textContent =
        action === 'Edit'
            ? 'Barang Tidak Dapat Diedit'
            : 'Barang Tidak Dapat Dihapus';

    document.getElementById('lockedArrivedMessage').textContent =
        action === 'Edit'
            ? 'Barang sudah masuk ke batch pengiriman yang ditutup. Data tidak dapat diedit.'
            : 'Barang sudah masuk ke batch pengiriman yang ditutup. Data tidak dapat dihapus.';

    document.getElementById('lockedArrivedBatch').textContent =
        batchName;

    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    modal.querySelector('.modal-btn-cancel').focus();
}

function closeLockedArrivedModal() {
    const modal = document.getElementById('lockedArrivedModal');

    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function (event) {
    const modal = document.getElementById('lockedArrivedModal');

    if (event.key === 'Escape' && modal?.classList.contains('is-open')) {
        closeLockedArrivedModal();
    }
});

</script>

@endsection
