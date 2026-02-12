<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$userName = isset($_SESSION['FirstName']) ? htmlspecialchars($_SESSION['FirstName'] . " " . $_SESSION['LastName']) : "John Doe";
$userInitial = substr($userName, 0, 1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>OWI CLP | IT Dashboard</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #004a9b;
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
             background: linear-gradient(rgba(229, 238, 253, 0.54), rgba(147, 175, 221, 0.65)), 
                    url('images/bg_login.png'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        /* --- Sidebar Styling --- */
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
            box-shadow: 0 20px 40px rgba(94, 120, 206, 0.62);
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
            color: #3A3541AD;
            text-decoration: none;
            transition: 0.2s;
            font-weight: 500;
        }

        .nav-item-custom i { width: 22px; margin-right: 12px; font-size: 1.1rem; }

        .nav-item-custom.active, .nav-item-custom:hover {
            background: linear-gradient(72.47deg, var(--primary-color) 22.16%, #004a9b 76.47%);
            color: white !important;
            box-shadow: 0px 4px 8px -4px #004a9b;
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
            background: rgba(244, 245, 250, 0.85);
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
        .dropdown-menu-custom {
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 12px;
            min-width: 230px;
            padding: 10px;
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
          <span class="brand-text">OWI CLP</span>
        </div> 
        <ul class="nav-menu">
            <small class="text-uppercase text-muted fw-bold ps-3 mb-2 d-block" style="font-size: 11px; letter-spacing: 1px;">Home</small>
            <li><a href="#" class="nav-item-custom active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="customer_profile.php" class="nav-item-custom"><i class="fas fa-user-circle"></i> Profile</a></li>
            
            <small class="text-uppercase text-muted fw-bold ps-3 mt-4 mb-2 d-block" style="font-size: 11px; letter-spacing: 1px;">Apps & Pages</small>
            <li><a href="customer_loyalty.php" class="nav-item-custom"><i class="fas fa-gift"></i> Loyalty Program</a></li>
            <li><a href="customer_purchase.php" class="nav-item-custom"><i class="fas fa-history"></i> Transactions</a></li>
            
            <small class="text-uppercase text-muted fw-bold ps-3 mt-4 mb-2 d-block" style="font-size: 11px; letter-spacing: 1px;">Settings</small>
            <li><a href="customer_settings.php" class="nav-item-custom"><i class="fas fa-cog"></i> Account Settings</a></li>
            <li><a href="#" id="sidebarLogout" class="nav-item-custom text-danger"><i class="fas fa-power-off"></i> Logout</a></li>
        </ul>
    </nav>

    <div class="main-container">    
        <header class="top-navbar">
            <div class="container-fluid d-flex align-items-center justify-content-between p-0">
                
                <div class="d-flex align-items-center flex-grow-1">
                    <button class="btn border-0 d-lg-none me-2" onclick="toggleSidebar()">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <div class="search-input-group d-none d-md-block">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control shadow-none" placeholder="Search (Ctrl+/)">
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <button class="btn btn-link text-dark nav-link px-2"><i class="far fa-moon fs-5"></i></button>
                    <button class="btn btn-link text-dark nav-link px-2 position-relative">
                        <i class="far fa-bell fs-5"></i>
                        <span class="position-absolute top-25 start-75 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>

                    <div class="dropdown ms-3">
                        <div class="d-flex align-items-center" data-bs-toggle="dropdown" style="cursor: pointer;">
                            <div class="avatar-circle me-2"><?php echo $userInitial; ?></div>
                            <div class="d-none d-sm-block">
                                <span class="d-block fw-bold mb-0" style="font-size: 0.9rem; line-height: 1.2;"><?php echo $userName; ?></span>
                                <small class="text-muted" style="font-size: 0.75rem;">Client Account</small>
                            </div>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom mt-3">
                            <li class="px-3 py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2" style="width: 35px; height: 35px;"><?php echo $userInitial; ?></div>
                                    <div>
                                        <div class="fw-bold" style="font-size: 0.85rem;"><?php echo $userName; ?></div>
                                        <small class="text-muted">Premium Member</small>
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
                confirmButtonColor: '#004a9b',
                confirmButtonText: 'Yes, logout'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = 'index.php';
            });
        
        document.getElementById('sidebarLogout').onclick = handleLogout;
        document.getElementById('navbarLogout').onclick = handleLogout;
    </script>
</body>
</html>