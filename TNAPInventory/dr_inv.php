
 <?php
 //  session_start();
  date_default_timezone_set("Asia/Manila");
   include 'templates/navbar.php';
   include 'templates/sidebar.php';
   include 'dr_inv_modal.php';
  
  ?>
  
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <div class="content-header">
       <div class="container-fluid">
         <div class="row mb-2">
           <div class="col-sm-6">
             <h1 class="m-0">Check Inventory</h1>
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
 <div class="row">
 <div class="col-md-4">
   <!-- <input type="text" class="form-control" placeholder="Input ALU"> -->
 </div>
 <!-- <div class="col-md-2"><input type="submit" value="Locate" class="form-control btn-info"></div> -->
 
 
 </div>
 <div class="col-md-12">
 
 <div class="card-body table-responsive p-0">
 
 <table class="table table-striped table-valign-middle" id="masterfile_data">
 </table>
 
 
 
 </div>
 
 
 </div>
 
 
 
       <table></table>
 
       </div><!-- /.container-fluid -->
     </div>
     <!-- /.content -->
   </div>
   <!-- /.content-wrapper -->
 
   <?php include 'templates/footer.php';
 
 ?>
 
 
 
 <script type="text/javascript">
 
 $(document).ready( function () {
 
 
   function getdata(){
 $.post('functions/fetch_data.php',{mode:'dr_chck_inv'},function(data){
//  console.log(data);
 admin_datatable(data);
 },'json');
 }
 
 getdata();
 
 var table
 function admin_datatable(t){
 const dataset=t.rptdata;
 
 table =  $("#masterfile_data").DataTable({
 
 "dom":
 'B<"pull-left"lf><"pull-right">tip',
 // stateSave: true,
 
 "info": false,
 "pagingType": "full_numbers",
 "bDestroy": true,
 "responsive": true, "lengthChange": false, "autoWidth": false,
 "language": {
 "search": "_INPUT_",
 "searchPlaceholder": "Enter ALU #..."
 },
 "pageLength":6,
 "data": dataset,
 
 "columns": [
 {title:"OWI SKU:", data:"OWI_SKU","defaultContent": "",},
 {title:"OWI DESCRIPTION:", data:"OWI_DESCRIPTION","defaultContent": "",},
 {title:"CWH BEGINNING INV:", data:"cwh_bgn_qty","defaultContent": "",},
 {title:"Transfer Received Voucher:", data:"cwh_onhand","defaultContent": "",},
 {title:"QUANTITY DELIVERED:", data:"cwh_qty","defaultContent": "",},
 {title:"QUANTITY ON-HAND:", data:"cwh_onhand","defaultContent": "",},
 {title:"MIN:", data:"cwh_onhand","defaultContent": "",},
 {title:"MAX:", data:"cwh_onhand","defaultContent": "",},

 {title:"HISTORY", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><i class='fas fa-print'></i></a></Button>"}
 
 ],
   columnDefs: [{
     "defaultContent": "-",
     "targets": "_all"
   }]
 });
 
 $('#masterfile_data tbody').on('click', 'button', function () {
var data = table.row( $(this).parents('tr') ).data();
// console.log(data)
$('#h_owi_desc').text('OWI #: ' + data['OWI_SKU']);
$('#h_owi_desc').append('   |   ' +data['OWI_DESCRIPTION']);
// $('#form_sku').val(data['OWI_SKU']);
$('#chw_total').val(data['cwh_qty']);
$('#pqin_val').val(data['pqiqty']);
$('#ptag_val').val(data['pqty']);
$('#form_sku').val(data['OWI_SKU']);

// console.log($('#slct_branch').val())
var form_sku = $('#form_sku').val();
breakInfo(form_sku);
$('#dr_inv_modal').modal('show');
    } );

 
 } // end of function
 
function breakInfo(form_sku){

 
//  var brslct = $('#slct_branch').val();

  // console.log($('#slct_branch').val())
  $.post('functions/fetch_data.php',{form_sku:form_sku,mode:'inv_breakdown'},function(data){
//  console.log(data);
 breakdwnTable(data);
 },'json');


}
 var table
 function breakdwnTable(t1){
 const dataset=t1.rptdata;
 
 table =  $("#break_table").DataTable({
 
 "dom":
 'B<"pull-left"lf><"pull-right">tip',
 // stateSave: true,
 
 "info": false,
 "pagingType": "full_numbers",
 "bDestroy": true,
 "responsive": true, "lengthChange": false, "autoWidth": false,
  searching: false,
   paging: false,
 "data": dataset,
 
 "columns": [
 // {title:"NUM", data:"id","defaultContent": "",},
 {title:"ALU:", data:"OWI_SKU","defaultContent": "",},
 {title:"DESCRIPTION", data:"OWI_DESCRIPTION","defaultContent": "",},
 {title:"PO#", data:"consign_tag","defaultContent": "",},
 {title:"Branch", data:"branch_desc","defaultContent": "",},
 {title:"Quantity", data:"consign_qty","defaultContent": "",},
 {title:"Delivery Receipt", data:"dr_tag","defaultContent": "",},
 {title:"Deliver Date", data:"del_date","defaultContent": "",}

 
 
 
 ],
   columnDefs: [{
     "defaultContent": "-",
     "targets": "_all"
   }]
   ,
   footerCallback: function (row, data, start, end, display) {
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
 
            // Total over all pages
            total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Total over this page
            pageTotal = api
                .column(4, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Update footer
            // $(api.column(4).footer()).html('Php.' + pageTotal + ' ( $' + total + ' total)');
            $(api.column(4).footer()).html(pageTotal);

        }
 });
 


 } // end of function

 

 
 
 
 
 } );
 
 </script>	
 
 
 