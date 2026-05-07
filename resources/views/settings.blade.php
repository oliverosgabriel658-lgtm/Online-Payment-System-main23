<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Settings</title>
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="settings-page-body">
    <header class="top-nav">
        <a href="{{ url('/dashboard') }}" class="back-link">
            <span>←</span> Back To Dashboard
        </a>
    </header>

    <main class="page-container">
        <div class="header-text">
            <h1>Notification Settings</h1>
            <p>Manage how to receive notifications and alerts</p>
        </div>

        <div class="settings-stack">
            <div class="settings-card">
                <h3>Transaction Notification</h3>
                <p class="section-desc">Get notified about your payment activities</p>
                
                <div class="setting-item">
                    <div class="item-info">
                        <div class="icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <p class="item-title">Payment Sent</p>
                            <p class="item-desc">When you send a payment to someone</p>
                        </div>
                    </div>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="item-info">
                        <div class="icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <p class="item-title">Payment Received</p>
                            <p class="item-desc">When you receive a payment</p>
                        </div>
                    </div>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="item-info">
                        <div class="icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <p class="item-title">Payment Failed</p>
                            <p class="item-desc">When a payment fails to process</p>
                        </div>
                    </div>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="item-info">
                        <div class="icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <p class="item-title">Payment Pending</p>
                            <p class="item-desc">When a payment is pending confirmation</p>
                        </div>
                    </div>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="settings-card">
                <h3>Account Notifications</h3>
                <p class="section-desc">Important updates about your account</p>
                
                <div class="setting-item">
                    <div class="item-info">
                        <div class="icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <p class="item-title">Security Alerts</p>
                            <p class="item-desc">Suspicious activity or login attempts</p>
                        </div>
                    </div>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="item-info">
                        <div class="icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <p class="item-title">Monthly Statement</p>
                            <p class="item-desc">Monthly account summary and statements</p>
                        </div>
                    </div>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="settings-card">
                <h3>Marketing & Updates</h3>
                <p class="section-desc">Optional promotional content</p>
                
                <div class="setting-item">
                    <div class="item-info">
                        <div class="icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <p class="item-title">Promotions & Offers</p>
                            <p class="item-desc">Special offers and promotional content</p>
                        </div>
                    </div>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="setting-item">
                    <div class="item-info">
                        <div class="icon-box">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <div>
                            <p class="item-title">Tips & Tutorials</p>
                            <p class="item-desc">Helpful tips to get the most out of PayThru</p>
                        </div>
                    </div>
                    <label class="switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <div class="delivery-box">
                <div class="delivery-content">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    <div>
                        <h4>Email Delivery</h4>
                        <p>All notifications will be sent to your registered email address: <strong>alex.johnson@email.com</strong></p>
                        <p class="small-text">Update your email in account settings to manage where notifications are sent.</p>
                    </div>
                </div>
            </div>

            <button class="save-btn">Save Settings</button>
        </div>
    </main>
</body>
</html>