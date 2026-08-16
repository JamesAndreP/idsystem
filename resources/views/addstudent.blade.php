<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            max-width: 600px;
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
            text-align: center;
            padding: 20px;
            border-bottom: none;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 30px;
            background: #fff;
        }

        .form-label {
            font-weight: 600;
            color: #444;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #d1d5db;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.2);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #4f46e5;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: #4338ca;
            transform: translateY(-1px);
        }

        .alert {
            max-width: 600px;
            margin: 0 auto 15px;
            border-radius: 10px;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 20px;
            }

            .card-header {
                padding: 15px;
            }

            .card-header h3 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>

@if(session()->has('success'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; width: 100%; max-width: 600px;">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; width: 100%; max-width: 600px;">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endforeach
    </div>
@endif

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Student Registration</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Middle Name</label>
                    <input type="text" class="form-control" name="middle_name" value="{{ old('middle_name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Section</label>
                    <input type="text" class="form-control" name="section" value="{{ old('section') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">LRN</label>
                    <input type="text" class="form-control" name="lrn" value="{{ old('lrn') }}" maxlength="12" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Student
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
