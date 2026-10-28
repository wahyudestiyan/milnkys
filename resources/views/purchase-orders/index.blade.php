@extends('layouts.app')

@section('title', 'Daftar Purchase')
@section('page-title', 'Daftar Purchase')
@section('page-subtitle', 'Kelola pesanan customer yang tercatat di warehouse Jepang.')

@section('content')

<div class="section-heading">
    <div>
        <h2>Riwayat Pembelian</h2>
        <p class="page-subtitle">Daftar order yang sudah dicatat oleh admin.</p>
    </div>

    <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary">
        + Input Purchase
    </a>
</div>

<div class="panel">
    <div class="panel-header">
        <h2>Semua Pesanan</h2>
        <p>Biaya warehouse ditampilkan dalam Yen Jepang.</p>
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nomor Order</th>
                    <th>Customer</th>
                    <th>Jenis Purchase</th>
                    <th>Payment</th>
                    <th>Biaya Warehouse</th>
                    <th>Deadline</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchaseOrders as $purchase)
                    <tr>
                        <td>
                            <span class="order-number">
                                {{ $purchase->order_number }}
                            </span>
                        </td>
                        <td>{{ $purchase->customer_name }}</td>
                        <td>
                            {{ $purchase->purchaseType?->name ?? '-' }}
                        </td>
                        <td>
                            {{ $purchase->paymentType?->name ?? '-' }}
                        </td>
                        <td>
                            <strong>
                                ¥{{ number_format((float) $purchase->warehouse_fee_jpy, 2, '.', ',') }}
                            </strong>
                        </td>
                        <td>
                            @if ($purchase->payment_deadline)
                                {{ $purchase->payment_deadline->format('d/m/Y H:i') }}
                            @else
                                <span class="section-caption">Tidak ditentukan</span>
                            @endif
                        </td>
                        
                            
                            <td>
                                <div class="purchase-actions">
                                    <a href="{{ route('purchase-orders.show', $purchase) }}"
                                    class="btn-action btn-view">
                                        Lihat
                                    </a>

                                    <a href="{{ route('purchase-orders.edit', $purchase) }}"
                                    class="btn-action btn-edit">
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        class="btn-action btn-delete"
                                        onclick="openDeleteModal(
                                            '{{ route('purchase-orders.destroy', $purchase) }}',
                                            @js($purchase->order_number),
                                            @js($purchase->customer_name)
                                        )">
                                        Hapus
                                    </button>
                                </div>
                            </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">🛍️</div>
                                <strong>Belum ada purchase</strong>
                                <p>Mulai dengan mencatat pesanan customer yang baru dibeli.</p>
                                <div style="margin-top:16px;">
                                    <a href="{{ route('purchase-orders.create') }}"
                                       class="btn btn-primary">
                                        + Input Purchase Pertama
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($purchaseOrders->hasPages())
        <div class="pagination-wrap">
            {{ $purchaseOrders->links() }}
        </div>
    @endif
</div>

{{-- Modal konfirmasi hapus purchase --}}
<div id="deleteModal" class="delete-modal" aria-hidden="true">
    <div class="delete-modal-backdrop" onclick="closeDeleteModal()"></div>

    <div class="delete-modal-card"
         role="dialog"
         aria-modal="true"
         aria-labelledby="deleteModalTitle">

        <div class="delete-modal-icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M12 8v5m0 3h.01M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

        <h3 id="deleteModalTitle">Hapus Purchase?</h3>

        <p class="delete-modal-description">
            Apakah Anda yakin ingin menghapus purchase ini?
            Tindakan ini tidak dapat dibatalkan.
        </p>

        <div class="delete-order-info">
            <span>Nomor Order</span>
            <strong id="deleteOrderNumber">-</strong>

            <span>Customer</span>
            <strong id="deleteCustomerName">-</strong>
        </div>

        <div class="delete-modal-actions">
            <button type="button"
                    class="modal-btn modal-btn-cancel"
                    onclick="closeDeleteModal()">
                Batal
            </button>

            <form id="deletePurchaseForm" method="POST">
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
    
/* Modal konfirmasi hapus */
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
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deletePurchaseForm');

    function openDeleteModal(url, orderNumber, customerName) {
        deleteForm.action = url;

        document.getElementById('deleteOrderNumber').textContent = orderNumber;
        document.getElementById('deleteCustomerName').textContent = customerName;

        deleteModal.classList.add('is-open');
        deleteModal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        deleteModal.querySelector('.modal-btn-cancel').focus();
    }

    function closeDeleteModal() {
        deleteModal.classList.remove('is-open');
        deleteModal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && deleteModal.classList.contains('is-open')) {
            closeDeleteModal();
        }
    });
</script>
@endsection