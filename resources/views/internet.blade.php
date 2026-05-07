<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Internet Bill - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/internet.css') }}">
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
    <div class="biller-icon-large">
        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 18C13.1046 18 14 17.1046 14 16C14 14.8954 13.1046 14 12 14C10.8954 14 10 14.8954 10 16C10 17.1046 10.8954 18 12 18Z" fill="#FF007A"/>
            <path d="M7.05005 11.05C8.3633 9.73675 10.1441 9 12 9C13.8559 9 15.6367 9.73675 16.95 11.05" stroke="#FF007A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M4.22003 8.22C6.28114 6.15889 9.07675 5 12 5C14.9233 5 17.7189 6.15889 19.78 8.22" stroke="#FF007A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M1.39001 5.39C4.20063 2.57938 8.01261 1 12 1C15.9874 1 19.7994 2.57938 22.61 5.39" stroke="#FF007A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
    <div class="header-text">
        <h1>PLDT Fibr</h1>
        <p>Internet</p>
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
                        <p>Payment will be processed instantly. Your PLDT Fibr account will be credited within 1-2 business days.</p>
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