
 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #020024; !important">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="images/owi_logo.jpg" alt="PG LOGO" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Barcode Generator</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
         <!-- <div class="text-white">Crisjer Gutana</div>  -->
        </div>
        <div class="info">
          <!-- insert name here session -->
          <a href="#" class="d-block"><?php echo $_SESSION['f_name']." ". $_SESSION['lst_name'];?></a>
        </div>
      </div>

 

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <input type="hidden" name="dptID" id="dptID" value="<?php echo $_SESSION['dept_id']; ?>">
               <li class="nav-item pdmod">
               <a href="#" class="nav-link">

               <i class="fa-solid fa-book"></i>
              <p>
              PURCHASING MODULE
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="add_po.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Purchase Order / Consignment Order Form  </p>
                </a>
              </li>
              <li class="nav-item">
              <a href="upt_sku.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update ALU/Item</p>
                </a>
              </li>
            </ul>
          </li>



          <li class="nav-item ldMod">
               <a href="#" class="nav-link">

               <i class="fa-solid fa-truck"></i>
              <p>
                LOGISTIC MODULE
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="ld_dash.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generate Delivery Receipt </p>
                </a>
              </li>
              <li class="nav-item">
              <a href="dr_inv.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Check CWH Inventory</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="dr_reprint.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>RE-PRINT DR</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="sales.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SALES</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item actMod">
               <a href="#" class="nav-link">

               <i class="fa-solid fa-dollar-sign"></i>
              <p>
                SALES MODULE
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="add_sales.php" class="nav-link">
              <i class="fas fa-file-invoice-dollar"></i>
                  <p>Transact</p>

                </a>
              </li>
              <li class="nav-item">
              <a href="acct_addSL.php" class="nav-link">
              <i class="fas fa-hand-holding-usd"></i>
                  <p>Sales Report</p>

                </a>
              </li>
              
              <li class="nav-item">
              <a href="dr_inv.php" class="nav-link">
              <i class="fas fa-warehouse"></i>
                  <p>Check CWH Inventory</p>
                </a>
              </li>
            </ul>
          </li>



          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

 
