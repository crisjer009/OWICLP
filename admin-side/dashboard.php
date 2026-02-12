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

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
/* RESET & FONT */
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

/* WRAPPER */
.wrapper{
    display:flex;
    min-height:100vh;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    background:#004a9b;
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
    line-height:1.2;
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
    background:#3b82f6;
}

.logout{
    margin-top:20px;
    background:#0b2545;
    text-align:center;
    padding:10px 0;
    border-radius:8px;
    font-weight:600;
}

/* MAIN CONTENT */
.main{
    flex:1;
    padding:50px;
    background:#f0f2f5;
}

/* TOP SECTION */
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
}

.top small{
    color:#555;
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

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
    gap:20px;
    margin-bottom:40px;
}

/* CARDS */
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
    transition:0.3s;
    position:relative;
    border:1px solid #e5e7eb;
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

.dashboard-left {
    flex: 2;
}

.dashboard-right {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* PAYMENT LIST (RIGHT SIDE) */
.payment-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.payment-list li {
    width:50%;
            padding:15px;
            background:#141618;
            color:#fff;
            font-weight:bold;
            border:none;
            border-radius:50px;
            cursor:pointer;
            transition:background 0.3s ease;
            margin:0 auto 15px;
            display:block;
}
            
        

.payment-list i {
    font-size: 20px;
    color: #3b82f6;
}

/* TABLE-BOX CARDS (CHARTS & TABLES) */
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

/* MAKE CHARTS RESPONSIVE */
.table-box canvas {
    width: 100% !important;
    height: auto !important;
    max-height: 300px; /* adjust if needed */
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

th {
    color: #555;
    font-weight: 600;
}

.green {
    color: green;
    font-weight: 600;
}

.red {
    color: red;
    font-weight: 600;
}


/* RESPONSIVE */
@media (max-width:900px){
    .wrapper{
        flex-direction:column;
    }
    .sidebar{
        width:100%;
        padding:20px;
        flex-direction:row;
        overflow-x:auto;
    }
    .sidebar a{
        margin:0 10px;
    }
    .main{
        padding:20px;
    }
}
</style>
</head>

<body>
<div class="wrapper">

    <!-- SIDEBAR -->
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

    <!-- MAIN -->
    <div class="main">

       <!-- DASHBOARD CONTENT -->
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

    <!-- NEW FLEX LAYOUT -->
    <div class="dashboard-layout">

        <!-- LEFT SIDE -->
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

        <!-- RIGHT SIDE -->
        <div class="dashboard-right">

            <!-- Yearly Sales -->
            <div class="table-box">
                <h4>Yearly Sales</h4>
                <canvas id="yearlySalesChart" height="200"></canvas>
            </div>

            <!-- Payment Gateway -->
            <div class="table-box">
                <h4>Payment Gateway</h4>
                <ul class="payment-list">
                    <li><i class="fab fa-visa"><i>Visa</button>
                    <li><i class="fab fa-paypal"></i> PayPal</li>
                </ul>
            </div>

        </div>

    </div>
</div>


        <!-- ADDITIONAL ADMIN SECTIONS -->
        <div id="usersContent" style="display:none;">
            <h2>Users Management</h2>
            <p>List all users, search, add or delete users here.</p>
        </div>

        <div id="pointsContent" style="display:none;">
            <h2>Points Management</h2>
            <p>Update, adjust, or monitor user points here.</p>
        </div>

        <div id="rewardsContent" style="display:none;">
            <h2>Rewards Management</h2>
            <p>Add new rewards or view redeemed rewards here.</p>
        </div>

        <div id="transactionsContent" style="display:none;">
            <h2>Transactions</h2>
            <p>View all points and reward transactions here.</p>
        </div>

        <div id="reportsContent" style="display:none;">
            <h2>Reports & Analytics</h2>
            <p>View charts, stats, and summaries here.</p>
        </div>

        <div id="settingsContent" style="display:none;">
            <h2>Settings</h2>
            <p>Admin settings, roles, and permissions.</p>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="dashboard.js"></script>
</body>
</html>
