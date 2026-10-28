<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Services\ThemeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ThemeController extends Controller
{
    public function index(ThemeService $themeService): View
    {
        return view('theme-settings.index', [
            'themeColors' => $themeService->colors(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $allowedColors = [
            'primary',
            'primary_dark',
            'primary_soft',
            'background',
            'surface',
            'text',
            'muted',
            'border',
            'danger',
        ];

        $rules = [];

        foreach ($allowedColors as $color) {
            $rules[$color] = [
                'required',
                'string',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ];
        }

        $validated = $request->validate($rules);

        foreach ($allowedColors as $color) {
            AppSetting::setValue(
                'theme_' . $color,
                $validated[$color]
            );
        }

        return redirect()
            ->route('theme-settings.index')
            ->with('success', 'Pengaturan tema berhasil disimpan.');
    }
}
