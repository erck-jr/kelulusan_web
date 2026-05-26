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
        .glass {
            background: rgba(15, 23, 25, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="bg-[#0B0F19] text-slate-100 min-h-screen overflow-x-hidden relative flex flex-col justify-between">
    
    <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full bg-indigo-900/15 blur-[120px] pointer-events-none -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[50vw] h-[50vw] rounded-full bg-purple-900/15 blur-[120px] pointer-events-none -z-10"></div>

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