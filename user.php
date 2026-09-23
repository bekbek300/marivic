<?php
session_start();
// Security Guard: Redirect sa login kung hindi naka-login
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            /* Purple Baby Gradient Background */
            background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 50%, #ce93d8 100%);
            font-family: 'Quicksand', sans-serif;
            min-height: 100vh;
            color: #4a148c;
            overflow-x: hidden;
            position: relative;
        }

        /* Soft floating purple bubbles */
        .bubble {
            position: absolute;
            background: rgba(186, 104, 200, 0.15);
            border-radius: 50%;
            animation: float 7s infinite ease-in-out;
            pointer-events: none;
            z-index: 0;
        }
        .bubble:nth-child(1) { width: 90px; height: 90px; top: 15%; left: 5%; animation-delay: 0s; }
        .bubble:nth-child(2) { width: 140px; height: 140px; bottom: 10%; right: 5%; animation-delay: 2.5s; }
        .bubble:nth-child(3) { width: 60px; height: 60px; top: 70%; left: 20%; animation-delay: 4s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-25px) scale(1.05); }
        }

        /* Top Navigation Bar */
        .navbar {
            background: linear-gradient(135deg, #ba68c8 0%, #9c27b0 100%);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 20px rgba(156, 39, 176, 0.3);
            position: relative;
            z-index: 1;
        }
        .navbar h2 { 
            color: #ffffff; 
            font-weight: 700; 
            letter-spacing: 2px; 
            text-transform: uppercase; 
            font-size: 20px;
        }
        
        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 10px 25px;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 13px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.3s ease;
        }
        .btn-logout:hover { 
            background: #ffffff; 
            color: #9c27b0; 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
        }

        /* Main Content */
        .container { 
            padding: 50px 40px; 
            max-width: 900px; 
            margin: 0 auto; 
            position: relative;
            z-index: 1;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 50px 40px;
            border-radius: 24px;
            border: 2px solid #e1bee7;
            box-shadow: 0 15px 35px rgba(156, 39, 176, 0.15), inset 0 0 15px rgba(255, 255, 255, 0.5);
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: popIn 0.6s ease-out;
        }

        @keyframes popIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* Top glowing accent line */
        .welcome-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(90deg, #ba68c8, #9c27b0, #ba68c8);
        }

        .welcome-card h1 { 
            color: #6a1b9a; 
            font-weight: 700; 
            margin-bottom: 15px; 
            font-size: 28px;
            letter-spacing: 1px; 
        }
        .welcome-card h1 span { 
            color: #9c27b0; 
            text-shadow: 0 2px 10px rgba(156, 39, 176, 0.2); 
        }
        .welcome-card p { 
            color: #ab47bc; 
            font-size: 16px; 
            font-weight: 600; 
            letter-spacing: 1px; 
        }
    </style>
</head>
<body>

    <!-- Floating bubbles -->
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>

    <nav class="navbar">
        <h2>🌸 User Panel</h2>
        <a href="logout.php" class="btn-logout">Log Out</a>
    </nav>

    <div class="container">
        <div class="welcome-card">
            <h1>Welcome, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</h1>
            <p>You are logged in. System status: ONLINE.</p>
        </div>
    </div>

</body>
</html>