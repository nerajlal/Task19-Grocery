<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VESPR - Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            background-color: #FAF9F6; 
            color: #111111;
            -webkit-font-smoothing: antialiased;
        }
        
        .login-card {
            border: 1px solid #e0ddd6 !important;
            border-radius: 8px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02) !important;
            background-color: #ffffff;
        }

        .btn-shopify-dark {
            background-color: #111111;
            border-color: #111111;
            color: #FAF9F6;
            font-weight: 550;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 14px;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
        }

        .btn-shopify-dark:hover {
            background-color: #222222;
            border-color: #222222;
            color: #ffffff;
        }

        .form-control {
            border-color: #e0ddd6;
            font-size: 14px;
            padding: 10px 14px;
            border-radius: 6px;
        }

        .form-control:focus {
            border-color: #111111;
            box-shadow: 0 0 0 1px #111111;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: #111111;
            margin-bottom: 6px;
        }

        .logo-text {
            font-family: Georgia, serif;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #111111;
            text-decoration: none;
        }

        .logo-text span {
            color: #C5A880;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 justify-content-between">
    
    <!-- Header -->
    <nav class="d-flex align-items-center justify-content-center py-4 border-bottom" style="background: #ffffff; height: 64px;">
        <a href="/" class="logo-text">vespr<span>.</span></a>
    </nav>

    <!-- Main Container -->
    <div class="container d-flex align-items-center justify-content-center flex-grow-1 py-5">
        <div class="w-100" style="max-width: 420px;">
            <div class="card login-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <h1 class="h4 fw-bold text-dark mb-2" style="font-family: Georgia, serif;">Set New Password</h1>
                    <p class="text-muted small">Create a secure new password for your account linked to <br><strong class="text-dark">{{ $email }}</strong></p>
                </div>
                
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger px-3 py-2 text-danger small mb-4 border-0 rounded-2" style="background-color: #fff1f0; border-left: 3px solid #ff4d4f !important;">
                            <ul class="list-unstyled mb-0 list-disc ps-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" id="password" name="password" required autofocus
                            class="form-control" placeholder="Minimum 8 characters">
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="form-control" placeholder="Re-enter password">
                    </div>

                    <button type="submit" class="btn btn-shopify-dark w-100 py-2.5 mb-3">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 border-top" style="background: #ffffff; font-size: 12px; color: #888888;">
        <p class="mb-0">© 2026 VESPR. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
