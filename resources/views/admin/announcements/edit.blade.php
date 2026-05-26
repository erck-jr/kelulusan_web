@section('title', 'Edit Pengumuman')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.announcements.index') }}">Data Pengumuman</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Edit Pengumuman</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <h2 class="font-display font-bold text-xl text-white tracking-wide">Edit Pengumuman</h2>
            <p class="text-xs text-slate-400 mt-1">Perbarui judul, isi, dan status publikasi.</p>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Judul Pengumuman</label>
                            <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition" />
                            @error('title')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Isi Pengumuman</label>
                            <textarea name="content" rows="10" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition" placeholder="Tulis isi pengumuman...">{{ old('content', $announcement->content) }}</textarea>
                            @error('content')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-3">
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Publikasikan sekarang</label>
                            <div class="flex items-center gap-3">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $announcement->is_published) ? 'checked' : '' }} class="h-4 w-4 rounded border-white/10 bg-slate-900 text-cyan-500 focus:ring-cyan-500" />
                                <label for="is_published" class="text-sm text-slate-200">Aktifkan publikasi sekarang</label>
                            </div>
                        </div>
                        <div class="space-y-2 lg:col-span-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Tanggal Publikasi</label>
                            <input type="datetime-local" name="published_at" value="{{ old('published_at', $announcement->published_at ? $announcement->published_at->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 outline-none transition" />
                            @error('published_at')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 justify-end">
                        <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-slate-300 text-xs font-semibold transition hover:bg-slate-700">Batal</a>
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-sky-500 text-white text-xs font-semibold transition shadow-md">Perbarui Pengumuman</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
