@section('title', 'Dashboard')

@section('breadcrumbs')
<li class="text-xs text-slate-400 hover:text-slate-300 transition-colors">Dashboard</li>
@endsection

<x-layouts.admin-layout>
    @php
        $slugParam = ['school_slug' => request()->route('school_slug')];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <div class="glass-panel p-5 rounded-2xl shadow-xl flex items-center justify-between relative overflow-hidden group">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-400 tracking-wide uppercase">Total Siswa</p>
                <h3 class="font-display font-bold text-3xl text-white">{{ $totalStudents }}</h3>
                <div class="pt-2">
                    <a href="{{ route('admin.students.index', $slugParam) }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors inline-flex items-center space-x-1">
                        <span>Lihat Detail</span>
                        <span class="material-icons-round text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 group-hover:scale-110 transition-transform duration-300">
                <span class="material-icons-round text-2xl">people</span>
            </div>
        </div>

        <div class="glass-panel p-5 rounded-2xl shadow-xl flex items-center justify-between relative overflow-hidden group">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-400 tracking-wide uppercase">Total Kelas</p>
                <h3 class="font-display font-bold text-3xl text-white">{{ $totalClasses }}</h3>
                <div class="pt-2">
                    <a href="{{ route('admin.school-classes.index', $slugParam) }}" class="text-xs font-semibold text-violet-400 hover:text-violet-300 transition-colors inline-flex items-center space-x-1">
                        <span>Lihat Detail</span>
                        <span class="material-icons-round text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-violet-500/10 border border-violet-500/20 flex items-center justify-center text-violet-400 group-hover:scale-110 transition-transform duration-300">
                <span class="material-icons-round text-2xl">school</span>
            </div>
        </div>

        <div class="glass-panel p-5 rounded-2xl shadow-xl flex items-center justify-between relative overflow-hidden group">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-400 tracking-wide uppercase">Siswa Lulus</p>
                <h3 class="font-display font-bold text-3xl text-emerald-400">{{ $totalGraduated }}</h3>
                <div class="pt-2">
                    <span class="text-xs font-semibold text-emerald-500 bg-emerald-500/10 px-2 py-0.5 rounded-md">
                        @if($totalStudents > 0)
                            {{ number_format(($totalGraduated / $totalStudents) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </span>
                    <span class="text-[11px] text-slate-500 ms-1">dari total siswa</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform duration-300">
                <span class="material-icons-round text-2xl">check_circle</span>
            </div>
        </div>

        <div class="glass-panel p-5 rounded-2xl shadow-xl flex items-center justify-between relative overflow-hidden group">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-400 tracking-wide uppercase">Pengumuman</p>
                <h3 class="font-display font-bold text-3xl text-cyan-400">{{ $totalAnnouncements }}</h3>
                <div class="pt-2">
                    <a href="{{ route('admin.announcements.index', $slugParam) }}" class="text-xs font-semibold text-cyan-400 hover:text-cyan-300 transition-colors inline-flex items-center space-x-1">
                        <span>Lihat Detail</span>
                        <span class="material-icons-round text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/20 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform duration-300">
                <span class="material-icons-round text-2xl">campaign</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        
        <div class="lg:col-span-2 glass-panel rounded-2xl shadow-xl overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-5 border-b border-white/5 flex items-center justify-between">
                    <h3 class="font-display font-bold text-base text-white tracking-wide">Pengumuman Terbaru</h3>
                    <a href="{{ route('admin.announcements.create', $slugParam) }}" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold text-xs tracking-wide transition-all shadow-md flex items-center space-x-1 cursor-pointer">
                        <span class="material-icons-round text-sm">add</span>
                        <span>Tambah</span>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 bg-slate-900/40 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="py-3 px-5">Judul Pengumuman</th>
                                <th class="py-3 px-5">Status</th>
                                <th class="py-3 px-5 text-center">Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-sm">
                            @forelse($recentAnnouncements as $announcement)
                                <tr class="hover:bg-white/[0.02] transition-colors">
                                    <td class="py-3.5 px-5 font-medium text-slate-200">
                                        {{ $announcement->title }}
                                    </td>
                                    <td class="py-3.5 px-5">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold {{ $announcement->is_published ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-slate-800 text-slate-400 border border-white/5' }}">
                                            {{ $announcement->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-5 text-center text-xs text-slate-400">
                                        {{ $announcement->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-xs text-slate-500">Belum ada data pengumuman terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="glass-panel p-5 rounded-2xl shadow-xl flex flex-col">
            <div class="pb-4 border-b border-white/5 mb-4">
                <h3 class="font-display font-bold text-base text-white tracking-wide">Statistik Per Kelas</h3>
            </div>
            
            <div class="space-y-4 overflow-y-auto max-h-[350px] pr-1">
                @forelse($classStatistics as $class)
                    <div class="flex items-start space-x-3.5 relative group">
                        <div class="w-8 h-8 rounded-lg bg-slate-800 border border-white/10 text-slate-400 flex items-center justify-center group-hover:border-indigo-500/50 group-hover:text-indigo-400 transition-colors z-10 shrink-0">
                            <span class="material-icons-round text-base">school</span>
                        </div>
                        
                        <div class="flex-1 min-w-0 border-b border-white/5 pb-3 group-last:border-none">
                            <h4 class="text-sm font-semibold text-slate-200 truncate">{{ $class->name }}</h4>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-xs text-slate-400 font-medium">
                                    {{ $class->graduated_count }} dari {{ $class->total_students }} lulus
                                </span>
                                <span class="text-xs font-bold text-indigo-400">
                                    @if($class->total_students > 0)
                                        {{ number_format(($class->graduated_count / $class->total_students) * 100, 0) }}%
                                    @else
                                        0%
                                    @endif
                                </span>
                            </div>
                            
                            <div class="w-full h-1 bg-slate-800 rounded-full mt-2 overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full" 
                                     style="width: {{ $class->total_students > 0 ? ($class->graduated_count / $class->total_students) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-4">Belum ada statistik data kelas.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-layouts.admin-layout>