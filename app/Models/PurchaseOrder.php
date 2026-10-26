<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'customer_name',
        'order_number',
        'website_url',
        'purchase_type_id',
        'payment_type_id',
        'purchase_proof_path',
        'payment_deadline',
        'warehouse_fee_jpy',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'payment_deadline' => 'datetime',
            'warehouse_fee_jpy' => 'decimal:2',
        ];
    }

    public function purchaseType(): BelongsTo
    {
        return $this->belongsTo(PurchaseType::class);
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

