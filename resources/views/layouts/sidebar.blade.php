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
            display: block;
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

    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                📊 Dashboard
            </a>
            <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.index') ? 'active' : '' }}">
                👥 Student List
            </a>
            <a href="{{ route('grade-sections.index') }}" class="{{ request()->routeIs('grade-sections.index') || request()->routeIs('grade-sections.create') ? 'active' : '' }}">
                🎓 Grade Levels
            </a>
            <a href="{{ route('students.scanner') }}" class="{{ request()->routeIs('students.scanner') ? 'active' : '' }}">
                📱 Portal
            </a>
            <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.index') ? 'active' : '' }}">
                ⚙️ Settings
            </a>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
