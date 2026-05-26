@section('title', 'Detail Nilai')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.grades.index') }}">Data Nilai</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Detail Nilai</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display font-bold text-xl text-white tracking-wide">Detail Nilai</h2>
                <p class="text-xs text-slate-400 mt-1">Informasi nilai siswa secara rinci.</p>
            </div>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('admin.grades.edit', $grade) }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-500/10 px-4 py-2.5 text-xs font-semibold text-indigo-300 border border-indigo-500/20 hover:bg-indigo-500/15 transition">
                    <span class="material-icons-round text-sm">edit</span>
                    <span>Edit</span>
                </a>
                <button type="button" onclick="confirmDelete('{{ $grade->id }}')" class="inline-flex items-center gap-2 rounded-xl bg-rose-500/10 px-4 py-2.5 text-xs font-semibold text-rose-300 border border-rose-500/20 hover:bg-rose-500/15 transition">
                    <span class="material-icons-round text-sm">delete</span>
                    <span>Hapus</span>
                </button>
                <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" id="delete-form-{{ $grade->id }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 glass-panel rounded-2xl shadow-xl p-6 space-y-4">
                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Siswa</p>
                    <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $grade->student->nama }}</p>
                    <p class="text-xs text-slate-500">NIS: {{ $grade->student->nis }}</p>
                </div>
                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Kelas</p>
                    <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $grade->student->schoolClass->nama_kelas }}</p>
                </div>
                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                    <p class="text-xs uppercase tracking-wide text-slate-400">Mata Pelajaran</p>
                    <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $grade->mata_pelajaran }}</p>
                </div>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Nilai Ujian</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ number_format($grade->nilai_ujian, 2) }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Nilai Sekolah</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ number_format($grade->nilai_sekolah, 2) }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Nilai Akhir</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ number_format($grade->nilai_akhir, 2) }}</p>
                    </div>
                </div>
                @if($grade->catatan)
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-slate-400">Catatan</p>
                        <p class="mt-2 text-sm text-slate-200">{{ $grade->catatan }}</p>
                    </div>
                @endif
            </div>

            <div class="glass-panel rounded-2xl shadow-xl p-6">
                <div class="space-y-4">
                    <a href="{{ route('admin.grades.index') }}" class="block w-full rounded-xl bg-slate-800 border border-white/10 px-4 py-3 text-center text-xs font-semibold text-slate-300 hover:bg-slate-700 transition">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>

    @push('custom_js')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Nilai?',
                text: 'Data nilai akan dihapus secara permanen!',
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
