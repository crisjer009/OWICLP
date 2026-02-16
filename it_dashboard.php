<?php
session_start();

// 1. Strict IT Access Check (New Logic)
// Only Role 3 (IT Dept) can enter this specific view
$userRole = isset($_SESSION['user_role']) ? (int)$_SESSION['user_role'] : 0;
if (!isset($_SESSION['user_id']) || $userRole !== 3) {
    header("Location: index.php"); 
    exit;
}

// 2. Database Connection
$db = new mysqli("localhost", "root", "", "clp");

// 3. IT Metrics
$full_name = $_SESSION['full_name'];

// Count total logs and total users (New Logic)
$log_count = $db->query("SELECT COUNT(*) as total FROM tbl_system_logs")->fetch_assoc()['total'];
$user_count = $db->query("SELECT COUNT(*) as total FROM tbl_users")->fetch_assoc()['total'];

// Fetch recent system logs
$system_logs = $db->query("SELECT * FROM tbl_system_logs ORDER BY timestamp DESC LIMIT 15");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Console | CLP System</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="img/x-icon" href="logo/logo2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { 
            --it-blue: #2980b9; 
            --it-dark: #1a1a2e; 
            --danger: #e74c3c; 
            --bg: #f0f2f5; 
            --brand-blue: #004a9b;
        }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; display: flex; overflow-x: hidden; }
        
        /* SIDEBAR  */
        .sidebar { width: 250px; background: var(--it-blue); color: white; min-height: 100vh; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; }
        .sidebar h2 { font-size: 1.2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; color: var(--it-blue); }
        .nav-links-container { flex-grow: 1; margin-top: 20px; }
        .nav-link { color: #bdc3c7; text-decoration: none; display: block; padding: 12px 0; transition: 0.3s; }
        .nav-link:hover { color: white; padding-left: 10px; }

        /* MAIN CONTENT */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        
        .stat-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid var(--it-blue); }
        .stat-card h4 { margin: 0; color: #888; font-size: 0.8rem; text-transform: uppercase; }
        .stat-card .value { font-size: 1.8rem; font-weight: bold; color: #333; margin: 10px 0; }

        /* LOG TABLE ( */
        .log-container { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .log-table { width: 100%; border-collapse: collapse; }
        .log-table th { text-align: left; padding: 12px; background: #f8f9fa; color: #666; font-size: 0.85rem; border-bottom: 1px solid #eee; }
        .log-table td { padding: 12px; border-bottom: 1px solid #eee; font-size: 0.85rem; font-family: 'Consolas', monospace; }
        
        .badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 0.7rem; }
        .badge-error { background: #ffdada; color: #c0392b; }
        .badge-info { background: #d1ecf1; color: #0c5460; }

        /* MODAL & DRAWER  */
        .bottom-nav { display: none; position: fixed; bottom: 0; width: 100%; background: white; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); justify-content: space-around; padding: 12px 0; z-index: 1000; }
        .mobile-drawer { position: fixed; top: 0; right: -320px; width: 280px; height: 100%; background: var(--it-blue); color: white; z-index: 3000; transition: all 0.4s ease; padding: 30px 20px; visibility: hidden; pointer-events: none; }
        .mobile-drawer.active { right: 0; visibility: visible; pointer-events: auto; }
        .drawer-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 2999; }
        .drawer-link { display: flex; align-items: center; color: white; text-decoration: none; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
        
        

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); z-index: 4000; align-items: center; justify-content: center; }
        .modal-box { background: white; width: 280px; border-radius: 15px; text-align: center; overflow: hidden; }
        .modal-footer { display: flex; border-top: 1px solid #eee; }
        .modal-btn { flex: 1; padding: 12px; border: none; background: none; font-size: 1rem; cursor: pointer; }

        @media (max-width: 768px) { 
            .sidebar { display: none; } 
            body { flex-direction: column; padding-bottom: 80px; }
            .bottom-nav { display: flex; }
            .main-content { padding: 20px; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div>
        <h2>IT COMMAND CENTER</h2>
        <p><i class="fa fa-terminal"></i> <?php echo $full_name; ?></p>
        <nav class="nav-links-container">
            <a href="admin_dashboard.php" class="nav-link"><i class="fa fa-arrow-left"></i> Back to Admin</a>
            <a href="#" class="nav-link"><i class="fa fa-server"></i> Server Status</a>
            <a href="#" class="nav-link"><i class="fa fa-database"></i> Database Tools</a>
        </nav>
    </div>
    <   <div onclick="openLogoutModal()" style="cursor:pointer;"><i class="fa fa-power-off"></i> Logout</div>
</div>

<div class="main-content">
    <div class="header">
        <h1>System Monitoring</h1>
        <div class="account-status">
            <span style="color: green;">● IT Specialist Online</span>
        </div>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h4>Total Registered Users</h4>
            <div class="value"><?php echo number_format($user_count); ?></div>
            <small style="color:green">DB Online</small>
        </div>
        <div class="stat-card">
            <h4>Security Events</h4>
            <div class="value"><?php echo number_format($log_count); ?></div>
            <small style="color:orange">Monitoring Active</small>
        </div>
        <div class="stat-card">
            <h4>Server Response</h4>
            <div class="value">24ms</div>
            <small style="color:green">Normal</small>
        </div>
    </div>

    <div class="log-container">
        <h3><i class="fa fa-list-ul"></i> Security & Error Logs</h3>
        <table class="log-table">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Action</th>
                    <th>Detail</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                <?php while($log = $system_logs->fetch_assoc()): ?>
                <tr>
                    <td style="color:#888;"><?php echo $log['timestamp']; ?></td>
                    <td>
                        <span class="badge <?php echo ($log['action'] == 'ACCOUNT_LOCKOUT' || $log['action'] == 'LOCKOUT') ? 'badge-error' : 'badge-info'; ?>">
                            <?php echo $log['action']; ?>
                        </span>
                    </td>
                    <td><?php echo $log['error_message']; ?></td>
                    <td><?php echo $log['ip_address']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="bottom-nav">
    <div class="bottom-nav-item active"><i class="fa fa-home"></i></div>
    <div class="bottom-nav-item" onclick="toggleMobileMenu()"><i class="fa fa-bars"></i></div>
</div>

<div class="drawer-overlay" id="drawerOverlay" onclick="toggleMobileMenu()"></div>
<div class="mobile-drawer" id="mobileDrawer">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h3 style="margin:0;">IT Menu</h3>
        <i class="fa fa-times" onclick="toggleMobileMenu()"></i>
    </div>
    <a href="admin_dashboard.php" class="drawer-link"><i class="fa fa-arrow-left"></i> Admin Panel</a>
    <a href="javascript:void(0)" class="drawer-link" onclick="toggleMobileMenu(); openLogoutModal();" style="color: #ff7675;">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>
</div>

<div id="logoutModal" class="modal-overlay">
    <div class="modal-box">
        <div style="padding:20px; font-weight:bold; color:var(--danger);">Logout</div>
        <div style="padding-bottom:20px;">Terminate IT Session?</div>
        <div class="modal-footer">
            <button class="modal-btn" onclick="closeLogoutModal()" style="color:#a4b0be; border-right:1px solid #eee;">Cancel</button>
            <button class="modal-btn" onclick="location.href='logout.php'" style="color:var(--it-blue); font-weight:bold;">Confirm</button>
        </div>
    </div>
</div>

<script>
    function toggleMobileMenu() {
        $('#mobileDrawer').toggleClass('active');
        $('#drawerOverlay').fadeToggle(300);
    }
    function openLogoutModal() { document.getElementById('logoutModal').style.display = 'flex'; }
    function closeLogoutModal() { document.getElementById('logoutModal').style.display = 'none'; }
</script>

</body>
</html>