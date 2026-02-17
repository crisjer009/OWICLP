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
    background: linear-gradient(135deg, rgb(2, 0, 36), #4b4a4af6);
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
    color:#fff;
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
    background: #000;;
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
    background: linear-gradient(135deg, rgb(2, 0, 36), #4b4a4af6);
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
    color: #ffffff;;
}

.top small{
    color: #ffffff;;
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
    background:#190f0f;
    color:white;
    padding:25px 20px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 6px 20px rgba(32, 30, 30, 0.1);
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


/* CC style */
.main-card{
    width: 100%;
    max-width: 380px;
    aspect-ratio: 1.7 / 1; /* perfect credit card ratio */
    
    background: linear-gradient(135deg, #111, #2c2c2c);
    color: white;
    padding: 25px;
    border-radius: 18px;
    margin-bottom: 25px;
    border: 1px solid rgba(255,255,255,0.15);
    box-shadow: 0 15px 35px rgba(0,0,0,0.4);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}


/* wifi logo */
.card-top{
    display:flex;
    justify-content:flex-end;
    font-size:22px;
    opacity:0.8;
}

/* CARD NUMBER */
.card-number{
    font-size:22px;
    letter-spacing:4px;
    font-weight:500;
    margin:20px 0;
}

/* BOTTOM */
.card-bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.card-holder small{
    font-size:12px;
    opacity:0.7;
}

.card-holder p{
    margin-top:3px;
    font-weight:600;
    font-size:14px;
}

/* CARD LOGO */
.mastercard-logo{
    position:relative;
    width:50px;
    height:30px;
}

.circle{
    width:28px;
    height:28px;
    border-radius:50%;
    position:absolute;
}

.circle.red{
    background:#eb001b;
    left:0;
}

.circle.yellow{
    background:#f79e1b;
    right:0;
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
.transactions-wrapper{
    display:grid;
    grid-template-columns: 2fr 1fr;
    gap:30px;
}



/* RECENT BOX */
.recent-box{
    background:#fff;
    padding:20px;
    border-radius:20px;
    box-shadow:0 6px 20px rgba(0,0,0,0.05);
}

.recent-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
}

.transaction-item{
    display:flex;
    justify-content:space-between;
    padding:12px 0;
    border-bottom:1px solid #eee;
}

.transaction-item:last-child{
    border:none;
}

/* UPCOMING */
.upcoming-box{
    background:#fff;
    padding:20px;
    border-radius:20px;
    box-shadow:0 6px 20px rgba(0,0,0,0.05);
}

.payment-card{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 0;
    border-bottom:1px solid #eee;
}

.payment-card:last-child{
    border:none;
}

.icon{
    width:40px;
    height:40px;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    margin-right:10px;
}

.orange-bg{
    background:orange;
}

.blue-bg{
    background:#3b82f6;
}

/* Colors of right icons */
.orange-bg {
    background: linear-gradient(135deg, #ff7a18, #ffb347);
    color: #fff;
}

.red-bg {
    background: linear-gradient(135deg, #ff416c, #ff4b2b);
    color: #fff;
}

.purple-bg {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff;
}



/* BADGES (Bronze,Silver,Gold and Platinum) */
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
            <h2>Office<br>Warehouse</h2>

            <a href="#" id="dashboardLink"><i class="fas fa-home"></i>Dashboard</a>         
            <a href="#" id="earnPointsLink"><i class="fas fa-gift"></i>Earn Points</a>
            <a href="#" id="rewardsLink"><i class="fas fa-star"></i>Rewards</a>
            <a href="#" id="transactionsLink"><i class="fas fa-exchange-alt"></i>Transactions</a>
            <a href="#" id="profileLink"><i class="fas fa-user"></i>Profile</a>
        </div>

        <a class="logout" href="/user-side/pages/login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

  <!-- MAIN CONTAINER -->
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

    <!-- TRANSACTIONS SECTION -->
    <div id="transactionsContent" style="display:none;">
        <div class="transactions-wrapper">

            <!-- LEFT SIDE -->
            <div class="left-section">
                <div class="main-card">
                    <div class="card-top"><i class="fas fa-wifi"></i></div>
                    <div class="card-number">4562 1122 4595 7852</div>
                    <div class="card-bottom">
                        <div class="card-holder">
                            <small>Loyalty Member</small>
                            <p><?php echo htmlspecialchars($_SESSION['user']); ?></p>
                        </div>
                        <div class="mastercard-logo">
                            <div class="circle red"></div>
                            <div class="circle yellow"></div>
                        </div>
                    </div>
                </div>

                <div class="recent-box">
                    <div class="recent-header">
                        <h4>Recent Transactions</h4>
                        <span>Recent</span>
                    </div>

                    <div class="transaction-item">
                        <div>
                            <strong>Voucher</strong>
                            <small>Feb 5, 2026</small>
                        </div>
                        <span class="red">-50</span>
                    </div>

                    <div class="transaction-item">
                        <div>
                            <strong>Purchasing Milk</strong>
                            <small>Feb 4, 2026</small>
                        </div>
                        <span class="red">-20</span>
                    </div>

                    <div class="transaction-item">
                        <div>
                            <strong>Freelance Payment</strong>
                            <small>Feb 09, 2026</small>
                        </div>
                        <span class="green">+500</span>
                    </div>
                </div>
            </div>

           <!-- RIGHT SIDE (the promos) -->
<div class="right-section">
    <div class="upcoming-box">
        <h4>Upcoming Promos</h4>

        <!-- Promo 1 -->
        <div class="payment-card">
            <div class="icon orange-bg">
                <i class="fas fa-gift"></i>
            </div>
            <div>
                <strong>Double Points Weekend</strong>
                <p>Feb 20-22</p>
            </div>
                <span>2x Points</span>
        </div>

        <!-- Promo 2 -->
        <div class="payment-card">
            <div class="icon red-bg">
                <i class="fas fa-tags"></i>
            </div>
            <div>
                <strong>Buy 1 Get 1 Free: Get It Now!</strong>
                <p>Selected Items Only</p>            
            </div>
            <span>March</span>
        </div>

        <!-- Promo 3 -->
        <div class="payment-card">
            <div class="icon purple-bg">
                <i class="fas fa-fire"></i>
            </div>
            <div>
                <strong>Flash Sale Friday</strong>
                <p>March 1</p>
            </div>
            <span>Buy Now!</span>
        </div>

    </div>
</div>
        

        </div> 
    </div> 
        
</div>         
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="dashboard.js"></script>
</body>
</html>
