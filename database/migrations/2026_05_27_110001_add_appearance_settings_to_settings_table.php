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
        $settings = [
            [
                'key' => 'theme_primary_color',
                'value' => '#6366f1',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Warna Utama (Primary Color)',
                'description' => 'Warna utama sekolah (format Hex, contoh: #6366f1) yang digunakan untuk gradasi ornamen dan elemen visual.'
            ],
            [
                'key' => 'theme_accent_color',
                'value' => '#8b5cf6',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Warna Aksen (Accent Color)',
                'description' => 'Warna aksen tombol, hover, dan ornamen penting (format Hex, contoh: #8b5cf6).'
            ],
            [
                'key' => 'theme_bg_mode',
                'value' => 'dark',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Mode Latar Belakang (Background Mode)',
                'description' => 'Pilihan mode tampilan untuk halaman publik siswa: dark (gelap) atau light (terang).'
            ],
            [
                'key' => 'theme_font_family',
                'value' => 'Outfit',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Jenis Huruf (Font Family)',
                'description' => 'Pilihan font Google Fonts online untuk halaman publik kelulusan siswa.'
            ],
            [
                'key' => 'theme_hero_bg',
                'value' => null,
                'type' => 'image',
                'group' => 'appearance',
                'label' => 'Gambar Latar Belakang (Background Hero)',
                'description' => 'Gambar latar kustom untuk halaman depan publik siswa (format: JPG/PNG, maks 2MB).'
            ]
        ];

        foreach ($settings as $setting) {
            $exists = \Illuminate\Support\Facades\DB::table('settings')->where('key', $setting['key'])->exists();
            if (!$exists) {
                \Illuminate\Support\Facades\DB::table('settings')->insert(array_merge($setting, [
                    'created_at' => now(),
                    'updated_at' => now()
                ]));
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::table('settings')
            ->whereIn('key', [
                'theme_primary_color',
                'theme_accent_color',
                'theme_bg_mode',
                'theme_font_family',
                'theme_hero_bg'
            ])->delete();
    }
};
