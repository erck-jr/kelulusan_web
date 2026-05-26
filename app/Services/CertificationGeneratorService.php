<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Student;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CertificationGeneratorService
{
    /**
     * Generate certificates for all students in a school and cache them.
     *
     * @return void
     */
    public function generateCertificates()
    {
        // Get the certificate template path from settings
        $setting = Setting::where('key', 'template-sertifikat')->first();
        if (!$setting || empty($setting->value)) {
            throw new \Exception('Template sertifikat belum diunggah oleh admin sekolah.');
        }

        $templatePath = storage_path('app/public/' . $setting->value);
        if (!file_exists($templatePath)) {
            throw new \Exception('File template sertifikat tidak ditemukan di server.');
        }

        // Generate and save certificates for the specified student
        $students = Student::all();
        foreach ($students as $student) {
            try {       
                    $certificate = $this->generateCertificate(
                    $student->nama,
                    $student->nis,
                        ($student->status ? 'LULUS' : 'TIDAK LULUS')
                    );

                    $path = 'certificates/' . $student->nis . '.jpg';
                    ob_start();
                    imagejpeg($certificate);
                    $imageContent = ob_get_clean();
                    imagedestroy($certificate);

                    Storage::disk('public')->put($path, $imageContent);

                    // Cache the public URL of the certificate
                    $cacheKey = "student_{$student->nis}_cert_path";
                    Cache::put($cacheKey, url('storage/' . $path), now()->addDays(365));
                
                    // Save the certificate to the public disk as JPEG
                    
                } catch (\Exception $e) {
                    Log::error("Error generating certificate for student {$student->nama}: " . $e->getMessage());
                }
        }
    }

    /**
     * Generate a single certificate.
     *
     * @param string $nama_siswa
     * @param string $nisn
     * @param string $status_kelulusan
     * @return \GdImage|resource
     */
    private function generateCertificate($nama_siswa, $nisn, $status_kelulusan)
    {
        // Use the existing CertificateService to generate the certificate
        return app(CertificateService::class)->generate($nama_siswa, $nisn, $status_kelulusan);
    }
}