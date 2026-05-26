@section('title', 'Daftar Pengumuman')
<x-guest-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display font-bold text-lg text-white">Daftar Pengumuman</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-slate-900/40 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3.5 px-6">Judul</th>
                            <th class="py-3.5 px-6">Tanggal Publikasi</th>
                            <th class="py-3.5 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($announcements as $announcement)
                            @if($announcement->is_published)
                                <tr class="hover:bg-white/[0.01] transition-colors">
                                    <td class="py-4 px-6 font-medium text-slate-200">{{ $announcement->title }}<p class="text-xs text-slate-500 mt-1">{{ Str::limit($announcement->content, 80) }}</p></td>
                                    <td class="py-4 px-6 text-slate-400">{{ $announcement->published_at ? $announcement->published_at->format('d/m/Y H:i') : '-' }}</td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('school.announcements.show', ['school_slug' => request()->route('school_slug'), 'announcement' => $announcement]) }}" class="inline-flex items-center p-2 rounded-lg bg-indigo-500/5 text-indigo-400 hover:bg-indigo-500/10 border border-indigo-500/10 transition-colors" title="Detail">
                                            <span class="material-icons-round text-sm">visibility</span>
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-sm text-slate-500">Tidak ada pengumuman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($announcements->hasPages())
                <div class="mt-4 border-t border-white/5 pt-4">
                    {{ $announcements->links() }}
                </div>
            @endif
        </div>
    </div>
</x-guest-layout>
