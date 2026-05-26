@section('title', 'Detil Pengguna')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.users.index') }}">Data Pengguna</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Detil Pengguna</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel p-6 rounded-2xl shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display font-bold text-xl text-white tracking-wide">Detil Pengguna</h2>
                <p class="text-xs text-slate-400 mt-1">Informasi lengkap pengguna tersimpan.</p>
            </div>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-500/10 px-4 py-2.5 text-xs font-semibold text-indigo-300 border border-indigo-500/20 hover:bg-indigo-500/15 transition">
                    <span class="material-icons-round text-sm">edit</span>
                    <span>Edit</span>
                </a>
                @if(auth()->id() !== $user->id)
                    <button type="button" onclick="confirmDelete('{{ $user->id }}')" class="inline-flex items-center gap-2 rounded-xl bg-rose-500/10 px-4 py-2.5 text-xs font-semibold text-rose-300 border border-rose-500/20 hover:bg-rose-500/15 transition">
                        <span class="material-icons-round text-sm">delete</span>
                        <span>Hapus</span>
                    </button>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" id="delete-form-{{ $user->id }}" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 glass-panel rounded-2xl shadow-xl p-6 space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Nama Lengkap</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $user->name }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Email</p>
                        <p class="mt-2 text-sm text-slate-200 font-semibold">{{ $user->email }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                        <p class="text-xs text-slate-400 uppercase tracking-wide">Peran</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold tracking-wide {{ $user->role === 'admin' ? 'bg-indigo-500/10 text-indigo-300 border border-indigo-500/20' : 'bg-slate-800 text-slate-300 border border-white/10' }}">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>

                <div class="rounded-2xl bg-slate-950/60 border border-white/10 p-5">
                    <h3 class="font-semibold text-sm text-slate-200 mb-3">Informasi Akun</h3>
                    <div class="grid gap-4">
                        <div>
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Email terverifikasi</p>
                            <p class="mt-2 text-sm text-slate-200">@if($user->email_verified_at){{ $user->email_verified_at->format('d/m/Y H:i') }}@else<span class="text-rose-400">Belum terverifikasi</span>@endif</p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Bergabung pada</p>
                            <p class="mt-2 text-sm text-slate-200">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] uppercase tracking-wide text-slate-500">Terakhir diperbarui</p>
                            <p class="mt-2 text-sm text-slate-200">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-2xl shadow-xl p-6">
                <h3 class="font-semibold text-sm text-white mb-4">Tindakan</h3>
                <a href="{{ route('admin.users.index') }}" class="block w-full rounded-xl bg-slate-800 border border-white/10 px-4 py-3 text-center text-xs font-semibold text-slate-300 hover:bg-slate-700 transition">Kembali ke Daftar</a>
            </div>
        </div>
    </div>

    @push('custom_js')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Pengguna?',
                text: 'Pengguna akan dihapus permanen dari sistem.',
                icon: 'warning',
                showCancelButton: true,
                background: '#0F1322',
                color: '#f1f5f9',
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#334155',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    @endpush
</x-layouts.admin-layout>
