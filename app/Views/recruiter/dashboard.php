<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruiter Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            color: #1a1a1a;
        }

        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
        }

        .navbar h1 {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            letter-spacing: -0.3px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-name {
            font-size: 14px;
            color: #4b5563;
            font-weight: 500;
        }

        .logout-btn {
            color: #6b7280;
            text-decoration: none;
            padding: 8px 16px;
            background-color: transparent;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background-color: #f9fafb;
            border-color: #9ca3af;
            color: #374151;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px;
        }

        .page-header {
            margin-bottom: 32px;
        }

        .page-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .page-header p {
            font-size: 15px;
            color: #6b7280;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border-left-color: #22c55e;
        }

        .alert-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #22c55e;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .card-header {
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
        }

        .card-subtitle {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.5;
        }

        .info-row {
            display: flex;
            padding: 14px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 14px;
            color: #6b7280;
            font-weight: 500;
            flex: 0 0 140px;
        }

        .info-value {
            font-size: 14px;
            color: #111827;
            font-weight: 500;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .stat-card {
            background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 6px;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .actions-section {
            margin-top: 24px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 16px;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }

        .action-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 24px;
            text-decoration: none;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .action-card:hover {
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
            transform: translateY(-2px);
        }

        .action-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .action-content {
            flex: 1;
        }

        .action-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 4px;
        }

        .action-description {
            font-size: 13px;
            color: #6b7280;
        }

        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .navbar-container {
                padding: 14px 20px;
            }

            .navbar h1 {
                font-size: 18px;
            }

            .user-name {
                display: none;
            }

            .main-container {
                padding: 24px 20px;
            }

            .page-header h2 {
                font-size: 24px;
            }

            .action-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <div class="logo">R</div>
                <h1>Recruiter Portal</h1>
            </div>
            <div class="navbar-right">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($data['user']['name'], 0, 1)); ?>
                    </div>
                    <span class="user-name"><?php echo htmlspecialchars($data['user']['name']); ?></span>
                </div>
                <a href="/logout" class="logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <div class="alert-icon">✓</div>
                <span><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
            </div>
        <?php endif; ?>

        <div class="page-header">
            <h2>Dashboard</h2>
            <p>Manage your recruitment activities and account settings</p>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Account Information</h3>
                    <p class="card-subtitle">Your profile and contact details</p>
                </div>
                <div>
                    <div class="info-row">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><?php echo htmlspecialchars($data['user']['name']); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email Address</div>
                        <div class="info-value"><?php echo htmlspecialchars($data['user']['email']); ?></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Account Type</div>
                        <div class="info-value">Recruiter</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status</div>
                        <div class="info-value" style="color: #22c55e;">Active</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Overview</h3>
                    <p class="card-subtitle">Quick statistics</p>
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">0</div>
                        <div class="stat-label">Active Jobs</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">0</div>
                        <div class="stat-label">Applications</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="actions-section">
            <h3 class="section-title">Quick Actions</h3>
            <div class="action-grid">
                <a href="/change-password" class="action-card">
                    <div class="action-icon">🔐</div>
                    <div class="action-content">
                        <div class="action-title">Change Password</div>
                        <div class="action-description">Update your security credentials</div>
                    </div>
                </a>
                <a href="/profile" class="action-card">
                    <div class="action-icon">👤</div>
                    <div class="action-content">
                        <div class="action-title">Edit Profile</div>
                        <div class="action-description">Update your information</div>
                    </div>
                </a>
                <a href="/settings" class="action-card">
                    <div class="action-icon">⚙️</div>
                    <div class="action-content">
                        <div class="action-title">Settings</div>
                        <div class="action-description">Configure your preferences</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>