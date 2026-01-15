<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }

        .navbar {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .navbar h1 {
            font-size: 24px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar-right span {
            font-size: 14px;
        }

        .navbar-right a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s;
        }

        .navbar-right a:hover {
            background: rgba(255,255,255,0.3);
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .welcome-section h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .welcome-section p {
            color: #666;
        }

        .info-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .info-card h3 {
            color: #f5576c;
            margin-bottom: 15px;
        }

        .info-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .action-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .action-section h3 {
            color: #333;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-btn {
            display: block;
            padding: 15px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 8px;
            transition: transform 0.2s;
            font-weight: 500;
        }

        .action-btn:hover {
            transform: translateY(-3px);
        }

        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Candidate Dashboard</h1>
        <div class="navbar-right">
            <span>Welcome, <?php echo htmlspecialchars($data['user']['name']); ?></span>
            <a href="/logout">Logout</a>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <div class="welcome-section">
            <h2>Candidate Portal</h2>
            <p>Welcome to your candidate dashboard</p>
        </div>

        <div class="info-card">
            <h3>Getting Started</h3>
            <p>As a candidate, you have access to job listings and application features.</p>
            <p>Your account email: <strong><?php echo htmlspecialchars($data['user']['email']); ?></strong></p>
        </div>

        <div class="action-section">
            <h3>Quick Actions</h3>
            <div class="action-buttons">
                <a href="/change-password" class="action-btn">Change Password</a>
            </div>
        </div>
    </div>
</body>
</html>