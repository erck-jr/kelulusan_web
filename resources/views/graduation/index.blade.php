@section('title','Beranda')
<x-guest-layout>
    <div class="w-full mx-auto px-4 py-12 max-w-3xl">
        <div class="glass-panel rounded-3xl shadow-2xl p-8 border border-school-border">
            <div class="text-center mb-6 flex flex-col items-center">
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
                <h1 class="font-display font-bold text-2xl text-slate-900 dark:text-white">Pengumuman Kelulusan</h1>
                <h2 class="font-display font-bold text-lg text-slate-700 dark:text-slate-300">{{ settings('school_name') }}</h2>
                @if($activePeriod)
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Tahun Ajaran {{ $activePeriod->tahun_ajaran }}</p>
                @endif
            </div>

            @php
                $isOpened = false;
                $pengumumanDateTime = null;
                if ($activePeriod) {
                    $pengumumanDateTime = \Carbon\Carbon::parse($activePeriod->tanggal_pengumuman->format('Y-m-d') . ' ' . ($activePeriod->jam_pengumuman ?? '00:00:00'));
                    $isOpened = now()->gte($pengumumanDateTime);
                }
            @endphp

            @if($activePeriod && $isOpened)
                <form method="POST" action="{{ route('graduation.check') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-1.5 text-left">
                        <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3">Nomor Induk Siswa Nasional (NISN)</label>
                        <input type="text" name="nis" required class="w-full rounded-2xl bg-white dark:bg-slate-950/50 border border-slate-300 dark:border-white/10 px-4 py-3 text-slate-800 dark:text-slate-200 text-sm focus:border-school-primary focus:ring-2 focus:ring-school-primary/20 outline-none transition" />
                        @error('nis')<p class="text-xs text-rose-500 dark:text-rose-400">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-school-primary to-school-accent text-white text-sm font-semibold shadow-lg shadow-school-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">Cek Kelulusan</button>
                    </div>
                </form>
            @elseif($activePeriod)
                <div class="rounded-2xl bg-white dark:bg-slate-950/60 border border-slate-200 dark:border-white/10 p-4 text-center">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Pengumuman kelulusan akan dibuka pada:</p>
                    <p class="text-sm text-slate-900 dark:text-white font-semibold mt-2">{{ $pengumumanDateTime->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
            @else
                <div class="rounded-2xl bg-white dark:bg-slate-950/60 border border-slate-200 dark:border-white/10 p-4 text-center">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada periode kelulusan yang aktif saat ini.</p>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
