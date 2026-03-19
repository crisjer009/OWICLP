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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

        .dropdown-menu{
display:none;
flex-direction:column;
padding-left:15px;
}

.dropdown-menu a{
padding:8px 0;
font-size:14px;
color:#cbd5f5;
}

.dropdown-menu a:hover{
color:#38bdf8;
}

.dropdown-icon{
margin-left:auto;
font-size:12px;
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




/* ==========================================================
   DASHBOARD & FILE MANAGER STYLING
   ========================================================== */

#dashboardContent {
    padding: 30px;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    color: #fff;
    display: flex;
    flex-direction: column;
    gap: 25px; /* Consistent vertical spacing */
}

/* --- TOP BAR (Glassmorphism) --- */
.top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(255, 255, 255, 0.05);
    padding: 20px 25px;
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 5px;
}

.top h2 {
    font-size: 22px;
    font-weight: 600;
    margin: 0;
    letter-spacing: -0.5px;
}

.top .search {
    position: relative;
    width: 300px;
}

.top .search input {
    width: 100%;
    padding: 10px 18px;
    background: rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 50px; /* Modern pill shape */
    color: white;
    font-size: 14px;
    transition: all 0.3s ease;
}

.top .search input:focus {
    outline: none;
    border-color: #38bdf8;
    background: rgba(0, 0, 0, 0.4);
    box-shadow: 0 0 15px rgba(56, 189, 248, 0.2);
    width: 320px;
}

/* --- DOCUMENTS SECTION WRAPPER --- */
.documents-section {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.documents-section h3 {
    margin: 0;
    font-size: 18px;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.documents-section small {
    color: #64748b;
    display: block;
    margin-bottom: 10px;
}

/* --- CONTENT CARDS (Stacked Layers) --- */
.content-card {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.01));
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.content-card:hover {
    border-color: rgba(56, 189, 248, 0.3);
    background: rgba(255, 255, 255, 0.04);
}

/* --- CARD HEADERS --- */
.card-header {
    padding: 18px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(255, 255, 255, 0.03);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.card-header h4 {
    margin: 0;
    font-size: 15px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 12px;
}

/* Section Identity Colors */
.card-header.recent h4 { color: #f472b6; }  /* Pink */
.card-header.shared h4 { color: #34d399; }  /* Green */
.card-header.personal h4 { color: #fbbf24; } /* Amber */

.count-badge {
    font-size: 11px;
    color: #94a3b8;
    background: rgba(255, 255, 255, 0.08);
    padding: 4px 12px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

/* --- FILE LISTS --- */
.file-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.file-list li {
    padding: 14px 25px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.2s ease;
}

.file-list li:hover {
    background: rgba(255, 255, 255, 0.03);
}

.file-list li:last-child {
    border-bottom: none;
}

.file-list li a {
    text-decoration: none;
    color: #cbd5e1;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.file-list li a i {
    width: 20px;
    text-align: center;
    font-size: 16px;
    opacity: 0.7;
}

.file-meta {
    font-size: 12px;
    color: #64748b;
    font-style: italic;
}

/* --- SHARED GRID VIEW --- */
.grid-view {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1px;
    background: rgba(255, 255, 255, 0.05); /* Divider lines */
}

.grid-view li {
    background: #111; /* Darker tile for grid view */
    border-bottom: none;
}

/* --- STORAGE SPLIT (Office vs Personal) --- */
.storage-split {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1px;
    background: rgba(255, 255, 255, 0.1); /* Visible center divider */
}

.storage-group {
    padding: 25px;
    background: rgba(0, 0, 0, 0.2);
}

.group-label {
    display: block;
    font-size: 11px;
    text-transform: uppercase;
    color: #38bdf8;
    font-weight: 800;
    margin-bottom: 15px;
    letter-spacing: 1.5px;
}

/* --- MOBILE RESPONSIVE --- */
@media (max-width: 768px) {
    .storage-split {
        grid-template-columns: 1fr;
    }
    .top {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    .top .search {
        width: 100%;
    }
    .top .search input:focus {
        width: 100%;
    }
}


/* ================= MY FOLDERS SECTION ================= */

#myFoldersContent {
    margin-top: 20px;
}

#myFoldersContent h3 {
    margin-bottom: 20px;
    font-size: 18px;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ================= CONTROLS ================= */

.folder-controls{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
    flex-wrap:wrap;
    gap:10px;
}

/* Add Folder Button */

.add-folder{
    background:#38bdf8;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    color:white;
    font-size:14px;
    cursor:pointer;
    transition:0.2s;
}

.add-folder:hover{
    background:#0ea5e9;
}

/* Layout Toggle */

.layout-toggle button{
    padding:7px 14px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    background:#64748b;
    color:white;
    margin-left:6px;
    font-size:13px;
}

.layout-toggle button:hover{
    background:#475569;
}

/* ================= FILTERS ================= */

.folder-filters{
    display:flex;
    gap:10px;
    margin-bottom:20px;
    flex-wrap:wrap;
    align-items:center;
}

.folder-filters select{
    padding:8px 12px;
    border-radius:6px;
    border:1px solid rgba(255,255,255,0.08);
    background:rgba(255,255,255,0.05);
    color:#e2e8f0;
    font-size:13px;
}

.folder-filters select:focus{
    outline:none;
    border-color:#38bdf8;
}

/* ================= FOLDER SEARCH ================= */

#folderSearch{
    padding:10px 14px 10px 36px;
    border-radius:8px;
    border:1px solid rgba(255,255,255,0.08);
    background:rgba(255,255,255,0.05);
    color:#e2e8f0;
    font-size:13px;
    width:220px;
    transition:all .25s ease;

    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%2394a3b8' viewBox='0 0 24 24'%3E%3Cpath d='M21 21l-4.3-4.3m1.3-5.2a7 7 0 11-14 0 7 7 0 0114 0z' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");

    background-repeat:no-repeat;
    background-size:16px;
    background-position:12px center;
}

#folderSearch::placeholder{
    color:#94a3b8;
}

#folderSearch:hover{
    border-color:rgba(56,189,248,0.4);
}

#folderSearch:focus{
    outline:none;
    border-color:#38bdf8;
    box-shadow:0 0 0 2px rgba(56,189,248,0.2);
    background:rgba(255,255,255,0.07);
}

/* ================= GRID LAYOUT ================= */

.my-folders-grid,
.folders-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:20px;
}

/* ================= FOLDER CARD ================= */

.folder-item{
    background:linear-gradient(145deg,rgba(255,255,255,0.05),rgba(255,255,255,0.01));
    border:1px solid rgba(255,255,255,0.08);
    border-radius:16px;
    padding:22px;
    display:flex;
    align-items:center;
    gap:15px;
    position:relative;
    cursor:pointer;
    transition:all .3s cubic-bezier(0.4,0,0.2,1);
}

.folder-item:hover{
    background:rgba(255,255,255,0.08);
    border-color:rgba(56,189,248,0.4);
    transform:translateY(-5px);
    box-shadow:0 12px 24px rgba(0,0,0,0.4);
}

/* ================= FOLDER ICON ================= */

.folder-icon{
    width:50px;
    height:50px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    flex-shrink:0;
}

/* Folder Type Colors */

.doc-color{
    background:rgba(56,189,248,0.15);
    color:#38bdf8;
}

.proj-color{
    background:rgba(168,85,247,0.15);
    color:#a855f7;
}

.arch-color{
    background:rgba(244,114,182,0.15);
    color:#f472b6;
}

/* ================= FOLDER INFO ================= */

.folder-info h4{
    margin:0;
    font-size:16px;
    font-weight:600;
    color:#f1f5f9;
}

.folder-info span{
    font-size:12px;
    color:#64748b;
    margin-top:4px;
    display:block;
}

.folder-info small{
    font-size:11px;
    color:#94a3b8;
    display:block;
}

/* ================= OPTIONS BUTTON ================= */

.folder-options{
    background:none;
    border:none;
    color:#475569;
    position:absolute;
    top:15px;
    right:15px;
    cursor:pointer;
    padding:5px;
    transition:color .2s ease;
}

.folder-options:hover{
    color:#ffffff;
}

/* ================= MODAL ================= */

.folder-modal{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    display:none;
    align-items:center;
    justify-content:center;
    z-index:999;
}

.modal-content{
    background:#0f172a;
    padding:25px;
    border-radius:12px;
    width:320px;
    box-shadow:0 10px 25px rgba(0,0,0,0.5);
}

.modal-content h3{
    margin-bottom:15px;
    color:#f1f5f9;
}

.modal-content input,
.modal-content select{
    width:100%;
    padding:10px;
    margin-bottom:12px;
    border-radius:6px;
    border:1px solid rgba(255,255,255,0.08);
    background:#020617;
    color:white;
}

/* Modal buttons */

.modal-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.modal-actions button{
    padding:8px 14px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.modal-actions button:first-child{
    background:#38bdf8;
    color:white;
}

.modal-actions button:last-child{
    background:#475569;
    color:white;
}

/* ================= LIST LAYOUT ================= */

.folders-list,
.my-folders-list{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.folders-list .folder-item,
.my-folders-list .folder-item{
    width:100%;
}

/* ================= RESPONSIVE ================= */

@media (max-width:768px){

    .folder-controls{
        flex-direction:column;
        align-items:flex-start;
    }

    .folder-filters{
        flex-direction:column;
    }

    #folderSearch{
        width:100%;
    }

}



/* ================= USER MANAGEMENT ================= */
.user-management {
    padding: 20px 40px; /* Wider padding for a breathable layout */
    background: transparent;
    color: #e2e8f0;
    font-family: 'Inter', sans-serif;
}

/* Header Section */
.user-management-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 50px; /* Increased margin for clear separation */
}

.user-management-header h2 {
    font-size: 14px; /* Slightly smaller, more professional heading */
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: rgba(241, 245, 249, 0.9);
    margin: 0;
}

/* Floating Action Button */
.btn-add {
    background: #38bdf8;
    color: #ffffff;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-add:hover {
    background: #0ea5e9;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(56, 189, 248, 0.3);
}

/* Minimalist Stats */
.stats-cards {
    display: flex;
    justify-content: center; /* Centers the stats like the image */
    align-items: center;
    gap: 100px;              
    margin: 40px 0 60px 0;
    padding: 20px 0;
}

.card {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: transparent; 
    border: none;            
}

.card span {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #cad3e0;        
    margin-bottom: 8px;
}

.card strong {
    display: block;
    font-size: 36px;
    font-weight: 700;
    margin-top: 8px;
    letter-spacing: -1px;
}

/* Stat Colors - Highlighting Active */
.card:nth-child(1) strong { color: rgba(255, 255, 255, 0.15); }
.card:nth-child(2) strong { color: #34d399; }
.card:nth-child(3) strong { color: rgba(255, 255, 255, 0.15); }

/* Integrated Table Controls */
.table-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.search-box {
    position: relative;
    width: 350px;
}

.search-box i {
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    color: #475569;
    font-size: 16px;
}

.search-box input {
    width: 100%;
    padding: 10px 10px 10px 30px;
    border: none;
    background: transparent;
    color: #f1f5f9;
    font-size: 14px;
    outline: none;
}

.search-box input::placeholder {
    color: #475569;
}

.filter-box select {
    background: transparent;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 13px;
    outline: none;
    text-align: right;
}

.filter-box select option {
    background: #0f172a; /* Match sidebar/dark background */
    color: white;
}

/* Clean Table Design */
.table-wrapper {
    width: 100%;
}

.user-table {
    width: 100%;
    border-collapse: collapse;
}

.user-table th {
    padding: 15px;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #64748b;
    text-align: left;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.user-table td {
    padding: 20px 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.02); /* Very subtle lines */
    color: #94a3b8;
    transition: background 0.2s;
}

.user-table tr:hover td {
    background: rgba(255, 255, 255, 0.02);
    color: #f1f5f9;
}

.user-name {
    font-weight: 600;
    color: #f1f5f9;
    display: block;
    font-size: 14px;
}

.user-email {
    font-size: 12px;
    color: #475569;
    margin-top: 2px;
}

/* Status Pill */
.status-pill.active {
    background: rgba(56, 189, 248, 0.1);
    color: #38bdf8;
    padding: 4px 12px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

/* Sleek Storage Bar */
.storage-bar {
    width: 120px;
    height: 4px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    margin-bottom: 6px;
    overflow: hidden;
}

.storage-bar .progress {
    height: 100%;
    background: #38bdf8;
    border-radius: 10px;
}

/* Action Icons */
.btn-icon {
    background: none;
    border: none;
    color: #475569;
    padding: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
    border-radius: 6px;
}

.btn-icon:hover {
    color: #f1f5f9;
    background: rgba(255, 255, 255, 0.05);
}

.btn-icon.text-danger:hover {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.1);
}

/* Responsive Fixes */
@media (max-width: 768px) {
    .stats-cards {
        gap: 30px;
        flex-wrap: wrap;
    }
    
    .user-management {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .user-management-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }
    
    .table-controls {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }
    
    .search-box {
        width: 100%;
    }
}

@media (max-width:480px){

    .folders-grid,
    .my-folders-grid{
        grid-template-columns:1fr;
    }

            
}

</style>
</head>

<body>

   <div class="wrapper">

    <!-- ================= SIDEBAR ================= -->
    <div class="sidebar">
        <div>

            <h2>FILE MANAGEMENT</h2>

            <!-- Dashboard -->
            <a href="#" id="dashboardLink">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            <!-- My Folders -->
            <a href="#" id="myFoldersLink">
                <i class="fas fa-folder"></i> My Folders
            </a>

            <!-- Department Folders -->
            <a href="#" id="departmentFoldersLink" class="dropdown-toggle">
                <i class="fas fa-building"></i> Department Folders
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </a>

            <div class="dropdown-menu" id="departmentMenu">

                <a href="#" class="departmentLink" data-dept="marketing">
                    <i class="fas fa-bullhorn"></i> Marketing
                </a>

                <a href="#" class="departmentLink" data-dept="accounting">
                    <i class="fas fa-calculator"></i> Accounting
                </a>

                <a href="#" class="departmentLink" data-dept="it">
                    <i class="fas fa-laptop-code"></i> IT Department
                </a>

                <a href="#" class="departmentLink" data-dept="merch">
                    <i class="fas fa-box"></i> Merchandising
                </a>

                <a href="#" class="departmentLink" data-dept="hr">
                    <i class="fas fa-users"></i> Human Resources
                </a>

            </div>

            <!-- All Users -->
            <a href="#" id="usersManagementLink">
                <i class="fas fa-users"></i> User Management
                <i class="fas fa-chevron-down"></i>
            </a>

            <!-- Shared Folders -->
            <a href="#" id="sharedFoldersLink">
                <i class="fas fa-share-alt"></i> Shared Folders
            </a>

            <!-- Reports -->
            <a href="#" id="reportsLink">
                <i class="fas fa-chart-bar"></i> Reports
            </a>

            <!-- System Settings -->
            <a href="#" id="settingsLink">
                <i class="fas fa-cogs"></i> System Settings
            </a>

        </div>

        <!-- Logout -->
        <a class="logout" href="/OLD_OWICLP/user-side/pages/login/loginn.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

    </div>


    <!-- ================= MAIN ================= -->
    <div class="main">


        <!-- ================= DASHBOARD CONTENT ================= -->
            <div id="dashboardContent" class="content-section">
    <div class="top">
        <div>
            <h2>Welcome, <?= htmlspecialchars($user); ?>!</h2>
        </div>
        <div class="search">
            <input type="text" placeholder="Search items...">
        </div>
    </div>

    <div class="documents-section">
    <div class="header-flex">
        <h3>File Manager</h3>
        <p>Manage your recent activity and workspace directories</p>
    </div>

    <div class="content-card">
        <div class="card-header recent">
            <h4><i class="fas fa-clock"></i> Recent & Frequently Opened</h4>
            <span class="count-badge">3 Files</span>
        </div>
        <ul class="file-list">
            <li>
                <a href="#"><i class="fas fa-file-invoice"></i> Inventory_Report_March.pdf</a>
                <span class="file-meta">Opened 2 mins ago</span>
            </li>
            <li>
                <a href="#"><i class="fas fa-file-alt"></i> Purchase_Order_#4421.docx</a>
                <span class="file-meta">Modified Yesterday</span>
            </li>
            <li>
                <a href="#"><i class="fas fa-file-signature"></i> Supplier_Agreement_v2.pdf</a>
                <span class="file-meta">Frequently Used</span>
            </li>
        </ul>
    </div>

    <div class="content-card">
        <div class="card-header shared">
            <h4><i class="fas fa-share-alt"></i> Shared Folders</h4>
            <span class="count-badge">Shared with Team</span>
        </div>
        <ul class="file-list grid-view">
            <li><a href="#"><i class="fas fa-users"></i> HR Documents</a></li>
            <li><a href="#"><i class="fas fa-hand-holding-usd"></i> Finance Reports 2026</a></li>
            <li><a href="#"><i class="fas fa-gavel"></i> Admin Policies</a></li>
        </ul>
    </div>

    <div class="content-card">
        <div class="card-header personal">
            <h4><i class="fas fa-folder-open"></i> Private & Office Storage</h4>
        </div>
        
        <div class="storage-split">
            <div class="storage-group">
                <span class="group-label">Office Drive</span>
                <ul class="file-list">
                    <li><a href="#"><i class="fas fa-building"></i> Branch_Operational_Manual</a></li>
                    <li><a href="#"><i class="fas fa-network-wired"></i> IT_Infrastructure_Logs</a></li>
                </ul>
            </div>
            <div class="storage-group">
                <span class="group-label">Personal Space</span>
                <ul class="file-list">
                    <li><a href="#"><i class="fas fa-user-lock"></i> My_Certificates</a></li>
                    <li><a href="#"><i class="fas fa-key"></i> Credentials_Safe</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
    </div>



       <!-- ================= MY FOLDERS SECTION ================= -->
<div id="myFoldersContent" class="content-section">
    <h3>My Folders</h3>

    <!-- Controls: Add folder, Layout toggle -->
    <div class="folder-controls">
        <button class="add-folder" onclick="openFolderModal()">Add Folder</button>

        <div class="layout-toggle">
            <button onclick="setGrid()">Grid</button>
            <button onclick="setList()">List</button>
        </div>
    </div>

    <!-- Filters -->
    <div class="folder-filters">
        <select id="typeFilter">
            <option value="all">All Types</option>
            <option value="document">Documents</option>
            <option value="spreadsheet">Spreadsheet</option>
            <option value="pdf">PDF</option>
            <option value="archive">Archive</option>
        </select>

        <select id="modifiedFilter">
            <option value="all">All</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
        </select>

        <select id="sourceFilter">
            <option value="all">All Sources</option>
            <option value="created">Created</option>
            <option value="uploaded">Uploaded</option>
            <option value="shared">Shared</option>
        </select>

        <input type="text" id="folderSearch" placeholder="Search folders...">
    </div>

    <!-- Folder Grid/List -->
    <div class="my-folders-grid folders-grid" id="foldersContainer">
        <div class="folder-item" data-type="document" data-modified="today" data-source="created">
            <div class="folder-icon doc-color">
                <i class="fas fa-folder"></i>
            </div>
            <div class="folder-info">
                <h4>Documents</h4>
                <span>128 Files</span>
            </div>
            <button class="folder-options"><i class="fas fa-ellipsis-v"></i></button>
        </div>

        <div class="folder-item" data-type="spreadsheet" data-modified="yesterday" data-source="created">
            <div class="folder-icon proj-color">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div class="folder-info">
                <h4>Projects</h4>
                <span>12 Active</span>
            </div>
            <button class="folder-options"><i class="fas fa-ellipsis-v"></i></button>
        </div>

        <div class="folder-item" data-type="archive" data-modified="today" data-source="uploaded">
            <div class="folder-icon arch-color">
                <i class="fas fa-archive"></i>
            </div>
            <div class="folder-info">
                <h4>Archives</h4>
                <span>2.4 GB</span>
            </div>
            <button class="folder-options"><i class="fas fa-ellipsis-v"></i></button>
        </div>
    </div>
</div>

<!-- ================= CREATE FOLDER MODAL ================= -->
<div id="folderModal" class="folder-modal">
    <div class="modal-content">
        <h3>Create Folder</h3>
        <input type="text" id="folderName" placeholder="Folder Name">
        <select id="folderType">
            <option value="document">Documents</option>
            <option value="spreadsheet">Spreadsheet</option>
            <option value="pdf">PDF</option>
            <option value="archive">Archive</option>
        </select>
        <select id="folderSource">
            <option value="created">Created</option>
            <option value="uploaded">Uploaded</option>
            <option value="shared">Shared</option>
        </select>
        <div class="modal-actions">
            <button onclick="createFolder()">Create</button>
            <button onclick="closeFolderModal()">Cancel</button>
        </div>
    </div>
</div>


  <!-- ================= DEPARTMENT FOLDERS CONTENT ================= -->

 <!-- ================= USER MANAGEMENT ================= -->
    <div id="usersManagementContent" class="user-management">

        <!-- Header & Add Button -->
        <div class="user-management-header">
            <h2>User Management</h2>
            <button class="btn-add">
                <i class="fas fa-user-plus"></i> Add New User
            </button>
        </div>

        <!-- Stats -->
        <div class="stats-cards">
            <div class="card">Total Users: <strong>124</strong></div>
            <div class="card">Active: <strong>118</strong></div>
            <div class="card">Storage Used: <strong>85%</strong></div>
        </div>

        <!-- Controls -->
        <div class="table-controls">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="userSearch" placeholder="Search by name or email...">
            </div>
            <div class="filter-box">
                <select id="deptFilter">
                    <option value="all">All Departments</option>
                    <option value="accounting">Accounting</option>
                    <option value="hr">Human Resources</option>
                    <option value="it">IT Department</option>
                    <option value="marketing">Marketing</option>
                </select>
            </div>
        </div>

        <!-- User Table -->
        <div class="table-wrapper">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Storage</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="userTableBody">
                    <tr data-dept="accounting">
                        <td>
                            <div class="user-info">
                                <span class="user-name">Sebastian Lazaro</span>
                                <span class="user-email">SLazaro@gmail.com</span>
                            </div>
                        </td>
                        <td>Accounting</td>
                        <td>Senior Accountant</td>
                        <td><span class="status-pill active">Active</span></td>
                        <td>
                            <div class="storage-bar">
                                <div class="progress" style="width:45%"></div>
                            </div>
                            <small>4.5GB / 10GB</small>
                        </td>
                        <td>
                            <button class="btn-icon"><i class="fas fa-edit"></i></button>
                            <button class="btn-icon text-danger"><i class="fas fa-trash"></i></button>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    
</div>

   
                
<script src="/admin-side/dashboard.js"></script>

</body>
</html>