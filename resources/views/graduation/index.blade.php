@section('title','Beranda')
<x-guest-layout>
    <div class="max-w-3xl mx-auto px-4 py-12">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <div class="text-center mb-4">
                <h3 class="font-display font-bold text-lg text-white">Pengumuman Kelulusan</h3>
                @if($activePeriod)
                    <p class="text-xs text-slate-400 mt-1">Tahun Ajaran {{ $activePeriod->tahun_ajaran }}</p>
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
                        <label class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nomor Induk Siswa Nasional (NISN)</label>
                        <input type="text" name="nis" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                        @error('nis')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 text-white text-sm font-semibold shadow-md">Cek Kelulusan</button>
                    </div>
                </form>
            @elseif($activePeriod)
                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-4 text-center">
                    <p class="text-sm text-slate-400">Pengumuman kelulusan akan dibuka pada:</p>
                    <p class="text-sm text-white font-semibold mt-2">{{ $pengumumanDateTime->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
            @else
                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-4 text-center">
                    <p class="text-sm text-slate-400">Tidak ada periode kelulusan yang aktif saat ini.</p>
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
