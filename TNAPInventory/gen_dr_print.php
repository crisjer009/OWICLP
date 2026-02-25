
<style>

/* .modal {
  padding: 0 !important; // override inline padding-right added from js
} */


* {
padding:0;
border:0;
margin:0;
}
html, body {
    height:100%;
    width:100%;
}
/* body {
    border:1px solid black;
} */



.flscrn {
  width: 100%;
  max-width: none;
  height: 100%;
  margin: 0;
}
.modal .flscrncont {
  height: 100%;
  border: 0;
  border-radius: 0;
}
.modal .flscrnbdy {
  overflow-y: auto;
}

@media screen {
  #printSection {
      display: none;
  }
}

@media print {
  body * {
    visibility:hidden;
    
  }

  .pagebreak {
        clear: both;
        page-break-after: always;
    }
  @page {
    /* size: landscape; */
    /* margin: 0  ; */
    /* margin: 5px; */
    font-weight:normal;}
  
    



  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    
    position:absolute;
    left:0;
    top:0;
    font-size: 25px;
    font-family: sans-serif;
    font-weight:normal;

 
  }

  table tr td {
    
  font-size: 25px;
  font-family: sans-serif;
    font-weight:normal;
    /* border-collapse: collapse; */
    border-collapse: collapse;
  border: 3px solid #ccc;
}

  
    
}




</style>

<!-- <style type="text/css" media="print">
    @page { 
        size: landscape;
    }
    body { 
        writing-mode: tb-rl;
    }
</style> -->

<div class="modal fade modal-fullscreen" id="gen_dr_print_Modal" tabindex="-1" role="dialog" aria-hidden="true">

<!-- <div class="modal fade" id="gen_dr_print_Modal"> -->
  <div class="modal-dialog modal-lg flscrn">
  <form method="post" name="gen_dr_print" id="gen_dr_print" enctype="multipart/form-data">


    <div class="modal-content flscrncont">
      <div class="modal-header">
        <!-- <h4 class="modal-title">TITLE OF DR RECEIPT HERE</h4> -->
        <button
        id="clsmods"
          type="button"
          class="close"
          data-bs-dismiss="modal"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body flscrnbdy">

      <!-- <input type="text" name="pr_ldsrs" id="pr_ldsrs"> -->
      <div class="col-md-12" id="print_area">
  <div class="row mt-4">
    <div class="col-md-12">
  <img src="images/owi.png" alt="" srcset="">

    </div>
    <div class="col-md-4 mt-0">
    <p class="">Office Warehouse, Inc.	</p>
    <p class="font"> 4780 Ortigas Ave. Ext Brgy. Rosario, Pasig City 			
 Tel No. +63 (2) 437 5680 | Fax No. +63 (2) 655 8933 			</p>		
    </div>
    <div class="col-md-4">
    <p class=""><h3 class="text-center">DELIVERY RECEIPT</h3></p>
    </div>
    <div class="col-md-4">
    <p id="dr_srs" class=" text-center">DR:NO </p>
    <!-- append mo dr number rito -->

    </div>
    <div class="col-md-12">
    <p class=" "><h6 class="text-bold">DELIVERY INFORMATION</h6> </p>
    </div> 
    <div class="col-md-6">
    <p id="del_comp" class="">Company:</p>
    </div> 
    <div class="col-md-3">
    <!-- <p id="del_date" class=" text-center" aria-required="">Delivery Date:</p> -->
    </div> 
    <div class="col-md-3">
    <p id="del_date" class=" text-center" aria-required="">Created Date:</p>
    </div> 
    <div class="col-md-6">
    <p id="del_add" class="">Del.Add:</p>
    </div> 
    <div class="col-md-3">
    <!-- <p id="del_PO" class=" text-center ">PO/OS No:</p> -->
    </div> 
    <div class="col-md-3">
    <p id="del_PO" class=" text-center ">PO/OS No:</p>
    </div> 
    <div class="col-md-6">
    <!-- <p id="del_add" class="">Del.Add:</p> -->
    </div> 
    <div class="col-md-3">
    <!-- <p id="del_terms" class=" text-right ">Terms:</p> -->
    </div> 
    <div class="col-md-3">
    <p id="del_terms" class=" text-center ">Terms:</p>
    </div> 
    
    <div class="col-md-12">
    <p class=" "><h6 class="text-bold">ITEMS TO BE DELIVER</h6> </p>
    </div>
  </div>

  <div class="col-md-12">

  <div class="card-body table-responsive p-0">

<table class="table table-bordered border table-striped table-valign-middle display" id="frtable">
<tfoot>
            <tr>
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
  <!-- end of row -->

</div>
<br>
<br>
<br>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-3 mb-5">
    <h4>Prepared by:</h4>
    </div>
    <div class="col-md-3 mb-5">
      <h4>Checked by:</h4>
    </div>
    <div class="col-md-3 mb-5">
      <h4>Approve By:</h4>
    </div>
    <div class="col-md-3 mb-5">
    <h4>Date Delivered:</h4>
    </div>
    <div class="col-md-3 mb-4 " >
    <div class="col-md-6" style="width: 300px; display: table;">
    <span style="display: table-cell; border-bottom: 1px solid black;"></span>

    </div>
    </div>
    <div class="col-md-3 text-center mb-4"  >
    <div class="col-md-6" style="width: 300px; display: table;">
    <span style="display: table-cell; border-bottom: 1px solid black;"></span>

    </div>
    </div>
    <div class="col-md-3 text-center mb-4" >
    <div class="col-md-6" style="width: 300px; display: table;">
    <span style="display: table-cell; border-bottom: 1px solid black;"></span>

    </div>
    </div>
    <div class="col-md-3 mb-4">
    <div class="col-md-6" style="width: 300px; display: table;">
    <span style="display: table-cell; border-bottom: 1px solid black;"></span>

    </div>
    </div>
    <div class="col-md-9 mt-4">
      <div class="text-bold">IMPORTANT:</div>
      <br>
      <p>All overdue accounts will be charge an annual interest rate equivalent to the prevailing bank rate calculated from due date of the invoice until the same shall have been fully paid plus cost of collection and attorneys fees in the sum of 25% of the total due. Any ligitation arising from this transaction shall be submitted to the court of Quezon City.</p>
    </div>
    <div class="col-md-3 mt-4">
      <p>Received the above merchandise in good order & condition.</p>
    </div>
   
  </div>
</div>


      </div>
    <!-- modal body end -->

   
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dimdiss="modal">
          Close
        </button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        <input type="button" name="printMe" id="printMe" class="btn btn-success printMe" value="Print" />   

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
</form>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script type="text/javascript">
// getdata1();
// function getdata1(cof){
//     var cof = $('#cof').val();
// //data table start
// $.post('functions/fetch_data.php',{cof:cof, mode:'gen_dr'},function(data){
// console.log(data);
// admin_datatable12(data);
// },'json');
// }
var table
function admin_datatable12(t){
const datasetx=t.rptdata;

table =  $("#frtable").DataTable({

"dom":
'B<"pull-left"lf><"pull-right">tip',
// stateSave: true,

"info": false,
// "pagingType": false,
"bPaginate": false,
"bDestroy": true,
"responsive": true, "lengthChange": false, "autoWidth": false,
"searching": false,
// "pageLength":1000,
// "ordering": false,
"data": datasetx,

"columns": [
{title:"NUM", data:"cof_id","defaultContent": "",},
// {title:":", data:"OWI SKU","defaultContent": "",},
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
// {title:"EDIT", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><i class='fas fa-print'></i></a></Button>"}



],
columnDefs: [
  {
    targets: [10,11],
    render: $.fn.dataTable.render.number(',', '.', 2, '')
  }
],
  footerCallback: function (row, data, start, end, display) {
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
            // $(api.column(1).footer()).html('TOTAL QTY:' );
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

}; //end of datatable





</script>





<script type="text/javascript"> 


function printElement(elem, append, delimiter) {
    var domClone = elem.cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }

    if (append !== true) {
        $printSection.innerHTML = "";
    }

    else if (append === true) {
        if (typeof(delimiter) === "string") {
            $printSection.innerHTML += delimiter;
        }
        else if (typeof(delimiter) === "object") {
            $printSection.appendChlid(delimiter);
        }
    }

    $printSection.appendChild(domClone);
}



$('#printMe').click(function(){
  // $("#print_area").printThis();
  printElement(document.getElementById("print_area"));
  window.print();


});

$("#clsmods").on('click', function() {
    $('#gen_dr_print_Modal').modal('hide');
});

</script>