@extends('layouts.app')

@section('title', 'Masuk ke Akun - Capyca Pet Cafe')

@section('content')
<div class="py-12 sm:py-16">
    <div class="max-w-md mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-8 sm:p-10 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-100/60 rounded-full blur-2xl pointer-events-none"></div>

            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-amber-500 text-white text-3xl flex items-center justify-center mx-auto mb-4 shadow-md">
                    <i class="fa-solid fa-cat"></i>
                </div>
                <h1 class="text-2xl font-bold font-playfair text-cafe-brown">Selamat Datang</h1>
                <p class="text-sm text-cafe-muted mt-1">Masuk untuk memesan sesi atau melihat riwayat reservasi</p>
            </div>

            <!-- Demo quick credentials badge -->
            <div class="mb-6 p-3 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-800">
                <p class="font-bold flex items-center gap-1.5 mb-1">
                    <i class="fa-solid fa-key text-amber-600"></i> Akun Uji Coba:
                </p>
                <div class="grid grid-cols-2 gap-2 text-[11px]">
                    <div><strong>Admin:</strong> admin / admin123</div>
                    <div><strong>Pelanggan:</strong> user / user123</div>
                </div>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="login" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-1.5">
                        Username atau Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-cafe-muted text-sm">
                            <i class="fa-regular fa-user"></i>
                        </span>
                        <input 
                            type="text" 
                            name="login" 
                            id="login" 
                            value="{{ old('login') }}" 
                            required 
                            autofocus
                            placeholder="Masukkan username atau email" 
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown @error('login') border-red-500 @enderror"
                        >
                    </div>
                    @error('login')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-cafe-muted text-sm">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required 
                            placeholder="Masukkan password Anda" 
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown @error('password') border-red-500 @enderror"
                        >
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-cafe-muted">
                        <input type="checkbox" name="remember" class="rounded text-amber-600 focus:ring-amber-500">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button 
                    type="submit" 
                    class="w-full py-3.5 px-4 bg-gradient-to-r from-amber-600 to-amber-500 text-white font-bold text-sm rounded-xl shadow-lg hover:from-amber-700 hover:to-amber-600 transition-all duration-200 flex items-center justify-center gap-2"
                >
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 text-center border-t border-amber-100 pt-6">
                <p class="text-xs text-cafe-muted">
                    Belum memiliki akun? 
                    <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:text-amber-700 underline">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
