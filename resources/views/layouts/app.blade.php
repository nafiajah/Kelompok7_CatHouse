<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cat House Bukit Bintang - Play • Interact • Make Memories')</title>

    <!-- Google Fonts: Poppins (normal) & Literata (serif/judul) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,7..72,400..800;1,7..72,400..700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Poppins"', 'sans-serif'],
                        serif: ['"Literata"', 'Georgia', 'serif'],
                        literata: ['"Literata"', 'Georgia', 'serif'],
                        display: ['"Literata"', 'Georgia', 'serif'],
                    },
                    colors: {
                        cathouse: {
                            blush: '#FFDAE1',
                            rose: '#E58B9C',
                            roseDark: '#D77487',
                            card: '#E39797',
                            espresso: '#3F322A',
                            espressoDark: '#2E221E',
                            muted: '#5C4D44',
                        },
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
                            text: '#3F322A',
                            muted: '#6E6259',
                            terracotta: '#D96B43',
                            brown: '#3F322A',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFFFFF;
            color: #3F322A;
        }
        .font-literata,
        .font-playfair {
            font-family: 'Literata', Georgia, serif;
        }
    </style>
    @yield('styles')
</head>
<body class="flex flex-col min-h-screen bg-white text-[#3F322A] antialiased">

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-[#FFDAE1]/95 backdrop-blur-md border-b border-[#E58B9C]/20">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-12">
            <div class="flex items-center justify-between h-[76px]">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-white p-1 flex items-center justify-center shadow-xs group-hover:scale-105 transition-transform duration-200">
                        <img
                            src="{{ asset('images/admin-cat-logo.png') }}"
                            alt="Cat House Logo"
                            class="w-full h-full object-contain rounded-lg"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        >
                        <span class="hidden items-center justify-center text-[#E58B9C] text-lg">
                            <i class="fa-solid fa-cat"></i>
                        </span>
                    </div>
                    <span class="text-[22px] font-semibold font-literata tracking-tight text-[#3F322A]">
                        Cat House
                    </span>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center gap-8 lg:gap-10 text-sm font-medium text-[#3F322A]">
                    <a href="{{ route('home') }}" class="hover:text-[#E58B9C] transition {{ request()->routeIs('home') ? 'font-semibold text-[#E58B9C]' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('about') }}" class="hover:text-[#E58B9C] transition {{ request()->routeIs('about') ? 'font-semibold text-[#E58B9C]' : '' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('reservasi.create') }}" class="hover:text-[#E58B9C] transition {{ request()->routeIs('reservasi.*') ? 'font-semibold text-[#E58B9C]' : '' }}">
                        Reservasi
                    </a>
                    <a href="{{ route('cats.index') }}" class="hover:text-[#E58B9C] transition {{ request()->routeIs('cats.*') ? 'font-semibold text-[#E58B9C]' : '' }}">
                        Kucing Kami
                    </a>
                    @auth
                        <a href="{{ route('feedback.create') }}" class="hover:text-[#E58B9C] transition {{ request()->routeIs('feedback.*') ? 'font-semibold text-[#E58B9C]' : '' }}">
                            Feedback
                        </a>
                    @else
                        <a href="{{ route('home') }}#kontak" class="hover:text-[#E58B9C] transition">
                            Kontak
                        </a>
                    @endauth
                </nav>

                <!-- Action / Auth Controls -->
                <div class="hidden md:flex items-center gap-3 shrink-0">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 text-xs font-semibold bg-white/80 text-[#3F322A] rounded-lg border border-[#3F322A]/15 hover:bg-white transition flex items-center gap-1.5">
                                <i class="fa-solid fa-shield-halved text-[#E58B9C]"></i> Admin
                            </a>
                        @endif

                        <!-- User Profile Dropdown -->
                        <div class="relative group">
                            <button type="button" class="flex items-center gap-2.5 px-2 py-1.5 rounded-full hover:bg-white/40 transition text-sm font-semibold text-[#3F322A] cursor-pointer">
                                <span class="w-8 h-8 rounded-full bg-[#E58B9C] text-white flex items-center justify-center text-sm font-semibold shadow-2xs">
                                    {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                                </span>
                                <span class="max-w-[110px] truncate">{{ explode(' ', trim(Auth::user()->nama_lengkap))[0] }}</span>
                                <i class="fa-solid fa-chevron-down text-[11px] text-[#3F322A]/80"></i>
                            </button>

                            <div class="absolute right-0 pt-2 w-56 hidden group-hover:block z-50">
                                <div class="bg-white rounded-2xl shadow-xl border border-[#FFDAE1] py-2">
                                    <div class="px-4 py-2.5 border-b border-[#FFDAE1]/60">
                                        <p class="text-[11px] text-[#5C4D44]">Masuk sebagai</p>
                                        <p class="text-sm font-bold text-[#3F322A] truncate">{{ Auth::user()->nama_lengkap }}</p>
                                        <span class="inline-block mt-1 text-[10px] uppercase font-bold px-2 py-0.5 rounded-full bg-[#FFDAE1] text-[#3F322A]">{{ Auth::user()->role }}</span>
                                    </div>
                                    <a href="{{ route('reservasi.history') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-[#3F322A] hover:bg-[#FFF5F7] transition">
                                        <i class="fa-solid fa-calendar-check text-[#E58B9C] w-4"></i> Riwayat Reservasi
                                    </a>
                                    <a href="{{ route('feedback.create') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-[#3F322A] hover:bg-[#FFF5F7] transition">
                                        <i class="fa-solid fa-star text-[#E58B9C] w-4"></i> Tulis Ulasan / Saran
                                    </a>
                                    <div class="border-t border-[#FFDAE1]/60 my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition text-left cursor-pointer">
                                            <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-[#3F322A] hover:bg-[#2E221E] text-white text-sm font-medium rounded-lg shadow-xs transition">
                            Login
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center gap-2.5 md:hidden">
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-1.5 bg-[#3F322A] text-white text-xs font-medium rounded-lg">
                            Login
                        </a>
                    @endguest
                    <button id="mobileMenuBtn" type="button" class="p-2 rounded-lg text-[#3F322A] hover:bg-white/50 transition" aria-label="Buka menu">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobileMenu" class="hidden md:hidden bg-[#FFF5F7] border-t border-[#E58B9C]/25 px-5 pt-3 pb-5 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-[#3F322A] hover:bg-[#FFDAE1]/60">Beranda</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-[#3F322A] hover:bg-[#FFDAE1]/60">Tentang Kami</a>
            <a href="{{ route('reservasi.create') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-[#3F322A] hover:bg-[#FFDAE1]/60">Reservasi</a>
            <a href="{{ route('cats.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-[#3F322A] hover:bg-[#FFDAE1]/60">Kucing Kami</a>
            @auth
                <a href="{{ route('feedback.create') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-[#3F322A] hover:bg-[#FFDAE1]/60">Feedback</a>
            @else
                <a href="{{ route('home') }}#kontak" class="block px-3 py-2 rounded-lg text-sm font-medium text-[#3F322A] hover:bg-[#FFDAE1]/60">Kontak</a>
            @endauth

            @auth
                <div class="border-t border-[#E58B9C]/25 pt-3 mt-2 space-y-1.5">
                    <p class="text-xs text-[#5C4D44] px-3 mb-1">Masuk sebagai: <strong>{{ Auth::user()->nama_lengkap }}</strong></p>
                    <a href="{{ route('reservasi.history') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-[#3F322A] hover:bg-[#FFDAE1]/60">Riwayat Reservasi</a>
                    <a href="{{ route('feedback.create') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-[#3F322A] hover:bg-[#FFDAE1]/60">Tulis Ulasan</a>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold text-[#3F322A] bg-[#FFDAE1]">Panel Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="pt-1">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </header>

    <!-- Global Flash Messages (only rendered when present so Hero stays flush under Navbar) -->
    @if(session('success') || session('error') || session('info'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full space-y-2">
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-sm">&times;</button>
                </div>
            @endif

            @if(session('info'))
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-info text-blue-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('info') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700 text-sm">&times;</button>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="kontak" class="bg-[#FFDAE1] text-[#3F322A] rounded-t-[44px] sm:rounded-t-[60px] mt-16">
        <div class="max-w-6xl mx-auto px-6 sm:px-10 lg:px-12 pt-12 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 items-start">

                <!-- Brand Info & Socials -->
                <div class="md:col-span-5 space-y-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-white p-1.5 flex items-center justify-center shadow-xs shrink-0">
                            <img
                                src="{{ asset('images/admin-cat-logo.png') }}"
                                alt="Cat House Logo"
                                class="w-full h-full object-contain rounded-lg"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >
                            <span class="hidden items-center justify-center text-[#E58B9C] text-xl">
                                <i class="fa-solid fa-cat"></i>
                            </span>
                        </div>
                        <div>
                            <span class="text-lg font-semibold font-literata text-[#3F322A] block leading-tight">Cat House</span>
                            <span class="text-xs font-bold text-[#3F322A] tracking-tight">Play &bull; Interact &bull; Make Memories</span>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-[#3F322A]/85 leading-relaxed max-w-xs">
                        Hadirkan pengalaman menyenangkan dan kebersamaan bersama kucing-kucing kesayangan di Cat House.
                    </p>

                    <div class="flex items-center gap-3 pt-1">
                        <a href="https://wa.me/6285222883700" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="w-9 h-9 rounded-full bg-[#E58B9C] text-white flex items-center justify-center text-base hover:bg-[#D77487] transition">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="#" aria-label="Instagram" class="w-9 h-9 rounded-full bg-[#E58B9C] text-white flex items-center justify-center text-base hover:bg-[#D77487] transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" aria-label="TikTok" class="w-9 h-9 rounded-full bg-[#E58B9C] text-white flex items-center justify-center text-base hover:bg-[#D77487] transition">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="md:col-span-3">
                    <h4 class="text-sm font-bold text-[#3F322A] mb-3.5">Navigasi Cepat</h4>
                    <ul class="space-y-2 text-xs sm:text-sm text-[#3F322A]/90">
                        <li><a href="{{ route('home') }}" class="hover:text-[#D77487] transition">Beranda</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-[#D77487] transition">Tentang Kami</a></li>
                        <li><a href="{{ route('reservasi.create') }}" class="hover:text-[#D77487] transition">Reservasi</a></li>
                        <li><a href="{{ route('cats.index') }}" class="hover:text-[#D77487] transition">Kucing Kami</a></li>
                        <li><a href="{{ route('home') }}#kontak" class="hover:text-[#D77487] transition">Kontak</a></li>
                    </ul>
                </div>

                <!-- Contact & Address -->
                <div class="md:col-span-4 space-y-4">
                    <div class="flex items-center gap-2.5 text-xs sm:text-sm font-medium text-[#3F322A]">
                        <i class="fa-solid fa-phone text-[#3F322A]"></i>
                        <span>0852-2288-3700</span>
                    </div>
                    <p class="text-xs sm:text-sm text-[#3F322A]/90 leading-relaxed">
                        Jl. Ir. P. M. Noor, Padang Panjang,<br>
                        Kec. Karang Intan, Kabupaten Banjar,<br>
                        Kalimantan Selatan 70661
                    </p>
                </div>
            </div>

            <!-- Divider & Copyright -->
            <div class="border-t border-[#3F322A]/40 mt-10 pt-5 text-center">
                <p class="text-xs text-[#3F322A]/85">
                    &copy; {{ date('Y') }} Cat House. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });

        // Mencegah halaman ditampilkan dari back-forward cache browser setelah logout
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
    @auth
        <!-- Logout Confirmation Modal -->
        <div id="logoutConfirmModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs opacity-0 pointer-events-none transition-all duration-300">
            <div class="bg-white rounded-3xl p-6 sm:p-7 max-w-sm w-full shadow-2xl border border-[#FFDAE1] transform scale-95 transition-all duration-300 text-center relative" id="logoutModalCard">
                <button type="button" onclick="closeLogoutModal()" class="absolute top-4 right-4 text-stone-400 hover:text-stone-600 p-1.5 rounded-full hover:bg-stone-100 transition cursor-pointer" aria-label="Tutup">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center text-2xl shadow-sm border border-red-100">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </div>
                <h3 class="text-xl font-extrabold text-[#3F322A] mb-2 font-serif">Yakin Ingin Logout?</h3>
                <p class="text-sm text-stone-600 mb-6 leading-relaxed">
                    Sesi akun Anda akan diakhiri. Anda perlu login kembali untuk mengakses layanan ini.
                </p>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="closeLogoutModal()" class="w-full py-2.5 px-4 rounded-xl border border-stone-200 text-stone-700 font-bold text-sm hover:bg-stone-100 transition active:scale-95 cursor-pointer">
                        Batal
                    </button>
                    <button type="button" id="confirmLogoutSubmitBtn" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 text-white font-bold text-sm shadow-md hover:from-red-600 hover:to-rose-700 hover:shadow-lg transition active:scale-95 cursor-pointer">
                        Ya, Logout
                    </button>
                </div>
            </div>
        </div>

        <script>
            let pendingLogoutForm = null;

            function openLogoutModal(form) {
                pendingLogoutForm = form;
                const modal = document.getElementById('logoutConfirmModal');
                const card = document.getElementById('logoutModalCard');
                if (!modal) return;

                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.classList.add('opacity-100', 'pointer-events-auto');
                if (card) {
                    card.classList.remove('scale-95');
                    card.classList.add('scale-100');
                }
            }

            function closeLogoutModal() {
                pendingLogoutForm = null;
                const modal = document.getElementById('logoutConfirmModal');
                const card = document.getElementById('logoutModalCard');
                if (!modal) return;

                modal.classList.remove('opacity-100', 'pointer-events-auto');
                modal.classList.add('opacity-0', 'pointer-events-none');
                if (card) {
                    card.classList.remove('scale-100');
                    card.classList.add('scale-95');
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const confirmBtn = document.getElementById('confirmLogoutSubmitBtn');
                if (confirmBtn) {
                    confirmBtn.addEventListener('click', function () {
                        if (pendingLogoutForm) {
                            pendingLogoutForm.dataset.confirmed = 'true';
                            pendingLogoutForm.submit();
                        }
                    });
                }

                // Intercept all logout form submissions
                document.addEventListener('submit', function (e) {
                    const form = e.target;
                    if (form && form.getAttribute('action') && form.getAttribute('action').includes('/logout')) {
                        if (!form.dataset.confirmed) {
                            e.preventDefault();
                            openLogoutModal(form);
                        }
                    }
                });

                // Close on backdrop click
                const modal = document.getElementById('logoutConfirmModal');
                if (modal) {
                    modal.addEventListener('click', function (e) {
                        if (e.target === modal) {
                            closeLogoutModal();
                        }
                    });
                }

                // Close on Escape key
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        closeLogoutModal();
                    }
                });
            });
        </script>

        @if(Auth::user()->role === 'user')
        <script>
            // Khusus user: auto logout jika tidak ada aktivitas selama 15 menit
            (function() {
                let idleSeconds = 0;
                const maxIdleSeconds = 15 * 60; // 15 menit

                function resetTimer() {
                    idleSeconds = 0;
                }

                ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'].forEach(function(evt) {
                    window.addEventListener(evt, resetTimer, { passive: true });
                });

                setInterval(function() {
                    idleSeconds++;
                    if (idleSeconds >= maxIdleSeconds) {
                        window.location.href = "{{ route('logout.idle') }}";
                    }
                }, 1000);
            })();
        </script>
        @endif
    @endauth
    @yield('scripts')
</body>
</html>
