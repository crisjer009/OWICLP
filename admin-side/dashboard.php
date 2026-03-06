<?php
session_start(); // start the session

// Set $user to the logged-in username if available, otherwise fallback to "Guest"
$user = isset($_SESSION['username']) && !empty($_SESSION['username']) 
        ? $_SESSION['username'] 
        : "Guest";
?> 

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- amCharts -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

                                 <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <style>

 /* ============================= GLOBAl======================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #f0f2f5;
            color: #333;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ==============================  SIDEBAR================================ */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px 20px;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
        }

        .sidebar h2 {
            padding-left: 15px;
            margin-bottom: 40px;
            font-size: 1.4rem;
            text-transform: uppercase;
            color: #38bdf8;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            margin: 4px 0;
            border-radius: 12px;
            text-decoration: none;
            color: #94a3b8;
            transition: 0.3s ease;
            font-weight: 500;
        }

        .sidebar a i {
            width: 24px;
            font-size: 1.1rem;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: rgba(56, 189, 248, 0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar a:hover i {
            color: #38bdf8;
            transform: scale(1.1);
        }

        .sidebar a.active {
            background: #38bdf8;
            color: #0f172a;
            box-shadow: 0 4px 15px rgba(56, 189, 248, 0.4);
        }

        .logout {
            margin-top: auto;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444 !important;
            border: 1px solid rgba(239, 68, 68, 0.2);
            justify-content: center;
        }

        .logout:hover {
            background: #ef4444 !important;
            color: #fff !important;
        }

      /* ============================= MAIN CONTENT ============================================= */
.main {
    flex: 1;
    padding: 30px; 
    background: #1e1924;
    margin-left: 280px;
    min-height: 100vh;
}

#dashboardContent {
    max-width: 1400px;
    margin: 0 auto;
}

/* ===================================  TOP BAR ===================================== */
.top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.top h2 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #fff;
    margin: 0;
}

.top small {
    color: rgba(255, 255, 255, 0.7);
}

.top .search input {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 10px 20px;
    border-radius: 50px;
    color: white;
    width: 300px;
    transition: 0.3s;
}

.top .search input:focus {
    width: 350px;
    border-color: #fff;
    outline: none;

}

 

    
      /* ============================= DASHBOARD ============================================= */

/* ==========================================================
   MODERN DASHBOARD STYLING
   ========================================================== */

#dashboardContent {
    padding: 30px;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: #fff;
}

/* --- Top Header Area --- */
.top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    background: rgba(255, 255, 255, 0.05);
    padding: 20px;
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px border rgba(255, 255, 255, 0.1);
}

.top h2 {
    font-size: 24px;
    font-weight: 600;
    letter-spacing: -0.5px;
}

/* --- Modern Search Bar --- */
.search {
    position: relative;
    width: 300px;
}

.search input {
    width: 100%;
    padding: 10px 15px;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    color: white;
    font-size: 14px;
    transition: all 0.3s ease;
}

.search input:focus {
    outline: none;
    border-color: #38bdf8;
    background: rgba(0, 0, 0, 0.4);
    box-shadow: 0 0 10px rgba(56, 189, 248, 0.2);
}

/* --- Documents Section Grid --- */
.documents-section h3 {
    margin-bottom: 20px;
    font-size: 18px;
    color: #94a3b8; /* Muted gray text */
    text-transform: uppercase;
    letter-spacing: 1px;
}

.folders-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

/* --- Folder Cards --- */
.folder-column {
    background: linear-gradient(145deg, rgba(255,255,255,0.1), rgba(255,255,255,0.02));
    padding: 20px;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.folder-column:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    border-color: rgba(56, 189, 248, 0.4);
}

.folder-column h4 {
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 17px;
    color: #38bdf8; /* Accent Blue */
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Add a folder icon via CSS if FontAwesome is present */
.folder-column h4::before {
    content: '\f07b';
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    opacity: 0.7;
}

/* --- List Styling --- */
.folder-column ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.folder-column ul li {
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.folder-column ul li:last-child {
    border-bottom: none;
}

.folder-column ul li a {
    text-decoration: none;
    color: #e2e8f0;
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: color 0.2s;
}

.folder-column ul li a:hover {
    color: #38bdf8;
}

/* Add a small arrow icon on hover */
.folder-column ul li a::after {
    content: '→';
    opacity: 0;
    transition: opacity 0.2s, transform 0.2s;
}

.folder-column ul li a:hover::after {
    opacity: 1;
    transform: translateX(5px);
}

</style>
</head>

<body>

    <div class="wrapper">

        <div class="sidebar">
    <div>
        <h2>Super Admin Panel</h2>

        <!-- Dashboard -->
        <a href="#" id="dashboardLink">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <!-- My Folders -->
        <a href="#" id="myFoldersLink">
            <i class="fas fa-folder"></i> My Folders
        </a>

        <!-- Department Folders -->
        <a href="#" id="departmentFoldersLink">
            <i class="fas fa-building"></i> Department Folders
            <i class="fas fa-chevron-down"></i>
        </a>

        <!-- All Users -->
        <a href="#" id="usersManagementLink">
            <i class="fas fa-users"></i> User Management
            <i class="fas fa-chevron-down"></i>
        </a>

        <!-- Shared Folders -->
        <a href="#" id="sharedFoldersLink">
            <i class="fas fa-share-alt"></i> Shared Folders
        </a>

        <!-- Reports -->
        <a href="#" id="reportsLink">
            <i class="fas fa-chart-bar"></i> Reports
        </a>

        <!-- System Settings -->
        <a href="#" id="settingsLink">
            <i class="fas fa-cogs"></i> System Settings
        </a>
    </div>

    <!-- Logout -->
    <a class="logout" href="/user-side/pages/login/login.php">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

  <!-- ========================== MAIN======================================== -->
                    <div class="main">

    <!-- ================= DASHBOARD CONTENT ================= -->
                   <div id="dashboardContent">

    <!-- TOP BAR -->
    <div class="top">
        <div>
            <h2>Welcome, <?= htmlspecialchars($user); ?>!</h2>
        </div>

        <div class="search">
            <input type="text" placeholder="Search items...">
        </div>
    </div>

    <!-- DOCUMENTS SECTION -->
    <div class="documents-section">
        <h3>Document Folders</h3>

        <div class="folders-container">

            <!-- Recent Folders Column -->
            <div class="folder-column">
                <h4>Recent</h4>
                <ul>
                    <li><a href="#">Inventory Reports</a></li>
                    <li><a href="#">Purchase Orders</a></li>
                    <li><a href="#">Supplier Contracts</a></li>
                </ul>
            </div>

            <!-- Shared Folders Column -->
            <div class="folder-column">
                <h4>Shared Folders</h4>
                <ul>
                    <li><a href="#">HR Documents</a></li>
                    <li><a href="#">Finance Reports</a></li>
                    <li><a href="#">Admin Policies</a></li>
                </ul>
            </div>

            <!-- Department Folders Column -->
            <div class="folder-column">
                <h4>Department Folders</h4>
                <ul>
                    <li><a href="#">Sales</a></li>
                    <li><a href="#">Logistics</a></li>
                    <li><a href="#">IT</a></li>
                </ul>
            </div>

        </div>
    </div>

</div>




        </div>


   
    </div>

</div>

<script src="/admin-side/dashboard.js"></script>

</body>
</html>