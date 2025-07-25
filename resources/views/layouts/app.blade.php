<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dewa Motor Admin')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/pages/layouts/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/layouts/admin-enhancements.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vehicle-photos.css') }}">
    
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="brand-section">
                    <div class="brand-icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="brand-text">
                        <h3>Dewa Motor</h3>
                        <span>Admin Panel</span>
                    </div>
                </div>
                <button id="sidebarToggle" class="sidebar-toggle" title="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="sidebar-menu">
                <ul class="menu-list">
                    <li class="menu-item" data-entity="dashboard">
                        <a href="/" class="menu-link" data-tooltip="Dashboard" data-route="admin.dashboard,home">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="menu-item" data-entity="kendaraans">
                        <a href="{{ route('kendaraans.index') }}" class="menu-link" data-tooltip="Kelola Kendaraan" data-route="kendaraans">
                            <i class="fas fa-motorcycle"></i>
                            <span>Kelola Kendaraan</span>
                        </a>
                    </li>
                    <li class="menu-item" data-entity="dokumen-kendaraans">
                        <a href="{{ route('dokumen-kendaraans.index') }}" class="menu-link" data-tooltip="Dokumen Kendaraan" data-route="dokumen-kendaraans">
                            <i class="fas fa-file-alt"></i>
                            <span>Dokumen Kendaraan</span>
                        </a>
                    </li>
                    <li class="menu-item" data-entity="categories">
                        <a href="{{ route('categories.index') }}" class="menu-link" data-tooltip="Kelola Kategori" data-route="categories">
                            <i class="fas fa-tags"></i>
                            <span>Kelola Kategori</span>
                        </a>
                    </li>
                    <li class="menu-item" data-entity="store">
                        <a href="{{ route('store.index') }}" class="menu-link" data-tooltip="Halaman Store" data-route="store">
                            <i class="fas fa-store"></i>
                            <span>Halaman Store</span>
                        </a>
                    </li>
                    <li class="menu-item" data-entity="admin">
                        <a href="{{ route('admin.token-info') }}" class="menu-link" data-tooltip="Token Admin" data-route="admin.token-info">
                            <i class="fas fa-key"></i>
                            <span>Token Admin</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="menu-link logout-link" data-tooltip="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="admin-main">
            <!-- Top Navigation -->
            <nav class="admin-navbar">
                <div class="navbar-content">
                    <div class="navbar-left">
                        <button class="mobile-toggle" id="mobileToggle">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="page-title-container">
                            <h5 class="page-title" id="pageTitle">@yield('page-title', 'Dashboard')</h5>
                            <div class="page-indicator" id="pageIndicator"></div>
                        </div>
                    </div>
                    <div class="navbar-right">
                        <div class="user-info">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Page Content -->
            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/admin-enhancements.js') }}"></script>
    
    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mobileToggle = document.getElementById('mobileToggle');
            const sidebar = document.getElementById('sidebar');
            
            // Check localStorage for saved state
            const sidebarState = localStorage.getItem('adminSidebarCollapsed');
            const isCollapsed = sidebarState === 'true';
            
            // Apply saved state only on desktop
            if (window.innerWidth >= 768 && isCollapsed) {
                sidebar.classList.add('collapsed');
            }
            
            // Desktop toggle functionality
            sidebarToggle?.addEventListener('click', function() {
                const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');
                
                if (isCurrentlyCollapsed) {
                    sidebar.classList.remove('collapsed');
                    localStorage.setItem('adminSidebarCollapsed', 'false');
                } else {
                    sidebar.classList.add('collapsed');
                    localStorage.setItem('adminSidebarCollapsed', 'true');
                }
            });
            
            // Mobile toggle functionality
            mobileToggle?.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 768 && 
                    sidebar.classList.contains('mobile-open') &&
                    !sidebar.contains(event.target) && 
                    !mobileToggle.contains(event.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    // Desktop: Remove mobile classes and restore collapsed state
                    sidebar.classList.remove('mobile-open');
                    const savedState = localStorage.getItem('adminSidebarCollapsed');
                    if (savedState === 'true') {
                        sidebar.classList.add('collapsed');
                    }
                } else {
                    // Mobile: Remove collapsed class and close mobile menu
                    sidebar.classList.remove('collapsed', 'mobile-open');
                }
            });
            
            // Enhanced active class logic with route-based matching
            function setActiveMenuItem() {
                const currentRoute = '{{ Route::currentRouteName() }}';
                const currentPath = window.location.pathname;
                const menuItems = document.querySelectorAll('.menu-item');
                const pageIndicator = document.getElementById('pageIndicator');
                
                // Remove all active classes first
                menuItems.forEach(item => {
                    item.classList.remove('active');
                });
                
                // Find and set active menu item
                const menuLinks = document.querySelectorAll('.menu-link');
                let activeSet = false;
                let activePageTitle = 'Dashboard';
                
                // Sort links by route specificity (more specific routes first)
                const sortedLinks = Array.from(menuLinks).sort((a, b) => {
                    const routesA = a.getAttribute('data-route') || '';
                    const routesB = b.getAttribute('data-route') || '';
                    return routesB.length - routesA.length;
                });
                
                sortedLinks.forEach(link => {
                    if (activeSet) return; // Skip if already found active item
                    
                    const href = link.getAttribute('href');
                    const routes = link.getAttribute('data-route');
                    const tooltip = link.getAttribute('data-tooltip');
                    
                    if (routes) {
                        const routeArray = routes.split(',');
                        
                        // Check for exact route match first
                        if (routeArray.some(route => currentRoute === route.trim())) {
                            link.closest('.menu-item').classList.add('active');
                            activePageTitle = tooltip || 'Dashboard';
                            activeSet = true;
                            return;
                        }
                        
                        // Check for route prefix match (more specific)
                        if (routeArray.some(route => currentRoute.startsWith(route.trim() + '.'))) {
                            link.closest('.menu-item').classList.add('active');
                            activePageTitle = tooltip || 'Dashboard';
                            activeSet = true;
                            return;
                        }
                    }
                });
                
                // Fallback to path-based matching only if no route match found
                if (!activeSet) {
                    sortedLinks.forEach(link => {
                        if (activeSet) return;
                        
                        const href = link.getAttribute('href');
                        const tooltip = link.getAttribute('data-tooltip');
                        
                        if (href && href !== '#') {
                            // Exact path match
                            if (href === currentPath) {
                                link.closest('.menu-item').classList.add('active');
                                activePageTitle = tooltip || 'Dashboard';
                                activeSet = true;
                                return;
                            }
                            
                            // Path contains match (but avoid substring conflicts)
                            if (href !== '/' && currentPath.startsWith(href + '/')) {
                                link.closest('.menu-item').classList.add('active');
                                activePageTitle = tooltip || 'Dashboard';
                                activeSet = true;
                                return;
                            }
                            
                            // Home/dashboard specific handling
                            if (href === '/' && (currentPath === '/' || currentPath === '/home')) {
                                link.closest('.menu-item').classList.add('active');
                                activePageTitle = tooltip || 'Dashboard';
                                activeSet = true;
                                return;
                            }
                        }
                    });
                }
                
                // Special handling for admin dashboard routes (last resort)
                if (!activeSet && (currentRoute === 'admin.dashboard' || currentRoute === 'home' || currentPath === '/' || currentPath === '/home')) {
                    const dashboardLink = document.querySelector('[data-route*="admin.dashboard"]');
                    if (dashboardLink) {
                        dashboardLink.closest('.menu-item').classList.add('active');
                        activePageTitle = 'Dashboard';
                    }
                }
                
                // Update page indicator
                if (pageIndicator) {
                    pageIndicator.classList.add('active');
                }
            }
            
            // Call the function on page load
            setActiveMenuItem();
            
            // Add click handlers for menu links to provide immediate feedback
            const menuLinks = document.querySelectorAll('.menu-link:not(.logout-link)');
            menuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Remove active class from all items
                    document.querySelectorAll('.menu-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    
                    // Add active class to clicked item
                    this.closest('.menu-item').classList.add('active');
                    
                    // Add a loading indicator (optional)
                    const icon = this.querySelector('i');
                    const originalClass = icon.className;
                    icon.className = 'fas fa-spinner fa-spin';
                    
                    // Restore original icon after a short delay (in case of slow navigation)
                    setTimeout(() => {
                        icon.className = originalClass;
                    }, 1000);
                });
            });
            
            // Enhanced tooltip positioning for collapsed sidebar
            function updateTooltipPositions() {
                if (sidebar.classList.contains('collapsed')) {
                    const menuLinks = document.querySelectorAll('.admin-sidebar.collapsed .menu-link');
                    menuLinks.forEach(link => {
                        const rect = link.getBoundingClientRect();
                        const tooltipData = link.getAttribute('data-tooltip');
                        
                        if (tooltipData) {
                            // Update tooltip positioning based on viewport
                            const viewportHeight = window.innerHeight;
                            const linkTop = rect.top;
                            
                            if (linkTop > viewportHeight * 0.7) {
                                link.style.setProperty('--tooltip-position', 'top');
                            } else {
                                link.style.setProperty('--tooltip-position', 'center');
                            }
                        }
                    });
                }
            }
            
            // Update tooltip positions on scroll and resize
            window.addEventListener('scroll', updateTooltipPositions);
            window.addEventListener('resize', updateTooltipPositions);
            
            // Prevent tooltip flicker on hover
            if (window.innerWidth >= 768) {
                const collapsedLinks = document.querySelectorAll('.admin-sidebar.collapsed .menu-link');
                collapsedLinks.forEach(link => {
                    link.addEventListener('mouseenter', function() {
                        if (sidebar.classList.contains('collapsed')) {
                            this.style.zIndex = '1002';
                        }
                    });
                    link.addEventListener('mouseleave', function() {
                        this.style.zIndex = '';
                    });
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
