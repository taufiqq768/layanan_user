<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f5f5f5;
    }

    .layout-container {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 260px;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        color: white;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar-header {
        padding: 25px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        text-align: center;
    }

    .sidebar-header h2 {
        font-size: 1.3em;
        margin-bottom: 5px;
    }

    .sidebar-header p {
        font-size: 0.85em;
        opacity: 0.9;
    }

    .sidebar-menu {
        padding: 20px 0;
    }

    .menu-section {
        margin-bottom: 25px;
    }

    .menu-section-title {
        padding: 10px 20px;
        font-size: 0.75em;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.7;
        font-weight: 600;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
    }

    .menu-item:hover {
        background: rgba(255, 255, 255, 0.1);
        padding-left: 25px;
    }

    .menu-item.active {
        background: rgba(255, 255, 255, 0.2);
        border-left: 4px solid white;
        padding-left: 16px;
        font-weight: 600;
    }

    .menu-item .icon {
        margin-right: 12px;
        font-size: 1.2em;
        width: 24px;
        text-align: center;
    }

    .menu-item .text {
        flex: 1;
    }

    .menu-item .badge {
        background: rgba(255, 255, 255, 0.3);
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.75em;
        font-weight: 600;
    }

    .sidebar-footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(0, 0, 0, 0.1);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.2em;
    }

    .user-details {
        flex: 1;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.9em;
    }

    .user-role {
        font-size: 0.75em;
        opacity: 0.8;
    }

    .logout-btn {
        width: 100%;
        padding: 10px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9em;
        font-weight: 600;
    }

    .logout-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    /* Main Content */
    .main-content {
        margin-left: 260px;
        flex: 1;
        padding: 30px;
        width: calc(100% - 260px);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .main-content {
            margin-left: 0;
            width: 100%;
        }

        .sidebar-footer {
            position: relative;
        }
    }

    /* Hamburger Menu for Mobile */
    .mobile-menu-toggle {
        display: none;
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1001;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 15px;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .mobile-menu-toggle {
            display: block;
        }

        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .sidebar.active {
            transform: translateX(0);
        }
    }
</style>

<div class="layout-container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo PTPN I" class="logo">
            <h4>Helpdesk Layanan Aplikasi PTPN I</h4>
            <h2></h2>
            <p>Admin Panel</p>
        </div>

        <div class="sidebar-menu">
            <!-- Main Menu -->
            <div class="menu-section">
                <div class="menu-section-title">Menu Utama</div>
                <a href="{{ route('layanan.admin') }}"
                    class="menu-item {{ request()->routeIs('layanan.admin') ? 'active' : '' }}">
                    <span class="icon">📋</span>
                    <span class="text">Dashboard</span>
                    @if(isset($stats['pending']) && $stats['pending'] > 0)
                        <span class="badge">{{ $stats['pending'] }}</span>
                    @endif
                </a>
                <a href="{{ route('layanan.index') }}"
                    class="menu-item {{ request()->routeIs('layanan.index') ? 'active' : '' }}">
                    <span class="icon">🏠</span>
                    <span class="text">Halaman User</span>
                </a>
            </div>

            <!-- Pertanyaan -->
            <div class="menu-section">
                <div class="menu-section-title">Pertanyaan</div>
                <a href="{{ route('layanan.admin') }}?status=pending"
                    class="menu-item {{ request()->get('status') == 'pending' ? 'active' : '' }}">
                    <span class="icon">⏳</span>
                    <span class="text">Pending</span>
                    @if(isset($stats['pending']))
                        <span class="badge">{{ $stats['pending'] }}</span>
                    @endif
                </a>
                <a href="{{ route('layanan.admin') }}?status=replied"
                    class="menu-item {{ request()->get('status') == 'replied' ? 'active' : '' }}">
                    <span class="icon">✅</span>
                    <span class="text">Dijawab</span>
                    @if(isset($stats['replied']))
                        <span class="badge">{{ $stats['replied'] }}</span>
                    @endif
                </a>
                <a href="{{ route('layanan.admin') }}?status=closed"
                    class="menu-item {{ request()->get('status') == 'closed' ? 'active' : '' }}">
                    <span class="icon">🔒</span>
                    <span class="text">Closed</span>
                    @if(isset($stats['closed']))
                        <span class="badge">{{ $stats['closed'] }}</span>
                    @endif
                </a>
            </div>

            <!-- Aplikasi (jika admin bisa akses lebih dari 1) -->
            <!-- @auth('admin')
                @php
                    $adminAplikasi = auth()->guard('admin')->user()->adminAplikasi ?? collect();
                @endphp
                @if($adminAplikasi->count() > 1)
                    <div class="menu-section">
                        <div class="menu-section-title">Filter Aplikasi</div>
                        <a href="{{ route('layanan.admin') }}" class="menu-item {{ !request()->get('aplikasi') ? 'active' : '' }}">
                            <span class="icon">📱</span>
                            <span class="text">Semua Aplikasi</span>
                        </a>
                        @foreach($adminAplikasi as $adminApp)
                            <a href="{{ route('layanan.admin') }}?aplikasi={{ $adminApp->aplikasi }}"
                               class="menu-item {{ request()->get('aplikasi') == $adminApp->aplikasi ? 'active' : '' }}">
                                <span class="icon">•</span>
                                <span class="text">{{ $adminApp->aplikasi }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endauth -->

            <!-- Pengaturan -->
            @if(auth()->guard('admin')->check() && auth()->guard('admin')->user()->name === 'superadmin')
                <div class="menu-section">
                    <div class="menu-section-title">Pengaturan</div>
                    <a href="{{ route('manajemen.admin.index') }}"
                        class="menu-item {{ request()->routeIs('manajemen.admin.*') ? 'active' : '' }}">
                        <span class="icon">👥</span>
                        <span class="text">Kelola Admin</span>
                    </a>
                    <a href="{{ route('manajemen.aplikasi.index') }}"
                        class="menu-item {{ request()->routeIs('manajemen.aplikasi.*') ? 'active' : '' }}">
                        <span class="icon">📱</span>
                        <span class="text">Kelola Aplikasi</span>
                    </a>
                    <a href="{{ route('manajemen.faq.index') }}"
                        class="menu-item {{ request()->routeIs('manajemen.faq.*') ? 'active' : '' }}">
                        <span class="icon">❓</span>
                        <span class="text">Kelola FAQ</span>
                    </a>
                </div>
             @endif
   </div>

        <div class="sidebar-footer">
            @auth('admin')
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->guard('admin')->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ auth()->guard('admin')->user()->name }}</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        🚪 Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        ☰
    </button>

    <!-- Main Content -->
    <div class="main-content">
        {{ $slot }}
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.mobile-menu-toggle');

        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
</script>