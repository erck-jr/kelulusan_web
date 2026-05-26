<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    @include('partials.head')
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-display {
            font-family: 'Outfit', sans-serif;
        }
        .glass-panel {
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }
        /* Custom scrollbar untuk kemewahan tema gelap */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0B0F19;
        }
        ::-webkit-scrollbar-thumb {
            background: #1E293B;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #334155;
        }
    </style>
</head>

<body class="bg-[#0B0F19] text-slate-100 min-h-screen overflow-x-hidden relative flex">

    <div class="absolute top-[-20%] left-[-10%] w-[60vw] h-[60vw] rounded-full bg-indigo-950/10 blur-[140px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50vw] h-[50vw] rounded-full bg-purple-950/10 blur-[140px] pointer-events-none -z-10"></div>

    @include('partials.admin.sidebar')

    <div class="flex-1 flex flex-col min-w-0 min-h-screen lg:max-w-[calc(100%-16rem)] lg:ml-64 transition-all duration-300">
        
        @include('partials.admin.navbar')

        <main class="flex-grow p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto z-10">
            {{ $slot }}
        </main>

        @include('partials.footer')
    </div>

    @include('partials.scripts')
    @stack('custom_js')
</body>
</html>