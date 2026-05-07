<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayThru - Send Payment</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sendpayment.css') }}">
</head>
<body>

    <nav class="top-nav">
        <a href="{{ url('/dashboard') }}" class="back-link">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back To Dashboard
        </a>
    </nav>

    <main class="main-content">
        <div class="container">
            <header class="page-header">
                <h1>Send Payment</h1>
                <p>Send money instantly via PayThru Account Number</p>
            </header>

            @if(session('error'))
                <div class="error-alert" style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid-layout">
                <div class="form-section card shadow-sm">
                    <form action="{{ url('/send-payment') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label>Recipient Account Number</label>
                            <input type="text" name="account_number" placeholder="PT-XXXXXXXX" class="styled-input" required>
                            <small style="color: #64748b; font-size: 11px; margin-top: 5px; display: block;">
                                Enter the recipient's unique 8-digit PayThru account number.
                            </small>
                        </div>

                        <div class="form-group">
                            <label>Amount</label>
                            <div class="amount-wrapper">
                                <span class="currency">₱</span>
                                <input type="number" id="amountInput" name="amount" placeholder="0.00" step="0.01" class="styled-input amount-field" required min="1">
                            </div>
                            <div class="shortcut-container">
                                <button type="button" class="btn-pill" onclick="updateAmount(500)">₱500</button>
                                <button type="button" class="btn-pill" onclick="updateAmount(1000)">₱1000</button>
                                <button type="button" class="btn-pill" onclick="updateAmount(2500)">₱2500</button>
                                <button type="button" class="btn-pill" onclick="updateAmount(5000)">₱5000</button>
                            </div>
                        </div>

                        <div class="payment-methods">
                            <label>Payment Method</label>
                            <div class="method-option">
                                <input type="radio" name="payment_method" id="wallet" value="wallet" checked style="display: none;">
                                <label for="wallet" class="method-card active">
                                    <div class="method-left">
                                        <div class="icon-square gray-bg">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"></path><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"></path><rect x="14" y="11" width="8" height="6" rx="2"></rect></svg>
                                        </div>
                                        <div class="method-details">
                                            <span class="method-title">PayThru Wallet</span>
                                            <span class="method-sub">Available: ₱ {{ number_format(Auth::user()->balance, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="radio-indicator"></div>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Note (Optional)</label>
                            <textarea name="description" placeholder="What is this for? (e.g. Dinner, Rent)" class="styled-textarea"></textarea>
                        </div>

                        <button type="submit" class="btn-main-send">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" transform="rotate(-45)"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                            Send Payment
                        </button>
                    </form>
                </div>

                <div class="summary-section">
                    <div class="card summary-card shadow-sm">
                        <h3>Payment Summary</h3>
                        <div class="summary-row">
                            <span>Amount</span>
                            <span class="val" id="summaryAmount">₱ 0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Transaction Fee</span>
                            <span class="val">₱ 0.00</span>
                        </div>
                        <div class="divider"></div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="val" id="summaryTotal">₱ 0.00</span>
                        </div>
                    </div>

                    <div class="alert-box">
                        <div class="alert-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        </div>
                        <p>Payments are processed instantly and cannot be cancelled. Please verify the account number before sending.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const amountInput = document.getElementById('amountInput');
        const summaryAmount = document.getElementById('summaryAmount');
        const summaryTotal = document.getElementById('summaryTotal');

        function updateAmount(val) {
            amountInput.value = val;
            renderSummary(val);
        }

        amountInput.addEventListener('input', function() {
            renderSummary(this.value);
        });

        function renderSummary(val) {
            let num = parseFloat(val) || 0;
            let formatted = '₱ ' + num.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            summaryAmount.innerText = formatted;
            summaryTotal.innerText = formatted;
        }
    </script>
</body>
</html>