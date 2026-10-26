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
        Schema::create('arrived_items', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();

            $table->foreignId('purchase_order_id')
                ->nullable()
                ->constrained('purchase_orders')
                ->nullOnDelete();

            $table->foreignId('shipment_batch_id')
                ->constrained('shipment_batches')
                ->restrictOnDelete();

            $table->string('photo_path')->nullable();
            $table->timestamp('arrived_at')->useCurrent();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('purchase_order_id');
            $table->index('shipment_batch_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arrived_items');
    }
};
