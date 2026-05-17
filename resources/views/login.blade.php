<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayThru Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}?v={{ time() }}">
    <style>
        /* Ensures layout alignment without the remember checkbox row */
        .options-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .brand-panel {
            background-image: url("{{ asset('images/fc3edde6-a75c-415c-95ac-0f2eb9fc0140.jpg') }}");
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>

<div class="split-container">
    <div class="brand-panel">
        <div class="brand-typography" style="display: none;">
            <span class="brand-peso">₱</span>ay<span class="brand-bold">Thru</span>
        </div>
    </div>

    <div class="form-panel">
        <div class="card">
            <div class="logo">₱</div>
            <h1>PayThru</h1>
            <p class="subtitle">Login to your account</p>

            @if(session('success'))
                <div style="color: #2ecc71; background: #eafaf1; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; text-align: center; border: 1px solid #d1fae5;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="color: #e74c3c; background: #fdf2f2; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; text-align: center; border: 1px solid #fee2e2;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ url('/login-user') }}" method="POST">
                @csrf 

                <div class="input-wrapper">
                    <label>Email Address</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </span>
                        <input type="email" name="email" required placeholder="Enter your email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="input-wrapper">
                    <label>MPIN</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </span>
                        <input type="password" id="mpin" name="mpin" maxlength="6" required placeholder="Enter your MPIN">
                        <span class="toggle" onclick="toggleMPIN()" style="cursor:pointer; color: #0047FF; font-weight:600; font-size: 13px; margin-left: 10px; user-select: none;">Show</span>
                    </div>
                </div>

                <div class="options-row">
                    <a href="{{ url('/forgot-password') }}" class="forgot" style="color: #0047FF; text-decoration: none; font-size: 14px; font-weight: 500;">Forget Password?</a>
                </div>

                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="signup-text">
                <p>Don't have an account? <a href="{{ url('/register') }}">Sign up</a></p>
            </div>
        </div>

        <footer>
            Secure payment processing with bank-level encryption
        </footer>
    </div>
</div>

<script>
    document.getElementById("mpin").addEventListener("input", function() {
        this.value = this.value.replace(/\D/g, '');
    });

    function toggleMPIN() {
        const mpin = document.getElementById("mpin");
        const btn = document.querySelector(".toggle");
        if (mpin.type === "password") {
            mpin.type = "text";
            btn.textContent = "Hide";
        } else {
            mpin.type = "password";
            btn.textContent = "Show";
        }
    }
</script>
</body>
</html>