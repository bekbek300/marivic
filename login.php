<?php
session_start();
require_once 'db.php';

// Redirect if already logged in
if (isset($_SESSION['logged_in'])) {
    if ($_SESSION['role'] === 'admin') { header("Location: admin.php"); exit(); }
    else { header("Location: user.php"); exit(); }
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && $password === $user['password']) {
        session_regenerate_id(true); 
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin.php"); exit();
        } else {
            header("Location: user.php"); exit();
        }
    } else {
        $error = "Access Denied. Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purple Baby System Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            /* Purple Baby Gradient Background */
            background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 50%, #ce93d8 100%);
            font-family: 'Quicksand', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Soft floating purple bubbles */
        .bubble {
            position: absolute;
            background: rgba(186, 104, 200, 0.2);
            border-radius: 50%;
            animation: float 7s infinite ease-in-out;
            pointer-events: none;
        }
        .bubble:nth-child(1) { width: 90px; height: 90px; top: 10%; left: 15%; animation-delay: 0s; }
        .bubble:nth-child(2) { width: 140px; height: 140px; bottom: 15%; right: 10%; animation-delay: 2.5s; background: rgba(156, 39, 176, 0.15); }
        .bubble:nth-child(3) { width: 60px; height: 60px; top: 60%; left: 5%; animation-delay: 4s; }
        .bubble:nth-child(4) { width: 110px; height: 110px; top: 20%; right: 20%; animation-delay: 1.5s; background: rgba(225, 190, 231, 0.4); }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-25px) scale(1.05); }
        }

        /* Login Card (Glassmorphism) */
        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 50px 40px;
            width: 100%;
            max-width: 420px;
            border-radius: 30px;
            border: 2px solid #e1bee7;
            box-shadow: 0 20px 40px rgba(156, 39, 176, 0.15), inset 0 0 15px rgba(255, 255, 255, 0.5);
            position: relative;
            z-index: 1;
            animation: popIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.9) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .login-card h2 {
            text-align: center;
            color: #8e24aa;
            margin-bottom: 8px;
            font-size: 30px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .login-card p.subtitle {
            text-align: center;
            color: #ba68c8;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 35px;
        }

        .input-group { margin-bottom: 22px; }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #6a1b9a;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .input-group input {
            width: 100%;
            padding: 16px 20px;
            background: #faf5fa;
            border: 2px solid #e1bee7;
            border-radius: 16px;
            font-size: 15px;
            color: #4a148c;
            font-family: 'Quicksand', sans-serif;
            font-weight: 600;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-group input::placeholder {
            color: #d1c4e9;
            font-weight: 500;
        }

        .input-group input:focus {
            border-color: #ba68c8;
            box-shadow: 0 0 15px rgba(186, 104, 200, 0.3);
            background: #ffffff;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #ba68c8 0%, #9c27b0 100%);
            color: #ffffff;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            font-family: 'Quicksand', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            box-shadow: 0 8px 20px rgba(156, 39, 176, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(156, 39, 176, 0.4);
            background: linear-gradient(135deg, #ab47bc 0%, #8e24aa 100%);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            color: #e53935;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            border: 1px dashed #e53935;
        }
    </style>
</head>
<body>

    <!-- Floating bubbles -->
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>

    <div class="login-card">
        <h2>System Login</h2>
        <p class="subtitle">Purpled 💜</p>
        
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username..." required autocomplete="off">
            </div>
            
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password..." required>
            </div>
            
            <button type="submit" class="btn-login">Log In</button>
        </form>
    </div>

</body>
</html>