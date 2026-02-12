<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user'])) {
    header("Location: /user-side/pages/login/login.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

.card{
    background:#3b82f6;
    color:white;
    padding:25px 20px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 6px 20px rgba(0,0,0,0.1);
    transition:0.3s;
    position:relative;
}

.card i{
    position:absolute;
    top:15px;
    right:15px;
    font-size:24px;
    opacity:0.3;
}

.card:hover{
    transform:translateY(-5px);
}

.card h3{
    font-size:14px;
    font-weight:500;
    margin-bottom:10px;
}

.card p{
    font-size:26px;
    font-weight:600;
}

/* PROGRESS */
.progress-box{
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 6px 20px rgba(0,0,0,0.05);
    margin-bottom:40px;
}

.progress-box small{
    display:block;
    margin-bottom:10px;
    color:#555;
}

.progress{
    background:#e0e0e0;
    border-radius:20px;
    overflow:hidden;
    height:20px;
    margin-bottom:10px;
}

.bar{
    background:#000;
    width:40%;
    height:100%;
    transition:width 1s ease-in-out;
}

.progress-labels{
    display:flex ;
    justify-content:space-between;
    font-size:0.9rem;
    color:#555;
}

/* BADGE */
.badge{
    background:yellow;
    color:#000;
    font-weight:600;
    padding:3px 10px;
    border-radius:12px;
    font-size:0.8rem;
    margin-left:10px;
}

/* TABLE */
.table-box{
    background:#fff;
    padding:20px;
    border-radius:15px;
    box-shadow:0 6px 20px rgba(0,0,0,0.05);
}

.table-box h4{
    margin-bottom:15px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:12px 10px;
    border-bottom:1px solid #e0e0e0;
    text-align:left;
}

th{
    color:#555;
    font-weight:600;
}

.green{color:green; font-weight:600;}
.red{color:red; font-weight:600;}

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
            <h2>PixelBloom<br>Studios</h2>

            <a href="#" id="dashboardLink"><i class="fas fa-home"></i>Dashboard</a>         
            <a href="#" id="earnPointsLink"><i class="fas fa-gift"></i>Earn Points</a>
            <a href="#" id="rewardsLink"><i class="fas fa-star"></i>Rewards</a>
            <a href="#"><i class="fas fa-exchange-alt"></i>Transactions</a>
            <a href="#"><i class="fas fa-user"></i>Profile</a>
        </div>

        <a class="logout" href="/user-side/pages/login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- DASHBOARD CONTENT -->
        <div id="dashboardContent">
            <div class="top">
                <div>
                    <h2>Welcome Back, <?php echo htmlspecialchars($_SESSION['user']); ?>
                        <span class="badge">GOLD ⭐</span>
                    </h2>
                    <small>Keep earning points to reach PLATINUM!</small>
                </div>

                <div class="search">
                    <input type="text" placeholder="Search...">
                </div>
            </div>

            <div class="cards">
                <div class="card">
                    <h3>Total Points</h3>
                    <p>1,256</p>
                    <i class="fas fa-coins"></i>
                </div>

                <div class="card">
                    <h3>Rewards Redeemed</h3>
                    <p>10</p>
                    <i class="fas fa-gift"></i>
                </div>

                <div class="card">
                    <h3>Vouchers</h3>
                    <p>2</p>
                    <i class="fas fa-ticket-alt"></i>
                </div>
            </div>

            <div class="progress-box">
                <small>Earn 1,744 more points to reach PLATINUM</small>
                <div class="progress">
                    <div class="bar" id="progressBar"></div>
                </div>
                <div class="progress-labels">
                    <span>GOLD</span>
                    <span>PLATINUM</span>
                </div>
            </div>

            <div class="table-box">
                <h4>Recent Activity</h4>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Points</th>
                    </tr>
                    <tr>
                        <td>Feb 11, 2026</td>
                        <td>Redeemed Voucher</td>
                        <td class="green">+250</td>
                    </tr>
                    <tr>
                        <td>Feb 09, 2026</td>
                        <td>Earned Points from Purchase</td>
                        <td class="green">+500</td>
                    </tr>
                    <tr>
                        <td>Feb 07, 2026</td>
                        <td>Redeemed Reward</td>
                        <td class="red">-100</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- EARN POINTS CONTENT -->
        <div id="earnPointsContent" style="display:none;">
            <div class="top">
                <div>
                    <h2>Earn Points
                        <span class="badge">GOLD ⭐</span>
                    </h2>
                    <small>Complete actions to earn more points!</small>
                </div>

                <div class="search">
                    <input type="text" placeholder="Search...">
                </div>
            </div>

            <div class="cards">
                <div class="card">
                    <h3>Daily Login</h3>
                    <p>5 days Streak</p>
                    <i class="fas fa-calendar-check"></i>
                </div>

                <div class="card">
                    <h3>Purchase Product</h3>
                    <p>+200 Points</p>
                    <i class="fas fa-shopping-cart"></i>
                </div>

                <div class="card">
                    <h3>Refer a Friend</h3>
                    <p>+100 Points</p>
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>

            <div class="progress-box">
                <small>You have earned 500 points this month!</small>
                <div class="progress">
                    <div class="bar" id="earnPointsProgressBar" style="width:38%;"></div>
                </div>
                <div class="progress-labels">
                    <span>500</span>
                    <span>1,500</span>
                </div>
            </div>

            <div class="table-box">
                <h4>Recent Actions</h4>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Action</th>
                        <th>Points</th>
                    </tr>
                    <tr>
                        <td>Feb 10, 2026</td>
                        <td>Purchased Product</td>
                        <td class="green">+200</td>
                    </tr>
                    <tr>
                        <td>Feb 09, 2026</td>
                        <td>Referred a Friend</td>
                        <td class="green">+100</td>
                    </tr>
                    <tr>
                        <td>Feb 08, 2026</td>
                        <td>Feedback Survey</td>
                        <td class="green">+30</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- REWARDS CONTENT -->
        <div id="rewardsContent" style="display:none;">
            <div class="top">
                <div>
                    <h2>Rewards, <?php echo htmlspecialchars($_SESSION['user']); ?>
                        <span class="badge">GOLD ⭐</span>
                    </h2>
                    <small>Check your rewards and vouchers!</small>
                </div>
            </div>

            <div class="cards">
                <div class="card">
                    <h3>Available Rewards</h3>
                    <p>5</p>
                    <i class="fas fa-gift"></i>
                </div>

                <div class="card">
                    <h3>Redeemed Rewards</h3>
                    <p>10</p>
                    <i class="fas fa-check-circle"></i>
                </div>

                <div class="card">
                    <h3>Vouchers</h3>
                    <p>2</p>
                    <i class="fas fa-ticket-alt"></i>
                </div>
            </div>

            <div class="table-box">
                <h4>Recent Reward Activity</h4>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Reward</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>Feb 11, 2026</td>
                        <td>Free Coffee</td>
                        <td class="green">Redeemed</td>
                    </tr>
                    <tr>
                        <td>Feb 09, 2026</td>
                        <td>Discount Voucher</td>
                        <td class="green">Redeemed</td>
                    </tr>
                    <tr>
                        <td>Feb 07, 2026</td>
                        <td>Gift Card</td>
                        <td class="red">Pending</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="dashboard.js"></script>
</body>
</html>
