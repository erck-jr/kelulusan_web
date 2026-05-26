@section('title', 'Edit Pengguna')

@section('breadcrumbs')
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="text-slate-600 select-none">/</li>
<li><a class="hover:text-slate-300 transition-colors" href="{{ route('admin.users.index') }}">Data Pengguna</a></li>
<li class="text-slate-600 select-none">/</li>
<li class="text-xs text-slate-400">Edit Pengguna</li>
@endsection

<x-layouts.admin-layout>
    <div class="space-y-6">
        <div class="glass-panel rounded-2xl shadow-xl p-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-display font-bold text-xl text-white tracking-wide">Edit Pengguna</h2>
                    <p class="text-xs text-slate-400 mt-1">Perbarui data pengguna tanpa mengubah logika bisnis.</p>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('name')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('email')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                            @error('password')<p class="text-xs text-rose-400">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="w-full rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition" />
                        </div>
                    </div>

                    <div class="glass-panel rounded-2xl border border-white/10 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-3">Peran Pengguna</p>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-white/10 bg-slate-950/50 p-4 transition hover:border-indigo-500/30">
                                <input type="radio" name="role" value="admin" class="h-4 w-4 text-indigo-500 focus:ring-indigo-500" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }} {{ auth()->id() === $user->id ? 'disabled' : '' }} />
                                <span class="text-sm text-slate-200">Admin</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-white/10 bg-slate-950/50 p-4 transition hover:border-indigo-500/30">
                                <input type="radio" name="role" value="operator" class="h-4 w-4 text-indigo-500 focus:ring-indigo-500" {{ old('role', $user->role) === 'operator' ? 'checked' : '' }} {{ auth()->id() === $user->id ? 'disabled' : '' }} />
                                <span class="text-sm text-slate-200">Operator</span>
                            </label>
                        </div>
                        @error('role')<p class="mt-3 text-xs text-rose-400">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-wrap gap-3 justify-end">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 border border-white/10 text-slate-300 text-xs font-semibold transition hover:bg-slate-700">Batal</a>
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 text-white text-xs font-semibold transition shadow-md">Perbarui Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
