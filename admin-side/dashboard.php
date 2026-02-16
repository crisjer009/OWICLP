<?php
session_start();
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="dashboard.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
}

body{
    background:#f0f2f5;
    color:#333;
}


.wrapper{
    display:flex;
    min-height:100vh;
}

.sidebar{
    width:260px;
    background: linear-gradient(135deg, rgb(2, 0, 36), #4b4a4af6);
    color:#fff;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    padding:40px 20px;
    transition: width 0.3s;
}

.sidebar h2{
    text-align:center;
    margin-bottom:50px;
    font-size:1.8rem;
    font-weight:700;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:15px;
    color:#fff;
    padding:12px 16px;
    margin:8px 0;
    text-decoration:none;
    border-radius:8px;
    transition:0.3s;
    font-weight:500;
}

.sidebar a i{
    width:20px;
    text-align:center;
}

.sidebar a:hover{
    background:black;
}

.logout{
    margin-top:20px;
    background:#0b2545;
    text-align:center;
    padding:10px 0;
    border-radius:8px;
    font-weight:600;
}

.main{
    flex:1;
    padding:50px;
    background: #1e1924;
}


  /* top section */
  
.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    margin-bottom:30px;
}

.top h2{
    font-size:1.8rem;
    margin-bottom:5px;
    color: white;
}

.top small{
    color: #fff;
}

.search input{
    padding:10px 15px;
    width:240px;
    border-radius:25px;
    border:1px solid #ccc;
    outline:none;
    transition:0.3s;
}

.search input:focus{
    border-color:#3b82f6;
}


#usersContent {
    padding: 20px;
    font-family: Arial, sans-serif;
}

/* Heading & description */
#usersContent h2 {
    margin-bottom: 10px;
    color: #333;
    font-size: 1.6rem;
}
#usersContent p {
    margin-bottom: 20px;
    color: #666;
    font-size: 0.95rem;
}

/* Search input */
#userSearch {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px 15px;
    width: 100%;
    max-width: 400px;
    margin-bottom: 20px;
    transition: 0.3s;
}
#userSearch:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 5px rgba(0,123,255,0.5);
}

/* Users table */
#usersTable {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 5px 15px rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

#usersTable thead {
    background-color: #007BFF;
    color: white;
}

#usersTable th, #usersTable td {
    padding: 12px 15px;
    text-align: left;
    font-size: 0.95rem;
}

#usersTable tbody tr {
    border-bottom: 1px solid #ddd;
    transition: background 0.3s, transform 0.2s;
}

#usersTable tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

#usersTable tbody tr:hover {
    background-color: #e0f0ff;
    transform: translateX(2px);
}

/* Role & Status badges */
.badge {
    padding: 4px 10px;
    border-radius: 12px;
    color: white;
    font-size: 0.85em;
    font-weight: bold;
    text-align: center;
    display: inline-block;
}

/* Role */
.badge-member { background-color: #28a745; } /* green */
.badge-admin { background-color: #17a2b8; } /* teal */
.badge-moderator { background-color: #6f42c1; } /* purple */

/* Status */
.badge-active { background-color: #28a745; } /* green */
.badge-inactive { background-color: #dc3545; } /* red */
.badge-suspended { background-color: #ffc107; color: #333; } /* yellow */

/* Action buttons */
#usersTable button {
    padding: 6px 12px;
    margin-right: 5px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.9em;
    transition: 0.3s;
}

#usersTable button.edit-btn {
    background-color: #ffc107; /* yellow */
    color: #333;
}

#usersTable button.edit-btn:hover {
    opacity: 0.85;
}

#usersTable button.delete-btn {
    background-color: #dc3545; /* red */
    color: white;
}

#usersTable button.delete-btn:hover {
    opacity: 0.85;
}

/* Responsive table */
@media (max-width: 900px) {
    #usersTable thead { display: none; }
    #usersTable, #usersTable tbody, #usersTable tr, #usersTable td {
        display: block;
        width: 100%;
    }
    #usersTable tr {
        margin-bottom: 15px;
        border-bottom: 2px solid #ddd;
    }
    #usersTable td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }
    #usersTable td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        width: 45%;
        padding-left: 5px;
        font-weight: bold;
        text-align: left;
    }
}


.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
    gap:20px;
    margin-bottom:40px;
}

.card{
    background:#ffffff;
    color:#1f2933;
    padding:22px 18px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    position:relative;
    border:1px solid #e5e7eb;
    transition:0.3s;
}

.card i{
    position:absolute;
    top:15px;
    right:15px;
    font-size:22px;
    opacity:0.4;
    color:#374151;
}

.card:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 28px rgba(0,0,0,0.12);
}

.card h3{
    font-size:14px;
    font-weight:600;
    margin-bottom:10px;
    color:#6b7280;
}

.card canvas{
    display:block;
    width:100% !important;
    height:90px !important;
}

/* DASHBOARD LAYOUT */
.dashboard-layout {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.dashboard-left { flex: 2; }
.dashboard-right { flex: 1; display: flex; flex-direction: column; gap: 20px; }

/* TABLE BOX*/
.table-box {
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    margin-bottom: 40px;
}

.table-box h4 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    color: #111;
    font-weight: 600;
}

.table-box canvas {
    width: 100% !important;
    height: auto !important;
    max-height: 300px;
}

/* TABLE STYLING */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 12px 10px;
    border-bottom: 1px solid #e0e0e0;
    text-align: left;
}

th { color: #555; font-weight: 600; }
.green { color: green; font-weight: 600; }
.red { color: red; font-weight: 600; }

/*  
   REPORTS SECTION
   ======================= */
.reports-flex {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

#chartdiv { width: 70%; height: 400px; }
#chartlegend { width: 30%; height: 400px; }

.metrics-cards {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.metrics-cards .card {
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    flex: 1;
    min-width: 180px;
}

.metrics-cards .card h5 { font-size: 1rem; color: #555; margin-bottom: 10px; }
.metrics-cards .card p { font-size: 1.5rem; margin: 0; }
.metrics-cards .up { color: green; }
.metrics-cards .down { color: red; }

/* Responsive */
@media (max-width: 900px) {
    .reports-flex { flex-direction: column; }
    #chartdiv, #chartlegend { width: 100%; height: 400px; }
    .wrapper { flex-direction: column; }
    .sidebar { width: 100%; padding:20px; flex-direction: row; overflow-x:auto; }
    .sidebar a { margin:0 10px; }
    .main { padding:20px; }
}
</style>
</head>

<body>
<div class="wrapper">

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <h2>Admin Panel</h2>
            <a href="#" id="dashboardLink"><i class="fas fa-home"></i>Dashboard</a>
            <a href="#" id="usersLink"><i class="fas fa-users"></i>Users</a>
            <a href="#" id="pointsLink"><i class="fas fa-coins"></i>Points Management</a>
            <a href="#" id="rewardsLink"><i class="fas fa-gift"></i>Rewards Management</a>
            <a href="#" id="transactionsLink"><i class="fas fa-exchange-alt"></i>Transactions</a>
            <a href="#" id="reportsLink"><i class="fas fa-chart-line"></i>Reports</a>
            <a href="#" id="settingsLink"><i class="fas fa-cog"></i>Settings</a>
        </div>
        <a class="logout" href="/admin/pages/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- DASHBOARD -->
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
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Points</th>
                            </tr>
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
                        </table>
                    </div>
                </div>

                <div class="dashboard-right">
                    <div class="table-box">
                        <h4>Yearly Sales</h4>
                        <canvas id="yearlySalesChart" height="200"></canvas>
                    </div>
                </div>

            </div>
        </div>

        <!-- USERS MANAGEMENT -->
        <div id="usersContent" style="display:none;">
            <h2>Users Management</h2>
            <p>Manage and view all registered users on the system.</p>

            <input type="text" id="userSearch" placeholder="Search users..." onkeyup="filterUsers()">

            <table id="usersTable">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Registered Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>U001</td>
                        <td>John Doe</td>
                        <td>john@example.com</td>
                        <td><span class="badge badge-member">Member</span></td>
                        <td><span class="badge badge-active">Active</span></td>
                        <td>2026-01-10</td>
                        <td>
                            <button class="edit-btn" onclick="editUser('U001')">Edit</button>
                            <button class="delete-btn" onclick="deleteUser('U001')">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>U002</td>
                        <td>Jane Smith</td>
                        <td>jane@example.com</td>
                        <td><span class="badge badge-admin">Admin</span></td>
                        <td><span class="badge badge-active">Active</span></td>
                        <td>2026-01-12</td>
                        <td>
                            <button class="edit-btn" onclick="editUser('U002')">Edit</button>
                            <button class="delete-btn" onclick="deleteUser('U002')">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- OTHER SECTIONS -->
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

        <!-- REPORTS -->
        <div id="reportsContent" style="display:none;">
            <h2>Reports & Analytics</h2>
            <div class="metrics-cards">
                <div class="card">
                    <h5>Audience</h5>
                    <p>1,878 <span class="up"><small>+12% vs last month</small></span></p>
                </div>
                <div class="card">
                    <h5>Visitors</h5>
                    <p>21,022 <span class="down"><small>-8% vs last month</small></span></p>
                </div>
                <div class="card">
                    <h5>Conversion</h5>
                    <p>9,881,118 <span class="up"><small>+8.9% vs last month</small></span></p>
                </div>
                <div class="card">
                    <h5>Total Rate</h5>
                    <p>187% <span class="up"><small>+77% vs last month</small></span></p>
                </div>
            </div>

            <div class="table-box">
                <h4>Puregold Stores Distribution</h4>
                <div class="reports-flex">
                    <div id="chartdiv"></div>
                    <div id="chartlegend"></div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
