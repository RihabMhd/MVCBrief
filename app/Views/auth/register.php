<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Job Portal</title>
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

        .register-container {
            background-color: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 48px;
            width: 100%;
            max-width: 500px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .brand-logo {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-weight: 700;
            font-size: 24px;
        }

        .register-header h1 {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .register-header p {
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

        .alert-icon {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background-color: #ef4444;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .form-group input,
        .form-group select {
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

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-group input:hover,
        .form-group select:hover {
            border-color: #9ca3af;
        }

        .form-group select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }

        .error-text {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-register {
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

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }

        .login-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .login-link a:hover {
            color: #1d4ed8;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 36px 24px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-header">
            <div class="brand-logo">JP</div>
            <h1>Create Account</h1>
            <p>Join our platform today</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <div class="alert-icon">!</div>
                <span><?php echo $_SESSION['error'];
                        unset($_SESSION['error']); ?></span>
            </div>
        <?php endif; ?>

        <form action="/register" method="POST">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name"
                    placeholder="John Doe"
                    value="<?php echo $_SESSION['old']['name'] ?? ''; ?>" required>
                <?php if (isset($_SESSION['errors']['name'])): ?>
                    <div class="error-text">⚠ <?php echo $_SESSION['errors']['name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"
                    placeholder="you@example.com"
                    value="<?php echo $_SESSION['old']['email'] ?? ''; ?>" required>
                <?php if (isset($_SESSION['errors']['email'])): ?>
                    <div class="error-text">⚠ <?php echo $_SESSION['errors']['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="role_id">Register As</label>
                <select id="role_id" name="role_id" required>
                    <option value="">Select your role</option>
                    <option value="2">Recruiter</option>
                    <option value="3">Candidate</option>
                </select>
                <?php if (isset($_SESSION['errors']['role_id'])): ?>
                    <div class="error-text">⚠ <?php echo $_SESSION['errors']['role_id']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                    placeholder="Create a secure password" required>
                <?php if (isset($_SESSION['errors']['password'])): ?>
                    <div class="error-text">⚠ <?php echo $_SESSION['errors']['password']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password_confirm">Confirm Password</label>
                <input type="password" id="password_confirm" name="password_confirm"
                    placeholder="Re-enter your password" required>
            </div>

            <button type="submit" class="btn-register">Create Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="/login">Sign in</a>
        </div>
    </div>

    <?php
    unset($_SESSION['errors']);
    unset($_SESSION['old']);
    ?>
</body>

</html>