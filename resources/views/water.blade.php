<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Water Bill - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/water.css') }}">
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
            <div class="biller-icon-large">💧</div>
            <div class="header-text">
                <h1>Manila Water</h1>
                <p>Water</p>
            </div>
        </header>

        <div class="grid-layout">
            <div class="payment-card">
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="tel" 
                            placeholder="Enter your account number" 
                            class="main-input" 
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                            pattern="[0-9]*">
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
                        <p>Payment will be processed instantly. Your Manila Water account will be credited within 1-2 business days.</p>
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
                    <div class="summary-row">
                        <span>Bill Amount</span>
                        <span id="displayAmt">₱ 0.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Service Fee</span>
                        <span>₱ 15.00</span>
                    </div>
                    <hr class="divider">
                    <div class="total-row">
                        <span>Total</span>
                        <span id="displayTotal">₱ 15.00</span>
                    </div>
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