@section('title', 'Daftar Periode Kelulusan')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Daftar Periode Kelulusan</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                    <span class="material-icons-round text-2xl">event</span>
                </div>
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Daftar Periode Kelulusan</h2>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Total periode: <span class="text-amber-400 font-bold">{{ $periods->total() }}</span></p>
                </div>
            </div>

            <a href="{{ route('admin.graduation-periods.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 px-4 py-2.5 text-xs font-semibold text-white transition shadow-md hover:from-amber-600 hover:to-orange-600">
                <span class="material-icons-round text-sm">add</span>
                <span>Tambah Periode</span>
            </a>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-slate-900/40 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3.5 px-6">Tahun Ajaran</th>
                            <th class="py-3.5 px-6">Semester</th>
                            <th class="py-3.5 px-6">Waktu Pengumuman</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($periods as $period)
                            <tr class="hover:bg-white/[0.01] transition-colors">
                                <td class="py-4 px-6 font-medium text-slate-200">{{ $period->tahun_ajaran }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ $period->semester }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ $period->tanggal_pengumuman->format('d F Y') }} {{ $period->jam_pengumuman ? \Carbon\Carbon::parse($period->jam_pengumuman)->format('H:i') : '00:00' }} WIB</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold tracking-wide {{ $period->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-800 text-slate-300 border border-white/10' }}">{{ $period->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.graduation-periods.show', $period) }}" class="p-2 rounded-lg bg-slate-800 text-slate-400 hover:text-white border border-white/5 hover:border-white/10 transition-colors" title="Detail Periode">
                                            <span class="material-icons-round text-sm">visibility</span>
                                        </a>
                                        <a href="{{ route('admin.graduation-periods.edit', $period) }}" class="p-2 rounded-lg bg-indigo-500/5 text-indigo-400 hover:bg-indigo-500/10 border border-indigo-500/10 hover:border-indigo-500/20 transition-colors" title="Edit Periode">
                                            <span class="material-icons-round text-sm">edit</span>
                                        </a>
                                        <button type="button" onclick="confirmDelete('{{ $period->id }}')" class="p-2 rounded-lg bg-rose-500/5 text-rose-400 hover:bg-rose-500/10 border border-rose-500/10 hover:border-rose-500/20 transition-colors" title="Hapus Periode">
                                            <span class="material-icons-round text-sm">delete</span>
                                        </button>
                                        <form action="{{ route('admin.graduation-periods.destroy', $period) }}" method="POST" id="delete-form-{{ $period->id }}" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-sm text-slate-500">Tidak ada data periode kelulusan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($periods->hasPages())
                <div class="p-4 border-t border-white/5 bg-slate-900/20 custom-pagination">
                    {{ $periods->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('custom_js')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Periode Kelulusan?',
                html: "Periode akan dihapus permanen bersama seluruh data terkait.",
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
