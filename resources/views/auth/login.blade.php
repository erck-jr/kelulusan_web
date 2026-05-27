@section('title', 'Login - ')
<x-guest-layout>
    <div class="w-full max-w-md mx-auto px-4 relative z-10">
        <div class="glass p-6 sm:p-8 rounded-2xl sm:rounded-3xl shadow-2xl relative overflow-hidden">
            
            <div class="text-center mb-6">
                <h4 class="font-display font-bold text-2xl text-slate-900 dark:text-white tracking-wide">Login Admin</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Masuk ke panel pengelolaan kelulusan sekolah</p>
            </div>

            @if (session('status'))
                <div class="p-4 mb-4 text-xs rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login', ['school_slug' => request()->route('school_slug')]) }}" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-semibold text-slate-600 dark:text-slate-300">Email Sekolah / Admin</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        placeholder="admin@sekolah.sch.id"
                        class="w-full bg-white dark:bg-slate-900/80 border @error('email') border-rose-500/50 focus:border-rose-500 @else border-slate-300 dark:border-white/10 focus:border-indigo-500 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none transition-colors">
                    
                    @error('email')
                        <span class="text-xs text-rose-400 block mt-1 font-medium">⚠️ {{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="text-xs font-semibold text-slate-600 dark:text-slate-300">Password</label>
                    </div>
                    <input type="password" name="password" id="password" required
                        placeholder="••••••••"
                        class="w-full bg-white dark:bg-slate-900/80 border @error('password') border-rose-500/50 focus:border-rose-500 @else border-slate-300 dark:border-white/10 focus:border-indigo-500 @enderror rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none transition-colors">
                    
                    @error('password')
                        <span class="text-xs text-rose-400 block mt-1 font-medium">⚠️ {{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="inline-flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" id="rememberMe" 
                            class="rounded bg-white dark:bg-slate-900 border-slate-300 dark:border-white/10 text-indigo-600 focus:ring-0 focus:ring-offset-0 w-4 h-4 transition-colors cursor-pointer">
                        <span class="ms-2 text-xs font-medium text-slate-500 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-300 transition-colors select-none">Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request', ['school_slug' => request()->route('school_slug')]) }}" 
                            class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition-all transform active:scale-[0.98] text-sm tracking-wide cursor-pointer flex justify-center items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        <span>Masuk ke Dashboard</span>
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</x-guest-layout>