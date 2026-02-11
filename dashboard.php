<?php
session_start();

// 1. Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// 2. Database Connection
$db = new mysqli("localhost", "root", "", "clp");

// 3. Retrieve basic session data
$full_name = $_SESSION['full_name'];
$username  = $_SESSION['username'];
$status    = isset($_SESSION['status']) ? $_SESSION['status'] : 'Active';

// 4. Temporary Placeholders since no data form db
$points    = 0; 
$tier      = "Member"; 
$expiry    = "Standard Account";
$tier_color = "#bdc3c7"; 

// 5. Simplified Leaderboard (fetching only what exists)
// This query only uses 'username' and 'id' to avoid errors if 'total_points' is missing
$leaderboard = $db->query("SELECT username FROM tbl_users LIMIT 3");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard | CLP</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --brand-blue: #004a9b; --bg-light: #f4f7f6; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg-light); margin: 0; display: flex; }
        
        .sidebar { width: 250px; background: var(--brand-blue); color: white; min-height: 100vh; padding: 20px; }
        .sidebar h2 { font-size: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 10px; }
        .nav-link { color: white; text-decoration: none; display: block; padding: 12px 0; opacity: 0.8; transition: 0.3s; }
        .nav-link:hover { opacity: 1; padding-left: 10px; }

        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card h3 { margin-top: 0; font-size: 1.1rem; color: #555; border-bottom: 1px solid #eee; padding-bottom: 10px; }

        .tier-badge { 
            display: inline-block; padding: 5px 15px; border-radius: 20px; 
            font-weight: bold; color: #fff; background: <?php echo $tier_color; ?>; 
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .rank-list { list-style: none; padding: 0; }
        .rank-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f1f1; }

        textarea { width: 100%; border-radius: 10px; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; resize: none; }
        .send-btn { background: var(--brand-blue); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }

        @media (max-width: 768px) { body { flex-direction: column; } .sidebar { width: 100%; min-height: auto; } }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>CLP Rewards</h2>
    <p><i class="fa fa-user-circle"></i> <?php echo $full_name; ?></p>
    <nav>
        <a href="#" class="nav-link"><i class="fa fa-home"></i> Dashboard</a>
        <a href="#" class="nav-link"><i class="fa fa-shopping-cart"></i> My Purchases</a>
        <a href="logout.php" class="nav-link" style="margin-top: 20px; color: #ff7675;"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </nav>
</div>

<div class="main-content">
    <div class="header">
        <h1>Welcome, <?php echo explode(' ', $full_name)[0]; ?>!</h1>
        <div class="account-status">
            Status: <span style="color: <?php echo ($status == 'A' || $status == 'Active') ? 'green' : 'red'; ?>; font-weight: bold;">● <?php echo $status; ?></span>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="card" style="text-align: center;">
            <h3>Your Loyalty Stats</h3>
            <div style="font-size: 2.5rem; font-weight: bold; color: var(--brand-blue);"><?php echo number_format($points); ?></div>
            <p>Total Reward Points</p>
            <div class="tier-badge"><?php echo $tier; ?> Tier</div>
            <p style="font-size: 0.8rem; color: #888; margin-top: 10px;">Account Status: <?php echo $expiry; ?></p>
        </div>

        <div class="card">
            <h3>Account Benefits</h3>
            <ul class="rank-list">
                <li class="rank-item"><span><i class="fa fa-check-circle"></i> Standard Discount</span></li>
                <li class="rank-item"><span><i class="fa fa-check-circle"></i> Access to Promotions</span></li>
            </ul>
        </div>

        <div class="card">
            <h3>Community Members</h3>
            <div class="rank-list">
                <div class="rank-item"><strong>Username</strong> <strong>Status</strong></div>
                <?php while($row = $leaderboard->fetch_assoc()): ?>
                <div class="rank-item" style="<?php echo ($row['username'] == $username) ? 'background:#eef5ff; font-weight:bold;' : ''; ?>">
                    <span><?php echo $row['username']; ?></span>
                    <span style="color: green; font-size: 0.8rem;">Online</span>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="card">
            <h3>Popular Categories</h3>
            <canvas id="categoryChart" height="150"></canvas>
        </div>

        <div class="card">
            <h3>Contact Admin</h3>
            <textarea id="adminMsg" rows="3" placeholder="How can we help you today?"></textarea>
            <button class="send-btn" onclick="sendMessage()">Send Message</button>
        </div>
    </div>
</div>

<script>
    function sendMessage() {
        const msg = $('#adminMsg').val();
        if(msg.trim() === "") return alert("Please enter a message.");
        alert("Your message has been sent to the administrator.");
        $('#adminMsg').val('');
    }

    const ctx = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Office Supplies', 'Electronics', 'Furniture'],
            datasets: [{
                data: [45, 25, 30],
                backgroundColor: ['#004a9b', '#e056fd', '#27ae60']
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });
</script>

</body>
</html>