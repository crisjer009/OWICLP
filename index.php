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
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #2a254a, #4a4444);
    padding: 40px 20px;
}

.wrapper {
    width: 100%;
    max-width: 1200px;
}

.page-title {
    font-size: 3rem;
    color: #ffffff;
    margin-bottom: 80px;
    text-align: center;
    font-weight: 200; 
    letter-spacing: 4px;
    text-transform: uppercase;
}

.systems {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 40px;
    flex-wrap: wrap;
}

.system-card {
    background: #10121688;
    width: 320px;
    height: 320px;
    border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; /* Organic shape */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    box-shadow: 20px 20px 60px rgba(0, 0, 0, 0.3), 
                -20px -20px 60px rgba(255, 255, 255, 0.02);
}



.system-card:hover {
    border-radius: 50%; 
    transform: translateY(-10px) scale(1.05);
    background: #101216ee;
    box-shadow: 0 0 50px rgba(255, 255, 255, 0.1);
}

.system-card h2 {
    font-size: 20px;
    color: #ffffff;
    margin-bottom: 20px;
    font-weight: 400;
    text-align: center;
}

.btn {
    text-decoration: none;
    padding: 10px 25px;
    border: 1px solid #ffffff;
    color: #ffffff;
    border-radius: 0; 
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    transition: all 0.3s ease;
}

.btn:hover {
    background: #ffffff;
    color: #332d57;
    padding: 10px 40px; 
}

/* TABLET RESPONSIVE */
@media (max-width: 1024px) {

    .page-title {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .systems {
        display: flex;
        flex-direction: column; /* stack cards vertically */
        gap: 15px;
        align-items: stretch; /* make cards full width */
    }

    .system-card {
        width: 100%;          /* full width of container */
        max-width: 100%;
        height: auto;         /* height adjusts to content */
        padding: 20px;
        background: #10121688;
        border-radius: 18px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .system-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .system-card h2 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .btn {
        padding: 10px 25px;
        font-size: 16px;
        align-self: flex-start;
    }
}

/* MOBILE RESPONSIVE */
@media (max-width: 500px) {

    body {
        padding: 15px;
    }

    .page-title {
        font-size: 20px;
        margin-bottom: 20px;
    }

    .systems {
        display: flex;
        flex-direction: column; /* vertical list */
        gap: 15px;
    }

    .system-card {
        width: 100%;         /* full width for list */
        max-width: 100%;
        padding: 15px;
        background: #10121688;
        border-radius: 18px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .system-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.3);
    }

    .system-card h2 {
        font-size: 16px;
        margin-bottom: 8px;
    }

    .btn {
        padding: 8px 20px;
        font-size: 14px;
        align-self: flex-start;
    }
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





