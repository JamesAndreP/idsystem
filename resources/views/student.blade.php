<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            min-height: 100vh;
            padding: 40px 20px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            max-width: 1100px;
        }

        .card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: #4f46e5;
            color: #fff;
            padding: 20px 25px;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: #f8f9fa;
        }

        .table thead th {
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #e9ecef;
        }

        .table tbody tr:hover {
            background: #f5f3ff;
        }

        .btn-primary {
            background: #4f46e5;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
        }

        .btn-primary:hover {
            background: #4338ca;
        }

        .btn-warning,
        .btn-danger {
            border-radius: 8px;
        }

        .badge {
            font-size: 0.85rem;
            padding: 6px 10px;
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 14px;
            }

            .card-header {
                text-align: center;
            }

            .card-header .d-flex {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

@if(session('success'))
<div class="container mb-3">
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<div class="container">
    <div class="card">

        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Students List</h3>

                <div class="d-flex gap-2">
                    <a href="{{ route('students.create') }}" class="btn btn-light">
                        + Add Student
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Section</th>
                        <th>LRN</th>
                        <th width="170">Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $student->first_name }}</td>

                            <td>
                                {{ $student->middle_name ?: '-' }}
                            </td>

                            <td>{{ $student->last_name }}</td>

                            <td>
                                <span class="badge bg-primary">
                                    {{ $student->section }}
                                </span>
                            </td>

                            <td>{{ $student->lrn }}</td>

                            <td>
                                <a href="{{ route('students.generateQr', $student->id) }}"
                                   class="btn btn-warning btn-sm">
                                    View / Print QR
                                </a>
                            </td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                No students found.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>
                </table>
            </div>

        </div>

        @if(method_exists($students, 'links'))
            <div class="card-footer bg-white">
                {{ $students->links() }}
            </div>
        @endif

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
