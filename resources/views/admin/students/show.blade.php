@section('title', 'Detail Siswa')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.students.index') }}">Daftar Siswa</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Detail Siswa</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display font-bold text-xl text-white tracking-wide">Detail Siswa</h2>
                <p class="text-xs text-slate-400 mt-1">Data lengkap siswa dan daftar nilai.</p>
            </div>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('admin.students.edit', $student) }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-500/10 px-4 py-2.5 text-xs font-semibold text-indigo-300 border border-indigo-500/20 hover:bg-indigo-500/15 transition">
                    <span class="material-icons-round text-sm">edit</span>
                    <span>Edit</span>
                </a>
                <button type="button" onclick="confirmDelete('{{ $student->id }}')" class="inline-flex items-center gap-2 rounded-xl bg-rose-500/10 px-4 py-2.5 text-xs font-semibold text-rose-300 border border-rose-500/20 hover:bg-rose-500/15 transition">
                    <span class="material-icons-round text-sm">delete</span>
                    <span>Hapus</span>
                </button>
                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" id="delete-form-{{ $student->id }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-4">
                <div class="glass-panel rounded-2xl shadow-xl p-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">NIS</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $student->nis }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Nama Lengkap</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $student->nama }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Kelas</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $student->schoolClass->nama_kelas }} - {{ $student->schoolClass->jurusan }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Periode Kelulusan</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $student->graduationPeriod->tahun_ajaran }} - {{ $student->graduationPeriod->semester }}</p>
                    </div>
                </div>

                <div class="glass-panel rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-sm text-white">Daftar Nilai</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-white/5 bg-slate-900/40 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                    <th class="py-3.5 px-6">Mata Pelajaran</th>
                                    <th class="py-3.5 px-6">Nilai Ujian</th>
                                    <th class="py-3.5 px-6">Nilai Sekolah</th>
                                    <th class="py-3.5 px-6">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-sm">
                                @forelse($student->grades as $grade)
                                    <tr class="hover:bg-white/[0.01] transition-colors">
                                        <td class="py-4 px-6 font-medium text-slate-200">{{ $grade->mata_pelajaran }}</td>
                                        <td class="py-4 px-6 text-slate-400">{{ number_format($grade->nilai_ujian, 2) }}</td>
                                        <td class="py-4 px-6 text-slate-400">{{ number_format($grade->nilai_sekolah, 2) }}</td>
                                        <td class="py-4 px-6 text-slate-400">{{ number_format($grade->nilai_akhir, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-sm text-slate-500">Belum ada nilai</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-2xl shadow-xl p-6 space-y-4">
                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Status</p>
                    <span class="mt-2 inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold tracking-wide {{ $student->status === 'LULUS' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">{{ $student->status }}</span>
                </div>
                @if($student->catatan)
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Catatan</p>
                        <p class="mt-2 text-sm text-slate-200">{{ $student->catatan }}</p>
                    </div>
                @endif
                <a href="{{ route('admin.students.index') }}" class="block w-full rounded-xl bg-slate-800 border border-white/10 px-4 py-3 text-center text-xs font-semibold text-slate-300 hover:bg-slate-700 transition">Kembali ke Daftar</a>
            </div>
        </div>
    </div>

    @push('custom_js')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Data Siswa?',
                text: 'Seluruh riwayat nilai siswa akan terhapus permanen dari peladen server!',
                icon: 'warning',
                showCancelButton: true,
                background: '#0F1322',
                color: '#f1f5f9',
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#334155',
                confirmButtonText: 'Ya, Hapus Permanen',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    @endpush
</x-layouts.admin-layout>
