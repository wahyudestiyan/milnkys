<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShipmentBatch extends Model
{
    protected $fillable = [
        'name',
        'is_closed',
        'closed_at',
        'created_by',
        'period_start',
        'period_end',
    ];

    protected function casts(): array
    {
        return [
            'is_closed' => 'boolean',
            'closed_at' => 'datetime',
            'period_start' => 'date',
            'period_end' => 'date',
        ];
    }

    public function arrivedItems(): HasMany
    {
        return $this->hasMany(ArrivedItem::class);
    }
}