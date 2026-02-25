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
            <h1 class="m-0" id="content_title">Create Consignment Order Form</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Add SKU</a></li>
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
      <form method="post" name="cof_br" id="cof_br" enctype="multipart/form-data">

<div class="row">
            <div class="col-md-4 col-sm-6 col-12 divBrnchCd">

            <select class="form-select form-control" id="slct_branch" name="slct_branch">
            <option selected disabled>Select Branch</option>
            <option value="PQIN">Puregold Q.I Central</option>
            <option value="PTAG">Puregold Taguig</option>
            <option value="PCOM">Puregold Commonwealth</option>
            <option value="PVAL">Puregold Valenzuela</option>
            <option value="PLIB">Puregold Libertad</option>
            <option value="PMAK">Puregold Makati</option>
            <option value="PMON">Puregold Montalban</option>
            <option value="PSUC">Puregold Sucat</option>
            <option value="PTAY">Puregold Tayuman</option>
            <option value="PLAS">Puregold Las Piñas</option>
            <option value="PDAU">Puregold Dau</option>
            
            </select>

            <br>
            <br>
            <br>
            <!-- /.col -->


            </div>
            <div class="col-md-4 col-sm-6 col-12 divBrnchCd">
            <input type="hidden" name="operation" id="operation" value="cofres" >

            <button type="button" id="btnBrnchCd" name= "btnBrnchCd" class="btn btn-info">Enter</button>
                  
            </div>
            </div> <!-- / .row -->

      </form>

      <!-- start co form -->
      <div class="col-md-12 co_form">
      <form method="post" name="cof_form" id="cof_form" enctype="multipart/form-data">
        <div class="row">
        <div class="col-md-6 input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">RPRO PO #:</span>
                  </div>
                  <input type="text" class="form-control" name="rpro_po" id="rpro_po" autocomplete="off" required minlength="2">
                </div>  
            <div class="col-md-6 input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Ref / Doc #:</span>
              </div>
              <input type="text" class="form-control" name="ref_co" id="ref_co" autocomplete="off" required minlength="2">
            </div>  


        <div class="col-md-3 input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Input ALU:</span>
                  </div>
                  <input type="text" class="form-control" name="OWI_SKU" id="input_alu" autocomplete="off" required minlength="2">
                </div>  
                <div class="col-md-3 input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">INPUT QTY:</span>
                  </div>
                  <input type="text" class="form-control" name="consign_qty" id="input_qty" autocomplete="off" disabled required>
                </div>  
                <div class="col-md-3 input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">COF-SERIES:</span>
                  </div>
                  <input type="text" class="form-control" name="consign_tag" id="tag_id" readonly>
                 
                </div>  
                <input type="hidden" class="form-control" name="cof_counter" id="cof_counter" readonly>
                  <input type="hidden" class="form-control"  id="comval" readonly>
               <input type="hidden" name="branch_id" id="branch_id"  readonly >
               <input type="hidden" name="contract_val" id="contract_val"  >
               <input type="hidden" name="alu_price" id="alu_price"  >
               <input type="hidden" name="ttl_price" id="ttl_price"  >
               <!-- <input type="hidden" name="date_created" id="date_created"  > -->

               <input type="hidden" name="operation" id="operation" value="Add" >

 
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
	                            <th class="text-capitalize text-center py-1 px-2">ALU</th>
	                            <th class="text-capitalize text-center py-1 px-2">PG_UPC</th>
	                            <th class="text-capitalize text-center py-1 px-2">PG SKU</th>
	                            <th class="text-capitalize text-center py-1 px-2">DESCRIPTION</th>
	                            <th class="text-capitalize text-center py-1 px-2">QTY</th>
	                            <th class="text-capitalize text-center py-1 px-2">SRP</th>
	                            <th class="text-capitalize text-center py-1 px-2">CONTRACT #</th>
	                            <th class="text-capitalize text-center py-1 px-2">Edit</th>

	                        
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
  $('#content_title').html('Consignment Order Form');
  $('.co_form').fadeIn();

  function get_cof(){
$.post('functions/fetch_data.php',{mode:'cof_counter'},function(data){
let cof_counterx = jQuery.parseJSON(data);
const cof= cof_counterx;
$('#tag_id').val(branchCd +"-"+String('0000' + cof[0].cof_counter).slice(-4)+"-"+last2Num );
$('#cof_counter').val(cof[0].cof_counter);
console.log(cof[0].cof_counter)

});


}
  
// get_cof();

let _getcof = get_cof();
  
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
    case "PLIB":
    $("#branch_id").val("5");
    break;
    case "PMAK":
    $("#branch_id").val("6");
    break;
    case "PMON":
    $("#branch_id").val("7");
    break;
    case "PSUC":
    $("#branch_id").val("8");
    break;
    case "PTAY":
    $("#branch_id").val("9");
    break;
    case "PLAS":
    $("#branch_id").val("10");
    break;
    case "PDAU":
    $("#branch_id").val("11");
    break;

  default:
    break;
}


let getcofupt = document.getElementById('cof_br');
let FormDatax2 = new FormData(getcofupt); 
  $.ajax({
        url: "functions/insert.php",
        method: "POST",
        data: FormDatax2,
        contentType: false,
        processData: false,
        success: function (data) {
          // alert('testcoffix');
          get_cof();
        },
        error: function (error) {
       
}
      });

});

getcom();

function getcom(){

  $("#input_alu").keyup(function(){
        inalu = $('#input_alu').val();
    var cmval = $('#comval').val();

        $.ajax({
    url:"functions/fetch_data.php",
    method:'POST',
     data:{inalu:inalu, cmval:cmval, mode:'fetch_con'},
    success:function(data)
    {
      var b = JSON.parse(data);
      // console.log(b)

      $("#contract_val").val(b[1].COM);
      $("#alu_price").val(b[1].price);

    }
   });
 
    });

}

function getttlamt(){

let ipt_qty = $('#input_qty').val();
let al_prc = $('#alu_price').val();
let ttl_1 = al_prc * ipt_qty;

$('#ttl_price').val(ttl_1);


}



function verSKU(){
$.post('functions/fetch_data.php',{mode:'versku'},function(data){
// console.log(data);
let skures = JSON.stringify(data)
// console.log(skures)
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
      getttlamt();
      console.log($('#ttl_price').val())
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
     data:{input_alu:input_alu, comval:comval, mode:'fetch_alu'},
    success:function(data)
    {
        // console.log(comval)
        var input_qty = $('#input_qty').val();
//   var trnAmt = value.trnAmountE;
       
      var a = JSON.parse(data);
      console.log(a);
    //   $('#table_list tbody').append("<tr><td>" + a[1].OWI_SKU + "</td><td>");
      $('#table_list tbody').append("<tr><td>" + a[1].OWI_SKU + "</td><td>" + a[1].PG_UPC + "</td><td>" + a[1].PG_SKU +  "</td><td>" + a[1].OWI_DESCRIPTION + "</td><td>" + input_qty + "</td><td>" + a[1].PRICE + "</td><td>" + a[1].COM + "</td></tr>");
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


// $('#btnBrnchCd').click(function (e) { 
//   e.preventDefault();

// });


    }); // docready/


</script>

