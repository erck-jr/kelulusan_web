@section('title', 'Hasil Kelulusan')

<x-guest-layout>
    <div class="w-full mx-auto px-4 py-12 max-w-6xl">
        <div class="text-center mb-8 flex flex-col items-center">
            @if(settings('school_logo'))
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-white p-2 flex items-center justify-center shadow-lg mb-4 overflow-hidden">
                    <img src="{{ asset('storage/' . settings('school_logo')) }}" alt="Logo {{ settings('school_name') }}" class="w-full h-full object-contain" />
                </div>
            @else
                <div class="mx-auto w-20 h-20 sm:w-24 sm:h-24 rounded-xl bg-gradient-to-tr from-school-primary to-school-accent flex items-center justify-center shadow-lg mb-4">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </div>
            @endif
            <h4 class="text-slate-900 dark:text-white text-3xl font-semibold tracking-tight">Hasil Pengumuman Kelulusan</h4>
            <p class="mt-2 text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">Lihat status kelulusan, sertifikat, dan data nilai yang sudah diinput oleh admin sekolah.</p>
        </div>

        @if ($student)
            @if(settings('announcement_header'))
            <div class="mb-8 p-4 sm:p-6 glass-panel rounded-3xl border border-school-border prose dark:prose-invert max-w-none overflow-x-auto text-sm sm:text-base text-slate-800 dark:text-slate-100">
                {!! settings('announcement_header') !!}
            </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="glass-panel rounded-3xl shadow-2xl border border-school-border p-6">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <div>
                            <h5 class="text-slate-800 dark:text-slate-200 text-lg font-semibold">Profil Siswa</h5>
                            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Informasi dasar siswa dan status kelulusan.</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-slate-200 dark:bg-slate-800/80 px-3 py-1 text-xs uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 font-semibold">{{ $student->status ? 'Lulus' : 'Tidak Lulus' }}</span>
                    </div>

                    <dl class="grid gap-4 text-sm text-slate-700 dark:text-slate-300">
                        <div class="space-y-1">
                            <dt class="text-slate-500 dark:text-slate-400">Nama Lengkap</dt>
                            <dd class="text-slate-900 dark:text-white font-medium">{{ $student->nama }}</dd>
                        </div>
                        <div class="space-y-1">
                            <dt class="text-slate-500 dark:text-slate-400">NIS</dt>
                            <dd class="text-slate-900 dark:text-white font-medium">{{ $student->nis }}</dd>
                        </div>
                        <div class="space-y-1">
                            <dt class="text-slate-500 dark:text-slate-400">Kelas</dt>
                            <dd class="text-slate-900 dark:text-white font-medium">{{ optional($student->schoolClass)->name ?? 'Tidak tersedia' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 rounded-3xl border border-slate-200 dark:border-slate-700/70 bg-white/40 dark:bg-slate-950/70 p-4">
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Status sertifikat</p>
                        @if (!empty($sertifikatPath))
                            <p class="mt-2 text-emerald-600 dark:text-emerald-300 font-semibold">Sertifikat sudah tersedia. Klik unduh untuk menyimpan file.</p>
                        @else
                            <p class="mt-2 text-amber-600 dark:text-amber-300 font-semibold">Sertifikat belum digenerate oleh admin. Silakan cek kembali nanti.</p>
                        @endif
                    </div>
                </div>

                <div class="glass-panel rounded-3xl shadow-2xl border border-school-border p-6">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <div>
                            <h5 class="text-slate-800 dark:text-slate-200 text-lg font-semibold">Sertifikat Kelulusan</h5>
                            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Tampilan cepat sertifikat jika sudah tersedia.</p>
                        </div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-school-primary/10 px-3 py-1 text-xs font-semibold text-school-primary">{{ !empty($sertifikatPath) ? 'Tersedia' : 'Belum tersedia' }}</span>
                    </div>

                    @if (!empty($sertifikatPath))
                        <div class="rounded-3xl overflow-hidden border border-school-border bg-slate-950/80">
                            <img src="{{ $sertifikatPath }}"
                                alt="Sertifikat Kelulusan"
                                class="w-full object-cover"
                                style="max-height:420px;">
                        </div>

                        <div class="flex flex-wrap gap-3 justify-center mt-6">
                            <a href="{{ $sertifikatPath }}"
                                class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-school-accent hover:scale-[1.02] active:scale-[0.98] text-white font-semibold shadow-lg shadow-school-accent/20 transition duration-300"
                                download="sertifikat-{{ $student->nis }}.jpg">
                                <span class="material-icons-round">download</span>
                                Unduh
                            </a>

                            <a href="https://wa.me/?text={{ urlencode('Halo, ini sertifikat kelulusan atas nama ' . $student->nama . ' (NIS: ' . $student->nis . '). Silakan download di sini: ' . $sertifikatPath) }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-5 py-3 rounded-full bg-emerald-600 dark:bg-emerald-500 hover:scale-[1.02] active:scale-[0.98] text-white font-semibold shadow-lg shadow-emerald-500/20 transition duration-300">
                                <span class="material-icons-round">share</span>
                                Bagikan
                            </a>
                        </div>
                    @else
                        <div class="rounded-3xl border border-amber-500/20 bg-amber-500/5 p-6 text-amber-600 dark:text-amber-200">
                            <p class="text-sm font-semibold">Sertifikat belum digenerate.</p>
                            <p class="mt-2 text-slate-500 dark:text-slate-400">Admin sekolah harus melakukan generate ulang sertifikat terlebih dahulu.</p>
                        </div>
                    @endif

                    <div class="mt-6 text-right">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-300 dark:border-slate-700/80 bg-white dark:bg-slate-900/80 px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            <span class="material-icons-round">home</span>
                            Kembali ke beranda
                        </a>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-3xl shadow-2xl border border-school-border p-6 mt-8">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h5 class="text-slate-800 dark:text-slate-200 text-lg font-semibold">Data Nilai</h5>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Data nilai yang diinput oleh admin sekolah untuk siswa ini.</p>
                    </div>
                    <span class="inline-flex items-center rounded-full bg-slate-200 dark:bg-slate-800/80 px-3 py-1 text-xs uppercase tracking-[0.2em] text-slate-700 dark:text-slate-300 font-semibold">{{ $student->grades->count() }} mata pelajaran</span>
                </div>

                @if ($student->grades->isNotEmpty())
                    <div class="overflow-x-auto rounded-3xl border border-slate-200 dark:border-slate-700/70 bg-white/40 dark:bg-slate-950/80">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm text-left text-slate-700 dark:text-slate-300">
                            <thead class="bg-slate-100 dark:bg-slate-900/90 text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-550">
                                <tr>
                                    <th class="px-4 py-4">Mata Pelajaran</th>
                                    <th class="px-4 py-4">Nilai Sekolah</th>
                                    <th class="px-4 py-4">Nilai Ujian</th>
                                    <th class="px-4 py-4">Nilai Akhir</th>
                                    <th class="px-4 py-4">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white/20 dark:bg-slate-900/80">
                                @foreach ($student->grades as $grade)
                                    <tr class="hover:bg-slate-100/50 dark:hover:bg-slate-800/80 transition-colors">
                                        <td class="px-4 py-4 text-slate-900 dark:text-white font-medium">{{ $grade->mata_pelajaran }}</td>
                                        <td class="px-4 py-4">{{ $grade->nilai_sekolah ?? '-' }}</td>
                                        <td class="px-4 py-4">{{ $grade->nilai_ujian ?? '-' }}</td>
                                        <td class="px-4 py-4 font-semibold text-school-primary">{{ $grade->nilai_akhir ?? '-' }}</td>
                                        <td class="px-4 py-4 text-slate-500 dark:text-slate-400">{{ $grade->catatan ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="rounded-3xl border border-slate-200 dark:border-slate-700/70 bg-white/40 dark:bg-slate-950/80 p-6 text-slate-700 dark:text-slate-300">
                        <p class="font-semibold text-slate-900 dark:text-slate-100">Data nilai dalam proses input admin.</p>
                        <p class="mt-2 text-slate-500 dark:text-slate-400">Nilai belum tersedia. Mohon cek kembali nanti setelah admin sekolah selesai memasukkan data.</p>
                    </div>
                @endif
            </div>

            @if(settings('announcement_footer'))
            <div class="mt-8 p-4 sm:p-6 glass-panel rounded-3xl border border-school-border prose dark:prose-invert max-w-none overflow-x-auto text-sm sm:text-base text-slate-800 dark:text-slate-100">
                {!! settings('announcement_footer') !!}
            </div>
            @endif
        @else
            <div class="glass-panel rounded-3xl shadow-2xl border border-school-border p-8 text-center">
                <p class="text-slate-500 dark:text-slate-400">Siswa tidak ditemukan.</p>
            </div>
        @endif
    </div>
</x-guest-layout>