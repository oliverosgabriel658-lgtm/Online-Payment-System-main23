<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Bills - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --bg-light: #f8f9fa;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            margin: 0;
            color: var(--text-main);
        }

        .page-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Top Navigation */
        .top-nav-bar {
            padding: 20px 40px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .back-link {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color 0.2s;
        }

        .back-link:hover { color: var(--primary-blue); }

        /* Header Section */
        .page-header {
            margin: 40px 0;
            text-align: center;
        }

        .header-title-row {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .logo-box {
            background: var(--primary-blue);
            color: white;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            font-size: 1.8rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.2);
        }

        .header-title-row h1 { margin: 10px 0 5px; font-size: 2rem; font-weight: 700; }
        .header-title-row p { margin: 0; color: var(--text-muted); font-size: 1rem; }

        /* Perfect 6-Grid Layout (3x2) */
        .biller-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Exactly 3 columns */
            gap: 25px;
            margin-top: 20px;
        }

        .biller-card {
            background: white;
            border-radius: 24px;
            padding: 35px 20px;
            text-align: center;
            border: 1px solid #edf2f7;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .biller-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-blue);
        }

        /* Icon Styles */
        .biller-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            font-size: 2rem;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .biller-card:hover .biller-icon { transform: scale(1.1); }

        /* Specific Icon Backgrounds */
        .yellow { background: #fffbeb; color: #d97706; }
        .blue { background: #eff6ff; color: #2563eb; }
        .red { background: #fef2f2; color: #dc2626; }
        .dark { background: #f8fafc; color: #1e293b; }
        .purple { background: #faf5ff; color: #9333ea; }
        .orange { background: #fff7ed; color: #ea580c; }

        .biller-card h3 {
            margin: 0 0 8px;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .biller-card p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--primary-blue);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #eff6ff;
            padding: 4px 12px;
            border-radius: 20px;
        }

        /* Responsive Fix for smaller screens */
        @media (max-width: 768px) {
            .biller-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
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
                    <p>Select a service to settle your payments instantly</p>
                </div>
            </div>
        </header>

        <div class="biller-grid">
            <div class="biller-card" id="electricityCard" style="cursor: pointer;">
                <div class="biller-icon yellow">⚡</div>
                <h3>Electricity</h3>
                <p>Pay now</p>
            </div>

            <div class="biller-card" id="waterCard" style="cursor: pointer;">
                <div class="biller-icon blue">💧</div>
                <h3>Water</h3>
                <p>Pay now</p>
            </div>

            <div class="biller-card" id="internetCard" style="cursor: pointer;">
                <div class="biller-icon red">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 21 17 13 7 13 7 21"></polyline><path d="M2 12h20"></path></svg>
                </div>
                <h3>Internet</h3>
                <p>Pay now</p>
            </div>

            <div class="biller-card" id="mobileCard" style="cursor: pointer;">
                <div class="biller-icon dark">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="17 11 12 6 7 11"></polyline><polyline points="17 18 12 13 7 18"></polyline></svg>
                </div>
                <h3>Mobile</h3>
                <p>Pay now</p>
            </div>

            <div class="biller-card" id="cableCard" style="cursor: pointer;">
                <div class="biller-icon purple">📺</div>
                <h3>Cable</h3>
                <p>Pay now</p>
            </div>

            <div class="biller-card" id="insuranceCard" style="cursor: pointer;">
                <div class="biller-icon orange">🛡️</div>
                <h3>Insurance</h3>
                <p>Pay now</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('electricityCard').onclick = () => window.location.href = "{{ url('/pay-bill/electricity') }}";
        document.getElementById('waterCard').onclick = () => window.location.href = "{{ url('/pay-bill/water') }}";
        document.getElementById('internetCard').onclick = () => window.location.href = "{{ url('/pay-bill/internet') }}";
        document.getElementById('mobileCard').onclick = () => window.location.href = "{{ url('/pay-bill/mobile') }}";
        document.getElementById('cableCard').onclick = () => window.location.href = "{{ url('/pay-bill/cable') }}";
        document.getElementById('insuranceCard').onclick = () => window.location.href = "{{ url('/pay-bill/insurance') }}";
    </script>

</body>
</html>