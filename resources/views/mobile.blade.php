<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Mobile Bill - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>
<body>

    <nav class="top-nav-bar">
        <a href="{{ url('/pay-bill') }}" class="back-link">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back To Billers
        </a>
    </nav>

    <div class="page-wrapper">
        <header class="page-header">
            <div class="biller-icon-large" style="color: #22C55E;">
                <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15.05 5A5 5 0 0 1 19 8.95M15.05 1A9 9 0 0 1 23 8.94m-1 7.98v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            </div>
            <div class="header-text">
                <h1>Globe Postpaid</h1>
                <p>Mobile</p>
            </div>
        </header>

        <div class="grid-layout">
            <div class="payment-card">
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="tel" placeholder="Enter your account number" class="main-input" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>

                    <div class="form-group">
                        <label>Amount to Pay</label>
                        <div class="input-with-symbol">
                            <span class="currency-symbol">₱</span>
                            <input type="number" id="billAmount" placeholder="0.00" class="main-input amount-input">
                        </div>
                    </div>

                    <div class="shortcut-container">
                        <button type="button" class="shortcut-btn" onclick="setVal(500)">₱500</button>
                        <button type="button" class="shortcut-btn" onclick="setVal(1000)">₱1000</button>
                        <button type="button" class="shortcut-btn" onclick="setVal(2000)">₱2000</button>
                        <button type="button" class="shortcut-btn" onclick="setVal(5000)">₱5000</button>
                    </div>

                    <div class="status-info-box">
                        <p>Payment will be processed instantly. Your Globe Postpaid account will be credited within 1-2 business days.</p>
                    </div>

                    <button type="submit" class="submit-pay-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" style="margin-right: 8px;"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                        Pay Bill
                    </button>
                </form>
            </div>

            <div class="summary-container">
                <div class="summary-card">
                    <h3>Payment Summary</h3>
                    <div class="summary-row"><span>Bill Amount</span><span id="displayAmt">₱ 0.00</span></div>
                    <div class="summary-row"><span>Service Fee</span><span>₱ 15.00</span></div>
                    <hr class="divider">
                    <div class="total-row"><span>Total</span><span id="displayTotal">₱ 15.00</span></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setVal(v) { 
            document.getElementById('billAmount').value = v; 
            updateSum(v); 
        }
        document.getElementById('billAmount').addEventListener('input', (e) => updateSum(e.target.value));
        function updateSum(v) {
            let amt = parseFloat(v) || 0;
            let total = amt + 15;
            document.getElementById('displayAmt').innerText = '₱ ' + amt.toLocaleString(undefined, {minimumFractionDigits: 2});
            document.getElementById('displayTotal').innerText = '₱ ' + total.toLocaleString(undefined, {minimumFractionDigits: 2});
        }
    </script>
</body>
</html>