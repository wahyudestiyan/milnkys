<?php

namespace App\Mail;

use App\Models\PurchaseOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentDeadlineReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PurchaseOrder $purchaseOrder,
        public string $reminderType,
    ) {}

    public function envelope(): Envelope
    {
        $subject = match ($this->reminderType) {
            'three_days' => 'Pengingat Deadline Pembayaran - 3 Hari Lagi',
            'one_day' => 'Pengingat Deadline Pembayaran - Besok',
            'overdue' => 'Peringatan Deadline Pembayaran Terlewati',
            default => 'Pengingat Deadline Pembayaran',
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-deadline-reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}