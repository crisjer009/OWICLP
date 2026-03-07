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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- amCharts -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

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

#dashboardContent {
    max-width: 1400px;
    margin: 0 auto;
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

/* Parent Container */
#FolderContent {
    margin-top: 20px;
}

#FolderContent h3 {
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


/* ================= GRID LAYOUT ================= */

.folders-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
}


/* ================= FOLDER CARD ================= */

.folder-item {
    background: linear-gradient(145deg, rgba(255,255,255,0.05), rgba(255,255,255,0.01));
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 22px;
    display: flex;
    align-items: center;
    gap: 15px;
    position: relative;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
}

/* Hover Effect */
.folder-item:hover {
    background: rgba(255,255,255,0.08);
    border-color: rgba(56,189,248,0.4);
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.4);
}


/* ================= FOLDER ICON ================= */

.folder-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

/* Folder Type Colors */

.doc-color{
    background: rgba(56,189,248,0.15);
    color:#38bdf8;
}

.proj-color{
    background: rgba(168,85,247,0.15);
    color:#a855f7;
}

.arch-color{
    background: rgba(244,114,182,0.15);
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
    transition:color 0.2s ease;
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

.folders-list{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.folders-list .folder-item{
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

}

@media (max-width:480px){
.folders-grid{
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
        <a class="logout" href="/user-side/pages/login/login.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

    </div>


    <!-- ================= MAIN ================= -->
    <div class="main">


        <!-- ================= DASHBOARD CONTENT ================= -->
        <div id="dashboardContent">

            <div class="top">
                <div>
                    <h2>Welcome, <?= htmlspecialchars($user); ?>!</h2>
                </div>

                <div class="search">
                    <input type="text" placeholder="Search items...">
                </div>
            </div>

            <div class="documents-section">

                <h3>File Manager</h3>
                <small>Quick access to your most used directories</small>

                <!-- cards remain unchanged -->
                <!-- (your dashboard cards stay exactly the same) -->

            </div>

        </div>


        <!-- ================= MY FOLDERS CONTENT ================= -->
        <div id="FolderContent">

            <h3>My Folders</h3>

            <div class="documents-section">

                <!-- controls, filters and folder grid remain unchanged -->

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


        <!-- ================= DEPARTMENT FOLDERS ================= -->
        <div id="departmentFoldersContent">

            <h3>Department Folders</h3>

            <div class="documents-section">

                <div class="folders-grid">

                    <!-- Marketing -->
                    <div class="folder-item">
                        <div class="folder-icon doc-color">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="folder-info">
                            <h4>Marketing</h4>
                            <span>Campaign Files</span>
                            <small>Department Storage</small>
                        </div>
                    </div>

                    <!-- Accounting -->
                    <div class="folder-item">
                        <div class="folder-icon proj-color">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="folder-info">
                            <h4>Accounting</h4>
                            <span>Financial Reports</span>
                            <small>Department Storage</small>
                        </div>
                    </div>

                    <!-- IT -->
                    <div class="folder-item">
                        <div class="folder-icon arch-color">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="folder-info">
                            <h4>IT Department</h4>
                            <span>System Files</span>
                            <small>Department Storage</small>
                        </div>
                    </div>

                    <!-- Merchandising -->
                    <div class="folder-item">
                        <div class="folder-icon doc-color">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="folder-info">
                            <h4>Merchandising</h4>
                            <span>Product Files</span>
                            <small>Department Storage</small>
                        </div>
                    </div>

                    <!-- HR -->
                    <div class="folder-item">
                        <div class="folder-icon proj-color">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="folder-info">
                            <h4>Human Resources</h4>
                            <span>Employee Documents</span>
                            <small>Department Storage</small>
                        </div>
                    </div>

                </div>

            </div>

        </div>


    </div> <!-- End main -->

</div> <!-- End wrapper -->

                
<script src="/admin-side/dashboard.js"></script>

</body>
</html>