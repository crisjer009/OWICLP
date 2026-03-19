<!-- <?php
// Removed session restriction and login check
$user = "Guest"; // placeholder username
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard- User Side</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

.main{
    flex:1;
    padding:50px;
    background: linear-gradient(135deg, rgb(2, 0, 36), #4b4a4af6);
}

.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    margin-bottom:30px;
}

.notifications {
    background: #fff9c4;
    border-left: 5px solid #fbc02d;
    padding: 10px 15px;
    margin: 15px 0;
    border-radius: 5px;
}

.notifications h4 {
    margin-bottom: 8px;
    font-size: 16px;
    color: #333;
}

.notifications ul {
    list-style: disc inside;
    padding-left: 0;
}

.notifications li {
    margin-bottom: 5px;
    font-size: 14px;
    color: #555;
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


.card-top{
    display:flex;
    justify-content:flex-end;
    font-size:22px;
    opacity:0.8;
}

.card-number{
    font-size:22px;
    letter-spacing:4px;
    font-weight:500;
    margin:20px 0;
}

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



.badge{
    background:yellow;
    color:#000;
    font-weight:600;
    padding:3px 10px;
    border-radius:12px;
    font-size:0.8rem;
    margin-left:10px;
}

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

<div class="main">

    <div id="dashboardContent">
        <div class="top">
            <div>
        <h2>Welcome Back, <?php echo htmlspecialchars($user); ?></h2>
            <span class="badge">GOLD ⭐</span>
                </h2>
                <small>Keep earning points to reach PLATINUM!</small>
            </div>
            <div class="search">
                <input type="text" placeholder="Search...">
            </div>
        </div>



    <div class="notifications">
        <h4>Notifications</h4>
        <ul>
            <li>You earned 200 points from your last purchase!</li>
            <li>Your voucher expires in 5 days!</li>
            <li>New reward available: "Free 50% Voucher"</li>
        </ul>
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

    <div id="rewardsContent" style="display:none;">
        <div class="top">
            <div>
        <h2>Rewards, <?php echo htmlspecialchars($user); ?></h2>            
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

    <div id="transactionsContent" style="display:none;">
        <div class="transactions-wrapper">

            <div class="left-section">
                <div class="main-card">
                    <div class="card-top"><i class="fas fa-wifi"></i></div>
                    <div class="card-number">4562 1122 4595 7852</div>
                    <div class="card-bottom">
                        <div class="card-holder">
                            <small>Loyalty Member</small>
        <p><?php echo htmlspecialchars($user); ?></p>               
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

<div class="right-section">
    <div class="upcoming-box">
        <h4>Upcoming Promos</h4>

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
 -->


 <?php
// Removed session restriction and login check
$user = "Guest"; // placeholder username
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard- User Side</title>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root {
    --primary: #6366f1;
    --secondary: #4f46e5;
    --bg-dark: #0f172a;
    --card-bg: rgba(30, 41, 59, 0.7);
    --sidebar-bg: #1e293b;
    --text-main: #f8fafc;
    --text-dim: #94a3b8;
    --accent-gold: #fbbf24;
    --glass-border: rgba(255, 255, 255, 0.1);
    --danger: #ef4444;
    --success: #10b981;
}

* {
    margin: 0; padding: 0; box-sizing: border-box;
    font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
}

body {
    background-color: var(--bg-dark);
    background-image: radial-gradient(circle at top right, #1e1b4b, var(--bg-dark));
    color: var(--text-main);
    min-height: 100vh;
}

.wrapper { display: flex; min-height: 100vh; }

/* --- SIDEBAR --- */
.sidebar {
    width: 280px;
    background: var(--sidebar-bg);
    border-right: 1px solid var(--glass-border);
    display: flex;
    flex-direction: column;
    padding: 30px 20px;
    position: sticky;
    top: 0;
    height: 100vh;
}

.sidebar h2 {
    font-size: 1.5rem;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 40px;
    padding-left: 15px;
    line-height: 1.2;
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--text-dim);
    padding: 14px 18px;
    text-decoration: none;
    border-radius: 12px;
    transition: 0.3s;
    margin-bottom: 8px;
    font-weight: 500;
}

.sidebar a i { width: 20px; text-align: center; }

.sidebar a:hover, .sidebar a.active {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.logout {
    margin-top: auto;
    border-top: 1px solid var(--glass-border);
    padding-top: 20px;
    color: var(--danger) !important;
}

/* --- MAIN CONTENT --- */
.main { flex: 1; padding: 40px; overflow-y: auto; }

.top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

        /* Container for Search + Bell */
.top-actions {
    display: flex;
    align-items: center;
    gap: 20px;
    position: relative;
}

.top h2 { font-size: 1.8rem; display: flex; align-items: center; gap: 10px; }
.top small { color: var(--text-dim); display: block; margin-top: 5px; }

.badge {
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
    color: #000;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 800;
}

    /* --- SEARCH --- */
    .search input {
        background: var(--sidebar-bg);
        border: 1px solid var(--glass-border);
        padding: 12px 20px;
        border-radius: 50px;
        color: white;
        outline: none;
        width: 250px;
        transition: 0.3s;
    }

    .search input:focus { border-color: var(--primary); width: 300px; }

    /* Bell/ .notifications Icon Styling */
.notif-wrapper {
    position: relative; /* Anchor for the dropdown */
    cursor: pointer;
    padding: 10px;
}

.bell-icon {
    font-size: 1.4rem;
    color: var(--text-dim);
    transition: 0.3s;
    position: relative;
}

.bell-icon:hover {
    color: var(--accent-gold);
    transform: rotate(15deg);
}

/* Red counter dot */
.notif-dot {
    position: absolute;
    top: -2px;
    right: -2px;
    width: 10px;
    height: 10px;
    background: #ef4444;
    border: 2px solid var(--bg-dark);
    border-radius: 50%;
}

/* --- THE DROPDOWN LOGIC --- */
.notifications {
    position: absolute;
    top: 50px; 
    right: 0;
    width: 320px;
    background: var(--sidebar-bg); 
    backdrop-filter: blur(15px);
    border: 1px solid var(--glass-border);
    border-top: 3px solid var(--accent-gold);
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
    z-index: 100;
    
    /* Hidden by default */
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

/* Show on Hover */
.notif-wrapper:hover .notifications {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* content inside the dropdown */
.notifications h4 { 
    color: var(--accent-gold); 
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 12px; 
    border-bottom: 1px solid var(--glass-border);
    padding-bottom: 10px;
}

.notifications ul { list-style: none; }

.notifications li { 
    font-size: 0.85rem; 
    padding: 10px 0;
    color: var(--text-main); 
    border-bottom: 1px solid rgba(255,255,255,0.05);
    transition: 0.2s;
}

.notifications li:hover {
    padding-left: 5px;
    color: var(--primary);
}

.notifications li:last-child { border: none; }

/* --- STAT CARDS --- */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.card {
    background: var(--card-bg);
    backdrop-filter: blur(10px);
    padding: 30px;
    border-radius: 24px;
    border: 1px solid var(--glass-border);
    position: relative;
    transition: 0.3s;
}

.card:hover { transform: translateY(-5px); border-color: var(--primary); }

.card i {
    position: absolute;
    top: 20px; right: 20px;
    font-size: 1.5rem;
    color: var(--primary);
    opacity: 0.5;
}

.card h3 { color: var(--text-dim); font-size: 0.9rem; margin-bottom: 10px; }
.card p { font-size: 2rem; font-weight: 700; }

/* --- PROGRESS --- */
.progress-box {
    background: var(--card-bg);
    padding: 30px;
    border-radius: 24px;
    margin-bottom: 40px;
    border: 1px solid var(--glass-border);
}

.progress {
    background: #334155;
    height: 12px;
    border-radius: 10px;
    margin: 15px 0;
    overflow: hidden;
}

.bar {
    background: linear-gradient(90deg, var(--primary), #818cf8);
    height: 100%;
    width: 42%; /* This matches your logic */
    box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
}

.progress-labels { display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--text-dim); }

/* --- TABLES --- */
.table-box {
    background: var(--card-bg);
    border-radius: 24px;
    padding: 30px;
    border: 1px solid var(--glass-border);
}

table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th { text-align: left; color: var(--text-dim); padding-bottom: 15px; border-bottom: 1px solid var(--glass-border); }
td { padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }

.green { color: var(--success); font-weight: 600; }
.red { color: var(--danger); font-weight: 600; }

/* --- TRANSACTIONS & PROMOS OVERHAUL --- */
.transactions-wrapper { 
    display: grid; 
    grid-template-columns: 1.6fr 1fr; 
    gap: 30px; 
    align-items: start;
}

/* PREMIUM LOYALTY CARD */
.main-card {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    padding: 35px;
    border-radius: 24px;
    margin-bottom: 30px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
    position: relative;
    overflow: hidden;
    transition: transform 0.4s ease;
}

.main-card:hover {
    transform: translateY(-5px) rotateX(2deg);
}

/* Holographic Shine Effect */
.main-card::after {
    content: '';
    position: absolute;
    top: -50%; left: -50%;
    width: 200%; height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.03), transparent);
    transform: rotate(45deg);
    pointer-events: none;
}

.card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.card-top i {
    font-size: 1.5rem;
    color: var(--text-dim);
    opacity: 0.6;
}

.card-number { 
    font-size: 1.6rem; 
    letter-spacing: 4px; 
    margin: 30px 0; 
    font-family: 'Share Tech Mono', monospace; 
    color: #fff;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.card-bottom {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}

.card-holder small {
    text-transform: uppercase;
    letter-spacing: 2px;
    font-size: 0.7rem;
    color: var(--text-dim);
}

.card-holder p {
    font-size: 1.1rem;
    font-weight: 600;
    margin-top: 5px;
    color: #fff;
}

.mastercard-logo { display: flex; align-items: center; }
.circle { width: 35px; height: 35px; border-radius: 50%; filter: blur(0.5px); }
.circle.red { background: rgba(235, 0, 27, 0.9); margin-right: -15px; }
.circle.yellow { background: rgba(247, 158, 27, 0.9); }

/* RECENT TRANSACTIONS BOX */
.recent-box {
    background: var(--card-bg);
    border-radius: 24px;
    padding: 25px;
    border: 1px solid var(--glass-border);
}

.recent-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.recent-header h4 { font-size: 1.1rem; }
.recent-header span { 
    font-size: 0.8rem; 
    background: var(--sidebar-bg); 
    padding: 4px 12px; 
    border-radius: 12px;
    color: var(--text-dim);
}

.transaction-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 12px;
    border-radius: 16px;
    transition: 0.3s;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.transaction-item:hover {
    background: rgba(255, 255, 255, 0.03);
}

.transaction-item strong { display: block; font-size: 0.95rem; margin-bottom: 4px; }
.transaction-item small { color: var(--text-dim); font-size: 0.8rem; }
.transaction-item span { font-weight: 700; font-size: 1rem; }

/* UPCOMING PROMOS */
.upcoming-box {
    background: var(--card-bg);
    padding: 30px;
    border-radius: 28px;
    border: 1px solid var(--glass-border);
    height: 100%;
}

.upcoming-box h4 { margin-bottom: 25px; letter-spacing: 1px; }

.payment-card {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 20px;
    border-radius: 20px;
    margin-bottom: 15px;
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid transparent;
    transition: 0.3s;
}

.payment-card:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: var(--glass-border);
}

.payment-card .icon {
    width: 50px;
    height: 50px;
    border-radius: 15px;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.payment-card div { flex: 1; }
.payment-card strong { font-size: 0.9rem; line-height: 1.3; display: block; }
.payment-card p { font-size: 0.75rem; color: var(--text-dim); margin-top: 4px; }
.payment-card span { 
    font-size: 0.7rem; 
    font-weight: 800; 
    text-transform: uppercase;
    color: var(--primary);
    background: rgba(99, 102, 241, 0.1);
    padding: 4px 10px;
    border-radius: 8px;
}

/* PROMO COLORS */
.orange-bg { background: linear-gradient(135deg, #ff9d00, #ff6a00); color: #fff; box-shadow: 0 10px 20px -5px rgba(255, 106, 0, 0.3); }
.red-bg { background: linear-gradient(135deg, #ff4b2b, #ff416c); color: #fff; box-shadow: 0 10px 20px -5px rgba(255, 75, 43, 0.3); }
.purple-bg { background: linear-gradient(135deg, #a855f7, #6366f1); color: #fff; box-shadow: 0 10px 20px -5px rgba(168, 85, 247, 0.3); }
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

        <a class="logout" href="/user-side/pages/login/login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

  <!-- MAIN CONTAINER -->
<div class="main">

    <!-- DASHBOARD CONTENT -->
    <div id="dashboardContent">
        <div class="top">
    <h2>Welcome Back, <?php echo htmlspecialchars($user); ?> <span class="badge">GOLD ⭐</span></h2>
    
    <div class="top-actions">
        <div class="search">
            <input type="text" placeholder="Search...">
        </div>

        <div class="notif-wrapper">
            <div class="bell-icon">
                <i class="fas fa-bell"></i>
                <span class="notif-dot"></span> </div>

            <div class="notifications">
                <h4>Notifications</h4>
                <ul>
                    <li>You earned 200 points!</li>
                    <li>Voucher expires in 5 days!</li>
                    <li>New reward available!</li>
                </ul>
            </div>
        </div>
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
        <h2>Rewards, <?php echo htmlspecialchars($user); ?></h2>            
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
    <section id="transactionsContent" class="content-section" style="display:none;">
            <div class="transactions-wrapper">
                <div class="left-section">
                    <div class="main-card">
                        <div class="card-top">
                            <i class="fas fa-wifi"></i>
                            <span class="card-label">Loyalty Pass</span>
                        </div>
                        <div class="card-number">4562 1122 4595 7852</div>
                        <div class="card-bottom">
                            <div class="card-holder">
                                <small>Member Name</small>
                                <p><?php echo htmlspecialchars($user); ?></p> 
                            </div>
                            <div class="mastercard-logo">
                                <div class="circle red"></div>
                                <div class="circle yellow"></div>
                            </div>
                        </div>
                    </div>

                    <div class="recent-box">
                        <div class="recent-header">
                            <h4>Recent History</h4>
                            <span>Feb 2026</span>
                        </div>
                        <div class="transaction-item">
                            <div>
                                <strong>Voucher Redeemed</strong>
                                <small>Feb 5, 2026</small>
                            </div>
                            <span class="red">-50</span>
                        </div>
                        <div class="transaction-item">
                            <div>
                                <strong>Purchasing Goods</strong>
                                <small>Feb 4, 2026</small>
                            </div>
                            <span class="red">-20</span>
                        </div>
                        <div class="transaction-item">
                            <div>
                                <strong>Purchase Bonus</strong>
                                <small>Feb 09, 2026</small>
                            </div>
                            <span class="green">+500</span>
                        </div>
                    </div>
                </div>

                <aside class="right-section">
                    <div class="upcoming-box">
                        <h4>Upcoming Promos</h4>
                        <div class="payment-card">
                            <div class="icon orange-bg"><i class="fas fa-gift"></i></div>
                            <div>
                                <strong>Double Points Weekend</strong>
                                <p>Feb 20-22</p>
                            </div>
                            <span>2x</span>
                        </div>
                        <div class="payment-card">
                            <div class="icon red-bg"><i class="fas fa-tags"></i></div>
                            <div>
                                <strong>Buy 1 Get 1 Free</strong>
                                <p>Selected Items</p> 
                            </div>
                            <span>New</span>
                        </div>
                        <div class="payment-card">
                            <div class="icon purple-bg"><i class="fas fa-fire"></i></div>
                            <div>
                                <strong>Flash Sale Friday</strong>
                                <p>March 1st</p>
                            </div>
                            <span>Hot</span>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

</div>
        

        </div> 
    </div> 
        
</div>         
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="dashboard.js"></script>
</body>
</html>
