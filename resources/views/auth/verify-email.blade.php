<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-lg">
            <div class="glass-panel rounded-2xl p-6 shadow-lg">
                <h4 class="text-lg font-semibold text-white text-center">Verifikasi Email</h4>
                <p class="text-sm text-slate-400 text-center mt-2">Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan melalui email? Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan email yang baru.</p>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 rounded-xl bg-indigo-600 text-white">Kirim Ulang Email Verifikasi</button>
                    </form>

                    <form method="POST" action="{{ route('logout', ['school_slug' => request()->route('school_slug')]) }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 rounded-xl bg-slate-800 text-slate-200">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
