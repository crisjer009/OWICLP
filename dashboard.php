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

// 4. Placeholders
$points      = 0; 
$tier        = "Member"; 
$tier_color  = "#bdc3c7"; 

$issued_mtd   = 12450; 
$redeemed_mtd = 8200;  
$at_risk_count = 5;    

// 5. Data Queries
$leaderboard = $db->query("SELECT username FROM tbl_users LIMIT 3");
$power_users = $db->query("SELECT id, username FROM tbl_users LIMIT 3");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard | CLP</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --brand-blue: #004a9b; --bg-light: #f4f7f6; --danger-red: #ff7675; --success-green: #27ae60; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg-light); margin: 0; display: flex; }
        
        /* --- SIDEBAR --- */
        .sidebar { width: 250px; background: var(--brand-blue); color: white; min-height: 100vh; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; }
        .sidebar h2 { font-size: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 10px; }
        .nav-links-container { flex-grow: 1; margin-top: 20px; }
        .nav-link { color: white; text-decoration: none; display: block; padding: 12px 0; opacity: 0.8; transition: 0.3s; }
        .nav-link:hover { opacity: 1; padding-left: 10px; }

        /* --- BOTTOM NAV --- */
        .bottom-nav { display: none; position: fixed; bottom: 0; width: 100%; background: white; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); justify-content: space-around; padding: 12px 0; z-index: 1000; }
        .bottom-nav-item { color: #888; font-size: 1.2rem; cursor: pointer; text-align: center; }
        .bottom-nav-item.active { color: var(--brand-blue); }
        .plus-btn { background: var(--brand-blue); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: -30px; box-shadow: 0 4px 10px rgba(0,74,155,0.3); }

        .logout-link { margin-top: auto; background-color: rgba(255, 75, 75, 0.1); color: #ff7675 !important; border-radius: 8px; padding: 12px 15px !important; font-weight: 600; border: 1px solid rgba(255, 75, 75, 0.2); transition: all 0.3s ease; display: flex; align-items: center; cursor: pointer; }
        .logout-link:hover { background-color: #ff7675 !important; color: white !important; }

        /* --- DASHBOARD --- */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card h3 { margin-top: 0; font-size: 0.9rem; color: #888; border-bottom: 1px solid #eee; padding-bottom: 10px; text-transform: uppercase; }
        
        /* amChart Styling */
        #chartdiv { width: 100%; height: 400px; }
        .full-row { grid-column: 1 / -1; }

        .power-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .power-table th { text-align: left; font-size: 0.8rem; color: #aaa; padding: 8px; border-bottom: 1px solid #eee; }
        .power-table td { padding: 10px 8px; font-size: 0.85rem; border-bottom: 1px solid #f9f9f9; }

        .tier-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-weight: bold; color: #fff; background: <?php echo $tier_color; ?>; }
        textarea { width: 100%; border-radius: 10px; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; resize: none; box-sizing: border-box;}
        .send-btn { background: var(--brand-blue); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; width: 100%;}

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); z-index: 2000; align-items: center; justify-content: center; }
        .modal-box { background: white; width: 280px; border-radius: 15px; text-align: center; overflow: hidden; animation: fadeIn 0.2s ease-out; }
        .modal-footer { display: flex; border-top: 1px solid #eee; }
        .modal-btn { flex: 1; padding: 12px; border: none; background: none; font-size: 1rem; cursor: pointer; }
        .confirm-btn { color: #6c5ce7; font-weight: bold; }
        
        @keyframes fadeIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        @media (max-width: 768px) { 
            body { flex-direction: column; padding-bottom: 80px; } 
            .sidebar { display: none; } 
            .bottom-nav { display: flex; } 
            .main-content { padding: 20px; }
            .dashboard-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } 
            .full-width-mobile { grid-column: span 2; }
            .card h3 { font-size: 0.7rem; }
            .header h1 { font-size: 1.3rem; }
            #chartdiv { height: 300px; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div>
        <h2>CLP Rewards</h2>
        <p><i class="fa fa-user-circle"></i> <?php echo $full_name; ?></p>
        <nav class="nav-links-container">
            <a href="#" class="nav-link"><i class="fa fa-home"></i> Dashboard</a>
            <a href="#" class="nav-link"><i class="fa fa-shopping-cart"></i> My Purchases</a>
        </nav>
    </div>
    <a href="javascript:void(0)" class="nav-link logout-link" onclick="openLogoutModal()">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Welcome, <?php echo explode(' ', $full_name)[0]; ?>!</h1>
        <div class="account-status">
            <span style="color: <?php echo ($status == 'A' || $status == 'Active') ? 'green' : 'red'; ?>;">● <?php echo $status; ?> Account</span>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="card full-row full-width-mobile">
            <h3>Loyalty Participation Stream</h3>
            <div id="chartdiv"></div>
        </div>

        <div class="card" style="text-align: center;">
            <h3>Issued (MTD)</h3>
            <div style="font-size: 1.5rem; font-weight: bold; color: var(--brand-blue);"><?php echo number_format($issued_mtd); ?></div>
        </div>

        <div class="card" style="text-align: center;">
            <h3>Redeemed (MTD)</h3>
            <div style="font-size: 1.5rem; font-weight: bold; color: var(--success-green);"><?php echo number_format($redeemed_mtd); ?></div>
        </div>

        <div class="card" style="text-align: center; border-left: 4px solid var(--danger-red);">
            <h3>At Risk</h3>
            <div style="font-size: 1.5rem; font-weight: bold; color: var(--danger-red);"><?php echo $at_risk_count; ?></div>
        </div>

        <div class="card full-width-mobile">
            <h3>Revenue Split (B2B vs B2C)</h3> 
            <canvas id="segmentChart" height="200"></canvas>
        </div>

        <div class="card full-width-mobile">
            <h3>Top Power Users</h3>
            <table class="power-table">
                <thead><tr><th>Member</th><th>Points</th></tr></thead>
                <tbody>
                    <?php while($user = $power_users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['username']; ?></td>
                        <td style="text-align: right; font-weight: bold;"><?php echo rand(2000, 8000); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3>Contact Admin</h3>
            <textarea id="adminMsg" rows="2" placeholder="Message..."></textarea>
            <button class="send-btn" onclick="sendMessage()">Send</button>
        </div>
    </div>
</div>

<div class="bottom-nav">
    <div class="bottom-nav-item active"><i class="fa fa-home"></i></div>
    <div class="bottom-nav-item"><i class="fa fa-search"></i></div>
    <div class="plus-btn"><i class="fa fa-plus"></i></div>
    <div class="bottom-nav-item"><i class="fa fa-bell"></i></div>
    <div class="bottom-nav-item" onclick="openLogoutModal()"><i class="fa fa-bars"></i></div>
</div>

<div id="logoutModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header" style="color:#ff4757; padding-top:20px;">Logout</div>
        <div class="modal-body" style="padding-bottom:20px;">Are you sure you want to logout?</div>
        <div class="modal-footer">
            <button class="modal-btn" onclick="closeLogoutModal()" style="color:#a4b0be; border-right:1px solid #eee;">Cancel</button>
            <button class="modal-btn confirm-btn" onclick="location.href='logout.php'">Confirm</button>
        </div>
    </div>
</div>

<script>
    // --- amCharts 5 Logic ---
    am5.ready(function() {
        var root = am5.Root.new("chartdiv");
        root.setThemes([am5themes_Animated.new(root)]);
        var chart = root.container.children.push(am5xy.XYChart.new(root, { panX: false, panY: false, wheelX: "panX", wheelY: "zoomX", layout: root.horizontalLayout }));
        var legend = chart.children.push(am5.Legend.new(root, { centerY: am5.p50, y: am5.p50, layout: root.verticalLayout, clickTarget: "none" }));
        legend.valueLabels.template.set("forceHidden", true);

        var data = [
            { year: "2022", paper: 78, ink: 20, office: 55 },
            { year: "2023", paper: 200, ink: 150, office: 90 },
            { year: "2024", paper: 160, ink: 210, office: 101 },
            { year: "2025", paper: 347, ink: 180, office: 150 }
        ];

        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, { categoryField: "year", renderer: am5xy.AxisRendererX.new(root, { minGridDistance: 50 }) }));
        xAxis.data.setAll(data);
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, { renderer: am5xy.AxisRendererY.new(root, {}) }));

        function createSeries(field, name) {
            var series = chart.series.push(am5xy.SmoothedXLineSeries.new(root, { name: name, xAxis: xAxis, yAxis: yAxis, valueField: field, valueYField: field + "_hi", openValueYField: field + "_low", categoryXField: "year", tooltip: am5.Tooltip.new(root, { labelText: "{name}: {valueY}" }) }));
            series.strokes.template.setAll({ forceHidden: true });
            series.fills.template.setAll({ visible: true, fillOpacity: 1 });
            series.appear();
            legend.data.push(series);
        }

        createSeries("paper", "Paper");
        createSeries("ink", "Ink");
        createSeries("office", "Furniture");

        for (var i = 0; i < data.length; i++) {
            var row = data[i], sum = 0;
            chart.series.each(function(s) { var f = s.get("valueField"), v = Number(row[f]); row[f + "_low"] = sum; row[f + "_hi"] = sum + v; sum += v; });
            var offset = sum / 2;
            chart.series.each(function(s) { var f = s.get("valueField"); row[f + "_low"] -= offset; row[f + "_hi"] -= offset; s.data.setAll(data); });
        }
        chart.appear(1000, 100);
    });

    // --- Chart.js ---
    const ctx2 = document.getElementById('segmentChart').getContext('2d');
    new Chart(ctx2, { type: 'pie', data: { labels: ['B2B', 'B2C'], datasets: [{ data: [65, 35], backgroundColor: ['#004a9b', '#3498db'] }] }, options: { plugins: { legend: { position: 'bottom' } } } });

    function sendMessage() { alert("Message sent."); }
    function openLogoutModal() { document.getElementById('logoutModal').style.display = 'flex'; }
    function closeLogoutModal() { document.getElementById('logoutModal').style.display = 'none'; }
</script>

</body>
</html>