<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayThru - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-left">
            <div class="logo-box">₱</div>
            <span class="brand-name">Pay Thru</span>
        </div>
        <div class="nav-links">
            <a href="dashboard.html" class="active">Dashboard</a>
            <a href="#">Transactions</a>
            <a href="#">Settings</a>
        </div>
        <div class="nav-right">
            <a href="{{ url('/') }}" class="logout">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
        <span>Logout</span>
            </a>
        </div>
    </nav>

    <main class="container">
        <header class="welcome-section">
            <h1>Welcome back, Gab!</h1>
            <p>Here's what's happening with your account today.</p>
        </header>

        <section class="top-row">
            <div class="balance-card">
                <p>Total Balance</p>
                <div class="amount">₱53,638.50</div>
            </div>

            <div class="action-card side-card">
                <div class="icon-box blue-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 7l10 10M17 7v10H7"/></svg>
                </div>
                <h3>Add Money</h3>
                <p>Deposit To Your Wallet</p>
            </div>
        </section>

        <section class="action-grid">
            <div class="action-card">
                <div class="icon-box blue-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                </div>
                <h3>Send Payment</h3>
                <p>Send Money To Anyone Instantly</p>
            </div>

            <div class="action-card">
                <div class="icon-box green-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                </div>
                <h3>Request Payment</h3>
                <p>Send Money From Contacts</p>
            </div>

            <div class="action-card">
                <div class="icon-box purple-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <h3>Pay Bill</h3>
                <p>Manage And Pay Your Bills</p>
            </div>
        </section>
    </main>

</body>
</html>