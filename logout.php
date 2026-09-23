<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
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
            color: #4a148c;
            text-align: center;
            overflow: hidden;
            position: relative;
        }

        /* Soft floating purple bubbles */
        .bubble {
            position: absolute;
            background: rgba(186, 104, 200, 0.15);
            border-radius: 50%;
            animation: float 7s infinite ease-in-out;
            pointer-events: none;
        }
        .bubble:nth-child(1) { width: 100px; height: 100px; top: 20%; left: 10%; animation-delay: 0s; }
        .bubble:nth-child(2) { width: 150px; height: 150px; bottom: 10%; right: 10%; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-25px) scale(1.05); }
        }

        .logout-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 50px 40px;
            border-radius: 30px;
            border: 2px solid #e1bee7;
            box-shadow: 0 20px 40px rgba(156, 39, 176, 0.15), inset 0 0 15px rgba(255, 255, 255, 0.5);
            position: relative;
            z-index: 1;
            animation: popIn 0.5s ease-out;
            max-width: 400px;
            width: 100%;
        }
        
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .logout-card h2 { 
            color: #8e24aa; 
            font-weight: 700; 
            margin-bottom: 10px; 
            font-size: 26px; 
            letter-spacing: 1px;
        }
        .logout-card p { 
            color: #ba68c8; 
            margin-bottom: 30px; 
            font-size: 15px; 
            font-weight: 600; 
            letter-spacing: 1px;
        }
        
        /* Spinning Purple Loader */
        .tech-loader {
            width: 45px;
            height: 45px;
            border: 4px solid rgba(186, 104, 200, 0.2);
            border-top: 4px solid #9c27b0;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
            box-shadow: 0 0 15px rgba(156, 39, 176, 0.2);
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
    <meta http-equiv="refresh" content="2;url=login.php">
</head>
<body>
    <div class="bubble"></div>
    <div class="bubble"></div>

    <div class="logout-card">
        <h2>Goodbye! 💜</h2>
        <p>You have been successfully logged out.</p>
        <div class="tech-loader"></div>
        <p style="margin-top: 20px; font-size: 12px; color: #ce93d8;">Redirecting to login screen...</p>
    </div>
</body>
</html>