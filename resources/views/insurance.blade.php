<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Insurance - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/water.css') }}">
    <style>
        /* Optional style helpers for session alert messages */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .alert-danger {
            background-color: #fef2f2;
            color: #ef4444;
            border: 1px solid #fee2e2;
        }
        .alert-success {
            background-color: #ecfdf5;
            color: #10b981;
            border: 1px solid #d1fae5;
        }
    </style>
</head>
<body>
    <nav class="top-nav-bar">
        <a href="{{ url('/pay-bill') }}" class="back-link">Back To Billers</a>
    </nav>

    <div class="page-wrapper">
        <header class="page-header">
            <div class="biller-icon-large">🛡️</div>
            <div class="header-text">
                <h1 id="headerTitle">PhilHealth</h1>
                <p>Government Insurance</p>
            </div>
        </header>

        <div class="grid-layout">
            <div class="payment-card">
                
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ url('/pay-bill/insurance') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Select Insurance Provider</label>
                        <select name="biller_name" class="main-input" id="billerSelect" onchange="updateBillerData(this.value)">
                            <option value="PhilHealth">PhilHealth</option>
                            <option value="SSS">SSS (Social Security System)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Policy / Account Number</label>
                        <input type="tel" name="account_number" id="accInput" placeholder="12-digit PIN" class="main-input" value="{{ old('account_number') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                    </div>

                    <div class="form-group">
                        <label>Contribution Amount</label>
                        <div class="input-with-symbol">
                            <span class="currency-symbol">₱</span>
                            <input type="number" name="amount" id="billAmount" placeholder="0.00" class="main-input amount-input" value="{{ old('amount') }}" oninput="updateSum(this.value)" required>
                        </div>
                    </div>

                    <div class="status-info-box">
                        <p>Your <span id="infoBiller">PhilHealth</span> payment will be posted within 24-48 hours.</p>
                    </div>

                    <button type="submit" class="submit-pay-btn">Pay Bill</button>
                </form>
            </div>

            <div class="summary-container">
                <div class="summary-card">
                    <h3>Payment Summary</h3>
                    <div class="summary-row"><span>Amount</span> <span id="displayAmt">₱ 0.00</span></div>
                    <div class="summary-row"><span>Service Fee</span> <span>₱ 15.00</span></div>
                    <hr class="divider">
                    <div class="total-row"><span>Total</span> <span id="displayTotal">₱ 15.00</span></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateBillerData(val) {
            document.getElementById('headerTitle').innerText = val;
            document.getElementById('infoBiller').innerText = val;
            document.getElementById('accInput').placeholder = (val === 'PhilHealth') ? "12-digit PIN" : "10-digit SSS No.";
        }
        function updateSum(v) {
            let amt = parseFloat(v) || 0;
            document.getElementById('displayAmt').innerText = '₱ ' + amt.toFixed(2);
            document.getElementById('displayTotal').innerText = '₱ ' + (amt + 15).toFixed(2);
        }

        // Run sum calculations on page load if old calculation numbers exist
        window.onload = function() {
            let initialVal = document.getElementById('billAmount').value;
            if(initialVal) updateSum(initialVal);
            
            let initialBiller = document.getElementById('billerSelect').value;
            if(initialBiller) updateBillerData(initialBiller);
        };
    </script>
</body>
</html>