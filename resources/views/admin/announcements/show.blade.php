@section('title', 'Detil Pengumuman')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.announcements.index') }}">Data Pengumuman</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Detil Pengumuman</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display font-bold text-xl text-white tracking-wide">Detil Pengumuman</h2>
                <p class="text-xs text-slate-400 mt-1">Lihat status dan detail publikasi pengumuman.</p>
            </div>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-500/10 px-4 py-2.5 text-xs font-semibold text-indigo-300 border border-indigo-500/20 hover:bg-indigo-500/15 transition">
                    <span class="material-icons-round text-sm">edit</span>
                    <span>Edit</span>
                </a>
                <button type="button" onclick="confirmDelete('{{ $announcement->id }}')" class="inline-flex items-center gap-2 rounded-xl bg-rose-500/10 px-4 py-2.5 text-xs font-semibold text-rose-300 border border-rose-500/20 hover:bg-rose-500/15 transition">
                    <span class="material-icons-round text-sm">delete</span>
                    <span>Hapus</span>
                </button>
                <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" id="delete-form-{{ $announcement->id }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 glass-panel rounded-2xl shadow-xl p-6 space-y-4">
                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                    <h3 class="font-semibold text-lg text-white">{{ $announcement->title }}</h3>
                    <p class="text-xs text-slate-400 mt-2">{{ $announcement->published_at ? $announcement->published_at->format('d/m/Y H:i') : 'Belum ditentukan' }}</p>
                    <div class="mt-4 text-slate-200 leading-relaxed whitespace-pre-line">{!! nl2br(e($announcement->content)) !!}</div>
                </div>
            </div>
            <div class="glass-panel rounded-2xl shadow-xl p-6">
                <div class="space-y-4">
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-[11px] uppercase tracking-wide text-slate-500">Status</p>
                        <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold tracking-wide {{ $announcement->is_published ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/20' : 'bg-slate-800 text-slate-300 border border-white/10' }}">{{ $announcement->is_published ? 'Dipublikasi' : 'Draft' }}</span>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-[11px] uppercase tracking-wide text-slate-500">Dibuat pada</p>
                        <p class="mt-2 text-sm text-slate-200">{{ $announcement->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-[11px] uppercase tracking-wide text-slate-500">Terakhir diperbarui</p>
                        <p class="mt-2 text-sm text-slate-200">{{ $announcement->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-end">
            <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-slate-300 text-xs font-semibold transition hover:bg-slate-700">Kembali</a>
        </div>
    </div>

    @push('custom_js')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Pengumuman?',
                text: 'Pengumuman akan dihapus permanen dari sistem.',
                icon: 'warning',
                showCancelButton: true,
                background: '#0F1322',
                color: '#f1f5f9',
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#334155',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    @endpush
</x-layouts.admin-layout>
