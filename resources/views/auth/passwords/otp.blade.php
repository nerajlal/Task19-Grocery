<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VESPR - Verify OTP</title>
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

        .form-control-otp {
            width: 45px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            border: 1px solid #e0ddd6;
            border-radius: 6px;
            background-color: #faf9f6;
            transition: all 0.2s ease;
        }

        .form-control-otp:focus {
            border-color: #111111;
            box-shadow: 0 0 0 1px #111111;
            outline: none;
            background-color: #ffffff;
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
        <div class="w-100" style="max-width: 440px;">
            <div class="card login-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <h1 class="h4 fw-bold text-dark mb-2" style="font-family: Georgia, serif;">Verify Code</h1>
                    <p class="text-muted small">We sent a 6-digit verification code to <br><strong class="text-dark">{{ $email }}</strong></p>
                </div>
                
                <form id="otpForm" method="POST" action="{{ route('password.otp.verify') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" id="fullOtp" name="otp" value="">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger px-3 py-2 text-danger small mb-4 border-0 rounded-2" style="background-color: #fff1f0; border-left: 3px solid #ff4d4f !important;">
                            <ul class="list-unstyled mb-0 list-disc ps-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success px-3 py-2 text-success small mb-4 border-0 rounded-2" style="background-color: #eafdf5; border-left: 3px solid #008060 !important;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Beautiful OTP Box Grid -->
                    <div class="d-flex justify-content-between gap-2 mb-4">
                        <input type="text" class="form-control-otp otp-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required autofocus>
                        <input type="text" class="form-control-otp otp-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
                        <input type="text" class="form-control-otp otp-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
                        <input type="text" class="form-control-otp otp-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
                        <input type="text" class="form-control-otp otp-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
                        <input type="text" class="form-control-otp otp-input" maxlength="1" pattern="[0-9]*" inputmode="numeric" required>
                    </div>

                    <button type="submit" class="btn btn-shopify-dark w-100 py-2.5 mb-3">
                        Verify Code
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="small text-decoration-none text-muted">Resend code</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 border-top" style="background: #ffffff; font-size: 12px; color: #888888;">
        <p class="mb-0">© 2026 VESPR. All rights reserved.</p>
    </footer>

    <!-- OTP Input Handling Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input');
            const form = document.getElementById('otpForm');
            const fullOtpInput = document.getElementById('fullOtp');

            // Handle typing and auto-advancing
            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    if (input.value.length > 0 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    combineOtp();
                });

                // Handle backspace back-navigation
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                // Handle paste event
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').trim();
                    if (/^\d{6}$/.test(pastedData)) {
                        inputs.forEach((inp, idx) => {
                            inp.value = pastedData[idx];
                        });
                        combineOtp();
                        inputs[inputs.length - 1].focus();
                    }
                });
            });

            function combineOtp() {
                let otpString = '';
                inputs.forEach(input => {
                    otpString += input.value;
                });
                fullOtpInput.value = otpString;
            }

            form.addEventListener('submit', function(e) {
                combineOtp();
                if (fullOtpInput.value.length !== 6) {
                    e.preventDefault();
                    alert('Please enter all 6 digits of the verification code.');
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
