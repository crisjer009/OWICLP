<?php
//   include 'd';
  include 'templates/navbar.php';
//   include 'condb.php';
  include 'templates/sidebar.php';
 
 ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0" id="content_title">SALES</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Transact</a></li>
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
            <option selected disabled>Select branch you want to transact</option>
            <option value="TNAP">TNAP</option>
            <!-- <option value="PTAG">Puregold Taguig</option> -->
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

      <!-- start co form -->
      <div class="col-md-12 co_form">
      <form method="post" name="cof_form" id="cof_form" enctype="multipart/form-data">
        <div class="row">
        <div class="col-md-6 input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">EDI-Invoice Number:</span>
                  </div>
                  <input type="text" class="form-control" name="inv_no" id="inv_no" autocomplete="off" style="text-transform: uppercase;" required minlength="2">
                </div>  
                <div class="col-md-6 input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">EDI-Invoice Date:</span>
                  </div>
                  <input type="date" class="form-control" name="inv_dt" id="inv_dt" autocomplete="off" required minlength="2">
                </div>  
        <div class="col-md-3 input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">PG ALU:</span>
                  </div>
                  <input type="text" class="form-control" name="pg_alu" id="input_alu" autocomplete="off" required minlength="2">
                </div>  
                <div class="col-md-3 input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">INPUT QTY:</span>
                  </div>
                  <input type="text" class="form-control" name="pg_alu_qty" id="input_qty" autocomplete="off" disabled required>
                </div>  
                  <input type="hidden" class="form-control"  id="comval" readonly>
               <input type="hidden" name="branch_id" id="branch_id"  readonly >
               <input type="hidden" name="contract_val" id="contract_val"  >
               <!-- <input type="hidden" name="date_created" id="date_created"  > -->

               <input type="hidden" name="operation" id="operation" value="Transact" >

 
            <div class="col-md-3">
            <!-- <button type="button" class="btn-info" id="btn_submit" class="btn btn-info">Enter</button> -->
            <button type="button" class="btn-success" id="btn_save" class="btn btn-info">Save</button>

            </div>

            </div>
        </div>
      </form>
      

      </div>
      
      <table class="table table-bordered table-striped co_form" id="table_list">
	                    <thead>
	                        <tr class="bg-primary bg-gradient text-white">
                          <th class="text-capitalize text-center py-1 px-2">PG SKU</th>
                          <th class="text-capitalize text-center py-1 px-2">PG_UPC</th>
	                            <th class="text-capitalize text-center py-1 px-2"> OWI ALU</th>
	                            <th class="text-capitalize text-center py-1 px-2">DESCRIPTION</th>
	                            <th class="text-capitalize text-center py-1 px-2">QTY</th>
	                            <th class="text-capitalize text-center py-1 px-2">SRP</th>
	                            <th class="text-capitalize text-center py-1 px-2">CONTRACT #</th>

	                        
	                        </tr>
	                    </thead>
	                    <tbody>
	                    </tbody>
	                </table>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include 'templates/footer.php';?>

<script type="text/javascript">



    $(document).ready(function () {


        $('.co_form').hide();

$("#btnBrnchCd").click(function(){
  let branchCd =$("#slct_branch").val();
  let branch_dbid = $("#branch_id").val();
  const last2 = new Date().getFullYear().toString().slice(-2);
// console.log(last2); // 👉️ has type of string
const last2Num = Number(last2);



//   alert(branchCd);

  $('.divBrnchCd').fadeOut();
  $('#content_title').html('Transact');
  $('.co_form').fadeIn();
 
  $('#comval').val(branchCd);
switch (branchCd) {
  case "PQIN":
    $("#branch_id").val("1");
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
    case "TNAP":
    $("#branch_id").val("12");
    break;

  default:
    break;
}

});

getcom();

function getcom(){

  $("#input_alu").keyup(function(){
        inalu = $('#input_alu').val();
    var cmval = $('#comval').val();

        $.ajax({
    url:"functions/fetch_data.php",
    method:'POST',
     data:{inalu:inalu, cmval:cmval, mode:'PGfetch_con'},
    success:function(data)
    {
      var b = JSON.parse(data);
      console.log(b)

      $("#contract_val").val(b[1].COM);

  
    }
   });
 
    });

}



function verSKU(){
$.post('functions/fetch_data.php',{mode:'verPGSKU'},function(data){
// console.log(data);
let skures = JSON.stringify(data)
console.log(skures)
verALU(skures)
},'json');
}

verSKU();


function verALU(skures){


  $('#input_alu').keypress(function(event){
    // e.preventDefault();
  var keycode = (event.keyCode ? event.keyCode : event.which);
 
  if(keycode == '13'){

    var not_allowed = skures;
    if (not_allowed.indexOf($(this).val()) > 0) {
    $('#input_qty').removeAttr("disabled");
      $('#input_qty').focus();
    }
    else{
      alert('Invalid ALU');

    }

  }
});

  
}

verQTY();
function verQTY(){


  $('#input_qty').keypress(function(event){
    // e.preventDefault();
  var keycode = (event.keyCode ? event.keyCode : event.which);
  var zeroval = '0';
  if(keycode == '13'){

    if (this.value != '' && this.value != zeroval) {
    $('#input_qty').removeAttr("disabled");
      $('#input_alu').focus();
      _getalu();
      function _getalu(input_alu,qty){
    var input_alu = $('#input_alu').val();
    var comval = $('#comval').val();
    // console.log(comval)
var input_qty = $('#input_qty').val();
 // validation
 if (input_alu == "" || input_qty == "") {

  // alert("REQUIRED");
  return false;
 }
 else {
  $.ajax({
    url:"functions/fetch_data.php",
    method:'POST',
     data:{input_alu:input_alu, comval:comval, mode:'fetch_pg_sku'},
    success:function(data)
    {
        // console.log(comval)
        var input_qty = $('#input_qty').val();
//   var trnAmt = value.trnAmountE;
       
      var a = JSON.parse(data);
      console.log(a);
    //   $('#table_list tbody').append("<tr><td>" + a[1].OWI_SKU + "</td><td>");
      $('#table_list tbody').append("<tr><td>" +a[1].PG_SKU  + "</td><td>" + a[1].PG_UPC + "</td><td>" + a[1].OWI_SKU  +  "</td><td>" + a[1].OWI_DESCRIPTION + "</td><td>" + input_qty + "</td><td>" + a[1].PRICE + "</td><td>" + a[1].COM + "</td></tr>");
      // $("#contract_val").val(a[1].COM);
      $('#input_alu').val("");
      $('#input_qty').val("");
      $('#input_qty').prop("disabled",true);  


  
    }
   });
 }


}

let form = document.getElementById('cof_form');
let formData = new FormData(form); 
  $.ajax({
        url: "functions/insert.php",
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
          console.log(data)
        },
        error: function (error) {
       
}
      });
    }
    else {
      alert('Please put quantity');
      $('#input_qty').val('');
      $('#input_qty').focus();
      // return false;
      
    }

  }
});

  
}





$('#btn_save').click(function (e) { 
  e.preventDefault();
  // alert('click');
   $('#operation').val("Save");
  // console.log($('#operation').val())
let formx = document.getElementById('cof_form');
let FormDatax = new FormData(formx); 
  $.ajax({
        url: "functions/insert.php",
        method: "POST",
        data: FormDatax,
        contentType: false,
        processData: false,
        success: function (data) {
          alert('Save!!!');
          location.reload();
        },
        error: function (error) {
       
}
      });
});


    }); // docready/


</script>

