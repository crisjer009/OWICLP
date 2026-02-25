
 <?php
//  session_start();
 date_default_timezone_set("Asia/Manila");
  include 'templates/navbar.php';
  include 'templates/sidebar.php';
  include 'upt_modal.php';
 
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
$.post('functions/fetch_data.php',{mode:'upt_res'},function(data){
console.log(data);
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
"searchPlaceholder": "Search..."
},
"pageLength":6,
"data": dataset,

"columns": [
// {title:"NUM", data:"id","defaultContent": "",},
{title:"SKU:", data:"OWI SKU","defaultContent": "",},
{title:"OWI DESCRIPTION:", data:"OWI DESCRIPTION","defaultContent": "",},
{title:"ITEM CODE:", data:"ITEM CODE","defaultContent": "",},
{title:"PG UPC:", data:"PG UPC","defaultContent": "",},
{title:"PRICE", data:"PRICE","defaultContent": "",},
// {title:"Print", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><a href='' target='_blank'><i class='fas fa-print'></i></a></Button>"}
{title:"EDIT", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><i class='fas fa-print'></i></a></Button>"}



],
  columnDefs: [{
    "defaultContent": "-",
    "targets": "_all"
  }]
});

 $('#masterfile_data tbody').on('click', 'button', function () {
var data = table.row( $(this).parents('tr') ).data();
console.log(data)
$('#form_sku').val(data['OWI SKU']);
$('#owi_desc').val(data['OWI DESCRIPTION']);
$('#pg_upc').val(data['PG UPC']);
$('#sku_price').val(data['PRICE']);
$('#prev_price').val(data['PRICE']);
$('#prev_upc').val(data['PG UPC']);
$('#item_code').val(data['ITEM CODE']);
$('#upt_modal').modal('show');
    } );

    $(document).on("submit", "#sku_form", function (e) {
    e.preventDefault();

    var priceVal = $("#sku_price").val();
    let OldPriceVal = $('#prev_price').val();
    let GTPriceValRes = 'Mark Up Price for this SKU.';
    let LTPricevalRes = 'Mark Down Price for this SKU.';

    if (priceVal > OldPriceVal) {
      $('#upt_reason').val(GTPriceValRes);
      
    }
    else{
      $('#upt_reason').val(LTPricevalRes);
    }


    if ( priceVal != "") {
      $.ajax({
        url: "functions/insert.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (data) {
          Swal.fire({
             icon: 'success',
             title: 'Your work has been saved',
             showConfirmButton: false,
             timer: 1500
          });
          $('#upt_modal').modal('hide');
          getdata();
        },
      });
    } else {
      alert("Test failed.");
      return false;
    }
    clearconsole();
  });


} // end of function





} );

</script>	


