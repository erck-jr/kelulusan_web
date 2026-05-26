@section('title', 'Edit Periode Kelulusan')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.graduation-periods.index') }}">Daftar Periode Kelulusan</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Edit Periode</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <h2 class="font-display font-bold text-xl text-white tracking-wide">Edit Periode Kelulusan</h2>
            <p class="text-xs text-slate-400 mt-1">Perbarui detail periode aktif.</p>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form action="{{ route('admin.graduation-periods.update', $period) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-6 lg:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $period->tahun_ajaran) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition" />
                            @error('tahun_ajaran')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Semester</label>
                            <select name="semester" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition">
                                <option value="">Pilih Semester</option>
                                <option value="Ganjil" {{ old('semester', $period->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester', $period->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('semester')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Tanggal Pengumuman</label>
                            <input type="date" name="tanggal_pengumuman" value="{{ old('tanggal_pengumuman', $period->tanggal_pengumuman->format('Y-m-d')) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition" />
                            @error('tanggal_pengumuman')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Jam Pengumuman</label>
                            <input type="time" name="jam_pengumuman" value="{{ old('jam_pengumuman', $period->jam_pengumuman ? \Carbon\Carbon::parse($period->jam_pengumuman)->format('H:i') : '') }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition" />
                            @error('jam_pengumuman')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2 lg:col-span-2">
                            <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-slate-950/50 px-4 py-3 text-sm text-slate-200">
                                <input type="checkbox" name="is_active" value="1" class="h-4 w-4 text-amber-500 focus:ring-amber-500" {{ $period->is_active ? 'checked' : '' }} />
                                <span>Aktifkan periode ini</span>
                            </label>
                            @error('is_active')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Keterangan (opsional)</label>
                            <textarea name="keterangan" rows="4" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none transition" placeholder="Keterangan tambahan...">{{ old('keterangan', $period->keterangan) }}</textarea>
                            @error('keterangan')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 justify-end">
                        <a href="{{ route('admin.graduation-periods.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-slate-300 text-xs font-semibold transition hover:bg-slate-700">Batal</a>
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-semibold transition shadow-md">Perbarui Periode</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
