@section('title', 'Daftar Kelas')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Daftar Kelas</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                    <span class="material-icons-round text-2xl">school</span>
                </div>
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Daftar Kelas</h2>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Total terdata: <span class="text-emerald-400 font-bold">{{ $classes->total() }}</span> Kelas</p>
                </div>
            </div>

            <a href="{{ route('admin.school-classes.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 px-4 py-2.5 text-xs font-semibold text-white transition shadow-md hover:from-emerald-600 hover:to-teal-600">
                <span class="material-icons-round text-sm">add</span>
                <span>Tambah Kelas</span>
            </a>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-slate-900/40 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3.5 px-6">Nama Kelas</th>
                            <th class="py-3.5 px-6">Jurusan</th>
                            <th class="py-3.5 px-6">Tingkat</th>
                            <th class="py-3.5 px-6">Wali Kelas</th>
                            <th class="py-3.5 px-6">Periode</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($classes as $class)
                            <tr class="hover:bg-white/[0.01] transition-colors">
                                <td class="py-4 px-6 font-medium text-slate-200">{{ $class->nama_kelas }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ $class->jurusan }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ $class->tingkat }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ $class->wali_kelas }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ $class->graduationPeriod->tahun_ajaran }} - {{ $class->graduationPeriod->semester }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.school-classes.show', $class) }}" class="p-2 rounded-lg bg-slate-800 text-slate-400 hover:text-white border border-white/5 hover:border-white/10 transition-colors" title="Detail Kelas">
                                            <span class="material-icons-round text-sm">visibility</span>
                                        </a>
                                        <a href="{{ route('admin.school-classes.edit', $class) }}" class="p-2 rounded-lg bg-indigo-500/5 text-indigo-400 hover:bg-indigo-500/10 border border-indigo-500/10 hover:border-indigo-500/20 transition-colors" title="Edit Kelas">
                                            <span class="material-icons-round text-sm">edit</span>
                                        </a>
                                        <button type="button" onclick="confirmDelete('{{ $class->id }}')" class="p-2 rounded-lg bg-rose-500/5 text-rose-400 hover:bg-rose-500/10 border border-rose-500/10 hover:border-rose-500/20 transition-colors" title="Hapus Kelas">
                                            <span class="material-icons-round text-sm">delete</span>
                                        </button>
                                        <form action="{{ route('admin.school-classes.destroy', $class) }}" method="POST" id="delete-form-{{ $class->id }}" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-sm text-slate-500">
                                    <div class="space-y-3">
                                        <span class="inline-flex px-3 py-1 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 text-xs font-semibold">Tidak ada kelas pada periode aktif saat ini</span>
                                        <a href="{{ route('admin.graduation-periods.index') }}" class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-slate-900/80 px-4 py-2 text-xs font-semibold text-slate-300 hover:bg-slate-800 transition">Ganti Periode</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($classes->hasPages())
                <div class="p-4 border-t border-white/5 bg-slate-900/20 custom-pagination">
                    {{ $classes->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('custom_js')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Kelas?',
                text: 'Kelas akan dihapus permanen bersama data terkait.',
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
