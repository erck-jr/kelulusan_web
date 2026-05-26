<nav class="w-full px-4 sm:px-6 py-4 border-b border-white/5 flex items-center justify-between sticky top-0 bg-[#0B0F19]/80 backdrop-blur-md z-20">
    <div class="flex items-center space-x-3">
        <button class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg hover:bg-white/5 transition-colors mr-1" 
                onclick="document.getElementById('sidebar-main').classList.remove('-translate-x-full')">
            <span class="material-icons-round">menu</span>
        </button>

        <div class="hidden sm:block">
            <ol class="flex items-center space-x-2 text-xs text-slate-500">
                <li><span class="hover:text-slate-300 transition-colors">Pages</span></li>
                <li class="text-slate-600 select-none">/</li>
                @yield('breadcrumbs')
            </ol>
            <h1 class="font-display font-bold text-lg text-white mt-0.5">@yield('title', 'Admin Dashboard')</h1>
        </div>
    </div>

    <div class="flex items-center space-x-4 relative" x-data="{ open: false }">
        <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 group focus:outline-none cursor-pointer">
            <div class="w-8 h-8 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center group-hover:border-indigo-500 transition-colors">
                <span class="material-icons-round text-slate-400 group-hover:text-indigo-400 text-lg transition-colors">account_circle</span>
            </div>
            <span class="text-sm font-medium text-slate-300 group-hover:text-white transition-colors hidden md:block">
                {{ Auth::user()->name ?? 'Administrator' }}
            </span>
            <span class="material-icons-round text-xs text-slate-500 group-hover:text-slate-300 transition-transform duration-200 hidden md:block" :class="open ? 'rotate-180' : ''">expand_more</span>
        </button>

        <div x-show="open" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             style="display: none;"
             class="absolute right-0 top-10 w-48 rounded-xl bg-[#0F1322] border border-white/5 shadow-2xl py-1.5 z-40">
            
            <form method="POST" action="{{ route('logout', ['school_slug' => request()->route('school_slug')]) }}">
                @csrf
                <a href="#" class="flex items-center space-x-2.5 px-4 py-2 text-sm text-slate-400 hover:text-rose-400 hover:bg-rose-500/5 transition-colors cursor-pointer"
                   onclick="event.preventDefault(); this.closest('form').submit();">
                    <span class="material-icons-round text-base">logout</span>
                    <span class="font-medium">Keluar Aplikasi</span>
                </a>
            </form>
        </div>
    </div>
</nav>