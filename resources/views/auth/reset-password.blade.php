@section('title','Reset Password')

<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="glass-panel rounded-2xl p-6 shadow-lg">
                <h4 class="text-lg font-semibold text-white text-center">Reset Password</h4>
                <p class="text-sm text-slate-400 text-center mt-2">Masukkan password baru Anda</p>

                <form method="POST" action="{{ route('password.store') }}" class="mt-4 space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label class="text-xs text-slate-400">Email</label>
                        <input type="email" name="email" value="{{ old('email', $request->email) }}" required readonly class="w-full mt-1 rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm" />
                        @error('email')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Password Baru</label>
                        <input type="password" name="password" required class="w-full mt-1 rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm" />
                        @error('password')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required class="w-full mt-1 rounded-2xl bg-slate-950/50 border border-white/10 px-4 py-3 text-slate-200 text-sm" />
                        @error('password_confirmation')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <button type="submit" class="w-full rounded-xl px-4 py-2 bg-indigo-600 text-white font-semibold">Reset Password</button>
                    </div>
                </form>

                <p class="mt-4 text-sm text-center text-slate-400">
                    <a href="{{ route('login', ['school_slug' => request()->route('school_slug')]) }}" class="text-indigo-400 font-semibold">Kembali ke Login</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
