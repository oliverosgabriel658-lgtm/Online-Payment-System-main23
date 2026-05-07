<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Payment - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/requestpayment.css') }}">
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
            <h1>Request Payment</h1>
            <p>Request Payment To Anyone With Their Email Address</p>
        </header>

        <div class="grid-layout">
            <div class="card">
                <form action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Recipient Email</label>
                        <input type="email" name="email" placeholder="recipient@example.com" class="main-input">
                    </div>

                    <div class="form-group">
                        <label>Amount</label>
                        <div class="input-wrapper">
                            <span class="currency">₱</span>
                            <input type="number" id="requestAmount" name="amount" placeholder="000.00" class="main-input amount-padding">
                        </div>
                    </div>
                    
                    <div class="shortcut-container">
                        <button type="button" class="shortcut-btn" onclick="setReqVal(500)">₱500</button>
                        <button type="button" class="shortcut-btn" onclick="setReqVal(1000)">₱1,000</button>
                        <button type="button" class="shortcut-btn" onclick="setReqVal(2500)">₱2,500</button>
                        <button type="button" class="shortcut-btn" onclick="setReqVal(5000)">₱5,000</button>
                    </div>

                    <div class="form-group">
                        <label>Reason for Request</label>
                        <textarea name="reason" placeholder="Add a note for the recipient...." class="main-textarea"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Due date (Optional)</label>
                        <input type="text" name="due_date" placeholder="mm/dd/yy" class="main-input" onfocus="(this.type='date')">
                    </div>

                    <button type="submit" class="request-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 10px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Create Payment Request
                    </button>
                </form>
            </div>

            <div class="summary-column">
                <div class="card summary-card">
                    <h3>Request Summary</h3>
                    <div class="summary-row"><span>Amount</span><span id="reqDisplayAmt">₱ 0.00</span></div>
                    <div class="summary-row"><span>Processing fee</span><span>₱ 0.00</span></div>
                    <hr>
                    <div class="total-row">
                        <span>You'll Received</span>
                        <span id="reqDisplayTotal">₱ 0.00</span>
                    </div>
                </div>

                <div class="info-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="info-icon"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <p>An automatic email notification will be sent to the requester with a secure payment link.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setReqVal(n) { document.getElementById('requestAmount').value = n; updateReq(n); }
        document.getElementById('requestAmount').addEventListener('input', (e) => updateReq(e.target.value));
        function updateReq(v) {
            let n = parseFloat(v) || 0;
            let f = '₱ ' + n.toLocaleString(undefined, {minimumFractionDigits: 2});
            document.getElementById('reqDisplayAmt').innerText = f;
            document.getElementById('reqDisplayTotal').innerText = f;
        }
    </script>
</body>
</html>