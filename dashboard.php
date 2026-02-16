<?php
session_start();

// --- NEW CACHE CONTROL LOGIC ---
// Forces the browser to always request a fresh page from the server
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-ca che");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// 1. Authentication Check
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// 2. Role-Based Redirection Logic
$userRole = isset($_SESSION['user_role']) ? (int)$_SESSION['user_role'] : 0;
if ($userRole === 1 || $userRole === 3) {
    header("Location: admin_dashboard.php");
    exit;
}

// 3. Database Connection
$db = new mysqli("localhost", "root", "", "clp");

// 4. Retrieve session & live database data
$user_id   = $_SESSION['user_id'];
$full_name = $_SESSION['full_name'];
$username  = $_SESSION['username'];
$status    = isset($_SESSION['status']) ? $_SESSION['status'] : 'Active';

// Pull real points and tier from tbl_users
$cust_query = $db->query("SELECT total_points, current_tier, account_expiry FROM tbl_users WHERE id = '$user_id'");
$cust_data  = $cust_query->fetch_assoc();

$total_points = $cust_data['total_points'] ?? 0;
$current_tier = $cust_data['current_tier'] ?? 'Member';
$expiry_date  = $cust_data['account_expiry'] ?? 'N/A';

// Dynamic values for the UI cards
$issued_mtd    = $total_points;
$redeemed_mtd  = 0; 
$at_risk_count = ($total_points > 0) ? 1 : 0;

// Leaderboard fetching
$power_users = $db->query("SELECT username, total_points FROM tbl_users WHERE user_role = 2 ORDER BY total_points DESC LIMIT 3");

// Tier color logic for the badge
$tier_color = "#bdc3c7"; 
if ($current_tier == "Gold") $tier_color = "#f1c40f";
if ($current_tier == "Platinum") $tier_color = "#3498db";
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
    <link rel="icon" type="img/x-icon" href="logo/logo2.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --brand-blue: #004a9b; --bg-light: #f4f7f6; --danger-red: #ff7675; --success-green: #27ae60; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg-light); margin: 0; display: flex; overflow-x: hidden; }
        
        /* SIDEBAR */
        .sidebar { width: 250px; background: var(--brand-blue); color: white; min-height: 100vh; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; }
        .sidebar h2 { font-size: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 10px; }
        .nav-links-container { flex-grow: 1; margin-top: 20px; }
        .nav-link { color: white; text-decoration: none; display: block; padding: 12px 0; opacity: 0.8; transition: 0.3s; }
        .nav-link:hover { opacity: 1; padding-left: 10px; }

        /* MOBILE NAV */
        .bottom-nav { display: none; position: fixed; bottom: 0; width: 100%; background: white; box-shadow: 0 -2px 10px rgba(0,0,0,0.1); justify-content: space-around; padding: 12px 0; z-index: 1000; }
        .bottom-nav-item { color: #888; font-size: 1.2rem; cursor: pointer; text-align: center; }
        .bottom-nav-item.active { color: var(--brand-blue); }

        /* BURGER MENU DRAWER */
        .mobile-drawer { position: fixed; top: 0; right: -320px; width: 280px; height: 100%; background: var(--brand-blue); color: white; z-index: 3000; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); padding: 30px 20px; visibility: hidden; pointer-events: none; }
        .mobile-drawer.active { right: 0; visibility: visible; pointer-events: auto; }
        .drawer-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 2999; }
        .drawer-link { display: flex; align-items: center; color: #000; text-decoration: none; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .drawer-link i { margin-right: 15px; width: 25px; text-align: center; }

        

        /* MAIN CONTENT */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card h3 { margin-top: 0; font-size: 0.9rem; color: #888; border-bottom: 1px solid #eee; padding-bottom: 10px; text-transform: uppercase; }
        
        #chartdiv { width: 100%; height: 400px; }
        .full-row { grid-column: 1 / -1; }
        .power-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .power-table td { padding: 10px 8px; font-size: 0.85rem; border-bottom: 1px solid #f9f9f9; }

        .tier-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-weight: bold; color: #fff; background: <?php echo $tier_color; ?>; }
        textarea { width: 100%; border-radius: 10px; border: 1px solid #ddd; padding: 10px; resize: none; box-sizing: border-box;}
        .send-btn { background: var(--brand-blue); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; width: 100%; margin-top:10px;}

        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); z-index: 2000; align-items: center; justify-content: center; }
        .modal-box { background: white; width: 280px; border-radius: 15px; text-align: center; overflow: hidden; }
        .modal-footer { display: flex; border-top: 1px solid #eee; }
        .modal-btn { flex: 1; padding: 12px; border: none; background: none; font-size: 1rem; cursor: pointer; }
        .confirm-btn { color: #6c5ce7; font-weight: bold; }
        
        @media (max-width: 768px) { 
            body { flex-direction: column; padding-bottom: 80px; } 
            .sidebar { display: none; } 
            .bottom-nav { display: flex; } 
            .main-content { padding: 20px; }
            .dashboard-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } 
            .full-width-mobile { grid-column: span 2; }
            #chartdiv { height: 300px; }
        }
        .mobile-brand-header { display: block; text-align: center; padding: 10px 0; }
            .mobile-brand-header img { width: 220px; }
            .mobile-tagline { font-weight: bold; font-style: italic; font-size: 14px; color: #000; margin-top: -5px; }

            /* Profile Section with Circular Image */
            .profile-card {
                background: #5d5fef;
                border-radius: 25px;
                padding: 45px 20px 20px 20px;
                color: white;
                position: relative;
                margin-top: 50px;
                box-shadow: 0 10px 25px rgba(93, 95, 239, 0.3);
            }
            .profile-img-circle {
                width: 100px; height: 100px;
                background: #dcdbd3;
                border-radius: 50%;
                position: absolute;
                top: -55px; left: 25px;
                border: 4px solid #fff;
            }
            .points-display { text-align: right; }
            .points-display h2 { margin: 0; font-size: 26px; }

            /* Stats Grid */
            .mobile-stats-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 25px; }
            .stat-box { border: 1px solid #eee; border-radius: 20px; padding: 20px; background: #fff; text-align: left; }
            .stat-box h4 { margin: 0; color: #333; font-size: 15px; font-weight: 600; }
            .stat-box .val { font-size: 32px; font-weight: bold; margin: 10px 0; color: #000; }

            /* Participation Card */
            .chart-card { border: 1px solid #eee; border-radius: 20px; padding: 20px; margin-top: 25px; }
            .chart-label { font-size: 15px; font-weight: 600; margin-bottom: 15px; }

            /* Bottom Nav */
            .bottom-nav { 
                display: flex; position: fixed; bottom: 0; width: 100%; 
                background: #fff; border-top: 1px solid #f0f0f0;
                justify-content: space-around; padding: 18px 0; z-index: 1000;
            }
            .bottom-nav i { font-size: 24px; color: #333; cursor: pointer; }
        
            /* Theme Variables */
:root {
    --brand-blue: #004a9b;
    --bg-main: #f4f7f6;
    --card-bg: #ffffff;
    --text-main: #333333;
    --border-color: #eeeeee;
}

body.dark-mode {
    --bg-main: #1a1a1a;
    --card-bg: #2d2d2d;
    --text-main: #e0e0e0;
    --border-color: #444444;
}

body { 
    background: var(--bg-main); 
    color: var(--text-main); 

}

.card, .stat-box, .mobile-drawer, .modal-box { 
    background: var(--card-bg) !important; 
    color: var(--text-main); 
    border-color: var(--border-color) !important;
}

/* Theme Toggle Button Style */
.theme-toggle {
    position: fixed;
    bottom: 85px;
    right: 20px;
    width: 50px;
    height: 50px;
    background: var(--card-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    cursor: pointer;
    z-index: 1001;
    border: 1px solid var(--border-color);
}

.theme-toggle img { width: 25px; height: 25px; }

        @media (min-width: 769px) { .mobile-brand-header, .profile-card, .mobile-stats-row, .bottom-nav { display: none; } }
        
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 2000; align-items: center; justify-content: center; }
    </style>
</head>
<body>

<div class="sidebar">
    <div>
        <h2>CLP Rewards</h2>
        <p><i class="fa fa-user-circle"></i> <?php echo $full_name; ?></p>
        <nav class="nav-links-container">
            <a href="#" class="nav-link"><i class="fa fa-home"></i> Dashboard</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-clock-rotate-left"></i> My History</a>
            <a href="#" class="nav-link"><i class="fa-sharp-duotone fa-solid fa-award"></i> My Benifits</a>
            <a href="#" class="nav-link"><i class="fa-sharp fa-solid fa-user-gear"></i> Settings</a>
        </nav>
    </div>
    <img src="icon/switch.png" alt="Logout" onclick="openLogoutModal()" style="width: 35px; height: 35px; margin-right: 10px; vertical-align: middle;">
    </div> 


    <div class="theme-toggle" onclick="toggleTheme()" id="themeBtn">
    <img src="icon/light.png" id="themeIcon" alt="Toggle Theme">
</div>

    <div class="main-content">
        <div class="top-nav">
            
        <h1>Dashboard, </h1>
    <div class="profile-card">
        <div class="profile-img-circle"></div>
        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
            <div>
                <div style="font-size: 15px; font-weight: bold;"><?php echo $full_name; ?></div>
                <div style="font-size: 15px; opacity: 0.9;"><?php echo $current_tier; ?></div>
            </div>
            <div class="points-display">
                <div style="font-size: 13px; opacity: 0.9;">Redeem Points</div>
                <h2><?php echo number_format($total_points); ?> pts</h2>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="card full-row full-width-mobile">
            <h3>Loyalty Participation Stream</h3>
            <div id="chartdiv"></div>
        </div>

        <div class="card" style="text-align: center;">
            <h3>Available Points</h3>
            <div style="font-size: 1.5rem; font-weight: bold; color: var(--brand-blue);"><?php echo number_format($total_points); ?></div>
        </div>

        <div class="card" style="text-align: center;">
            <h3>Redeemed</h3>
            <div style="font-size: 1.5rem; font-weight: bold; color: var(--success-green);"><?php echo number_format($redeemed_mtd); ?></div>
        </div>

        <div class="card" style="text-align: center; border-left: 4px solid var(--danger-red);">
            <h3>Point Expiry</h3>
            <div style="font-size: 1rem; font-weight: bold; color: var(--danger-red);"><?php echo $expiry_date; ?></div>
        </div>

        
        <div class="card full-width-mobile">
            <h3>Top Power Users</h3>
            <table class="power-table">
                <thead><tr><th>Member</th><th style="text-align:right;">Points</th></tr></thead>
                <tbody>
                    <?php while($row = $power_users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td style="text-align: right; font-weight: bold;"><?php echo number_format($row['total_points']); ?></td>
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
    <div class="bottom-nav-item"><i class="fa fa-bell"></i></div>
    <div class="bottom-nav-item" onclick="toggleMobileMenu()"><i class="fa fa-bars"></i></div>
</div>

<div class="drawer-overlay" id="drawerOverlay" onclick="toggleMobileMenu()"></div>
<div class="mobile-drawer" id="mobileDrawer">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h3 style="margin:0;">Menu</h3>
        <i class="fa fa-times" onclick="toggleMobileMenu()" style="cursor:pointer;"></i>
    </div>
    <a href="#" class="drawer-link"><i class="fa fa-user"></i> Profile</a>
    <a href="#" class="drawer-link"><i class="fa fa-cog"></i> Settings</a>
    <a href="#" class="drawer-link"><i class="fa-solid fa-clock-rotate-left"></i> History</a>
    <a href="#" class="drawer-link"><i class="fa-sharp-duotone fa-solid fa-award"></i>My Benifits</a>
    <a href="javascript:void(0)" class="drawer-link" onclick="toggleMobileMenu(); openLogoutModal();" style="color: #ff7675;">
        <i class="fa fa-sign-out-alt"></i> Logout
    </a>
</div>

<div id="logoutModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header" style="color:#ff4757; padding-top:20px; font-weight:bold;">Logout</div>
        <div class="modal-body" style="padding:10px 0 20px 0;">Are you sure you want to logout?</div>
        <div class="modal-footer">
            <button class="modal-btn" onclick="closeLogoutModal()" style="color:#a4b0be; border-right:1px solid #eee;">Cancel</button>
            <button class="modal-btn confirm-btn" onclick="location.href='logout.php'">Confirm</button>
        </div>
    </div>
</div>

<script>
    // 1. Mobile Menu Logic
    function toggleMobileMenu() {
        $('#mobileDrawer').toggleClass('active');
        $('#drawerOverlay').fadeToggle(300);
    }

    // 2. Modal UI logout logic
    function openLogoutModal() { 
        document.getElementById('logoutModal').style.display = 'flex'; 
    }
    
    function closeLogoutModal() { 
        document.getElementById('logoutModal').style.display = 'none'; 
    }

    function sendMessage() { 
        alert("Message sent to Admin."); 
    }

    // 3. Browser Back-Button Disable Logic (Updated with History Trap)
    (function (global) {
        if (typeof (global) === "undefined") {
            throw new Error("window is undefined");
        }

        var _hash = "!";
        var noBackPlease = function () {
            global.location.href += "#";
            global.setTimeout(function () {
                global.location.href += "!";
            }, 50);
        };

        // This is the core fix for multiple clicks
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };

        global.onhashchange = function () {
            if (global.location.hash !== _hash) {
                global.location.hash = _hash;
            }
        };

        global.onload = function () {
            noBackPlease();
            // Disables backspace navigation on modern browsers
            document.body.onkeydown = function (e) {
                var elm = e.target.nodeName.toLowerCase();
                if (e.which === 8 && (elm !== 'input' && elm !== 'textarea')) {
                    e.preventDefault();
                }
                e.stopPropagation();
            };
        };
    })(window);

    function toggleTheme() {
    const body = document.body;
    const themeIcon = document.getElementById('themeIcon');
    
    body.classList.toggle('dark-mode');
    
    // Check if dark mode is now active
    if (body.classList.contains('dark-mode')) {
        themeIcon.src = 'icon/dark.png'; // Switch to Dark icon
        localStorage.setItem('theme', 'dark');
        updateChartTheme(true);
    } else {
        themeIcon.src = 'icon/light.png'; // Switch to Light icon
        localStorage.setItem('theme', 'light');
        updateChartTheme(false);
    }
}

// Check for saved theme preference on page load
window.onload = function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        document.getElementById('themeIcon').src = 'icon/dark.png';
    }
};

am5.ready(function() {


var root = am5.Root.new("chartdiv");





var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: false,
  panY: false,
  wheelX: "panX",
  wheelY: "zoomX",
  paddingLeft:0,
  layout: root.verticalLayout
}));


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}))


// Data
var data = [{
  year: "2017",
  income: 23.5,
  expenses: 18.1
}, {
  year: "2018",
  income: 26.2,
  expenses: 22.8
}, {
  year: "2019",
  income: 30.1,
  expenses: 23.9
}, {
  year: "2020",
  income: 29.5,
  expenses: 25.1
}, {
  year: "2021",
  income: 24.6,
  expenses: 25
}];


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "year",
  renderer: am5xy.AxisRendererY.new(root, {
    inversed: true,
    cellStartLocation: 0.1,
    cellEndLocation: 0.9,
    minorGridEnabled: true
  })
}));

yAxis.data.setAll(data);

var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
  renderer: am5xy.AxisRendererX.new(root, {
    strokeOpacity: 0.1,
    minGridDistance: 50
  }),
  min: 0
}));


// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
function createSeries(field, name) {
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: name,
    xAxis: xAxis,
    yAxis: yAxis,
    valueXField: field,
    categoryYField: "year",
    sequencedInterpolation: true,
    tooltip: am5.Tooltip.new(root, {
      pointerOrientation: "horizontal",
      labelText: "[bold]{name}[/]\n{categoryY}: {valueX}"
    })
  }));

  series.columns.template.setAll({
    height: am5.p100,
    strokeOpacity: 0
  });


  series.bullets.push(function () {
    return am5.Bullet.new(root, {
      locationX: 1,
      locationY: 0.5,
      sprite: am5.Label.new(root, {
        centerY: am5.p50,
        text: "{valueX}",
        populateText: true
      })
    });
  });

  series.bullets.push(function () {
    return am5.Bullet.new(root, {
      locationX: 1,
      locationY: 0.5,
      sprite: am5.Label.new(root, {
        centerX: am5.p100,
        centerY: am5.p50,
        text: "{name}",
        fill: am5.color(0xffffff),
        populateText: true
      })
    });
  });

  series.data.setAll(data);
  series.appear();

  return series;
}

createSeries("income", "Income");
createSeries("expenses", "Expenses");


// Add legend
// https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}));

legend.data.setAll(chart.series.values);


// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
  behavior: "zoomY"
}));
cursor.lineY.set("forceHidden", true);
cursor.lineX.set("forceHidden", true);


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);

});
    // 5. Chart.js initialization 
    const ctx2 = document.getElementById('segmentChart').getContext('2d');
    new Chart(ctx2, { type: 'pie', data: { labels: ['B2B', 'B2C'], datasets: [{ data: [65, 35], backgroundColor: ['#004a9b', '#3498db'] }] }, options: { plugins: { legend: { position: 'bottom' } } } });
</script>

</body>
</html>