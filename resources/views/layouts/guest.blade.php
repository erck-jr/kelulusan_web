<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ settings('theme_bg_mode', 'dark') === 'light' ? '' : 'dark' }} scroll-smooth">
<head>
    @include('partials.head')
    @php
        $primaryColor = settings('theme_primary_color', '#6366f1');
        $accentColor = settings('theme_accent_color', '#8b5cf6');
        $bgMode = settings('theme_bg_mode', 'dark');
        $fontFamily = settings('theme_font_family', 'Outfit');
        $heroBg = settings('theme_hero_bg');

        $isLightMode = $bgMode === 'light';
        $bgColor = $isLightMode ? '#F8FAFC' : '#0B0F19';
        $bgPanel = $isLightMode ? 'rgba(255, 255, 255, 0.7)' : 'rgba(15, 23, 42, 0.45)';
        $borderVal = $isLightMode ? 'rgba(0, 0, 0, 0.08)' : 'rgba(255, 255, 255, 0.06)';
        
        $fonts = [
            'Plus Jakarta Sans' => 'family=Plus+Jakarta+Sans:wght@400;500;600;700',
            'Inter' => 'family=Inter:wght@400;500;600;700',
            'Roboto' => 'family=Roboto:wght@400;500;700',
            'Outfit' => 'family=Outfit:wght@400;600;700;800',
            'Poppins' => 'family=Poppins:wght@400;500;600;700',
            'Montserrat' => 'family=Montserrat:wght@400;500;600;700',
            'Open Sans' => 'family=Open+Sans:wght@400;500;600;700',
            'Playfair Display' => 'family=Playfair+Display:wght@400;600;700',
            'Lora' => 'family=Lora:wght@400;500;600;700',
            'Merriweather' => 'family=Merriweather:wght@400;700'
        ];
        
        $fontParam = $fonts[$fontFamily] ?? 'family=Outfit:wght@400;600;700;800';
    @endphp

    <link href="https://fonts.googleapis.com/css2?{{ $fontParam }}&display=swap" rel="stylesheet">

    <style>
        :root {
            --school-primary: {{ $primaryColor }};
            --school-accent: {{ $accentColor }};
            --school-bg: {{ $bgColor }};
            --school-bg-panel: {{ $bgPanel }};
            --school-border: {{ $borderVal }};
        }
        body {
            font-family: '{{ $fontFamily }}', sans-serif;
        }
        .font-display {
            font-family: '{{ $fontFamily }}', sans-serif;
        }
        .glass-panel {
            background: var(--school-bg-panel);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--school-border);
        }
        .glass {
            background: var(--school-bg-panel);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--school-border);
        }
        @if($heroBg)
        .custom-hero-bg {
            background-image: linear-gradient(to bottom, {{ $isLightMode ? 'rgba(248, 250, 252, 0.85)' : 'rgba(11, 15, 25, 0.92)' }}, {{ $isLightMode ? 'rgba(248, 250, 252, 0.95)' : 'rgba(11, 15, 25, 0.98)' }}), url('{{ Storage::url($heroBg) }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        @endif
    </style>
</head>
<body class="bg-school-bg {{ $isLightMode ? 'text-slate-800' : 'text-slate-100' }} min-h-screen overflow-x-hidden relative flex flex-col justify-between {{ $heroBg ? 'custom-hero-bg' : '' }}">
    
    <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-school-primary/10 blur-[120px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50vw] h-[50vw] rounded-full bg-school-accent/10 blur-[120px] pointer-events-none -z-10"></div>

    @include('partials.navbar')

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 py-24 lg:py-32 flex flex-col justify-center items-center z-10 w-full">
        <div class="w-full flex flex-col items-center">
            {{ $slot }}
        </div>
    </main>

    @include('partials.footer')

    @include('partials.scripts')
    @stack('custom_js')
</body>
</html>