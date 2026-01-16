<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Forbidden</title>
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

        .error-container {
            background-color: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 64px 48px;
            text-align: center;
            max-width: 560px;
            width: 100%;
        }

        .error-icon {
            width: 80px;
            height: 80px;
            background-color: #fef2f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 36px;
        }

        .error-code {
            font-size: 72px;
            font-weight: 800;
            color: #ef4444;
            line-height: 1;
            margin-bottom: 16px;
        }

        .error-title {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 12px;
        }

        .error-message {
            font-size: 15px;
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-home:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .info-box {
            margin-top: 32px;
            padding: 20px;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            text-align: left;
        }

        .info-box h3 {
            font-size: 16px;
            font-weight: 600;
            color: #991b1b;
            margin-bottom: 12px;
        }

        .info-box ul {
            list-style: none;
            padding-left: 0;
        }

        .info-box li {
            font-size: 14px;
            color: #7f1d1d;
            margin-bottom: 8px;
            padding-left: 24px;
            position: relative;
        }

        .info-box li::before {
            content: '•';
            position: absolute;
            left: 8px;
            color: #ef4444;
        }

        @media (max-width: 768px) {
            .error-container {
                padding: 48px 32px;
            }

            .error-code {
                font-size: 56px;
            }

            .error-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">🚫</div>
        <div class="error-code">403</div>
        <h1 class="error-title">Access Forbidden</h1>
        <p class="error-message">
            You don't have permission to access this resource. This area is restricted to authorized users only.
        </p>
        
        <a href="/dashboard" class="btn-home">
            ← Back to Dashboard
        </a>

        <div class="info-box">
            <h3>What you can do:</h3>
            <ul>
                <li>Return to the dashboard and try again</li>
                <li>Contact an administrator if you believe this is an error</li>
                <li>Verify you have the necessary permissions</li>
                <li>Make sure you're logged in with the correct account</li>
            </ul>
        </div>
    </div>
</body>
</html>