<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard - Cat House')</title>

    <!-- Admin Styles (Poppins font + custom CSS) -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        admintext: '#7A5E48',
                        accent: '#E58B9C',
                        sidebar: '#3E2723',
                        sidebardark: '#2C1B17',
                        cream: '#F8F6E8',
                        tan: '#EBD9C3',
                        pagebg: '#F5F5F5',
                    }
                }
            }
        }
    </script>
    @yield('styles')
</head>
<body class="bg-pagebg text-admintext flex h-screen overflow-hidden relative">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-stone-900/60 z-40 backdrop-blur-xs hidden transition-opacity duration-300 lg:hidden"></div>

    <!-- Sidebar (Responsive Drawer on Mobile/Zoom, Fixed on Desktop) -->
    <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85vw] bg-sidebar flex flex-col transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:w-64 lg:flex-shrink-0 lg:z-auto shadow-2xl lg:shadow-none h-full">
        <!-- Logo & Mobile Close Button -->
        <div class="h-16 sm:h-20 flex items-center justify-between px-5 sm:px-6 border-b border-white/10 flex-shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-accent/30 text-accent flex items-center justify-center text-xl shadow-md flex-shrink-0">
                    <i class="fa-solid fa-cat"></i>
                </div>
                <div class="min-w-0">
                    <span class="text-cream font-bold text-base leading-none block truncate">Cat House Admin</span>
                    <span class="text-xs text-tan font-semibold tracking-wider truncate block">Cat House Management</span>
                </div>
            </div>
            <!-- Mobile Close Button -->
            <button id="sidebarClose" type="button" class="lg:hidden p-2 text-cream/70 hover:text-cream hover:bg-white/10 rounded-xl transition" aria-label="Tutup Menu">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigation Links (Scrollable area with custom scrollbar matching dashboard bg #F5F5F5) -->
        <nav class="flex-1 overflow-y-auto min-h-0 px-4 py-4 sm:py-6 space-y-1.5 text-sm font-medium sidebar-scroll">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-accent text-cream font-bold shadow-sm' : 'text-cream/80 hover:bg-accent/50 hover:text-cream' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            <div class="pt-4 pb-1 px-3 text-[11px] font-bold text-accent uppercase tracking-wider">Master Data</div>

            <a href="{{ route('admin.kucing.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.kucing.*') ? 'bg-accent text-cream font-bold shadow-sm' : 'text-cream/80 hover:bg-accent/50 hover:text-cream' }}">
                <i class="fa-solid fa-paw w-5 text-center"></i>
                <span>Data Kucing</span>
            </a>

            <a href="{{ route('admin.variants.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.variants.*') ? 'bg-accent text-cream font-bold shadow-sm' : 'text-cream/80 hover:bg-accent/50 hover:text-cream' }}">
                <i class="fa-solid fa-tags w-5 text-center"></i>
                <span>Varian Jenis</span>
            </a>

            <a href="{{ route('admin.sessions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.sessions.*') ? 'bg-accent text-cream font-bold shadow-sm' : 'text-cream/80 hover:bg-accent/50 hover:text-cream' }}">
                <i class="fa-solid fa-clock w-5 text-center"></i>
                <span>Sesi & Kuota</span>
            </a>

            <div class="pt-4 pb-1 px-3 text-[11px] font-bold text-accent uppercase tracking-wider">Transaksi & Layanan</div>

            <a href="{{ route('admin.reservations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.reservations.*') ? 'bg-accent text-cream font-bold shadow-sm' : 'text-cream/80 hover:bg-accent/50 hover:text-cream' }}">
                <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                <span>Data Reservasi</span>
            </a>

            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.payments.*') ? 'bg-accent text-cream font-bold shadow-sm' : 'text-cream/80 hover:bg-accent/50 hover:text-cream' }}">
                <i class="fa-solid fa-receipt w-5 text-center"></i>
                <span>Laporan Pembayaran</span>
            </a>

            <a href="{{ route('admin.feedbacks.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.feedbacks.*') ? 'bg-accent text-cream font-bold shadow-sm' : 'text-cream/80 hover:bg-accent/50 hover:text-cream' }}">
                <i class="fa-solid fa-comments w-5 text-center"></i>
                <span>Moderasi Feedback</span>
            </a>

            <div class="pt-4 pb-1 px-3 text-[11px] font-bold text-accent uppercase tracking-wider">Sistem</div>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-accent text-cream font-bold shadow-sm' : 'text-cream/80 hover:bg-accent/50 hover:text-cream' }}">
                <i class="fa-solid fa-users w-5 text-center"></i>
                <span>Kelola Pengguna</span>
            </a>

            <div class="pt-6">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-accent hover:bg-accent/50 hover:text-cream transition">
                    <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center"></i>
                    <span>Lihat Halaman Cat House</span>
                </a>
            </div>
        </nav>

        <!-- User bottom section -->
        <div class="p-4 border-t border-white/10 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-xl bg-accent text-white font-bold flex items-center justify-center text-xs flex-shrink-0">
                    <i class="fa-solid fa-user-shield text-sm"></i>
                </div>
                <div class="text-xs min-w-0">
                    <p class="font-bold text-cream truncate max-w-[120px]">{{ Auth::user()->nama_pelanggan }}</p>
                    <p class="text-tan">Admin</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" title="Logout" class="p-2 text-tan hover:text-red-400 hover:bg-white/10 rounded-lg transition flex-shrink-0">
                    <i class="fa-solid fa-power-off"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Section -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Topbar Header -->
        <header class="h-16 sm:h-20 bg-white border-b border-admintext/10 px-4 sm:px-6 lg:px-8 flex items-center justify-between flex-shrink-0 gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <!-- Hamburger Menu Button on Mobile/Tablet -->
                <button id="sidebarToggle" type="button" class="lg:hidden p-2 rounded-xl text-admintext hover:bg-stone-100 hover:text-accent focus:outline-none focus:ring-2 focus:ring-accent transition flex-shrink-0" aria-label="Buka Menu">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="min-w-0">
                    <h1 class="text-lg sm:text-xl font-bold text-admintext truncate">@yield('page_title', 'Dashboard')</h1>
                    <p class="text-xs text-admintext/70 hidden sm:block truncate">Sistem Informasi Manajemen Cat House</p>
                </div>
            </div>
            <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
                <span class="text-[11px] sm:text-xs bg-emerald-100 text-emerald-800 font-semibold px-2.5 sm:px-3 py-1 rounded-full flex items-center gap-1.5 whitespace-nowrap">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Sistem Aktif
                </span>
                <span class="text-xs text-admintext/60 hidden md:inline whitespace-nowrap">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto min-h-0 p-4 sm:p-6 lg:p-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg flex-shrink-0"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 ml-2">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3 min-w-0">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg flex-shrink-0"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 ml-2">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Responsive Sidebar Drawer Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const toggleBtn = document.getElementById('sidebarToggle');
            const closeBtn = document.getElementById('sidebarClose');

            function openSidebar() {
                if (!sidebar || !backdrop) return;
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            }

            function closeSidebar() {
                if (!sidebar || !backdrop) return;
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);

            // Close on Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeSidebar();
            });

            // Close when clicking nav links on mobile
            if (sidebar) {
                sidebar.querySelectorAll('nav a').forEach(function (link) {
                    link.addEventListener('click', function () {
                        if (window.innerWidth < 1024) {
                            closeSidebar();
                        }
                    });
                });
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
