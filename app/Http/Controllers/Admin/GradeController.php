<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Protection;

class GradeController extends Controller
{
    public function template()
    {
        // Ambil siswa dari periode aktif
        $students = Student::whereHas('graduationPeriod', function ($query) {
                            $query->where('is_active', 1);
                        })
                        ->pluck('nis','id');

        // Header kolom
        $headers = [
            'NISN',           // A
            'Mata Pelajaran', // B
            'Nilai Ujian',    // C
            'Nilai Sekolah',  // D
            'Nilai Akhir',    // E
            'Catatan'         // F
        ];

        $filename = 'template_nilai_' . date('Ymd') . '.xlsx';
        $path = storage_path('app/public/' . $filename);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // === Set header ===
        foreach ($headers as $idx => $header) {
            $col = chr(65 + $idx); // A, B, C, ...
            $sheet->setCellValue("{$col}1", $header);
            $sheet->getStyle("{$col}1")->getFont()->setBold(true);
        }

        // === Isi data NIS di kolom A ===
        $row = 2;
        foreach ($students as $nis) {
            $sheet->setCellValue("A{$row}", $nis);
            $row++;
        }

        // === Format angka untuk nilai ===
        $sheet->getStyle('C:E')->getNumberFormat()
            ->setFormatCode('0.00'); // 2 desimal

        // Auto size kolom
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // === Simpan file ===
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }

    public function index()
    {
        $grades = Grade::with('student')->whereHas('student.graduationPeriod', function ($query) {
                        $query->where('is_active', 1);
                    })
                ->latest()->paginate(10);
        return view('admin.grades.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::all();
        return view('admin.grades.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'mata_pelajaran' => 'required',
            'nilai_akhir' => 'required|numeric|min:0|max:100',
            'nilai_ujian' => 'nullable|numeric|min:0|max:100',
            'nilai_sekolah' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        Grade::create($validated);

        // Update nilai rata-rata siswa
        $student = Student::find($request->student_id);
        $avgGrade = $student->grades()->avg('nilai_akhir');
        $student->update(['nilai_rata_rata' => $avgGrade]);

        return redirect()->route('admin.grades.index')->with('success', 'Nilai berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $grade = Grade::with('student')->findOrFail($id);
        return view('admin.grades.show', compact('grade'));
    }

    public function edit(string $id)
    {
        $grade = Grade::findOrFail($id);
        $students = Student::all();
        return view('admin.grades.edit', compact('grade', 'students'));
    }

    public function update(Request $request, string $id)
    {
        $grade = Grade::findOrFail($id);

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'mata_pelajaran' => 'required',
            'nilai_akhir' => 'required|numeric|min:0|max:100',
            'nilai_ujian' => 'nullable|numeric|min:0|max:100',
            'nilai_sekolah' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        $grade->update($validated);

        // Update nilai rata-rata siswa
        $student = Student::find($request->student_id);
        $avgGrade = $student->grades()->avg('nilai_akhir');
        $student->update(['nilai_rata_rata' => $avgGrade]);

        return redirect()->route('admin.grades.index')->with('success', 'Nilai berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $grade = Grade::findOrFail($id);
        $student_id = $grade->student_id;
        $grade->delete();

        // Update nilai rata-rata siswa
        $student = Student::find($student_id);
        $avgGrade = $student->grades()->avg('nilai_akhir');
        $student->update(['nilai_rata_rata' => $avgGrade]);

        return redirect()->route('admin.grades.index')->with('success', 'Nilai berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $errors = [];
        $validData = [];
        $affectedStudentIds = [];

        foreach ($rows as $index => $row) {
            if ($index == 1) continue; // skip header

            $nis            = trim($row['A'] ?? '');
            $mataPelajaran  = trim($row['B'] ?? '');
            $nilaiUjian     = isset($row['C']) ? trim($row['C']) : null;
            $nilaiSekolah   = isset($row['D']) ? trim($row['D']) : null;
            $nilaiAkhir     = isset($row['E']) ? trim($row['E']) : null;
            $catatan        = isset($row['F']) ? trim($row['F']) : null;

            // skip baris kosong
            if (empty($nis) && empty($mataPelajaran)) continue;

            $hasRowError = false;

            if (empty($nis)) {
                $errors[] = "Baris {$index} Kolom A (NISN) kosong.";
                $hasRowError = true;
            }
            if (empty($mataPelajaran)) {
                $errors[] = "Baris {$index} Kolom B (Mata Pelajaran) kosong.";
                $hasRowError = true;
            }

            if ($hasRowError) continue; // skip to next row since NIS/Mapel is required to do further checks

            // validasi nis
            $student = Student::where('nis', $nis)->first();
            if (!$student) {
                $errors[] = "Baris {$index} Kolom A &rarr; NIS <b>{$nis}</b> tidak ditemukan di database.";
                $hasRowError = true;
            }

            // validasi nilai (harus angka jika diisi)
            if ($nilaiUjian !== null && $nilaiUjian !== '' && !is_numeric($nilaiUjian)) {
                $errors[] = "Baris {$index} Kolom C (Nilai Ujian) harus berupa angka.";
                $hasRowError = true;
            }
            if ($nilaiSekolah !== null && $nilaiSekolah !== '' && !is_numeric($nilaiSekolah)) {
                $errors[] = "Baris {$index} Kolom D (Nilai Sekolah) harus berupa angka.";
                $hasRowError = true;
            }
            if ($nilaiAkhir === null || $nilaiAkhir === '' || !is_numeric($nilaiAkhir)) {
                $errors[] = "Baris {$index} Kolom E (Nilai Akhir) kosong atau bukan angka (wajib diisi).";
                $hasRowError = true;
            }

            if (!$hasRowError) {
                $validData[] = [
                    'student_id'     => $student->id,
                    'mata_pelajaran' => $mataPelajaran,
                    'nilai_ujian'    => $nilaiUjian !== '' ? $nilaiUjian : null,
                    'nilai_sekolah'  => $nilaiSekolah !== '' ? $nilaiSekolah : null,
                    'nilai_akhir'    => $nilaiAkhir,
                    'catatan'        => $catatan,
                ];
                $affectedStudentIds[$student->id] = $student->id;
            }
        }

        // kalau ada error, batalkan semua (all in or nothing)
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        // kalau aman, simpan dalam transaction
        DB::transaction(function () use ($validData, $affectedStudentIds) {
            foreach ($validData as $data) {
                // Cari berdasarkan subject case-insensitive
                $existing = Grade::where('student_id', $data['student_id'])
                                 ->whereRaw('LOWER(mata_pelajaran) = ?', [strtolower($data['mata_pelajaran'])])
                                 ->first();

                if ($existing) {
                    $existing->update([
                        'nilai_ujian' => $data['nilai_ujian'],
                        'nilai_sekolah' => $data['nilai_sekolah'],
                        'nilai_akhir' => $data['nilai_akhir'],
                        'catatan' => $data['catatan'],
                    ]);
                } else {
                    Grade::create($data);
                }
            }

            // Update nilai rata-rata siswa
            foreach ($affectedStudentIds as $studentId) {
                $student = Student::find($studentId);
                if ($student) {
                    $avgGrade = $student->grades()->avg('nilai_akhir');
                    $student->update(['nilai_rata_rata' => $avgGrade]);
                }
            }
        });

        return redirect()->back()->with('success', 'Import nilai berhasil disimpan.');
    }


}
