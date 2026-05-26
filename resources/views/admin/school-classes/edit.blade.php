@section('title', 'Edit Kelas')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.school-classes.index') }}">Daftar Kelas</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Edit Kelas</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Edit Kelas</h2>
                    <p class="text-xs text-slate-400 mt-1">Perbarui detail kelas tanpa mengubah logika.</p>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form action="{{ route('admin.school-classes.update', $class) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nama Kelas</label>
                            <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $class->nama_kelas) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition" />
                            @error('nama_kelas')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Jurusan</label>
                            <input type="text" name="jurusan" value="{{ old('jurusan', $class->jurusan) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition" />
                            @error('jurusan')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Tingkat</label>
                            <input type="text" name="tingkat" value="{{ old('tingkat', $class->tingkat) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition" />
                            @error('tingkat')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Wali Kelas</label>
                            <input type="text" name="wali_kelas" value="{{ old('wali_kelas', $class->wali_kelas) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition" />
                            @error('wali_kelas')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Periode Kelulusan</label>
                            <select name="graduation_period_id" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition">
                                <option value="">Pilih Periode</option>
                                @foreach($periods as $period)
                                    <option value="{{ $period->id }}" {{ old('graduation_period_id', $class->graduation_period_id) == $period->id ? 'selected' : '' }}>{{ $period->tahun_ajaran }} - {{ $period->semester }}</option>
                                @endforeach
                            </select>
                            @error('graduation_period_id')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 justify-end">
                        <a href="{{ route('admin.school-classes.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-slate-300 text-xs font-semibold transition hover:bg-slate-700">Batal</a>
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-semibold transition shadow-md">Perbarui Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
