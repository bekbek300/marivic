<?php
session_start();
require_once 'db.php'; 

if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all users from the database para ilagay sa table
try {
    $stmt = $pdo->query("SELECT id, username, role FROM users ORDER BY id ASC");
    $users = $stmt->fetchAll();
    $total_users = count($users);
    
    $admin_count = 0;
    $user_count = 0;
    foreach ($users as $u) {
        if ($u['role'] === 'admin') $admin_count++;
        else $user_count++;
    }
} catch (PDOException $e) {
    $users = [];
    $total_users = 0;
    $admin_count = 0;
    $user_count = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Rajdhani', sans-serif; }
        
        body { background-color: #0b1120; color: #e2e8f0; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: rgba(15, 23, 42, 0.95);
            border-right: 1px solid rgba(0, 242, 254, 0.2);
            padding: 30px 0;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            box-shadow: 5px 0 15px rgba(0, 242, 254, 0.05);
            z-index: 10;
        }

        .sidebar h2 {
            color: #00f2fe;
            text-align: center;
            font-size: 24px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 0 0 10px rgba(0, 242, 254, 0.5);
            margin-bottom: 40px;
        }

        .sidebar a {
            color: #94a3b8;
            text-decoration: none;
            padding: 15px 30px;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(0, 242, 254, 0.05);
            color: #00f2fe;
            border-left: 3px solid #00f2fe;
            text-shadow: 0 0 8px rgba(0, 242, 254, 0.4);
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 40px;
            width: calc(100% - 250px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 20px;
        }
        .header h1 { font-size: 28px; font-weight: 700; letter-spacing: 1px; }
        .header h1 span { color: #00f2fe; text-shadow: 0 0 10px rgba(0, 242, 254, 0.4); }
        
        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            padding: 10px 25px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: 1px solid rgba(239, 68, 68, 0.3);
            transition: all 0.3s ease;
        }
        .btn-logout:hover { background: #ef4444; color: #fff; box-shadow: 0 0 15px rgba(239, 68, 68, 0.5); }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: rgba(15, 23, 42, 0.8);
            padding: 25px;
            border-radius: 8px;
            border: 1px solid rgba(0, 242, 254, 0.15);
            box-shadow: 0 0 15px rgba(0, 242, 254, 0.05);
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 3px; height: 100%;
            background: #00f2fe;
        }
        .stat-card h3 { color: #94a3b8; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .stat-card p { font-size: 32px; font-weight: 700; color: #00f2fe; text-shadow: 0 0 10px rgba(0,242,254,0.3); }

        /* User Table */
        .table-container {
            background: rgba(15, 23, 42, 0.8);
            border-radius: 8px;
            border: 1px solid rgba(0, 242, 254, 0.15);
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 242, 254, 0.05);
        }
        .table-container h2 { font-size: 20px; margin-bottom: 20px; letter-spacing: 1px; color: #e2e8f0; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        th { color: #00f2fe; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        td { font-size: 16px; font-weight: 600; }
        
        .role-badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .role-admin { background: rgba(0, 242, 254, 0.1); color: #00f2fe; border: 1px solid rgba(0, 242, 254, 0.3); }
        .role-user { background: rgba(79, 172, 254, 0.1); color: #4facfe; border: 1px solid rgba(79, 172, 254, 0.3); }

        tr:hover { background: rgba(255, 255, 255, 0.02); }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin System</h2>
        <a href="admin.php" class="active">Dashboard</a>
        <a href="#">User Management</a>
        <a href="#">System Logs</a>
        <a href="#">Settings</a>
        <a href="logout.php" style="margin-top: auto; color: #ef4444;">Log Out</a>
    </div>

    <div class="main-content">
        
        <div class="header">
            <h1>Welcome, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>.</h1>
            <a href="logout.php" class="btn-logout">Log Out</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="stat-card">
                <h3>Administrators</h3>
                <p><?php echo $admin_count; ?></p>
            </div>
            <div class="stat-card">
                <h3>Regular Users</h3>
                <p><?php echo $user_count; ?></p>
            </div>
            <div class="stat-card">
                <h3>System Status</h3>
                <p style="font-size: 20px; color: #10b981;">ONLINE</p>
            </div>
        </div>

        <div class="table-container">
            <h2>Registered Users (Database)</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td>
                                    <span class="role-badge <?php echo $user['role'] === 'admin' ? 'role-admin' : 'role-user'; ?>">
                                        <?php echo htmlspecialchars($user['role']); ?>
                                    </span>
                                </td>
                                <td style="color: #10b981;">Active</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #94a3b8;">No users found in database.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>