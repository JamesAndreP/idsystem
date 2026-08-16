<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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
            max-width: 450px;
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

        .logo {
            height: 90px;
            width: 90px;
            object-fit: contain;
            margin-bottom: 10px;
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
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .btn-primary {
            background: #4f46e5;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
        }

        .btn-primary:hover {
            background: #4338ca;
        }
    </style>
</head>
<body>

@if(session('status'))
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; width: 100%; max-width: 600px;">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
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
            <img src="{{ asset('images/stec-logo.png') }}" class="logo" alt="Logo">
            <h3>RMDSF-STEC ID System</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('login.attempt') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" value="1">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn btn-primary">
                    Log In
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
