<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #111827;
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial;
            margin: 0;
        }

        .container {
            max-width: 500px;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            background: #0f172a;
            color: #fff;
            text-align: center;
            padding: 25px;
            border-bottom: none;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 600;
        }

        .card-body {
            padding: 35px;
            background: #1f2937;
        }

        .form-label {
            font-weight: 600;
            color: #e5e7eb;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #374151;
            background: #111827;
            color: white;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #4f46e5;
            background: #0f172a;
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.2);
            color: white;
        }

        .form-check-input {
            background-color: #111827;
            border-color: #374151;
        }

        .form-check-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .form-check-label {
            color: #e5e7eb;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #4f46e5;
            font-weight: 600;
            transition: 0.3s;
            color: white;
        }

        .btn-primary:hover {
            background: #4338ca;
            transform: translateY(-1px);
        }

        .alert {
            max-width: 500px;
            margin: 0 auto 15px;
            border-radius: 10px;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 25px;
            }

            .card-header {
                padding: 20px;
            }

            .card-header h3 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>

@if($errors->any())
    <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999; width: 100%; max-width: 500px;">
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
            <h3>Login</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('login.authenticate') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    Sign In
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
