@section('title', 'Edit Nilai')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.grades.index') }}">Data Nilai</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Edit Nilai</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <h2 class="font-display font-bold text-xl text-white tracking-wide">Edit Data Nilai</h2>
            <p class="text-xs text-slate-400 mt-1">Perbarui nilai siswa dengan tampilan yang seragam.</p>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form action="{{ route('admin.grades.update', $grade) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-6 lg:grid-cols-3">
                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Siswa</label>
                            <select name="student_id" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition">
                                <option value="">Pilih Siswa</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $grade->student_id) == $student->id ? 'selected' : '' }}>{{ $student->nis }} - {{ $student->nama }}</option>
                                @endforeach
                            </select>
                            @error('student_id')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2 lg:col-span-1">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Mata Pelajaran</label>
                            <input type="text" name="mata_pelajaran" value="{{ old('mata_pelajaran', $grade->mata_pelajaran) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition" />
                            @error('mata_pelajaran')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nilai Ujian</label>
                            <input type="number" step="0.01" name="nilai_ujian" value="{{ old('nilai_ujian', $grade->nilai_ujian) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition" />
                            @error('nilai_ujian')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nilai Sekolah</label>
                            <input type="number" step="0.01" name="nilai_sekolah" value="{{ old('nilai_sekolah', $grade->nilai_sekolah) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition" />
                            @error('nilai_sekolah')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nilai Akhir</label>
                            <input type="number" step="0.01" name="nilai_akhir" value="{{ old('nilai_akhir', $grade->nilai_akhir) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition" />
                            @error('nilai_akhir')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2 lg:col-span-3">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Catatan (opsional)</label>
                            <textarea name="catatan" rows="4" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition" placeholder="Catatan tambahan...">{{ old('catatan', $grade->catatan) }}</textarea>
                            @error('catatan')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 justify-end">
                        <a href="{{ route('admin.grades.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-slate-300 text-xs font-semibold transition hover:bg-slate-700">Batal</a>
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-rose-500 to-pink-500 text-white text-xs font-semibold transition shadow-md">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
