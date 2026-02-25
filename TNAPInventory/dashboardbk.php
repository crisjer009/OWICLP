
 <?php
 include 'templates/navbar.php';

 include 'templates/sidebar.php';

?>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1 class="m-0">Dashboard</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
           <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
             <li class="breadcrumb-item active">Home</li>
           </ol>
         </div><!-- /.col -->
       </div><!-- /.row -->
     </div><!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->

   <!-- Main content -->
   <div class="content">
     <div class="container-fluid">
       <div class="row">
         <div class="col-lg-6">
           <div class="card">
             <div class="card-body">
               <h5 class="card-title text-bold">Printing on queue</h5>

               <p class="card-text ">
                   Add mo rito jer yung latest barcode na nagpiprint 
                   <br>
                   Item Commrate Sino nag pa print
               </p>

               <a href="#" class="card-link">Card link</a>
               <a href="#" class="card-link">Another link</a>
             </div>
           </div>

           <div class="card card-primary card-outline">
             <div class="card-body">
               <h5 class="card-title text-bold">Recenty Price Upadate</h5>

               <p class="card-text">
                 Lagay mo rito yung huling item with comm code na may huling price update at kung sino yung nag update plus date updated.
               </p>
               <a href="#" class="card-link">Card link</a>
               <a href="#" class="card-link">Another link</a>
             </div>
           </div><!-- /.card -->
         </div>
         <!-- /.col-md-6 -->
         <div class="col-lg-6">
           <div class="card">
             <div class="card-header">
               <h5 class="m-0 text-bold">Print History</h5>
             </div>
             <div class="card-body">
               <h6 class="card-title">Print History </h6>

               <p class="card-text">Lagay mo dito datatables ng history of print <br>
               alu, item, date printed, sino nag pa print,</p>
               <a href="#" class="btn btn-primary">Go somewhere</a>
             </div>
           </div>

           <div class="card card-primary card-outline">
             <div class="card-header">
               <h5 class="m-0 text-bold">History of Price Update</h5>
             </div>
             <div class="card-body">
               <h6 class="card-title">History of price update over the time</h6>

               <p class="card-text">Lagay mo dito datatables ng history of price update <br>
               alu, item, date printed, sino nag pa print,</p>
               <a href="#" class="btn btn-primary">Go somewhere</a>
             </div>
           </div>
         </div>
         <!-- /.col-md-6 -->
       </div>
       <!-- /.row -->
     </div><!-- /.container-fluid -->
   </div>
   <!-- /.content -->
 </div>
 <!-- /.content-wrapper -->

 <?php include 'templates/footer.php';
