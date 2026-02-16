<?php
session_start();

// 1. Refined Access Control 
$userRole = isset($_SESSION['user_role']) ? (int)$_SESSION['user_role'] : 0;
if (!isset($_SESSION['user_id']) || ($userRole !== 1 && $userRole !== 3)) {
    header("Location: index.php");
    exit;
}

// 2. Database Connection
$db = new mysqli("localhost", "root", "", "clp");

// 3. Define UI Variables
$isAdmin = ($userRole === 1);
$isIT    = ($userRole === 3);
$theme_color = $isAdmin ? '#004a9b' : '#2980b9'; 
$panel_title = $isAdmin ? 'CLP | Admin' : 'CLP | IT Dashboard';

// 4. Retrieve session data
$full_name = $_SESSION['full_name'];

// 5. Global System Metrics
$total_points_query = $db->query("SELECT SUM(total_points) as total FROM tbl_users");
$total_points_issued = $total_points_query->fetch_assoc()['total'] ?? 0;

// Checks for status 'L', 'Blocked', or empty based on dump
$blocked_query = $db->query("SELECT COUNT(*) as total FROM tbl_users WHERE user_status != 'Active' AND user_status != 'A'");
$blocked_count = $blocked_query->fetch_assoc()['total'];

// 6. User Management List
$all_users = $db->query("SELECT id, username, user_status, user_attempt, FirstName, LastName FROM tbl_users ORDER BY id DESC LIMIT 10");

// Fetch live count of active users
$active_query = $db->query("SELECT COUNT(*) as total FROM tbl_users WHERE user_status = 'Active' OR user_status = 'A'");
$active_count = $active_query->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $panel_title; ?> | CLP</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <link rel="icon" type="img/x-icon" href="logo/logo2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root { 
            --admin-dark: #004a9b; --it-blue: #2980b9; --brand-blue: #004a9b; 
            --bg-light: #f4f7f6; --danger-red: #ff7675; --success-green: #27ae60;
        }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg-light); margin: 0; display: flex; overflow-x: hidden; }
        
        /* SIDEBAR  */
        .sidebar { width: 250px; background: <?php echo $theme_color; ?>; color: white; min-height: 100vh; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; transition: 0.3s; }
        .sidebar h2 { font-size: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 10px; }
        .nav-links-container { flex-grow: 1; margin-top: 20px; }
        .nav-link { color: white; text-decoration: none; display: block; padding: 12px 0; opacity: 0.8; transition: 0.3s; }
        .nav-link:hover { opacity: 1; padding-left: 10px; }

        /* MAIN CONTENT */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(104, 102, 227, 0.05); }
        .card h3 { margin-top: 0; font-size: 0.8rem; color: #888; text-transform: uppercase; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        
        /* TABLE STYLING */
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .admin-table th { text-align: left; font-size: 0.8rem; color: #aaa; padding: 10px; border-bottom: 1px solid #eee; }
        .admin-table td { padding: 12px 10px; font-size: 0.85rem; border-bottom: 1px solid #f9f9f9; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: bold; }
        
        .unlock-btn { color: var(--brand-blue); border: 1px solid var(--brand-blue); background: none; padding: 4px 8px; border-radius: 4px; cursor: pointer; transition: 0.3s; }
        .unlock-btn:hover { background: var(--brand-blue); color: white; }

        /* MODAL & DRAWER  */
        .bottom-nav { display: none; position: fixed; bottom: 0; width: 100%; background: white; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); justify-content: space-around; padding: 12px 0; z-index: 1000; }
        .bottom-nav-item { color: #888; font-size: 1.2rem; cursor: pointer; text-align: center; }
        .mobile-drawer { position: fixed; top: 0; right: -320px; width: 280px; height: 100%; background: <?php echo $theme_color; ?>; color: white; z-index: 3000; transition: all 0.4s ease; padding: 30px 20px; visibility: hidden; pointer-events: none; }
        .mobile-drawer.active { right: 0; visibility: visible; pointer-events: auto; }
        .drawer-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 2999; }
        .drawer-link { display: flex; align-items: center; color: white; text-decoration: none; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .drawer-link i { margin-right: 15px; width: 25px; text-align: center; }

        
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); z-index: 4000; align-items: center; justify-content: center; }
        .modal-box { background: white; width: 280px; border-radius: 15px; text-align: center; overflow: hidden; }
        .modal-footer { display: flex; border-top: 1px solid #eee; }
        .modal-btn { flex: 1; padding: 12px; border: none; background: none; font-size: 1rem; cursor: pointer; }

        @media (max-width: 768px) { 
            .sidebar { display: none; } 
            body { flex-direction: column; padding-bottom: 80px; }
            .bottom-nav { display: flex; }
            .main-content { padding: 20px; }
            .dashboard-grid { grid-template-columns: 1fr; }
        }

        .unlock-btn {
        background: white;
        color: var(--brand-blue);
        border: 1px solid var(--brand-blue);
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .unlock-btn:hover {
        background: var(--brand-blue);
        color: white;
        box-shadow: 0 4px 6px -1px rgba(0, 74, 155, 0.2);
    }
    
    </style>
</head>
<body>

<div class="sidebar">
    <div>
        <h2><?php echo $panel_title; ?></h2>
        <p><i class="fa fa-shield-alt"></i> <?php echo $full_name; ?></p>
        <nav class="nav-links-container">
            <a href="#" class="nav-link"><i class="fa fa-users"></i> Members Deatils</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-file-invoice"></i> Transaction</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-circle-dollar-to-slot"></i> Earn Module</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-gift"></i> Redeem Module</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-gear"></i> Settings</a>
            <?php if($isIT): ?>
                <a href="#" class="nav-link"><i class="fa fa-terminal"></i> System Logs</a>
            <?php endif; ?>
        </nav>
    </div>
    <img src="icon/switch.png" alt="Logout" onclick="openLogoutModal()" style="width: 35px; height: 35px; margin-right: 10px; vertical-align: middle;">
    </div>


<div class="main-content">
    <div class="header">
        <h1>Overall View</h1>
        <div class="account-status">
            <span style="color: green;">● System Online</span>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="card" style="text-align: center;">
            <h3>Total Points Issued</h3>
            <div style="font-size: 1.5rem; font-weight: bold; color: var(--brand-blue);"><?php echo number_format($total_points_issued); ?></div>
        </div>

        <!-- for active account count -->
<div class="card" style="text-align: center; border-left: 4px solid var(--success-green);">
    <h3>Active Accounts</h3>
    <div style="font-size: 1.5rem; font-weight: bold; color: var(--success-green);">
        <?php echo number_format($active_count); ?>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div id="statusAlert" style="padding: 12px; margin-bottom: 20px; border-radius: 8px; text-align: center; font-size: 0.9rem; font-weight: 600; 
        <?php echo ($_GET['msg'] == 'UserUnlocked' || $_GET['msg'] == 'UserActive') ? 'background: #dcfce7; color: #166534; border: 1px solid #bbf7d0;' : 'background: #fee2e2; color: #991b1b; border: 1px solid #fecaca;'; ?>">
        <i class="fa <?php echo ($_GET['msg'] == 'UserUnlocked' || $_GET['msg'] == 'UserActive') ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
        <?php 
            if ($_GET['msg'] == 'UserUnlocked' || $_GET['msg'] == 'UserActive') echo "User account has been successfully activated.";
            else echo "An error occurred while trying to update the account.";
        ?>
    </div>
    <script>
        setTimeout(() => { 
            const alert = document.getElementById('statusAlert');
            if(alert) alert.style.display = 'none'; 
        }, 3000);
    </script>
<?php endif; ?>

<!-- for locked account count -->
<div class="card" style="text-align: center; border-left: 4px solid var(--danger-red);">
            <h3>Locked Accounts</h3>
            <div style="font-size: 1.5rem; font-weight: bold; color: var(--danger-red);"><?php echo $blocked_count; ?></div>
        </div>

        <?php if (isset($_GET['msg'])): ?>
            <div id="statusAlert" style="grid-column: span 2; padding: 12px; margin-bottom: 10px; border-radius: 8px; text-align: center; font-size: 0.9rem; font-weight: 600; 
                <?php echo ($_GET['msg'] == 'UserUnlocked') ? 'background: #dcfce7; color: #166534;' : 'background: #fee2e2; color: #991b1b;'; ?>">
                <?php echo ($_GET['msg'] == 'UserUnlocked') ? 'User account successfully unlocked.' : 'Error processing request.'; ?>
            </div>
            <script>setTimeout(() => { $('#statusAlert').fadeOut(); }, 3000);</script>
        <?php endif; ?>

        <div class="card" style="grid-column: span 2;">
            <h3>Recent User Activity</h3>
            <table class="admin-table">
                <thead>
                    <tr><th>Name</th><th>Username</th><th>Attempts</th><th>Status</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php while($user = $all_users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['FirstName'] . " " . $user['LastName']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['user_attempt']; ?> / 3</td>
                        <td>
                            <span class="status-badge" style="background: <?php echo ($user['user_status'] == 'Active' || $user['user_status'] == 'A') ? '#e1f5fe; color:#01579b;' : '#ffebee; color:#b71c1c;'; ?>">
                                <?php echo ($user['user_status'] == 'Active' || $user['user_status'] == 'A') ? 'Active' : 'Locked'; ?>
                            </span>
                        </td>
                        <td>
                            <?php if($user['user_status'] != 'Active' && $user['user_status'] != 'A'): ?>
                                <button class="unlock-btn" onclick="unlockUser(<?php echo $user['id']; ?>, '<?php echo $user['username']; ?>')">
                                    <i class="fa fa-unlock-alt"></i> Unlock
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<div class="bottom-nav">
    <div class="bottom-nav-item active"><i class="fa fa-home"></i></div>
    <div class="bottom-nav-item"><i class="fa fa-search"></i></div>
    <div class="bottom-nav-item"><i class="fa fa-bell"></i></div>
    <div class="bottom-nav-item" onclick="toggleMobileMenu()"><i class="fa fa-bars"></i></div>
</div>

<div class="drawer-overlay" id="drawerOverlay" onclick="toggleMobileMenu()"></div>
<div class="mobile-drawer" id="mobileDrawer">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h3 style="margin:0;">Menu</h3>
        <i class="fa fa-times" onclick="toggleMobileMenu()"></i>
    </div>
    <a href="#" class="drawer-link"><i class="fa fa-users"></i> Members Deatils</a>
            <a href="#" class="drawer-link"><i class="fa-solid fa-file-invoice"></i> Transaction</a>
            <a href="#" class="drawer-link"><i class="fa-solid fa-circle-dollar-to-slot"></i> Earn Module</a>
            <a href="#" class="drawer-link"><i class="fa-solid fa-gift"></i> Redeem Module</a>
            <a href="#" class="drawer-link"><i class="fa-solid fa-gear"></i> Settings</a>
            <?php if($isIT): ?>
        <a href="#" class="drawer-link"><i class="fa fa-terminal"></i> System Logs</a>
    <?php endif; ?>
    <a href="javascript:void(0)" class="drawer-link" onclick="toggleMobileMenu(); openLogoutModal();" style="color: #ff7675;">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>
</div>

<div id="logoutModal" class="modal-overlay">
    <div class="modal-box">
        <div style="padding:20px; font-weight:bold; color:#ff4757;">Logout</div>
        <div style="padding-bottom:20px;">Are you sure you want to logout?</div>
        <div class="modal-footer">
            <button class="modal-btn" onclick="closeLogoutModal()" style="color:#a4b0be; border-right:1px solid #eee;">Cancel</button>
            <button class="modal-btn" onclick="location.href='logout.php'" style="color:#6c5ce7; font-weight:bold;">Confirm</button>
        </div>
    </div>
</div>

<script>
// 3. Unlock Function
    function unlockUser(userId, username) {
        if (confirm("Are you sure you want to unlock @" + username + "?")) {
            window.location.href = "unlock_process.php?id=" + userId;
        }
    }

    function toggleMobileMenu() {
        $('#mobileDrawer').toggleClass('active');
        $('#drawerOverlay').fadeToggle(300);
    }
    function openLogoutModal() { document.getElementById('logoutModal').style.display = 'flex'; }
    function closeLogoutModal() { document.getElementById('logoutModal').style.display = 'none'; }

    function unlockUser(userId) {
        if(confirm("Reset attempts and unlock this account?")) {
            $.post('process_admin.php', { action: 'unlock', id: userId }, function(res) {
                location.reload();
            });
        }
    }
</script>

</body>
</html>