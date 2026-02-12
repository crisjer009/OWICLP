<?php 
session_start(); 
// Redirect to login if session is empty
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// User details for display
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
            transition: all 0.3s ease;
            z-index: 1050;
            border-right: 1px dashed #dadae3;
            box-shadow: 0 20px 40px rgba(94, 120, 206, 0.62);
            background: linear-gradient(
        rgba(236, 238, 240, 0.99), 
        rgba(202, 221, 248, 0.86)
    ),
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
          list-style: none;
          padding: 10px 15px;
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
            <small class="text-uppercase text-muted fw-bold ps-3 mb-2 d-block" style="font-size: 11px; letter-spacing: 1px;">Home</small>
            <li><a href="#" class="nav-item-custom active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="customer_profile.php" class="nav-item-custom"><i class="fas fa-user-circle"></i> Customer Profile</a></li>
            <small class="text-uppercase text-muted fw-bold ps-3 mt-4 mb-2 d-block" style="font-size: 11px; letter-spacing: 1px;">Apps & Pages</small>
            <li><a href="customer_loyalty.php" class="nav-item-custom"><i class="fas fa-gift"></i> Loyalty & Rewards</a></li>
            <li><a href="customer_purchase.php" class="nav-item-custom"><i class="fas fa-history"></i> Purchase & Points </a></li>
            <li><a href="customer_purchase.php" class="nav-item-custom"><i class="fas fa-history"></i> Promotions </a></li>
            <small class="text-uppercase text-muted fw-bold ps-3 mt-4 mb-2 d-block" style="font-size: 11px; letter-spacing: 1px;">Settings</small>
            <li><a href="customer_settings.php" class="nav-item-custom"><i class="fas fa-cog"></i> Account Settings</a></li>
            <li><a href="#" id="sidebarLogout" class="nav-item-custom text-danger"><i class="fas fa-power-off"></i> Logout</a></li>
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
                    <button class="btn btn-link text-dark nav-link px-2"><i class="far fa-moon fs-5"></i></button>
                    <button class="btn btn-link text-dark nav-link px-2 position-relative">
                        <i class="far fa-bell fs-5"></i>
                        <span class="position-absolute top-25 start-75 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>

                    <div class="dropdown ms-3">
                        <div class="d-flex align-items-center" data-bs-toggle="dropdown" style="cursor: pointer;">
                            <div class="avatar-circle me-2"><?php echo $userInitial; ?></div>
                            <div class="d-none d-sm-block">
                                <span class="d-block fw-bold mb-0" style="font-size: 0.9rem; line-height: 1.2;"><?php echo $userName; ?></span>
                                <small class="text-muted" style="font-size: 0.75rem;">Client Account</small>
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
                <div class="col-xl-4 col-md-12" style="margin-bottom:20px;">
                    <div class="m-card h-100" style="position: relative; overflow: hidden;">
                        <h5 class="fw-bold">Congratulations <?php echo explode(' ', $userName)[0]; ?>! 🎉</h5>
                        <p class="text-muted small">You have 12 new rewards waiting.</p>
                        <h2 class="text-primary fw-bold mt-4">$42.8k</h2>
                        <button class="btn btn-primary btn-sm rounded-pill px-4">View Rewards</button>
                        <img src="https://demos.themeselection.com/materio-bootstrap-html-admin-template-free/assets/img/illustrations/trophy.png" 
                             style="position: absolute; right: 20px; bottom: 10px; width: 75px;" alt="Trophy">
                    </div>
                </div>

                <div class="col-xl-8 col-md-12" style="margin-bottom:20px;">
                    <div class="m-card h-100">
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-bold m-0">Account Statistics</h5>
                            <i class="fas fa-ellipsis-v text-muted cursor-pointer"></i>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded me-3 text-primary"><i class="fas fa-wallet fa-lg"></i></div>
                                    <div><h6 class="mb-0 fw-bold">1.2k</h6><small class="text-muted">Points</small></div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 p-2 rounded me-3 text-success"><i class="fas fa-shopping-bag fa-lg"></i></div>
                                    <div><h6 class="mb-0 fw-bold">45</h6><small class="text-muted">Orders</small></div>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="row g-4">
              <div class="col-xl-8 col-lg-7">
                <div class="m-card">
                  <h6 class="fw-bold">Activity Overview</h6>
                  <div id="accrualChart" style="width: 100%; height: 300px;"></div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-5">
                <div class="m-card">
                  <h6 class="fw-bold">Earnings Sources</h6>
                  <div id="categoryChart" style="width: 100%; height:300px;"></div>
                </div>
              </div>
              <div class="col-xl-6">
                <div class="m-card">
                  <h6 class="fw-bold">Balance Growth</h6>
                  <div id="growthChart" style="width: 100%; height:300px;"></div>
                </div>
              </div>

              <div class="col-xl-6">
                <div class="m-card text-center">
                  <h6 class="fw-bold text-start">Next Reward Progress</h6>
                  <div id="gaugeChart" style="width: 100%; height: 250px;"></div>
                  <p class="mt-2 small text-muted">Only 500 more points to reach <strong>Gold Status</strong>!</p>
                </div>
              </div>

              <div class="row g-4 mt-2">
                <div class="col-xl-6 col-md-12">
                  <div class="m-card">
                    <h6 class="fw-bold mb-0">Spending Profile</h6>
                    <small class="text-muted d-block mb-4">Your shopping persona based on points</small>
                    <div id="radarHabitChart" style="width: 100%; height: 350px;"></div>
                  </div>
                </div>

              <div class="col-xl-6 col-md-12">
                <div class="m-card">
                  <h6 cass="fw-bold mb-0">Engagement Frequency</h6>
                  <small class="text-muted d-block mb-4">Points earned by day of the week</small>
                  <div id="bubbleActivityChart" style="width: 100%; height: 350px;"></div>
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
        var rootItems = ["accrualChart", "categoryChart", "growthChart", "gaugeChart"];
    
         // ACCRUAL VS REDEMPTION (XY Chart) 
        var root1 = am5.Root.new("accrualChart");
        root1.setThemes([am5themes_Animated.new(root1)]);
        var chart1 = root1.container.children.push(am5xy.XYChart.new(root1, { layout: root1.verticalLayout }));
    
        var xAxis1 = chart1.xAxes.push(am5xy.CategoryAxis.new(root1, {
          categoryField: "month",
          renderer: am5xy.AxisRendererX.new(root1, {})
        }));
        var yAxis1 = chart1.yAxes.push(am5xy.ValueAxis.new(root1, {
          renderer: am5xy.AxisRendererY.new(root1, {})
        }));

        var seriesEarned = chart1.series.push(am5xy.ColumnSeries.new(root1, {
          name: "Earned", xAxis: xAxis1, yAxis: yAxis1, valueYField: "e", categoryXField: "month"
        }));
        seriesEarned.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, fill: am5.color(0x9155FD) });

        var seriesSpent = chart1.series.push(am5xy.LineSeries.new(root1, {
          name: "Spent", xAxis: xAxis1, yAxis: yAxis1, valueYField: "s", categoryXField: "month"
        }));
        seriesSpent.strokes.template.setAll({ strokeWidth: 3, stroke: am5.color(0x56CA00) });

        var data1 = [{month:"Jan",e:2000,s:1200},{month:"Feb",e:2500,s:1800},{month:"Mar",e:2200,s:2500},{month:"Apr",e:3500,s:2000}];
        xAxis1.data.setAll(data1);
        seriesEarned.data.setAll(data1);
        seriesSpent.data.setAll(data1);

        //CATEGORY DONUT (Percent Chart) 
        var root2 = am5.Root.new("categoryChart");
        root2.setThemes([am5themes_Animated.new(root2)]);
        var chart2 = root2.container.children.push(am5percent.PieChart.new(root2, { innerRadius: am5.percent(70) }));
        var series2 = chart2.series.push(am5percent.PieSeries.new(root2, { valueField: "val", categoryField: "cat" }));
        series2.data.setAll([{cat:"Gas",val:40},{cat:"Dining",val:30},{cat:"Partner",val:20},{cat:"Other",val:10}]);
        series2.labels.template.set("forceHidden", true);
        series2.ticks.template.set("forceHidden", true);

       //GROWTH AREA CHART
        var root3 = am5.Root.new("growthChart");
        var chart3 = root3.container.children.push(am5xy.XYChart.new(root3, {}));
        var xAxis3 = chart3.xAxes.push(am5xy.CategoryAxis.new(root3, { categoryField: "day", renderer: am5xy.AxisRendererX.new(root3, {}) }));
        var yAxis3 = chart3.yAxes.push(am5xy.ValueAxis.new(root3, { renderer: am5xy.AxisRendererY.new(root3, {}) }));
        var series3 = chart3.series.push(am5xy.LineSeries.new(root3, { 
          xAxis: xAxis3, yAxis: yAxis3, valueYField: "v", categoryXField: "day", fill: am5.color(0x9155FD), stroke: am5.color(0x9155FD) 
        }));
        series3.fills.template.setAll({ fillOpacity: 0.3, visible: true });
        var data3 = [{day:"Mon",v:1000},{day:"Tue",v:1200},{day:"Wed",v:1100},{day:"Thu",v:1800},{day:"Fri",v:2200}];
        xAxis3.data.setAll(data3);
        series3.data.setAll(data3);

        //PROGRESS GAUGE 
        var root4 = am5.Root.new("gaugeChart");
        var chart4 = root4.container.children.push(am5radar.RadarChart.new(root4, { innerRadius: -20, startAngle: 180, endAngle: 360 }));
        var axisRenderer = am5radar.AxisRendererCircular.new(root4, { innerRadius: -10 });
        var xAxis4 = chart4.xAxes.push(am5xy.ValueAxis.new(root4, { min: 0, max: 100, renderer: axisRenderer }));
        var axisDataItem = xAxis4.makeDataItem({ value: 0, endValue: 75 });
        xAxis4.createAxisRange(axisDataItem);
        axisDataItem.get("axisFill").setAll({ visible: true, fill: am5.color(0x9155FD) });
      });
      //SPENDING PROFILE RADAR CHART
      var root5 = am5.Root.new("radarHabitChart");
      root5.setThemes([am5themes_Animated.new(root5)]);
      var chart5 = root5.container.children.push(am5radar.RadarChart.new(root5, {
      panX: false, panY: false, wheelX: "panX", wheelY: "zoomX"
      }));

      var cursor5 = chart5.set("cursor", am5radar.RadarCursor.new(root5, {}));
      cursor5.lineY.set("visible", false);

      var xRenderer5 = am5radar.AxisRendererCircular.new(root5, {});
      xRenderer5.labels.template.setAll({ radius: 10 });

      var xAxis5 = chart5.xAxes.push(am5xy.CategoryAxis.new(root5, {
        maxDeviation: 0,
        categoryField: "attribute",
        renderer: xRenderer5,
        tooltip: am5.Tooltip.new(root5, {})
      }));

      var yAxis5 = chart5.yAxes.push(am5xy.ValueAxis.new(root5, {
        renderer: am5radar.AxisRendererRadial.new(root5, {})
      }));

      var series5 = chart5.series.push(am5radar.RadarLineSeries.new(root5, {
        name: "User Profile",
        xAxis: xAxis5,
        yAxis: yAxis5,
        valueYField: "value",
        categoryXField: "attribute",
        tooltip: am5.Tooltip.new(root5, { labelText: "{valueY}" })
      }));

      series5.strokes.template.setAll({ strokeWidth: 2, stroke: am5.color(0x9155FD) });
      series5.fills.template.setAll({ fillOpacity: 0.5, visible: true, fill: am5.color(0x9155FD) });

      var data5 = [
        { attribute: "Consistency", value: 80 },
        { attribute: "Online", value: 95 },
        { attribute: "In-Store", value: 40 },
        { attribute: "Referrals", value: 60 },
        { attribute: "Redemption", value: 85 }
      ];

      xAxis5.data.setAll(data5);
      series5.data.setAll(data5);

      //ACTIVITY BUBBLE/HEATMAP CHART 
      var root6 = am5.Root.new("bubbleActivityChart");
      root6.setThemes([am5themes_Animated.new(root6)]);

      var chart6 = root6.container.children.push(am5xy.XYChart.new(root6, {
        panX: false, panY: false, layout: root6.verticalLayout
      }));

      var xAxis6 = chart6.xAxes.push(am5xy.CategoryAxis.new(root6, {
        categoryField: "day",
        renderer: am5xy.AxisRendererX.new(root6, { minGridDistance: 30 })
      }));

      var yAxis6 = chart6.yAxes.push(am5xy.ValueAxis.new(root6, {
        renderer: am5xy.AxisRendererY.new(root6, {})
      }));

      var series6 = chart6.series.push(am5xy.LineSeries.new(root6, {
        xAxis: xAxis6,
        yAxis: yAxis6,
        valueYField: "value",
        categoryXField: "day"
      }));

      // Create "bubbles" using bullets
      series6.bullets.push(function() {
      var circle = am5.Circle.new(root6, {
        radius: 10,
        templateField: "bulletSettings",
        fill: am5.color(0x16B1FF), // Cyan/Blue
        stroke: am5.color(0xffffff),
        strokeWidth: 2,
        tooltipText: "{valueY} pts earned"
      });
       return am5.Bullet.new(root6, { sprite: circle });
      });

      series6.strokes.template.set("strokeOpacity", 0); 

      var data6 = [
        { day: "Mon", value: 450 },
        { day: "Tue", value: 200 },
        { day: "Wed", value: 800, bulletSettings: { fill: am5.color(0x9155FD), radius: 20 } }, // Peak Day
        { day: "Thu", value: 300 },
        { day: "Fri", value: 900, bulletSettings: { fill: am5.color(0x9155FD), radius: 25 } }, // Peak Day
        { day: "Sat", value: 150 },
        { day: "Sun", value: 100 }
      ];
      xAxis6.data.setAll(data6);
      series6.data.setAll(data6);
    </script>
  </body>
</html>