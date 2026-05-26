@section('title', 'Edit Siswa')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.students.index') }}">Daftar Siswa</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Edit Siswa</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Edit Data Siswa</h2>
                    <p class="text-xs text-slate-400 mt-1">Perbarui data siswa dengan gaya yang seragam.</p>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form action="{{ route('admin.students.update', $student) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-6 lg:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">NIS</label>
                            <input type="text" name="nis" value="{{ old('nis', $student->nis) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('nis')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama', $student->nama) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('nama')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Kelas</label>
                            <select name="school_class_id" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition">
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('school_class_id', $student->school_class_id) == $class->id ? 'selected' : '' }}>{{ $class->nama_kelas }} - {{ $class->jurusan }}</option>
                                @endforeach
                            </select>
                            @error('school_class_id')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Periode Kelulusan</label>
                            <select name="graduation_period_id" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition">
                                <option value="">Pilih Periode</option>
                                @foreach($periods as $period)
                                    <option value="{{ $period->id }}" {{ old('graduation_period_id', $student->graduation_period_id) == $period->id ? 'selected' : '' }}>{{ $period->tahun_ajaran }} - {{ $period->semester }}</option>
                                @endforeach
                            </select>
                            @error('graduation_period_id')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nilai Rata-Rata</label>
                            <input type="number" step="0.01" name="nilai_rata_rata" value="{{ old('nilai_rata_rata', $student->nilai_rata_rata) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('nilai_rata_rata')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2 flex items-center gap-3">
                            <label class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3 text-slate-200 text-sm w-full">
                                <input type="checkbox" name="status" value="LULUS" class="h-4 w-4 text-emerald-500 focus:ring-emerald-500" {{ old('status', $student->status) === 'LULUS' ? 'checked' : '' }} />
                                <span>Status Lulus</span>
                            </label>
                            <span class="text-xs text-slate-400">Centang jika siswa lulus.</span>
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Catatan (opsional)</label>
                            <textarea name="catatan" rows="4" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" placeholder="Catatan tambahan...">{{ old('catatan', $student->catatan) }}</textarea>
                            @error('catatan')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 justify-end">
                        <a href="{{ route('admin.students.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-slate-300 text-xs font-semibold transition hover:bg-slate-700">Batal</a>
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 text-white text-xs font-semibold transition shadow-md">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
