<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayThru - Transaction History</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #1a73e8;
            --bg-light: #f8f9fa;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --success-green: #10b981;
            --danger-red: #ef4444;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            margin: 0;
            color: var(--text-main);
        }

        /* RESTORED: Original 3-column grid structure layout */
        .navbar {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 15px 40px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .nav-left { display: flex; align-items: center; gap: 10px; }
        .logo-box {
            background: var(--primary-blue);
            color: white;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-weight: bold;
        }

        .nav-links { display: flex; gap: 30px; }
        .nav-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            transition: color 0.2s;
        }
        .nav-links a.active { color: var(--primary-blue); }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header-area { text-align: left; margin-bottom: 30px; }
        .header-area h1 { font-size: 1.8rem; margin: 0; font-weight: 700; }
        .header-area p { color: var(--text-muted); margin-top: 5px; }

        .table-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        thead { background: #f8fafc; border-bottom: 1px solid #f1f5f9; }
        th { padding: 16px 24px; font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 600; }
        td { padding: 18px 24px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }

        .badge { padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
        .status-completed { background: #ecfdf5; color: var(--success-green); }
        .type-tag { font-size: 0.8rem; padding: 4px 8px; background: #f1f5f9; border-radius: 6px; color: #475569; text-transform: capitalize; }
        .amount-neg { color: var(--danger-red); font-weight: 600; }
        .amount-pos { color: var(--success-green); font-weight: 600; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-left">
            <div class="logo-box">₱</div>
            <span style="font-weight: 700; font-size: 1.1rem;">Pay Thru</span>
        </div>
        
        <div class="nav-links">
            <a href="{{ url('/dashboard') }}">Dashboard</a>
            <a href="{{ url('/transactions') }}" class="active">Transaction</a>
            <a href="{{ url('/settings') }}">Settings</a>
        </div>
    </nav>

    <main class="container">
        <div class="header-area">
            <h1>Transaction History</h1>
            <p>Review your recent activity and payments.</p>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Details</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>
                            <div style="font-weight: 500;">
                                {{ $transaction->description ?? 'No Description Provided' }}
                            </div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">
                                Ref: {{ $transaction->reference_number ?? 'N/A' }}
                            </div>
                        </td>
                        <td>
                            <span class="type-tag">{{ str_replace('_', ' ', $transaction->type ?? 'Payment') }}</span>
                        </td>
                        <td>
                            <span class="{{ str_contains(strtolower($transaction->type ?? ''), 'receive') ? 'amount-pos' : 'amount-neg' }}">
                                {{ str_contains(strtolower($transaction->type ?? ''), 'receive') ? '+' : '-' }}₱{{ number_format($transaction->amount ?? 0, 2) }}
                            </span>
                        </td>
                        <td style="color: var(--text-muted);">
                            {{ isset($transaction->created_at) ? \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y • h:i A') : 'N/A' }}
                        </td>
                        <td><span class="badge status-completed">COMPLETED</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>