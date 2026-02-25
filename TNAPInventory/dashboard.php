
 <?php
//  session_start();
 date_default_timezone_set("Asia/Manila");
  include 'templates/navbar.php';
  include 'templates/sidebar.php';
  include 'upt_modal.php';
 
 ?>

 <style>

.fa-check{
  color: green;
}
.fa-long-arrow-up{
  color: green;
}
.fa-long-arrow-down{
color: red;

}

  </style>

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

<div class="col-md-12 mb-5">
<div class="card h-100">
<h5 class="card-header text-center">CREATED COF</h5>
<div class="card-body table-responsive ">

<table class="table table-striped table-valign-middle text-center" id="po_data">
</table>



</div>


</div>
</div>

<div class="col-md-6">
<div class="card h-100">
<h5 class="card-header text-center">PRICE UPDATE HISTORY</h5>
<div class="card-body table-responsive ">

<table class="table table-striped table-valign-middle" id="pu_data">
</table>



</div>


</div>
</div>


</div>


      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include 'templates/footer.php';

?>



<script type="text/javascript">

$(document).ready( function () {


  function dash_1data(){
$.post('functions/fetch_data.php',{mode:'pd_dash_1'},function(data){
console.log(data);
podata_dtbl(data);
},'json');
}

dash_1data();

var table1
function podata_dtbl(t){
const dataset=t.rptdata;

table1 =  $("#po_data").DataTable({
  "language": {
    "infoEmpty": "No entries to show"
    },
"dom":
'B<"pull-left"lf><"pull-right">tip',
// stateSave: true,

"info": false,
"pagingType": "full_numbers",
"bDestroy": true,
"responsive": true, "lengthChange": false, "autoWidth": false,
"searching": false,
"pageLength":10,
order: [[1, 'asc']],

"data": dataset,

"columns": [
// {title:"NUM", data:"id","defaultContent": "",},
{title:"P.O Number:", data:"consign_tag","defaultContent": "",},
{title:"Date Created:", data:"date_created","defaultContent": "",},
{title:"COF Created by:", data:"cof_crt","defaultContent": "",},
{title:"Total QTY:", data:"ttl_qty","defaultContent": "",},
{title:"Total AMT:", data:"ttl_amt","defaultContent": "",},
{title:"Delivery Tag:", data:"dr_tag","defaultContent": "",},
{title:"DR Created by:", data:"ld_crt","defaultContent": "",},
{title:"Ref/Doc#:", data:"ref_co","defaultContent": "",}


],
// "columnDefs": [
// { 

//   targets: [4,5],
//   render: function ( data, type, row) {
//       if(type === 'display'){
//          if(data == 'Y'){
//             data = '<i class="fa fa-check"></i>'
//           }


//   }
//   return data;
// }
// }
// ],

columnDefs: [
  {
    targets: 4,
    render: $.fn.dataTable.render.number(',', '.', 2, '')
    
  }
],

rowCallback: function(row, data, index){
if(data['dr_tag'] == 'Y'){
// $(row).find('td:eq(5)').css('color', 'red');
$(row).find('td:eq(5)').html('<i class="fa fa-check"></i>')
}
}
});




} // end of function 1



function dash_2data(){
$.post('functions/fetch_data.php',{mode:'pd_dash_2'},function(data){
// console.log(data);
pudata_dtbl(data);
},'json');
}

dash_2data();

var table1
function pudata_dtbl(t){
const dataset=t.rptdata2;

table1 =  $("#pu_data").DataTable({

"dom":
'B<"pull-left"lf><"pull-right">tip',
// stateSave: true,

"info": false,
"pagingType": "full_numbers",
"bDestroy": true,
"responsive": true, "lengthChange": false, "autoWidth": false,
"searching": false,
"pageLength":5,
"data": dataset,
order: [[0, 'desc']],

"columns": [
// {title:"NUM", data:"id","defaultContent": "",},
{title:"", data:"upt_id","defaultContent": "",},
{title:"Date Updated:", data:"date_updated","defaultContent": "",},
{title:"OWI SKU:", data:"OWI_SKU","defaultContent": "",},
{title:"Previous Price:", data:"prev_price","defaultContent": "",},
{title:"", data:"mrk","defaultContent": "",},
{title:"Updated Price:", data:"new_price","defaultContent": "",},
{title:"Updated By:", data:"user_name","defaultContent": "",}

],



"columnDefs": [
{ 

  targets: 4,
  "width": "1%",
  render: function ( data, type, row) {
      if(type === 'display'){
         if(data == 'Mark Up Price for this SKU.'){
            data = '<i class="fas fa-long-arrow-up"></i>'
          }
         else if(data == 'Mark Down Price for this SKU.'){
            data = '<i class="fas fa-long-arrow-down"></i>'
          }

  }
  return data;
}
},
{ 
                target: 0,
                visible: false,

}
],
});




} // end of function 1




} );

</script>	


