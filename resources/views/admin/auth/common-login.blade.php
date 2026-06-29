<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VESPR Admin - Log In</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            background-color: #f6f6f7; 
            color: #202223;
            -webkit-font-smoothing: antialiased;
        }
        
        .login-card {
            border: 1px solid #e1e3e5 !important;
            border-radius: 8px !important;
            box-shadow: none !important;
            background-color: #ffffff;
        }

        .btn-shopify-dark {
            background-color: #1a1a1a;
            border-color: #1a1a1a;
            color: #ffffff;
            font-weight: 550;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .btn-shopify-dark:hover {
            background-color: #000000;
            border-color: #000000;
            color: #ffffff;
        }

        .form-control {
            border-color: #d2d5d8;
            font-size: 14px;
            padding: 10px 14px;
            border-radius: 6px;
        }

        .form-control:focus {
            border-color: #1a1a1a;
            box-shadow: 0 0 0 1px #1a1a1a;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: #202223;
            margin-bottom: 6px;
        }
        :root {
            --black: #0A0A0A;
            --white: #FFFFFF;
            --cream: #FAF8F4;
            --gold: #C9A84C;
            --gold-light: #F0E4C2;
            --gold-dark: #8B6914;
            --gray-100: #F5F4F0;
            --gray-200: #E8E6E0;
            --gray-400: #9E9C96;
            --gray-600: #5C5A54;
            --gray-800: #2A2924;
            --text: #0A0A0A;
            --text-muted: #5C5A54;
            --border: #E0DDD6;
        }

        /* NAV */
        nav {
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            padding: 0 40px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .nav-logo {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--black);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-logo span {
            color: var(--gold);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
            margin-bottom: 0;
            padding-left: 0;
        }

        .nav-links a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .nav-links a:hover { color: var(--black); }

        .btn-primary-header {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--black);
            color: var(--white);
            font-size: 14px;
            font-weight: 500;
            padding: 10px 22px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-primary-header:hover { background: var(--gray-800); color: var(--white); }

        /* FOOTER styling */
        .footer-landing {
            background: var(--black);
            border-top: 1px solid rgba(255,255,255,0.08);
            padding: 48px 40px 32px;
            width: 100%;
            text-align: left;
        }

        .footer-landing .footer-inner {
            max-width: 1080px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 48px;
        }

        .footer-landing .footer-brand {
            font-size: 20px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 12px;
        }

        .footer-landing .footer-brand span { color: var(--gold); }

        .footer-landing .footer-tagline {
            font-size: 14px;
            color: rgba(255,255,255,0.4);
            max-width: 280px;
            line-height: 1.6;
        }

        .footer-landing .footer-col h4 {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            margin-bottom: 16px;
        }

        .footer-landing .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-left: 0;
            margin-bottom: 0;
        }

        .footer-landing .footer-col a {
            font-size: 14px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-landing .footer-col a:hover { color: var(--white); }

        .footer-landing .footer-bottom {
            max-width: 1080px;
            margin: 0 auto;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .footer-landing .footer-bottom p {
            font-size: 13px;
            color: rgba(255,255,255,0.3);
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .footer-landing .footer-inner {
                grid-template-columns: 1fr;
                gap: 32px;
            }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 justify-content-between">
    
    <!-- Header -->
    <nav>
      <a href="{{ route('landing') }}" class="nav-logo">vespr<span>.</span></a>
      <ul class="nav-links d-none d-md-flex">
        <li><a href="{{ route('landing') }}#how-it-works">How it works</a></li>
        <li><a href="{{ route('landing') }}#features">Features</a></li>
        <li><a href="{{ route('landing') }}#templates">Templates</a></li>
        <li><a href="{{ route('landing') }}#pricing">Pricing</a></li>
      </ul>
      <div class="d-flex align-items-center" style="gap: 24px;">
        <a href="{{ route('admin.common.login') }}" style="font-size: 14px; font-weight: 500; color: var(--text-muted); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--black)'" onmouseout="this.style.color='var(--text-muted)'">Log in</a>
        <a href="{{ route('landing') }}?get_started=1" class="btn-primary-header">Get started</a>
      </div>
    </nav>

    <!-- Main Container -->
    <div class="container d-flex align-items-center justify-content-center flex-grow-1 py-5">
        <div class="w-100" style="max-width: 420px;">
            <div class="card login-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <h1 class="h4 fw-bold text-dark mb-2">Log in to Vespr Admin</h1>
                    <p class="text-muted small">Enter your email and password to access your store's dashboard.</p>
                </div>
                
                <form method="POST" action="{{ route('admin.common.login.submit') }}">
                    @csrf
                    
                    @if ($errors->any())
                        <div class="alert alert-danger px-3 py-2 text-danger small mb-4 border-0 rounded-2" style="background-color: #fff1f0; border-left: 3px solid #ff4d4f !important;">
                            <ul class="list-unstyled mb-0 list-disc ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="form-control" placeholder="admin@example.com">
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label mb-0">Password</label>
                            <a href="{{ route('password.request') }}" class="small text-decoration-none text-muted" style="font-size: 12px;">Forgot password?</a>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="form-control" placeholder="••••••••">
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input id="remember_me" type="checkbox" name="remember" class="form-check-input" style="cursor: pointer;">
                            <label for="remember_me" class="form-check-label small text-secondary" style="cursor: pointer; user-select: none;">Keep me logged in</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-shopify-dark w-100 py-2.5 mb-3">
                        Log in
                    </button>

                    <div class="d-flex align-items-center my-3 text-muted">
                        <hr class="flex-grow-1 my-0">
                        <span class="px-3 small">or</span>
                        <hr class="flex-grow-1 my-0">
                    </div>

                    <a href="{{ route('google.login') }}" class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="font-size: 14px; border-radius: 6px; border-color: #d2d5d8;">
                        <svg width="18" height="18" viewBox="0 0 18 18">
                            <path fill="#4285F4" d="M17.64 9.2c0-.63-.06-1.25-.16-1.84H9v3.47h4.84a4.14 4.14 0 0 1-1.8 2.71v2.26h2.9c1.7-1.57 2.7-3.88 2.7-6.6z"/>
                            <path fill="#34A853" d="M9 18c2.43 0 4.47-.8 5.96-2.2l-2.9-2.26c-.8.54-1.85.87-3.06.87-2.35 0-4.33-1.58-5.04-3.71H.94v2.33A9 9 0 0 0 9 18z"/>
                            <path fill="#FBBC05" d="M3.96 10.7a5.4 5.4 0 0 1 0-3.4V4.97H.94a9 9 0 0 0 0 8.06l3.02-2.33z"/>
                            <path fill="#EA4335" d="M9 3.58c1.32 0 2.5.45 3.44 1.35L15 2.1A9 9 0 0 0 .94 4.97l3.02 2.33C4.67 5.16 6.65 3.58 9 3.58z"/>
                        </svg>
                        Continue with Google
                    </a>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-landing">
      <div class="footer-inner">
        <div>
          <div class="footer-brand">vespr<span>.</span></div>
          <p class="footer-tagline">The e-commerce platform built for grocers and supermarkets. From local shops to global chains.</p>
          <p style="font-size:13px;color:rgba(255,255,255,0.35);margin-top:16px;">support@vespr.com</p>
        </div>
        <div class="footer-col">
          <h4>Platform</h4>
          <ul>
            <li><a href="{{ route('landing') }}#how-it-works">How it works</a></li>
            <li><a href="{{ route('landing') }}#features">Features</a></li>
            <li><a href="{{ route('landing') }}#templates">Templates</a></li>
            <li><a href="{{ route('landing') }}#pricing">Pricing</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Company</h4>
          <ul>
            <li><a href="{{ route('landing') }}#contact">Contact</a></li>
            <li><a href="#">Privacy policy</a></li>
            <li><a href="#">Terms of service</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2026 Vespr. All rights reserved.</p>
        <p>Built for grocery brands worldwide.</p>
      </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
