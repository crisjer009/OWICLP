<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /user-side/pages/login/login.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, sans-serif;
}

body{
    background:#f3f3f3;
}

.wrapper{
    display:flex;
    height:100vh;
}

/* SIDEBAR */
.sidebar{
    width:240px;
    background:#004fa3;
    color:#fff;
    padding:50px;
}

.sidebar h2{
    text-align:center;
    margin-bottom:50px;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:25px;
    color:black;
    padding:10px 14px;
    margin:6px 0;
    text-decoration:none;
    border-radius:150px;
    transition:.2s;
}

.sidebar a:hover{
    background:rgb(255, 253, 253);
}

.logout{
    margin-top:40px;
    background:#022f5c;
}

/* MAIN */
.main{
    flex:1;
    padding:55px;
    background:#fff;
}

/* TOP */
.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.search input{
    padding:8px 14px;
    width:240px;
    border-radius:20px;
    border:1px solid #ccc;
}

.cards{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin:25px 0;
}

.card{
    background:#004fa3;
    color:white;
    padding:35px;
    border-radius:10px;
}

.card h3{
    font-size:14px;
    font-weight:500;
}

.card p{
    font-size:26px;
    margin-top:10px;
}

/* PROGRESS */
.progress-box{
    margin:20px 0;
}

.progress{
    background-color: #ccc;
    border-radius:20px;
    overflow:hidden;
    height:25px;
}

.bar{
    background:black;
    width:40%;
    height:100%;
}

/* TABLE */
.table-box{
    background:#f6f6f6;
    padding:20px;
    border-radius:10px;
    margin-top:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:12px;
    border-bottom:1px solid #ccc;
    text-align:left;
}

.green{color:green;}
.red{color:red;}
</style>
</head>

<body>
<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>PixelBloom<br>Studios</h2>

        <a href="#">Dashboard</a>
        <a href="#">Earn Points</a>
        <a href="#">Rewards</a>
        <a href="#">Transactions</a>
        <a href="#">Profile</a>

        <a class="logout" href="/user-side/pages/login/logout.php"> Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="top">
            <div>
                <h2>Welcome Back (<?php echo $_SESSION['user']; ?>)</h2>
                <small>Member Level: GOLD ⭐</small>
            </div>

            <div class="search">
                <input type="text" placeholder="Search...">
            </div>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Total Points</h3>
                <p>1,256</p>
            </div>

            <div class="card">
                <h3>Rewards Redeemed</h3>
                <p>10</p>
            </div>

            <div class="card">
                <h3>Vouchers</h3>
                <p>#</p>
            </div>
        </div>

        <div class="progress-box">
            <small>Earn 1,744 more points</small>
            <div class="progress">
                <div class="bar"></div>
            </div>
            <div style="display:flex;justify-content:space-between;margin-top:10px;">
                <small>GOLD</small>
                <small>PLATINUM</small>
            </div>
        </div>

        <h3>PRODUCTS</h3>
        <small>Subheading</small>

        <div class="table-box">
            <h4>RECENT ACTIVITY</h4>

            <table>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Points</th>
                </tr>
                <tr>
                    <td>Feb 11 2026</td>
                    <td>Redeemed Voucher</td>
                    <td class="green">+250</td>
                </tr>
            </table>
        </div>

    </div>

</div>
</body>
</html>
