@extends('layouts.app')

@section('title', 'Daftar Akun Baru - Capyca Pet Cafe')

@section('content')
<div class="py-12 sm:py-16">
    <div class="max-w-lg mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-3xl shadow-xl border border-amber-100 p-8 sm:p-10 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-100/60 rounded-full blur-2xl pointer-events-none"></div>

            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-amber-500 text-white text-3xl flex items-center justify-center mx-auto mb-4 shadow-md">
                    <i class="fa-solid fa-paw"></i>
                </div>
                <h1 class="text-2xl font-bold font-playfair text-cafe-brown">Daftar Akun Baru</h1>
                <p class="text-sm text-cafe-muted mt-1">Bergabung bersama komunitas pecinta anabul Capyca Pet Cafe</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="nama_pelanggan" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-1">
                        Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        name="nama_pelanggan" 
                        id="nama_pelanggan" 
                        value="{{ old('nama_pelanggan') }}" 
                        required 
                        placeholder="Contoh: Nabila Putri" 
                        class="w-full px-4 py-2.5 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown @error('nama_pelanggan') border-red-500 @enderror"
                    >
                    @error('nama_pelanggan')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-1">
                            Username
                        </label>
                        <input 
                            type="text" 
                            name="username" 
                            id="username" 
                            value="{{ old('username') }}" 
                            required 
                            placeholder="username123" 
                            class="w-full px-4 py-2.5 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown @error('username') border-red-500 @enderror"
                        >
                        @error('username')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_telp" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-1">
                            Nomor WhatsApp / Telp
                        </label>
                        <input 
                            type="text" 
                            name="no_telp" 
                            id="no_telp" 
                            value="{{ old('no_telp') }}" 
                            required 
                            placeholder="08123456789" 
                            class="w-full px-4 py-2.5 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown @error('no_telp') border-red-500 @enderror"
                        >
                        @error('no_telp')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-1">
                        Alamat Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}" 
                        required 
                        placeholder="nama@email.com" 
                        class="w-full px-4 py-2.5 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown @error('email') border-red-500 @enderror"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-1">
                            Password
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            required 
                            placeholder="Min. 6 karakter" 
                            class="w-full px-4 py-2.5 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown @error('password') border-red-500 @enderror"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-cafe-brown mb-1">
                            Ulangi Password
                        </label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            required 
                            placeholder="Konfirmasi" 
                            class="w-full px-4 py-2.5 rounded-xl border border-amber-200 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-amber-50/20 text-cafe-brown"
                        >
                    </div>
                </div>

                <div class="pt-3">
                    <button 
                        type="submit" 
                        class="w-full py-3.5 px-4 bg-gradient-to-r from-amber-600 to-amber-500 text-white font-bold text-sm rounded-xl shadow-lg hover:from-amber-700 hover:to-amber-600 transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center border-t border-amber-100 pt-6">
                <p class="text-xs text-cafe-muted">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:text-amber-700 underline">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
