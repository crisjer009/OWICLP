
 <?php
//  session_start();
 date_default_timezone_set("Asia/Manila");
  include 'templates/navbar.php';
  include 'templates/sidebar.php';
 ?>


<style>


td:nth-child(4) {
  font-size: 20px;
}
td:nth-child(5) {
  font-size: 20px;
}


</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Generate Delivery Receipt</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Generate Delivery Receipt</a></li>
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
      <form method="post" name="dr_form" id="dr_form" enctype="multipart/form-data">
      <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gen_dr_print_Modal">Large modal</button> -->
<div class="row">
<div class="col-md-6 mb-4">
  <input type="text" class="form-control" name="cof" id="cof" placeholder="Input COF Series #" >
<input type="hidden" name="branch_id" id="branch_id">
<input type="hidden" name="ld_user_secID" id="ld_user_secID">
<input type="text" name="ld_series" id="ld_series">

</div>
<div class="col-md-6 dr_delDate">
<input type="date" class="form-control" name="dr_delDate" id="dr_delDate"  placeholder="Created Date" placeholder="Input Delivery Date" required />
</div>
<div class="col-md-2"><input type="submit" id="extract" name="extract" value="Extract" class="form-control btn-info"></div>
<div class="col-md-2"><input type="button" id="btn-refresh" name="btn-refresh" value="Refresh" class="form-control btn-warning"></div>
<div class="col-md-2"><input type="button" id="prnt" name="prnt" value="Print for Picking" class="form-control btn-warning"></div>
<div class="col-md-2"><input type="submit" id="rpnt" name="rpnt" value="Create DR" class="form-control btn-success"></div>
<input type="hidden" name="operations" id="operations" value="" >


 
</form>

</div>
<div class="col-md-12">

<div class="card-body table-responsive p-0">

<table class="table tbl-global table-bordered table-valign-middle display" id="genpo_data">
<tfoot>
            <tr>
                <th  style="text-align:right"></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>

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




$(document).ready(function () {

  $('#dr_delDate').focus();
  $('.dr_delDate').hide();


  $( "#extract" ).on( "click", function(e) {
    var ldUser = "<?php echo $_SESSION['ld_user_secID'] ?>";
    $('#operations').val('dr_rpnt');
    e.preventDefault();
    var cof = $('#cof').val();
    $.ajax({
    url:"functions/fetch_data.php",
    method:'POST',
     data:{cof:cof, mode:'brid'},
    success:function(data)
    {
      var a = JSON.parse(data);
      if (a[0].dr_tag == 'Y') {
        $('.dr_delDate').show();
        $('#branch_id').val(a[0].branch_id);
        $('#genMod_branch_id').val(a[0].branch_id);
        $('#ld_user_secID').val(ldUser);
        // testjer(ldUser);
        // dr_counterx(a[0].branch_id);
        $('#extract').prop('disabled', true);
        // console.log(a) 
      } else {
        alert('THIS COF HAS NOT BEEN PRINTED YET')
        $('#extract').prop('disabled', true);
        $('#rpnt').prop('disabled', true);

        return false;
      }





    }
   });


// function testjer(x)
// {

//   $.ajax({
//     url:"functions/fetch_data.php",
//     method:'POST',
//      data:{cof:cof,x:x,mode:'dr_counter'},
//     success:function(data)
//     {

//       const last2 = new Date().getFullYear().toString().substring(2);
// // console.log(last2); // 👉️ has type of string
// const last2Num = Number(last2);


//       var drseries = JSON.parse(data);
//       // console.log(drseries)
//       var append_dr_series = String('0000' + drseries[0].dr_counter).slice(-4);
//       let br_id = $('#ld_user_secID').val();  
// switch (br_id) {
//   case '1':
//     // $('#ld_series').val('PQIN'+'-'+drseries[0].dr_counter);
//     $('#ld_series').val(last2+'-'+'LDL'+'-'+append_dr_series);
//     break;
//   case '2':
//     $('#ld_series').val(last2+'-'+'LDI'+'-'+append_dr_series);
//     break;

//   default:
//     break;
// }
// // var k = $('#ld_series').val();
// // console.log(k)
// // printModal(k);

//     }
//    });


// }
   getdata();
$('#branch_id').val();
    function getdata(cof){
    var cof = $('#cof').val();
//data table start
$.post('functions/fetch_data.php',{cof:cof, mode:'gen_dr'},function(data){
console.log(data);
admin_datatable(data);
admin_datatable12(data);
},'json');
}
var table
function admin_datatable(t){
const dataset=t.rptdata;

table =  $(".tbl-global").DataTable({

"dom":
'B<"pull-left"lf><"pull-right">tip',
// stateSave: true,
language: {
  decimal: ',',
  thousands: '.',
},
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
// {title:"NUM", data:"id","defaultContent": "",},
{title:"", data:"","defaultContent": "",},
{title:"ALU:", data:"OWI SKU","defaultContent": "",},
{title:"PG_UPC:", data:"PG_UPC","defaultContent": "",},
{title:"PG_SKU:", data:"PG_SKU","defaultContent": "",},
{title:"OWI DESCRIPTION:", data:"OWI DESCRIPTION","defaultContent": "",},
{title:"BRAND:", data:"BRAND","defaultContent": "",},
{title:"COLOR:", data:"COLOR","defaultContent": "",},
{title:"SIZE:", data:"SIZE","defaultContent": "",},
{title:"QTY:", data:"consign_qty","defaultContent": "",},
{title:"UNIT:", data:"UNIT","defaultContent": "",},
{title:"PRICE", data:"PRICE","defaultContent": "",},
{title:"TOTAL", data:"TOTAL","defaultContent": "",},
{title:"CONTRACT #", data:"contract_num","defaultContent": "",},
// {title:"Print", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><a href='' target='_blank'><i class='fas fa-print'></i></a></Button>"}
{title:"EDIT", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><i class='fas fa-print'></i></a></Button>"}



],
columnDefs: [
  {
    targets: [10,11],
    render: $.fn.dataTable.render.number(',', '.', 2, '')
  }
],  footerCallback: function (row, data, start, end, display) {
            var api = this.api();
 
            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
            var numFormat =  $.fn.dataTable.render.number(',', '.', 2, '').display;
        
            // Total over all pages
            total = api
                .column(11)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


                total1 = api
                .column(8)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


 
            // Total over this page
            pageTotal = api
                .column(11, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                pageTotal1 = api
                .column(8, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                pageQTY = api
                .column(8, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
            // Update footer
            $(api.column(7).footer()).html('TOTAL QTY:' );
            $(api.column(8).footer()).html(pageTotal1 );
            $(api.column(10).footer()).html('Grand Total:' );
            $(api.column(11).footer()).html(numFormat(pageTotal));

        }
 
});


table.on('order.dt search.dt', function () {
        let i = 1;
 
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();

$('#genpo_data tbody').on('click', 'button', function () {


var data = table.row( $(this).parents('tr') ).data();


$('#gen_dr_modal').modal('show');
$('#consign_tag').val(data['consign_tag']);
$('#form_sku').val(data['OWI SKU']);
$('#consign_qty').val(data['consign_qty']);
// console.log($('#operation').val())

    } );

    $(document).on("submit", "#gen_dr_form", function (e) {
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
          getdata();
          // getdata1();
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

dr_counterx();

jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
    return this.flatten().reduce( function ( a, b ) {
        if ( typeof a === 'string' ) {
            a = a.replace(/[^\d.-]/g, '') * 1;
        }
        if ( typeof b === 'string' ) {
            b = b.replace(/[^\d.-]/g, '') * 1;
        }
 
        return a + b;
    }, 0 );
} );


 var table
 function frdatable(t){
 const dataset=t.rptdata;
 
 table =  $(".tbl-global").DataTable({

 
 "dom":
 'B<"pull-left"lf><"pull-right">tip',
 // stateSave: true,
//  "ordering": false,
 "info": false,
 "pagingType": false,
 "bDestroy": true,
 "responsive": true, "lengthChange": false, "autoWidth": false,
 "language": {
 "search": "_INPUT_",
 "searchPlaceholder": "Search..."
 },
 "pageLength":6,
 "data": dataset,
 
 "columns": [
 {title:"NUM", data:"id","defaultContent": "",},
 {title:"ALUXXXX:", data:"OWI SKU","defaultContent": "",},
 {title:"PG_UPC:", data:"PG_UPC","defaultContent": "",},
 {title:"PG_SKU:", data:"PG_SKU","defaultContent": "",},
 {title:"OWI DESCRIPTION:", data:"OWI DESCRIPTION","defaultContent": "",},
 {title:"BRAND:", data:"BRAND","defaultContent": "",},
 {title:"COLOR:", data:"COLOR","defaultContent": "",},
 {title:"SIZE:", data:"SIZE","defaultContent": "",},
 {title:"QTY:", data:"consign_qty","defaultContent": "",},
 {title:"UNIT:", data:"UNIT","defaultContent": "",},
 {title:"PRICE", data:"PRICE","defaultContent": "",},
 {title:"TOTAL", data:"TOTAL","defaultContent": "",},
 {title:"CONTRACT #", data:" sarapppp d","defaultContent": "",},
 // {title:"Print", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><a href='' target='_blank'><i class='fas fa-print'></i></a></Button>"}
 // {title:"EDIT", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><i class='fas fa-print'></i></a></Button>"}
 
 
 
 ],
   columnDefs: [{
     "defaultContent": "-",
     "targets": "_all"
   }]
 });
 
 
 }; //end




    
}); // end of extract click

function dr_counterx() {

  $('#rpnt').click(function (e) { 
    e.preventDefault();
    
    var br = $('#branch_id').val();
    var cof = $("#cof").val();
    var ld_series = $("#ld_series").val();
  var operations = $("#operations").val();
  var delDate = $('#del_date').val();
//   console.log($("#ld_series").val())
if (operations != "") {

  $(document).on("click", "#dr_form", function (e) {
    e.preventDefault();
    $('#operations').val('dr_rpnt');
      $.ajax({
        url: "functions/insert.php",
        method: "POST",
        data: new FormData(this), br:br,
        contentType: false,
        processData: false,
        success: function (data) {
          Swal.fire({
             icon: 'success',
             title: 'Your work has been saved',
             showConfirmButton: false,
             timer: 1500
          });
          drInfo(cof);
         
          $('#gen_dr_print_Modal').modal('show');
          // $(".print_area").print();
        },
      });

  });

} else {
  alert('please input date');
  return false;
  
}

  });

}


$('#prnt').click(function (e) { 
    e.preventDefault();
    
    var br = $('#branch_id').html();
    var cof = $("#cof").html();
    var ld_series = $("#ld_series").html();
  var operations = $("#operations").html();
  var delDate = $('#del_date').html();
//   console.log($("#ld_series").val())
  // frdatable(data);
          // drInfo(ld_series);
         
          $('#gen_dr_print_Modal').modal('show');



  });

$('#btn-refresh').click(function (e) { 
  e.preventDefault();
  location.reload();
});


// printModal();

function drInfo(xl)
{

  $.ajax({
    url:"functions/fetch_data.php",
    method:'POST',
     data:{xl:xl,mode:'re_print_dr'},
    success:function(data)
    {
        // console.log(data)
      var drxinfo = JSON.parse(data);
        $('#dr_srs').append(drxinfo[0].dr_tag);
        // $('#dr_srs').append(drxinfo[0].dr_tag);
        $('#del_comp').append(drxinfo[0].branch_longDesc);
        $('#del_date').append(drxinfo[0].del_date);
        $('#del_add').append(drxinfo[0].branch_address);
        // $('#del_add').append(drxinfo[0].branch_address);
        $('#del_PO').append(drxinfo[0].consign_tag);
        

    }
   });


}

$('.scdcol').hide();
  

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





// $(".btnmodalres").click(function (e) { 
//   e.preventDefault();
//   // alert('save');
  
// });

}); // end of ready


</script>

<?php
  include 'gen_dr_modal.php';
  include 'gen_dr_print.php';

?>



