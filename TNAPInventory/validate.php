<?php 
require_once('database.php');
// extracting POST Variables
extract($_POST);
    $error = [];
    $check = $concat->query("SELECT * FROM `tbl_masterfile` where OWI_SKU = '{$fat}'". (isset($id) && $id > 0 ? " and OWI_SKU != '{$id}' " : "" ));
    if($check->num_rows > 0){
        $error['field_name'] = 'OWI_SKU';
        $error['msg']=" # is already use.";
    }
    echo json_encode($error);
?>