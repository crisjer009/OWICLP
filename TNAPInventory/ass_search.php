<?php

session_start();
date_default_timezone_set("Asia/Manila");

include('dbcon.php');


// $srch_val = 1;
// $srch_val = $_POST['slct'];

// $f = $srch_val;



// switch ($f) {
//    case '1':
//      $br_table = 'tbl_dept';
//      $br_order = 'dept_id';
//      $br_name = 'dept_name';

//       break;
//    case '2':
//       $br_table = 'tbl_store';
//       $br_order = 'str_no';
//      $br_name = 'str_name';
 
//       break;
   
//    default:
//       # code...
//       break;
// }


if(!isset($_POST['searchFat'])){

   // Fetch records
   $statement = $conn->prepare("SELECT * FROM tbl_masterfile ORDER BY OWI_SKU ");
   $statement->execute();
   $fatList = $statement->fetchAll();

}else{

   $search = $_POST['searchFat'];// Search text

   // Fetch records
   $statement = $conn->prepare("SELECT * FROM tbl_masterfile WHERE OWI_SKU like :OWI_SKU ORDER BY OWI_SKU ");
   $statement->bindValue(':OWI_SKU','%'.$search.'%', PDO::PARAM_STR);
   $statement->execute();
   $fatList = $statement->fetchAll();

}

$response = array();

// Read Data
foreach($fatList as $fat){
   $response[] = array(
      "id" => $fat['OWI_SKU'],
      "text" => $fat['OWI_SKU']." ". $fat['OWI_DESCRIPTION'],
   );
}

echo json_encode($response);
exit();








?>