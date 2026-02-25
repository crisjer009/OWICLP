<?php

session_start();
date_default_timezone_set("Asia/Manila");

include('insert_obj.php');
if(isset($_POST["operation"]))
{

 if($_POST["operation"] == "Add")
 {


$restat = $connection->prepare("
INSERT INTO tnap_tbl_consign_reports (OWI_SKU, branch_id, consign_qty, consign_tag,contract_num,date_created,rpro_po,idv_amt,amt,ref_co,cof_crt_usr) 
VALUES (:OWI_SKU, :branch_id, :consign_qty, :consign_tag, :contract_num, :date_created, :rpro_po, :idv_amt, :amt, :ref_co, :cof_crt_usr)
");
$remarkres= $restat->execute(
array(

    ':OWI_SKU' => $_POST["OWI_SKU"],
    ':branch_id' => $_POST["branch_id"],
    ':consign_qty' => $_POST["consign_qty"],
    ':consign_tag' => $_POST["consign_tag"],
    ':contract_num' => $_POST["contract_val"],
    ':date_created' => date('Y-m-d'),
    ':rpro_po' => $_POST["rpro_po"],
    ':idv_amt' => $_POST["alu_price"],
    ':amt' => $_POST["ttl_price"],
    ':ref_co' => $_POST["ref_co"],
    ':cof_crt_usr' => $_SESSION['user_id']


    

)); 
 //  add branch here if new existing comes for adding in inv_qty
$qry = $connection->prepare(" SELECT * FROM tnap_tbl_masterfile WHERE OWI_SKU = '".$_POST['OWI_SKU'] ."'");
$qry->execute();
$res = $qry->fetch(PDO::FETCH_ASSOC); 
$cwhqtyres = $res['cwh_qty'];
$alu_qty =  $_POST["consign_qty"];
$totalqty = $cwhqtyres + $alu_qty;
$statement = $connection->prepare(
  "UPDATE tnap_tbl_masterfile SET cwh_qty = $totalqty WHERE OWI_SKU = '".$_POST['OWI_SKU'] ."'");
$result = $statement->execute(
  array(
    ':cwh_qty' => $cwhqtyres + $_POST["consign_qty"]
  ));
// end of add cwh inventory

$branchIDval = $_POST['branch_id'];
switch ($branchIDval) {
  case "1":
    $brRes = 'tbl_pqimasterfile';
    break;
  case "2":
    $brRes = 'tbl_tgmasterfile';
    break;
  case "3":
    $brRes = 'tbl_pcommasterfile';
      break;	
  case "4":
    $brRes = 'tbl_pvalmasterfile';
        break;		
  case '5':
    $brRes = 'tbl_plibmasterfile';
    break;	
  case '6':
    $brRes = 'tbl_pmakmasterfile';
    break;			
  case '7':
  $brRes = 'tbl_pmonmasterfile';
  break;
  case '8':
  $brRes = 'tbl_psucmasterfile';
  break;
  case '9':
  $brRes = 'tbl_ptaymasterfile';
  break;
  case '10':
  $brRes = 'tbl_plasmasterfile';
          break;
  case '11':
  $brRes = 'tbl_pdaumasterfile';
           break;
           case '12':
            $brRes = 'tnap_tbl_tnapmasterfile';
                     break;
  default:
    # code...
    break;
}
 
  $qry = $connection->prepare(" SELECT * FROM $brRes WHERE OWI_SKU = '".$_POST['OWI_SKU'] ."'");
  $qry->execute();
  $res = $qry->fetch(PDO::FETCH_ASSOC); 
  $cwhqtyres = $res['inv_qty'];
  $alu_qty =  $_POST["consign_qty"];
  $totalqty = $cwhqtyres + $alu_qty;
  $statement = $connection->prepare(
    "UPDATE $brRes SET inv_qty = $totalqty WHERE OWI_SKU = '".$_POST['OWI_SKU'] ."'");
  $result = $statement->execute(
    array(
      ':cwh_qty' => $cwhqtyres + $_POST["consign_qty"]
    )); // end of add inv_qty in store 


  

}; // end of add



if($_POST["operation"] == "Add_Sales")
{


$restat = $connection->prepare("
INSERT INTO tnap_tbl_sales_reports (OWI_SKU, branch_id, consign_qty, consign_tag,contract_num,date_created,rpro_po,idv_amt,amt,ref_co,cof_crt_usr) 
VALUES (:OWI_SKU, :branch_id, :consign_qty, :consign_tag, :contract_num, :date_created, :rpro_po, :idv_amt, :amt, :ref_co, :cof_crt_usr)
");
$remarkres= $restat->execute(
array(

   ':OWI_SKU' => $_POST["OWI_SKU"],
   ':branch_id' => $_POST["branch_id"],
   ':consign_qty' => $_POST["consign_qty"],
   ':consign_tag' => $_POST["consign_tag"],
   ':contract_num' => $_POST["contract_val"],
   ':date_created' => date('Y-m-d H:i:s'),
   ':rpro_po' => $_POST["rpro_po"],
   ':idv_amt' => $_POST["alu_price"],
   ':amt' => $_POST["ttl_price"],
   ':ref_co' => $_POST["ref_co"],
   ':cof_crt_usr' => $_SESSION['user_id']


   

)); 
//  add branch here if new existing comes for adding in inv_qty
$qry = $connection->prepare(" SELECT * FROM tnap_tbl_masterfile WHERE OWI_SKU = '".$_POST['OWI_SKU'] ."'");
$qry->execute();
$res = $qry->fetch(PDO::FETCH_ASSOC); 
$cwhqtyres = $res['sls_qty'];
$alu_qty =  $_POST["consign_qty"];
$totalqty = $cwhqtyres + $alu_qty;
$statement = $connection->prepare(
 "UPDATE tbl_masterfile SET sls_qty = $totalqty WHERE OWI_SKU = '".$_POST['OWI_SKU'] ."'");
$result = $statement->execute(
 array(
   ':sls_qty' => $cwhqtyres + $_POST["consign_qty"]
 ));
// end of add cwh inventory

$branchIDval = $_POST['branch_id'];
switch ($branchIDval) {
 case "1":
   $brRes = 'tbl_pqimasterfile';
   break;
 case "2":
   $brRes = 'tbl_tgmasterfile';
   break;
 case "3":
   $brRes = 'tbl_pcommasterfile';
     break;	
 case "4":
   $brRes = 'tbl_pvalmasterfile';
       break;		
 case '5':
   $brRes = 'tbl_plibmasterfile';
   break;	
 case '6':
   $brRes = 'tbl_pmakmasterfile';
   break;			
 case '7':
 $brRes = 'tbl_pmonmasterfile';
 break;
 case '8':
 $brRes = 'tbl_psucmasterfile';
 break;
 case '9':
 $brRes = 'tbl_ptaymasterfile';
 break;
 case '10':
 $brRes = 'tbl_plasmasterfile';
         break;
 case '11':
 $brRes = 'tbl_pdaumasterfile';
          break;
          case '12':
           $brRes = 'tnap_tbl_tnapmasterfile';
                    break;
 default:
   # code...
   break;
}

 $qry = $connection->prepare(" SELECT * FROM $brRes WHERE OWI_SKU = '".$_POST['OWI_SKU'] ."'");
 $qry->execute();
 $res = $qry->fetch(PDO::FETCH_ASSOC); 
 $cwhqtyres = $res['sls_qty'];
 $alu_qty =  $_POST["consign_qty"];
 $totalqty = $cwhqtyres + $alu_qty;
 $statement = $connection->prepare(
   "UPDATE $brRes SET sls_qty = $totalqty WHERE OWI_SKU = '".$_POST['OWI_SKU'] ."'");
 $result = $statement->execute(
   array(
     ':cwh_qty' => $cwhqtyres + $_POST["consign_qty"]
   )); // end of add inv_qty in store 


 

}; // end of add







if($_POST["operation"] == "cofres")
{
  $qry = $connection->prepare(" SELECT cof_counter FROM tnap_tbl_consign_counter");
  $qry->execute();
  $res = $qry->fetch(PDO::FETCH_ASSOC); 
  $ticknum = $res['cof_counter']+1;
  $statement = $connection->prepare(
    "UPDATE tnap_tbl_consign_counter SET cof_counter = :cof_counter");
  $result = $statement->execute(
    array(
      ':cof_counter' => $ticknum,));
  



}; // end of cof fix

if($_POST["operation"] == "Save")
{
  $qry = $connection->prepare(" SELECT cof_counter FROM tnap_tbl_consign_counter");
  $qry->execute();
  $res = $qry->fetch(PDO::FETCH_ASSOC); 
  // $ticknum = $res['cof_counter']+1;
  // $statement = $connection->prepare(
  //   "UPDATE tbl_consign_counter SET cof_counter = :cof_counter");
  // $result = $statement->execute(
  //   array(
  //     ':cof_counter' => $ticknum,));
  
  echo 'Data Inserted.';
  

  $restat = $connection->prepare("
  INSERT INTO tnap_tbl_crdr_stat (consign_tag, stat) 
  VALUES (:consign_tag, :stat)
  ");
  $remarkres= $restat->execute(
  array(
  

      ':consign_tag' => $_POST["consign_tag"],
      ':stat' => 'N',
    
  
  ));  



}; // end of save
 


//  if($_POST["operation"] == "Edit")
//  { 
// $data=   array(
//     ':OWI_SKU' => $_POST["form_sku"],
//     ':OWI_DESCRIPTION' => $_POST["owi_desc"],
//     ':PG_UPC' => $_POST["pg_upc"],
//     ':PRICE' => $_POST["sku_price"],
//     ':user_id' => $_POST["user_id"],
//     ':ITEM_CODE' => $_POST["item_code"]
//     // ':date_updated' => date('Y-m-d H:i:s',strtotime($_POST["date_updated"]))
//    ) ;

//   $statement = $connection->prepare(
//    "UPDATE tnap_tbl_masterfile
//    SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//    WHERE OWI_SKU = :OWI_SKU"
//   );

//   $result = $statement->execute($data);

//   if(!empty($result))
//   {
//  $pricehist = $connection->prepare("
//     INSERT INTO tnap_tbl_priceupdatehist (OWI_SKU, user_id, date_updated, prev_price, new_price, prev_upc, new_upc, upt_reason) 
//    VALUES (:OWI_SKU, :user_id, :date_updated, :prev_price, :new_price, :prev_upc, :new_upc, :upt_reason)
//   ");
//   $pricehistres= $pricehist->execute(
//     array(
//       ':OWI_SKU' => $_POST["form_sku"],
//       ':user_id' => $_POST["user_id"],
//       ':date_updated' => date('Y-m-d H:i:s'),
//       ':prev_price' => $_POST["prev_price"],
//       ':new_price' => $_POST["sku_price"],
//       ':prev_upc' => $_POST["pg_upc"],
//       ':new_upc' => $_POST["pg_upc"],
//       ':upt_reason' => $_POST["upt_reason"]

      
//     ));
    

//     $branchdata=   array(
//       ':OWI_SKU' => $_POST["form_sku"],
//       ':OWI_DESCRIPTION' => $_POST["owi_desc"],
//       ':PG_UPC' => $_POST["pg_upc"],
//       ':PRICE' => $_POST["sku_price"],
//       ':user_id' => $_POST["user_id"],
//       ':ITEM_CODE' => $_POST["item_code"]
//       // ':date_updated' => date('Y-m-d H:i:s',strtotime($_POST["date_updated"]))
//      ) ;
  
//     $pqimasterfileres = $connection->prepare(
//      "UPDATE tbl_pqimasterfile
//      SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//      WHERE OWI_SKU = :OWI_SKU"
//     );
  
//     $pqiresult = $pqimasterfileres->execute($branchdata);


//     // $tgdata=   array(
//     //   ':OWI_SKU' => $_POST["form_sku"],
//     //   ':OWI_DESCRIPTION' => $_POST["owi_desc"],
//     //   ':PG_UPC' => $_POST["pg_upc"],
//     //   ':PRICE' => $_POST["sku_price"],
//     //   ':user_id' => $_POST["user_id"],
//     //   ':ITEM_CODE' => $_POST["item_code"]
//     //   // ':date_updated' => date('Y-m-d H:i:s',strtotime($_POST["date_updated"]))
//     //  ) ;
  
//     $tgmasterfileres = $connection->prepare(
//      "UPDATE tbl_tgmasterfile
//      SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//      WHERE OWI_SKU = :OWI_SKU"
//     );
  
//     $tgresult = $tgmasterfileres->execute($branchdata);

//     $pcommasterfileres = $connection->prepare(
//      "UPDATE tbl_pcommasterfile
//      SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//      WHERE OWI_SKU = :OWI_SKU"
//     );
  
//     $pcomresult = $pcommasterfileres->execute($branchdata);

//     $pvalmasterfileres = $connection->prepare(
//      "UPDATE tbl_pvalmasterfile
//      SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//      WHERE OWI_SKU = :OWI_SKU"
//     );
  
//     $pvalresult = $pvalmasterfileres->execute($branchdata);


//     $plibmasterfileres = $connection->prepare(
//       "UPDATE tbl_plibmasterfile
//       SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//       WHERE OWI_SKU = :OWI_SKU"
//      );
   
//      $plibresult = $plibmasterfileres->execute($branchdata);

//      // PMAK
//     $pmakmasterfileres = $connection->prepare(
//       "UPDATE tbl_pmakmasterfile
//       SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//       WHERE OWI_SKU = :OWI_SKU"
//      );
   
//      $pmakresult = $pmakmasterfileres->execute($branchdata);
// // END PMAK

// // PMON
//      $pmonmasterfileres = $connection->prepare(
//       "UPDATE tbl_pmonmasterfile
//       SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//       WHERE OWI_SKU = :OWI_SKU"
//      );
   
//      $pmonresult = $pmonmasterfileres->execute($branchdata);
//      // END OF PMON
//      // PSUC
//      $psucmasterfileres = $connection->prepare(
//       "UPDATE tbl_psucmasterfile
//       SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//       WHERE OWI_SKU = :OWI_SKU"
//      );
   
//      $psucresult = $psucmasterfileres->execute($branchdata);
// // END OF PSUC

// // PTAY
//      $ptaymasterfileres = $connection->prepare(
//       "UPDATE tbl_ptaymasterfile
//       SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//       WHERE OWI_SKU = :OWI_SKU"
//      );
   
//      $ptayresult = $ptaymasterfileres->execute($branchdata);
// // END OF PTAY

// // PLAS
//      $plasmasterfileres = $connection->prepare(
//       "UPDATE tbl_plasmasterfile
//       SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//       WHERE OWI_SKU = :OWI_SKU"
//      );
   
//      $plasresult = $plasmasterfileres->execute($branchdata);

//      // END OF PLAS

// // PDAU
// $pdaumasterfileres = $connection->prepare(
//   "UPDATE tbl_pdaumasterfile
//   SET OWI_SKU = :OWI_SKU, OWI_DESCRIPTION = :OWI_DESCRIPTION, PG_UPC = :PG_UPC, PRICE = :PRICE, ITEM_CODE = :ITEM_CODE
//   WHERE OWI_SKU = :OWI_SKU"
//  );

//  $pdauresult = $pdaumasterfileres->execute($branchdata);

//  // END OF PDAU


//   }

// } // end  EDIT

// if($_POST["operation"] == "add_sales"){




// $a = $_POST["sls_price"];
// // $a = "1,435.50";
// $b = str_replace( ',', '', $a );


//   $restat = $connection->prepare("
//   INSERT INTO tbl_sales_rep (OWI_SKU, sls_price, sls_qty, sls_date,user_id) 
//   VALUES (:OWI_SKU, :sls_price, :sls_qty, :sls_date, :user_id)
//   ");
//   $remarkres= $restat->execute(
//   array(
  
//       ':OWI_SKU' => $_POST["form_sku"],
//       ':sls_price' => $_POST["sls_price"],
//       ':sls_qty' => $_POST["pd_add"],
//       ':sls_date' => date('Y-m-d H:i:s'),
//       ':user_id' => $_POST["user_id"]
      
  
//   )); 



//   $adjqty = $_POST['pd_add'];

//   $OpvalRes = $adjqty;
//   $qry = $connection->prepare(" SELECT * FROM tbl_pqimasterfile WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
//   $qry->execute();
//   $res = $qry->fetch(PDO::FETCH_ASSOC); 
//   $cwhqtyres = $res['sls_qty'];
//   $alu_qty =  $_POST["pd_add"];
//   $totalqty = $cwhqtyres + $OpvalRes;
//   $statement = $connection->prepare(
//     "UPDATE tbl_pqimasterfile SET sls_qty = $totalqty WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
//   $result = $statement->execute(
//     array(
//       ':cwh_qty' => $cwhqtyres + $_POST["pd_add"]
//     ));



 
// }

// cof edit
if($_POST["operation"] == "COF_Edit")
 { 
 
  $orgqty = $_POST['consign_qty'];
  $adjqty = $_POST['cs_edit_val'];

  $sel_val = $_POST['slct_ops'];
  switch ($sel_val) {
    case "1":
      $OpvalRes = $adjqty;
      $qry = $connection->prepare(" SELECT * FROM tnap_tbl_masterfile WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $qry->execute();
      $res = $qry->fetch(PDO::FETCH_ASSOC); 
      $cwhqtyres = $res['cwh_qty'];
      $alu_qty =  $_POST["consign_qty"];
      $totalqty = $cwhqtyres + $OpvalRes;
      $statement = $connection->prepare(
        "UPDATE tnap_tbl_masterfile SET cwh_qty = $totalqty WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $result = $statement->execute(
        array(
          ':cwh_qty' => $cwhqtyres + $_POST["cs_edit_val"]
        ));

      break;
    case "2":
      $OpvalRes = $adjqty;
      $qry = $connection->prepare(" SELECT * FROM tnap_tbl_masterfile WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $qry->execute();
      $res = $qry->fetch(PDO::FETCH_ASSOC); 
      $cwhqtyres = $res['cwh_qty'];
      $alu_qty =  $_POST["consign_qty"];
      $totalqty = $cwhqtyres - $OpvalRes;
      $statement = $connection->prepare(
        "UPDATE tnap_tbl_masterfile SET cwh_qty = $totalqty WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $result = $statement->execute(
        array(
          ':cwh_qty' => $cwhqtyres - $_POST["cs_edit_val"]
        ));
      break;					
    default:
      # code...
      break;
  }


  
  $data=   array(
    ':consign_tag' => $_POST["consign_tag"],
    ':OWI_SKU' => $_POST["form_sku"],
    ':consign_qty' => $_POST["cs_new_val"]
    // ':date_updated' => date('Y-m-d H:i:s',strtotime($_POST["date_updated"]))
   ) ;

   $statement = $connection->prepare(
    "UPDATE tnap_tbl_consign_reports
    SET OWI_SKU = :OWI_SKU, consign_qty = :consign_qty
    WHERE consign_tag = :consign_tag AND OWI_SKU = :OWI_SKU"
   );

 $result = $statement->execute($data);
  
switch ($sel_val) {
  case '1':
   $adjres = $_POST["cs_edit_val"];
    break;
  case 'value':
    $adjres = -1 * $_POST["cs_edit_val"];
    break;
  default:
    # code...
    break;
}

 $restat = $connection->prepare("
INSERT INTO tnap_tbl_dr_adjustment (user_id, consign_tag, OWI_SKU, date_adjust,old_qty, adj_qty, opVal) 
VALUES (:user_id, :consign_tag, :OWI_SKU, :date_adjust, :old_qty, :adj_qty, :opVal)
");
$remarkres= $restat->execute(
array(

    ':user_id' => $_POST["user_id"],
    ':consign_tag' => $_POST["consign_tag"],
    ':OWI_SKU' => $_POST["form_sku"],
    ':date_adjust' => date('Y-m-d H:i:s'),
    ':old_qty' => $_POST["consign_qty"],
    ':adj_qty' => $adjres,
    ':opVal' => $_POST["slct_ops"]
    

)); 


$branchIDval = $_POST['genMod_branch_id'];
switch ($branchIDval) {
  case "1":
    $brResx = 'tbl_pqimasterfile';
    break;
  case "2":
    $brResx = 'tbl_tgmasterfile';
    break;
  case "3":
    $brResx = 'tbl_pcommasterfile';
      break;	
  case "4":
    $brResx = 'tbl_pvalmasterfile';
        break;	
  case '5':
    $brResx = 'tbl_plibmasterfile';
    break;		
  case '6':
    $brResx = 'tbl_pmakmasterfile';
    break;	
  case '7':
    $brResx = 'tbl_pmonmasterfile';
  break;	
  case '8':
    $brResx = 'tbl_psucmasterfile';
  break;		
  case '9':
    $brResx = 'tbl_ptaymasterfile';
  break;		
  case '10':
    $brResx = 'tbl_plasmasterfile';
  break;			
  case '11':
    $brResx = 'tbl_pdaumasterfile';
  break;
  case '12':
    $brResx = 'tnap_tbl_tnapmasterfile';
  break;			
  
  default:
    # code...
    break;
}

$sel_valx = $_POST['slct_ops'];
switch ($sel_valx) {
  case '1':
    $qryx = $connection->prepare(" SELECT * FROM $brResx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $qryx->execute();
    $resx = $qryx->fetch(PDO::FETCH_ASSOC); 
    $cwhqtyresx = $resx['inv_qty'];
    $alu_qtyx =  $_POST["cs_edit_val"];
    $totalqtyx = $cwhqtyresx + $alu_qtyx;
    $statement = $connection->prepare(
      "UPDATE $brResx SET inv_qty = $totalqtyx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $result = $statement->execute(
      array(
        ':inv_qty' => $cwhqtyresx + $_POST["consign_qty"]
      )); // end of add inv_qty in store 
    break;
  case '2':
    $qryx = $connection->prepare(" SELECT * FROM $brResx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $qryx->execute();
    $resx = $qryx->fetch(PDO::FETCH_ASSOC); 
    $cwhqtyresx = $resx['inv_qty'];
    $alu_qtyx =  $_POST["cs_edit_val"];
    $totalqtyx = $cwhqtyresx - $alu_qtyx;
    $statement = $connection->prepare(
      "UPDATE $brResx SET inv_qty = $totalqtyx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $result = $statement->execute(
      array(
        ':inv_qty' => $cwhqtyresx - $_POST["consign_qty"]
      )); // end of add inv_qty in store 
     break;
  
  default:
    # code...
    break;
}


 }



 // start of SALES EDIT

 if($_POST["operation"] == "Sales_Edit")
 { 
 
  $orgqty = $_POST['consign_qty'];
  $adjqty = $_POST['cs_edit_val'];

  $sel_val = $_POST['slct_ops'];
  switch ($sel_val) {
    case "1":
      $OpvalRes = $adjqty;
      $qry = $connection->prepare(" SELECT * FROM tnap_tbl_masterfile WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $qry->execute();
      $res = $qry->fetch(PDO::FETCH_ASSOC); 
      $cwhqtyres = $res['sls_qty'];
      $alu_qty =  $_POST["consign_qty"];
      $totalqty = $cwhqtyres + $OpvalRes;
      $statement = $connection->prepare(
        "UPDATE tnap_tbl_masterfile SET sls_qty = $totalqty WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $result = $statement->execute(
        array(
          ':sls_qty' => $cwhqtyres + $_POST["cs_edit_val"]
        ));

      break;
    case "2":
      $OpvalRes = $adjqty;
      $qry = $connection->prepare(" SELECT * FROM tnap_tbl_masterfile WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $qry->execute();
      $res = $qry->fetch(PDO::FETCH_ASSOC); 
      $cwhqtyres = $res['sls_qty'];
      $alu_qty =  $_POST["consign_qty"];
      $totalqty = $cwhqtyres - $OpvalRes;
      $statement = $connection->prepare(
        "UPDATE tnap_tbl_masterfile SET sls_qty = $totalqty WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $result = $statement->execute(
        array(
          ':sls_qty' => $cwhqtyres - $_POST["cs_edit_val"]
        ));
      break;					
    default:
      # code...
      break;
  }


  
  $data=   array(
    ':consign_tag' => $_POST["consign_tag"],
    ':OWI_SKU' => $_POST["form_sku"],
    ':consign_qty' => $_POST["cs_new_val"],
    ':sls_id' => $_POST["sls_id"]
    // ':date_updated' => date('Y-m-d H:i:s',strtotime($_POST["date_updated"]))
   ) ;

   $statement = $connection->prepare(
    "UPDATE tnap_tbl_sales_reports
    SET OWI_SKU = :OWI_SKU, consign_qty = :consign_qty
    WHERE consign_tag = :consign_tag AND OWI_SKU = :OWI_SKU AND cof_id = :sls_id"
   );

 $result = $statement->execute($data);
  
switch ($sel_val) {
  case '1':
   $adjres = $_POST["cs_edit_val"];
    break;
  case 'value':
    $adjres = -1 * $_POST["cs_edit_val"];
    break;
  default:
    # code...
    break;
}

//  $restat = $connection->prepare("
// INSERT INTO tbl_dr_adjustment (user_id, consign_tag, OWI_SKU, date_adjust,old_qty, adj_qty, opVal) 
// VALUES (:user_id, :consign_tag, :OWI_SKU, :date_adjust, :old_qty, :adj_qty, :opVal)
// ");
// $remarkres= $restat->execute(
// array(

//     ':user_id' => $_POST["user_id"],
//     ':consign_tag' => $_POST["consign_tag"],
//     ':OWI_SKU' => $_POST["form_sku"],
//     ':date_adjust' => date('Y-m-d H:i:s'),
//     ':old_qty' => $_POST["consign_qty"],
//     ':adj_qty' => $adjres,
//     ':opVal' => $_POST["slct_ops"]
    

// )); 


$branchIDval = $_POST['genMod_branch_id'];
switch ($branchIDval) {
  case "1":
    $brResx = 'tbl_pqimasterfile';
    break;
  case "2":
    $brResx = 'tbl_tgmasterfile';
    break;
  case "3":
    $brResx = 'tbl_pcommasterfile';
      break;	
  case "4":
    $brResx = 'tbl_pvalmasterfile';
        break;	
  case '5':
    $brResx = 'tbl_plibmasterfile';
    break;		
  case '6':
    $brResx = 'tbl_pmakmasterfile';
    break;	
  case '7':
    $brResx = 'tbl_pmonmasterfile';
  break;	
  case '8':
    $brResx = 'tbl_psucmasterfile';
  break;		
  case '9':
    $brResx = 'tbl_ptaymasterfile';
  break;		
  case '10':
    $brResx = 'tbl_plasmasterfile';
  break;			
  case '11':
    $brResx = 'tbl_pdaumasterfile';
  break;
  case '12':
    $brResx = 'tnap_tbl_tnapmasterfile';
  break;			
  
  default:
    # code...
    break;
}

$sel_valx = $_POST['slct_ops'];
switch ($sel_valx) {
  case '1':
    $qryx = $connection->prepare(" SELECT * FROM $brResx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $qryx->execute();
    $resx = $qryx->fetch(PDO::FETCH_ASSOC); 
    $cwhqtyresx = $resx['sls_qty'];
    $alu_qtyx =  $_POST["cs_edit_val"];
    $totalqtyx = $cwhqtyresx + $alu_qtyx;
    $statement = $connection->prepare(
      "UPDATE $brResx SET sls_qty = $totalqtyx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $result = $statement->execute(
      array(
        ':sls_qty' => $cwhqtyresx + $_POST["consign_qty"]
      )); // end of add inv_qty in store 
    break;
  case '2':
    $qryx = $connection->prepare(" SELECT * FROM $brResx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $qryx->execute();
    $resx = $qryx->fetch(PDO::FETCH_ASSOC); 
    $cwhqtyresx = $resx['sls_qty'];
    $alu_qtyx =  $_POST["cs_edit_val"];
    $totalqtyx = $cwhqtyresx - $alu_qtyx;
    $statement = $connection->prepare(
      "UPDATE $brResx SET sls_qty = $totalqtyx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $result = $statement->execute(
      array(
        ':sls_qty' => $cwhqtyresx - $_POST["consign_qty"]
      )); // end of add inv_qty in store 
     break;
  
  default:
    # code...
    break;
}


 }



// start

if($_POST["operation"] == "Gen_Edit")
 { 
 
  $orgqty = $_POST['consign_qty'];
  $adjqty = $_POST['cs_edit_val'];

  $sel_val = $_POST['slct_ops'];
  switch ($sel_val) {
    case "1":
      $OpvalRes = $adjqty;
      $qry = $connection->prepare(" SELECT * FROM tnap_tbl_masterfile WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $qry->execute();
      $res = $qry->fetch(PDO::FETCH_ASSOC); 
      $cwhqtyres = $res['cwh_qty'];
      $alu_qty =  $_POST["consign_qty"];
      $totalqty = $cwhqtyres + $OpvalRes;
      $statement = $connection->prepare(
        "UPDATE tnap_tbl_masterfile SET cwh_qty = $totalqty WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $result = $statement->execute(
        array(
          ':cwh_qty' => $cwhqtyres + $_POST["cs_edit_val"]
        ));

      break;
    case "2":
      $OpvalRes = $adjqty;
      $qry = $connection->prepare(" SELECT * FROM tnap_tbl_masterfile WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $qry->execute();
      $res = $qry->fetch(PDO::FETCH_ASSOC); 
      $cwhqtyres = $res['cwh_qty'];
      $alu_qty =  $_POST["consign_qty"];
      $totalqty = $cwhqtyres - $OpvalRes;
      $statement = $connection->prepare(
        "UPDATE tnap_tbl_masterfile SET cwh_qty = $totalqty WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
      $result = $statement->execute(
        array(
          ':cwh_qty' => $cwhqtyres - $_POST["cs_edit_val"]
        ));
      break;					
    default:
      # code...
      break;
  }


  
  $data=   array(
    ':consign_tag' => $_POST["consign_tag"],
    ':OWI_SKU' => $_POST["form_sku"],
    ':consign_qty' => $_POST["cs_new_val"]
    // ':date_updated' => date('Y-m-d H:i:s',strtotime($_POST["date_updated"]))
   ) ;

   $statement = $connection->prepare(
    "UPDATE tnap_tbl_consign_reports
    SET OWI_SKU = :OWI_SKU, consign_qty = :consign_qty
    WHERE consign_tag = :consign_tag AND OWI_SKU = :OWI_SKU"
   );

 $result = $statement->execute($data);
  
switch ($sel_val) {
  case '1':
   $adjres = $_POST["cs_edit_val"];
    break;
  case 'value':
    $adjres = -1 * $_POST["cs_edit_val"];
    break;
  default:
    # code...
    break;
}

 $restat = $connection->prepare("
INSERT INTO tnap_tbl_dr_adjustment (user_id, consign_tag, OWI_SKU, date_adjust,old_qty, adj_qty, opVal) 
VALUES (:user_id, :consign_tag, :OWI_SKU, :date_adjust, :old_qty, :adj_qty, :opVal)
");
$remarkres= $restat->execute(
array(

    ':user_id' => $_POST["user_id"],
    ':consign_tag' => $_POST["consign_tag"],
    ':OWI_SKU' => $_POST["form_sku"],
    ':date_adjust' => date('Y-m-d H:i:s'),
    ':old_qty' => $_POST["consign_qty"],
    ':adj_qty' => $adjres,
    ':opVal' => $_POST["slct_ops"]
    

)); 


$branchIDval = $_POST['genMod_branch_id'];
switch ($branchIDval) {
  case "1":
    $brResx = 'tbl_pqimasterfile';
    break;
  case "2":
    $brResx = 'tbl_tgmasterfile';
    break;
  case "3":
    $brResx = 'tbl_pcommasterfile';
      break;	
  case "4":
    $brResx = 'tbl_pvalmasterfile';
        break;	
  case '5':
    $brResx = 'tbl_plibmasterfile';
    break;		
  case '6':
    $brResx = 'tbl_pmakmasterfile';
    break;	
  case '7':
    $brResx = 'tbl_pmonmasterfile';
  break;	
  case '8':
    $brResx = 'tbl_psucmasterfile';
  break;		
  case '9':
    $brResx = 'tbl_ptaymasterfile';
  break;		
  case '10':
    $brResx = 'tbl_plasmasterfile';
  break;			
  case '11':
    $brResx = 'tbl_pdaumasterfile';
  break;
  case '12':
    $brResx = 'tnap_tbl_tnapmasterfile';
  break;		
  
  default:
    # code...
    break;
}

$sel_valx = $_POST['slct_ops'];
switch ($sel_valx) {
  case '1':
    $qryx = $connection->prepare(" SELECT * FROM $brResx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $qryx->execute();
    $resx = $qryx->fetch(PDO::FETCH_ASSOC); 
    $cwhqtyresx = $resx['inv_qty'];
    $alu_qtyx =  $_POST["cs_edit_val"];
    $totalqtyx = $cwhqtyresx + $alu_qtyx;
    $statement = $connection->prepare(
      "UPDATE $brResx SET inv_qty = $totalqtyx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $result = $statement->execute(
      array(
        ':inv_qty' => $cwhqtyresx + $_POST["consign_qty"]
      )); // end of add inv_qty in store 
    break;
  case '2':
    $qryx = $connection->prepare(" SELECT * FROM $brResx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $qryx->execute();
    $resx = $qryx->fetch(PDO::FETCH_ASSOC); 
    $cwhqtyresx = $resx['inv_qty'];
    $alu_qtyx =  $_POST["cs_edit_val"];
    $totalqtyx = $cwhqtyresx - $alu_qtyx;
    $statement = $connection->prepare(
      "UPDATE $brResx SET inv_qty = $totalqtyx WHERE OWI_SKU = '".$_POST['form_sku'] ."'");
    $result = $statement->execute(
      array(
        ':inv_qty' => $cwhqtyresx - $_POST["consign_qty"]
      )); // end of add inv_qty in store 
     break;
  
  default:
    # code...
    break;
}


 }

 if($_POST["operation"] == "Transact")
 {


$restat = $connection->prepare("
INSERT INTO tnap_tbl_sales_reports (inv_no, inv_dt, pg_alu,pg_alu_qty,date_created,contract_num,branch_id) 
VALUES (:inv_no, :inv_dt, :pg_alu, :pg_alu_qty, :date_created, :contract_num, :branch_id)
");
$remarkres= $restat->execute(
array(

    ':inv_no' => $_POST["inv_no"],
    ':inv_dt' => $_POST["inv_dt"],
    ':pg_alu' => $_POST["pg_alu"],
    ':pg_alu_qty' => $_POST["pg_alu_qty"],
    ':contract_num' => $_POST["contract_val"],
    ':branch_id' => $_POST["branch_id"],

    ':date_created' => date('Y-m-d')


)); 



$branchIDval = $_POST['branch_id'];
switch ($branchIDval) {
  case "1":
    $brRes = 'tbl_pqimasterfile';
    break;
  case "2":
    $brRes = 'tbl_tgmasterfile';
    break;
  case "3":
    $brRes = 'tbl_pcommasterfile';
      break;	
  case "4":
    $brRes = 'tbl_pvalmasterfile';
        break;						
  case '5':
    $brRes = 'tbl_plibmasterfile';
    break;
  case '6':
    $brRes = 'tbl_pmakmasterfile';
    break;
  case '7':
  $brRes = 'tbl_pmonmasterfile';
  break;
  case '8':
  $brRes = 'tbl_psucmasterfile';
  break;
  case '9':
  $brRes = 'tbl_ptaymasterfile';
  break;
  case '10':
  $brRes = 'tbl_plasmasterfile';
  break;
  case '11':
    $brRes = 'tbl_pdaumasterfile';
  break;
  case '12':
    $brRes = 'tnap_tbl_tnapmasterfile';
  break;
          
  
  default:
    # code...
    break;
}

  $qry = $connection->prepare(" SELECT * FROM $brRes WHERE PG_SKU = '".$_POST['pg_alu'] ."'");
  $qry->execute();
  $res = $qry->fetch(PDO::FETCH_ASSOC); 
  $cwhqtyres = $res['sls_qty'];
  $alu_qty =  $_POST["pg_alu_qty"];
  $totalqty = $cwhqtyres + $alu_qty;
  $statement = $connection->prepare(
    "UPDATE $brRes SET sls_qty = $totalqty WHERE PG_SKU = '".$_POST['pg_alu'] ."'");
  $result = $statement->execute(
    array(
      ':sls_qty' => $cwhqtyres + $_POST["pg_alu_qty"]
    )); // end of add inv_qty in store 


 }



} //end of "operation"


if(isset($_POST["operations"]))
{
  if($_POST["operations"] == "dr_snp")
  {

    $rdstat = $connection->prepare("
    INSERT INTO tnap_tbl_dr (dr_tag, consign_tag, branch_id,del_date,user_id)
    VALUES (:dr_tag, :consign_tag, :branch_id, :del_date, :user_id)
    ");
    $rdstatres= $rdstat->execute(
    array(
    

    ':dr_tag' => $_POST["ld_series"],
    ':consign_tag' => $_POST["cof"],
    ':branch_id' => $_POST["branch_id"],
    ':del_date' => $_POST["dr_delDate"],
    ':user_id' => $_SESSION["user_id"]
    
    )); // add to tbl_dr

    



   $qry = $connection->prepare("SELECT dr_counter FROM tnap_tbl_dr_counter WHERE ld_user_secID =  ".$_POST['ld_user_secID'] ."");
   $qry->execute();
   $res = $qry->fetch(PDO::FETCH_ASSOC); 
   $ticknumx = $res['dr_counter']+1;
   $statement = $connection->prepare(
     "UPDATE tnap_tbl_dr_counter SET dr_counter = :dr_counter WHERE ld_user_secID =  ".$_POST['ld_user_secID'] ."");

   $result = $statement->execute(
     array(
       ':dr_counter' => $ticknumx,));
   
   echo 'Data Inserted.'; //dr_counter


  // dr_tag change tag if cof is add to tbl_dr

  $qry1 = $connection->prepare("SELECT dr_tag FROM tnap_tbl_consign_reports WHERE consign_tag =  '".$_POST["cof"] ."'");
  $qry1->execute();
  $res1 = $qry1->fetch(PDO::FETCH_ASSOC); 
  // $Ytag = $res1['dr_counter']+1;
  $Ytag = 'Y';
  $statement = $connection->prepare(
    "UPDATE tnap_tbl_consign_reports SET dr_tag = :dr_tag WHERE consign_tag =  '".$_POST['cof'] ."'");

  $result1 = $statement->execute(
    array(
      ':dr_tag' => $Ytag,));
   //dr_counter

   $qryx = $connection->prepare("SELECT consign_tag FROM tnap_tbl_crdr_stat WHERE consign_tag =  '".$_POST["cof"] ."'");
   $qryx->execute();
   $res1 = $qryx->fetch(PDO::FETCH_ASSOC); 
   // $Ytag = $res1['dr_counter']+1;
   $Ytagx = 'Y';
   $statement = $connection->prepare(
     "UPDATE tnap_tbl_crdr_stat SET stat = :dcrr_tag WHERE consign_tag =  '".$_POST['cof'] ."'");
 
   $resultx = $statement->execute(
     array(
       ':dcrr_tag' => $Ytagx,));


  }
  // elseif ($_POST["operations"] != "dr_snp") {
  //   # code...
  // }; // and of snp 

}
?>