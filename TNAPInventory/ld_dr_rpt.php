

  

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
           <h1 class="m-0">Update/Change Price</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
           <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="#">Update Change Price</a></li>
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
     <button>Add row</button>

<table id="myTable">
   <tbody>
       <tr>
           <td>1</td>
           <td>John</td>
           <td>654 789 321</td>
       </tr>
   </tbody>
</table>

     </div><!-- /.container-fluid -->
   </div>
   <!-- /.content -->
 </div>
 <!-- /.content-wrapper -->

 <?php include 'templates/footer.php';
 ?>

 <script>
$(document).ready(function () {
 //Try to get tbody first with jquery children. works faster!
var tbody = $('#myTable').children('tbody');

//Then if no tbody just select your table 
var table = tbody.length ? tbody : $('#myTable');


$('button').click(function(){
   //Add row
   table.append('<tr><td>0</td><td>Hey</td><td>**********</td></tr>');
})




});





 </script>


