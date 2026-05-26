@section('title', 'Data Nilai')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Data Nilai</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400">
                    <span class="material-icons-round text-2xl">grade</span>
                </div>
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Data Nilai</h2>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Total nilai: <span class="text-rose-400 font-bold">{{ $grades->total() }}</span></p>
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.grades.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-rose-500 to-pink-500 px-4 py-2.5 text-xs font-semibold text-white transition shadow-md hover:from-rose-600 hover:to-pink-600">
                    <span class="material-icons-round text-sm">add</span>
                    <span>Tambah Nilai</span>
                </a>
                <button type="button" onclick="document.getElementById('import-modal').classList.remove('hidden')" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-500/10 px-4 py-2.5 text-xs font-semibold text-emerald-300 border border-emerald-500/20 hover:bg-emerald-500/15 transition">
                    <span class="material-icons-round text-sm">upload</span>
                    <span>Import</span>
                </button>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-slate-900/40 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3.5 px-6">Siswa</th>
                            <th class="py-3.5 px-6">Mata Pelajaran</th>
                            <th class="py-3.5 px-6">Nilai Ujian</th>
                            <th class="py-3.5 px-6">Nilai Sekolah</th>
                            <th class="py-3.5 px-6">Nilai Akhir</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($grades as $grade)
                            <tr class="hover:bg-white/[0.01] transition-colors">
                                <td class="py-4 px-6 font-medium text-slate-200">{{ $grade->student->nama }}<span class="block text-xs text-slate-500">{{ $grade->student->nis }}</span></td>
                                <td class="py-4 px-6 text-slate-400">{{ $grade->mata_pelajaran }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ number_format($grade->nilai_ujian, 2) }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ number_format($grade->nilai_sekolah, 2) }}</td>
                                <td class="py-4 px-6 text-slate-400">{{ number_format($grade->nilai_akhir, 2) }}</td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.grades.show', $grade) }}" class="p-2 rounded-lg bg-slate-800 text-slate-400 hover:text-white border border-white/5 hover:border-white/10 transition-colors" title="Detail Nilai">
                                            <span class="material-icons-round text-sm">visibility</span>
                                        </a>
                                        <a href="{{ route('admin.grades.edit', $grade) }}" class="p-2 rounded-lg bg-indigo-500/5 text-indigo-400 hover:bg-indigo-500/10 border border-indigo-500/10 hover:border-indigo-500/20 transition-colors" title="Edit Nilai">
                                            <span class="material-icons-round text-sm">edit</span>
                                        </a>
                                        <button type="button" onclick="confirmDelete('{{ $grade->id }}')" class="p-2 rounded-lg bg-rose-500/5 text-rose-400 hover:bg-rose-500/10 border border-rose-500/10 hover:border-rose-500/20 transition-colors" title="Hapus Nilai">
                                            <span class="material-icons-round text-sm">delete</span>
                                        </button>
                                        <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" id="delete-form-{{ $grade->id }}" class="hidden">
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
                                        <span class="inline-flex px-3 py-1 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 text-xs font-semibold">Tidak ada nilai pada periode aktif saat ini</span>
                                        <a href="{{ route('admin.graduation-periods.index') }}" class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-slate-900/80 px-4 py-2 text-xs font-semibold text-slate-300 hover:bg-slate-800 transition">Ganti Periode</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($grades->hasPages())
                <div class="p-4 border-t border-white/5 bg-slate-900/20 custom-pagination">
                    {{ $grades->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <div id="import-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="relative rounded-2xl bg-[#0F1322] border border-white/10 shadow-2xl max-w-2xl w-full p-6">
            <div class="flex items-center justify-between border-b border-white/5 pb-4 mb-4">
                <div>
                    <h3 class="font-display font-bold text-base text-white tracking-wide">Import Data Nilai</h3>
                    <p class="text-xs text-slate-400 mt-1">Unggah file Excel atau CSV sesuai template.</p>
                </div>
                <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden')" class="text-slate-400 hover:text-white transition">
                    <span class="material-icons-round text-lg">close</span>
                </button>
            </div>
            <form action="{{ route('admin.grades.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <a href="{{ route('admin.grades.template') }}" class="inline-flex items-center justify-center gap-2 w-full rounded-xl bg-slate-800 border border-white/10 px-4 py-3 text-xs font-semibold text-slate-300 hover:bg-slate-700 transition">
                    <span class="material-icons-round text-sm">download</span>
                    <span>Unduh Template Excel</span>
                </a>
                <div class="space-y-2 rounded-2xl bg-slate-950/50 border border-white/10 p-4">
                    <div class="text-xs uppercase tracking-wide text-slate-400">Pilih Berkas</div>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full rounded-2xl bg-slate-900/70 border border-white/10 px-4 py-3 text-slate-200 text-sm" />
                    <p class="text-[11px] text-slate-500">Ekstensi dokumen: .xlsx, .xls, .csv.</p>
                </div>
                <div class="flex flex-wrap gap-3 justify-end">
                    <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-slate-300 text-xs font-semibold transition hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 text-white text-xs font-semibold transition shadow-md">Import</button>
                </div>
            </form>
        </div>
    </div>

    @push('custom_js')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Nilai?',
                text: 'Nilai akan dihapus permanen!',
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
