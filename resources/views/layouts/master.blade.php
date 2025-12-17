<!doctype html>

<html lang="en">

<head>
    <title>{{ \App\Helpers\Helper::getCompanyName() }} - @yield('title')</title>
    @include('layouts.meta')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @yield('css')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        a {
            text-decoration: none;
        }

        :root {
            --primary: #1d3557;
            --secondary: #457b9d;
            --accent: #2a9d8f;
            --danger: #e63946;
            --warning: #ffb703;
            --success: #2a9d8f;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --border: #e9ecef;
        }

        body {
            background-color: #f5f7fa;
            color: var(--dark);
            min-height: 100vh;
            display: flex;
        }

        /* LOGOUT */
        .logout-btn {
            background: transparent;
            border: none;
            color: #2a9d8f;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .logout-btn:hover {
            opacity: 0.85;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, var(--primary) 0%, #0d1b2a 100%);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header h2 i {
            color: var(--accent);
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
            border-left-color: var(--accent);
        }

        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent);
        }

        .menu-item i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .menu-item span {
            font-size: 1rem;
            font-weight: 500;
        }

        .menu-divider {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.1);
            margin: 15px 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        /* Top Navigation */
        .top-nav {
            background-color: white;
            padding: 15px 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .nav-left h1 {
            font-size: 1.8rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .date-display {
            background-color: var(--light);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
        }

        /* Dashboard Stats */
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .main-stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s;
        }

        .main-stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
        }

        .stat-icon.green {
            background: linear-gradient(135deg, var(--accent) 0%, #1d7a6b 100%);
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, var(--warning) 0%, #e68a00 100%);
        }

        .stat-icon.red {
            background: linear-gradient(135deg, var(--danger) 0%, #b31b2b 100%);
        }

        .stat-info h3 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .stat-info p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .stat-change {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .stat-change.positive {
            color: var(--success);
        }

        .stat-change.negative {
            color: var(--danger);
        }

        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (max-width: 1200px) {
            .charts-section {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-header h3 {
            font-size: 1.3rem;
            color: var(--primary);
        }

        .chart-actions {
            display: flex;
            gap: 10px;
        }

        .chart-btn {
            background-color: var(--light);
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.9rem;
            color: var(--gray);
            cursor: pointer;
            transition: all 0.3s;
        }

        .chart-btn.active {
            background-color: var(--secondary);
            color: white;
        }

        .chart-container {
            height: 300px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Recent Activities */
        .recent-activities {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .activities-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .activities-header h3 {
            font-size: 1.3rem;
            color: var(--primary);
        }

        .activities-list {
            max-height: 350px;
            overflow-y: auto;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--border);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: white;
        }

        .activity-icon.payment {
            background-color: var(--success);
        }

        .activity-icon.purchase {
            background-color: var(--secondary);
        }

        .activity-icon.warning {
            background-color: var(--warning);
        }

        .activity-details {
            flex: 1;
        }

        .activity-details h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .activity-details p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .activity-time {
            color: var(--gray);
            font-size: 0.85rem;
            white-space: nowrap;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin: 0 auto 15px;
        }

        .action-card.payment .action-icon {
            background: linear-gradient(135deg, var(--success) 0%, #1d7a6b 100%);
        }

        .action-card.purchase .action-icon {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
        }

        .action-card.report .action-icon {
            background: linear-gradient(135deg, var(--warning) 0%, #e68a00 100%);
        }

        .action-card.settings .action-icon {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }

        .action-card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--dark);
        }

        .action-card p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Footer */
        .dashboard-footer {
            text-align: center;
            padding: 20px;
            color: var(--gray);
            font-size: 0.9rem;
            border-top: 1px solid var(--border);
            margin-top: 20px;
        }

        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary);
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .top-nav {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .nav-right {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 768px) {
            .dashboard-stats {
                grid-template-columns: 1fr;
            }

            .charts-section {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 15px;
            }

            .nav-left {
                display: flex;
                justify-content: center;
                gap: 15px;
            }
        }

        /* Chart Placeholders */
        .chart-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--gray);
        }

        .chart-placeholder i {
            font-size: 4rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Notification Badge */
        .notification-badge {
            background-color: var(--danger);
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            /* position: absolute; */
            top: -5px;
            right: -5px;
        }

        /* Overlay for mobile menu */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }
    </style>
    <style>
        .custom-btn {
            padding: 14px 24px;
            background-color: #2a9d8f;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .custom-btn:hover {
            background-color: #238276;
        }

        .delete-btn2 {
            padding: 14px 24px;
            background-color: #e63946;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .me-2 {
            margin-left: 8px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-chart-line"></i> HIKAYAT</h2>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('payment-terminal') }}"
                class="menu-item {{ request()->routeIs('payment-terminal') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i>
                <span>Payment Tracker</span>
            </a>

            <a href="{{ route('purchase-terminal') }}"
                class="menu-item {{ request()->routeIs('purchase-terminal') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Purchase Management</span>
            </a>

            <div class="menu-divider"></div>

            <a href="#" class="menu-item">
                <i class="fas fa-chart-bar"></i>
                <span>Analytics</span>
            </a>

            <a href="#" class="menu-item">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Reports</span>
                <span class="notification-badge">3</span>
            </a>

            <a href="#" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Clients</span>
            </a>

            <div class="menu-divider"></div>

            <a href="#" class="menu-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>

            <a href="#" class="menu-item">
                <i class="fas fa-question-circle"></i>
                <span>Help & Support</span>
            </a>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navigation -->
        <div class="top-nav">
            <div class="nav-left">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h1><i class="fas fa-tachometer-alt"></i> @yield('title')</h1>
            </div>

            <div class="nav-right">
                <div class="date-display">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="currentDate">Loading...</span>
                </div>

                <div class="user-profile">
                    <div class="user-avatar">
                        <span>{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    </div>
                    <div class="user-name">{{ Auth::user()->name }}</div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Content Area -->
        @yield('content')

        <!-- Footer -->
        <div class="dashboard-footer">
            <p>Hikayat Perfumes © {{ date('Y') }} | All data is securely stored and managed</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('script')
    <script>
        @if (Session::has('success'))
            Swal.fire({
                title: '{{ __('Success!') }}',
                text: "{{ __(Session::get('success')) }}",
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if (Session::has('message'))
            Swal.fire({
                title: '{{ __('Info!') }}',
                text: "{{ __(Session::get('message')) }}",
                icon: 'info',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if (Session::has('error'))
            Swal.fire({
                title: '{{ __('Error!') }}',
                text: "{{ __(Session::get('error')) }}",
                icon: 'error',
                timer: 2000,
                showConfirmButton: false
            });
        @endif
        $(document).on('click', '.delete_confirmation', function(event) {
            event.preventDefault();

            let form = $(this).closest('form');

            Swal.fire({
                title: "{{ __('Are you sure?') }}",
                text: "{{ __('You would not be able to revert this!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ __('Yes, delete it!') }}",
                cancelButtonText: "{{ __('Cancel') }}",
                reverseButtons: true,
                customClass: {
                    confirmButton: 'delete-btn2 me-2',
                    cancelButton: 'custom-btn'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "{{ __('Your data is safe!') }}",
                        icon: 'info',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });
    </script>

    <script>
        // DOM Elements
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const menuToggle = document.getElementById('menuToggle');
        const mainContent = document.getElementById('mainContent');
        const currentDateElement = document.getElementById('currentDate');

        // Get current date and format it
        function updateCurrentDate() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            currentDateElement.textContent = now.toLocaleDateString('en-PK', options);
        }

        // Toggle sidebar for mobile
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        menuToggle.addEventListener('click', toggleSidebar);
        // 👉 CALL THE FUNCTION AFTER PAGE LOAD
        document.addEventListener('DOMContentLoaded', updateCurrentDate);
    </script>

</body>

</html>
