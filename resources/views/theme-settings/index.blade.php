@extends('layouts.app')

@section('content')
<div class="theme-page">

    {{-- HEADER --}}
    <div class="theme-header">
        <div class="theme-heading">
            <div class="theme-icon">🎨</div>
            <div>
                <h1>Pengaturan Tema</h1>
                <p>Sesuaikan identitas visual dan warna aplikasi Milnkys.</p>
            </div>
        </div>

        <span class="theme-status">
            <span class="status-dot"></span>
            Kustomisasi Tampilan
        </span>
    </div>

    @if ($errors->any())
        <div class="theme-alert theme-alert-error">
            <div>
                <strong>Ada pengaturan yang perlu diperbaiki</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('theme-settings.update') }}"
          method="POST"
          id="themeSettingsForm">
        @csrf
        @method('PUT')

        @php
            $colorGroups = [
                [
                    'title' => 'Identitas Merek',
                    'description' => 'Warna utama untuk tombol, tautan, dan elemen interaktif.',
                    'items' => [
                        'primary' => [
                            'label' => 'Warna Utama',
                            'description' => 'Tombol utama dan elemen aktif.',
                            'default' => '#2563EB',
                        ],
                        'primary_dark' => [
                            'label' => 'Warna Utama Gelap',
                            'description' => 'Hover tombol dan aksen yang lebih tegas.',
                            'default' => '#1D4ED8',
                        ],
                        'primary_soft' => [
                            'label' => 'Warna Utama Lembut',
                            'description' => 'Latar badge dan sorotan lembut.',
                            'default' => '#DBEAFE',
                        ],
                    ],
                ],
                [
                    'title' => 'Latar Belakang & Panel',
                    'description' => 'Atur latar halaman dan permukaan kartu.',
                    'items' => [
                        'background' => [
                            'label' => 'Latar Halaman',
                            'description' => 'Background utama halaman aplikasi.',
                            'default' => '#F5F8FF',
                        ],
                        'surface' => [
                            'label' => 'Latar Kartu',
                            'description' => 'Kartu, panel, dan area formulir.',
                            'default' => '#FFFFFF',
                        ],
                        'border' => [
                            'label' => 'Garis Pembatas',
                            'description' => 'Border kartu, input, dan pemisah.',
                            'default' => '#E2E8F0',
                        ],
                    ],
                ],
                [
                    'title' => 'Tipografi',
                    'description' => 'Jaga agar tulisan tetap nyaman dibaca.',
                    'items' => [
                        'text' => [
                            'label' => 'Teks Utama',
                            'description' => 'Judul, isi, dan informasi penting.',
                            'default' => '#1E293B',
                        ],
                        'muted' => [
                            'label' => 'Teks Sekunder',
                            'description' => 'Deskripsi, keterangan, dan label tambahan.',
                            'default' => '#64748B',
                        ],
                    ],
                ],
                [
                    'title' => 'Status & Peringatan',
                    'description' => 'Warna untuk tindakan atau informasi penting.',
                    'items' => [
                        'danger' => [
                            'label' => 'Warna Bahaya',
                            'description' => 'Hapus, gagal, dan peringatan penting.',
                            'default' => '#DC2626',
                        ],
                    ],
                ],
                
                

            ];
        @endphp

        <div class="theme-layout">

            {{-- PANEL PENGATURAN --}}
            <div class="theme-main">

                @foreach ($colorGroups as $groupIndex => $group)
                    <section class="theme-card">
                        <div class="theme-card-heading">
                            <div class="theme-section-number">
                                {{ str_pad($groupIndex + 1, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div>
                                <h2>{{ $group['title'] }}</h2>
                                <p>{{ $group['description'] }}</p>
                            </div>
                        </div>

                        <div class="theme-color-list">
                            @foreach ($group['items'] as $key => $item)
                                @php
                                    $currentColor = old(
                                        $key,
                                        $themeColors[$key] ?? $item['default']
                                    );
                                @endphp

                                <div class="theme-color-row">
                                    <div class="theme-color-info">
                                        <label for="{{ $key }}">
                                            {{ $item['label'] }}
                                        </label>
                                        <p>{{ $item['description'] }}</p>
                                    </div>

                                    <div class="theme-color-control">
                                        <label class="theme-swatch"
                                               for="{{ $key }}"
                                               title="Pilih warna {{ $item['label'] }}">
                                            <input
                                                type="color"
                                                id="{{ $key }}"
                                                name="{{ $key }}"
                                                value="{{ $currentColor }}"
                                                data-theme-color="{{ $key }}"
                                                required
                                            >
                                        </label>

                                        <div class="theme-hex-wrap">
                                            <span class="hex-prefix">HEX</span>
                                            <input
                                                type="text"
                                                value="{{ $currentColor }}"
                                                maxlength="7"
                                                pattern="#[0-9A-Fa-f]{6}"
                                                data-hex-target="{{ $key }}"
                                                aria-label="Kode HEX {{ $item['label'] }}"
                                                autocomplete="off"
                                                spellcheck="false"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach

                <div class="theme-actions">
                    <button type="button"
                            class="theme-btn theme-btn-reset"
                            id="resetThemeButton">
                        <span>↺</span>
                        Kembalikan Default
                    </button>

                    <button type="submit"
                            class="theme-btn theme-btn-save"
                            id="saveThemeButton">
                        <span>✓</span>
                        Simpan Pengaturan
                    </button>
                </div>
            </div>

            {{-- PANEL PRATINJAU --}}
            <aside class="theme-preview-column">
                <div class="theme-preview-card">
                    <div class="preview-header">
                        <div>
                            <span class="preview-eyebrow">LIVE PREVIEW</span>
                            <h2>Pratinjau Tema</h2>
                        </div>
                        <span class="preview-live-dot"></span>
                    </div>

                    <p class="preview-description">
                        Contoh tampilan berdasarkan palet warna yang Anda pilih.
                    </p>

                    <div class="preview-canvas" id="themePreview">
                        <div class="preview-mini-nav">
                            <div class="preview-brand-mark">A</div>
                            <div class="preview-brand-name">
                                <strong>Milnkys</strong>
                                <span>Admin Panel</span>
                            </div>
                            <div class="preview-avatar">A</div>
                        </div>

                        <div class="preview-content">
                            <span class="preview-greeting">DASHBOARD</span>
                            <h3>Selamat datang!</h3>
                            <p class="preview-muted">
                                Kelola toko Anda dengan mudah.
                            </p>

                            <div class="preview-stat">
                                <div class="preview-stat-top">
                                    <span>Total Penjualan</span>
                                    <span class="preview-stat-icon">↗</span>
                                </div>
                                <strong>Rp 2.450.000</strong>
                                <span class="preview-stat-caption">
                                    Contoh tampilan informasi
                                </span>
                            </div>

                            <div class="preview-button-row">
                                <button type="button" class="preview-primary-button">
                                    + Tambah Data
                                </button>
                                <button type="button" class="preview-secondary-button">
                                    Lihat
                                </button>
                            </div>

                            <div class="preview-message">
                                <span class="preview-success-mark">✓</span>
                                <div>
                                    <strong>Berhasil disimpan</strong>
                                    <p>Data telah diperbarui.</p>
                                </div>
                            </div>

                            <div class="preview-danger">
                                <span>!</span>
                                Contoh pesan peringatan
                            </div>
                        </div>
                    </div>

                    <div class="preview-legend">
                        <div>
                            <span class="legend-dot legend-primary"></span>
                            <span>Utama</span>
                        </div>
                        <div>
                            <span class="legend-dot legend-surface"></span>
                            <span>Panel</span>
                        </div>
                        <div>
                            <span class="legend-dot legend-text"></span>
                            <span>Teks</span>
                        </div>
                        <div>
                            <span class="legend-dot legend-danger"></span>
                            <span>Peringatan</span>
                        </div>
                    </div>
                </div>

                <div class="theme-tip">
                    <span class="theme-tip-icon">💡</span>
                    <div>
                        <strong>Tips memilih warna</strong>
                        <p>
                            Gunakan warna teks yang kontras dengan latar belakang
                            agar informasi tetap mudah dibaca.
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </form>
</div>

{{-- POPUP KONFIRMASI RESET TEMA --}}
<div class="theme-modal-overlay"
     id="resetThemeModal"
     aria-hidden="true"
     role="dialog"
     aria-modal="true"
     aria-labelledby="resetThemeTitle">

    <div class="theme-modal">
        <div class="theme-modal-icon">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M12 8v5m0 3h.01M10.3 3.9 2.8 17.2a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"
                      stroke="currentColor"
                      stroke-width="1.8"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
        </div>

        <h3 id="resetThemeTitle">Kembalikan Warna Default?</h3>

        <p>
            Seluruh pilihan warna pada formulir akan dikembalikan ke
            pengaturan awal. Perubahan ini belum disimpan sampai Anda
            menekan tombol Simpan Pengaturan.
        </p>

        <div class="theme-modal-actions">
            <button type="button"
                    class="theme-modal-btn theme-modal-cancel"
                    id="cancelResetTheme">
                Batal
            </button>

            <button type="button"
                    class="theme-modal-btn theme-modal-confirm"
                    id="confirmResetTheme">
                Ya, Kembalikan
            </button>
        </div>
    </div>
</div>

<style>
.theme-page {
    --tp-primary: {{ $themeColors['primary'] ?? '#2563EB' }};
    --tp-primary-dark: {{ $themeColors['primary_dark'] ?? '#1D4ED8' }};
    --tp-primary-soft: {{ $themeColors['primary_soft'] ?? '#DBEAFE' }};
    --tp-background: {{ $themeColors['background'] ?? '#F5F8FF' }};
    --tp-surface: {{ $themeColors['surface'] ?? '#FFFFFF' }};
    --tp-text: {{ $themeColors['text'] ?? '#1E293B' }};
    --tp-muted: {{ $themeColors['muted'] ?? '#64748B' }};
    --tp-border: {{ $themeColors['border'] ?? '#E2E8F0' }};
    --tp-danger: {{ $themeColors['danger'] ?? '#DC2626' }};
    --tp-success: {{ $themeColors['success'] ?? '#16A34A' }};
    --tp-success-soft: {{ $themeColors['success_soft'] ?? '#DCFCE7' }};
    --tp-warning: {{ $themeColors['warning'] ?? '#D97706' }};
    --tp-danger-soft: {{ $themeColors['danger_soft'] ?? '#FEE2E2' }};

    color: var(--tp-text);
    padding-bottom: 28px;
}

.theme-page,
.theme-page * {
    box-sizing: border-box;
}

.theme-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 26px;
}

.theme-heading {
    display: flex;
    align-items: center;
    gap: 15px;
}

.theme-icon {
    display: grid;
    place-items: center;
    width: 54px;
    height: 54px;
    border-radius: 17px;
    background: var(--tp-primary-soft);
    font-size: 25px;
}

.theme-heading h1 {
    margin: 0;
    color: var(--tp-text);
    font-size: clamp(23px, 3vw, 29px);
    line-height: 1.3;
    font-weight: 800;
    letter-spacing: -0.7px;
}

.theme-heading p {
    margin: 5px 0 0;
    color: var(--tp-muted);
    font-size: 13px;
    line-height: 1.6;
}

.theme-status {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 13px;
    border: 1px solid var(--tp-border);
    border-radius: 999px;
    color: var(--tp-muted);
    background: var(--tp-surface);
    font-size: 11px;
    font-weight: 700;
}

.status-dot,
.preview-live-dot {
    width: 8px;
    height: 8px;
    flex-shrink: 0;
    border-radius: 50%;
    background: #22C55E;
}

.theme-alert {
    display: flex;
    gap: 12px;
    padding: 15px 17px;
    margin-bottom: 20px;
    border-radius: 15px;
    font-size: 13px;
}

.theme-alert strong {
    display: block;
    margin-bottom: 3px;
}

.theme-alert p {
    margin: 0;
}

.theme-alert ul {
    margin: 5px 0 0;
    padding-left: 18px;
}

.theme-alert-success {
    color: #166534;
    background: #F0FDF4;
    border: 1px solid #BBF7D0;
}

.theme-alert-error {
    color: #991B1B;
    background: #FEF2F2;
    border: 1px solid #FECACA;
}

.alert-icon {
    font-size: 20px;
    font-weight: 800;
}

.theme-layout {
    display: grid;
    grid-template-columns: minmax(0, 1.55fr) minmax(270px, 0.85fr);
    gap: 22px;
    align-items: start;
}

.theme-main {
    display: flex;
    flex-direction: column;
    gap: 18px;
    min-width: 0;
}

.theme-card,
.theme-preview-card {
    background: var(--tp-surface);
    border: 1px solid var(--tp-border);
    border-radius: 20px;
    box-shadow: 0 5px 18px rgba(15, 23, 42, 0.035);
}

.theme-card {
    padding: 23px;
}

.theme-card-heading {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    padding-bottom: 19px;
    border-bottom: 1px solid var(--tp-border);
}

.theme-section-number {
    display: grid;
    place-items: center;
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: var(--tp-primary-soft);
    color: var(--tp-primary-dark);
    font-size: 12px;
    font-weight: 800;
}

.theme-card-heading h2 {
    margin: 1px 0 5px;
    font-size: 15px;
    font-weight: 800;
    color: var(--tp-text);
}

.theme-card-heading p {
    margin: 0;
    color: var(--tp-muted);
    font-size: 12px;
    line-height: 1.65;
}

.theme-color-list {
    display: flex;
    flex-direction: column;
}

.theme-color-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 18px 0;
    border-bottom: 1px solid var(--tp-border);
}

.theme-color-row:last-child {
    border-bottom: 0;
    padding-bottom: 0;
}

.theme-color-info {
    min-width: 0;
}

.theme-color-info label {
    display: block;
    margin-bottom: 5px;
    color: var(--tp-text);
    font-size: 13px;
    font-weight: 750;
}

.theme-color-info p {
    margin: 0;
    color: var(--tp-muted);
    font-size: 11px;
    line-height: 1.6;
}

.theme-color-control {
    display: flex;
    align-items: center;
    gap: 9px;
    flex-shrink: 0;
}

.theme-swatch {
    display: block;
    width: 45px;
    height: 43px;
    padding: 4px;
    border: 1px solid var(--tp-border);
    border-radius: 12px;
    background: var(--tp-surface);
    cursor: pointer;
    transition: border-color 0.2s, transform 0.2s;
}

.theme-swatch:hover {
    border-color: var(--tp-primary);
    transform: translateY(-1px);
}

.theme-swatch input[type="color"] {
    display: block;
    width: 100%;
    height: 100%;
    padding: 0;
    border: 0;
    border-radius: 7px;
    background: transparent;
    cursor: pointer;
}

.theme-swatch input[type="color"]::-webkit-color-swatch-wrapper {
    padding: 0;
}

.theme-swatch input[type="color"]::-webkit-color-swatch {
    border: 0;
    border-radius: 7px;
}

.theme-hex-wrap {
    display: flex;
    align-items: center;
    gap: 6px;
    width: 126px;
    height: 43px;
    padding: 0 9px;
    border: 1px solid var(--tp-border);
    border-radius: 12px;
    background: var(--tp-surface);
}

.hex-prefix {
    color: var(--tp-muted);
    font-size: 9px;
    font-weight: 800;
}

.theme-hex-wrap input {
    width: 100%;
    min-width: 0;
    padding: 0;
    border: 0;
    outline: 0;
    color: var(--tp-text);
    background: transparent;
    font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
}

.theme-hex-wrap:focus-within {
    border-color: var(--tp-primary);
    box-shadow: 0 0 0 3px var(--tp-primary-soft);
}

.theme-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding-top: 4px;
}

.theme-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    gap: 9px;
    min-height: 46px;
    padding: 0 18px;
    border: 1px solid transparent;
    border-radius: 13px;
    font-size: 12px;
    font-weight: 750;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
}

.theme-btn:hover {
    transform: translateY(-1px);
}

.theme-btn:focus-visible {
    outline: 3px solid var(--tp-primary-soft);
    outline-offset: 3px;
}

.theme-btn-reset {
    color: var(--tp-text);
    background: var(--tp-surface);
    border-color: var(--tp-border);
}

.theme-btn-reset:hover {
    background: var(--tp-background);
}

.theme-btn-save {
    color: #FFFFFF;
    background: var(--tp-primary);
    box-shadow: 0 5px 12px rgba(37, 99, 235, 0.18);
}

.theme-btn-save:hover {
    background: var(--tp-primary-dark);
    box-shadow: 0 7px 16px rgba(37, 99, 235, 0.24);
}

.theme-btn-save:disabled {
    opacity: 0.65;
    cursor: wait;
    transform: none;
}

.theme-preview-column {
    position: sticky;
    top: 20px;
    min-width: 0;
}

.theme-preview-card {
    overflow: hidden;
}

.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    padding: 21px 21px 0;
}

.preview-eyebrow {
    display: block;
    margin-bottom: 6px;
    color: var(--tp-primary);
    font-size: 9px;
    font-weight: 850;
    letter-spacing: 1.5px;
}

.preview-header h2 {
    margin: 0;
    color: var(--tp-text);
    font-size: 17px;
    font-weight: 800;
}

.preview-description {
    margin: 8px 21px 17px;
    color: var(--tp-muted);
    font-size: 11px;
    line-height: 1.7;
}

.preview-live-dot {
    box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.12);
}

.preview-canvas {
    --pv-primary: var(--tp-primary);
    --pv-primary-dark: var(--tp-primary-dark);
    --pv-primary-soft: var(--tp-primary-soft);
    --pv-background: var(--tp-background);
    --pv-surface: var(--tp-surface);
    --pv-text: var(--tp-text);
    --pv-muted: var(--tp-muted);
    --pv-border: var(--tp-border);
    --pv-danger: var(--tp-danger);
    --pv-success: var(--tp-success);
    --pv-success-soft: var(--tp-success-soft);
    --pv-warning: var(--tp-warning);
    --pv-danger-soft: var(--tp-danger-soft);

    margin: 0 14px;
    overflow: hidden;
    border: 1px solid var(--pv-border);
    border-radius: 15px;
    color: var(--pv-text);
    background: var(--pv-background);
}

.preview-mini-nav {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 12px;
    border-bottom: 1px solid var(--pv-border);
    background: var(--pv-surface);
}

.preview-brand-mark {
    display: grid;
    place-items: center;
    width: 30px;
    height: 30px;
    border-radius: 9px;
    background: var(--pv-primary);
    color: #FFFFFF;
    font-size: 13px;
    font-weight: 900;
}

.preview-brand-name {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 0;
    flex: 1;
}

.preview-brand-name strong {
    color: var(--pv-text);
    font-size: 11px;
}

.preview-brand-name span {
    color: var(--pv-muted);
    font-size: 9px;
}

.preview-avatar {
    display: grid;
    place-items: center;
    width: 27px;
    height: 27px;
    border-radius: 50%;
    background: var(--pv-primary-soft);
    color: var(--pv-primary-dark);
    font-size: 10px;
    font-weight: 800;
}

.preview-content {
    padding: 15px 12px;
}

.preview-greeting {
    color: var(--pv-primary);
    font-size: 8px;
    font-weight: 850;
    letter-spacing: 1.2px;
}

.preview-content h3 {
    margin: 5px 0 3px;
    color: var(--pv-text);
    font-size: 16px;
    font-weight: 850;
    letter-spacing: -0.4px;
}

.preview-muted {
    margin: 0 0 13px;
    color: var(--pv-muted);
    font-size: 10px;
}

.preview-stat {
    padding: 13px;
    border: 1px solid var(--pv-border);
    border-radius: 12px;
    background: var(--pv-surface);
}

.preview-stat-top {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    color: var(--pv-muted);
    font-size: 9px;
}

.preview-stat-icon {
    display: grid;
    place-items: center;
    width: 23px;
    height: 23px;
    border-radius: 7px;
    color: var(--pv-primary-dark);
    background: var(--pv-primary-soft);
    font-size: 12px;
}

.preview-stat > strong {
    display: block;
    margin-top: 7px;
    color: var(--pv-text);
    font-size: 19px;
    font-weight: 850;
    letter-spacing: -0.6px;
}

.preview-stat-caption {
    display: block;
    margin-top: 4px;
    color: var(--pv-muted);
    font-size: 9px;
}

.preview-button-row {
    display: flex;
    gap: 8px;
    margin-top: 12px;
}

.preview-primary-button,
.preview-secondary-button {
    min-height: 34px;
    padding: 0 10px;
    border-radius: 9px;
    font-size: 9px;
    font-weight: 750;
}

.preview-primary-button {
    border: 1px solid var(--pv-primary);
    background: var(--pv-primary);
    color: #FFFFFF;
}

.preview-secondary-button {
    border: 1px solid var(--pv-border);
    background: var(--pv-surface);
    color: var(--pv-text);
}

.preview-message {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-top: 12px;
    padding: 10px;
    border: 1px solid var(--pv-border);
    border-radius: 10px;
    background: var(--pv-surface);
}

.preview-success-mark {
    display: grid;
    place-items: center;
    width: 24px;
    height: 24px;
    flex-shrink: 0;
    border-radius: 8px;
    color: #15803D;
    background: #DCFCE7;
    font-size: 12px;
    font-weight: 900;
}

.preview-message strong {
    display: block;
    color: var(--pv-text);
    font-size: 10px;
}

.preview-message p {
    margin: 3px 0 0;
    color: var(--pv-muted);
    font-size: 9px;
}

.preview-danger {
    display: flex;
    align-items: center;
    gap: 7px;
    margin-top: 9px;
    padding: 9px;
    border-radius: 9px;
    color: var(--pv-danger);
    background: var(--pv-surface);
    border: 1px solid var(--pv-border);
    font-size: 9px;
    font-weight: 650;
}

.preview-danger span {
    display: grid;
    place-items: center;
    width: 17px;
    height: 17px;
    border-radius: 50%;
    background: var(--pv-danger);
    color: #FFFFFF;
    font-size: 10px;
    font-weight: 900;
}

.preview-legend {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 16px 18px 18px;
}

.preview-legend > div {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--tp-muted);
    font-size: 10px;
}

.legend-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 4px;
    border: 1px solid var(--tp-border);
}

.legend-primary {
    background: var(--tp-primary);
}

.legend-surface {
    background: var(--tp-surface);
}

.legend-text {
    background: var(--tp-text);
}

.legend-danger {
    background: var(--tp-danger);
}

.theme-tip {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    margin-top: 16px;
    padding: 15px;
    border: 1px solid var(--tp-border);
    border-radius: 15px;
    background: var(--tp-surface);
}

.theme-tip-icon {
    font-size: 19px;
}

.theme-tip strong {
    display: block;
    margin-bottom: 5px;
    color: var(--tp-text);
    font-size: 12px;
}

.theme-tip p {
    margin: 0;
    color: var(--tp-muted);
    font-size: 11px;
    line-height: 1.7;
}

@media (max-width: 1000px) {
    .theme-layout {
        grid-template-columns: minmax(0, 1fr);
    }

    .theme-preview-column {
        position: static;
    }
}

@media (max-width: 600px) {
    .theme-header {
        align-items: flex-start;
    }

    .theme-status {
        margin-left: 0;
    }

    .theme-card {
        padding: 17px;
        border-radius: 16px;
    }

    .theme-color-row {
        align-items: flex-start;
        flex-direction: column;
        gap: 12px;
    }

    .theme-color-control {
        width: 100%;
    }

    .theme-hex-wrap {
        width: 145px;
    }

    .theme-actions {
        flex-direction: column-reverse;
        align-items: stretch;
    }

    .theme-btn {
        width: 100%;
    }
}

/* Popup konfirmasi reset tema */

.theme-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;

    /* Latar belakang di luar popup */
    background: rgba(15, 23, 42, 0.65);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);

    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.22s ease, visibility 0.22s ease;
}


.theme-modal-overlay.is-visible {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}


.theme-modal {
    width: 100%;
    max-width: 410px;
    padding: 30px;

    background-color: #FFFFFF !important;
    background-image: none !important;
    opacity: 1;

    border: 1px solid #E2E8F0;
    border-radius: 24px;
    color: #1E293B;
    text-align: center;
    box-shadow: 0 24px 80px rgba(15, 23, 42, 0.2);

    transform: translateY(12px) scale(0.97);
    transition: transform 0.22s ease;
}


.theme-modal-overlay.is-visible .theme-modal {
    transform: translateY(0) scale(1);
}

.theme-modal-icon {
    display: grid;
    place-items: center;
    width: 62px;
    height: 62px;
    margin: 0 auto 18px;
    border-radius: 20px;
    color: var(--tp-primary-dark);
    background: var(--tp-primary-soft);
}

.theme-modal-icon svg {
    width: 30px;
    height: 30px;
}

.theme-modal h3 {
    margin: 0 0 10px;
    color: var(--tp-text);
    font-size: 21px;
    font-weight: 800;
    letter-spacing: -0.4px;
}

.theme-modal > p {
    margin: 0;
    color: var(--tp-muted);
    font-size: 13px;
    line-height: 1.8;
}

.theme-modal-actions {
    display: flex;
    gap: 10px;
    margin-top: 26px;
}

.theme-modal-btn {
    flex: 1;
    min-height: 46px;
    padding: 10px 14px;
    border: 1px solid transparent;
    border-radius: 13px;
    font-size: 12px;
    font-weight: 750;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
}

.theme-modal-btn:hover {
    transform: translateY(-1px);
}

.theme-modal-btn:focus-visible {
    outline: 3px solid var(--tp-primary-soft);
    outline-offset: 3px;
}

.theme-modal-cancel {
    color: var(--tp-text);
    background: var(--tp-surface);
    border-color: var(--tp-border);
}

.theme-modal-cancel:hover {
    background: var(--tp-background);
}

.theme-modal-confirm {
    color: #FFFFFF;
    background: var(--tp-primary);
}

.theme-modal-confirm:hover {
    background: var(--tp-primary-dark);
}

@media (max-width: 480px) {
    .theme-modal {
        padding: 24px 20px;
        border-radius: 20px;
    }

    .theme-modal-actions {
        flex-direction: column-reverse;
    }

    .theme-modal-btn {
        width: 100%;
    }
}

/* Perbaikan posisi dan visibilitas tombol popup */
#resetThemeModal .theme-modal {
    display: flex;
    flex-direction: column;
    max-height: 90vh;
    overflow-y: auto;
}

#resetThemeModal .theme-modal-actions {
    display: flex !important;
    flex-direction: row !important;
    align-items: stretch;
    justify-content: center;
    gap: 12px;
    width: 100%;
    margin-top: 26px;
}

#resetThemeModal .theme-modal-actions .theme-modal-btn {
    display: inline-flex !important;
    flex: 1 1 0;
    align-items: center;
    justify-content: center;
    min-width: 0;
    min-height: 46px;
    visibility: visible !important;
    opacity: 1 !important;
    position: relative;
    color: var(--tp-text);
    background: #FFFFFF;
    border: 1px solid var(--tp-border);
    border-radius: 12px;
}

#resetThemeModal .theme-modal-actions .theme-modal-confirm {
    color: #FFFFFF !important;
    background: var(--tp-primary) !important;
    border-color: var(--tp-primary) !important;
}

#resetThemeModal .theme-modal-actions .theme-modal-confirm:hover {
    background: var(--tp-primary-dark) !important;
}

#resetThemeModal .theme-modal-actions .theme-modal-cancel:hover {
    background: var(--tp-background);
}

@media (max-width: 480px) {
    #resetThemeModal .theme-modal-actions {
        flex-direction: column-reverse !important;
    }

    #resetThemeModal .theme-modal-actions .theme-modal-btn {
        width: 100%;
        flex: auto;
    }
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const page = document.querySelector('.theme-page');
    const form = document.getElementById('themeSettingsForm');

    if (!page || !form) return;

    const defaults = {
        primary: '#2563EB',
        primary_dark: '#1D4ED8',
        primary_soft: '#DBEAFE',
        background: '#F5F8FF',
        surface: '#FFFFFF',
        text: '#1E293B',
        muted: '#64748B',
        border: '#E2E8F0',
        danger: '#DC2626',
        success: '#16A34A',
        success_soft: '#DCFCE7',
        warning: '#D97706',
        danger_soft: '#FEE2E2'
    };

    const colorInputs = form.querySelectorAll('[data-theme-color]');
    const hexInputs = form.querySelectorAll('[data-hex-target]');

    function normalizeHex(value) {
        return /^#[0-9A-Fa-f]{6}$/.test(value) ? value.toUpperCase() : null;
    }

    function updatePreview(key, value) {
        const variableMap = {
            primary: '--tp-primary',
            primary_dark: '--tp-primary-dark',
            primary_soft: '--tp-primary-soft',
            background: '--tp-background',
            surface: '--tp-surface',
            text: '--tp-text',
            muted: '--tp-muted',
            border: '--tp-border',
            danger: '--tp-danger',
            success: '--tp-success',
            success_soft: '--tp-success-soft',
            warning: '--tp-warning',
            danger_soft: '--tp-danger-soft'
        };

        const variable = variableMap[key];
        if (!variable) return;

        page.style.setProperty(variable, value);

        const input = form.querySelector('[data-theme-color="' + key + '"]');
        const hex = form.querySelector('[data-hex-target="' + key + '"]');

        if (input) input.value = value;
        if (hex) hex.value = value;

        const preview = document.getElementById('themePreview');
        if (preview) {
            const previewMap = {
                primary: '--pv-primary',
                primary_dark: '--pv-primary-dark',
                primary_soft: '--pv-primary-soft',
                background: '--pv-background',
                surface: '--pv-surface',
                text: '--pv-text',
                muted: '--pv-muted',
                border: '--pv-border',
                danger: '--pv-danger',
                success: '--pv-success',
                success_soft: '--pv-success-soft',
                warning: '--pv-warning',
                danger_soft: '--pv-danger-soft'
            };

            preview.style.setProperty(previewMap[key], value);
        }
    }

    colorInputs.forEach(function (input) {
        input.addEventListener('input', function () {
            updatePreview(input.dataset.themeColor, input.value.toUpperCase());
        });
    });

    hexInputs.forEach(function (input) {
        input.addEventListener('input', function () {
            const key = input.dataset.hexTarget;
            const color = normalizeHex(input.value);

            if (color) {
                updatePreview(key, color);
            }
        });

        input.addEventListener('blur', function () {
            const key = input.dataset.hexTarget;
            const color = normalizeHex(input.value);

            if (color) {
                updatePreview(key, color);
            } else {
                const picker = form.querySelector(
                    '[data-theme-color="' + key + '"]'
                );

                if (picker) input.value = picker.value.toUpperCase();
            }
        });
    });

  
const resetButton = document.getElementById('resetThemeButton');
const resetModal = document.getElementById('resetThemeModal');
const cancelReset = document.getElementById('cancelResetTheme');
const confirmReset = document.getElementById('confirmResetTheme');

function openResetModal() {
    resetModal.classList.add('is-visible');
    resetModal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    cancelReset.focus();
}

function closeResetModal() {
    resetModal.classList.remove('is-visible');
    resetModal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    resetButton.focus();
}

resetButton.addEventListener('click', openResetModal);

cancelReset.addEventListener('click', closeResetModal);

confirmReset.addEventListener('click', function () {
    Object.entries(defaults).forEach(function ([key, value]) {
        updatePreview(key, value);
    });

    closeResetModal();
});

resetModal.addEventListener('click', function (event) {
    if (event.target === resetModal) {
        closeResetModal();
    }
});

document.addEventListener('keydown', function (event) {
    if (
        event.key === 'Escape' &&
        resetModal.classList.contains('is-visible')
    ) {
        closeResetModal();
    }
});


    form.addEventListener('submit', function (event) {
        let invalid = false;

        hexInputs.forEach(function (input) {
            const key = input.dataset.hexTarget;
            const color = normalizeHex(input.value);

            if (!color) {
                invalid = true;
                input.setCustomValidity('Masukkan kode HEX, misalnya #2563EB.');
                input.reportValidity();
                return;
            }

            input.setCustomValidity('');
            updatePreview(key, color);
        });

        if (invalid) {
            event.preventDefault();
        }
    });
});
</script>
@endsection
