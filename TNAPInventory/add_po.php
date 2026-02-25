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
            <!-- <option value="PQIN">Puregold Q.I Central</option>
            <option value="PTAG">Puregold Taguig</option>
            <option value="PCOM">Puregold Commonwealth</option>
            <option value="PVAL">Puregold Valenzuela</option>
            <option value="PLIB">Puregold Libertad</option>
            <option value="PMAK">Puregold Makati</option>
            <option value="PMON">Puregold Montalban</option>
            <option value="PSUC">Puregold Sucat</option>
            <option value="PTAY">Puregold Tayuman</option>
            <option value="PLAS">Puregold Las Piñas</option>
            <option value="PDAU">Puregold Dau</option> -->
            <option value="TNAP">TNAP</option>
            
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
      
      <!-- <table class="table table-bordered table-striped co_form" id="table_list">
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
	                </table> -->




                  <table class="table table-striped table-valign-middle table_datatbl" id="cof_datatable">
</table>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include 'templates/footer.php';?>

<script type="text/javascript">



    $(document).ready(function () {

//       window.onbeforeunload = function (e) {
//     e = e || window.event;

//     // For IE and Firefox prior to version 4
//     if (e) {
//         e.returnValue = 'Any string';
//     }

//     // For Safari
//     return 'Any string';
// };

      


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
// console.log(cof[0].cof_counter)


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
    case "TNAP":
    $("#branch_id").val("100");
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




// DATATABLE FOR COF WITH EDIT ROWS
// STARTS HERE....

function coftagres(tag_id){
    var tag_id = $('#tag_id').val();
    console.log(tag_id);
//data table start
$.post('functions/fetch_data.php',{tag_id:tag_id, mode:'cof_datatbl'},function(data){
console.log(data);
cof1_datatable(data);
},'json');
}


var table
function cof1_datatable(t){
const dataset=t.rptdatacof;

table=  $("#cof_datatable").DataTable({

"dom":
'B<"pull-left"lf><"pull-right">tip',
// stateSave: true,

"info": false,
// "pagingType": false,
"bPaginate": false,
"bDestroy": true,
"responsive": true, "lengthChange": false, "autoWidth": false,
"language": {
"search": "_INPUT_",
"searchPlaceholder": "Search..."
},
// "pageLength":1000,
"data": dataset,

"columns": [
{title:":", data:"","defaultContent": "",},
{title:"ALU:", data:"OWI_SKU","defaultContent": "",},
{title:"PG UPC:", data:"PG_UPC","defaultContent": "",},
{title:"PG SKU:", data:"PG_SKU","defaultContent": "",},
{title:"DESCRIPTION:", data:"OWI_DESCRIPTION","defaultContent": "",},
{title:"QTY:", data:"consign_qty","defaultContent": "",},
{title:"SRP:", data:"idv_amt","defaultContent": "",},
{title:"AMOUNT:", data:"amt","defaultContent": "",},
{title:"CONTRACT #:", data:"contract_num","defaultContent": "",},


// {title:"Print", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><a href='' target='_blank'><i class='fas fa-print'></i></a></Button>"}
{title:"EDIT", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><i class='fas fa-print'></i></a></Button>"}



],
columnDefs: [
  {
    targets: [7],
    render: $.fn.dataTable.render.number(',', '.', 2, '')
  }
]
  
 
});


table.on('order.dt search.dt', function () {
        let i = 1;
 
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();

$('#cof_datatable tbody').on('click', 'button', function (e) {
  e.preventDefault();
  e.stopImmediatePropagation();
  let genmodfetch =$("#branch_id").val();
console.log(genmodfetch)
var data = table.row( $(this).parents('tr') ).data();
// console.log(data)
// alert('click');
$('#gen_dr_modal').modal('show');
$('#consign_tag').val(data['consign_tag']);
$('#form_sku').val(data['OWI_SKU']);
$('#consign_qty').val(data['consign_qty']);
$('#genMod_branch_id').val(genmodfetch);

    } );

    $(document).on("submit", "#gen_cof_form", function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var consign_qty = $("#consign_qty").val();
    // console.log(consign_qty)

    if ( consign_qty != "") {
      $.ajax({
        url: "functions/insert.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (data) {
          // console.log(data)
          Swal.fire({
             icon: 'success',
             title: 'Your work has been saved',
             showConfirmButton: false,
             timer: 1500
          });
          $('#gen_dr_modal').modal('hide');
          coftagres();
          $('#gen_dr_form')[0].reset();
          $('.scdcol').hide();
          $('#action').prop('disabled', true);

          

          
        },
      });
    } else {
      alert("Test failed.");
      return false;
    }
    // e.preventDefault();
    // clearconsole();
  });

}; //end of datatable




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
      // console.log($('#ttl_price').val())
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
      coftagres();
      // cof1_datatable();
      // coftagres();
      // console.log(a);
    //   $('#table_list tbody').append("<tr><td>" + a[1].OWI_SKU + "</td><td>");
      // $('#table_list tbody').append("<tr><td>" + a[1].OWI_SKU + "</td><td>" + a[1].PG_UPC + "</td><td>" + a[1].PG_SKU +  "</td><td>" + a[1].OWI_DESCRIPTION + "</td><td>" + input_qty + "</td><td>" + a[1].PRICE + "</td><td>" + a[1].COM + "</td></tr>");
      $("#contract_val").val(a[1].COM);
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
          // console.log(data)
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


$("#slct_ops").change(function () { 
    
    // alert('selected');
    $('.scdcol').show();

    $('#action').prop('disabled', false);
 var slct_val = $("#slct_ops").val();
//  console.log(slct_val)
    if (slct_val == 1) {
      
      $("#cs_edit_title").html("Quantity to be Added:");
    }
    else{

      $("#cs_edit_title").html("Quantity to be Deduct:");

    }

  });

  $("#cs_edit_val").keyup(function(){
    var orgqty = parseFloat($('#consign_qty').val());
    var edtqty = parseFloat($('#cs_edit_val').val());
    var slct_valx = $("#slct_ops").val();
    var newqty = $("#cs_new_val").val();
    if (slct_valx == 1) {
    var a =  orgqty + edtqty;
    $("#cs_new_val").val(a);
    // console.log(a);
      
    }
    else{
      var a =  orgqty - edtqty;
      $("#cs_new_val").val(a);
      // console.log(a);
    }


     
    });




// $('#btnBrnchCd').click(function (e) { 
//   e.preventDefault();

// });


    }); // docready/


</script>

<?php
  include 'gen_cof_modal.php';
  // include 'gen_dr_print.php';

?>
