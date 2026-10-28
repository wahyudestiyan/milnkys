
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="{{ $themeColors['background'] ?? '#F5F8FF' }}">
    <title>Akses Ditolak - Milnkys</title>

    <style>
        :root {
            --primary: {{ $themeColors['primary'] ?? '#2563EB' }};
            --primary-dark: {{ $themeColors['primary_dark'] ?? '#1D4ED8' }};
            --primary-soft: {{ $themeColors['primary_soft'] ?? '#DBEAFE' }};
            --bg: {{ $themeColors['background'] ?? '#F5F8FF' }};
            --surface: {{ $themeColors['surface'] ?? '#FFFFFF' }};
            --text: {{ $themeColors['text'] ?? '#1E293B' }};
            --muted: {{ $themeColors['muted'] ?? '#64748B' }};
            --border: {{ $themeColors['border'] ?? '#E2E8F0' }};
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: var(--bg);
            color: var(--text);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
        }

        .message {
            width: 100%;
            max-width: 380px;
            padding: 30px 24px;
            text-align: center;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 6px 24px #2633260D;
        }

        .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 68px;
            height: 68px;
            margin: 0 auto 14px;
            border-radius: 50%;
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-size: 32px;
        }

        h2 {
            margin: 0 0 10px;
            color: var(--text);
            font-size: 21px;
        }

        p {
            margin: 0 0 22px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        a {
            display: block;
            padding: 13px 16px;
            border-radius: 12px;
            background: var(--primary);
            color: #FFFFFF;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: background .2s ease;
        }

        a:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>
    <div class="message">
        <div class="icon">🔒</div>
        <h2>Akses Ditolak</h2>
        <p>Halaman ini hanya dapat diakses oleh Admin.</p>
        <a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
    </div>
</body>
</html>
