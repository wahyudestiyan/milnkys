<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            // Informasi customer dan order
            $table->string('customer_name');
            $table->string('order_number')->unique();
            $table->text('website_url')->nullable();

            // Referensi jenis purchase dan payment
            $table->foreignId('purchase_type_id')
                ->constrained('purchase_types')
                ->restrictOnDelete();

            $table->foreignId('payment_type_id')
                ->constrained('payment_types')
                ->restrictOnDelete();

            // Bukti purchase
            $table->string('purchase_proof_path')->nullable();

            // Deadline pembayaran, tanggal dan jam
            $table->dateTime('payment_deadline')->nullable();

            // Fee warehouse dalam Yen Jepang
            $table->decimal('warehouse_fee_jpy', 15, 2)->default(0);

            // Pengguna yang mencatat purchase
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('customer_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
