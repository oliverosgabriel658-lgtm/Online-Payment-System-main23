<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Bills - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/paybill.css') }}">
</head>
<body>

    <nav class="top-nav-bar">
        <a href="{{ url('/dashboard') }}" class="back-link">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back To Dashboard
        </a>
    </nav>

    <div class="page-wrapper">
        <header class="page-header">
            <div class="header-title-row">
                <div class="logo-box">₱</div>
                <div>
                    <h1>PayBills</h1>
                    <p>Pay your utility bills and other services instantly</p>
                </div>
            </div>
        </header>

        <div class="search-container">
            <div class="search-wrapper">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" placeholder="Search for a biller..." class="search-input">
            </div>
        </div>

        <div class="biller-grid">
            <div class="biller-card" id="electricityCard" style="cursor: pointer;">
                <div class="biller-icon yellow">⚡</div>
                <h3>Electricity</h3>
                <p>Pay now !</p>
            </div>

            <div class="biller-card" id="waterCard" style="cursor: pointer;">
                <div class="biller-icon blue">💧</div>
                <h3>Water</h3>
                <p>Pay now !</p>
            </div>

            <div class="biller-card" id="internetCard" style="cursor: pointer;">
                <div class="biller-icon red">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 21 17 13 7 13 7 21"></polyline><path d="M2 12h20"></path></svg>
                </div>
                <h3>Internet</h3>
                <p>Pay now !</p>
            </div>

            <div class="biller-card" id="mobileCard" style="cursor: pointer;">
                <div class="biller-icon dark">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="17 11 12 6 7 11"></polyline><polyline points="17 18 12 13 7 18"></polyline></svg>
                </div>
                <h3>Mobile</h3>
                <p>Pay now !</p>
            </div>

            <div class="biller-card" id="cableCard" style="cursor: pointer;">
                <div class="biller-icon">📺</div>
                <h3>Cable</h3>
                <p>Pay now !</p>
            </div>

            <div class="biller-card" id="insuranceCard" style="cursor: pointer;">
                <div class="biller-icon">🛡️</div>
                <h3>Insurance</h3>
                <p>Pay now !</p>
            </div>

            <div class="biller-card" id="rentCard" style="cursor: pointer;">
                <div class="biller-icon">🏠</div>
                <h3>Rent</h3>
                <p>Pay now !</p>
            </div>
        </div>
    </div>

    <script>
        // Click event para sa Electricity lang muna
        document.getElementById('electricityCard').addEventListener('click', function() {
            window.location.href = "{{ url('/pay-bill/electricity') }}";
        });

        document.getElementById('waterCard').addEventListener('click', function() {
        window.location.href = "{{ url('/pay-bill/water') }}";
        });

        document.getElementById('internetCard').addEventListener('click', function() {
        window.location.href = "{{ url('/pay-bill/internet') }}";
        });

        document.getElementById('mobileCard').addEventListener('click', function() {
        window.location.href = "{{ url('/pay-bill/mobile') }}";
        });

        document.getElementById('cableCard').addEventListener('click', function() {
        window.location.href = "{{ url('/pay-bill/cable') }}";
        });

        document.getElementById('insuranceCard').addEventListener('click', function() {
        window.location.href = "{{ url('/pay-bill/insurance') }}";
        });

        document.getElementById('rentCard').addEventListener('click', function() {
        window.location.href = "{{ url('/pay-bill/rent') }}";
        });

    </script>

</body>
</html>