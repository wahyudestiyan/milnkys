<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'from_currency',
        'to_currency',
        'rate',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'rate' => 'decimal:4',
            'is_active' => 'boolean',
        ];
    }

    public static function current(): ?self
    {
        return static::query()
            ->where('from_currency', 'JPY')
            ->where('to_currency', 'IDR')
            ->where('is_active', true)
            ->latest('id')
            ->first();
    }
}
