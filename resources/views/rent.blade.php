<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Property Rent - PayThru</title>
    <link rel="stylesheet" href="{{ asset('css/rent.css') }}">
</head>
<body>
    <nav class="top-nav">
        <a href="{{ url('/pay-bill') }}" style="text-decoration:none; color:gray;">← Back To Billers</a>
    </nav>

    <div class="page-wrapper">
        <div class="header-section">
            <div style="color: #1E293B;">
                <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
            <div class="header-text">
                <h1>Property Rent</h1>
                <p>Rent</p>
            </div>
        </div>

        <div class="main-grid">
            <div class="card">
                <form>
                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="tel" class="input-field" placeholder="Enter your account number" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <div class="form-group">
                        <label>Amount to Pay</label>
                        <input type="number" id="rentAmt" class="input-field" placeholder="₱ 0.00">
                    </div>

                    <div class="info-alert">
                        Payment will be processed instantly. Your Property Rent account will be credited within 1-2 business days.
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
        document.getElementById('rentAmt').addEventListener('input', function() {
            let val = parseFloat(this.value) || 0;
            document.getElementById('sumAmt').innerText = '₱ ' + val.toLocaleString(undefined, {minimumFractionDigits: 2});
            document.getElementById('sumTotal').innerText = '₱ ' + (val + 15).toLocaleString(undefined, {minimumFractionDigits: 2});
        });
    </script>
</body>
</html>