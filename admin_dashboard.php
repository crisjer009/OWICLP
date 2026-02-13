<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$userName = isset($_SESSION['FirstName']) ? htmlspecialchars($_SESSION['FirstName'] . " " . $_SESSION['LastName']) : "John Doe";
$userInitial = substr($userName, 0, 1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>OWI CLP | Customer Dashboard</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #004a9b;
            --primary-light: #F4F0FF;
            --bg-body: #F4F5FA;
            --sidebar-width: 260px;
            --topbar-height: 70px;
            --card-shadow: 0 4px 12px 0 rgba(58, 53, 65, 0.1);
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background-color: var(--bg-body);
            color: #3A3541DE;
            overflow-x: hidden;
             background: linear-gradient(rgba(229, 238, 253, 0.54), rgba(147, 175, 221, 0.65)), 
                    url('images/bg_login.png'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        /* --- Sidebar Styling --- */
        .sidebar {
            width: var(--sidebar-width);
            background: #fff;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            display:flex;
            flex-direction: column;
            transition: all 0.3s ease;
            z-index: 1050;
            border-right: 1px dashed #dadae3;
            box-shadow: 0 20px 40px rgba(94, 120, 206, 0.62);
            background: linear-gradient(rgba(236, 238, 240, 0.99),rgba(202, 221, 248, 0.86)),
            url('images/bg_login.png'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .sidebar-header{
          padding:15px 20px;
          display: flex;
          align-items: center;
          border-bottom: 1px solid rgba(58,53,65,0.05);
          margin-bottom: 10px;
          flex-shrink:0;
        }

        .brand-logo{
          width: 35px;
          height: 35px;
          object-fit: contain;
          border-radius: 6px;
        }

        .brand-text{
          font-weight:700;
          font-size:1.25rem;
          color: var(--primary-color);
          letter-spacing:0.5px;
          margin-left:12px;
          text-transform: uppercase;
        }
        .nav-menu{
            list-style:none;
            padding:10px 15px 30px 15px;
            margin:0;
            overflow-y: auto;
            flex-grow:1;
        }
        .nav-menu::-webkit-scrollbar{
            width:5px;
        }
        .nav-menu::-webkit-scrollbar-track{
            background:transparent;
        }
        .nav-menu::-webkit-scrollbar-thumb{
            background: rgba(0,74,155,0.2);
            border-radius:10px;
        }
        .nav-menu::-webkit-scrollbar-thumb:hover{
            background: var(--primary-color);
        }
        .menu-divider{
            display:block;
            text-transform:uppercase;
            font-size:11px;
            font-weight:700;
            color:#3a35418a;
            letter-spacing:1px;
            padding: 20px 0 10px 10px;
        }
       
        .nav-item-custom {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            margin-bottom: 4px;
            border-radius: 0 50px 50px 0;
            color: #3a3541ed;
            text-decoration: none;
            transition: 0.2s;
            font-weight: 500;
        }

        .nav-item-custom i { width: 22px; margin-right: 12px; font-size: 1.1rem; }

        .nav-item-custom.active, .nav-item-custom:hover {
            background: linear-gradient(72.47deg, var(--primary-color) 22.16%, #004a9b 76.47%);
            color: white !important;
            box-shadow: 0px 4px 8px -4px #004a9b;
        }

        /* --- Main Content Area --- */
        .main-container {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        /* --- Top Navbar --- */
        .top-navbar {
            height: var(--topbar-height);
            background: rgba(244, 245, 250, 0.85);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .search-input-group {
            position: relative;
            max-width: 400px;
            width: 100%;
        }

        .search-input-group input {
            border: none;
            background: transparent;
            padding-left: 35px;
            font-size: 0.9rem;
        }

        .search-input-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #3A3541AD;
        }
        /* --- User Profile Dropdown --- */
        .avatar-circle {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
            cursor: pointer;
        }

        .dropdown-menu-custom {
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 12px;
            min-width: 230px;
            padding: 10px;
        }
        /* --- Responsive Behavior --- */
        @media (max-width: 992px) {
            .sidebar { left: -100%; }
            .sidebar.show { left: 0; }
            .main-container { margin-left: 0; }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }
            .sidebar-overlay.active { display: block; }
        }
        /* --- Dashboard Cards --- */
        .m-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 24px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>
       <nav class="sidebar" id="sidebar">
           <div class="sidebar-header">
             <img src="images/owi.jpg" alt="Logo" class="brand-logo">
             <span class="brand-text">OWI CLP</span>
            </div>
           <ul class="nav-menu">
               <small class="menu-divider">
                 <span>Analytics</span>
               </small>
               <li><a href="admin_dashboard.php" class="nav-item-custom active"><i class="fas fa-chart-line"></i> Dashboard</a></li>
               <li><a href="admin_reports.php" class="nav-item-custom"><i class="fas fa-file-export"></i> Detailed Reports</a></li>
    
               <small class="menu-divider">
                 <span>User Control</span>
               </small>
               <li><a href="admin_customers.php" class="nav-item-custom"><i class="fas fa-users"></i> Member Directory</a></li>
               <li><a href="admin_tiers.php" class="nav-item-custom"><i class="fas fa-layer-group"></i> Tier Management</a></li>

               <small class="menu-divider">
                 <span>Inventory & Rewards</span>
               </small>
               <li><a href="admin_redemptions.php" class="nav-item-custom"><i class="fas fa-ticket-alt"></i> Pending Claims 
               <span class="badge bg-danger ms-auto rounded-pill" style="font-size: 0.7rem;">5</span>
               </a></li>
               <li><a href="admin_catalog.php" class="nav-item-custom"><i class="fas fa-gift"></i> Reward Catalog</a></li>
               <li><a href="admin_promotions.php" class="nav-item-custom"><i class="fas fa-bullhorn"></i> Campaign Manager</a></li>
    
               <small class="menu-divider">
                  <span>System Rules</span>
               </small>
               <li><a href="admin_points_config.php" class="nav-item-custom"><i class="fas fa-coins"></i> Earning Rules</a></li>
               <li><a href="admin_settings.php" class="nav-item-custom"><i class="fas fa-user-shield"></i> Admin Settings</a></li>
               <li><a href="#" id="sidebarLogout" class="nav-item-custom text-danger mt-4"><i class="fas fa-power-off"></i> Log Out</a></li>
           </ul>
       </nav>

    <div class="main-container">  
        <header class="top-navbar">
            <div class="container-fluid d-flex align-items-center justify-content-between p-0">  
                <div class="d-flex align-items-center flex-grow-1">
                    <button class="btn border-0 d-lg-none me-2" onclick="toggleSidebar()">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <div class="search-input-group d-none d-md-block">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control shadow-none" placeholder="Search (Ctrl+/)">
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown ms-3">
                        <div class="d-flex align-items-center" data-bs-toggle="dropdown" style="cursor: pointer;">
                            <div class="avatar-circle me-2"><?php echo $userInitial; ?></div>
                            <div class="d-none d-sm-block">
                                <span class="d-block fw-bold mb-0" style="font-size: 0.9rem; line-height: 1.2;"><?php echo $userName; ?></span>
                                <small class="text-muted" style="font-size: 0.75rem;">Admin Account</small>
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom mt-3">
                            <li class="px-3 py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2" style="width: 35px; height: 35px;"><?php echo $userInitial; ?></div>
                                    <div>
                                        <div class="fw-bold" style="font-size: 0.85rem;"><?php echo $userName; ?></div>
                                        <small class="text-muted">Premium Member</small>
                                    </div>
                                </div>
                            </li>
                            <li><a class="dropdown-item py-2 mt-2 rounded" href="customer_profile.php"><i class="far fa-user me-2"></i> My Profile</a></li>
                            <li><a class="dropdown-item py-2 rounded" href="customer_settings.php"><i class="fas fa-cog me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 rounded text-danger" href="#" id="navbarLogout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <main class="p-4">
            <div class="row g-4">
                <div class="col-xl-8 col-lg-7">
                    <div class="m-card">
                        <h6 class="fw-bold">Points Economy (Accural vs. Redemption)</h6>
                        <div id="chartPointsTrend" style="width:100%; height:350px;"></div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="m-card">
                        <h6 class="fw-bold">Member Tier Distribution</h6>
                        <div id="chartTierDist" style="width:100%; height:350px;"></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="m-card">
                        <h6 class="fw-bold">Top 5 Rewards Claimed</h6>
                        <div id="chartTopRewards" style="width:100%; height:350px;"></div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="m-card">
                        <h6 class="fw-bold">Points Expiry Forecast (Next 6 Months)</h6>
                        <div id="chartExpiry" style="width:100%; height:350px;"></div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="m-card">
                        <h6 class="fw-bold">Acquisition Growth</h6>
                        <div id="chartSignups" style="width:100%; height:300px;"></div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="m-card text-center">
                        <h6 class="fw-bold text-start">Program Redemption Rate</h6>
                        <div id="chartRedemptionGauge" style="width:100%; height:250px;"></div>
                        <p class="small text-muted">Target: 65% utilization</p>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="m-card">
                        <h6 class="fw-bold">Earning Channels</h6>
                        <div id="chartChannels" style="width:100%; height:300px;"></div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="m-card">
                        <h6 class="fw-bold">Store-wise Engagement (Points Issued)</h6>
                        <div id="chartStorePerformance" style="width:100%; height 400px;"></div>
                    </div>
                </div>
            </div>
       </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>
        // Sidebar Toggle for Mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('overlay').classList.toggle('active');
        }
        // Unified Logout Logic
        function handleLogout(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Sign Out?',
                text: "You will be returned to the login screen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#004a9b',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = 'index.php';
            });
        }
        document.getElementById('sidebarLogout').onclick = handleLogout;
        document.getElementById('navbarLogout').onclick = handleLogout;
    </script>
    <script>
        am5.ready(function() {
            // Helper function to create root and chart
            function createChart(divId) {
              var root = am5.Root.new(divId);
              root.setThemes([am5themes_Animated.new(root)]);
              return root;
            }
            // POINTS TREND (XY Line & Column)
            var root1 = createChart("chartPointsTrend");
            var chart1 = root1.container.children.push(am5xy.XYChart.new(root1, { layout: root1.verticalLayout }));
            var xAxis1 = chart1.xAxes.push(am5xy.CategoryAxis.new(root1, { categoryField: "month", renderer: am5xy.AxisRendererX.new(root1, {}) }));
            var yAxis1 = chart1.yAxes.push(am5xy.ValueAxis.new(root1, { renderer: am5xy.AxisRendererY.new(root1, {}) }));
            var s1 = chart1.series.push(am5xy.ColumnSeries.new(root1, { name: "Earned", xAxis: xAxis1, yAxis: yAxis1, valueYField: "e", categoryXField: "month" }));
            var s2 = chart1.series.push(am5xy.LineSeries.new(root1, { name: "Redeemed", xAxis: xAxis1, yAxis: yAxis1, valueYField: "r", categoryXField: "month" }));
            s1.data.setAll([{month:"Sep",e:15000,r:8000},{month:"Oct",e:18000,r:9500},{month:"Nov",e:25000,r:12000},{month:"Dec",e:35000,r:28000}]);
            s2.data.setAll([{month:"Sep",e:15000,r:8000},{month:"Oct",e:18000,r:9500},{month:"Nov",e:25000,r:12000},{month:"Dec",e:35000,r:28000}]);
            xAxis1.data.setAll(s1.data.values);
            // TIER DISTRIBUTION (Pie)
            var root2 = createChart("chartTierDist");
            var chart2 = root2.container.children.push(am5percent.PieChart.new(root2, {}));
            var series2 = chart2.series.push(am5percent.PieSeries.new(root2, { valueField: "val", categoryField: "tier" }));
            series2.data.setAll([{tier:"Bronze",val:5000},{tier:"Silver",val:2500},{tier:"Gold",val:800},{tier:"Platinum",val:200}]);
            // TOP REWARDS (Horizontal Bar)
            var root3 = createChart("chartTopRewards");
            var chart3 = root3.container.children.push(am5xy.XYChart.new(root3, { layout: root3.verticalLayout }));
            var yAxis3 = chart3.yAxes.push(am5xy.CategoryAxis.new(root3, { categoryField: "item", renderer: am5xy.AxisRendererY.new(root3, { inversed: true }) }));
            var xAxis3 = chart3.xAxes.push(am5xy.ValueAxis.new(root3, { renderer: am5xy.AxisRendererX.new(root3, {}) }));
            var series3 = chart3.series.push(am5xy.ColumnSeries.new(root3, { xAxis: xAxis3, yAxis: yAxis3, valueXField: "qty", categoryYField: "item" }));
            series3.data.setAll([{item:"Gift Card",qty:450},{item:"Office Chair",qty:320},{item:"Paper Pack",qty:280},{item:"Ink Refill",qty:210}]);
            yAxis3.data.setAll(series3.data.values);
            // EXPIRY FORECAST (Area Chart)
            var root4 = createChart("chartExpiry");
            var chart4 = root4.container.children.push(am5xy.XYChart.new(root4, {}));
            var xAxis4 = chart4.xAxes.push(am5xy.CategoryAxis.new(root4, { categoryField: "date", renderer: am5xy.AxisRendererX.new(root4, {}) }));
            var yAxis4 = chart4.yAxes.push(am5xy.ValueAxis.new(root4, { renderer: am5xy.AxisRendererY.new(root4, {}) }));
            var series4 = chart4.series.push(am5xy.LineSeries.new(root4, { xAxis: xAxis4, yAxis: yAxis4, valueYField: "pts", categoryXField: "date" }));
            series4.fills.template.setAll({ visible: true, fillOpacity: 0.5 });
            series4.data.setAll([{date:"Mar",pts:5000},{date:"Apr",pts:12000},{date:"May",pts:7000},{date:"Jun",pts:15000}]);
            xAxis4.data.setAll(series4.data.values);
            // SIGNUPS (Step Line)
            var root5 = createChart("chartSignups");
            var chart5 = root5.container.children.push(am5xy.XYChart.new(root5, {}));
            var xAxis5 = chart5.xAxes.push(am5xy.CategoryAxis.new(root5, { categoryField: "week", renderer: am5xy.AxisRendererX.new(root5, {}) }));
            var yAxis5 = chart5.yAxes.push(am5xy.ValueAxis.new(root5, { renderer: am5xy.AxisRendererY.new(root5, {}) }));
            var series5 = chart5.series.push(am5xy.LineSeries.push(am5xy.LineSeries.new(root5, { xAxis: xAxis5, yAxis: yAxis5, valueYField: "v", categoryXField: "week" })));
            series5.data.setAll([{week:"W1",v:100},{week:"W2",v:150},{week:"W3",v:130},{week:"W4",v:210}]);
            xAxis5.data.setAll(series5.data.values);
            // REDEMPTION GAUGE (Radar)
            var root6 = createChart("chartRedemptionGauge");
            var chart6 = root6.container.children.push(am5radar.RadarChart.new(root6, { innerRadius: -15, startAngle: 180, endAngle: 360 }));
            var xAxis6 = chart6.xAxes.push(am5xy.ValueAxis.new(root6, { min: 0, max: 100, renderer: am5radar.AxisRendererCircular.new(root6, {}) }));
            var axisDataItem = xAxis6.makeDataItem({ value: 58 });
            xAxis6.createAxisRange(axisDataItem);
            axisDataItem.get("axisFill").setAll({ visible: true, fill: am5.color(0x004a9b) });
            // CHANNELS (Donut)
            var root7 = createChart("chartChannels");
            var chart7 = root7.container.children.push(am5percent.PieChart.new(root7, { innerRadius: am5.percent(60) }));
            var series7 = chart7.series.push(am5percent.PieSeries.new(root7, { valueField: "v", categoryField: "c" }));
            series7.data.setAll([{c:"In-Store",v:70},{c:"Web",v:20},{c:"Mobile App",v:10}]);
            // STORE PERFORMANCE (Column)
            var root8 = createChart("chartStorePerformance");
            var chart8 = root8.container.children.push(am5xy.XYChart.new(root8, {}));
            var xAxis8 = chart8.xAxes.push(am5xy.CategoryAxis.new(root8, { categoryField: "store", renderer: am5xy.AxisRendererX.new(root8, {}) }));
            var yAxis8 = chart8.yAxes.push(am5xy.ValueAxis.new(root8, { renderer: am5xy.AxisRendererY.new(root8, {}) }));
            var series8 = chart8.series.push(am5xy.ColumnSeries.new(root8, { xAxis: xAxis8, yAxis: yAxis8, valueYField: "p", categoryXField: "store" }));
            series8.data.setAll([{store:"Makati",p:45000},{store:"Quezon City",p:38000},{store:"Cebu",p:31000},{store:"Davao",p:28000},{store:"Online Store",p:52000}]);
            xAxis8.data.setAll(series8.data.values);
        });
    </script>
</body>
</html>