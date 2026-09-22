<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard - Capyca Pet Cafe')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
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
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-50 text-slate-800 flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col flex-shrink-0 border-r border-slate-800">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-slate-800 gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xl shadow-md">
                <i class="fa-solid fa-cat"></i>
            </div>
            <div>
                <span class="text-white font-bold text-base leading-none block">Capyca Admin</span>
                <span class="text-xs text-amber-400 font-semibold tracking-wider">Cat House Management</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5 text-sm font-medium">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-white font-bold shadow-sm' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            <div class="pt-4 pb-1 px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Master Data</div>

            <a href="{{ route('admin.kucing.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.kucing.*') ? 'bg-amber-500 text-white font-bold shadow-sm' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <i class="fa-solid fa-paw w-5 text-center"></i>
                <span>Data Kucing</span>
            </a>

            <a href="{{ route('admin.variants.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.variants.*') ? 'bg-amber-500 text-white font-bold shadow-sm' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <i class="fa-solid fa-tags w-5 text-center"></i>
                <span>Varian Jenis</span>
            </a>

            <a href="{{ route('admin.sessions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.sessions.*') ? 'bg-amber-500 text-white font-bold shadow-sm' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <i class="fa-solid fa-clock w-5 text-center"></i>
                <span>Sesi & Kuota</span>
            </a>

            <div class="pt-4 pb-1 px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Transaksi & Layanan</div>

            <a href="{{ route('admin.reservations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.reservations.*') ? 'bg-amber-500 text-white font-bold shadow-sm' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                <span>Data Reservasi</span>
            </a>

            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.payments.*') ? 'bg-amber-500 text-white font-bold shadow-sm' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <i class="fa-solid fa-receipt w-5 text-center"></i>
                <span>Laporan Pembayaran</span>
            </a>

            <a href="{{ route('admin.feedbacks.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.feedbacks.*') ? 'bg-amber-500 text-white font-bold shadow-sm' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <i class="fa-solid fa-comments w-5 text-center"></i>
                <span>Moderasi Feedback</span>
            </a>

            <div class="pt-4 pb-1 px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sistem</div>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-amber-500 text-white font-bold shadow-sm' : 'hover:bg-slate-800 text-slate-400 hover:text-slate-200' }}">
                <i class="fa-solid fa-users w-5 text-center"></i>
                <span>Kelola Pengguna</span>
            </a>

            <div class="pt-6">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-amber-400 hover:bg-slate-800 transition">
                    <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center"></i>
                    <span>Lihat Halaman Kafe</span>
                </a>
            </div>
        </nav>

        <!-- User bottom section -->
        <div class="p-4 border-t border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-600 text-white font-bold flex items-center justify-center text-xs">
                    ADM
                </div>
                <div class="text-xs">
                    <p class="font-bold text-white truncate max-w-[110px]">{{ Auth::user()->nama_pelanggan }}</p>
                    <p class="text-slate-400">Administrator</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" title="Logout" class="p-2 text-slate-400 hover:text-red-400 hover:bg-slate-800 rounded-lg transition">
                    <i class="fa-solid fa-power-off"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Section -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-xl font-bold text-slate-800">@yield('page_title', 'Dashboard')</h1>
                <p class="text-xs text-slate-500">Sistem Informasi Manajemen Capyca Pet Cafe</p>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs bg-emerald-100 text-emerald-800 font-semibold px-3 py-1 rounded-full flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Sistem Aktif
                </span>
                <span class="text-xs text-slate-500 hidden sm:inline">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 sm:p-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
