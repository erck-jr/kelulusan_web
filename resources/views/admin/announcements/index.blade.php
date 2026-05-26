@section('title', 'Data Pengumuman')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Data Pengumuman</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400">
                    <span class="material-icons-round text-2xl">campaign</span>
                </div>
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Daftar Pengumuman</h2>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Total terdata: <span class="text-cyan-400 font-bold">{{ $announcements->total() }}</span> Pengumuman</p>
                </div>
            </div>

            <a href="{{ route('admin.announcements.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-cyan-500 to-sky-500 px-4 py-2.5 text-xs font-semibold text-white transition shadow-md hover:from-cyan-600 hover:to-sky-600">
                <span class="material-icons-round text-sm">add</span>
                <span>Tambah Pengumuman</span>
            </a>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-slate-900/40 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3.5 px-6">Judul</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6">Tanggal Publikasi</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($announcements as $announcement)
                            <tr class="hover:bg-white/[0.01] transition-colors">
                                <td class="py-4 px-6 font-medium text-slate-200">{{ $announcement->title }}</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold tracking-wide {{ $announcement->is_published ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-800 text-slate-300 border border-white/10' }}">
                                        {{ $announcement->is_published ? 'Dipublikasi' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-slate-400">{{ $announcement->published_at ? $announcement->published_at->format('d/m/Y H:i') : '-' }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.announcements.show', $announcement) }}" class="p-2 rounded-lg bg-slate-800 text-slate-400 hover:text-white border border-white/5 hover:border-white/10 transition-colors" title="Detail Pengumuman">
                                            <span class="material-icons-round text-sm">visibility</span>
                                        </a>
                                        <a href="{{ route('admin.announcements.edit', $announcement) }}" class="p-2 rounded-lg bg-indigo-500/5 text-indigo-400 hover:bg-indigo-500/10 border border-indigo-500/10 hover:border-indigo-500/20 transition-colors" title="Edit Pengumuman">
                                            <span class="material-icons-round text-sm">edit</span>
                                        </a>
                                        <button type="button" onclick="confirmDelete('{{ $announcement->id }}')" class="p-2 rounded-lg bg-rose-500/5 text-rose-400 hover:bg-rose-500/10 border border-rose-500/10 hover:border-rose-500/20 transition-colors" title="Hapus Pengumuman">
                                            <span class="material-icons-round text-sm">delete</span>
                                        </button>
                                        <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" id="delete-form-{{ $announcement->id }}" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-sm text-slate-500">Tidak ada pengumuman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($announcements->hasPages())
                <div class="p-4 border-t border-white/5 bg-slate-900/20 custom-pagination">
                    {{ $announcements->links() }}
                </div>
            @endif
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
