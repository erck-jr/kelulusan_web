<?php

namespace App\Services;

use App\Models\Setting;
use Exception;

class CertificateService
{
    /**
     * Generate sertifikat kelulusan
     *
     * @param string $nama_siswa
     * @param string $nisn
     * @param string $status_kelulusan
     * @return \GdImage|resource
     * @throws Exception
     */
    public function generate($nama_siswa, $nisn, $status_kelulusan)
    {
        $setting = Setting::where('key', 'template-sertifikat')->first();
        if (!$setting || empty($setting->value)) {
            throw new Exception('Template sertifikat belum diunggah oleh admin sekolah.');
        }

        $templatePath = storage_path('app/public/' . $setting->value);
        if (!file_exists($templatePath)) {
            throw new Exception('File template sertifikat tidak ditemukan di server.');
        }

        $font_path    = public_path('assets/fonts/BebasNeue-Regular.ttf');
        $gambar       = imagecreatefromjpeg($templatePath);
        $font_color   = imagecolorallocate($gambar, 0, 0, 0);

        $font_size = 50;
        $angle = 0;
        $width  = imagesx($gambar);
        $height = imagesy($gambar);
        $centerX = $width / 2;
        $centerY = $height / 2;

        $pasteCenteredText = function ($image, $text, $fontSize, $angle, $xOffset, $yOffset, $color, $fontPath, $centerX, $centerY) {
            list($left, $bottom, $right, , , $top) = imageftbbox($fontSize, $angle, $fontPath, $text);
            $left_offset = ($right - $left) / 2;
            $top_offset  = ($bottom - $top) / 2;

            $x = ($centerX - $left_offset) + $xOffset;
            $y = ($centerY - $top_offset) + $yOffset;

            imagettftext($image, $fontSize, $angle, $x, $y, $color, $fontPath, $text);
        };

        // ===== Tulis Nama Siswa =====
        $pasteCenteredText($gambar, $nama_siswa, $font_size, $angle, 0, -75, $font_color, $font_path, $centerX, $centerY);

        // ===== Tulis NISN =====
        $pasteCenteredText($gambar, "( " . strtoupper($nisn) . " )", $font_size, $angle, 0, 25, $font_color, $font_path, $centerX, $centerY);

        // ===== Tulis Status Kelulusan =====
        $pasteCenteredText($gambar, "~ " . strtoupper($status_kelulusan) . " ~", $font_size + 30, $angle, 0, 155, $font_color, $font_path, $centerX, $centerY);

        return $gambar;
    }
}
