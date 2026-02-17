<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Consignment Order Form System</title>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(#332d57, #817f7f33);
}

/* Wrapper */
.wrapper{
    width:90%;
    max-width:1000px;
    text-align:center;
}

.page-title{
    font-size:28px;
    margin-bottom:50px;
}

/* Systems container */
.systems{
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:20px;
}

/* Card design */
.system-card{
    flex:1 1 250px;
    min-width:250px;
    height:250px;
    background:#10121688;
    border-radius:25px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    transition: transform 0.4s, box-shadow 0.4s;
    cursor:pointer;
    
}

.system-card:hover{
    transform: translateY(-10px) scale(1.05) rotateZ(1deg);
}

.system-card h2{
    font-size:22px;
    color:#ffffff;
    margin-bottom:15px;
}

/* Icon */
.icon{
    font-size:50px;
    margin-bottom:15px;
}

/* Button */
.btn{
    padding:10px 25px;
    border:none;
    border-radius:25px;
    background: #333;
    color: #fff;
    font-weight:bold;
    cursor:pointer;
    transition: transform 0.3s, background 0.3s;
}

.btn:hover{
    transform: scale(1.1);
    background:#000000;
}
</style>
</head>
<body>

<div class="wrapper">
    <h1 class="page-title">Consignment Order Form System</h1>

    <div class="systems">

    <div class="system-card">
        <h2>Puregold System</h2>
        <a class="btn" href="/user-side/pages/login/login.php?system=puregold">Enter</a>
    </div>

    <div class="system-card">
        <h2>TNAP System</h2>
        <a class="btn" href="/user-side/pages/login/login.php?system=tnap">Enter</a>
    </div>

    <div class="system-card">
        <h2>Fishermall System</h2>
        <a class="btn" href="/user-side/pages/login/login.php?system=fishermall">Enter</a>
    </div>

</div>

</div>
        <script src="script.js"></script>
</body>
</html>





