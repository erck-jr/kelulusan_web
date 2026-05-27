@section('title', 'Pengaturan Aplikasi')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Pengaturan Aplikasi</li>
@endsection

@php
    $groupMeta = [
        'general'      => ['label' => 'Umum',              'icon' => 'settings',           'desc' => 'Pengaturan dasar aplikasi seperti nama dan identitas.'],
        'school'       => ['label' => 'Profil Sekolah',    'icon' => 'school',             'desc' => 'Informasi profil dan branding sekolah.'],
        'academic'     => ['label' => 'Akademik & Nilai',  'icon' => 'grading',            'desc' => 'Konfigurasi terkait penilaian dan kelulusan.'],
        'announcement' => ['label' => 'Pengumuman',        'icon' => 'campaign',           'desc' => 'Atur jadwal dan konten pengumuman kelulusan.'],
        'sertifikat'   => ['label' => 'Sertifikat',        'icon' => 'workspace_premium',  'desc' => 'Template dan pengaturan sertifikat kelulusan.'],
        'appearance'   => ['label' => 'Desain Tampilan',   'icon' => 'palette',            'desc' => 'Sesuaikan warna, font, dan tampilan halaman siswa.'],
    ];
@endphp

<x-layouts.admin-layout>
    {{-- Inline styles for this page --}}
    <style>
        /* Panel animation */
        @keyframes settingsFadeSlideIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .settings-panel-enter {
            animation: settingsFadeSlideIn 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        /* Tab active indicator */
        .settings-tab-item {
            position: relative;
            transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .settings-tab-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 3px;
            height: 60%;
            border-radius: 0 4px 4px 0;
            background: linear-gradient(180deg, #6366f1, #8b5cf6);
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .settings-tab-item.active::before {
            transform: translateY(-50%) scaleY(1);
        }
        .settings-tab-item.active {
            background: linear-gradient(135deg, rgba(99,102,241,0.12), rgba(139,92,246,0.08));
            border-color: rgba(99,102,241,0.25);
        }
        .settings-tab-item:not(.active):hover {
            background: rgba(255,255,255,0.03);
            border-color: rgba(255,255,255,0.08);
        }

        /* Mobile tab pills */
        .settings-tab-pill {
            transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
            white-space: nowrap;
        }
        .settings-tab-pill.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(99,102,241,0.25);
        }
        .settings-tab-pill:not(.active):hover {
            background: rgba(255,255,255,0.06);
            border-color: rgba(255,255,255,0.12);
        }

        /* Hide scrollbar on mobile tab strip */
        .settings-mobile-tabs::-webkit-scrollbar { display: none; }
        .settings-mobile-tabs { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="space-y-6">
        {{-- Page Header --}}
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display font-bold text-xl text-white tracking-wide">Pengaturan Aplikasi</h2>
                <p class="text-xs text-slate-400 mt-1">Sesuaikan konfigurasi aplikasi tanpa mengubah proses bisnis.</p>
            </div>
        </div>

        {{-- Main Form --}}
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Mobile Tab Navigation (horizontal pills, visible < lg) --}}
            <div class="lg:hidden mb-4">
                <div class="settings-mobile-tabs flex gap-2 overflow-x-auto pb-2 px-1">
                    @foreach($groups as $index => $group)
                        @php $meta = $groupMeta[$group] ?? ['label' => ucfirst($group), 'icon' => 'settings', 'desc' => '']; @endphp
                        <button
                            type="button"
                            data-settings-tab="{{ $group }}"
                            class="settings-tab-pill flex items-center gap-2 px-4 py-2.5 rounded-xl border border-white/10 bg-slate-900/60 text-xs font-semibold text-slate-300 {{ $index === 0 ? 'active' : '' }}"
                        >
                            <span class="material-icons-round text-sm">{{ $meta['icon'] }}</span>
                            <span>{{ $meta['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Split Panel Layout --}}
            <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
                <div class="flex flex-col lg:flex-row min-h-[520px]">

                    {{-- Desktop Sidebar Tabs (hidden < lg) --}}
                    <div class="hidden lg:flex flex-col w-64 shrink-0 border-r border-white/[0.06] bg-slate-950/30 py-3">
                        <div class="px-5 py-3 mb-1">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-500">Kelompok Pengaturan</p>
                        </div>
                        <nav class="flex-1 flex flex-col gap-1 px-2">
                            @foreach($groups as $index => $group)
                                @php $meta = $groupMeta[$group] ?? ['label' => ucfirst($group), 'icon' => 'settings', 'desc' => '']; @endphp
                                <button
                                    type="button"
                                    data-settings-tab="{{ $group }}"
                                    class="settings-tab-item flex items-center gap-3 w-full text-left px-4 py-3 rounded-xl border border-transparent text-sm {{ $index === 0 ? 'active' : '' }}"
                                >
                                    <span class="material-icons-round text-lg {{ $index === 0 ? 'text-indigo-400' : 'text-slate-500' }}">{{ $meta['icon'] }}</span>
                                    <div class="min-w-0">
                                        <p class="font-semibold truncate {{ $index === 0 ? 'text-white' : 'text-slate-300' }}">{{ $meta['label'] }}</p>
                                    </div>
                                </button>
                            @endforeach
                        </nav>
                    </div>

                    {{-- Content Area --}}
                    <div class="flex-1 flex flex-col min-w-0">
                        @foreach($groups as $index => $group)
                            @php $meta = $groupMeta[$group] ?? ['label' => ucfirst($group), 'icon' => 'settings', 'desc' => '']; @endphp

                            <div
                                id="settings-panel-{{ $group }}"
                                data-settings-panel="{{ $group }}"
                                class="flex-1 flex flex-col {{ $index !== 0 ? 'hidden' : 'settings-panel-enter' }}"
                            >
                                {{-- Section Header --}}
                                <div class="px-6 pt-6 pb-4 border-b border-white/[0.06]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500/20 to-violet-500/20 border border-indigo-500/20 flex items-center justify-center">
                                            <span class="material-icons-round text-indigo-400">{{ $meta['icon'] }}</span>
                                        </div>
                                        <div>
                                            <h3 class="text-base font-bold text-white">{{ $meta['label'] }}</h3>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $meta['desc'] }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section Body --}}
                                <div class="flex-1 p-6 overflow-y-auto">
                                    @if($group === 'appearance')
                                        {{-- Appearance: 2-column with live mockup --}}
                                        <div class="grid gap-6 lg:grid-cols-12">
                                            {{-- Form Fields Column --}}
                                            <div class="space-y-6 lg:col-span-7">
                                                @foreach($settings[$group] as $setting)
                                                    <div class="space-y-2">
                                                        <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $setting->label }}</label>
                                                        
                                                        @if(in_array($setting->key, ['theme_primary_color', 'theme_accent_color']))
                                                            <div class="flex gap-3">
                                                                <input type="color" id="picker-{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" class="h-11 w-14 rounded-xl border border-white/10 bg-slate-950/50 cursor-pointer p-1 transition duration-200" oninput="document.getElementById('input-{{ $setting->key }}').value = this.value; window.updateMockup();" />
                                                                <input type="text" id="input-{{ $setting->key }}" name="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}" class="flex-1 rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" oninput="document.getElementById('picker-{{ $setting->key }}').value = this.value; window.updateMockup();" />
                                                            </div>
                                                        @elseif($setting->key === 'theme_bg_mode')
                                                            <select name="{{ $setting->key }}" id="select-{{ $setting->key }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" onchange="window.updateMockup();">
                                                                <option value="dark" {{ old($setting->key, $setting->value) === 'dark' ? 'selected' : '' }}>Gelap Premium (Dark Mode)</option>
                                                                <option value="light" {{ old($setting->key, $setting->value) === 'light' ? 'selected' : '' }}>Terang Bersih (Light Mode)</option>
                                                            </select>
                                                        @elseif($setting->key === 'theme_font_family')
                                                            <select name="{{ $setting->key }}" id="select-{{ $setting->key }}" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" onchange="window.updateMockup();">
                                                                @foreach(['Plus Jakarta Sans', 'Inter', 'Roboto', 'Outfit', 'Poppins', 'Montserrat', 'Open Sans', 'Playfair Display', 'Lora', 'Merriweather'] as $font)
                                                                    <option value="{{ $font }}" {{ old($setting->key, $setting->value) === $font ? 'selected' : '' }}>{{ $font }}</option>
                                                                @endforeach
                                                            </select>
                                                        @elseif($setting->type === 'image')
                                                            <div class="rounded-2xl border border-white/10 bg-slate-900/50 p-4">
                                                                @if($setting->value)
                                                                    <img id="preview-image-{{ $setting->key }}" src="{{ Storage::url($setting->value) }}" alt="{{ $setting->label }}" class="h-24 w-full object-contain rounded-xl mb-3" />
                                                                @endif
                                                                <input type="file" name="{{ $setting->key }}" accept="image/*" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" onchange="window.previewHeroBg(this);" />
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

                                            {{-- Live Mockup Column --}}
                                            <div class="lg:col-span-5 flex flex-col justify-start border-t border-white/5 pt-6 lg:border-t-0 lg:pt-0 mt-6 lg:mt-0">
                                                <label class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">Pratinjau Live Tampilan Halaman Siswa</label>
                                                <div id="mockup-container" data-bg="{{ settings('theme_hero_bg') ? Storage::url(settings('theme_hero_bg')) : '' }}" class="rounded-3xl border border-white/10 shadow-2xl p-6 transition-all duration-500 aspect-[9/14] flex flex-col justify-between relative overflow-hidden" style="max-height: 480px;">
                                                    <!-- Decorative Blurs -->
                                                    <div id="mockup-blur-1" class="absolute top-[-20%] left-[-20%] w-[80%] h-[80%] rounded-full opacity-20 blur-[60px] pointer-events-none transition-colors duration-500"></div>
                                                    <div id="mockup-blur-2" class="absolute bottom-[-20%] right-[-20%] w-[80%] h-[80%] rounded-full opacity-20 blur-[60px] pointer-events-none transition-colors duration-500"></div>

                                                    <div class="z-10 flex flex-col items-center text-center mt-6">
                                                        <!-- Logo Mockup -->
                                                        <div id="mockup-logo-container" class="w-16 h-16 rounded-xl flex items-center justify-center shadow-lg mb-3 bg-white p-1 overflow-hidden">
                                                            @if(settings('school_logo'))
                                                                <img src="{{ Storage::url(settings('school_logo')) }}" alt="Logo" class="w-full h-full object-contain" />
                                                            @else
                                                                <div id="mockup-logo-fallback" class="w-full h-full rounded-lg flex items-center justify-center text-white">
                                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        
                                                        <!-- School Info -->
                                                        <h1 id="mockup-title" class="font-bold text-sm tracking-wide transition-all duration-300">Pengumuman Kelulusan</h1>
                                                        <h2 id="mockup-school-name" class="font-bold text-xs mt-0.5 transition-all duration-300">{{ settings('school_name') }}</h2>
                                                        <p class="text-[10px] opacity-60 mt-0.5">Tahun Ajaran 2025/2026</p>
                                                    </div>

                                                    <!-- Input Field Mockup -->
                                                    <div class="z-10 my-4 space-y-3">
                                                        <div class="space-y-1 text-left">
                                                            <span class="text-[9px] font-bold uppercase tracking-wider opacity-60">Nomor Induk Siswa Nasional (NISN)</span>
                                                            <div id="mockup-input" class="w-full rounded-xl border border-white/10 px-3 py-2 text-xs opacity-60 bg-slate-900/40">1234567890</div>
                                                        </div>
                                                        <button type="button" id="mockup-button" class="w-full py-2.5 rounded-xl text-white text-xs font-semibold transition-all duration-500 shadow-md">
                                                            Cek Kelulusan
                                                        </button>
                                                    </div>

                                                    <!-- Footer Mockup -->
                                                    <div class="z-10 text-[9px] opacity-40 text-center mb-2">
                                                        Sistem Informasi Kelulusan © 2026
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Standard group: 2-column grid --}}
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
                                    @endif
                                </div>

                                {{-- Section Footer with Save Button --}}
                                <div class="px-6 py-4 border-t border-white/[0.06] bg-slate-950/20 flex justify-end">
                                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 text-white text-xs font-semibold shadow-lg shadow-indigo-500/20 hover:shadow-indigo-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200">
                                        <span class="material-icons-round text-sm">save</span>
                                        Simpan Pengaturan
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </form>
    </div>

@push('custom_js')
<script>
    // ─── Tab Navigation Logic ───────────────────────────────────
    (function() {
        function switchTab(groupKey) {
            // Update all tab buttons (both desktop sidebar & mobile pills)
            document.querySelectorAll('[data-settings-tab]').forEach(function(btn) {
                const isTarget = btn.getAttribute('data-settings-tab') === groupKey;

                // Toggle active class
                btn.classList.toggle('active', isTarget);

                // Update icon color for desktop tabs
                const icon = btn.querySelector('.material-icons-round');
                if (icon && btn.classList.contains('settings-tab-item')) {
                    icon.classList.toggle('text-indigo-400', isTarget);
                    icon.classList.toggle('text-slate-500', !isTarget);
                }

                // Update label color for desktop tabs
                const label = btn.querySelector('p');
                if (label && btn.classList.contains('settings-tab-item')) {
                    label.classList.toggle('text-white', isTarget);
                    label.classList.toggle('text-slate-300', !isTarget);
                }
            });

            // Show/hide content panels
            document.querySelectorAll('[data-settings-panel]').forEach(function(panel) {
                const isTarget = panel.getAttribute('data-settings-panel') === groupKey;
                if (isTarget) {
                    panel.classList.remove('hidden');
                    // Re-trigger animation
                    panel.classList.remove('settings-panel-enter');
                    // Force reflow to restart animation
                    void panel.offsetWidth;
                    panel.classList.add('settings-panel-enter');
                } else {
                    panel.classList.add('hidden');
                    panel.classList.remove('settings-panel-enter');
                }
            });

            // Update URL hash (without scrolling)
            history.replaceState(null, '', '#' + groupKey);

            // Scroll mobile pill into view if needed
            const mobilePill = document.querySelector('.settings-mobile-tabs [data-settings-tab="' + groupKey + '"]');
            if (mobilePill) {
                mobilePill.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }

            // Re-init mockup if switching to appearance
            if (groupKey === 'appearance' && typeof window.updateMockup === 'function') {
                setTimeout(function() { window.updateMockup(); }, 50);
            }
        }

        // Attach click handlers
        document.querySelectorAll('[data-settings-tab]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                switchTab(this.getAttribute('data-settings-tab'));
            });
        });

        // On page load: check URL hash or default to first group
        function initTabs() {
            var hash = window.location.hash.replace('#', '');
            var validPanel = hash && document.querySelector('[data-settings-panel="' + hash + '"]');
            if (validPanel) {
                switchTab(hash);
            }
            // else: first tab is already active by default from Blade
        }

        // Listen for hash changes (e.g. browser back/forward)
        window.addEventListener('hashchange', function() {
            var hash = window.location.hash.replace('#', '');
            if (hash && document.querySelector('[data-settings-panel="' + hash + '"]')) {
                switchTab(hash);
            }
        });

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initTabs);
        } else {
            initTabs();
        }
    })();

    // ─── Live Mockup Logic (Appearance Tab) ─────────────────────
    window.updateMockup = function() {
        try {
            const primaryInput = document.getElementById('input-theme_primary_color');
            const accentInput = document.getElementById('input-theme_accent_color');
            const bgModeSelect = document.getElementById('select-theme_bg_mode');
            const fontSelect = document.getElementById('select-theme_font_family');
            
            if (!primaryInput || !accentInput || !bgModeSelect || !fontSelect) return;

            const primary = primaryInput.value;
            const accent = accentInput.value;
            const bgMode = bgModeSelect.value;
            const font = fontSelect.value;
            
            const container = document.getElementById('mockup-container');
            const blur1 = document.getElementById('mockup-blur-1');
            const blur2 = document.getElementById('mockup-blur-2');
            const button = document.getElementById('mockup-button');
            const title = document.getElementById('mockup-title');
            const schoolName = document.getElementById('mockup-school-name');
            const logoFallback = document.getElementById('mockup-logo-fallback');
            const mockupInput = document.getElementById('mockup-input');
            
            if (container) {
                container.style.fontFamily = `'${font}', sans-serif`;
            }
            
            // Tentukan overlay background berdasarkan mode gelap/terang
            const isLight = bgMode === 'light';
            const overlayColor = isLight ? 'rgba(248, 250, 252, 0.9)' : 'rgba(11, 15, 25, 0.92)';
            
            if (container && title && schoolName && mockupInput) {
                if (isLight) {
                    container.style.backgroundColor = '#F8FAFC';
                    container.style.color = '#1E293B';
                    container.style.borderColor = 'rgba(0, 0, 0, 0.08)';
                    title.style.color = '#0F172A';
                    schoolName.style.color = '#334155';
                    mockupInput.style.backgroundColor = 'rgba(0, 0, 0, 0.03)';
                    mockupInput.style.color = '#1E293B';
                    mockupInput.style.borderColor = 'rgba(0, 0, 0, 0.08)';
                } else {
                    container.style.backgroundColor = '#0B0F19';
                    container.style.color = '#F1F5F9';
                    container.style.borderColor = 'rgba(255, 255, 255, 0.06)';
                    title.style.color = '#FFFFFF';
                    schoolName.style.color = '#CBD5E1';
                    mockupInput.style.backgroundColor = 'rgba(15, 23, 42, 0.45)';
                    mockupInput.style.color = '#F1F5F9';
                    mockupInput.style.borderColor = 'rgba(255, 255, 255, 0.06)';
                }
                
                // Pasang background image jika ada data-bg
                const heroBgUrl = container.getAttribute('data-bg');
                if (heroBgUrl) {
                    container.style.backgroundImage = `linear-gradient(to bottom, ${overlayColor}, ${overlayColor}), url('${heroBgUrl}')`;
                    container.style.backgroundSize = 'cover';
                    container.style.backgroundPosition = 'center';
                } else {
                    container.style.backgroundImage = '';
                }
            }
            
            if (blur1) blur1.style.backgroundColor = primary;
            if (blur2) blur2.style.backgroundColor = accent;
            
            if (button) {
                button.style.background = `linear-gradient(135deg, ${primary}, ${accent})`;
                button.style.boxShadow = `0 4px 14px 0 ${primary}33`;
            }
            
            if (logoFallback) {
                logoFallback.style.background = `linear-gradient(135deg, ${primary}, ${accent})`;
            }
        } catch (error) {
            console.error('Error updating mockup:', error);
        }
    }

    window.previewHeroBg = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById('mockup-container');
                if (container) {
                    container.setAttribute('data-bg', e.target.result);
                    window.updateMockup();
                }
                const imgPreview = document.getElementById('preview-image-theme_hero_bg');
                if (imgPreview) {
                    imgPreview.src = e.target.result;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function initMockup() {
        if (document.getElementById('input-theme_primary_color')) {
            // Load custom fonts dynamically untuk pratinjau dropdown list
            const fonts = ['Plus Jakarta Sans', 'Inter', 'Roboto', 'Outfit', 'Poppins', 'Montserrat', 'Open Sans', 'Playfair Display', 'Lora', 'Merriweather'];
            fonts.forEach(font => {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = `https://fonts.googleapis.com/css2?family=${font.replace(/ /g, '+')}:wght@400;500;600;700&display=swap`;
                document.head.appendChild(link);
            });
            
            // Set initial mockup dari seting saat ini
            window.updateMockup();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMockup);
    } else {
        initMockup();
    }
</script>
@endpush
</x-layouts.admin-layout>
