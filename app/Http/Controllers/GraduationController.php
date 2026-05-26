<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\GraduationPeriod;

class GraduationController extends Controller
{
    public function index()
    {
        $activePeriod = GraduationPeriod::where('is_active', true)->first();
        return view('graduation.index', compact('activePeriod'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'nis' => 'required|string'
        ]);

        $student = Student::with(['schoolClass', 'grades'])
            ->where('nis', $request->nis)
            ->first();

        if (!$student) {
            return back()->with('error', 'NIS tidak ditemukan');
        }

        $activePeriod = GraduationPeriod::where('is_active', true)->first();
        if ($activePeriod) {
            $pengumumanDateTime = \Carbon\Carbon::parse($activePeriod->tanggal_pengumuman->format('Y-m-d') . ' ' . ($activePeriod->jam_pengumuman ?? '00:00:00'));
            if (now()->lt($pengumumanDateTime)) {
                return back()->with('error', 'Maaf, Pengumuman Kelulusan akan dibuka pada ' . $pengumumanDateTime->format('d-m-Y H:i'));
            }
        }

        $nisn             = $student->nis;
        $nama_siswa       = $student->nama;
        $status_kelulusan = $student->status;

        clearstatcache();

        // Only use cached certificate URLs for student access.
        $cacheKey = "student_{$nisn}_cert_path";

        $sertifikatPath = null;
        if ($student) {
            $sertifikatPath = \Illuminate\Support\Facades\Cache::get($cacheKey);
        }
        return view('graduation.result', compact('student', 'sertifikatPath'));
    }

}
