<?php

include 'admin_function.php';
$fn = new dbconfig();
// $fn->admin_data_table_res();

 
$mode= $_POST['mode'];
switch ($mode) {
    case 'upt_res':
        $records['rptdata']= $fn->masterfile_res();

         break; 
         case 'fetch_alu':  
            $records= $fn->fetch_alu(); 
        break;
        case 'fetch_con':
            $records= $fn->fetch_con(); 
        break;
    case 'cof_counter':
        $records= $fn->fetch_cof_counter(); 

        break;
    case 'gen_dr':
        $records['rptdata']= $fn->generate_dr(); 
        break;
    case 'brid':
        $records= $fn->fetch_consign_brid(); 
        break;
    case 'dr_counter':
        $records= $fn->fetch_dr_counter(); 
        break;
    case 'drid':
        $records= $fn->fetch_dr_brid(); 
        break;
    // case 'fr_print':
    //     $records['rptdatax']= $fn->frprint();
    //      break; 
    case 'dr_info':
        $records= $fn->fr_dr_info(); 
         break; 
         case 're_print_dr':
            $records= $fn->re_print_dr(); 
             break; 
    // case 'dr_chck_inv':
    //       $records['rptdata']= $fn->dr_chck_inv();
    //       break;
    case 'inv_breakdown':
            $records['rptdata']= $fn->inv_breakdown();
          break;
    // case 'sls_res':
    //         $records['rptdata']= $fn->sls_res();
    
          break; 
    case 'pd_dash_1':
            $records['rptdata']= $fn->pd_dash_1();
    
          break;
    case 'pd_dash_2':
            $records['rptdata2']= $fn->pd_dash_2();
    
          break; 
    case 'ld_dash_1':
            $records['rptdata1']= $fn->ld_dash_1();
    
          break; 
    case 'ld_dash_2':
            $records['rptdata2']= $fn->ld_dash_2();
    
          break; 
    case 'overallgrph':
            $records= $fn->overallpie_res();
         break;
    case 'ldpieres2':
            $records= $fn->ldpie2();
         break;

    case 'gen_drx':
            $records['datasetx']= $fn->generate_dr(); 
            break;
    case 'versku':
        $records= $fn->verSKU();
        break;
    case 'verPGSKU':
            $records= $fn->verPGSKU();
            break;
    case 'fetch_pg_sku':
            $records= $fn->fetch_pg_sku(); 
        break;
     case 'PGfetch_con':
            $records= $fn->PGfetch_con(); 
        break;
    case 'cof_datatbl':
        $records['rptdatacof']= $fn->fetch_cofdata();
        break;
        case 'sales_datatbl':
            $records['rptdatacof']= $fn->fetch_slsdata();
            break;

    default:


        # code...
        break;
}

echo json_encode($records);

?>