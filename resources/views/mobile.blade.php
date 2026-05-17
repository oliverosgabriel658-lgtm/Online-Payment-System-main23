<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Mobile Data - PayThru</title>
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
            <div class="biller-icon-large">📱</div>
            <div class="header-text">
                <h1 id="headerTitle">Smart Communications</h1>
                <p>Mobile Data & Load</p>
            </div>
        </header>

        <div class="grid-layout">
            <div class="payment-card">
                <form action="{{ url('/pay-bill/electricity') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label>Select Network</label>
                        <select name="biller_name" class="main-input" id="billerSelect" onchange="updateBillerData(this.value)">
                            <option value="Smart Communications">Smart Communications</option>
                            <option value="Globe Telecom">Globe Telecom</option>
                            <option value="DITO Telecommunity">DITO Telecommunity</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="tel" 
                            name="account_number"
                            placeholder="09XXXXXXXXX" 
                            class="main-input @error('account_number') is-invalid @enderror" 
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                            maxlength="11"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Amount / Promo Price</label>
                        <div class="input-with-symbol">
                            <span class="currency-symbol">₱</span>
                            <input type="number" name="amount" id="billAmount" placeholder="0.00" class="main-input amount-input" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label id="promoLabel">Smart Popular Promos</label>
                        <div class="shortcut-container" id="shortcutBox">
                            </div>
                    </div>

                    <div class="status-info-box">
                        <p>Load will be sent to <span id="infoBiller">Smart Communications</span> instantly. No service fees apply.</p>
                    </div>

                    <button type="submit" class="submit-pay-btn">
                        Pay ₱<span id="btnTotal">0.00</span>
                    </button>
                </form>
            </div>

            <div class="summary-container">
                <div class="summary-card">
                    <h3>Purchase Summary</h3>
                    <div class="summary-row">
                        <span>Load Amount</span>
                        <span id="displayAmt">₱ 0.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Service Fee</span>
                        <span>₱ 0.00</span>
                    </div>
                    <hr class="divider">
                    <div class="total-row">
                        <span>Total</span>
                        <span id="displayTotal">₱ 0.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const promoData = {
            "Smart Communications": [
                { label: "PowerAll 99", val: 99 },
                { label: "PowerAll 149", val: 149 },
                { label: "Magic Data 399", val: 399 },
                { label: "Giga Video 50", val: 50 }
            ],
            "Globe Telecom": [
                { label: "Go50", val: 50 },
                { label: "Go+99", val: 99 },
                { label: "Go+250", val: 250 },
                { label: "Super Xtra 99", val: 99 }
            ],
            "DITO Telecommunity": [
                { label: "LevelUp 99", val: 99 },
                { label: "LevelUp 199", val: 199 },
                { label: "LevelUp 499", val: 499 },
                { label: "Data 50", val: 50 }
            ]
        };

        function updateBillerData(network) {
            document.getElementById('headerTitle').innerText = network;
            document.getElementById('infoBiller').innerText = network;
            document.getElementById('promoLabel').innerText = network + " Popular Promos";
            
            const container = document.getElementById('shortcutBox');
            container.innerHTML = ''; // Clear old buttons

            promoData[network].forEach(promo => {
                const btn = document.createElement('button');
                btn.type = "button";
                btn.className = "shortcut-btn";
                btn.innerText = promo.label;
                btn.onclick = () => setVal(promo.val);
                container.appendChild(btn);
            });
        }

        function setVal(v) { 
            document.getElementById('billAmount').value = v; 
            updateSum(v); 
        }

        document.getElementById('billAmount').addEventListener('input', (e) => updateSum(e.target.value));

        function updateSum(v) {
            let amt = parseFloat(v) || 0;
            let formatted = amt.toLocaleString(undefined, {minimumFractionDigits: 2});
            document.getElementById('displayAmt').innerText = '₱ ' + formatted;
            document.getElementById('displayTotal').innerText = '₱ ' + formatted;
            document.getElementById('btnTotal').innerText = formatted;
        }

        // Initialize with Smart
        updateBillerData("Smart Communications");
    </script>
</body>
</html>