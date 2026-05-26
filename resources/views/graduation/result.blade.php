<!-- resources/views/graduation/result.blade.php -->

@section('title', 'Hasil Kelulusan')

<x-guest-layout>
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="text-center mb-8">
            <h4 class="text-white text-3xl font-semibold tracking-tight">Hasil Pengumuman Kelulusan</h4>
            <p class="mt-2 text-slate-400 max-w-2xl mx-auto">Lihat status kelulusan, sertifikat, dan data nilai yang sudah diinput oleh admin sekolah.</p>
        </div>

        @if ($student)
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="glass-panel rounded-3xl shadow-2xl border border-white/10 p-6">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <div>
                            <h5 class="text-slate-200 text-lg font-semibold">Profil Siswa</h5>
                            <p class="text-slate-400 text-sm mt-1">Informasi dasar siswa dan status kelulusan.</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-slate-800/80 px-3 py-1 text-xs uppercase tracking-[0.2em] text-slate-300">{{ $student->status ? 'Lulus' : 'Tidak Lulus' }}</span>
                    </div>

                    <dl class="grid gap-4 text-sm text-slate-300">
                        <div class="space-y-1">
                            <dt class="text-slate-400">Nama Lengkap</dt>
                            <dd class="text-white">{{ $student->nama }}</dd>
                        </div>
                        <div class="space-y-1">
                            <dt class="text-slate-400">NIS</dt>
                            <dd class="text-white">{{ $student->nis }}</dd>
                        </div>
                        <div class="space-y-1">
                            <dt class="text-slate-400">Kelas</dt>
                            <dd class="text-white">{{ optional($student->schoolClass)->name ?? 'Tidak tersedia' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 rounded-3xl border border-slate-700/70 bg-slate-950/70 p-4">
                        <p class="text-slate-400 text-sm">Status sertifikat</p>
                        @if (!empty($sertifikatPath))
                            <p class="mt-2 text-emerald-300 font-semibold">Sertifikat sudah tersedia. Klik unduh untuk menyimpan file.</p>
                        @else
                            <p class="mt-2 text-amber-300 font-semibold">Sertifikat belum digenerate oleh admin. Silakan cek kembali nanti.</p>
                        @endif
                    </div>
                </div>

                <div class="glass-panel rounded-3xl shadow-2xl border border-white/10 p-6">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <div>
                            <h5 class="text-slate-200 text-lg font-semibold">Sertifikat Kelulusan</h5>
                            <p class="text-slate-400 text-sm mt-1">Tampilan cepat sertifikat jika sudah tersedia.</p>
                        </div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-200">{{ !empty($sertifikatPath) ? 'Tersedia' : 'Belum tersedia' }}</span>
                    </div>

                    @if (!empty($sertifikatPath))
                        <div class="rounded-3xl overflow-hidden border border-white/10 bg-slate-950/80">
                            <img src="{{ $sertifikatPath }}"
                                alt="Sertifikat Kelulusan"
                                class="w-full object-cover"
                                style="max-height:420px;">
                        </div>

                        <div class="flex flex-wrap gap-3 justify-center mt-6">
                            <a href="{{ $sertifikatPath }}"
                                class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-amber-500 text-slate-950 font-semibold shadow-lg shadow-amber-500/20"
                                download="sertifikat-{{ $student->nis }}.jpg">
                                <span class="material-icons-round">download</span>
                                Unduh
                            </a>

                            <a href="https://wa.me/?text={{ urlencode('Halo, ini sertifikat kelulusan atas nama ' . $student->nama . ' (NIS: ' . $student->nis . '). Silakan download di sini: ' . $sertifikatPath) }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-emerald-500 text-slate-950 font-semibold shadow-lg shadow-emerald-500/20">
                                <span class="material-icons-round">share</span>
                                Bagikan
                            </a>
                        </div>
                    @else
                        <div class="rounded-3xl border border-amber-500/20 bg-amber-500/5 p-6 text-amber-200">
                            <p class="text-sm font-semibold">Sertifikat belum digenerate.</p>
                            <p class="mt-2 text-slate-400">Admin sekolah harus melakukan generate ulang sertifikat terlebih dahulu.</p>
                        </div>
                    @endif

                    <div class="mt-6 text-right">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-700/80 bg-slate-900/80 px-4 py-2 text-sm text-slate-200 hover:bg-slate-800 transition">
                            <span class="material-icons-round">home</span>
                            Kembali ke beranda
                        </a>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-3xl shadow-2xl border border-white/10 p-6 mt-8">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h5 class="text-slate-200 text-lg font-semibold">Data Nilai</h5>
                        <p class="text-slate-400 text-sm mt-1">Data nilai yang diinput oleh admin sekolah untuk siswa ini.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-slate-800/80 px-3 py-1 text-xs uppercase tracking-[0.2em] text-slate-300">{{ $student->grades->count() }} mata pelajaran</span>
                </div>

                @if ($student->grades->isNotEmpty())
                    <div class="overflow-x-auto rounded-3xl border border-slate-700/70 bg-slate-950/80">
                        <table class="min-w-full divide-y divide-slate-700 text-sm text-left text-slate-300">
                            <thead class="bg-slate-900/90 text-xs uppercase tracking-[0.2em] text-slate-500">
                                <tr>
                                    <th class="px-4 py-4">Mata Pelajaran</th>
                                    <th class="px-4 py-4">Nilai Sekolah</th>
                                    <th class="px-4 py-4">Nilai Ujian</th>
                                    <th class="px-4 py-4">Nilai Akhir</th>
                                    <th class="px-4 py-4">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700 bg-slate-900/80">
                                @foreach ($student->grades as $grade)
                                    <tr class="hover:bg-slate-800/80 transition-colors">
                                        <td class="px-4 py-4 text-white">{{ $grade->mata_pelajaran }}</td>
                                        <td class="px-4 py-4">{{ $grade->nilai_sekolah ?? '-' }}</td>
                                        <td class="px-4 py-4">{{ $grade->nilai_ujian ?? '-' }}</td>
                                        <td class="px-4 py-4 font-semibold text-emerald-300">{{ $grade->nilai_akhir ?? '-' }}</td>
                                        <td class="px-4 py-4 text-slate-400">{{ $grade->catatan ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="rounded-3xl border border-slate-700/70 bg-slate-950/80 p-6 text-slate-300">
                        <p class="font-semibold text-slate-100">Data nilai dalam proses input admin.</p>
                        <p class="mt-2 text-slate-400">Nilai belum tersedia. Mohon cek kembali nanti setelah admin sekolah selesai memasukkan data.</p>
                    </div>
                @endif
            </div>
        @else
            <div class="glass-panel rounded-3xl shadow-2xl border border-white/10 p-8 text-center">
                <p class="text-slate-400">Siswa tidak ditemukan.</p>
            </div>
        @endif
    </div>
</x-guest-layout>