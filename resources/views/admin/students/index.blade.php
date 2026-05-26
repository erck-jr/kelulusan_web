@section('title', 'Daftar Siswa')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Daftar Siswa</li>
@endsection

<x-layouts.admin-layout>
    @php
        $slugParam = ['school_slug' => request()->route('school_slug')];
    @endphp
    
    <div x-data="{ modalImportOpen: false }" class="space-y-6">
        
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                    <span class="material-icons-round text-2xl">people</span>
                </div>
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Daftar Siswa</h2>
                    <p class="text-xs text-slate-400 font-medium mt-0.5">Total terdata: <span class="text-indigo-400 font-bold">{{ $students->total() }}</span> Siswa</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3 w-auto">
                <a href="{{ route('admin.students.create', $slugParam) }}" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold text-xs tracking-wide transition-all shadow-md flex items-center justify-center space-x-1.5 cursor-pointer">
                    <span class="material-icons-round text-sm">add</span>
                    <span>Tambah Siswa</span>
                </a>
                <button @click="modalImportOpen = true" type="button" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-emerald-600/10 hover:bg-emerald-600/20 border border-emerald-500/20 hover:border-emerald-500/30 text-emerald-400 font-semibold text-xs tracking-wide transition-all flex items-center justify-center space-x-1.5 cursor-pointer">
                    <span class="material-icons-round text-sm">upload</span>
                    <span>Import Siswa</span>
                </button>
                <button id="btn-regenerate-certificates" type="button" data-url="{{ route('admin.settings.regenerate-certificates') }}" class="flex-1 md:flex-none px-4 py-2.5 rounded-xl bg-yellow-500/10 hover:bg-yellow-500/20 border border-amber-500/20 text-amber-400 font-semibold text-xs tracking-wide transition-all flex items-center justify-center space-x-1.5 cursor-pointer">
                    <span class="material-icons-round text-sm">auto_fix_high</span>
                    <span>Generate Semua Sertifikat</span>
                </button>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-slate-900/40 text-[11px] font-bold uppercase tracking-wider text-slate-400 space-y-2">
                            <th class="py-3.5 px-6">NIS</th>
                            <th class="py-3.5 px-6">Nama Lengkap</th>
                            <th class="py-3.5 px-6">Kelas</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6">Nilai Rata-rata</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($students as $student)
                            <tr class="hover:bg-white/[0.01] transition-colors group">
                                <td class="py-4 px-6 font-semibold text-indigo-400 tracking-wide">
                                    {{ $student->nis }}
                                </td>
                                <td class="py-4 px-6 font-medium text-slate-200">
                                    {{ $student->nama }}
                                </td>
                                <td class="py-4 px-6 text-slate-400">
                                    {{ $student->schoolClass->nama_kelas ?? '-' }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold tracking-wide {{ $student->status === 'LULUS' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                        {{ $student->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-mono text-slate-300">
                                    {{ number_format($student->nilai_rata_rata, 2) }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.students.show', array_merge($slugParam, ['student' => $student->id])) }}" 
                                           class="p-2 rounded-lg bg-slate-800 text-slate-400 hover:text-white border border-white/5 hover:border-white/10 transition-colors"
                                           title="Detail Siswa">
                                            <span class="material-icons-round text-sm block">visibility</span>
                                        </a>
                                        <a href="{{ route('admin.students.edit', array_merge($slugParam, ['student' => $student->id])) }}" 
                                           class="p-2 rounded-lg bg-indigo-500/5 text-indigo-400 hover:bg-indigo-500/10 border border-indigo-500/10 hover:border-indigo-500/20 transition-colors"
                                           title="Edit Siswa">
                                            <span class="material-icons-round text-sm block">edit</span>
                                        </a>
                                        <button type="button" onclick="confirmDelete('{{ $student->id }}')"
                                                class="p-2 rounded-lg bg-rose-500/5 text-rose-400 hover:bg-rose-500/10 border border-rose-500/10 hover:border-rose-500/20 transition-colors cursor-pointer"
                                                title="Hapus Siswa">
                                            <span class="material-icons-round text-sm block">delete</span>
                                        </button>

                                        <form action="{{ route('admin.students.destroy', array_merge($slugParam, ['student' => $student->id])) }}" method="POST" id="delete-form-{{ $student->id }}" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="max-w-sm mx-auto space-y-3">
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            Tidak ada data siswa pada periode aktif
                                        </span>
                                        <p class="text-xs text-slate-500">Silakan ubah konfigurasi penanggalan kelulusan atau periksa kembali data impor Anda.</p>
                                        <a href="{{ route('admin.graduation-periods.index', $slugParam) }}" class="inline-flex px-4 py-2 rounded-xl bg-slate-800 border border-white/5 hover:border-white/10 text-xs font-semibold text-slate-300 hover:text-white transition-colors cursor-pointer">
                                            Ganti Periode Aktif
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students->hasPages())
                <div class="p-4 border-t border-white/5 bg-slate-900/20 custom-pagination">
                    {{ $students->links() }}
                </div>
            @endif
        </div>

        <div x-show="modalImportOpen" 
             class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4" 
             style="display: none;">
            
            <div x-show="modalImportOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="modalImportOpen = false" 
                 class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

            <div x-show="modalImportOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-[#0F1322] border border-white/10 rounded-2xl overflow-hidden shadow-2xl max-w-md w-full z-10 transform transition-all p-6">
                
                <div class="flex items-center justify-between pb-4 border-b border-white/5">
                    <h3 class="font-display font-bold text-base text-white tracking-wide">Import Data Nilai & Siswa</h3>
                    <button @click="modalImportOpen = false" class="text-slate-400 hover:text-white transition-colors cursor-pointer">
                        <span class="material-icons-round block text-lg">close</span>
                    </button>
                </div>

                <form action="{{ route('admin.students.import', $slugParam) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
                    @csrf
                    
                    <div class="p-3.5 rounded-xl bg-indigo-500/5 border border-indigo-500/10 text-xs text-indigo-300 flex items-start space-x-2.5">
                        <span class="material-icons-round text-sm mt-0.5">info</span>
                        <span>Silakan unduh dokumen template di bawah ini, sesuaikan isi baris data tanpa merubah kolom panduan struktural.</span>
                    </div>

                    <a href="{{ route('admin.students.template', $slugParam) }}" class="w-full py-2.5 rounded-xl bg-slate-800 border border-white/5 hover:border-white/10 text-slate-300 hover:text-white font-semibold text-xs tracking-wide transition-all flex items-center justify-center space-x-2 cursor-pointer">
                        <span class="material-icons-round text-sm">download</span>
                        <span>Unduh Template Excel</span>
                    </a>

                    <div class="p-3.5 rounded-xl bg-amber-500/5 border border-amber-500/10 text-xs text-amber-400 space-y-1">
                        <h4 class="font-bold flex items-center space-x-1">
                            <span class="material-icons-round text-sm">warning</span>
                            <span>Perhatian Penting!</span>
                        </h4>
                        <p class="text-[11px] text-slate-400 leading-relaxed">Pastikan Anda telah menghapus baris baris teks contoh instruksi bawaan di dalam Excel sebelum melakukan proses unggah file.</p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pilih Berkas Excel</label>
                        <div class="w-full bg-slate-900 border border-white/10 rounded-xl px-3 py-2 text-sm text-slate-300 flex items-center relative">
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required 
                                   class="w-full bg-transparent text-xs text-slate-400 file:mr-3 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-600/20 file:text-indigo-400 hover:file:bg-indigo-600/30 file:cursor-pointer">
                        </div>
                        <span class="text-[10px] text-slate-500 block">Ekstensi dokumen yang diizinkan: .xlsx, .xls, atau .csv</span>
                    </div>

                    <div class="pt-4 border-t border-white/5 flex items-center justify-end space-x-3">
                        <button @click="modalImportOpen = false" type="button" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700/60 border border-white/5 text-slate-300 text-xs font-semibold transition-colors cursor-pointer">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white text-xs font-semibold shadow-lg transition-all cursor-pointer">Proses Import</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('custom_js')
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Proses Gagal!',
                    text: `{!! session('error') !!}`,
                    background: '#0F1322',
                    color: '#f1f5f9',
                    confirmButtonColor: '#6366f1',
                    confirmButtonText: 'Perbaiki Berkas'
                });
            });
        </script>
    @endif

    <script>
        // Fungsi Pemicu Konfirmasi Hapus Data via SweetAlert2
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Data Siswa?',
                text: "Seluruh riwayat nilai siswa terpilih akan terhapus permanen dari peladen server!",
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('btn-regenerate-certificates');
            if (!btn) return;

            btn.addEventListener('click', function (e) {
                const url = btn.getAttribute('data-url');
                if (!url) return;

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Proses ini akan meregenerasi sertifikat untuk semua siswa. Anda tidak dapat mengakses menu lain hingga proses selesai. Lanjutkan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    cancelButtonText: 'Batal',
                    background: '#0F1322',
                    color: '#f1f5f9',
                    confirmButtonColor: '#f59e0b',
                    cancelButtonColor: '#334155'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    Swal.fire({
                        title: 'Meregenerasi sertifikat...',
                        html: 'Mohon tunggu — proses dapat memakan waktu beberapa menit.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(url, { headers: { 'Accept': 'application/json' } })
                        .then(async (res) => {
                            const isJson = res.headers.get('content-type')?.includes('application/json');
                            const data = isJson ? await res.json() : null;
                            if (res.ok) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Selesai',
                                    text: (data && data.message) ? data.message : 'Sertifikat berhasil diregenerasi.',
                                    background: '#0F1322',
                                    color: '#f1f5f9',
                                    confirmButtonColor: '#10b981'
                                }).then(() => location.reload());
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: (data && data.message) ? data.message : 'Terjadi kesalahan server.',
                                    background: '#0F1322',
                                    color: '#f1f5f9',
                                    confirmButtonColor: '#ef4444'
                                });
                            }
                        })
                        .catch((err) => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan jaringan. Coba lagi.',
                                background: '#0F1322',
                                color: '#f1f5f9',
                                confirmButtonColor: '#ef4444'
                            });
                        });
                });
            });
        });
    </script>
    @endpush
</x-layouts.admin-layout>