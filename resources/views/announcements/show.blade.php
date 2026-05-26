@section('title','Detil Pengumuman')
<x-guest-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display font-bold text-lg text-white">Detail Pengumuman</h3>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-4">
                    <div>
                        <h4 class="text-xl font-semibold text-slate-100">{{ $announcement->title }}</h4>
                        <p class="text-xs text-slate-400 mt-1">Tanggal Publikasi: {{ $announcement->published_at ? $announcement->published_at->format('d/m/Y H:i') : 'Belum ditentukan' }}</p>
                    </div>

                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>

                    <div class="flex justify-start mt-4">
                        <a href="{{ route('school.announcements', ['school_slug' => request()->route('school_slug')]) }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-800 border border-white/10 px-4 py-2 text-xs font-semibold text-slate-300 hover:bg-slate-700 transition"> 
                            <span class="material-icons-round text-sm">arrow_back</span>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <h6 class="text-sm text-slate-400">Informasi Pengumuman</h6>
                        <p class="text-xs text-slate-300 mt-2"><strong>Dibuat pada:</strong><br>{{ $announcement->created_at->format('d/m/Y H:i') }}</p>
                        <p class="text-xs text-slate-300 mt-2"><strong>Terakhir diperbarui:</strong><br>{{ $announcement->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
