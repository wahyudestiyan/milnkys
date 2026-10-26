<?php

namespace App\Console\Commands;

use App\Mail\PaymentDeadlineReminderMail;
use App\Models\PaymentDeadlineReminder;
use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendPaymentDeadlineReminders extends Command
{
    protected $signature = 'payment-deadline:remind';

    protected $description =
        'Mengirim pengingat email deadline pembayaran kepada admin dan karyawan aktif';

    public function handle(): int
    {
        $today = Carbon::today();

        // Ambil admin dan karyawan aktif dengan alamat email valid.
        $recipients = User::query()
            ->where('is_active', true)
            ->whereIn('role', ['admin', 'staff'])
            ->whereNotNull('email')
            ->whereRaw("TRIM(email) <> ''")
            ->get(['id', 'name', 'email'])
            ->filter(fn (User $user) => filter_var(
                trim($user->email),
                FILTER_VALIDATE_EMAIL
            ))
            ->unique(fn (User $user) => strtolower(trim($user->email)))
            ->values();

        if ($recipients->isEmpty()) {
            $this->warn('Tidak ada admin/karyawan aktif dengan email valid.');
            Log::warning('Payment deadline reminder: penerima email kosong.');

            return self::SUCCESS;
        }

        $orders = PurchaseOrder::query()
            ->whereNotNull('payment_deadline')
            ->where(function ($query) use ($today) {
                $query
                    ->whereDate(
                        'payment_deadline',
                        $today->copy()->addDays(3)->toDateString()
                    )
                    ->orWhereDate(
                        'payment_deadline',
                        $today->copy()->addDay()->toDateString()
                    )
                    ->orWhere('payment_deadline', '<', now());
            })
            ->get();

        foreach ($orders as $order) {
            $deadline = Carbon::parse($order->payment_deadline);

            if ($deadline->lt(now())) {
                $type = 'overdue';
            } elseif ($deadline->isSameDay($today->copy()->addDays(3))) {
                $type = 'three_days';
            } elseif ($deadline->isSameDay($today->copy()->addDay())) {
                $type = 'one_day';
            } else {
                continue;
            }

            $this->sendReminder($order, $type, $recipients);
        }

        $this->info('Pemeriksaan deadline pembayaran selesai.');

        return self::SUCCESS;
    }

    private function sendReminder(
        PurchaseOrder $order,
        string $type,
        $recipients
    ): void {
        // Sudah pernah berhasil dicatat? Jangan kirim lagi.
        $alreadySent = PaymentDeadlineReminder::query()
            ->where('purchase_order_id', $order->id)
            ->where('reminder_type', $type)
            ->whereNotNull('sent_at')
            ->exists();

        if ($alreadySent) {
            return;
        }

        try {
            // Mengirim satu email per penerima untuk menjaga privasi alamat email.
            foreach ($recipients as $recipient) {
                Mail::to(trim($recipient->email))
                    ->send(new PaymentDeadlineReminderMail($order, $type));
            }

            // Catat setelah semua pengiriman berhasil.
            DB::transaction(function () use ($order, $type) {
                PaymentDeadlineReminder::query()->updateOrCreate(
                    [
                        'purchase_order_id' => $order->id,
                        'reminder_type' => $type,
                    ],
                    [
                        'sent_at' => now(),
                    ]
                );
            });

            $this->line(
                "Pengingat {$type} terkirim untuk pesanan {$order->order_number}."
            );
        } catch (Throwable $e) {
            Log::error('Gagal mengirim pengingat deadline pembayaran.', [
                'purchase_order_id' => $order->id,
                'order_number' => $order->order_number,
                'reminder_type' => $type,
                'error' => $e->getMessage(),
            ]);

            $this->error(
                "Gagal mengirim pengingat {$type} untuk {$order->order_number}."
            );
        }
    }
}