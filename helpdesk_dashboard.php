<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
// User details for display
$userName = isset($_SESSION['FirstName']) ? htmlspecialchars($_SESSION['FirstName'] . " " . $_SESSION['LastName']) : "John Doe";
$userInitial = substr($userName, 0, 1);
$userStatus = isset($_SESSION['user_status']) ? $_SESSION['user_status'] : "Active";

// Define status appearance
switch (strtolower($userStatus)) {
    case 'active':
        $statusClass = 'text-success';
        $lightClass = 'bg-success';
        break;
    case 'locked':
        $statusClass = 'text-warning';
        $lightClass = 'bg-warning';
        break;
    case 'blocked':
        $statusClass = 'text-danger';
        $lightClass = 'bg-danger';
        break;
    default:
        $statusClass = 'text-muted';
        $lightClass = 'bg-secondary';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>OWI HELPDESK | Dashboard</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #E1AD01;
            --primary-light: #F4F0FF;
            --bg-body: #F4F5FA;
            --sidebar-width: 260px;
            --topbar-height: 70px;
            --card-shadow: 0 4px 12px 0 rgba(58, 53, 65, 0.1);
        }

        body {
            font-family: 'Public Sans', sans-serif;
            background-color: var(--bg-body);
            color: #3A3541DE;
            overflow-x: hidden;
             background: linear-gradient(rgba(218, 219, 207, 0.3), rgba(214, 216, 184, 0.27)), 
                    url('images/bg_login yellow.png'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: #fff;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            z-index: 1050;
            border-right: 1px dashed #dadae3;
            box-shadow: 0 20px 40px rgba(163, 163, 92, 0.4);
            background: linear-gradient(rgba(218, 219, 207, 0.3), rgba(214, 216, 184, 0.27)), 
                    url('images/bg_login yellow.png'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .sidebar-header{
          padding:15px 20px;
          display: flex;
          align-items: center;
          border-bottom: 1px solid rgba(58,53,65,0.05);
          margin-bottom: 10px;
        }

        .brand-logo{
          width: 35px;
          height: 35px;
          object-fit: contain;
          border-radius: 6px;
        }

        .brand-text{
          font-weight:700;
          font-size:1.25rem;
          color: var(--primary-color);
          letter-spacing:0.5px;
          margin-left:12px;
          text-transform: uppercase;
        }

        .nav-menu{
          list-style: none;
          padding: 10px 15px;
        }
        
        .nav-item-custom {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            margin-bottom: 4px;
            border-radius: 0 50px 50px 0;
            color: #3a3541ed;
            text-decoration: none;
            transition: 0.2s;
            font-weight: 500;
        }

        .nav-item-custom i { width: 22px; margin-right: 12px; font-size: 1.1rem; }

        .nav-item-custom.active, .nav-item-custom:hover {
            background: linear-gradient(72.47deg, var(--primary-color) 22.16%, #E1AD01 76.47%);
            color: white !important;
            box-shadow: 0px 4px 8px -4px #E1AD01;
        }

        /* --- Main Content Area --- */
        .main-container {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        /* --- Top Navbar --- */
        .top-navbar {
            height: var(--topbar-height);
            box-shadow: 0 10px 20px rgba(221, 221, 93, 0.4);
            background: linear-gradient(rgba(218, 219, 207, 0.3), rgba(214, 216, 184, 0.27)), 
                    url('images/bg_login yellow.png'); 
            background-size: cover;
            background-attachment: fixed;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .search-input-group {
            position: relative;
            max-width: 400px;
            width: 100%;
        }

        .search-input-group input {
            border: none;
            background: transparent;
            padding-left: 35px;
            font-size: 0.9rem;
        }

        .search-input-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #3A3541AD;
        }

        /* --- User Profile Dropdown --- */
        .avatar-circle {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
            cursor: pointer;
        }
       
        .card{
          background-color:#fff;
          border-radius:10px;
          border:none;
          position:relative;
          margin-bottom:0;
          box-shadow: 0 20px 40px rgba(185, 185, 42, 0.85);
        }
        .card .card-header{
          border-bottom-color: #f9f9f9;
          line-height:30px;
          -ms-grid-row-align:center;
          align-self:center;
          width:100%;
          display:flex;
          align-items:center;
          margin-bottom:0;
          margin-top:-30px;
          background-color:rgba(0,0,0,.03);
          border-bottom:1px solid rgba(0,0,0,.125);
        }
        .card-header:first-child{
          border-radius:calc(.25rem -1px)calc(.25rem -1px)00;
        }
        .container{
          margin-top:20px;
          width:100%;
          padding:-10px;
          box-shadow: 0 20px 40px rgba(185, 185, 42, 0.85);
          background-color:white;
         
        }

        .table:not(.table-sm) thead th{
          border-bottom: none;
          background-color: #e9e9eb;
          color:#666;
          padding-top:15px;
          padding-bottom:15px;
        }        
        .bg-success{
          background-color: #54ca68 !important;
        }

        .bg-purple{
          background-color: #9c27b0 !important;
          color: #fff;
        }
        .bg-cyan{
          background-color: #10cfbd !important;
          color:#fff;
        }
        .bg-red{
          background-color: #f44336 !important;
          color: #fff;
        }
        .progress{
          -webkit-box-shadow: 0 0.4rem 0.6rem rgba(0,0,0,,0.15);
          box-shadow: 0 0.4rem 0.6rem rgba(0,0,0,0.15);
        }
        .table thead th{
          font-size:12px;
          text-transform: uppercase;
          letter-spacing:1px;
          font-weight:700;
          color:#555;
          padding:20px;
          border-bottom: 2px solid #f0f0f0;
        
        }

        .table tbody td{
          padding:15px 10px;
          font-size:14px;
        }
        .btn-outline-primary{
          border-color:#E1AD01;
          font-weight:600;
          transition:all 0.3s;
        }
        .btn-outline-primary:hover{
          background-color:#E1AD01;
          transform:translateY(-2px);
          box-shadow:0 4px 10px rgba(13,110,253,0.2);
        }
        .badge{
          padding:6px 12px;
          font-weight: 500;
        }
        .v-align-middle td{
          vertical-align: middle !important;
        }
        .badge-secondary {
          background-color: #eef2f7;
          color: #5a7184;
          font-weight:500;
          padding: 5px 10px;
        }
        .badge-danger{
          background-color: #ff5e5e;
        }
        .badge-warning{
          background-color: #ffc107;
          color:#333;
        }
        .badge-success{
          background-color: #28a745;
        }
        .order-list{
          display:flex;
          padding-left:0;
          list-style: none;
          margin-bottom:0;
        }
       
        .col-green{
          color:#28a745!important;
        }
        .font-13{
          font-size:13px;
          font-weight:600;
        }
        .font-12{
          font-size:12px;
        }
        .fas, .far{
          cursor:pointer;
          opacity:0.7;
          transition: opacity 0.2s;
        }
        .fas:hover, .far:hover{
          opacity:1;
        }
        .dropdown-menu-custom {
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 12px;
            min-width: 230px;
            padding: 10px;
        }
        .status-light{
          width: 8px;
          height:8px;
          border-radius: 50%;
          display:inline-block;
          margin-right:5px;
          position:relative;
        } 
        .bg-success.status-light::after{
          content:'';
          position:absolute;
          width:100%;
          height:100%;
          background:inherit;
          border-radius:50%;
          animation:statusPulse 2s infinite;
          opacity:0.4;
        }

        #ticketReportModal .modal-content{
          background-color:#ffffff;
        }
        #ticketReportModal .bg-light{
          background-color:#ffffff !important;
        }
        #ticketReportModal label{
          font-size:11px;
          letter-spacing:0.5px;
        }
        #ticketReportModal .modal-body{
          max-height: 80vh;
          overflow-y:auto;
        }
        @keyframes statusPulse{
          0% { transform: scale(1); opacity:0.8;}
          100%{transform:scale(2.5); opacity:0;}
        }
        /* --- Responsive Behavior --- */
        @media (max-width: 992px) {
            .sidebar { left: -100%; }
            .sidebar.show { left: 0; }
            .main-container { margin-left: 0; }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1040;
            }
            .sidebar-overlay.active { display: block; }
        }
        /* --- Dashboard Cards --- */
        .m-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 24px;
            border: none;
        }
    </style>
</head>
<body>
 <div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
          <img src="images/owi.jpg" alt="Logo" class="brand-logo">
          <span class="brand-text">OWI HELPDESK</span>
        </div>
        <ul class="nav-menu">
          <small class="menu-divider">
            <span>Main Menu</span>
          </small>
          <li><a href="#" class="nav-item-custom active"><i class="fas fa-th-large"></i>Dashboard</a></li>
          <li><a href="helpdesk_new.php" class="nav-item-custom"><i class="fas fa-user-gear"></i>New Reports</a></li>

          <small class="menu-divider">
            <span></span>
          </small>
          <li><a href="helpdesk_reports.php" class="nav-item-custom"><i class="fas fa-award"></i>Generate Report</a></li>
          <li><a href="helpdesk_maintenance.php" class="nav-item-custom"><i class="fas fa-file-invoice-dollar"></i>Maintenance</a></li>
          <li><a href="helpdesk_notification.php" class="nav-item-custom"><i class="fas fa-bullhorn"></i>Notification</a></li>
        
          <small class="menu-divider">
           <span></span>
          </small>
          <li><a href="#" id="sidebarLogout" class="nav-item-custom text-danger logout-hover"><i class="fas fa-right-from-bracket"></i>Logout</a></li>
        </ul>
    </nav>

    <div class="main-container">  
        <header class="top-navbar">
            <div class="container-fluid d-flex align-items-center justify-content-between p-0">  
               <div class="d-flex align-items-center flex-grow-1  p-3">
                <button class="btn border-0 d-lg-none me-2" onclick="toggleSidebar()">
                  <i class="fas fa-bars fa-lg"></i>
                </button>
                <div class="d-flex align-items-center gap-3 w-100">
                  <div class="text-dark fw-bold border-end pe-3 d-none d-sm-block">
                    <i class="far fa-clock me-1" style="color:#E1AD01;"></i>
                    <span id="runningTime">00:00:00</span>
                  </div>
                  <div class="text-dark  border-end pe-3 d-none d-sm-block" style="margin-top:15px;">
                    <p>Filter by</p>
                  </div>
                  <select class="form-select form-select-sm border-gold" style="width:auto;">
                    <option selected>Month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                  </select>
                  <select class="form-select form-select-sm border-gold" style="width:auto;">
                    <option selected>Year</option>
                    <option value="2026">2026</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                  </select>
                  <button class="btn btn-gold btn-sm d-flex align-items-center gap-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="d-none d-md-inline">Show Calendar</span>
                  </button>
                </div>
            </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown ms-3">
                        <div class="d-flex align-items-center" data-bs-toggle="dropdown" style="cursor: pointer;">
                            <div class="avatar-circle me-2"><?php echo $userInitial; ?></div>
                            <div class="d-none d-sm-block">
                              <span class="d-block fw-bold mb-0" style="font-size:0.9rem; line-height:1.2;">
                                <?php echo$userName;?>
                              </span>
                              <div class="d-flex align-items-center">
                                <span class="status-light <?php echo $lightClass;?>"></span>
                                <small class="fw-medium <?php echo $statusClass;?>" style="font-size: 0.75rem;"></small>
                                <small class="fw-medium <?php echo $statusClass;?>" style="font-size:0.75rem;"><?php echo ucfirst($userStatus);?> Account</small>
                              </div>
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom mt-3">
                            <li class="px-3 py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2" style="width: 35px; height: 35px;"><?php echo $userInitial; ?></div>
                                    <div>
                                       <div class="fw-bold" style="font-size: 0.85rem;"><?php echo $userName; ?></div>
                                       <div class="d-flex align-items-center">
                                        <span class="status-light <?php echo $lightClass;?>" style="width:6px; height: 6px;"></span>
                                        <small class="<?php echo $statusClass; ?> fw-bold" style="font-size:0.7rem;"><?php echo strtoupper(string: $userStatus);?>
                                         </small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a class="dropdown-item py-2 mt-2 rounded" href="customer_profile.php"><i class="far fa-user me-2"></i> My Profile</a></li>
                            <li><a class="dropdown-item py-2 rounded" href="customer_settings.php"><i class="fas fa-cog me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 rounded text-danger" href="#" id="navbarLogout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-4">
          <div class="row g-4">
            <div class="col-xl-3 col-lg-6 col-md-6">
              <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; transition: transform 0.2s;">
                <div class="card-body p-4">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                      <i class="fas fa-file-alt fa-2x"></i>
                     </div>
                        <h2 class="fw-black mb-1" style="font-size: 2.2rem; letter-spacing: -1px;">142</h2>
                     </div>
                     <div>
                        <p class="text-primary fw-bold text-uppercase mb-0" style="font-size: 0.75rem; letter-spacing: 1px; margin-left:10px;">Assigned Reports</p>
                        <hr width="100%" color="blue"/>
                     </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
              <div class="card border-0 shadow-sm h-100" style="border-radius:15px; transition: transform 0.2s;">
                <div class="card-body p-4">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                      <i class="fas fa-exclamation-circle fa-2x"></i>
                    </div>
                    <h2 class="fw-black mb-1" style="font-size: 2.2rem; letter-spacing:-1px;">12</h2>
                  </div>
                  <div>
                    <p class="text-danger fw-bold text-uppercase mb-0" style="font-size:0.75rem; letter-spacing: 1px; margin-left:10px;">On Process</p>
                    <hr width="100%" color="red"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
              <div class="card border-0 shadow-sm h-100" style="border-radius:15px;">
                <div class="card-body p-4">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                      <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <h2 class="fw-black mb-1" style="font-size:2.2rem; letter-spacing:-1px;">8</h2>
                  </div>
                  <div>
                    <p class="text-warning fw-bold text-uppercase mb-0" style="font-size: 0.75rem; letter-spacing: 1px; margin-left:10px;">Pending Action</p>
                    <hr width="100%" color="yellow"/>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
              <div class="card border-0 shadow-sm h-100" style="border-radius:15px;">
                <div class="card-body p-4">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                      <i class="fas fa-check-double fa-2x"></i>
                    </div>
                    <h2 class="fw-black mb-1" style="font-size: 2.2rem; letter-spacing:-1px;">122</h2>
                  </div>
                  <div>
                    <p class="text-success fw-bold text-uppercase mb-0" style="font-size:0.75rem; letter-spacing:1px; margin-left:10px;">Closed Reports</p>
                    <hr width="100%" color="green"/>
                  </div>
                </div>
              </div>
            </div>     
        </div>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
        <div class="container">
          <div class="row">
            <div class="col-12" style="background: linear-gradient(rgba(218, 219, 207, 0.3), rgba(214, 216, 184, 0.27)), 
                    url('images/bg_login yellow.png');">
              <div class="card-border-0 shadow-sm" style=" padding:-40px;">
                <div class="card-header py-3 d-flex justify-content-between align-items-center" style="margin-bottom:10px; margin-top:10px; width:100%;background:#E1AD01">
                  <div>
                    <h5 class="mb-0 fw-bold" style="color:black; margin-left:20px; ">
                      HELP DESK TICKETS
                    </h5>
                  </div>
                  <div class="search-input-group d-none d-md-block" style="margin-right:20px;">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control shadow-none" placeholder="Enter your search here">
                    </div>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="proTeamScroll" style="max-height:450px; width:100%;overflow-y:auto;">
                  <table class="table table-hover align-middle">
                    <thead class="table-light">
                      <tr>
                        <th>Date Created</th>
                        <th>Store/Branch</th>
                        <th>Subject</th>
                        <th>Via</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-muted">13-02-2026</td>
                        <td><span class="fw-bold">Warehouse A</span></td>
                        <td>WMS Sync Failure</td>
                        <td><span class="badge rounded-pill bg-light text-dark border">Portal</span></td>
                        <td><span class="badge bg-danger">Open</span></td>
                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-outline-primary px-3 rounded-pill"
                          data-bs-toggle="modal" data-bs-target="#ticketReportModal"><i class="fas fa-eye me-1"></i>View</button>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-muted">13-02-2026</td>
                        <td><span class="fw-bold">Store #04</span></td>
                        <td>POS Terminal Offline</td>
                        <td><span class="badge rounded-pill bg-light text-dark border">Phone</span></td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        <td class="text-center">
                          <a href="reports.php?id=2" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                            <i class="fas fa-eye me-1"></i>View
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="ticketReportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header bg-warning text-white p-4" style="border-radius: 15px 15px 0 0;">
              <h5 class="modal-title fw-bold" id="reportModalLabel">
                <i class="fas fa-file-onvoice me-2"></i>Detailed Incident Report
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
              <div class="row g-3 mb-4">
                <div class="col-md-3 col-6">
                  <label class="text-muted small fw-bold text-uppercase d-block">Date Created</label>
                  <span class="fw-bold text-dark">13-02-2026</span>
                </div>
                <div class="col-md-3 col-6">
                  <label class="text-muted small fw-bold text-uppercase d-block">Store / Branch</label>
                  <span class="fw-bold text-dark">Warehouse A</span>
                </div>
                <div class="col-md-3 col-6">
                  <label class="text-muted small fw-bold text-uppercase d-block">Via</label>
                  <span class="fw-bold text-dark"><i class="fas fa-desktop me-1 small"></i>Portal</span>
                </div>
                <div class="col-md-3 col-6">
                  <label class="text-muted small fw-bold text-uppercase d-block">Status</label>
                  <span class="badge bg-success">Closed</span>
                </div>
                <div class="mb-4" style="margin-bottom: -20px;">
                    <label class="text-muted small fw-bold text-uppercase">Subject</label>
                    <h5 class="fw-bold text-warning">WMS Sync Failure - Handheld Connection Issue</h5>
                </div>

                <hr class="opacity-10">
                <div class="row g-3 mb-4">
                    <div class="col-md-6 border-end">
                        <p class="mb-2 fw-bold"><i class="fas fa-tags me-2 text-warning"></i>Classification</p>
                        <div class="d-flex justify-content-between pe-3">
                            <div>
                                <small class="text-muted d-block">Category</small>
                                <span class="fw-semibold">Software Systems</span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Sub Category</small>
                                <span class="fw-semibold">Warehouse Mgmt (WMS)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ps-md-4">
                        <p class="mb-2 fw-bold"><i class="fas fa-history me-2 text-warning"></i>Timeline</p>
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted d-block">Date Closed</small>
                                <span class="fw-semibold">13-02-2026</span>
                            </div>
                            <div>
                                <small class="text-muted d-block">Completion Time</small>
                                <span class="fw-semibold">14:30 PM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-light p-3 rounded border">
                  <label class="fw-bold text-uppercase small text-warning mb-2">Work Output / Resolution</label>
                  <p class="mb-0 text-secondary" style="font-size: 0.95rem; line-height: 1.5;">
                    Technical staff identified a local IP conflict on the warehouse floor. 
                    Reset the static IP for Scanner #09 and Scanner #12. 
                    Verified connectivity with the main database server. 
                    Service restored for the picking line.
                  </p>
                </div>  
              </div>
            </div>
          </div>
        </div>
      </div>   
    </main> 
  </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <script>
        // Sidebar Toggle for Mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('overlay').classList.toggle('active');
        }
        // Unified Logout Logic
        function handleLogout(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Sign Out?',
                text: "You will be returned to the login screen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#E1AD01',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = 'index.php';
            });
        }

        document.getElementById('sidebarLogout').onclick = handleLogout;
        document.getElementById('navbarLogout').onclick = handleLogout;

        function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString([], { 
        hour: '2-digit', 
        minute: '2-digit', 
        second: '2-digit',
        hour12: true 
    });
    document.getElementById('runningTime').textContent = timeString;
}

// Update every second
setInterval(updateClock, 1000);
updateClock(); // Initial call
</script>
</body>
</html>