<nav class="w-full px-4 sm:px-6 py-5 max-w-7xl mx-auto flex items-center justify-between border-b border-white/5 absolute top-0 left-0 right-0 z-30">
    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
            </svg>
        </div>
        <span class="font-display font-bold text-xl tracking-wide bg-gradient-to-r from-white via-indigo-200 to-violet-300 bg-clip-text text-transparent">Kelulusan-App</span>
    </a>
    
    <div class="flex items-center space-x-4">
        <a href="{{ route('login', ['school_slug' => request()->route('school_slug')]) }}" class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-300 hover:text-white hover:bg-white/5 transition-all flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Login</span>
        </a>
        
        @if (Route::has('password.request'))
            <a href="{{ route('password.request', ['school_slug' => request()->route('school_slug')]) }}" class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors text-xs font-semibold text-slate-200 tracking-wide">
                Reset Password
            </a>
        @endif
    </div>
</nav>