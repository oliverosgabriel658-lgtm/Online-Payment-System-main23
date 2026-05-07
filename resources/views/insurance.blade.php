<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PhilHealth - PayThru</title>
    <link rel="stylesheet" href="{{ asset('css/insurance.css') }}">
</head>
<body>
    <nav class="top-nav">
        <a href="{{ url('/pay-bill') }}" style="text-decoration:none; color:gray;">← Back To Billers</a>
    </nav>

    <div class="page-wrapper">
        <div class="header-section">
            <div class="biller-icon">
                <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div class="header-text">
                <h1>PhilHealth</h1>
                <p>Insurance</p>
            </div>
        </div>

        <div class="main-grid">
            <div class="card">
                <form>
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="tel" class="input-field" placeholder="Enter account number" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <div class="form-group">
                        <label>Amount to Pay</label>
                        <input type="number" id="amtInput" class="input-field" placeholder="0.00">
                    </div>
                    <div class="info-alert">
                        Payment will be processed instantly. Your PhilHealth account will be credited within 1-2 business days.
                    </div>
                    <button type="submit" class="pay-button">Pay Bill</button>
                </form>
            </div>

            <div class="card">
                <h3>Payment Summary</h3>
                <div class="summary-row"><span>Bill Amount</span><span id="sumAmt">₱ 0.00</span></div>
                <div class="summary-row"><span>Service Fee</span><span>₱ 15.00</span></div>
                <div class="total-row"><span>Total</span><span id="sumTotal">₱ 15.00</span></div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('amtInput').addEventListener('input', function() {
            let val = parseFloat(this.value) || 0;
            document.getElementById('sumAmt').innerText = '₱ ' + val.toFixed(2);
            document.getElementById('sumTotal').innerText = '₱ ' + (val + 15).toFixed(2);
        });
    </script>
</body>
</html>