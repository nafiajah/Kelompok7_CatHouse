<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Capyca Pet Cafe - Kafe Kucing & Teman Santai')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN for instant styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        },
                        cafe: {
                            cream: '#FAF6F0',
                            peach: '#F4EAE0',
                            card: '#FFFFFF',
                            text: '#2D231E',
                            muted: '#6E6259',
                            terracotta: '#D96B43',
                            brown: '#4A3528',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF6F0;
            color: #2D231E;
        }
        .font-playfair {
            font-family: 'Playfair Display', serif;
        }
    </style>
    @yield('styles')
</head>
<body class="flex flex-col min-h-screen bg-[#FAF6F0] text-cafe-text">

    <!-- Top Announcement Bar -->
    <div class="bg-cafe-brown text-amber-100 text-xs py-2 px-4 text-center tracking-wide font-medium flex items-center justify-center gap-2">
        <span>🐾 Nikmati waktu santai bersama 10+ kucing ramah & gemas di <strong>Capyca Pet Cafe</strong>!</span>
        <span class="hidden sm:inline">|</span>
        <a href="{{ route('reservasi.create') }}" class="hidden sm:inline text-amber-300 underline font-semibold hover:text-white transition">Reservasi Sekarang &rarr;</a>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-amber-900/10 shadow-sm transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-amber-400 flex items-center justify-center text-white text-2xl shadow-md group-hover:scale-105 transition-transform duration-200">
                        <i class="fa-solid fa-cat"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold font-playfair tracking-tight text-cafe-brown block leading-none">Capyca Pet Cafe</span>
                        <span class="text-xs text-amber-700 font-semibold tracking-widest uppercase">Cat House & Lounge</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-cafe-text">
                    <a href="{{ route('home') }}" class="hover:text-amber-600 transition {{ request()->routeIs('home') ? 'text-amber-600 font-bold' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('cats.index') }}" class="hover:text-amber-600 transition {{ request()->routeIs('cats.*') ? 'text-amber-600 font-bold' : '' }}">
                        Kucing Kami
                    </a>
                    <a href="{{ route('home') }}#sesi" class="hover:text-amber-600 transition">
                        Jadwal Sesi & Tiket
                    </a>
                    <a href="{{ route('home') }}#ulasan" class="hover:text-amber-600 transition">
                        Ulasan Pengunjung
                    </a>
                </nav>

                <!-- Action / Auth Buttons -->
                <div class="hidden sm:flex items-center gap-3">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-xs font-bold uppercase tracking-wider bg-purple-100 text-purple-800 rounded-xl border border-purple-200 hover:bg-purple-200 transition flex items-center gap-2">
                                <i class="fa-solid fa-shield-halved"></i> Panel Admin
                            </a>
                        @endif

                        <!-- User Profile Dropdown -->
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-xl bg-amber-50 border border-amber-200 hover:bg-amber-100 transition text-sm font-semibold text-cafe-brown">
                                <span class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr(Auth::user()->nama_pelanggan, 0, 1)) }}
                                </span>
                                <span class="max-w-[120px] truncate">{{ Auth::user()->nama_pelanggan }}</span>
                                <i class="fa-solid fa-chevron-down text-xs text-cafe-muted"></i>
                            </button>

                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-amber-100 py-2 hidden group-hover:block transition z-50">
                                <div class="px-4 py-2 border-b border-amber-50">
                                    <p class="text-xs text-cafe-muted">Masuk sebagai</p>
                                    <p class="text-sm font-bold text-cafe-brown truncate">{{ Auth::user()->nama_pelanggan }}</p>
                                    <span class="inline-block mt-1 text-[10px] uppercase font-bold px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">{{ Auth::user()->role }}</span>
                                </div>
                                <a href="{{ route('reservasi.history') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-cafe-text hover:bg-amber-50 transition">
                                    <i class="fa-solid fa-calendar-check text-amber-600 w-4"></i> Riwayat Reservasi
                                </a>
                                <a href="{{ route('feedback.create') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-cafe-text hover:bg-amber-50 transition">
                                    <i class="fa-solid fa-star text-amber-500 w-4"></i> Tulis Ulasan / Saran
                                </a>
                                <div class="border-t border-amber-50 my-1"></div>
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition text-left">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                        <a href="{{ route('reservasi.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-amber-600 to-amber-500 text-white text-sm font-bold rounded-xl shadow-md hover:from-amber-700 hover:to-amber-600 hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-ticket"></i> Reservasi
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-bold text-cafe-brown hover:text-amber-600 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-bold rounded-xl border-2 border-amber-600 text-amber-700 hover:bg-amber-600 hover:text-white transition">
                            Daftar
                        </a>
                        <a href="{{ route('reservasi.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-amber-600 to-amber-500 text-white text-sm font-bold rounded-xl shadow-md hover:from-amber-700 hover:to-amber-600 transition flex items-center gap-2">
                            <i class="fa-solid fa-ticket"></i> Reservasi
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center gap-2 md:hidden">
                    <a href="{{ route('reservasi.create') }}" class="px-3 py-1.5 bg-amber-600 text-white text-xs font-bold rounded-lg">
                        Reservasi
                    </a>
                    <button id="mobileMenuBtn" class="p-2 rounded-lg text-cafe-brown hover:bg-amber-100">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-amber-100 px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-bold text-cafe-text hover:bg-amber-50">Beranda</a>
            <a href="{{ route('cats.index') }}" class="block px-3 py-2 rounded-lg text-sm font-bold text-cafe-text hover:bg-amber-50">Kucing Kami</a>
            <a href="{{ route('home') }}#sesi" class="block px-3 py-2 rounded-lg text-sm font-bold text-cafe-text hover:bg-amber-50">Jadwal Sesi & Tiket</a>
            <a href="{{ route('home') }}#ulasan" class="block px-3 py-2 rounded-lg text-sm font-bold text-cafe-text hover:bg-amber-50">Ulasan Pengunjung</a>
            <div class="border-t border-amber-100 pt-3">
                @auth
                    <p class="text-xs text-cafe-muted px-3 mb-2 font-medium">Masuk sebagai: <strong>{{ Auth::user()->nama_pelanggan }}</strong></p>
                    <a href="{{ route('reservasi.history') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-cafe-text hover:bg-amber-50">Riwayat Reservasi</a>
                    <a href="{{ route('feedback.create') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-cafe-text hover:bg-amber-50">Tulis Ulasan</a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-bold text-purple-700 bg-purple-50">Panel Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-sm font-bold text-red-600 hover:bg-red-50 rounded-lg">Logout</button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-2 px-1">
                        <a href="{{ route('login') }}" class="text-center py-2 rounded-xl border border-amber-300 text-sm font-bold text-cafe-brown">Masuk</a>
                        <a href="{{ route('register') }}" class="text-center py-2 rounded-xl bg-amber-600 text-white text-sm font-bold">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Global Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-sm">&times;</button>
            </div>
        @endif

        @if(session('info'))
            <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-800 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-info text-blue-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('info') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700 text-sm">&times;</button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-cafe-brown text-amber-100 border-t border-amber-950/20 pt-16 pb-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                <!-- Brand Info -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xl">
                            <i class="fa-solid fa-cat"></i>
                        </div>
                        <span class="text-2xl font-bold font-playfair text-white tracking-tight">Capyca Pet Cafe</span>
                    </div>
                    <p class="text-sm text-amber-200/80 leading-relaxed max-w-md">
                        Kafe kucing berkonsep hangat dan nyaman dengan berbagai ras kucing sehat, jinak, dan bersahabat. Tempat ideal untuk melepas penat, menikmati kopi berkualitas, dan berinteraksi bersama anabul kesayangan.
                    </p>
                    <div class="flex items-center gap-4 text-amber-300 text-lg pt-2">
                        <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-amber-500 hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-amber-500 hover:text-white transition"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-amber-500 hover:text-white transition"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-bold text-sm tracking-wider uppercase mb-4">Navigasi Cepat</h4>
                    <ul class="space-y-2.5 text-sm text-amber-200/70">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-300 transition">Beranda</a></li>
                        <li><a href="{{ route('cats.index') }}" class="hover:text-amber-300 transition">Daftar Kucing</a></li>
                        <li><a href="{{ route('reservasi.create') }}" class="hover:text-amber-300 transition">Reservasi Tiket</a></li>
                        <li><a href="{{ route('feedback.create') }}" class="hover:text-amber-300 transition">Kirim Ulasan</a></li>
                    </ul>
                </div>

                <!-- Jam Operasional & Kontak -->
                <div>
                    <h4 class="text-white font-bold text-sm tracking-wider uppercase mb-4">Jam Operasional</h4>
                    <ul class="space-y-2 text-sm text-amber-200/80">
                        <li class="flex items-center gap-2">
                            <i class="fa-regular fa-clock text-amber-400"></i>
                            <span>Selasa - Minggu: 10:00 - 20:00</span>
                        </li>
                        <li class="text-xs text-amber-300/80 pl-6">
                            (Senin libur perawatan anabul)
                        </li>
                        <li class="flex items-center gap-2 pt-2">
                            <i class="fa-solid fa-location-dot text-amber-400"></i>
                            <span>Jl. Cat Paradise No. 7, Jakarta Selatan</span>
                        </li>
                        <li class="flex items-center gap-2 pt-1">
                            <i class="fa-solid fa-phone text-amber-400"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 mt-12 pt-6 text-center text-xs text-amber-200/60 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p>&copy; {{ date('Y') }} Capyca Pet Cafe (Cat House). Kelompok 7 - Hak Cipta Dilindungi.</p>
                <p class="flex items-center gap-2">
                    <span>Made with 🐾 and care</span>
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    </script>
    @yield('scripts')
</body>
</html>
