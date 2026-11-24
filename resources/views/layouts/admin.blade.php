<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard - Cat House')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/admin-cat-logo.png') }}">

    <link rel="stylesheet" href="/css/admin.css?v={{ time() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        serif: ['Literata', 'Georgia', 'serif'],
                        literata: ['Literata', 'Georgia', 'serif'],
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

    <div id="sidebarBackdrop" class="fixed inset-0 bg-stone-900/60 z-40 backdrop-blur-xs hidden transition-opacity duration-300 lg:hidden"></div>

    <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85vw] bg-sidebar flex flex-col transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:w-64 lg:flex-shrink-0 lg:z-auto shadow-2xl lg:shadow-none h-full">

        <div class="h-16 sm:h-20 flex items-center justify-between px-5 sm:px-6 border-b border-white/10 flex-shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <img src="{{ asset('images/admin-cat-logo.png') }}" alt="Cat House Logo" class="w-10 h-10 rounded-xl object-contain shadow-md flex-shrink-0">
                <div class="min-w-0">
                    <span class="text-cream font-bold text-base leading-none block truncate">Cat House Admin</span>
                    <span class="text-xs text-tan font-semibold tracking-wider truncate block">Cat House Management</span>
                </div>
            </div>

            <button id="sidebarClose" type="button" class="lg:hidden p-2 text-cream/70 hover:text-cream hover:bg-white/10 rounded-xl transition" aria-label="Tutup Menu">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

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
                <span>Sesi Reservasi</span>
            </a>

            <div class="pt-4 pb-1 px-3 text-[11px] font-bold text-accent uppercase tracking-wider">Transaksi &amp; Layanan</div>

            <a href="{{ route('admin.reservations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.reservations.*') ? 'bg-accent text-cream font-bold shadow-sm' : 'text-cream/80 hover:bg-accent/50 hover:text-cream' }}">
                <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                <span>Data Reservasi</span>
            </a>

            <a href="{{ route('admin.feedbacks.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ request()->routeIs('admin.feedbacks.*') ? 'bg-accent text-cream font-bold shadow-sm' : 'text-cream/80 hover:bg-accent/50 hover:text-cream' }}">
                <i class="fa-solid fa-comments w-5 text-center"></i>
                <span>Feedback</span>
            </a>
        </nav>

        <div class="p-4 border-t border-white/10 flex-shrink-0" id="adminBottomMenuWrapper">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-full bg-accent text-white flex items-center justify-center text-sm flex-shrink-0 shadow-xs">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="relative min-w-0" id="adminHoverZone">
                        <button
                            type="button"
                            id="adminRoleDropdownBtn"
                            class="inline-flex items-center gap-1.5 text-sm font-bold text-cream cursor-pointer focus:outline-none py-1"
                            aria-expanded="false"
                            aria-controls="adminWebsiteDropdown"
                        >
                            <span>Admin</span>
                            <i id="adminRoleChevron" class="fa-solid fa-chevron-down text-[10px] text-cream/80 transition-transform duration-200"></i>
                        </button>

                        <div
                            id="adminWebsiteDropdown"
                            class="hidden absolute left-0 z-50"
                        >
                            <a
                                href="{{ route('home') }}"
                                class="block text-xs font-medium text-white hover:text-accent transition whitespace-nowrap py-0.5"
                            >
                                Lihat Website
                            </a>
                        </div>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="flex-shrink-0">
                    @csrf
                    <button type="submit" title="Logout" class="p-2 text-cream hover:text-red-400 hover:bg-white/10 rounded-lg transition cursor-pointer flex items-center justify-center">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M14 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2v-2" />
                            <path d="M10 12h11" />
                            <path d="M18 8l4 4-4 4" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-white">

        <header class="h-16 sm:h-20 bg-[#FFDAE1] border-b border-[#E58B9C]/35 px-5 sm:px-7 lg:px-8 flex items-center justify-between flex-shrink-0 gap-3">
            <div class="flex items-center gap-3 min-w-0">

                <button id="sidebarToggle" type="button" class="lg:hidden p-2 rounded-xl text-[#3F322A] hover:bg-white/40 focus:outline-none focus:ring-2 focus:ring-accent transition flex-shrink-0 cursor-pointer" aria-label="Buka Menu">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold text-[#3F322A] truncate leading-tight">@yield('page_title', 'Dashboard')</h1>
                    <p class="text-xs text-[#7A5E48] hidden sm:block truncate mt-0.5">Sistem Informasi Manajemen Cat House</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto min-h-0 p-5 sm:p-6 lg:p-8 bg-white">

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

    <script>
        (function () {
            let hideTimer = null;

            function positionAdminDropdown() {
                const hoverZone = document.getElementById('adminHoverZone');
                const menu = document.getElementById('adminWebsiteDropdown');
                if (!hoverZone || !menu) return;

                const rect = hoverZone.getBoundingClientRect();
                const menuHeight = menu.offsetHeight || 24;
                const spaceBelow = window.innerHeight - rect.bottom;

                menu.classList.remove('top-full', 'pt-1', 'bottom-full', 'pb-1');

                if (spaceBelow < menuHeight + 12) {
                    menu.classList.add('bottom-full', 'pb-1');
                } else {
                    menu.classList.add('top-full', 'pt-1');
                }
            }

            function openAdminDropdown() {
                const menu = document.getElementById('adminWebsiteDropdown');
                const chevron = document.getElementById('adminRoleChevron');
                const btn = document.getElementById('adminRoleDropdownBtn');
                if (!menu) return;

                clearTimeout(hideTimer);
                menu.classList.remove('hidden');
                positionAdminDropdown();
                if (chevron) chevron.classList.add('rotate-180');
                if (btn) btn.setAttribute('aria-expanded', 'true');
            }

            function closeAdminDropdown(immediate) {
                const menu = document.getElementById('adminWebsiteDropdown');
                const chevron = document.getElementById('adminRoleChevron');
                const btn = document.getElementById('adminRoleDropdownBtn');
                if (!menu) return;

                const doClose = function () {
                    menu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                };

                clearTimeout(hideTimer);
                if (immediate) {
                    doClose();
                } else {
                    hideTimer = setTimeout(doClose, 140);
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const hoverZone = document.getElementById('adminHoverZone');
                if (!hoverZone) return;

                hoverZone.addEventListener('mouseenter', openAdminDropdown);
                hoverZone.addEventListener('mouseleave', function () {
                    closeAdminDropdown(false);
                });

                window.addEventListener('resize', function () {
                    const menu = document.getElementById('adminWebsiteDropdown');
                    if (menu && !menu.classList.contains('hidden')) {
                        positionAdminDropdown();
                    }
                });
            });
        })();

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

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeSidebar();
            });

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

        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

    <div id="logoutConfirmModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs opacity-0 pointer-events-none transition-all duration-300">
        <div class="bg-white rounded-3xl p-6 sm:p-7 max-w-sm w-full shadow-2xl border border-stone-200 transform scale-95 transition-all duration-300 text-center relative" id="logoutModalCard">
            <button type="button" onclick="closeLogoutModal()" class="absolute top-4 right-4 text-stone-400 hover:text-stone-600 p-1.5 rounded-full hover:bg-stone-100 transition cursor-pointer" aria-label="Tutup">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center text-2xl shadow-sm border border-red-100">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
            <h3 class="text-xl font-bold text-stone-800 mb-2">Yakin Ingin Logout?</h3>
            <p class="text-sm text-stone-600 mb-6 leading-relaxed">
                Sesi administrator Anda akan diakhiri. Silakan login kembali untuk mengakses panel admin.
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

            document.addEventListener('submit', function (e) {
                const form = e.target;
                if (form && form.getAttribute('action') && form.getAttribute('action').includes('/logout')) {
                    if (!form.dataset.confirmed) {
                        e.preventDefault();
                        openLogoutModal(form);
                    }
                }
            });

            const modal = document.getElementById('logoutConfirmModal');
            if (modal) {
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        closeLogoutModal();
                    }
                });
            }

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeLogoutModal();
                }
            });
        });
    </script>

    <div id="deleteConfirmModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/45 backdrop-blur-[2px] opacity-0 pointer-events-none transition-all duration-200">
        <div id="deleteModalCard" class="bg-white rounded-[20px] border border-stone-300 shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-200">

            <div class="px-6 py-4 border-b border-stone-300 flex items-center justify-between">
                <h3 class="text-base sm:text-lg font-bold text-[#3F322A]">Konfirmasi Hapus</h3>
                <button type="button" onclick="closeDeleteModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg transition cursor-pointer" aria-label="Tutup">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <div class="px-6 py-6 text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-rose-50 text-[#D95367] border border-rose-200/70 flex items-center justify-center text-2xl">
                    <i class="fa-regular fa-trash-can"></i>
                </div>
                <p id="deleteConfirmMessage" class="text-sm font-semibold text-[#3F322A] leading-relaxed">
                    Apakah Anda yakin ingin menghapus data ini?
                </p>
                <p class="mt-1.5 text-xs text-stone-500">
                    Data yang sudah dihapus tidak dapat dikembalikan lagi.
                </p>
            </div>

            <div class="px-6 py-4 border-t border-stone-300 flex items-center justify-end gap-3 bg-white">
                <button type="button" onclick="closeDeleteModal()" class="px-5 py-2 rounded-lg border border-stone-400 bg-white text-[#3F322A] text-xs sm:text-sm font-medium hover:bg-stone-100 transition cursor-pointer">
                    Batal
                </button>
                <button type="button" id="confirmDeleteSubmitBtn" class="px-5 py-2 rounded-lg bg-[#D95367] hover:bg-[#C14155] text-white text-xs sm:text-sm font-medium transition cursor-pointer">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        let pendingDeleteForm = null;

        function openDeleteModal(form, message) {
            pendingDeleteForm = form;
            const modal = document.getElementById('deleteConfirmModal');
            const card = document.getElementById('deleteModalCard');
            const msgEl = document.getElementById('deleteConfirmMessage');
            if (!modal) return;

            if (msgEl) {
                msgEl.textContent = message || 'Apakah Anda yakin ingin menghapus data ini?';
            }

            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            if (card) {
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }
        }

        function closeDeleteModal() {
            pendingDeleteForm = null;
            const modal = document.getElementById('deleteConfirmModal');
            const card = document.getElementById('deleteModalCard');
            if (!modal) return;

            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            if (card) {
                card.classList.remove('scale-100');
                card.classList.add('scale-95');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const confirmDeleteBtn = document.getElementById('confirmDeleteSubmitBtn');
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', function () {
                    if (pendingDeleteForm) {
                        pendingDeleteForm.dataset.deleteConfirmed = 'true';
                        pendingDeleteForm.submit();
                    }
                });
            }

            document.addEventListener('submit', function (e) {
                const form = e.target;
                if (form && form.hasAttribute('data-delete-confirm')) {
                    if (!form.dataset.deleteConfirmed) {
                        e.preventDefault();
                        openDeleteModal(form, form.getAttribute('data-delete-confirm'));
                    }
                }
            });

            const deleteModal = document.getElementById('deleteConfirmModal');
            if (deleteModal) {
                deleteModal.addEventListener('click', function (e) {
                    if (e.target === deleteModal) {
                        closeDeleteModal();
                    }
                });
            }

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeDeleteModal();
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
