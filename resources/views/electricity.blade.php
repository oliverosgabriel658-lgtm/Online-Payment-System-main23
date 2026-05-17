<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Electricity - PayThru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/electricity.css') }}">
</head>
<body>

    <nav class="top-nav-bar">
        <a href="{{ url('/pay-bill') }}" class="back-link">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to billers
        </a>
    </nav>

    <div class="page-wrapper">
        <header class="page-header">
            <div class="biller-icon-large">⚡</div>
            <div class="header-text">
                <h1>Electricity Payment</h1>
                <p>Select provider and enter account details</p>
            </div>
        </header>

        <div class="grid-layout">
            <div class="payment-card">
                <form action="{{ route('pay.electricity.process') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label>Select Biller</label>
                        <select name="biller_name" id="billerSelect" class="main-input" style="background-color: white;">
                            <option value="LEYECO" {{ old('biller_name') == 'LEYECO' ? 'selected' : '' }}>LEYECO (Leyte Electric)</option>
                            <option value="SAMELCO" {{ old('biller_name') == 'SAMELCO' ? 'selected' : '' }}>SAMELCO (Samar Electric)</option>
                            <option value="DORELCO" {{ old('biller_name') == 'DORELCO' ? 'selected' : '' }}>DORELCO (Don Orestes Romualdez)</option>
                            <option value="MERALCO" {{ old('biller_name') == 'MERALCO' ? 'selected' : '' }}>Manila Electric Co. (Meralco)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Account Number</label>
                        <input type="text" 
                               name="account_number"
                               value="{{ old('account_number') }}"
                               placeholder="Enter your account number" 
                               class="main-input @error('account_number') is-invalid @enderror" 
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        
                        @error('account_number')
                            <span style="color: #ef4444; font-size: 13px; margin-top: 8px; display: block; font-weight: 500;">
                                @if(Str::contains($message, 'must be'))
                                    Invalid account number. Account number should be 6 digits.
                                @else
                                    {{ $message }}
                                @endif
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Amount to Pay</label>
                        <div class="input-with-symbol">
                            <span class="currency-symbol">₱</span>
                            <input type="number" 
                                   name="amount"
                                   id="billAmount" 
                                   step="0.01"
                                   value="{{ old('amount') }}"
                                   placeholder="0.00" 
                                   class="main-input amount-input @error('amount') is-invalid @enderror">
                        </div>
                        @error('amount')
                            <span style="color: #ef4444; font-size: 13px; margin-top: 8px; display: block; font-weight: 500;">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="shortcut-container">
                        <button type="button" class="shortcut-btn" onclick="setVal(500)">₱500</button>
                        <button type="button" class="shortcut-btn" onclick="setVal(1000)">₱1000</button>
                        <button type="button" class="shortcut-btn" onclick="setVal(2000)">₱2000</button>
                        <button type="button" class="shortcut-btn" onclick="setVal(5000)">₱5000</button>
                    </div>

                    <div class="status-info-box">
                        <p>Payment will be processed instantly. Your electricity account will be credited within 1-2 business days.</p>
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
                        <span id="displayAmt">₱ {{ number_format(old('amount', 0), 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Service Fee</span>
                        <span>₱ 15.00</span>
                    </div>
                    <hr class="divider">
                    <div class="total-row">
                        <span>Total</span>
                        <span id="displayTotal">₱ {{ number_format(old('amount', 0) ? old('amount') + 15 : 0, 2) }}</span>
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
            let total = amt > 0 ? amt + 15 : 0;
            document.getElementById('displayAmt').innerText = '₱ ' + amt.toLocaleString(undefined, {minimumFractionDigits: 2});
            document.getElementById('displayTotal').innerText = '₱ ' + total.toLocaleString(undefined, {minimumFractionDigits: 2});
        }

        window.addEventListener('DOMContentLoaded', () => {
            let initialVal = document.getElementById('billAmount').value;
            if (initialVal) {
                updateSum(initialVal);
            }
        });
    </script>
</body>
</html>