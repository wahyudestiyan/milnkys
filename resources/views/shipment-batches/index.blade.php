@extends('layouts.app')

@section('content')

<style>

    /* Panel dan judul */

.panel {

    background: var(--surface);

    border: 1px solid var(--border);

    border-radius: 12px;

}



.panel h2 {

    color: var(--text);

}



/* Header tabel */

table thead th {

    background: var(--primary-soft);

    color: var(--primary-dark);

    border-color: var(--border);

}



/* Isi tabel */

table tbody td {

    color: var(--text);

    border-color: var(--border);

}



table tbody tr:hover {

    background: var(--bg);

}



/* Tombol utama dan Detail */

.btn-primary,

.btn-secondary {

    background: var(--primary);

    color: var(--surface);

    border-color: var(--primary);

}



.btn-primary:hover,

.btn-secondary:hover {

    background: var(--primary-dark);

    border-color: var(--primary-dark);

    color: var(--surface);

}



/* Tombol Edit */

.btn-edit {

    background: var(--primary-soft);

    color: var(--primary-dark);

    border-color: color-mix(in srgb, var(--primary) 35%, var(--surface));

}



.btn-edit:hover {

    background: color-mix(in srgb, var(--primary) 35%, var(--surface));

    color: var(--primary-dark);

}



/* Status */

.status.open {

    background: var(--primary-soft);

    color: var(--primary-dark);

}



.status.closed {

    background: var(--bg);

    color: var(--muted);

}



/* Tombol berbahaya tetap merah */

.btn-danger,

.btn-delete {

    background: var(--danger);

    color: var(--surface);

    border-color: var(--danger);

}



.btn-danger:hover,

.btn-delete:hover {

    background: color-mix(in srgb, var(--danger) 85%, black);

    border-color: color-mix(in srgb, var(--danger) 85%, black);

}



/* Pagination */

.pagination a,

.pagination button {

    color: var(--primary);

}



.pagination .active,

.pagination [aria-current="page"] {

    background: var(--primary);

    color: var(--surface);

    border-color: var(--primary);

}

.btn-secondary:hover {

    background: var(--primary-dark) !important;

    border-color: var(--primary-dark) !important;

    color: var(--surface) !important;

}



.btn-edit:hover {

    background: color-mix(in srgb, var(--primary) 35%, var(--surface)) !important;

    border-color: color-mix(in srgb, var(--primary) 35%, var(--surface)) !important;

    color: var(--primary-dark) !important;

}

</style>

<div class="container">

    <div class="page-header">

        <div>

            <h1>Pengiriman Indonesia</h1>

            <p>Kelola box pengiriman dari Jepang ke Indonesia.</p>

        </div>

    </div>



    @if (session('success'))

        <div class="alert alert-success">{{ session('success') }}</div>

    @endif



    @if (session('error'))

        <div class="alert alert-danger">{{ session('error') }}</div>

    @endif



    @if ($errors->any())

        <div class="alert alert-danger">

            @foreach ($errors->all() as $error)

                <div>{{ $error }}</div>

            @endforeach

        </div>

    @endif





<div class="panel">

    <h2>Tambah Box Pengiriman</h2>



    <form action="{{ route('shipment-batches.store') }}" method="POST">

        @csrf



        <label for="name">Nama Box / Batch</label>

        <input

            type="text"

            id="name"

            name="name"

            value="{{ old('name') }}"

            placeholder="Contoh: Pengiriman Indonesia - Batch 1"

            maxlength="255"

            required

        >



        <div class="period-fields">

            <div>

                <label for="period_start">Periode Mulai</label>

                <input

                    type="date"

                    id="period_start"

                    name="period_start"

                    value="{{ old('period_start') }}"

                    required

                    onchange="document.getElementById('period_end').min = this.value"

                >

            </div>



            <div>

                <label for="period_end">Periode Selesai</label>

                <input

                    type="date"

                    id="period_end"

                    name="period_end"

                    value="{{ old('period_end') }}"

                    min="{{ old('period_start') }}"

                    required

                >

            </div>

        </div>



        <button type="submit" class="btn" style="background-color: var(--primary); color: white; border-color: var(--primary);">

    + Buat Box

</button>

    </form>

</div>





   <div class="panel">

    <h2>Daftar Box Pengiriman</h2>



    @if ($batches->isEmpty())

        <div class="empty-state">

            <p>Belum ada box pengiriman.</p>

            <p>Buat box pertama melalui formulir di atas.</p>

        </div>

    @else

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>Nama Box</th>

                        <th>Periode Mulai</th>

                        <th>Periode Selesai</th>

                        <th>Total Resi</th>

                        <th>Status</th>

                        <th>Tanggal Dibuat</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($batches as $batch)

                        <tr>

                            <td>

                                <strong>{{ $batch->name }}</strong>

                            </td>

                            <td>{{ $batch->period_start?->format('d/m/Y') ?? '-' }}</td>

                            <td>{{ $batch->period_end?->format('d/m/Y') ?? '-' }}</td>

                            <td>{{ $batch->arrived_items_count }}</td>

                            <td>

                                @if ($batch->is_closed)

                                    <span class="status closed">Ditutup</span>

                                @else

                                    <span class="status open">Terbuka</span>

                                @endif

                            </td>

                            <td>{{ $batch->created_at?->format('d/m/Y H:i') }}</td>

                            <td>

                                <div class="actions">

                                        <a

                                            href="{{ route('shipment-batches.show', $batch) }}"

                                            class="btn btn-secondary"

                                            style="background: var(--primary); color: var(--surface); border: 1px solid var(--primary);"

                                        >

                                            Detail

                                        </a>



                                        <a

                                            href="{{ route('shipment-batches.edit', $batch) }}"

                                            class="btn btn-edit"

                                            style="background: var(--primary-soft); color: var(--primary-dark); border: 1px solid color-mix(in srgb, var(--primary) 35%, var(--surface));"

                                        >

                                            Edit

                                        </a>



                                        @unless ($batch->is_closed)

                                            <button

                                                type="button"

                                                class="btn btn-danger"

                                                onclick="openCloseBatchModal('{{ route('shipment-batches.close', $batch) }}')"

                                            >

                                                Tutup Batch

                                            </button>

                                        @endunless



                                        @if ($batch->arrived_items_count == 0)

                                            <button

                                                type="button"

                                                class="btn btn-delete"

                                                onclick="openBatchDeleteModal(

                                                    @js(route('shipment-batches.destroy', $batch)),

                                                    @js($batch->name)

                                                )"

                                            >

                                                Hapus

                                            </button>

                                        @endif

                                    </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>



        <div class="pagination">

            {{ $batches->links() }}

        </div>

    @endif

</div>

</div>



<div id="closeBatchModal" class="batch-modal" aria-hidden="true">

    <div

        class="batch-modal-backdrop"

        onclick="closeCloseBatchModal()"

    ></div>



    <div

        class="batch-modal-card"

        role="dialog"

        aria-modal="true"

        aria-labelledby="closeBatchTitle"

    >

        <div class="batch-modal-icon">

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



        <h3 id="closeBatchTitle">Tutup Batch Pengiriman?</h3>



        <p class="batch-modal-description">

            Apakah kamu yakin ingin menutup batch ini?

            Pastikan seluruh proses pengiriman sudah selesai.

        </p>



        <div class="batch-modal-actions">

            <button

                type="button"

                class="batch-modal-btn batch-modal-cancel"

                onclick="closeCloseBatchModal()"

            >

                Batal

            </button>



            <form id="closeBatchForm" method="POST">

                @csrf

                @method('PATCH')



                <button

                    type="submit"

                    class="batch-modal-btn batch-modal-confirm"

                >

                    Ya, Tutup Batch

                </button>

            </form>

        </div>

    </div>

</div>





{{-- Modal Konfirmasi Hapus Box --}}

<div id="batchDeleteModal" class="batch-modal" aria-hidden="true">

    <div

        class="batch-modal-backdrop"

        onclick="closeBatchDeleteModal()"

    ></div>



    <div

        class="batch-modal-card"

        role="dialog"

        aria-modal="true"

        aria-labelledby="batchDeleteTitle"

    >

        <div class="batch-modal-icon">

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



        <h3 id="batchDeleteTitle">Hapus Box Pengiriman?</h3>



        <p class="batch-modal-description">

            Apakah Anda yakin ingin menghapus box ini?

            Tindakan ini tidak dapat dibatalkan.

        </p>



        <div class="batch-modal-info">

            <span>Nama Box Pengiriman</span>

            <strong id="batchDeleteName">-</strong>

        </div>



        <div class="batch-modal-actions">

            <button

                type="button"

                class="batch-modal-btn batch-modal-cancel"

                onclick="closeBatchDeleteModal()"

            >

                Batal

            </button>



            <form id="batchDeleteForm" method="POST">

                @csrf

                @method('DELETE')



                <button

                    type="submit"

                    class="batch-modal-btn batch-modal-confirm"

                >

                    Ya, Hapus

                </button>

            </form>

        </div>

    </div>

</div>



<style>

    .container { max-width: 1200px; margin: 0 auto; padding: 24px; color: var(--text); }

    .page-header { margin-bottom: 24px; }

    .page-header h1 { margin: 0 0 6px; font-size: 26px; font-weight: 700; }

    .page-header p { margin: 0; color: var(--muted); }

    .panel { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 22px; margin-bottom: 22px; }

    .panel h2 { font-size: 18px; margin: 0 0 18px; }

    label { display: block; font-weight: 600; margin-bottom: 8px; }

    input[type="text"] { width: 100%; max-width: 500px; padding: 11px 12px; border: 1px solid var(--border); border-radius: 8px; margin-bottom: 14px; box-sizing: border-box; }

    button, .btn { display: inline-block; padding: 9px 13px; border: 0; border-radius: 8px; text-decoration: none; cursor: pointer; font-size: 13px; font-weight: 600; white-space: nowrap; }

    .btn-primary { background: var(--primary); color: var(--surface); }

    .btn-secondary { background: var(--primary-soft); color: var(--primary-dark); }

    .btn-danger { background: var(--danger-soft); color: var(--danger); }

    .alert { padding: 12px 15px; border-radius: 8px; margin-bottom: 18px; }

    .alert-success { background: var(--success-soft); color: var(--success); }

    .alert-danger { background: var(--danger-soft); color: var(--danger); }

    .table-wrapper { width: 100%; overflow-x: auto; }

    table {

    width: 100%;

    border-collapse: collapse;

    min-width: 900px;

}

    th, td { text-align: left; padding: 13px 12px; border-bottom: 1px solid var(--border); vertical-align: middle; }

    th { background: var(--primary-soft); color: var(--muted); font-size: 12px; text-transform: uppercase; }

    .status { display: inline-block; padding: 5px 9px; border-radius: 20px; font-size: 12px; font-weight: 600; }

    .status.open { background: var(--success-soft); color: var(--success); }

    .status.closed { background: var(--bg); color: var(--muted); }

    .actions { display: flex; flex-wrap: wrap; gap: 7px; align-items: center; }

    .actions form { margin: 0; }

    .empty-state { padding: 28px 12px; text-align: center; color: var(--muted); background: var(--bg); border-radius: 10px; }

    .empty-state p { margin: 5px; }

    .pagination { margin-top: 18px; }

    @media (max-width: 600px) {

        .container { padding: 14px; }

        .panel { padding: 15px; }

        .page-header h1 { font-size: 22px; }

    }



input[type="text"],

input[type="date"] {

    width: 100%;

    max-width: 500px;

    padding: 11px 12px;

    border: 1px solid var(--border);

    border-radius: 8px;

    margin-bottom: 14px;

    box-sizing: border-box;

}



.period-fields {

    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 16px;

    max-width: 700px;

}



@media (max-width: 600px) {

    .period-fields {

        grid-template-columns: 1fr;

        gap: 0;

    }

}

.btn-edit {

    background: var(--primary-soft);

    color: var(--primary-dark);

}



.btn-delete {

    background: var(--danger-soft);

    color: var(--danger);

}



.actions form {

    margin: 0;

}

/* Modal konfirmasi hapus box pengiriman */

.batch-modal {

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



.batch-modal.is-open {

    opacity: 1;

    visibility: visible;

}



.batch-modal-backdrop {

    position: absolute;

    inset: 0;

    background: rgba(20, 29, 22, .48);

    backdrop-filter: blur(3px);

}



.batch-modal-card {

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



.batch-modal.is-open .batch-modal-card {

    transform: translateY(0) scale(1);

}



.batch-modal-icon {

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



.batch-modal-icon svg {

    width: 25px;

    height: 25px;

}



.batch-modal-card h3 {

    margin: 0 0 8px;

    color: var(--text);

    font-size: 21px;

    font-weight: 800;

}



.batch-modal-description {

    margin: 0 0 20px;

    color: var(--muted);

    font-size: 13px;

    line-height: 1.7;

}



.batch-modal-info {

    display: grid;

    gap: 7px;

    padding: 14px;

    margin-bottom: 22px;

    background: var(--bg);

    border: 1px solid var(--border);

    border-radius: 12px;

}



.batch-modal-info span {

    color: var(--muted);

    font-size: 11px;

}



.batch-modal-info strong {

    color: var(--text);

    font-size: 13px;

    overflow-wrap: anywhere;

}



.batch-modal-actions {

    display: flex;

    justify-content: flex-end;

    gap: 8px;

}



.batch-modal-actions form {

    margin: 0;

}



.batch-modal-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 6px;

    min-height: 38px;

    padding: 9px 14px;

    border: 1px solid transparent;

    border-radius: 9px;

    font-family: inherit;

    font-size: 12px;

    font-weight: 700;

    cursor: pointer;

    transition: background .2s ease;

}



.batch-modal-cancel {

    color: var(--primary-dark);

    background: var(--primary-soft);

    border-color: var(--border);

}



.batch-modal-cancel:hover {

    background: var(--primary-soft);

}



.batch-modal-confirm {

    color: var(--surface);

    background: var(--danger);

    border-color: var(--danger);

}



.batch-modal-confirm:hover {

    background: color-mix(in srgb, var(--danger) 85%, black);

}



.batch-modal-btn svg {

    width: 15px;

    height: 15px;

}



@media (max-width: 480px) {

    .batch-modal-card {

        padding: 22px;

    }



    .batch-modal-actions {

        flex-direction: column-reverse;

    }



    .batch-modal-actions form,

    .batch-modal-actions .batch-modal-btn {

        width: 100%;

    }

}

</style>

<script>

    function openBatchDeleteModal(url, batchName) {

        const modal = document.getElementById('batchDeleteModal');

        const form = document.getElementById('batchDeleteForm');



        form.action = url;



        document.getElementById('batchDeleteName').textContent =

            batchName || 'Box pengiriman';



        modal.classList.add('is-open');

        modal.setAttribute('aria-hidden', 'false');

        document.body.style.overflow = 'hidden';



        modal.querySelector('.batch-modal-cancel').focus();

    }



    function closeBatchDeleteModal() {

        const modal = document.getElementById('batchDeleteModal');



        modal.classList.remove('is-open');

        modal.setAttribute('aria-hidden', 'true');

        document.body.style.overflow = '';

    }



    document.addEventListener('keydown', function (event) {

        const modal = document.getElementById('batchDeleteModal');



        if (

            event.key === 'Escape' &&

            modal?.classList.contains('is-open')

        ) {

            closeBatchDeleteModal();

        }

    });





function openCloseBatchModal(url) {

    const modal = document.getElementById('closeBatchModal');

    const form = document.getElementById('closeBatchForm');



    form.action = url;



    modal.classList.add('is-open');

    modal.setAttribute('aria-hidden', 'false');

    document.body.style.overflow = 'hidden';



    modal.querySelector('.batch-modal-cancel').focus();

}



function closeCloseBatchModal() {

    const modal = document.getElementById('closeBatchModal');



    modal.classList.remove('is-open');

    modal.setAttribute('aria-hidden', 'true');

    document.body.style.overflow = '';

}



document.addEventListener('keydown', function (event) {

    const modal = document.getElementById('closeBatchModal');



    if (

        event.key === 'Escape' &&

        modal?.classList.contains('is-open')

    ) {

        closeCloseBatchModal();

    }

});





function openBatchDeleteModal(url, batchName) {

    const modal = document.getElementById('batchDeleteModal');

    const form = document.getElementById('batchDeleteForm');



    form.action = url;



    document.getElementById('batchDeleteName').textContent =

        batchName || 'Box pengiriman';



    modal.classList.add('is-open');

    modal.setAttribute('aria-hidden', 'false');

    document.body.style.overflow = 'hidden';



    modal.querySelector('.batch-modal-cancel').focus();

}



function closeBatchDeleteModal() {

    const modal = document.getElementById('batchDeleteModal');



    modal.classList.remove('is-open');

    modal.setAttribute('aria-hidden', 'true');

    document.body.style.overflow = '';

}



</script>

@endsection
