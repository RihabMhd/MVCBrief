<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 48px;
            width: 100%;
            max-width: 480px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .form-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
        }

        .form-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 14px;
            color: #6b7280;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid;
        }

        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border-left-color: #ef4444;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border-left-color: #22c55e;
        }

        .alert-icon {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .alert-error .alert-icon {
            background-color: #ef4444;
            color: white;
        }

        .alert-success .alert-icon {
            background-color: #22c55e;
            color: white;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s ease;
            background-color: #ffffff;
            color: #111827;
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-group input:hover {
            border-color: #9ca3af;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .back-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }

        .back-link a {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .back-link a:hover {
            color: #1d4ed8;
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 36px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <div class="form-icon">🔐</div>
            <h1>Change Password</h1>
            <p>Update your account password</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <div class="alert-icon">!</div>
                <span><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <div class="alert-icon">✓</div>
                <span><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
            </div>
        <?php endif; ?>

        <form action="/change-password" method="POST">
            <div class="form-group">
                <label for="old_password">Current Password</label>
                <input type="password" id="old_password" name="old_password" 
                       placeholder="Enter current password" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" 
                       placeholder="Enter new password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" 
                       placeholder="Confirm new password" required>
            </div>

            <button type="submit" class="btn-submit">Update Password</button>
        </form>

        <div class="back-link">
            <a href="/dashboard">← Back to Dashboard</a>
        </div>
    </div>
</body>
</html>