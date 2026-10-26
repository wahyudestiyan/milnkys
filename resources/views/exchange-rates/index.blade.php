
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f7f1">
    <title>Pengaturan Kurs - Milnkys</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 24px 16px 40px;
            background: #f5f7f1;
            color: #263326;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .container { max-width: 760px; margin: auto; }

        .back {
            display: inline-block;
            margin-bottom: 24px;
            color: #526b48;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .heading { margin-bottom: 25px; }

        .eyebrow {
            color: #718765;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.4px;
        }

        h1 {
            margin: 9px 0;
            font-size: 27px;
            letter-spacing: -.8px;
        }

        .muted {
            color: #899184;
            font-size: 13px;
            line-height: 1.7;
        }

        .card {
            margin-bottom: 18px;
            padding: 23px;
            background: white;
            border: 1px solid #e8ece3;
            border-radius: 22px;
            box-shadow: 0 6px 24px #26332606;
        }

        .card h2 {
            margin: 0 0 8px;
            font-size: 17px;
        }

        label {
            display: block;
            margin: 22px 0 9px;
            font-size: 12px;
            font-weight: 700;
        }

        input {
            width: 100%;
            min-height: 49px;
            padding: 12px 14px;
            border: 1px solid #dfe5d9;
            border-radius: 13px;
            background: #fbfcf9;
            color: #263326;
            font: inherit;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #718765;
            box-shadow: 0 0 0 3px #71876520;
        }

        button {
            width: 100%;
            min-height: 48px;
            margin-top: 16px;
            border: 0;
            border-radius: 14px;
            background: #718765;
            color: white;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
        }

        button:hover { background: #526b48; }

        .success {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 13px;
            background: #e8eee2;
            color: #465b3d;
            font-size: 13px;
        }

        .error {
            margin-top: 7px;
            color: #b42318;
            font-size: 12px;
        }

        .rate-display {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 19px;
            padding: 16px;
            border-radius: 15px;
            background: #f5f7f1;
        }

        .rate-value {
            color: #465b3d;
            font-size: 20px;
            font-weight: 800;
        }

        .result {
            overflow-wrap: anywhere;
            margin: 18px 0 8px;
            color: #465b3d;
            font-size: clamp(27px, 7vw, 36px);
            font-weight: 800;
            letter-spacing: -1px;
        }

        @media (max-width: 480px) {
            body { padding: 20px 13px 30px; }
            .card { padding: 19px; border-radius: 19px; }
            h1 { font-size: 24px; }
        }
    </style>
</head>

<body>
<main class="container">
    <a href="{{ route('dashboard') }}" class="back">← Kembali ke Dashboard</a>

    <header class="heading">
        <div class="eyebrow">MILNKYS · PENGATURAN</div>
        <h1>Kurs Mata Uang</h1>
        <div class="muted">
            Atur kurs JPY ke IDR dan hitung estimasi konversi biaya gudang.
        </div>
    </header>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <section class="card">
        <h2>Pengaturan Kurs</h2>
        <p class="muted">
            Masukkan nilai rupiah untuk setiap 1 Yen Jepang.
            Perubahan ini akan menjadi kurs aktif yang digunakan aplikasi.
        </p>

        <form action="{{ route('exchange-rates.update') }}" method="POST">
            @csrf

            <label for="rate">Kurs JPY ke IDR</label>

            <input
                id="rate"
                name="rate"
                type="number"
                min="1"
                step="0.01"
                max="999999999999"
                value="{{ old('rate', $exchangeRate ? (string) $exchangeRate->rate : '') }}"
                placeholder="Contoh: 122000"
                required
            >

            @error('rate')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Simpan Kurs</button>
        </form>

        <div class="rate-display">
            <div>
                <div class="muted">Kurs yang sedang aktif</div>
                <div class="rate-value">
                    @if ($exchangeRate)
                        1 JPY = Rp {{ number_format((float) $exchangeRate->rate, 2, ',', '.') }}
                    @else
                        Belum diatur
                    @endif
                </div>
            </div>
            <span>🇯🇵 → 🇮🇩</span>
        </div>
    </section>

    <section class="card">
        <h2>Kalkulator Konversi</h2>
        <p class="muted">
            Masukkan jumlah JPY untuk melihat perkiraan nilai dalam rupiah.
        </p>

        <label for="amount">Jumlah dalam JPY (¥)</label>
        <input
            id="amount"
            type="number"
            min="0"
            step="any"
            placeholder="Masukkan jumlah Yen"
        >

        <div class="muted" style="margin-top: 22px">
            Estimasi dalam Rupiah
        </div>

        <div class="result" id="result">Rp 0</div>

        <div class="muted" id="calculation-note">
            @if ($exchangeRate && (float) $exchangeRate->rate > 0)
                Kurs: 1 JPY = Rp {{ number_format((float) $exchangeRate->rate, 0, ',', '.') }}
            @else
                Simpan kurs terlebih dahulu untuk mengaktifkan konversi.
            @endif
        </div>
    </section>
</main>

<script>
    const amountInput = document.getElementById('amount');
    const result = document.getElementById('result');

    const rate = Number(@json((float) ($exchangeRate?->rate ?? 0)));
 const currencyFormatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});

    function calculateConversion() {
        const amount = Number(amountInput.value);

        if (amountInput.value.trim() === '' || !Number.isFinite(amount) || amount < 0) {
            result.textContent = 'Rp 0';
            return;
        }

        if (rate <= 0) {
            result.textContent = 'Kurs belum tersedia';
            return;
        }

        result.textContent = currencyFormatter.format(amount * rate);
    }

    amountInput.addEventListener('input', calculateConversion);
</script>
</body>
</html>
