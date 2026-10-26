<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Pengingat otomatis deadline pembayaran
Schedule::command('payment-deadline:remind')
    ->everyMinute()
    ->withoutOverlapping();