
 <?php
//  session_start();
 date_default_timezone_set("Asia/Manila");
  include 'templates/navbar.php';
  include 'templates/sidebar.php';
  include 'acct_addSL_modal.php';
 
 ?>

 <style>
.pull-left{
float: left !important;
}


 </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0" id="txt_uptsl">Add Sales</h1>
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
            <div class="col-md-4 col-sm-6 col-12 divBrnchCd">

            <select class="form-select form-control" id="slct_branch" name="slct_branch">
            <option selected disabled>Select Branch</option>
            <option value="PQIN">Puregold Q.I Central</option>
            <option value="PTAG">Puregold Taguig</option>
            <!-- <option value="PCOM">Puregold Commonwealth</option>
            <option value="PVAL">Puregold Valenzuela</option> -->
            </select>

            <br>
            <br>
            <br>
            <!-- /.col -->


            </div>
            <div class="col-md-4 col-sm-6 col-12 divBrnchCd">
       
            <button type="button" id="btnBrnchCd" class="btn btn-info">Enter</button>
                  
            </div>
            </div> <!-- / .row -->

<input type="hidden" name="comval" id="comval">
<input type="hidden" name="branch_id" id="branch_id">


<div class="row">
<div class="col-md-4">
  <!-- <input type="text" class="form-control" placeholder="Input ALU"> -->
</div>
<!-- <div class="col-md-2"><input type="submit" value="Locate" class="form-control btn-info"></div> -->


</div>
<div class="col-md-12 tblDiv">

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

  $('.dataTables_filter').addClass('pull-left');


$(".tblDiv").hide();

$("#btnBrnchCd").click(function(){

  var comVal = $("#comval").val();
var slct_branch =$("#slct_branch").val();
console.log(slct_branch)

//   alert(branchCd);

  $('.divBrnchCd').fadeOut();
  $('.tblDiv').fadeIn();

//   function get_cof(){
// $.post('functions/fetch_data.php',{mode:'cof_counter'},function(data){
// let cof_counterx = jQuery.parseJSON(data);
// const cof= cof_counterx;
// $('#tag_id').val(branchCd +"-"+String('0000' + cof[0].cof_counter).slice(-4)+"-"+last2Num );
// $('#cof_counter').val(cof[0].cof_counter);

// });


// }

  
  $('#comval').val(slct_branch);
switch (slct_branch) {
  case "PQIN":
    $("#branch_id").val("1");
    // alert('PQN')
    $("#txt_uptsl").text("ADD SALES FOR PUREGOLD QI");
    break;
    case "PTAG":
    $("#branch_id").val("2");
    break;
    case "PCOM":
    $("#branch_id").val("3");
    break;
    case "PVAL":
    $("#branch_id").val("4");
    break;

  default:
    break;
}

});

  function getdata(){
$.post('functions/fetch_data.php',{mode:'sls_res'},function(data){
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
"searchPlaceholder": "Search PG SKU HERE...."
},
"pageLength":6,
"data": dataset,

"columns": [
// {title:"NUM", data:"id","defaultContent": "",},
{title:"PG SKU:", data:"PG_SKU","defaultContent": "",},
{title:"OWI ALU:", data:"OWI SKU","defaultContent": "",},
{title:"OWI DESCRIPTION:", data:"OWI DESCRIPTION","defaultContent": "",},
{title:"INVENTORY RECEIVED:", data:"inv_qty","defaultContent": "",},
{title:"SALES:", data:"sls_qty","defaultContent": "",},
{title:"INVENTORY ON-HAND:", data:"ONHAND","defaultContent": "",},
// {title:"PRICE", data:"PRICE","defaultContent": "",},
// {title:"Print", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><a href='' target='_blank'><i class='fas fa-print'></i></a></Button>"}
{title:"ADD ORDER", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><i class='fas fa-print'></i></a></Button>"}



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
$('#pg_upc').val(data['PG_SKU']);
$('#sku_price').val(data['PRICE']);
$('#sls_price').val(data['PRICE']);
$('#prev_price').val(data['PRICE']);
$('#prev_upc').val(data['PG UPC']);
$('#item_code').val(data['ITEM CODE']);
$('#acct_addSL_modal').modal('show');
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
          $('#acct_addSL_modal').modal('hide');
          getdata();
        },
      });
    } else {
      alert("Test failed.");
      return false;
    }
    // clearconsole();
  });


} // end of function





} );

</script>	


