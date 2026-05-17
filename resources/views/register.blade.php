<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayThru Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}?v={{ time() }}">
    <style>
        /* Fixes the brand panel logo image display issue */
        .brand-panel {
            background-image: url("{{ asset('images/fc3edde6-a75c-415c-95ac-0f2eb9fc0140.jpg') }}");
            background-size: cover;
            background-position: center;
        }

        /* Clean formatting styles for your custom real-time JS messages */
        .strength {
            font-size: 12px;
            margin-top: 4px;
            font-weight: 500;
        }
        .strength.success {
            color: #2ecc71;
        }
        .strength.error {
            color: #e74c3c;
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
            <h1>Create Account</h1>
            <p class="subtitle">Register your PayThru wallet</p>

            <form action="{{ url('/register-user') }}" method="POST">
                @csrf 

                <div class="input-wrapper">
                    <label>Full Name</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </span>
                        <input type="text" name="full_name" required placeholder="Enter your full name" value="{{ old('full_name') }}">
                    </div>
                </div>

                <div class="input-wrapper">
                    <label>Email Address</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </span>
                        <input type="email" id="email" name="email" required placeholder="Enter your email address" value="{{ old('email') }}">
                    </div>
                    <div id="emailMsg" class="strength"></div>
                </div>

                <div class="input-wrapper">
                    <label>Phone Number</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </span>
                        <input type="text" id="phone" name="phone_number" required maxlength="11" placeholder="09XXXXXXXXX" value="{{ old('phone_number') }}">
                    </div>
                    <div id="phoneMsg" class="strength"></div>
                </div>

                <div class="input-wrapper">
                    <label>MPIN</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </span>
                        <input type="password" id="mpin" name="mpin" maxlength="6" required placeholder="4-6 digit PIN">
                        <span class="toggle" onclick="toggleField('mpin')" style="cursor:pointer; color: #0046cd; font-weight: 600; font-size: 13px; margin-left: 10px; user-select: none;">Show</span>
                    </div>
                    <div id="mpinStrength" class="strength"></div>
                </div>

                <button type="submit" class="register-btn" style="margin-top: 15px;">Register</button>
            </form>

            <div class="login-link">
                <p>Already have an account? <a href="{{ url('/') }}">Login</a></p>
            </div>
        </div>

        <footer>
            Secure payment processing with bank-level encryption
        </footer>
    </div>
</div>

<script>
    function toggleField(id){
        let field = document.getElementById(id);
        let toggle = field.nextElementSibling;
        if(field.type === "password"){
            field.type = "text";
            toggle.textContent = "Hide";
        } else {
            field.type = "password";
            toggle.textContent = "Show";
        }
    }

    document.getElementById("email").addEventListener("input", function(){
        let email = this.value;
        let msg = document.getElementById("emailMsg");
        if(email.includes("@") && email.includes(".")){
            msg.textContent = "Valid email";
            msg.className = "strength success";
        } else {
            msg.textContent = "Invalid email format";
            msg.className = "strength error";
        }
    });

    document.getElementById("phone").addEventListener("input", function(){
        this.value = this.value.replace(/\D/g,'');
        let msg = document.getElementById("phoneMsg");
        if(this.value.length == 11){
            msg.textContent = "Valid phone number";
            msg.className = "strength success";
        } else {
            msg.textContent = "Phone must be 11 digits";
            msg.className = "strength error";
        }
    });

    document.getElementById("mpin").addEventListener("input", function(){
        this.value = this.value.replace(/\D/g,'');
        let strength = document.getElementById("mpinStrength");
        if(this.value.length < 4){
            strength.textContent = "MPIN too short";
            strength.className = "strength error";
        } else {
            strength.textContent = "Valid MPIN format";
            strength.className = "strength success";
        }
    });
</script>
</body>
</html>