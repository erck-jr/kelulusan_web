@section('title', 'Pengaturan Aplikasi')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Pengaturan Aplikasi</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display font-bold text-xl text-white tracking-wide">Pengaturan Aplikasi</h2>
                <p class="text-xs text-slate-400 mt-1">Sesuaikan konfigurasi aplikasi tanpa mengubah proses bisnis.</p>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-sm font-semibold text-white">Kelompok Pengaturan</h3>
                                <p class="text-xs text-slate-400">Pilih grup pengaturan untuk menampilkan opsi yang sesuai.</p>
                            </div>
                        </div>

                        <div class="mt-5 grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach($groups as $index => $group)
                                <button type="button" class="group rounded-2xl border border-white/10 bg-slate-900/70 px-4 py-3 text-left transition hover:border-indigo-500/30 {{ $index === 0 ? 'ring-2 ring-indigo-500/40 bg-indigo-500/10 border-indigo-500/20' : '' }}" onclick="document.getElementById('tab-{{ $group }}').scrollIntoView({ behavior: 'smooth', block: 'start' })">
                                    <p class="text-xs uppercase tracking-wide text-slate-400 group-hover:text-white">{{ ucfirst($group) }}</p>
                                    <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $group }}</p>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-8">
                        @foreach($groups as $index => $group)
                            <div id="tab-{{ $group }}" class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                                <h3 class="text-sm font-semibold text-white mb-4">{{ ucfirst($group) }}</h3>
                                <div class="grid gap-6 lg:grid-cols-2">
                                    @foreach($settings[$group] as $setting)
                                        <div class="space-y-2">
                                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $setting->label }}</label>
                                            @if(in_array($setting->type, ['text','number']))
                                                <input type="{{ $setting->type }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                                            @elseif($setting->type === 'image' || $setting->type === 'template')
                                                <div class="rounded-2xl border border-white/10 bg-slate-900/50 p-4">
                                                    @if($setting->value)
                                                        <img src="{{ Storage::url($setting->value) }}" alt="{{ $setting->label }}" class="h-24 w-full object-contain rounded-xl mb-3" />
                                                    @endif
                                                    <input type="file" name="{{ $setting->key }}" accept="image/*" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                                                    @if($setting->type === 'template' && $setting->value)
                                                        <a href="{{ route('admin.settings.certificate-preview') }}" target="_blank" class="inline-flex items-center gap-2 mt-3 rounded-xl bg-indigo-500/10 px-3 py-2 text-xs font-semibold text-indigo-300 border border-indigo-500/20 hover:bg-indigo-500/15 transition">Cek Hasil Sertifikat</a>
                                                    @endif
                                                </div>
                                            @endif
                                            @if($setting->description)
                                                <p class="text-xs text-slate-500">{{ $setting->description }}</p>
                                            @endif
                                            @error($setting->key)
                                                <p class="text-xs text-rose-400">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex flex-wrap gap-3 justify-end">
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 text-white text-xs font-semibold transition shadow-md">Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
