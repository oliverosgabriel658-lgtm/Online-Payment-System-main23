<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Money - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/addmoney.css') }}">
</head>
<body>

    <nav class="top-nav-bar">
        <a href="{{ url('/dashboard') }}" class="back-link">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Dashboard
        </a>
    </nav>

    <div class="page-wrapper">
        <header class="page-header">
            <h1>Add Money</h1>
            <p>Deposit funds to your PayThru wallet</p>
        </header>

        <div class="grid-layout">
            <div class="card">
                <form action="#" method="POST">
                    @csrf
                    <label>Deposit Amount</label>
                    <div class="input-wrapper">
                        <span class="currency">₱</span>
                        <input type="number" id="depositAmount" name="amount" placeholder="0.00" class="main-input">
                    </div>
                    <p class="hint">Minimum deposit: 100</p>
                    
                    <div class="shortcut-container">
                        <button type="button" class="shortcut-btn" onclick="setVal(500)">₱500</button>
                        <button type="button" class="shortcut-btn" onclick="setVal(1000)">₱1,000</button>
                        <button type="button" class="shortcut-btn" onclick="setVal(5000)">₱5,000</button>
                        <button type="button" class="shortcut-btn" onclick="setVal(10000)">₱10,000</button>
                    </div>

                    <label>Deposit Method</label>
                    <div class="method-card active" onclick="selectMethod(this)">
                        <div class="dot-indicator"></div>
                        <div class="method-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="10" width="20" height="11" rx="2" ry="2"></rect><path d="M7 10v4M12 10v4M17 10v4M2 10l10-7 10 7"></path></svg>
                        </div>
                        <div class="method-text">
                            <span class="m-title">Bank Transfer</span>
                            <span class="m-sub">Transfer from your bank account</span>
                            <span class="m-process">Processing: Instant to 1 business day</span>
                        </div>
                    </div>

                    <div class="method-card" onclick="selectMethod(this)">
                        <div class="dot-indicator"></div>
                        <div class="method-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        </div>
                        <div class="method-text">
                            <span class="m-title">Credit/Debit Card</span>
                            <span class="m-sub">Visa, Mastercard, JCB</span>
                            <span class="m-process">Processing: Instant</span>
                        </div>
                    </div>

                    <div class="reference-group">
                        <label>Reference Number (Optional)</label>
                        <input type="text" placeholder="Enter bank reference number" class="main-input">
                        <p class="hint">If you've already made a bank transfer, enter the reference number here for faster processing.</p>
                    </div>

                    <div class="instruction-box">
                        <strong>Bank Transfer Instructions:</strong>
                        <p>Bank: <b>BDO Unibank</b></p>
                        <p>Account Name: <b>PayThru Philippines Inc.</b></p>
                        <p>Account Number: <b>0123-4567-8901</b></p>
                        <p class="ins-footer">After transferring, submit this form with the reference number.</p>
                    </div>

                    <button type="submit" class="add-money-btn">+ Add Money</button>
                </form>
            </div>

            <div class="summary-column">
                <div class="card summary-card">
                    <h3>Deposit Summary</h3>
                    <div class="summary-row"><span>Deposit Amount</span><span id="displayAmt">₱ 0.00</span></div>
                    <div class="summary-row"><span>Processing fee</span><span>₱ 0.00</span></div>
                    <div class="total-row"><span>Total</span><span id="displayTotal">₱ 0.00</span></div>
                    <div class="wallet-bal">
                        <p>Current Wallet Balance</p>
                        <strong>₱ {{ number_format(Auth::user()->balance ?? 0, 2) }}</strong>
                    </div>
                </div>

                <div class="notes-card">
                    <div class="notes-header">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        Important Notes
                    </div>
                    <ul>
                        <li>Credit card deposits are processed instantly.</li>
                        <li>Bank transfers may take up to 1 business day.</li>
                        <li>Keep your reference number for tracking.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setVal(n) { document.getElementById('depositAmount').value = n; update(n); }
        document.getElementById('depositAmount').addEventListener('input', (e) => update(e.target.value));
        function update(v) {
            let n = parseFloat(v) || 0;
            let f = '₱ ' + n.toLocaleString(undefined, {minimumFractionDigits: 2});
            document.getElementById('displayAmt').innerText = f;
            document.getElementById('displayTotal').innerText = f;
        }
        function selectMethod(el) {
            document.querySelectorAll('.method-card').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
        }
    </script>
</body>
</html>