<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0047FF;
            --bg-light: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --error-red: #ef4444;
            --success-green: #10b981;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            margin: 0;
            color: var(--text-main);
        }

        /* NAVBAR */
        .navbar {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 15px 40px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .nav-left { display: flex; align-items: center; gap: 10px; }
        .logo-box {
            background: var(--primary-blue);
            color: white;
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px; font-weight: bold;
            font-size: 18px;
        }

        .nav-links { display: flex; gap: 30px; }
        .nav-links a { text-decoration: none; color: var(--text-muted); font-weight: 500; transition: color 0.2s; }
        .nav-links a:hover { color: var(--primary-blue); }
        .nav-links a.active { color: var(--primary-blue); font-weight: 600; }

        .page-container { max-width: 600px; margin: 0 auto; padding: 40px 20px; }
        h1 { font-size: 28px; font-weight: 600; margin-bottom: 24px; }

        /* CARDS */
        .settings-card { background: white; border-radius: 20px; padding: 28px; margin-bottom: 24px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01); }
        .settings-card h3 { margin: 0 0 20px; font-size: 1.15rem; font-weight: 600; color: #0f172a; }

        /* FORM ELEMENTS */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 0.82rem; letter-spacing: 0.05em; text-transform: uppercase; }
        
        .input-group {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .input-group input { 
            width: 100%; padding: 14px 16px; border: 1px solid #cbd5e1; border-radius: 12px; 
            font-family: inherit; box-sizing: border-box; font-size: 0.95rem; color: #334155;
            transition: all 0.2s;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 71, 255, 0.1);
        }

        .toggle-btn {
            position: absolute;
            right: 16px;
            cursor: pointer;
            font-size: 13px;
            color: var(--primary-blue);
            font-weight: 600;
            user-select: none;
        }

        /* ALERTS */
        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; font-size: 0.92rem; font-weight: 500; display: flex; align-items: center; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fee2e2; }

        .save-btn {
            width: 100%; padding: 16px; background: var(--primary-blue); color: white;
            border: none; border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 1rem;
            transition: background-color 0.2s, transform 0.1s;
        }
        .save-btn:hover { background: #0036d6; }
        .save-btn:active { transform: scale(0.99); }

        /* LOGOUT SECTION */
        .logout-container { margin-top: 32px; text-align: center; }
        .logout-footer-btn {
            display: inline-block; padding: 12px 28px; color: var(--error-red);
            text-decoration: none; font-weight: 600; font-size: 0.9rem;
            border: 1px solid #fee2e2; border-radius: 12px; background: white;
            transition: all 0.2s;
        }
        .logout-footer-btn:hover { background: #fef2f2; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-left">
            <div class="logo-box">₱</div>
            <span style="font-weight: 700; font-size: 18px; color: #0f172a;">PayThru</span>
        </div>
        
        <div class="nav-links">
            <a href="{{ url('/dashboard') }}">Dashboard</a>
            <a href="{{ url('/transactions') }}">Transaction</a>
            <a href="{{ url('/settings') }}" class="active">Settings</a>
        </div>

        <div class="nav-right"></div>
    </nav>

    <main class="page-container">
        <h1>Account Settings</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ url('/update-settings') }}" method="POST">
            @csrf
            
            <div class="settings-card">
                <h3>Profile Details</h3>
                <div class="form-group">
                    <label>Full Name</label>
                    <div class="input-group">
                        <input type="text" name="full_name" value="{{ Auth::user()->full_name }}" required placeholder="Enter your name">
                    </div>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-group">
                        <input type="email" name="email" value="{{ Auth::user()->email }}" required placeholder="Enter email address">
                    </div>
                </div>
            </div>

            <div class="settings-card">
                <h3>Security Verification</h3>
                <div class="form-group">
                    <label>Current MPIN <span style="color: var(--error-red)">*</span></label>
                    <div class="input-group">
                        <input type="password" class="numeric-pin" id="current_mpin" name="current_mpin" maxlength="6" required placeholder="Enter your 6-digit MPIN to save changes">
                        <span class="toggle-btn" onclick="toggleField('current_mpin', this)">Show</span>
                    </div>
                </div>
                <hr style="border:0; border-top:1px solid #f1f5f9; margin: 24px 0;">
                <div class="form-group">
                    <label>New MPIN (Optional)</label>
                    <div class="input-group">
                        <input type="password" class="numeric-pin" id="new_mpin" name="new_mpin" maxlength="6" placeholder="Enter new 6-digit MPIN">
                        <span class="toggle-btn" onclick="toggleField('new_mpin', this)">Show</span>
                    </div>
                </div>
                <div class="form-group">
                    <label>Confirm New MPIN</label>
                    <div class="input-group">
                        <input type="password" class="numeric-pin" id="new_mpin_confirmation" name="new_mpin_confirmation" maxlength="6" placeholder="Confirm your new 6-digit MPIN">
                        <span class="toggle-btn" onclick="toggleField('new_mpin_confirmation', this)">Show</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="save-btn">Save Changes</button>
        </form>

        <div class="logout-container">
            <a href="{{ url('/logout') }}" class="logout-footer-btn">Sign Out</a>
        </div>
    </main>

    <script>
        // Enforce digits only rules across structural security fields
        document.querySelectorAll('.numeric-pin').forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });
        });

        // Toggle field type between plain text and hidden asterisks
        function toggleField(fieldId, element) {
            const field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
                element.textContent = "Hide";
            } else {
                field.type = "password";
                element.textContent = "Show";
            }
        }
    </script>
</body>
</html>