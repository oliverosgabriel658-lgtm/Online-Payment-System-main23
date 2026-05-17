<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayThru - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --bg-light: #f8f9fa;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            margin: 0;
            color: #1e293b;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Top Navigation */
        .navbar {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 15px 40px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .logo-box {
            background: var(--primary-blue);
            color: white;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            justify-content: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #64748b;
            margin: 0 15px;
            font-weight: 500;
        }

        .nav-links a.active { color: var(--primary-blue); }

        /* Welcome Section */
        .welcome-section {
            text-align: center;
            margin: 30px 0;
        }

        .welcome-section h1 { font-size: 1.5rem; margin-bottom: 5px; }

        /* Success Alert */
        .alert-success {
            background: #ecfdf5;
            color: #10b981;
            padding: 16px;
            border-radius: 16px;
            margin-bottom: 25px;
            border: 1px solid #d1fae5;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.05);
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Central Balance Module */
        .balance-hero {
            background: var(--primary-blue);
            color: white;
            border-radius: 24px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(26, 115, 232, 0.2);
            margin-bottom: 25px;
            position: relative;
        }

        .balance-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .balance-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .balance-amount {
            font-size: 3.5rem;
            font-weight: 700;
            margin: 0;
        }

        .toggle-balance-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .toggle-balance-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Action Grid */
        .action-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .action-item {
            background: white;
            border-radius: 20px;
            padding: 20px 10px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid #f1f5f9;
        }

        .action-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
        }

        .action-item h3 {
            font-size: 0.9rem;
            margin: 0;
            color: #475569;
            font-weight: 600;
        }

        .blue-bg { background: #eff6ff; color: #2563eb; }
        .green-bg { background: #f0fdf4; color: #16a34a; }
        .purple-bg { background: #faf5ff; color: #9333ea; }
        .orange-bg { background: #fff7ed; color: #ea580c; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-left" style="display: flex; align-items: center; gap: 10px;">
            <div class="logo-box">₱</div>
            <span class="brand-name" style="font-weight: 700; font-size: 1.2rem;">Pay Thru</span>
        </div>
        <div class="nav-links">
            <a href="{{ url('/dashboard') }}" class="active">Dashboard</a>
            <a href="{{ url('/transactions') }}">Transaction</a>
            <a href="{{ url('/settings') }}">Settings</a>
        </div>
        <div class="nav-right"></div>
    </nav>

    <main class="container">
        <header class="welcome-section">
            <h1>Hi, {{ Auth::user()->full_name }}!</h1>
            <p style="color: #64748b; font-size: 0.9rem;">Acc No: {{ Auth::user()->account_number }}</p>
        </header>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <section class="balance-hero">
            <div class="balance-label">Available Balance</div>
            <div class="balance-container">
                <h2 class="balance-amount" id="balanceText" data-amount="₱{{ number_format(Auth::user()->balance ?? 0, 2) }}">₱{{ number_format(Auth::user()->balance ?? 0, 2) }}</h2>
                <button class="toggle-balance-btn" onclick="toggleBalance()" title="Show/Hide Balance">
                    <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>
        </section>

        <section class="action-row">
            <div class="action-item" onclick="window.location.href='{{ url('/add-money') }}'">
                <div class="action-icon blue-bg">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                </div>
                <h3>Cash In</h3>
            </div>

            <div class="action-item" onclick="window.location.href='{{ url('/send-payment') }}'">
                <div class="action-icon green-bg">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                </div>
                <h3>Send</h3>
            </div>

            <div class="action-item" onclick="window.location.href='{{ route('request.payment') }}'">
                <div class="action-icon orange-bg">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                </div>
                <h3>Request</h3>
            </div>

            <div class="action-item" onclick="window.location.href='{{ url('/pay-bill') }}'">
                <div class="action-icon purple-bg">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                </div>
                <h3>Bills</h3>
            </div>
        </section>
    </main>

    <script>
        let isHidden = false;
        const balanceText = document.getElementById('balanceText');
        const eyeIcon = document.getElementById('eyeIcon');
        const originalAmount = balanceText.getAttribute('data-amount');

        function toggleBalance() {
            isHidden = !isHidden;
            if (isHidden) {
                balanceText.innerText = "₱ ••••••";
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                balanceText.innerText = originalAmount;
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }
    </script>
</body>
</html>