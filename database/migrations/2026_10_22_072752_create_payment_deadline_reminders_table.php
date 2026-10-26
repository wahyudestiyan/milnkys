<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_deadline_reminders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('purchase_order_id')
                ->constrained('purchase_orders')
                ->cascadeOnDelete();

            $table->string('reminder_type', 20);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->unique(
                ['purchase_order_id', 'reminder_type'],
                'payment_deadline_reminder_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_deadline_reminders');
    }
};