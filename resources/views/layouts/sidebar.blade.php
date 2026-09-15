<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #111827;
            color: white;
            min-height: 100vh;
            font-family: Arial;
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #0f172a;
            padding: 20px;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #374151;
            transition: width 0.3s ease;
            position: relative;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed .sidebar-menu a span,
        .sidebar.collapsed .sidebar-footer .btn-danger {
            display: none;
        }

        .sidebar.collapsed .sidebar-menu a {
            justify-content: center;
            padding: 12px;
        }

        .sidebar.collapsed .sidebar-footer form {
            display: flex;
            justify-content: center;
        }

        .sidebar-toggle {
            position: absolute;
            top: 10px;
            right: -15px;
            width: 30px;
            height: 30px;
            background: #4f46e5;
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: all 0.2s ease;
            padding: 0;
        }

        .sidebar-toggle:hover {
            background: #4338ca;
            transform: scale(1.1);
        }

        .sidebar-toggle svg {
            width: 16px;
            height: 16px;
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed .sidebar-toggle svg {
            transform: rotate(180deg);
        }

        .sidebar-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #374151;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #4f46e5;
        }

        .sidebar-menu {
            flex: 1;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #e5e7eb;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.2s ease;
        }

        .sidebar-menu a:hover {
            background: #1f2937;
            color: white;
        }

        .sidebar-menu a.active {
            background: #4f46e5;
            color: white;
        }

        .sidebar-footer {
            padding-top: 20px;
            border-top: 1px solid #374151;
        }

        .sidebar-footer form {
            display: inline;
        }

        .btn-danger {
            background: #ef4444;
            border: none;
            border-radius: 8px;
            padding: 10px;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #374151;
            }

            .main-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar" id="sidebar">
        <button class="sidebar-toggle" id="sidebarToggle">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                📊 <span>Dashboard</span>
            </a>
            <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.index') ? 'active' : '' }}">
                👥 <span>Student List</span>
            </a>
            <a href="{{ route('grade-sections.index') }}" class="{{ request()->routeIs('grade-sections.index') || request()->routeIs('grade-sections.create') ? 'active' : '' }}">
                🎓 <span>Grade Levels</span>
            </a>
            <a href="{{ route('students.scanner') }}" class="{{ request()->routeIs('students.scanner') ? 'active' : '' }}">
                📱 <span>Portal</span>
            </a>
            <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.index') ? 'active' : '' }}">
                ⚙️ <span>Settings</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    </script>

</body>
</html>
