<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengingat Deadline Pembayaran</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <h2>Pengingat Deadline Pembayaran</h2>

    @if ($reminderType === 'three_days')
        <p>
            Ini adalah pengingat bahwa deadline pembayaran tinggal
            <strong>3 hari lagi</strong>.
        </p>
    @elseif ($reminderType === 'one_day')
        <p>
            Ini adalah pengingat bahwa deadline pembayaran adalah
            <strong>besok</strong>.
        </p>
    @elseif ($reminderType === 'overdue')
        <p style="color: #b91c1c;">
            <strong>Perhatian:</strong> deadline pembayaran pesanan ini
            sudah terlewati.
        </p>
    @endif

    
<table cellpadding="8" cellspacing="0" border="1"
    style="border-collapse: collapse; border-color: #ddd;">
    <tr>
        <td><strong>Nomor Pesanan</strong></td>
        <td>{{ $purchaseOrder->order_number }}</td>
    </tr>
    <tr>
        <td><strong>Nama Customer</strong></td>
        <td>{{ $purchaseOrder->customer_name }}</td>
    </tr>
    <tr>
        <td><strong>Deadline</strong></td>
        <td>
            {{ $purchaseOrder->payment_deadline?->format('d-m-Y H:i') ?? '-' }}
        </td>
    </tr>
    <tr>
        <td><strong>Website</strong></td>
        <td>
            @if ($purchaseOrder->website_url)
                <a href="{{ $purchaseOrder->website_url }}">
                    {{ $purchaseOrder->website_url }}
                </a>
            @else
                -
            @endif
        </td>
    </tr>

    @if ($purchaseOrder->payment_url)
        <tr>
            <td><strong>Link Payment</strong></td>
            <td>
                <a href="{{ $purchaseOrder->payment_url }}"
                   target="_blank"
                   rel="noopener noreferrer">
                    Klik di sini untuk melakukan pembayaran
                </a>
            </td>
        </tr>
    @endif
</table>


    <p>Dimohon untuk dapat menindaklanjuti payment tersebut.</p>

    <p>
        Email ini dikirim otomatis oleh Milnkys Warehouse Manager.
    </p>
</body>
</html>