<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Track Tech Solutions') - Garment Production Management</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #0b1322;
            --sidebar-hover: #172439;
            --primary-blue: #2563eb;
            --primary-blue-hover: #1d4ed8;
            --bg-canvas: #f8fafc;
            --card-border: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-canvas);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* Scrollable Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            height: 100vh;
            color: #ffffff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            padding: 1.25rem 1rem;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .brand-section {
            padding: 0.5rem 0.75rem 1.25rem 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
        }

        .brand-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .brand-subtitle {
            font-size: 0.65rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 4px;
        }

        /* Scrollable Nav Items Area */
        .sidebar-nav-container {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 4px;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        /* Custom Sleek Scrollbar for Sidebar */
        .sidebar-nav-container::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-nav-container::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }
        .sidebar-nav-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }
        .sidebar-nav-container::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .sidebar-section-title {
            font-size: 0.65rem;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 1.1rem 0.75rem 0.4rem;
        }

        .sidebar .nav-item {
            margin-bottom: 3px;
        }

        .sidebar .nav-link {
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.86rem;
            padding: 0.65rem 0.9rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.15s ease-in-out;
        }

        .sidebar .nav-link i {
            font-size: 1.05rem;
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: var(--sidebar-hover);
        }

        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: var(--primary-blue);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        /* User Profile & Logout in Sidebar Footer */
        .sidebar-user-footer {
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            flex-shrink: 0;
        }

        .logout-btn-custom {
            color: #f87171;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            font-size: 0.78rem;
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 8px;
            transition: all 0.15s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }

        .logout-btn-custom:hover {
            color: #ffffff;
            background: #ef4444;
            border-color: #ef4444;
        }

        /* Main Workspace Wrapper */
        .main-wrapper {
            margin-left: 260px;
            padding: 2rem 2.5rem;
            min-height: 100vh;
        }

        /* Top Header */
        .page-top-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .page-header-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.02em;
            margin-bottom: 2px;
        }

        .page-header-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin: 0;
        }

        .status-online-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #10b981;
            background: rgba(16, 185, 129, 0.08);
            padding: 4px 12px;
            border-radius: 20px;
        }

        .status-online-dot {
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 8px #10b981;
        }

        /* UI Cards */
        .card-custom {
            background-color: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--card-border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            margin-bottom: 1.5rem;
        }

        .card-custom-body {
            padding: 1.5rem 1.75rem;
        }

        .card-custom-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .card-custom-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 1.25rem;
        }

        /* Buttons */
        .btn-primary-blue {
            background-color: var(--primary-blue);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.65rem 1.4rem;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
            transition: all 0.15s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-blue:hover {
            background-color: var(--primary-blue-hover);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-outline-custom {
            background-color: #ffffff;
            border: 1px solid var(--card-border);
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.65rem 1.25rem;
            border-radius: 10px;
        }

        .btn-outline-custom:hover {
            background-color: #f1f5f9;
            color: var(--text-dark);
        }

        /* Form Controls */
        .form-control-custom, .form-select-custom {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-control-custom:focus, .form-select-custom:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        /* Metric Summary Cards */
        .metric-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.5rem;
            height: 100%;
        }

        .metric-card-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .metric-card-value {
            font-size: 2.1rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .metric-card-subtext {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        /* Table Styling */
        .table-custom {
            width: 100%;
            margin-bottom: 0;
        }

        .table-custom th {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            background-color: #f8fafc;
            padding: 0.85rem 1.25rem;
            border-bottom: 1px solid var(--card-border);
        }

        .table-custom td {
            padding: 1rem 1.25rem;
            font-size: 0.88rem;
            color: var(--text-dark);
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-custom tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge-active {
            background-color: #dcfce7;
            color: #166534;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .badge-inactive {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }
            .sidebar-nav-container {
                overflow-y: visible;
            }
            .main-wrapper {
                margin-left: 0;
                padding: 1.5rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    @auth
    <!-- Dark Sidebar -->
    <aside class="sidebar">
        <!-- Brand Header (Fixed Top) -->
        <div class="brand-section">
            <h1 class="brand-title">Track Tech<br>Solutions</h1>
            <div class="brand-subtitle">Garment Production System</div>
        </div>

        <!-- Scrollable Navigation Menu Container -->
        <div class="sidebar-nav-container">
            <!-- MAIN MENU -->
            <div class="sidebar-section-title">Main Menu</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.bundles') ? 'active' : '' }}" href="{{ route('production.bundles') }}">
                        <i class="bi bi-layers-fill"></i> Production Bundles
                    </a>
                </li>
            </ul>



            <!-- 1. ORDER & PLANNING -->
            <div class="sidebar-section-title">1. Order & Planning</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('buyer-orders.*') ? 'active' : '' }}" href="{{ route('buyer-orders.index') }}">
                        <i class="bi bi-cart-check"></i> Buyer Orders (PO)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('sales-orders.*') ? 'active' : '' }}" href="{{ route('sales-orders.index') }}">
                        <i class="bi bi-receipt"></i> Sales Orders (ERP)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production-plans.*') ? 'active' : '' }}" href="{{ route('production-plans.index') }}">
                        <i class="bi bi-calendar-event"></i> Production Planning
                    </a>
                </li>
            </ul>

            <!-- 2. FABRIC ERP & STORE -->
            <div class="sidebar-section-title">2. Fabric ERP & Store</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabrics.*') ? 'active' : '' }}" href="{{ route('fabrics.index') }}">
                        <i class="bi bi-aspect-ratio"></i> Fabric Master
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-pos.*') ? 'active' : '' }}" href="{{ route('fabric-pos.index') }}">
                        <i class="bi bi-bag-plus"></i> Fabric Procurement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-grns.*') ? 'active' : '' }}" href="{{ route('fabric-grns.index') }}">
                        <i class="bi bi-box-arrow-in-down"></i> Receiving & GRN
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-inspections.*') ? 'active' : '' }}" href="{{ route('fabric-inspections.index') }}">
                        <i class="bi bi-patch-check"></i> 4-Point Inspection
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-relaxations.*') ? 'active' : '' }}" href="{{ route('fabric-relaxations.index') }}">
                        <i class="bi bi-clock-history"></i> Fabric Relaxation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-groups.*') ? 'active' : '' }}" href="{{ route('fabric-groups.index') }}">
                        <i class="bi bi-collection-fill"></i> Fabric Groups
                    </a>
                </li>
            </ul>

            <!-- 3. CUT ROOM & LAY -->
            <div class="sidebar-section-title">3. Cut Room & Lay</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cut-planning.*') ? 'active' : '' }}" href="{{ route('cut-planning.index') }}">
                        <i class="bi bi-rulers"></i> Cut Room Planner
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lay-models.*') ? 'active' : '' }}" href="{{ route('lay-models.index') }}">
                        <i class="bi bi-bounding-box"></i> Lay Models
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lay-slips.*') ? 'active' : '' }}" href="{{ route('lay-slips.index') }}">
                        <i class="bi bi-grid-3x3-gap"></i> Lay Slips (Completed)
                    </a>
                </li>
            </ul>

            <!-- 4. PRODUCTION SECTIONS -->
            <div class="sidebar-section-title">4. Production Sections</div>
            <ul class="nav flex-column mb-3">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.cutting') ? 'active' : '' }}" href="{{ route('production.cutting') }}">
                        <i class="bi bi-scissors"></i> Cutting
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.sewing') ? 'active' : '' }}" href="{{ route('production.sewing') }}">
                        <i class="bi bi-gear-wide-connected"></i> Sewing
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.quality') ? 'active' : '' }}" href="{{ route('production.quality') }}">
                        <i class="bi bi-check-circle-fill"></i> Quality
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.packing') ? 'active' : '' }}" href="{{ route('production.packing') }}">
                        <i class="bi bi-box-seam-fill"></i> Packing
                    </a>
                </li>
            </ul>
        </div>


        <!-- User Profile & Logout Footer (Fixed Bottom) -->
        <div class="sidebar-user-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 overflow-hidden" style="max-width: 140px;">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px; min-width: 34px; font-size: 0.9rem;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="text-truncate">
                        <div class="fw-bold text-white small text-truncate" style="line-height: 1.2;">{{ Auth::user()->name }}</div>
                        <div class="text-muted small" style="font-size: 0.7rem;">{{ Auth::user()->role }}</div>
                    </div>
                </div>

                <!-- Explicit Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="logout-btn-custom" title="Logout from System">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>
    @endauth

    <!-- Main Content Container -->
    <main class="{{ Auth::check() ? 'main-wrapper' : 'container py-5' }}">
        @auth
        <!-- Top Bar Header -->
        <div class="page-top-header">
            <div>
                <h2 class="page-header-title">@yield('page_header_title', 'Production Management')</h2>
                <p class="page-header-subtitle">@yield('page_header_subtitle', 'Track Tech Solutions | Digital Garment Production Management')</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="status-online-badge">
                    <span class="status-online-dot"></span> System Online
                </div>
                @yield('top_header_action')
            </div>
        </div>
        @endauth

        <!-- System Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                <div class="fw-bold mb-1"><i class="bi bi-x-circle-fill me-2"></i> Validation Errors:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
