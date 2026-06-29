<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xxxx Admin - Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f2f3; }
        .bg-gray-900 { background-color: #111827; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="w-100 p-4" style="max-width: 448px;">
        <div class="card border shadow-sm p-4 p-md-5">
            <div class="d-flex justify-content-center mb-4">
                <div class="bg-dark text-white d-flex align-items-center justify-content-center rounded fw-bold fs-4" style="width: 48px; height: 48px;">N</div>
            </div>
            <h2 class="h4 fw-bold text-center text-dark mb-4">Log in to {{ $currentTenant->name ?? 'xxxx' }} Admin</h2>
            
            <form method="POST" action="{{ route('admin.login.submit', ['tenant' => $currentTenant->id ?? 1]) }}">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger px-3 py-2 text-danger small mb-4">
                        <ul class="list-unstyled mb-0 list-disc ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label fw-medium small text-secondary mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="form-control shadow-sm">
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-medium small text-secondary mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="form-control shadow-sm">
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                        <label for="remember_me" class="form-check-label small text-secondary">Remember me</label>
                    </div>
                    <div>
                        <a href="{{ route('password.request') }}" class="small text-decoration-none text-success fw-medium">Forgot password?</a>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 shadow-sm fw-medium py-2">
                    Log in
                </button>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
