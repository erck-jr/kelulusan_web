@php
    $slugParam = ['school_slug' => request()->route('school_slug')];
@endphp

<aside class="fixed inset-y-0 left-0 w-64 bg-[#0F1322]/90 border-r border-white/5 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col justify-between" id="sidebar-main">
    <div>
        <div class="p-5 border-b border-white/5 flex items-center justify-between">
            <a class="flex items-center space-x-3 group" href="{{ route('admin.dashboard', $slugParam) }}">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl {{ settings('school_logo') ? 'bg-white p-0.5 sm:p-1' : 'bg-gradient-to-tr from-indigo-500 to-violet-600' }} flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300 flex-shrink-0 overflow-hidden">
                    @if(settings('school_logo'))
                        <img src="{{ asset('storage/' . settings('school_logo')) }}" alt="Logo {{ settings('school_name') }}" class="w-full h-full object-contain" />
                    @else
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                        </svg>
                    @endif
                </div>
                <span class="font-display font-bold text-lg tracking-wide bg-gradient-to-r from-white to-indigo-200 bg-clip-text text-transparent">GradSaaS</span>
            </a>
            
            <button class="lg:hidden text-slate-400 hover:text-white" onclick="document.getElementById('sidebar-main').classList.add('-translate-x-full')">
                <span class="material-icons-round">close</span>
            </button>
        </div>

        <div class="px-4 py-6 overflow-y-auto max-h-[calc(100vh-140px)]">
            <ul class="space-y-1">
                <li>
                    <a class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-500 to-violet-600 text-white shadow-lg' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}" href="{{ route('admin.dashboard', $slugParam) }}">
                        <span class="material-icons-round text-lg">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.students.*') ? 'bg-gradient-to-r from-indigo-500 to-violet-600 text-white shadow-lg' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}" href="{{ route('admin.students.index', $slugParam) }}">
                        <span class="material-icons-round text-lg">people</span>
                        <span>Data Siswa</span>
                    </a>
                </li>

                <li>
                    <a class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.school-classes.*') ? 'bg-gradient-to-r from-indigo-500 to-violet-600 text-white shadow-lg' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}" href="{{ route('admin.school-classes.index', $slugParam) }}">
                        <span class="material-icons-round text-lg">school</span>
                        <span>Data Kelas</span>
                    </a>
                </li>

                <li>
                    <a class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.announcements.*') ? 'bg-gradient-to-r from-indigo-500 to-violet-600 text-white shadow-lg' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}" href="{{ route('admin.announcements.index', $slugParam) }}">
                        <span class="material-icons-round text-lg">campaign</span>
                        <span>Pengumuman</span>
                    </a>
                </li>

                <li>
                    <a class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.grades.*') ? 'bg-gradient-to-r from-indigo-500 to-violet-600 text-white shadow-lg' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}" href="{{ route('admin.grades.index', $slugParam) }}">
                        <span class="material-icons-round text-lg">grade</span>
                        <span>Data Nilai</span>
                    </a>
                </li>

                <li class="pt-4 px-4 pb-2">
                    <span class="text-[10px] font-bold tracking-wider text-slate-500 uppercase">Pengaturan</span>
                </li>

                <li>
                    <a class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.graduation-periods.*') ? 'bg-gradient-to-r from-indigo-500 to-violet-600 text-white shadow-lg' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}" href="{{ route('admin.graduation-periods.index', $slugParam) }}">
                        <span class="material-icons-round text-lg">event</span>
                        <span>Periode Kelulusan</span>
                    </a>
                </li>
                <li>
                    <a class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-indigo-500 to-violet-600 text-white shadow-lg' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}" href="{{ route('admin.users.index', $slugParam) }}">
                        <span class="material-icons-round text-lg">manage_accounts</span>
                        <span>Pengguna</span>
                    </a>
                </li>

                <li>
                    <a class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-indigo-500 to-violet-600 text-white shadow-lg' : 'text-slate-400 hover:text-slate-200 hover:bg-white/5' }}" href="{{ route('admin.settings.index', $slugParam) }}">
                        <span class="material-icons-round text-lg">settings</span>
                        <span>Konfigurasi</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="p-4 border-t border-white/5">
        <form method="POST" action="{{ route('logout', $slugParam) }}">
            @csrf
            <a class="w-full flex items-center justify-center space-x-2 px-4 py-3 rounded-xl text-sm font-semibold text-rose-400 bg-rose-500/5 border border-rose-500/10 hover:bg-rose-500/10 transition-colors cursor-pointer" 
               href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                <span class="material-icons-round text-sm">logout</span>
                <span>Keluar Panel</span>
            </a>
        </form>
    </div>
</aside>