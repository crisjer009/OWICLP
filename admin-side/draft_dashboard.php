<!-- 
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
<meta charset="UTF-8
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

 Font Awesome -
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

 Chart.js -
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<style>


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

/* =========================================================
   SIDEBAR
========================================================= 

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
    box-shadow: 4px 0px 20px rgba(0, 0, 0, 0.2);
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

/* Logout Button 
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

/* =========================================================
   MAIN CONTENT LAYOUT
========================================================= 

.main {
    flex: 1;
    padding: 50px;
    background: #1e1924;
    margin-left: 280px; /* important for fixed sidebar 
}

/* =========================================================
           DASHBOARD - MAIN WRAPPER
        ========================================================= 
        #dashboardContent {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Basic Layout Structure */
        .dashboard-layout {
            display: grid;
            grid-template-columns: 3fr 1fr; /* 75% left, 25% right 
            gap: 20px;
        }

        /* =========================================================
           DASHBOARD - TOP BAR
        ========================================================= 
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
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

        /* =========================================================
           DASHBOARD - STAT CARDS
        ========================================================= 
       .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 140px; /* Reduced height to fit more content 
            position: relative;
            overflow: hidden;
            color: #333;
        }

        /* MINI CHART CONTAINERS 
        .card canvas { max-height: 50px !important; width: 100% !important; margin-top: auto; }
        
        .card h3 { font-size: 0.85rem; color: #64748b; text-transform: uppercase; margin: 0; }
        
        .card i {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.2rem;
            color: #cbd5e1;
        }

            /* =========================================================
           NEW: MAIN TREND CHART CONTAINER
        ========================================================= 
        .trend-chart-box {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            color: #333;
            height: 250px;
        }
        .trend-chart-box h4 { margin: 0 0 15px 0; color: #333; }



        /* =========================================================
           DASHBOARD - TABLE BOX
        ========================================================= 
       .table-box {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            color: #333;
        }   
        .table-box h4 { margin: 0 0 15px 0; font-weight: 600; color: #333; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 12px 10px; border-bottom: 1px solid #e0e0e0; }
        th { color: #64748b; font-size: 0.9rem; }
        .green { color: #16a34a; font-weight: 600; }
        .red { color: #dc2626; font-weight: 600; }

        /* =========================================================
           DASHBOARD - RIGHT SIDEBAR
        ========================================================= 
        .system-status {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            color: #333;
        }
        .system-status h4 { margin-top: 0; color: #333; margin-bottom: 20px; }

        /* Layout change for status items 
        .status-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .status-item:last-child { border-bottom: none; }

        .status-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .status-icon { font-size: 1.2rem; }
        
        /* Status colors 
        .status-ok { color: #16a34a; }
        .status-warn { color: #ca8a04; }
        .status-danger { color: #dc2626; }

/* =========================================================
   USERS MANAGEMENT SECTION
========================================================= 

#usersContent {
    padding: 30px;
    animation: fadeIn 0.3s ease;
    font-family: 'Segoe UI', sans-serif;
    background: #1a1c23;
    min-height: 100vh;
}

#usersContent h2 { font-size: 1.8rem; margin-bottom: 5px; color: #fff; }
#usersContent p { color: rgba(255, 255, 255, 0.7); margin-bottom: 25px; }

/* Branch Selector Styles 
.branch-selector {
    margin-bottom: 30px;
}

.branch-selector label {
    color: #fff;
    margin-right: 15px;
    font-weight: 600;
}

#branchSelect {
    padding: 12px 20px;
    border-radius: 50px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    outline: none;
    cursor: pointer;
    width: 100%;
    max-width: 300px;
    font-size: 1rem;
}

#branchSelect option {
    background: #1a1c23;
    color: #fff;
}

/* Table Styles 
#usersTable {
    width: 100%;
    border-collapse: separate;
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    color: #333;
    border-spacing: 0;
}

#usersTable th { 
    padding: 18px 20px; 
    text-align: left; 
    background: #f8f9fa; 
    color: #64748b; 
    font-size: 0.75rem; 
    text-transform: uppercase;
    letter-spacing: 1px;
}
#usersTable td { 
    padding: 15px 20px; 
    border-bottom: 1px solid #f1f5f9; 
}

/* Modal Styles 
.modal {
    display: none; /* Hidden by default 
    position: fixed;
    z-index: 2000;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
}

.modal-content {
    background-color: #fff;
    margin: 8% auto;
    padding: 30px;
    max-width: 450px;
    border-radius: 20px;
    position: relative;
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
}

.close-btn { 
    position: absolute; 
    right: 25px; 
    top: 15px; 
    font-size: 28px; 
    cursor: pointer; 
    color: #94a3b8; 
}

/* Modal Form Styles 
.profile-form { 
    display: flex; 
    flex-direction: column; 
    gap: 15px; 
    padding: 20px 0; 
}

.detail-item { 
    display: flex; 
    flex-direction: column; 
    gap: 5px; 
}

.detail-item label { 
    font-size: 0.85rem; 
    color: #64748b; 
    font-weight: 600;
}

.detail-item input, 
.detail-item select {
    padding: 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 1rem;
    width: 100%;
    box-sizing: border-box; 
}

.detail-item input:focus, 
.detail-item select:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
}

/* Buttons 
.save-btn { 
    background: #0ea5e9; 
    color: white; 
    border: none; 
    padding: 14px; 
    width: 100%; 
    cursor: pointer; 
    border-radius: 10px; 
    font-weight: 600; 
    font-size: 1rem;
    transition: background 0.2s;
}
.save-btn:hover { background: #0284c7; }

.view-btn { 
    background: #f0f9ff; 
    color: #0369a1; 
    padding: 6px 12px; 
    border: none; 
    border-radius: 6px; 
    cursor: pointer; 
    font-weight: 500;
}
.view-btn:hover { background: #e0f2fe; }

/* Animations 
@keyframes fadeIn { 
    from { opacity: 0; transform: translateY(10px); } 
    to { opacity: 1; transform: translateY(0); } 
}

/* =========================================================
   REPORTS SECTION
========================================================= 

.modern-dashboard-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 Column Grid */
    gap: 20px;
    padding: 10px;
}

.metrics-row {
    grid-column: 1 / -1;
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.metrics-row .card {
    flex: 1;
    min-width: 220px;
    background: #fff;
    padding: 20px;
    border-radius: 16px; 
    box-shadow: 0 10px 20px rgba(0,0,0,0.03); 
    border: 1px solid #f0f0f0;
}

/* Box Styling 
.dashboard-box {
    background: #fff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.03);
    border: 1px solid #f0f0f0;
}

/* Grid Positioning 
.chart-box-large {
    grid-column: span 2; /* Distribution Chart takes 2/3 width 
}

.chart-box-small {
    grid-column: span 1; /* Sales vs Target takes 1/3 width

.table-box-full {
    grid-column: 1 / -1; /* Table takes full width 
}

.box-title {
    margin-bottom: 20px;
    font-size: 1.1rem;
    color: #2c3e50;
    font-weight: 700;
}

/* Chart Stylings 
#chartdiv {
    width: 100%;
    /* Height is set inline in HTML for this example 
}

.chart-placeholder {
    height: 350px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 12px;
}

/* Data Table Styling
.data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.data-table th {
    color: #7f8c8d;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.data-table td {
    padding: 20px 15px;
    border-bottom: 1px solid #f0f0f0;
    font-size: 0.95rem;
    color: #2c3e50;
    font-weight: 500;
}

.data-table tr:last-child td {
    border-bottom: none;
}

.data-table tr:hover {
    background-color: #fbfbfb;
}

.reports-flex {
    display: flex;
    justify-content: space-between; /* Pushes chart left, legend right */
    gap: 15px; /* Compact gap */
    align-items: center; /* Vertically aligns them */
    flex-wrap: nowrap; /* Ensures they stay side-by-side */
}

#chartdiv { 
    width: 65%; /* Chart takes 65% width */
    height: 250px; /* Reduced height for smaller footprint */
}

#chartlegend { 
    width: 30%; /* Legend takes 30% width */
    height: 250px; /* Matches chart height */
    overflow-y: auto; /* Scrollbar if legend is too long */
    font-size: 0.85rem; /* Smaller, cleaner font */
}

.chart-box-large {
    padding: 15px; /* Reduced padding from 25px */
}

/* Trend Colors 
.trend.up { color: #2ecc71; }
.trend.down { color: #e74c3c; }



@media (max-width: 900px) {

    .wrapper {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        flex-direction: row;
        overflow-x: auto;
    }

    .main {
        margin-left: 0;
        padding: 20px;
    }

    .reports-flex {
        flex-direction: column;
    }

    #chartdiv,
    #chartlegend {
        width: 100%;
    }
}
</style>



</head>

<body>
<div class="wrapper">

    <!-- Sidebar 
    <div class="sidebar">
        <div>
            <h2>Admin Panel</h2>
            <a href="#" id="dashboardLink"><i class="fas fa-home"></i>Dashboard</a>
            <a href="#" id="usersLink"><i class="fas fa-users"></i>Branches</a>
            <a href="#" id="pointsLink"><i class="fas fa-coins"></i>Points Management</a>
            <a href="#" id="rewardsLink"><i class="fas fa-gift"></i>Rewards Management</a>
            <a href="#" id="transactionsLink"><i class="fas fa-exchange-alt"></i>Transactions</a>
            <a href="#" id="reportsLink"><i class="fas fa-chart-line"></i>Reports</a>
            <a href="#" id="settingsLink"><i class="fas fa-cog"></i>Settings</a>
        </div>
        <a class="logout" href="/user-side/pages/login/login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main 
    <div class="main">

       <div id="dashboardContent">
        <div class="top">
            <div>
                <h2>Welcome, ADMIN</h2>
                <small>Here's a quick overview of your system</small>
            </div>
            <div class="search">
                <input type="text" placeholder="Search users, transactions...">
            </div>
        </div>

        <div class="dashboard-layout">

            <div class="dashboard-left">
                <div class="cards">
                    <div class="card">
                        <h3>Total Users</h3>
                        <canvas id="usersMiniChart"></canvas>
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card">
                        <h3>Total Points</h3>
                        <canvas id="pointsMiniChart"></canvas>
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="card">
                        <h3>Total Rewards</h3>
                        <canvas id="rewardsMiniChart"></canvas>
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="card">
                        <h3>Total Transactions</h3>
                        <canvas id="transactionsMiniChart"></canvas>
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>

                <div class="table-box">
                    <h4>Recent User Activity</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Feb 11, 2026</td>
                                <td>Michaela Doe</td>
                                <td>Redeemed Reward</td>
                                <td class="red">-100</td>
                            </tr>
                            <tr>
                                <td>Feb 10, 2026</td>
                                <td>John Johnny</td>
                                <td>Earned Points from Purchase</td>
                                <td class="green">+250</td>
                            </tr>
                            <tr>
                                <td>Feb 09, 2026</td>
                                <td>Gian Hermoso</td>
                                <td>Referred a Friend</td>
                                <td class="green">+100</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dashboard-right">
                <div class="system-status">
                    <h4>System Health</h4>
                    
                    <div class="status-item">
                        <div class="status-label">
                            <i class="fas fa-server"></i> Server
                        </div>
                        <span class="status-ok">Online <i class="fas fa-check-circle"></i></span>
                    </div>

                    <div class="status-item">
                        <div class="status-label">
                            <i class="fas fa-database"></i> Database
                        </div>
                        <span class="status-ok">Connected <i class="fas fa-check-circle"></i></span>
                    </div>

                    <div class="status-item">
                        <div class="status-label">
                            <i class="fas fa-exclamation-triangle"></i> Errors
                        </div>
                        <span class="status-warn">2 Pending</span>
                    </div>
                </div>
            </div>
           

        </div>
    </div>
    
  <div id="usersContent">
    <div class="header-flex">
        <div>
            <h2>Branch Management</h2>
            <p>Select a branch to view and manage admins and managers.</p>
        </div>
    </div>

    <div class="branch-selector">
        <label for="branchSelect">Select Branch:</label>
        <select id="branchSelect" onchange="loadBranchUsers()">
            <option value="">-- Choose a Branch --</option>
            <option value="cubao">Cubao</option>
            <option value="santolan">Santolan</option>
            <option value="antipolo">Antipolo</option>
            <option value="montalban">Montalban</option>
        </select>
    </div>

    <table id="usersTable" style="display:none;">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="branchUsersBody">
            </tbody>
    </table>
</div>

<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Edit User Profile</h2>
        <hr>
        <div class="profile-form">
            <div class="detail-item"><strong>User ID:</strong> <span id="detID"></span></div>
            <div class="detail-item">
                <label><strong>Full Name:</strong></label>
                <input type="text" id="detName">
            </div>
            <div class="detail-item">
                <label><strong>Email:</strong></label>
                <input type="email" id="detEmail">
            </div>
            <div class="detail-item">
                <label><strong>Role:</strong></label>
                <select id="detRole">
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                </select>
            </div>
        </div>
        <hr>
        <button class="save-btn" onclick="saveUserChanges()">Save Changes</button>
    </div>
</div>

        <!-- Point SECTIONS 
        <div id="pointsContent" style="display:none;">
            <h2>Points Management</h2>
            <p>Update, adjust, or monitor user points...</p>
        </div>
        <div id="rewardsContent" style="display:none;">
            <h2>Rewards Management</h2>
            <p>Add new rewards...</p>
        </div>
        <div id="transactionsContent" style="display:none;">
            <h2>Transactions</h2>
            <p>View all transactions...</p>
        </div>
        <div id="settingsContent" style="display:none;">
            <h2>Settings</h2>
            <p>Admin settings...</p>
        </div>

        <!-- REPORTS 
       <div id="reportsContent" style="display:block;">
    <h2 class="section-title">Reports & Analytics</h2>

    <div class="modern-dashboard-grid">
        
        <div class="metrics-row">
            <div class="card">
                <div class="card-header">Audience</div>
                <div class="card-value">1,878</div>
                <div class="card-trend up"><i class="fas fa-arrow-up"></i> +12%</div>
            </div>
            <div class="card">
                <div class="card-header">Visitors</div>
                <div class="card-value">21,022</div>
                <div class="card-trend down"><i class="fas fa-arrow-down"></i> -8%</div>
            </div>
            <div class="card">
                <div class="card-header">Conversion</div>
                <div class="card-value">9,881,118</div>
                <div class="card-trend up"><i class="fas fa-arrow-up"></i> +8.9%</div>
            </div>
            <div class="card">
                <div class="card-header">Total Rate</div>
                <div class="card-value">187%</div>
                <div class="card-trend up"><i class="fas fa-arrow-up"></i> +77%</div>
            </div>
        </div>

        <div class="dashboard-box chart-box-large">
            <h4 class="box-title">Puregold Stores Distribution</h4>
            <div id="chartdiv" style="height: 350px;"></div>
            <div id="chartlegend"></div>
        </div>

        <div class="dashboard-box chart-box-small">
            <h4 class="box-title">Sales vs. Target (Monthly)</h4>
            <div class="chart-placeholder">
                <p style="color: #666;">[Sales Target Bar Chart Placeholder]</p>
            </div>
        </div>

        <div class="dashboard-box table-box-full">
            <h4 class="box-title">Top Performing Locations</h4>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Branch</th>
                        <th>City</th>
                        <th>Sales</th>
                        <th>Growth</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Puregold QI Central</td>
                        <td>Quezon City</td>
                        <td>₱1,200,000</td>
                        <td><span class="trend up">▲ +15%</span></td>
                    </tr>
                    <tr>
                        <td>Puregold Monumento</td>
                        <td>Caloocan</td>
                        <td>₱980,000</td>
                        <td><span class="trend up">▲ +12%</span></td>
                    </tr>
                    <tr>
                        <td>Puregold Valenzuela</td>
                        <td>Valenzuela</td>
                        <td>₱850,000</td>
                        <td><span class="trend down">▼ -2%</span></td>
                    </tr>
                </tbody>
            </table>
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
 -->



 
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- =========================================================
        META
    ========================================================== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- =========================================================
        EXTERNAL LIBRARIES
    ========================================================== -->

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

/* ================================  DASHBOARD CARDS========================================= */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.card {
    background: #25202b; 
    padding: 25px;
    border-radius: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.card-info span {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
}

.card-info h2 {
    font-size: 1.8rem;
    color: #fff;
    margin-top: 5px;
}

.trend {
    font-weight: 600;
    font-size: 0.9rem;
}

.trend.up {
    color: #38bdf8; /* Light blue */
}

.trend.down {
    color: #ef4444; /* Red */
}

/* ================================ MAIN GRID LAYOUT============================== */
.main-dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr; 
    gap: 20px;
}

.table-box, .chart-box {
    background: #25202b;
    padding: 25px;
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.table-box h4, .chart-box h4 {
    color: #fff;
    margin-bottom: 20px;
    font-size: 1.2rem;
}

/* ================================= DATA TABLE STYLING=================================== */
.data-table {
    width: 100%;
    border-collapse: collapse;
    color: #fff;
}

.data-table th {
    text-align: left;
    color: rgba(255, 255, 255, 0.5);
    font-weight: 500;
    padding: 15px 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 0.9rem;
}

.data-table td {
    padding: 15px 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    font-size: 0.95rem;
}

.data-table tr:hover {
    background: rgba(255, 255, 255, 0.03);
}

/* Status Badges */
.status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status.in-transit {
    background: rgba(246, 194, 62, 0.1);
    color: #f6c23e;
}

.status.delivered {
    background: rgba(28, 200, 138, 0.1);
    color: #1cc88a;
}

/* ===============================CHART BOX STYLING============================================= */
.chart-placeholder {
    height: 300px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    border: 2px dashed rgba(255, 255, 255, 0.1);
}

.chart-placeholder p {
    color: rgba(255, 255, 255, 0.4);
}


/* ==============================  BRANCHES CONTENT STYLES ============================= */

#branchesContent {
    padding: 30px;
    min-height: 100vh;
    background: var(--bg-color); 
    font-family: 'Segoe UI', sans-serif;
    animation: fadeIn 0.3s ease;
}

/* Top Section */
#branchesContent .top {
    display: flex;
    flex-direction: column;
    margin-bottom: 25px;
}

#branchesContent .top h2 {
    font-size: 1.8rem;
    margin-bottom: 5px;
    color: white;
}

#branchesContent .top small {
    color: white;
}

/* Branch Selector */
#branchSelect {
    padding: 12px 18px;
    border-radius: 10px;
    border: 1px solid #d1d5db; 
    color: #111827;
    font-size: 1rem;
    outline: none;
    transition: all 0.2s ease;
    width: 100%;
    max-width: 300px;
    cursor: pointer;
}

#branchSelect:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
}

/* Table Box */
#branchTableWrapper {
    margin-top: 20px;
    background: var(--box-color); /* Matches box dark background */
    padding: 20px 25px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    transition: all 0.2s ease;
}

#branchTableWrapper h4 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    color: var(--text-color); /* White */
}

/* Data Table */
#branchTableWrapper table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

#branchTableWrapper th {
    background: rgba(255, 255, 255, 0.05); /* Subtle light gray background for headers */
    padding: 12px 15px;
    font-weight: 600;
    color: var(--text-muted); /* Light gray text */
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    text-align: left;
}

#branchTableWrapper td {
    padding: 12px 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05); /* Subtle dark border */
    color: var(--text-color); /* White text */
    font-size: 0.95rem;
}

#branchTableWrapper tr:last-child td {
    border-bottom: none;
}

/* Hover Effect */
#branchTableWrapper tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.03); /* Slight highlight on hover */
    transition: background 0.2s ease;
}


.modal {
    display: none; 
    position: fixed; 
    z-index: 1000; 
    left: 0; top: 0;
    width: 100%; height: 100%; 
    background-color: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: black;
    padding: 30px;
    border-radius: 15px;
    width: 400px;
    color: white; 
    position: relative;
}

.close-btn {
    position: absolute;
    top: 15px; right: 20px;
    font-size: 24px;
    cursor: pointer;
}

.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; color: var(--text-muted); }

.form-group input, .form-group select {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #d1d5db; 
    background: #ffffff;       
    color: #111827;           
}

.form-group input[readonly] { 
    background: #f3f4f6;       
    opacity: 0.8; 
    cursor: not-allowed; 
}

.save-btn {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: var(--primary-blue);
    color: white;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
}
.edit-btn {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

/* ================ SUPPLIERS & STOCK MOVEMENT STYLES  =============================== */

#StocksContent {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    color: var(--text-color); 
    padding: 20px;
    background-color: var(--bg-color); 
    min-height: 100vh;
}

/* Header Area */
#StocksContent .top {
    margin-bottom: 25px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1); /* Subtle border */
    padding-bottom: 15px;
}

#StocksContent h2 {
    margin: 0;
    font-size: 24px;
    color: white;
}

#StocksContent small {
    color: var(--text-muted); /* Light gray */
    font-size: 14px;
}

/* Chart Container Styling */
.chart-container {
    width: 100%;
    margin-bottom: 30px;
}

.chart-box {
    background-color: var(--box-color); /* Dark box background */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.3);
}

.chart-box h4 {
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 16px;
    color: var(--text-color); /* White */
    text-align: center;
}

canvas {
    max-height: 250px;
}

/* Table Container Styling */
.table-box {
    background-color: var(--box-color); /* Dark box background */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    overflow-x: auto;
}

.table-box h4 {
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 18px;
    color: var(--text-color); /* White */
}

/* Data Table Styling */
.data-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}

.data-table thead th {
    text-align: left;
    padding: 12px 15px;
    background-color: rgba(255, 255, 255, 0.05); /* Very light background for contrast */
    color: var(--text-muted); /* Light gray text */
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.data-table tbody td {
    padding: 15px;
    font-size: 14px;
    color: var(--text-color); /* White */
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

/* Table Row Hover Effect */
.data-table tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.02); /* Very subtle hover */
}
        /* Status Badges */
.status {
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: capitalize;
}
.status.pending { background: rgba(251, 191, 36, 0.2); color: #fbbf24; }
.status.in-transit { background: rgba(56, 189, 248, 0.2); color: #38bdf8; }
.status.completed { background: rgba(16, 185, 129, 0.2); color: #34d399; }

/* Action Buttons */
.action-btn {
    background: transparent;
    border: 1px solid #38bdf8; /* Blue accent */
    color: #38bdf8;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.85rem;
    transition: all 0.2s ease;
}
.action-btn:hover {
    background: #38bdf8;
    color: #ffffff;
}

/* Table Row Hover Effect */
.data-table tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.02); /* Very subtle hover */
}


     /* =========================== TICKETING SECTION STYLES =================*/

.ticket-dashboard-container {
    width: 100%;
    margin-top: 10px;
}

.ticket-table-box {
    background-color: #1a1d26; 
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.03);
    overflow-x: auto;
}

.ticket-data-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 800px;
    color: #e2e8f0;
}

.ticket-data-table thead th {
    text-align: left;
    padding: 12px 15px;
    color: #94a3b8;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.ticket-data-table tbody td {
    padding: 16px 15px;
    font-size: 0.9rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    vertical-align: middle;
}

.ticket-data-table tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.01);
}

.ticket-data-table td strong {
    color: #ffffff;
    font-weight: 600;
}

.status-label, .prio-tag {
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
}

.status-label.pending {
    background: rgba(251, 191, 36, 0.1);
    color: #fbbf24;
    border: 1px solid rgba(251, 191, 36, 0.2);
}

.prio-tag.high {
    background: rgba(248, 113, 113, 0.1);
    color: #f87171;
    border: 1px solid rgba(248, 113, 113, 0.2);
}

.action-cell {
    display: flex;
    gap: 8px;
}

.action-cell button {
    border: none;
    background: rgba(255, 255, 255, 0.05);
    padding: 7px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
}

.view-btn { color: #38bdf8; }
.edit-btn { color: #fbbf24; }
.delete-btn { color: #f87171; }

.action-cell button:hover {
    background: rgba(255, 255, 255, 0.12);
    transform: scale(1.05);
}

.btn-primary {
    background: #fdffff;
    color: black;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.85rem;
    border: none;
    cursor: pointer;
}
    /* ======================= REPORTS SECTION STYLES ======================================== */

.reports-row {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    align-items: flex-start;
}

.reports-chart-box,
.reports-table-box {
    flex: 1;
    background-color: var(--box-color);
    padding: 20px;
    border-radius: 12px;
}

.chart-title {
    color: #ffffff;
    text-align: center;
    margin-top: 0;
}

.chart-wrapper {
    display: flex;
    gap: 10px;
    align-items: center;
}

#chartdiv {
    width: 60%;
    height: 300px;
}

#chartlegend {
    width: 40%;
    height: 300px;
    overflow-y: auto;
}

.table-wrapper {
    overflow-x: auto;
}

.trend.up {
    color: #34d399;
}

.trend.down {
    color: #f87171;
}
.data-table tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.02);
}





    </style>

</head>

<body>

    <div class="wrapper">
     <!-- ======================= SIDEBAR================================ -->
        <div class="sidebar">
            <div>
                <h2>Admin Panel</h2>

                <a href="#" id="dashboardLink">
                    <i class="fas fa-home"></i> Dashboard
                </a>

                <a href="#" id="usersLink">
                    <i class="fas fa-users"></i> Branches
                </a>
                <a href="#" id="suppliersStockLink">
                 <i class="fas fa-boxes"></i> Suppliers & Stock Movement
                </a>

                <a href="#" id="ticketManagementLink">
                 <i class="fas fa-ticket-alt"></i> Support Ticket Management
                </a>

                <a href="#" id="transactionsLink">
                    <i class="fas fa-exchange-alt"></i> Transactions
                </a>

                <a href="#" id="reportsLink">
                    <i class="fas fa-chart-line"></i> Reports
                </a>

                <a href="#" id="settingsLink">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </div>

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
                        <small>Office Warehouse Inventory Overview</small>
                    </div>

                    <div class="search">
                        <input type="text" placeholder="Search SKUs, locations, items...">
                    </div>
                </div>

                    <!-- STAT CARDS -->
                    <div class="cards">

                        <div class="card">
                            <div class="card-info">
                                <span>Total SKUs in Stock</span>
                                <h2>1,284</h2>
                            </div>
                            <span class="trend up">↑ 3.2%</span>
                        </div>

                        <div class="card">
                            <div class="card-info">
                                <span>Low Stock Items</span>
                                <h2>27</h2>
                            </div>
                            <span class="trend down">↑ 15.0%</span>
                        </div>

                        <div class="card">
                            <div class="card-info">
                                <span>Total Inventory Value</span>
                                <h2>₱200,890.00</h2>
                            </div>
                            <span class="trend up">↑ 1.8%</span>
                        </div>

                        <div class="card">
                            <div class="card-info">
                                <span>Warehouse Capacity</span>
                                <h2>78%</h2>
                            </div>
                            <span class="trend up">↑ 2.0%</span>
                        </div>

                    </div>

        <!-- MAIN GRID -->
        <div class="main-dashboard-grid">

            <!-- RECENT INVENTORY TABLE -->
            <div class="table-box">
                <h4>Recent Inventory Activity</h4>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Item Name</th>
                            <th>Location</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>OFF-CH-001</td>
                            <td>Ergonomic Desk Chair</td>
                            <td>Manila City</td>
                            <td>45</td>
                            <td>Units</td>
                            <td><span class="status delivered">In Stock</span></td>
                        </tr>

                        <tr>
                            <td>TEC-PRN-05</td>
                            <td>LaserJet Office Printer</td>
                            <td>Quezon City</td>
                            <td>5</td>
                            <td>Units</td>
                            <td><span class="status pending">Low Stock</span></td>
                        </tr>

                        <tr>
                            <td>OFF-TBL-10</td>
                            <td>Wooden Conference Table</td>
                            <td>Makati City</td>
                            <td>12</td>
                            <td>Units</td>
                            <td><span class="status delivered">In Stock</span></td>
                        </tr>

                        <tr>
                            <td>PAP-A4-02</td>
                            <td>Bond Paper A4 (Sub 20)</td>
                            <td>Cebu City</td>
                            <td>300</td>
                            <td>Reams</td>
                            <td><span class="status delivered">In Stock</span></td>
                        </tr>

                        <tr>
                            <td>OFF-DSK-03</td>
                            <td>Modular Office Desk</td>
                            <td>Davao City</td>
                            <td>0</td>
                            <td>Units</td>
                            <td>
                                <span class="status delivered" style="background:#ef4444; color:white;">
                                    Out of Stock
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- STOCK MOVEMENT CHART -->
            <div class="chart-box">
                <h4>Stock Movement (Last 30 Days)</h4>
                <div class="chart-placeholder">
                    <p>[Stock Movement Graph]</p>
                </div>
            </div>

        </div>
    </div>


    <!-- =======================   BRANCHES CONTENT ================================ -->
    <div id="branchesContent" style="display:none;">

    <div class="top">
        <div>
            <h2>Branch Management</h2>
            <small>Select a branch to view assigned users</small>
        </div>
    </div>

    <div style="margin-bottom:20px;">
        <select id="branchSelect" style="padding:10px 15px; border-radius:8px;">
            <option value="">-- Select Branch --</option>
            <option value="Makati">Makati</option>
            <option value="Cubao">Cubao</option>
            <option value="Batangas">Batangas</option>
            <option value="Bulacan">Bulacan</option>
            <option value="Antipolo">Antipolo</option>
        </select>
    </div>

    <div class="table-box" id="branchTableWrapper" style="display:none;">
        <h4>Branch Users</h4>

        <table class="data-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Branch</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th> </tr>
            </thead>
            <tbody id="branchTableBody">
                </tbody>
        </table>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3>Edit User Details</h3>
        <form id="editForm">
            <div class="form-group">
                <label>User ID (Locked)</label>
                <input type="text" id="editUserId" readonly>
            </div>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" id="editName">
            </div>
            <div class="form-group">
       <label>Branch (Locked)</label> 
                <input type="text" id="editBranch" readonly>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select id="editRole">
                    <option value="Staff">Staff</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Manager">Manager</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="editStatus">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <button type="submit" class="save-btn">Save Changes</button>
        </form>
    </div>
</div>

        <!------------- Stocks Content --------->

 <div id="StocksContent" style="display:none;">
    <div class="top">
        <div>
            <h2>Suppliers & Stock Movement</h2>
            <small>Manage suppliers and inter-branch stock transfers</small>
        </div>
    </div>

    <div class="chart-container">
        <div class="chart-box" style="flex: 1; max-width: 400px; margin: 0 auto 30px auto;">
            <h4>Transfer Status Breakdown</h4>
            <canvas id="transferStatusChart"></canvas>
        </div>
    </div>

    <div class="table-box" style="margin-bottom:30px;">
        <h4>Suppliers</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Supplier</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Pricing</th>
                    <th>Leading Time</th>
                    <th>Next Shipment</th>

                </tr>
            </thead>
            <tbody id="suppliersTableBody">
                </tbody>
        </table>
    </div>

    <div class="table-box">
        <h4>Inter-Branch Stock Transfers</h4>

        <table class="data-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>From Branch</th>
                <th>To Branch</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Date Requested</th>
                <th>Action</th> </tr>
        </thead>
        <tbody id="transfersTableBody">
            </tbody>
    </table>
    </div>
</div>

 <div id="ticketContent" style="display:none;">
    <div class="top">
        <div class="ticket-header">
            <div class="header-text">
                <h2>Support Ticket Management</h2>
                <small>Process of tracking, prioritizing, and resolving branch problems</small>
            </div>
            <button class="btn-primary" id="createNewTicket">
                <i class="fas fa-plus"></i> Create New Ticket
            </button>
        </div>

        <div class="ticket-dashboard-container">
            <div class="ticket-table-box">
                <table class="ticket-data-table" id="ticketTable">
                    <thead>
                        <tr>
                            <th>Branch</th>
                            <th>Issue Detail</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Cubao Branch</strong></td>
                            <td class="issue-text">Printer connectivity issues in Office 2</td>
                            <td><span class="prio-tag high">High</span></td>
                            <td><span class="status-label pending">Pending</span></td>
                            <td class="action-cell">
                                <button class="view-btn" onclick="viewTicket(this)"><i class="fas fa-eye"></i></button>
                                <button class="edit-btn" onclick="editTicket(this)"><i class="fas fa-edit"></i></button>
                                <button class="delete-btn" onclick="confirmDelete(this)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Monumento Branch</strong></td>
                            <td class="issue-text">POS Terminal 4 touchscreen unresponsive</td>
                            <td><span class="prio-tag medium">Medium</span></td>
                            <td><span class="status-label progress">In Progress</span></td>
                            <td class="action-cell">
                                <button class="view-btn" onclick="viewTicket(this)"><i class="fas fa-eye"></i></button>
                                <button class="edit-btn" onclick="editTicket(this)"><i class="fas fa-edit"></i></button>
                                <button class="delete-btn" onclick="confirmDelete(this)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>











                <!---------------------- REPORTS ------------>

            <div id="reportsContent" style="display:none;">

    <div class="top">
        <div>
            <h2>Analytics Report</h2>
            <small>Branch Performance Overview</small>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 30px;">
        
        <div class="chart-box" style="display: flex; gap: 20px; align-items: center; background-color: var(--box-color); padding: 20px; border-radius: 12px;">
            <div style="width: 70%; height: 300px;">
                <h4 style="color: white; text-align:center;">Sales Distribution by Branch</h4>
                <div id="chartdiv" style="width: 100%; height: 260px;"></div>
            </div>
            <div id="chartlegend" style="width: 30%; height: 300px; overflow-y: auto;"></div>
        </div>

    </div>

    <div class="dashboard-box table-box-full" style="background-color: var(--box-color); padding: 20px; border-radius: 12px;">
        <h4 class="box-title" style="color: white; margin-bottom: 15px;">Top Performing Locations</h4>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Branch</th>
                    <th>City</th>
                    <th>Sales</th>
                    <th>Growth</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Puregold QI Central</td>
                    <td>Quezon City</td>
                    <td>₱1,200,000</td>
                    <td><span class="trend up" style="color: #34d399;">▲ +15%</span></td>
                </tr>
                <tr>
                    <td>Puregold Libertad</td>
                    <td>Pasay</td>
                    <td>₱650,000</td>
                    <td><span class="trend down" style="color: #f87171;">▼ -3%</span></td>
                </tr>
                <tr>
                    <td>Puregold Monumento</td>
                    <td>Caloocan</td>
                    <td>₱980,000</td>
                    <td><span class="trend up" style="color: #34d399;">▲ +12%</span></td>
                </tr>
                <tr>
                    <td>Puregold Valenzuela</td>
                    <td>Valenzuela</td>
                    <td>₱850,000</td>
                    <td><span class="trend down" style="color: #f87171;">▼ -2%</span></td>
                </tr>
                
            </tbody>
        </table>
    </div>

</div>
</div>

    </div>

</div>

<script src="/admin-side/dashboard.js"></script>

</body>
</html>