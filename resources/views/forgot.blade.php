<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot MPIN - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}?v={{ time() }}">
    <style>
        .brand-panel {
            background-image: url("{{ asset('images/fc3edde6-a75c-415c-95ac-0f2eb9fc0140.jpg') }}");
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>

<div class="split-container">
    <div class="brand-panel"></div>

    <div class="form-panel">
        <div class="card">
            <div class="logo">₱</div>
            <h1>Reset MPIN</h1>
            <p class="subtitle">Enter your details to register a new MPIN</p>

            @if($errors->any())
                <div style="color: #e74c3c; background: #fdf2f2; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; text-align: center; border: 1px solid #fee2e2;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('/forgot-password') }}" method="POST">
                @csrf 

                <div class="input-wrapper">
                    <label>Email Address</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </span>
                        <input type="email" name="email" required placeholder="Enter your registered email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="input-wrapper">
                    <label>Phone Number</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </span>
                        <input type="text" name="phone_number" required placeholder="Enter your registered phone number">
                    </div>
                </div>

                <div class="input-wrapper">
                    <label>New 6-Digit MPIN</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </span>
                        <input type="password" id="new_mpin" name="new_mpin" maxlength="6" required placeholder="Enter new MPIN">
                        <span class="toggle-pin" onclick="toggleField('new_mpin', this)" style="cursor:pointer; color: #0047FF; font-weight:600; font-size: 13px; margin-left: 10px; user-select:none;">Show</span>
                    </div>
                </div>

                <button type="submit" class="login-btn">Reset & Login</button>
            </form>

            <div class="signup-text">
                <p>Remembered your MPIN? <a href="{{ url('/') }}">Back to Login</a></p>
            </div>
        </div>

        <footer>
            Secure payment processing with bank-level encryption
        </footer>
    </div>
</div>

<script>
    document.getElementById("new_mpin").addEventListener("input", function() {
        this.value = this.value.replace(/\D/g, '');
    });

    function toggleField(id, btn) {
        const field = document.getElementById(id);
        if (field.type === "password") {
            field.type = "text";
            btn.textContent = "Hide";
        } else {
            field.type = "password";
            btn.textContent = "Show";
        }
    }
</script>
</body>
</html>