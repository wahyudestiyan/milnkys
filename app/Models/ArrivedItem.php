<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArrivedItem extends Model
{
    protected $fillable = [
        'tracking_number',
        'purchase_order_id',
        'shipment_batch_id',
        'photo_path',
        'arrived_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'arrived_at' => 'datetime',
        ];
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function shipmentBatch(): BelongsTo
    {
        return $this->belongsTo(ShipmentBatch::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
