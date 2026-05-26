@section('title', 'Detail Periode Kelulusan')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.graduation-periods.index') }}">Daftar Periode Kelulusan</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Detail Periode</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display font-bold text-xl text-white tracking-wide">Detail Periode Kelulusan</h2>
                <p class="text-xs text-slate-400 mt-1">Informasi lengkap periode dan kelas terkait.</p>
            </div>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('admin.graduation-periods.edit', $period) }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-500/10 px-4 py-2.5 text-xs font-semibold text-indigo-300 border border-indigo-500/20 hover:bg-indigo-500/15 transition">
                    <span class="material-icons-round text-sm">edit</span>
                    <span>Edit</span>
                </a>
                <button type="button" onclick="confirmDelete('{{ $period->id }}')" class="inline-flex items-center gap-2 rounded-xl bg-rose-500/10 px-4 py-2.5 text-xs font-semibold text-rose-300 border border-rose-500/20 hover:bg-rose-500/15 transition">
                    <span class="material-icons-round text-sm">delete</span>
                    <span>Hapus</span>
                </button>
                <form action="{{ route('admin.graduation-periods.destroy', $period) }}" method="POST" id="delete-form-{{ $period->id }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-4">
                <div class="glass-panel rounded-2xl shadow-xl p-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Tahun Ajaran</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $period->tahun_ajaran }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Semester</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $period->semester }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Tanggal Pengumuman</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $period->tanggal_pengumuman->format('d F Y') }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Status</p>
                        <span class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold tracking-wide {{ $period->is_active ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-800 text-slate-300 border border-white/10' }}">{{ $period->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                    </div>
                </div>

                <div class="glass-panel rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-sm text-white">Daftar Kelas</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-white/5 bg-slate-900/40 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                    <th class="py-3.5 px-6">Nama Kelas</th>
                                    <th class="py-3.5 px-6">Jurusan</th>
                                    <th class="py-3.5 px-6">Wali Kelas</th>
                                    <th class="py-3.5 px-6 text-center">Siswa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-sm">
                                @forelse($period->schoolClasses as $class)
                                    <tr class="hover:bg-white/[0.01] transition-colors">
                                        <td class="py-4 px-6 font-medium text-slate-200">{{ $class->nama_kelas }}</td>
                                        <td class="py-4 px-6 text-slate-400">{{ $class->jurusan }}</td>
                                        <td class="py-4 px-6 text-slate-400">{{ $class->wali_kelas }}</td>
                                        <td class="py-4 px-6 text-center text-slate-400">{{ $class->students->count() }} siswa</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-sm text-slate-500">Tidak ada kelas untuk periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-2xl shadow-xl p-6 space-y-4">
                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Jumlah Kelas</p>
                    <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $period->schoolClasses->count() }} kelas</p>
                </div>
                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Jumlah Siswa</p>
                    <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $period->students->count() }} siswa</p>
                </div>
                <a href="{{ route('admin.graduation-periods.index') }}" class="block w-full rounded-xl bg-slate-800 border border-white/10 px-4 py-3 text-center text-xs font-semibold text-slate-300 hover:bg-slate-700 transition">Kembali ke Daftar</a>
            </div>
        </div>
    </div>

    @push('custom_js')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Periode Kelulusan?',
                text: 'Periode akan dihapus permanen bersama data terkait.',
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
