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

            {{-- Success Message --}}
            @if(session('success'))
                <div class="success-alert" style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #bbf7d0;">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            {{-- Error Display --}}
            @if($errors->any())
                <div class="error-alert" style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #fecaca;">
                    <ul style="margin: 0; list-style: none;">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid-layout">
                <div class="form-section card shadow-sm">
                    <form action="{{ url('/send-payment') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Recipient Account Number</label>
                            <input type="text" name="account_number" id="acc_num" placeholder="PT-XXXXXXXX" class="styled-input" value="{{ old('account_number') }}" required>
                            <small style="color: #64748b; font-size: 0.8rem; margin-top: 4px; display: block;">Enter the unique "PT-" account number of the receiver.</small>
                        </div>

                        <div class="form-group">
                            <label>Amount</label>
                            <div class="amount-wrapper">
                                <span class="currency">₱</span>
                                <input type="number" id="amountInput" name="amount" placeholder="0.00" step="0.01" class="styled-input amount-field" value="{{ old('amount') }}" required min="1">
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
                            <textarea name="description" placeholder="What is this for?" class="styled-textarea">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn-main-send">Send Payment</button>
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
                        <div class="divider" style="height: 1px; background: #e2e8f0; margin: 15px 0;"></div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span class="val" id="summaryTotal">₱ 0.00</span>
                        </div>
                        
                        <div class="info-notice" style="margin-top: 20px; background: #eff6ff; padding: 12px; border-radius: 6px; display: flex; gap: 10px;">
                            <svg style="color: #3b82f6; flex-shrink: 0;" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                            <p style="font-size: 0.75rem; color: #1e40af; margin: 0;">Payments are processed instantly and cannot be cancelled once sent.</p>
                        </div>
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
            let formatted = '₱ ' + num.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            summaryAmount.innerText = formatted;
            summaryTotal.innerText = formatted;
        }

        // Initialize summary on page load (handles back buttons/errors)
        document.addEventListener('DOMContentLoaded', () => {
            if (amountInput.value) renderSummary(amountInput.value);
        });
    </script>
</body>
</html>