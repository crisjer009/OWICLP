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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="dashboard.js"></script>

<!-- <style>

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

.sidebar {
    width: 280px; /* Slightly wider for better breathing room */
    height: 100vh;
    background: #0f172a; /* Sleek Midnight Blue/Slate */
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
    text-align: left;
    padding-left: 15px;
    margin-bottom: 40px;
    font-size: 1.4rem;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #38bdf8; /* Modern Cyan accent */
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #94a3b8; /* Muted text for non-active links */
    padding: 14px 18px;
    margin: 4px 0;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 500;
}

/* Icon specific styling */
.sidebar a i {
    font-size: 1.1rem;
    width: 24px;
    transition: transform 0.3s;
}

/* Modern Hover: Slide effect + Glow */
.sidebar a:hover {
    background: rgba(56, 189, 248, 0.1); /* Light blue tint */
    color: #fff;
    transform: translateX(5px);
}

.sidebar a:hover i {
    color: #38bdf8;
    transform: scale(1.1);
}

/* Unique Active State (Add this class via JS to your current page) */
.sidebar a.active {
    background: #38bdf8;
    color: #0f172a;
    box-shadow: 0 4px 15px rgba(56, 189, 248, 0.4);
}

/* Floating Logout Button */
.logout {
    margin-top: auto; /* Pushes to bottom */
    background: rgba(239, 68, 68, 0.1); /* Soft red transparent */
    color: #ef4444 !important;
    border: 1px solid rgba(239, 68, 68, 0.2);
    justify-content: center;
}

.logout:hover {
    background: #ef4444 !important;
    color: white !important;
    transform: translateY(-2px);
}
.main{
    flex:1;
    padding:50px;
    background: #1e1924;
}


  /* top section */
  
.top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px; /* Adds space if items stack on mobile */
    flex-wrap: wrap;
    margin-bottom: 30px;
    padding: 10px 0;
}

/* Typography Improvements */
.top h2 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #ffffff;
    letter-spacing: -0.5px;
}

.top small {
    color: rgba(255, 255, 255, 0.7); /* Slightly transparent white for better hierarchy */
    font-size: 0.9rem;
}

/* Search Bar Styling */
.top .search input {
    background: rgba(255, 255, 255, 0.1); /* Subtle transparent background */
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 10px 20px;
    border-radius: 50px; /* Pill shape */
    color: white;
    width: 300px;
    transition: all 0.3s ease;
    outline: none;
}

.top .search input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.top .search input:focus {
    background: rgba(255, 255, 255, 0.2);
    border-color: #ffffff;
    width: 350px; /* Smoothly expands on focus */
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
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
    margin-bottom: 20px;
    color: #ffffff;
    font-size: 1.6rem;
}
#usersContent p {
    margin-bottom: 20px;
    color: #fffdfd;
    font-size: 0.95rem;
}

/* Search input */
#userSearch {
    border: 1px solid #ccc;
    border-radius: 20px;
    padding: 10px 15px;
    width: 50%;
    max-width: 400px;
    margin-bottom: 20px;
    transition: 0.3s;
}
#userSearch:focus {
    border-color: #030303;
    outline: none;
    box-shadow: 0 0 5px rgba(7, 7, 7, 0.5);
}

/* Users table */
#usersTable {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 5px 15px rgba(255, 255, 255, 0.26);
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
    gap: 30px;
    flex-wrap: wrap;
}

#chartdiv { width: 70%; height: 400px; }
#chartlegend { width: 20%; height: 400px; }

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
    .reports-flex { 
        flex-direction: column; 
    }
    #chartdiv, #chartlegend { 
        width: 100%; 
        height: 400px; }
    .wrapper { 
        flex-direction: column; 
    }
    .sidebar { 
        width: 100%; 
        padding:20px; 
        flex-direction: row; 
        overflow-x:auto; 
    }
    .sidebar a { 
        margin:0 10px;
     }
    .main { padding:20px; }
}
</style> -->

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
========================================================= */

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

/* Logout Button */
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
========================================================= */

.main {
    flex: 1;
    padding: 50px;
    background: #1e1924;
    margin-left: 280px; /* important for fixed sidebar */
}

/* =========================================================
           DASHBOARD - MAIN WRAPPER
        ========================================================= */
        #dashboardContent {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Basic Layout Structure */
        .dashboard-layout {
            display: grid;
            grid-template-columns: 3fr 1fr; /* 75% left, 25% right */
            gap: 20px;
        }

        /* =========================================================
           DASHBOARD - TOP BAR
        ========================================================= */
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
        ========================================================= */
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
            height: 140px; /* Reduced height to fit more content */
            position: relative;
            overflow: hidden;
            color: #333;
        }

        /* MINI CHART CONTAINERS */
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
        ========================================================= */
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
        ========================================================= */
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
        ========================================================= */
        .system-status {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            color: #333;
        }
        .system-status h4 { margin-top: 0; color: #333; margin-bottom: 20px; }

        /* Layout change for status items */
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
        
        /* Status colors */
        .status-ok { color: #16a34a; }
        .status-warn { color: #ca8a04; }
        .status-danger { color: #dc2626; }

/* =========================================================
   USERS MANAGEMENT SECTION
========================================================= */

#usersContent {
    padding: 30px;
    animation: fadeIn 0.3s ease;
    font-family: 'Segoe UI', sans-serif;
    background: #1a1c23;
    min-height: 100vh;
}

#usersContent h2 { font-size: 1.8rem; margin-bottom: 5px; color: #fff; }
#usersContent p { color: rgba(255, 255, 255, 0.7); margin-bottom: 25px; }

/* Branch Selector Styles */
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

/* Table Styles */
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

/* Modal Styles */
.modal {
    display: none; /* Hidden by default */
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

/* Modal Form Styles */
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
    box-sizing: border-box; /* Ensures padding doesn't affect width */
}

.detail-item input:focus, 
.detail-item select:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
}

/* Buttons */
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

/* Animations */
@keyframes fadeIn { 
    from { opacity: 0; transform: translateY(10px); } 
    to { opacity: 1; transform: translateY(0); } 
}

/* =========================================================
   REPORTS SECTION
========================================================= */

.modern-dashboard-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* 3 Column Grid */
    gap: 20px;
    padding: 10px;
}

/* Make Metrics Row take full width */
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
    border-radius: 16px; /* Smoother corners */
    box-shadow: 0 10px 20px rgba(0,0,0,0.03); /* Softer shadow */
    border: 1px solid #f0f0f0;
}

/* Box Styling */
.dashboard-box {
    background: #fff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.03);
    border: 1px solid #f0f0f0;
}

/* Grid Positioning */
.chart-box-large {
    grid-column: span 2; /* Distribution Chart takes 2/3 width */
}

.chart-box-small {
    grid-column: span 1; /* Sales vs Target takes 1/3 width */
}

.table-box-full {
    grid-column: 1 / -1; /* Table takes full width */
}

.box-title {
    margin-bottom: 20px;
    font-size: 1.1rem;
    color: #2c3e50;
    font-weight: 700;
}

/* Chart Stylings */
#chartdiv {
    width: 100%;
    /* Height is set inline in HTML for this example */
}

.chart-placeholder {
    height: 350px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border-radius: 12px;
}

/* Data Table Styling */
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

/* Trend Colors */
.trend.up { color: #2ecc71; }
.trend.down { color: #e74c3c; }

/* =========================================================
   RESPONSIVE DESIGN
========================================================= */

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

    <!-- Sidebar -->
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

    <!-- Main -->
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

        <!-- Point SECTIONS -->
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
