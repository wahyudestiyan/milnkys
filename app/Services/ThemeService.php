<?php

namespace App\Services;

use App\Models\AppSetting;

class ThemeService
{
    public function colors(): array
    {
        $defaults = config('theme.colors', []);

     $keys = [
    'primary',
    'primary_dark',
    'primary_soft',
    'background',
    'surface',
    'text',
    'muted',
    'border',
    'danger',
    'success',
    'success_soft',
    'warning',
    'danger_soft',
];

        $colors = [];

        foreach ($keys as $key) {
            $colors[$key] = AppSetting::getValue(
                'theme_' . $key,
                $defaults[$key] ?? '#FFFFFF'
            );
        }

        return $colors;
    }
}
