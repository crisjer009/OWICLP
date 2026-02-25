
 <?php
 //  session_start();
  date_default_timezone_set("Asia/Manila");
   include 'templates/navbar.php';
   include 'templates/sidebar.php';
   include 'upt_modal.php';
  
  ?>

<style>
#chartdiv5 {
/*   margin-top: 2px;
  margin-left: 18px;*/
  width: 100%;
  height: 395px;

  
}

#chartdiv6 {
/*   margin-top: 2px;
  margin-left: 18px;*/
  width: 100%;
  height: 395px;

  
}
#submitdel
    {    
        visibility: hidden;
    }

    .mycontent-left {
  border-right: 3px solid #F4F6F9;
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
 
       <div class="row mt-4">

<div class="col-md-12">
<div class="card h-100">
<h5 class="card-header text-center">Delivery Status Per Branch</h5>
<div class="card-body ">
<div class="row">
<div class="col-md-6 mycontent-left">
<table class="table table-striped table-valign-middle" id="pu_data">

</table>
</div>

<div class="col-md-6 mycontent-right">

<div id="chartdiv6"></div>

</div>


</div>




</div>


</div>
</div>
<!-- 
<div class="col-md-6">
<div class="card h-100">
<h5 class="card-header">Deliveries Per Branch</h5>
<div class="card-body ">
</table> -->



</div>




 <div class="row ">
 
 <div class="col-md-12 ">
 <div class="card h-100">

 <?php
 if (isset($_POST['submitdel'])) {
    $cofdel = $_POST["cofdel"];
 }
 
 ?>

    <form action="gen_dr.php" method="POST">
 <input type="hidden" name="cofdel" id="cofdel">
 <input type="submit" name="submitdel" id="submitdel">
 </form>
 <h5 class="card-header text-center">COF Without Delivery Receipt</h5>
 <div class="card-body table-responsive ">
 
 <table class="table table-striped table-valign-middle" id="po_data">
 </table>
 
 
 
 </div>
 
 
 </div>
 </div>

 <!-- <div class="col-md-6">
 <div class="card h-100">
 <h5 class="card-header text-center">Delivery Receipt Status</h5>
 <div class="card-body table-responsive ">
 <div id="chartdiv5"></div>
 </table>
 
 
 
 </div>
 
 
 </div>
 </div> -->
 </div> 
 <!-- add div for row fix  -->
 

 
 
 </div>
 </div>
 
 
 </div> 
 <!-- end div row -->
 
       </div> <!--footer div-->
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
 $.post('functions/fetch_data.php',{mode:'ld_dash_1'},function(data){
 console.log(data);
 podata_dtbl(data);
 },'json');
 }
 
 dash_1data();
 
 var table1
 function podata_dtbl(t){
 const dataset=t.rptdata1;
 
 table =  $("#po_data").DataTable({
 
 "dom":
 'B<"pull-left"lf><"pull-right">tip',
 // stateSave: true,
 
 "info": false,
 "pagingType": "full_numbers",
 "bDestroy": true,
 "responsive": true, "lengthChange": false, "autoWidth": false,
 "searching": false,
 "pageLength":5,
 "order": [[1, 'asc']],
 "language": {
      "emptyTable": "No data available in table"
    },
 "data": dataset,
 
 "columns": [
 // {title:"NUM", data:"id","defaultContent": "",},
 {title:"COF_TAG:", data:"consign_tag","defaultContent": "",},
 {title:"Date Created:", data:"date_created","defaultContent": "",},
//  {title:"DR TAG:", data:"dr_tag","defaultContent": "",},
{title:"Create DR", data:null,"defaultContent": "<Button class='btn btn-danger' name='update' id='dtbsecond'><i class='fas fa-print'></i></a></Button>"}

 
 ],
 
 });
 
 $('#po_data tbody').on('click', 'button', function () {
var data = table.row( $(this).parents('tr') ).data();
console.log(data)
$('#cofdel').val(data['consign_tag']);
$('#submitdel').click();
    } );
 
 
 } // end of function 1


 function dash_2data(){
$.post('functions/fetch_data.php',{mode:'ld_dash_2'},function(data){
console.log(data);
pudata_dtbl(data);
},'json');
}

dash_2data();

var table1
function pudata_dtbl(t){
const dataset=t.rptdata2;

table1 =  $("#pu_data").DataTable({
  "language": {
      "emptyTable": "No data available in table"
    },  
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
{title:"Consign Tag:", data:"consign_tag","defaultContent": "",},
{title:"Delivery Receipt Tag:", data:"dr_tag","defaultContent": "",},
{title:"Delivery Date:", data:"del_date","defaultContent": "",},
{title:"Branch:", data:"branch_desc","defaultContent": "",},
{title:"Created By:", data:"user_name","defaultContent": "",}

]
});




} // end of function 1
 
 

  _overallpie();
  ldpie2();
  function _overallpie(){
 
 $.ajax({
    url:"functions/fetch_data.php",
    method:'POST',
     data:{mode:'overallgrph'},

    success:function(data5)
    {
 
      var obj5 = JSON.parse(data5);
      // console.log(obj5)
       _plotovpie(obj5)
      
    }
   });

}
 function _plotovpie(grphdata2){

am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv5", am4charts.PieChart);

// legend
chart.legend = new am4charts.Legend();
chart.legend.position = "bottom";
chart.legend.valign = "bottom";
chart.innerRadius = am4core.percent(40);
chart.legend.labels.template.text = "[bold {color}]{name}[/]";
// chart.legend.labels.template.text =
// series1.legendSettings.value = "{points}";
// Add data
chart.data = grphdata2

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "points";
pieSeries.dataFields.category = "stat_name";
pieSeries.slices.template.stroke = am4core.color("#FFF"); //outline
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template.tooltipPosition = "pointer";
pieSeries.labels.template.maxWidth = 130;
pieSeries.labels.template.wrap = true;
pieSeries.labels.template.fontSize = 12;
pieSeries.labels.template.text =  "{type}  {value.value} {category} | {value.percent.formatNumber('.##')}%";
pieSeries.slices.template.tooltipText = "{type} {value.value} {category}  | {value.percent.formatNumber('.##')}%";


// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

pieSeries.colors.list = [
  am4core.color("#77DD77"),
  am4core.color("#FF6961")

  // am4core.color("#F7BB07"),
  // am4core.color("#169DB2"),
];

am4core.options.autoDispose = true;

}); // end am4core.ready()


 } //end grphdata




 function ldpie2(){

$.ajax({
   url:"functions/fetch_data.php",
   method:'POST',
    data:{mode:'ldpieres2'},

   success:function(data)
   {

     var obj2 = JSON.parse(data);
    //  console.log(obj2)
    ldpieres2(obj2)
     
   }
  });

}
function ldpieres2(grphdata){

am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv6", am4charts.PieChart);

// legend
chart.legend = new am4charts.Legend();
chart.legend.position = "bottom";
chart.legend.valign = "bottom";
// chart.innerRadius = am4core.percent(40);
chart.legend.labels.template.text = "[bold {color}]{name}[/]";
// chart.legend.labels.template.text =
// series1.legendSettings.value = "{points}";
// Add data
chart.data = grphdata

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "points";
pieSeries.dataFields.category = "stat_name";
pieSeries.slices.template.stroke = am4core.color("#FFF"); //outline
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;
pieSeries.slices.template.tooltipPosition = "pointer";
pieSeries.labels.template.maxWidth = 130;
pieSeries.labels.template.wrap = true;
pieSeries.labels.template.fontSize = 12;
pieSeries.labels.template.text =  "{type}  {value.value} {category} WITH DR | {value.percent.formatNumber('.##')}%";
pieSeries.slices.template.tooltipText = "{type} {value.value} {category} WITHOUT DR | {value.percent.formatNumber('.##')}%";


// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

// pieSeries.colors.list = [
//  am4core.color("#27A243"),
//  am4core.color("#D53343")

//  // am4core.color("#F7BB07"),
//  // am4core.color("#169DB2"),
// ];

am4core.options.autoDispose = true;

}); // end am4core.ready()


} //end grphdata





 
 
 
 } ); // end jqready
 
 </script>	
 
 
 