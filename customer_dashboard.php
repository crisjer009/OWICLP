<?php 
session_start(); 
// Redirect to login if session is empty
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Customer Dashboard | Loyalty Program</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <style>
        :root {
            --primary-blue: #004a9b;
            --secondary-blue: #003670;
            --bg-light: #f4f7fe;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            overflow-x: hidden;
        }
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-blue);
            height: 100vh;
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar .logo-section {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar .logo-section img {
            width: 70px;
            border-radius: 12px;
            background: white;
            padding: 5px;
        }

        .nav-links {
            padding: 20px 15px;
            list-style: none;
        }

        .nav-links li a {
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: 0.3s;
        }

        .nav-links li a:hover, .nav-links li a.active {
            background: rgba(255,255,255,0.15);
            color: #fff;
            transform: translateX(5px);
        }
        .nav-links i { margin-right: 12px; width: 20px; }
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            transition: all 0.3s;
        }

        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            display: flex;
            align-items: center;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: 0.3s;
        }

        .stat-card:hover { transform: translateY(-5px); }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 20px;
        }

        .icon-blue { background: #e7f0ff; color: #004a9b; }
        .icon-green { background: #e6fffa; color: #38b2ac; }
        .icon-orange { background: #fffaf0; color: #ed8936; }

        /* Mobile Adjustments */
        @media (max-width: 992px) {
            .sidebar { left: -280px; }
            .sidebar.active { left: 0; }
            .main-content { margin-left: 0; }
        }
        #chartdiv {
           width: 100%;
           height: 500px;
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="logo-section">
        <img src="images/owi.jpg" alt="Logo">
        <h6 class="text-white mt-3 fw-bold">CUSTOMER DASHBOARD</h6>
    </div>
    <ul class="nav-links">
        <li><a href="customer_dashboard" class="active"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
        <li><a href="customer_profile.php"><i class="fas fa-user-shield"></i>Customer Profile</a></li>
        <li><a href="customer_loyalty.php"><i class="fas fa-gift"></i> Loyalty & Rewards</a></li>
        <li><a href="customer_purchase.php"><i class="fas fa-exchange-alt"></i> Purchase & Points</a></li>
        <li><a href="customer_promotion.php"><i class="fas fa-exchange-alt"></i> Promotions Section</a></li>
        <hr class="text-white opacity-25">
        <li><a href="customer_settings.php"><i class="fas fa-file-invoice"></i> Settings</a></li>
        <li><a href="#" id="confirmLogout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="top-header">
        <div>
            <h4 class="fw-bold mb-0">Customer Overview</h4>
            <small class="text-muted">Welcome back,
                <span class="text-primary fw-bold">
                    <?php
                    echo isset($_SESSION['FirstName'])? htmlspecialchars(string: $_SESSION['FirstName']." ".$_SESSION['LastName']): "Guest";
                    ?>
                </span>
            </small>
        </div>

        <div class="d-flex align-items-center">
            <button class="btn btn-white shadow-sm border me-3"><i class="fas fa-bell"></i></button>
            <div class="fw-medium"><?php echo date(format: "M d,Y");?></div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon icon-blue"><i class="fas fa-users"></i></div>
                <div>
                    <h3 class="fw-bold mb-0">0</h3>
                    <small class="text-muted">Total Customers</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon icon-green"><i class="fas fa-star"></i></div>
                <div>
                    <h3 class="fw-bold mb-0">0</h3>
                    <small class="text-muted">Points Issued</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon icon-orange"><i class="fas fa-shopping-cart"></i></div>
                <div>
                    <h3 class="fw-bold mb-0">0</h3>
                    <small class="text-muted">Pending Redemptions</small>
                </div>
            </div>
        </div>
    </div>
    <!-- HTML -->
    <div id="chartdiv"></div>
    
</div>


<script>
    am5.ready(function() {

// Data
var data = [
  {
    ax: 1,
    ay: 0.5,
    bx: 1,
    by: 2.2
  },
  {
    ax: 2,
    ay: 1.3,
    bx: 2,
    by: 4.9
  },
  {
    ax: 3,
    ay: 2.3,
    bx: 3,
    by: 5.1
  },
  {
    ax: 4,
    ay: 2.8,
    bx: 4,
    by: 5.3
  },
  {
    ax: 5,
    ay: 3.5,
    bx: 5,
    by: 6.1
  },
  {
    ax: 6,
    ay: 5.1,
    bx: 6,
    by: 8.3
  },
  {
    ax: 7,
    ay: 6.7,
    bx: 7,
    by: 10.5
  },
  {
    ax: 8,
    ay: 8,
    bx: 8,
    by: 12.3
  },
  {
    ax: 9,
    ay: 8.9,
    bx: 9,
    by: 14.5
  },
  {
    ax: 10,
    ay: 9.7,
    bx: 10,
    by: 15
  },
  {
    ax: 11,
    ay: 10.4,
    bx: 11,
    by: 18.8
  },
  {
    ax: 12,
    ay: 11.7,
    bx: 12,
    by: 25
  }
];

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(
  am5xy.XYChart.new(root, {
    panX: false,
    panY: false,
    wheelY: "none"
  })
);

chart.get("colors").set("step", 2);

// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xAxis = chart.xAxes.push(
  am5xy.ValueAxis.new(root, {
    strictMinMax: true,
    maxDeviation: 0,
    renderer: am5xy.AxisRendererX.new(root, { minGridDistance: 50 }),
    tooltip: am5.Tooltip.new(root, {
      themeTags: ["axis"],
      animationDuration: 300
    })
  })
);

var yAxis = chart.yAxes.push(
  am5xy.ValueAxis.new(root, {
    strictMinMax: true,
    maxDeviation: 0,
    renderer: am5xy.AxisRendererY.new(root, {}),
    tooltip: am5.Tooltip.new(root, {
      themeTags: ["axis"],
      animationDuration: 300
    })
  })
);

// Create series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series0 = chart.series.push(
  am5xy.LineSeries.new(root, {
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: "ay",
    valueXField: "ax",
    baseAxis: xAxis,
    tooltip: am5.Tooltip.new(root, {
      labelText: "x:{valueX}, y:{valueY}"
    })
  })
);

series0.fills.template.setAll({
  fillOpacity: 0.5,
  visible: true
});

// Create series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series1 = chart.series.push(
  am5xy.LineSeries.new(root, {
    xAxis: xAxis,
    yAxis: yAxis,
    valueYField: "by",
    valueXField: "bx",
    baseAxis: yAxis,
    tooltip: am5.Tooltip.new(root, {
      labelText: "x:{valueX}, y:{valueY}"
    })
  })
);

series1.fills.template.setAll({
  fillOpacity: 0.5,
  visible: true
});

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
chart.set("cursor", am5xy.XYCursor.new(root, {
  xAxis: xAxis,
  yAxis: yAxis,
  snapToSeries: [series0, series1]
}));

// Add scrollbars
// https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
chart.set("scrollbarX", am5.Scrollbar.new(root, {
  orientation: "horizontal"
}));

chart.set("scrollbarY", am5.Scrollbar.new(root, {
  orientation: "vertical"
}));

series0.data.setAll(data);
series1.data.setAll(data);

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
series0.appear(1000);
series1.appear(1000);
chart.appear(1000, 100);

}); // end am5.ready()
    
    // Logout logic
    $('#confirmLogout').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Sign Out?',
            text: "You will need to login again to access the dashboard.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#004a9b',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Logout',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php';
            }
        });
    });
</script>
</body>
</html>