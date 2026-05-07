<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - PayThru</title>
    <link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Ensuring badges handle the new Send/Receive types */
        .type-badge.Send.Money { background: #fee2e2; color: #991b1b; }
        .type-badge.Receive.Money { background: #dcfce7; color: #166534; }
        .type-badge.deposit { background: #e0e7ff; color: #3730a3; }
        
        /* Tooltip style for reference numbers */
        code { background: #f1f5f9; padding: 2px 4px; border-radius: 4px; font-family: monospace; }
    </style>
</head>
<body>
    <header class="main-header">
        <a href="{{ url('/dashboard') }}" class="back-link">
            <span>←</span> Back To Dashboard
        </a>
        <button class="export-button" onclick="window.print()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Export PDF
        </button>
    </header>

    <main class="page-container">
        <div class="header-section">
            <h1 class="page-title">Transaction History</h1>
            <p class="page-subtitle">View and manage all your payment transactions</p>
        </div>

        <div class="transaction-card">
            <div class="toolbar">
                <div class="search-wrapper">
                    <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="Search by ID or Type..." class="search-input" id="tableSearch">
                </div>
                <button class="filter-button">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    Filters
                </button>
            </div>

            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>Reference ID</th>
                        <th>Type</th>
                        <th>Details</th>
                        <th>Amount</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                        <tr>
                            <td>
                                <code>{{ $trx->reference_number ?? 'N/A' }}</code>
                            </td>
                            
                            <td>
                                <span class="type-badge {{ $trx->type }}">
                                    {{ $trx->type }}
                                </span>
                            </td>

                            <td style="color: #64748b;">
                                {{ $trx->description ?? 'No description' }}
                            </td>

                            <td style="font-weight: 700; color: {{ ($trx->type == 'Receive Money' || $trx->type == 'deposit') ? '#10b981' : '#ef4444' }};">
                                {{ ($trx->type == 'Receive Money' || $trx->type == 'deposit') ? '+' : '-' }} 
                                ₱{{ number_format($trx->amount, 2) }}
                            </td>

                            <td style="color: #64748b;">
                                {{ is_string($trx->created_at) ? date('M d, Y • h:i A', strtotime($trx->created_at)) : $trx->created_at->format('M d, Y • h:i A') }}
                            </td>

                            <td>
                                <span class="status-badge {{ strtolower($trx->status) }}">
                                    {{ strtoupper($trx->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="6">
                                <div class="empty-state">
                                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    <p>No transactions found yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <script>
        document.getElementById('tableSearch').addEventListener('keyup', function() {
            let filter = this.value.toUpperCase();
            let rows = document.querySelector(".transaction-table tbody").rows;
            
            for (let i = 0; i < rows.length; i++) {
                if (rows[i].classList.contains('empty-row')) continue;
                
                let refCol = rows[i].cells[0].textContent.toUpperCase();
                let typeCol = rows[i].cells[1].textContent.toUpperCase();
                let detailCol = rows[i].cells[2].textContent.toUpperCase();
                
                if (refCol.indexOf(filter) > -1 || typeCol.indexOf(filter) > -1 || detailCol.indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }      
            }
        });
    </script>
</body>
</html>