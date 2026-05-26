<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CertificationGeneratorService;
use Illuminate\Cache\TaggableStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;

class SettingController extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->get();

        $groups = $settings->pluck('group')->unique()->values();

        $groupedSettings = $settings->groupBy('group');

        return view('admin.settings.index', [
            'settings' => $groupedSettings,
            'groups' => $groups
        ]);
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token', '_method') as $key => $value) {
            $setting = DB::table('settings')->where('key', $key)->first();

           if (!$setting) continue;
           
           if (($setting->type === 'image' || $setting->type === 'template') && $request->hasFile($key)) {
                if ($setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }
                // simpan file di folder "settings" di disk public
                $value = $request->file($key)->store('settings', 'public');
            }

            DB::table('settings')->where('key', $key)->update([
                'value' => $value,
                'updated_at' => now()
            ]);
        }

        Cache::forget('settings');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');

        Cache::forget('settings');

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function previewCertificate()
    {
        try {
            $certificateService = app(\App\Services\CertificateService::class);
            $gambar = $certificateService->generate('NAMA SISWA DUMMY', '1234567890', 'LULUS');

            ob_start();
            imagejpeg($gambar);
            $content = ob_get_clean();
            imagedestroy($gambar);

            return response($content)->header('Content-Type', 'image/jpeg');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function regenerateCertificates(Request $request)
    {
        // Try to flush certificate-related cache using tags when supported.
        try {
            $store = Cache::getStore();
            if ($store instanceof TaggableStore) {
                Cache::tags(['certificates'])->flush();
            } else {
                // Fallback: forget individual certificate cache keys for this school
                $students = Student::all();
                foreach ($students as $student) {
                    $cacheKey = "student_{$student->nis}_cert_path";
                    Cache::forget($cacheKey);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Unable to flush certificate cache tags: ' . $e->getMessage());
        }
        try {
            Log::info("Regenerating certificates for all students");

            $service = new CertificationGeneratorService();
            $service->generateCertificates();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Sertifikat berhasil diregenerasi.']);
            }

            return redirect()->back()->with('success', 'Sertifikat berhasil diregenerasi.');
        } catch (\Exception $e) {
            Log::error("Error regenerating certificates: " . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat meregenerasi sertifikat.'], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat meregenerasi sertifikat.');
        }
    }


}
