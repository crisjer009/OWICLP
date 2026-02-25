<?php

include '../connection/db.php';
// date_default_timezone_set("Asia/Manila");


class dbconfig extends dbconn
{
 
public function masterfile_res(){

	$query="
	SELECT * FROM tnap_tbl_masterfile";
	
	$statement = $this->connection->prepare($query);
	$statement-> execute();
	$result = $statement->fetchAll();
	$data[] = array();
	// $fetchdata[] = array();

		foreach($result as $row)
				{


				$fetchdata[] = array(
					'OWI SKU' => $row['OWI_SKU'],
					'OWI DESCRIPTION' => $row['OWI_DESCRIPTION'],
					'ITEM CODE' => $row['ITEM_CODE'],
					'PG UPC' => trim($row['PG_UPC']),
					'PRICE' => $row['PRICE']

				);

				}
			$data = array_filter($fetchdata);
            // echo json_encode($data);
				return $data;

	}


	public function fetch_branch(){

		$query="
		SELECT * FROM tnap_tbl_branch";
		
		$statement = $this->connection->prepare($query);
		$statement-> execute();
		$result = $statement->fetchAll();
		$data[] = array();
		// $fetchdata[] = array();
	
			foreach($result as $row)
					{
	
	
					$fetchdata[] = array(
						'str_code' => $row['str_code'],
						'str_desc' => $row['str_desc'],
						'str_longDesc' => $row['str_longDesc']
	
					);
	
					}
				$data = array_filter($fetchdata);
				// echo json_encode($data);
					return $data;
	
		}
 

		public function fetch_alu(){

			
			$query="
			SELECT * FROM tnap_tbl_masterfile WHERE OWI_SKU = '".$_POST['input_alu'] ."'";
			// SELECT * FROM tbl_masterfile WHERE OWI_SKU = '74'";
			
			$statement = $this->connection->prepare($query);
			$statement-> execute();
			$result = $statement->fetchAll();
			$data[] = array();
			$fetchdata[] = array();
			// $comvalres = '';
			$comval = $_POST['comval'];
			switch ($comval) {
				case "PQIN":
					$comvalres = 'COM_PQIN';
					break;
				case "PTAG":
					$comvalres = 'COM_PTAG';
					break;
				case "PCOM":
					$comvalres = 'COM_PCOM';
						break;	
				case "PVAL":
					$comvalres = 'COM_PVAL';
							break;				
				case "PLIB":
					$comvalres = 'COM_PLIB';
					break;		
				case 'PMAK':
					$comvalres = 'COM_PMAK';
					break;
				case 'PMON':
					$comvalres = 'COM_PMON';
					break;
				case 'PSUC':
					$comvalres = 'COM_PSUC';
					break;
				case 'PTAY':
					$comvalres = 'COM_PTAY';
					break;
				case 'PLAS':
					$comvalres = 'COM_PLAS';
					break;
				case 'PDAU':
					$comvalres = 'COM_PDAU';
					break;
					case 'TNAP':
						$comvalres = 'COM_TNAP';
						break;
				default:
					# code...
					break;
			}
		
		
				foreach($result as $row)
						{
		
		
						$fetchdata[] = array(
							'CATEGORY' => $row['CATEGORY'],
							'BRAND' => $row['BRAND'],
							'OWI_SKU' => $row['OWI_SKU'],
							'PG_UPC' => $row['PG_UPC'],
							'PG_SKU' => $row['PG_SKU'],
							'OWI_DESCRIPTION' => $row['OWI_DESCRIPTION'],
							'PRICE' => $row['PRICE'],
							'COM' => $row[$comvalres]

		
						);
		
						}
					$data = array_filter($fetchdata);
					// echo json_encode($data);
						return $data;
		
			}


			public function fetch_cofdata(){

			
				$query="
				SELECT
				tnap_tbl_consign_reports.cof_id,
				tnap_tbl_consign_reports.consign_tag,
				tnap_tbl_consign_reports.OWI_SKU, 
				tnap_tbl_masterfile.PG_UPC, 
				tnap_tbl_masterfile.PG_SKU, 
				tnap_tbl_masterfile.OWI_DESCRIPTION,
				tnap_tbl_consign_reports.consign_qty,
				tnap_tbl_consign_reports.idv_amt,
				tnap_tbl_consign_reports.amt,
				tnap_tbl_consign_reports.contract_num
			FROM
				tnap_tbl_consign_reports
				INNER JOIN
				tnap_tbl_masterfile
				ON 
					tnap_tbl_consign_reports.OWI_SKU = tnap_tbl_masterfile.OWI_SKU
					WHERE consign_tag = '".$_POST['tag_id'] ."'
					ORDER BY tnap_tbl_consign_reports.cof_id";
				// SELECT * FROM tbl_masterfile WHERE OWI_SKU = '74'";
				// $query= "";
				$statement = $this->connection->prepare($query);
				$statement-> execute();
				$result = $statement->fetchAll();
				$data[] = array();
				// $fetchdata[] = array();
				// $comvalres = '';
			
			
					foreach($result as $row)
							{
			
			
							$fetchdata[] = array(
								'cof_id' => $row['cof_id'],
								'consign_tag' => $row['consign_tag'],
								'OWI_SKU' => $row['OWI_SKU'],
								'PG_UPC' => $row['PG_UPC'],
								'PG_SKU' => $row['PG_SKU'],
								'OWI_DESCRIPTION' => $row['OWI_DESCRIPTION'],
								'consign_qty' => $row['consign_qty'],
								'idv_amt' => $row['idv_amt'],
								'amt' => $row['amt'],
								'contract_num' => $row['contract_num']
	
			
							);
			
							}
						$data = array_filter($fetchdata);
						// echo json_encode($data);
							return $data;
			
				}


				public function fetch_slsdata(){

			
					$query="
					SELECT
					tnap_tbl_sales_reports.cof_id,
					tnap_tbl_sales_reports.consign_tag,
					tnap_tbl_sales_reports.OWI_SKU, 
					tnap_tbl_masterfile.PG_UPC, 
					tnap_tbl_masterfile.PG_SKU, 
					tnap_tbl_masterfile.OWI_DESCRIPTION,
					tnap_tbl_sales_reports.consign_qty,
					tnap_tbl_sales_reports.idv_amt,
					tnap_tbl_sales_reports.amt,
					tnap_tbl_sales_reports.contract_num,
					tnap_tbl_sales_reports.date_created
				FROM
					tnap_tbl_sales_reports
					INNER JOIN
					tnap_tbl_masterfile
					ON 
						tnap_tbl_sales_reports.OWI_SKU = tnap_tbl_masterfile.OWI_SKU
						WHERE consign_tag = '".$_POST['tag_id'] ."'
						ORDER BY tnap_tbl_sales_reports.cof_id";
					// SELECT * FROM tbl_masterfile WHERE OWI_SKU = '74'";
					// $query= "";
					$statement = $this->connection->prepare($query);
					$statement-> execute();
					$result = $statement->fetchAll();
					$data[] = array();
					// $fetchdata[] = array();
					// $comvalres = '';
				
				
						foreach($result as $row)
								{
				
				
								$fetchdata[] = array(
									'cof_id' => $row['cof_id'],
									'consign_tag' => $row['consign_tag'],
									'OWI_SKU' => $row['OWI_SKU'],
									'PG_UPC' => $row['PG_UPC'],
									'PG_SKU' => $row['PG_SKU'],
									'OWI_DESCRIPTION' => $row['OWI_DESCRIPTION'],
									'consign_qty' => $row['consign_qty'],
									'idv_amt' => $row['idv_amt'],
									'amt' => $row['amt'],
									'contract_num' => $row['contract_num'],
									'date_created' => $row['date_created'],

		
				
								);
				
								}
							$data = array_filter($fetchdata);
							// echo json_encode($data);
								return $data;
				
					}



			public function fetch_pg_sku(){

			
				$query="
				SELECT * FROM tnap_tbl_masterfile WHERE PG_SKU = '".$_POST['input_alu'] ."'";
				// SELECT * FROM tbl_masterfile WHERE OWI_SKU = '74'";
				
				$statement = $this->connection->prepare($query);
				$statement-> execute();
				$result = $statement->fetchAll();
				$data[] = array();
				$fetchdata[] = array();
				// $comvalres = '';
				$comval = $_POST['comval'];
				switch ($comval) {
					case "PQIN":
						$comvalres = 'COM_PQIN';
						break;
					case "PTAG":
						$comvalres = 'COM_PTAG';
						break;
					case "PCOM":
						$comvalres = 'COM_PCOM';
							break;	
					case "PVAL":
						$comvalres = 'COM_PVAL';
								break;						
					case 'PLIB':
						$comvalres = 'COM_PLIB';
						break;
					case 'PMAK':
						$comvalres = 'COM_PMAK';
						break;
					case 'PMON':
						$comvalres = 'COM_PMON';
						break;
					case 'PSUC':
						$comvalres = 'COM_PSUC';
						break;
					case 'PTAY':
						$comvalres = 'COM_PTAY';
						break;
					case 'PLAS':
						$comvalres = 'COM_PLAS';
						break;
					case 'PDAU':
						$comvalres = 'COM_PDAU';
						break;
						case 'TNAP':
							$comvalres = 'COM_TNAP';
							break;
					default:
						# code...
						break;
				}
			
			
					foreach($result as $row)
							{
			
			
							$fetchdata[] = array(
								'CATEGORY' => $row['CATEGORY'],
								'BRAND' => $row['BRAND'],
								'PG_UPC' => $row['PG_UPC'],
								'OWI_SKU' => $row['OWI_SKU'],
								'PG_SKU' => $row['PG_SKU'],
								'OWI_DESCRIPTION' => $row['OWI_DESCRIPTION'],
								'PRICE' => $row['PRICE'],
								'COM' => $row[$comvalres]
	
			
							);
			
							}
						$data = array_filter($fetchdata);
						// echo json_encode($data);
							return $data;
			
				}

			public function fetch_con(){

			
				$query="
				SELECT * FROM tnap_tbl_masterfile WHERE OWI_SKU = '".$_POST['inalu'] ."'";
				// SELECT * FROM tbl_masterfile WHERE OWI_SKU = '74'";
				
				$statement = $this->connection->prepare($query);
				$statement-> execute();
				$result = $statement->fetchAll();
				$data[] = array();
				$fetchdata[] = array();
				// $comvalres = '';
				$comval = $_POST['cmval'];
				switch ($comval) {
					case "PQIN":
						$comvalres = 'COM_PQIN';
						break;
					case "PTAG":
						$comvalres = 'COM_PTAG';
						break;
					case "PCOM":
						$comvalres = 'COM_PCOM';
							break;	
					case "PVAL":
						$comvalres = 'COM_PVAL';
								break;		
				  	case 'PLIB':
						$comvalres = 'COM_PLIB';
						break;	
					case 'PMAK':
						$comvalres = 'COM_PMAK';
						break;	
					case 'PMON':
						$comvalres = 'COM_PMON';
						break;
					case 'PSUC':
						$comvalres = 'COM_PSUC';
						break;
					case 'PTAY':
						$comvalres = 'COM_PTAY';
						break;
					case 'PLAS':
						$comvalres = 'COM_PLAS';
						break;
					case 'PDAU':
						$comvalres = 'COM_PDAU';
						break;
						case 'TNAP':
							$comvalres = 'COM_TNAP';
							break;
					
					default:
						# code...
						break;
				}
			
			
					foreach($result as $row)
							{
			
			
							$fetchdata[] = array(

								'COM' => $row[$comvalres],
								'price' => $row['PRICE']
	
			
							);
			
							}
						$data = array_filter($fetchdata);
						// echo json_encode($data);
							return $data;
			
				} 

			public function fetch_cof_counter(){

				$query="
				SELECT * FROM tnap_tbl_consign_counter";
				
				$statement = $this->connection->prepare($query);
				$statement-> execute();
				$result = $statement->fetchAll();
				$data[] = array();
				// $fetchdata[] = array();
			
					foreach($result as $row)
							{
			
			
							$fetchdata[] = array(
								'cof_counter' => $row['cof_counter']
			
							);
			
							}
						$data = array_filter($fetchdata);
						// echo json_encode($data);
							return $data;
			
				}

				public function generate_dr(){

					// $query="
					// SELECT
					// tbl_consign_reports.consign_tag AS consign_tag,
					// tbl_consign_reports.branch_id AS branch_id,
					// tbl_branch.branch_desc AS branch_desc,
					// tbl_consign_reports.OWI_SKU AS OWI_SKU,
					// tbl_masterfile.PG_UPC AS PG_UPC,
					// tbl_masterfile.PG_SKU AS PG_SKU,
					// tbl_masterfile.OWI_DESCRIPTION AS OWI_DESCRIPTION,
					// tbl_masterfile.BRAND AS BRAND,
					// tbl_masterfile.COLOR AS COLOR,
					// tbl_masterfile.SIZE AS SIZE,
					// tbl_consign_reports.consign_qty AS consign_qty,
					// tbl_masterfile.UNIT AS UNIT,
					// tbl_masterfile.PRICE AS PRICE,
					// tbl_masterfile.COM_PQIN AS COM_PQIN,
					// tbl_masterfile.COM_PTAG AS COM_PTAG,
					// tbl_masterfile.COM_PCOM AS COM_PCOM,
					// tbl_masterfile.COM_PVAL AS COM_PVAL,
					// tbl_masterfile.COM_PLIB AS COM_PLIB,
					// tbl_masterfile.COM_PMAK AS COM_PMAK,
					// tbl_masterfile.COM_PMON AS COM_PMON,
					// tbl_masterfile.COM_PSUC AS COM_PSUC,
					// tbl_masterfile.COM_PTAY AS COM_PTAY,
					// tbl_masterfile.COM_PLAS AS COM_PLAS,
					// tbl_masterfile.COM_PDAU AS COM_PDAU,
					// (tbl_consign_reports.consign_qty * tbl_masterfile.PRICE) AS TOTAL,
					// tbl_consign_reports.contract_num
					// FROM ((`tbl_consign_reports` join `tbl_masterfile` on(`tbl_masterfile`.`OWI_SKU` = `tbl_consign_reports`.`OWI_SKU`)) join `tbl_branch` on(`tbl_branch`.`branch_id` = `tbl_consign_reports`.`branch_id`))
					// WHERE tbl_consign_reports.consign_tag = '".$_POST['cof'] ."' AND consign_qty <> '0'
					// ";
										$query="
										SELECT
										tnap_tbl_consign_reports.consign_tag AS consign_tag,
										tnap_tbl_consign_reports.branch_id AS branch_id,
										tnap_tbl_branch.branch_desc AS branch_desc,
										tnap_tbl_consign_reports.OWI_SKU AS OWI_SKU,
										tnap_tbl_masterfile.PG_UPC AS PG_UPC,
										tnap_tbl_masterfile.PG_SKU AS PG_SKU,
										tnap_tbl_masterfile.OWI_DESCRIPTION AS OWI_DESCRIPTION,
										tnap_tbl_masterfile.BRAND AS BRAND,
										tnap_tbl_masterfile.COLOR AS COLOR,
										tnap_tbl_masterfile.SIZE AS SIZE,
										tnap_tbl_consign_reports.consign_qty AS consign_qty,
										tnap_tbl_masterfile.UNIT AS UNIT,
										tnap_tbl_masterfile.PRICE AS PRICE,
										tnap_tbl_masterfile.COM_PQIN AS COM_PQIN,
										tnap_tbl_masterfile.COM_PTAG AS COM_PTAG,
										tnap_tbl_masterfile.COM_PCOM AS COM_PCOM,
										tnap_tbl_masterfile.COM_PVAL AS COM_PVAL,
										tnap_tbl_masterfile.COM_PLIB AS COM_PLIB,
										tnap_tbl_masterfile.COM_PMAK AS COM_PMAK,
										tnap_tbl_masterfile.COM_PMON AS COM_PMON,
										tnap_tbl_masterfile.COM_PSUC AS COM_PSUC,
										tnap_tbl_masterfile.COM_PTAY AS COM_PTAY,
										tnap_tbl_masterfile.COM_PLAS AS COM_PLAS,
										tnap_tbl_masterfile.COM_PDAU AS COM_PDAU,
										tnap_tbl_masterfile.COM_TNAP AS COM_TNAP,
										( tnap_tbl_consign_reports.consign_qty * tnap_tbl_masterfile.PRICE ) AS TOTAL,
										tnap_tbl_consign_reports.contract_num,
										tnap_tbl_consign_reports.cof_id 
									FROM
										(
											( tnap_tbl_consign_reports JOIN tnap_tbl_masterfile ON ( tnap_tbl_masterfile.OWI_SKU = tnap_tbl_consign_reports.OWI_SKU ) )
											JOIN tnap_tbl_branch ON ( tnap_tbl_branch.branch_id = tnap_tbl_consign_reports.branch_id ) 
										) 
									WHERE
										tnap_tbl_consign_reports.consign_tag = '".$_POST['cof'] ."' 
										AND consign_qty <> '0'
										ORDER BY cof_id ASC
										
					";
					
					$statement = $this->connection->prepare($query);
					$statement-> execute();
					$result = $statement->fetchAll();
					$data[] = array();
					// $fetchdata[] = array();
				
						foreach($result as $row)
								{
				
				
								$fetchdata[] = array(
									'consign_tag' => $row['consign_tag'],
									'branch_id' => $row['branch_id'],
									'OWI SKU' => $row['OWI_SKU'],
									'PG_UPC' => $row['PG_UPC'],
									'PG_SKU' => $row['PG_SKU'],
									'OWI DESCRIPTION' => $row['OWI_DESCRIPTION'],
									'BRAND' => $row['BRAND'],
									'COLOR' => $row['COLOR'],
									'SIZE' => $row['SIZE'],
									'consign_qty' => $row['consign_qty'],
									'UNIT' => $row['UNIT'],
									
									// 'PRICE' => $row['PRICE'],
									'PRICE' => number_format((float)$row['PRICE'], 2, '.', ''),
									'TOTAL' => number_format((float)$row['TOTAL'], 2, '.', ''),
									'contract_num' => $row['contract_num'],
									// tbl_consign_reports.contract_num
									// 'TOTAL'  => $row['consign_qty'] * $row['PRICE']
				
		 						);
				
				 				}
							$data = array_filter($fetchdata);
							// echo json_encode($data);
								return $data;
				
					}




			public function fetch_consign_brid(){

				$query="
				SELECT  * FROM tnap_tbl_consign_reports WHERE consign_tag = '".$_POST['cof']."'";
				
				$statement = $this->connection->prepare($query);
				$statement-> execute();
				$result = $statement->fetchAll();
				$data[] = array();
				// $fetchdata[] = array();
			
					foreach($result as $row)
							{
			
			
							$fetchdata[] = array(
								'branch_id' => $row['branch_id'],
								'dr_tag' => $row['dr_tag']
								
			
							);
			
							}
						$data = array_filter($fetchdata);
						// echo json_encode($data);
							return $data;
			
				}

				public function fetch_dr_counter(){

					$query="
					SELECT * FROM tnap_tbl_dr_counter WHERE ld_user_secID = '".$_POST['x']."'";
					
					$statement = $this->connection->prepare($query);
					$statement-> execute();
					$result = $statement->fetchAll();
					$data[] = array();
					// $fetchdata[] = array();
				
						foreach($result as $row)
								{
				
				
								$fetchdata[] = array(
									'dr_counter' => $row['dr_counter']
				
								);
				
								}
							$data = array_filter($fetchdata);
							// echo json_encode($data);
								return $data;
				
					}
					public function fetch_dr_brid(){

						$query="
						SELECT DISTINCT branch_id FROM tnap_tbl_consign_reports WHERE consign_tag = '".$_POST['dr']."'";
						
						$statement = $this->connection->prepare($query);
						$statement-> execute();
						$result = $statement->fetchAll();
						$data[] = array();
						// $fetchdata[] = array();
					
							foreach($result as $row)
									{
					
					
									$fetchdata[] = array(
										'branch_id' => $row['branch_id']
					
									);
					 
									}
								$data = array_filter($fetchdata);
								// echo json_encode($data);
									return $data;
					
						}

						public function fr_dr_info(){

							$query="
							SELECT
							tnap_tbl_dr.dr_tag AS dr_tag,
							tnap_tbl_dr.consign_tag AS consign_tag,
							tnap_tbl_dr.branch_id AS branch_id,
							tnap_tbl_branch.branch_desc AS branch_desc,
							tnap_tbl_branch.branch_longDesc AS branch_longDesc,
							tnap_tbl_branch.branch_address AS branch_address,
							tnap_tbl_dr.del_date AS del_date
							from (`tnap_tbl_dr` join `tnap_tbl_branch` on(`tnap_tbl_branch`.`branch_id` = `tnap_tbl_dr`.`branch_id`))
							WHERE tnap_tbl_dr.dr_tag = '".$_POST['xl']."'
							";
							
							$statement = $this->connection->prepare($query);
							$statement-> execute();
							$result = $statement->fetchAll();
							$data[] = array();
							// $fetchdata[] = array();
						
								foreach($result as $row)
										{
						
						
										$fetchdata[] = array(
											'dr_tag' => $row['dr_tag'],
											'consign_tag' => $row['consign_tag'],
											'branch_id' => $row['branch_id'],
											'branch_longDesc' => $row['branch_longDesc'],
											'branch_address' => $row['branch_address'],
											'del_date' => date('m/d/Y',strtotime($row["del_date"]))

											
						
										);
						
										}
									$data = array_filter($fetchdata);
									// echo json_encode($data);
										return $data;
						
							}



							public function re_print_dr(){

								$query="
								SELECT
								tnap_tbl_dr.dr_tag AS dr_tag,
								tnap_tbl_dr.consign_tag AS consign_tag,
								tnap_tbl_dr.branch_id AS branch_id,
								tnap_tbl_branch.branch_desc AS branch_desc,
								tnap_tbl_branch.branch_longDesc AS branch_longDesc,
								tnap_tbl_branch.branch_address AS branch_address,
								tnap_tbl_dr.del_date AS del_date
								from (`tnap_tbl_dr` join `tnap_tbl_branch` on(`tnap_tbl_branch`.`branch_id` = `tnap_tbl_dr`.`branch_id`))
								WHERE tnap_tbl_dr.consign_tag = '".$_POST['xl']."'
								";
								
								$statement = $this->connection->prepare($query);
								$statement-> execute();
								$result = $statement->fetchAll();
								$data[] = array();
								// $fetchdata[] = array();
							
									foreach($result as $row)
											{
							
							
											$fetchdata[] = array(
												'dr_tag' => $row['dr_tag'],
												'consign_tag' => $row['consign_tag'],
												'branch_id' => $row['branch_id'],
												'branch_longDesc' => $row['branch_longDesc'],
												'branch_address' => $row['branch_address'],
												'del_date' => date('m/d/Y',strtotime($row["del_date"]))
	
												
							
											);
							
											}
										$data = array_filter($fetchdata);
										// echo json_encode($data);
											return $data;
							
								}

							// public function dr_chck_inv(){

							// 	$query="
							// 	SELECT
							// 	tnap_tbl_masterfile.OWI_SKU,
							// 	tnap_tbl_masterfile.OWI_DESCRIPTION,
							// 	tnap_tbl_masterfile.cwh_qty,
							// 	tnap_tbl_masterfile.cwh_bgn_qty,
							// 	tnap_tbl_pqimasterfile.inv_qty AS pqiqty,
							// 	tnap_tbl_tgmasterfile.inv_qty AS ptagqty
							// 	FROM
							// 	tnap_tbl_masterfile
							// 	INNER JOIN tbl_pqimasterfile ON tbl_pqimasterfile.OWI_SKU = tbl_masterfile.OWI_SKU
							// 	INNER JOIN tbl_tgmasterfile ON tbl_tgmasterfile.OWI_SKU = tbl_masterfile.OWI_SKU					
							// 	";
								
							// 	$statement = $this->connection->prepare($query);
							// 	$statement-> execute();
							// 	$result = $statement->fetchAll();
							// 	$data[] = array();
							// 	// $fetchdata[] = array();
							
							// 		foreach($result as $row)
							// 				{
							
							
							// 				$fetchdata[] = array(
							// 					'OWI_SKU' => $row['OWI_SKU'],
							// 					'OWI_DESCRIPTION' => $row['OWI_DESCRIPTION'],
							// 					'cwh_qty' => $row['cwh_qty'],
							// 					'cwh_bgn_qty' => $row['cwh_bgn_qty'],
							// 					'pqiqty' => $row['pqiqty'],
							// 					'ptagqty' => $row['ptagqty'],
							// 					'cwh_onhand' => $row['cwh_bgn_qty'] - $row['cwh_qty']
												
							// 				);
							
							// 				}
							// 			$data = array_filter($fetchdata);
							// 			// echo json_encode($data);
							// 				return $data;
							
							// 	}						
							
								public function inv_breakdown(){

									$query="
									SELECT
									tnap_tbl_masterfile.OWI_SKU AS OWI_SKU,
									tnap_tbl_branch.branch_id AS branch_id,
									tnap_tbl_branch.branch_desc AS branch_desc,
									tnap_tbl_dr.dr_tag AS dr_tag,
									tnap_tbl_dr.del_date AS del_date,
									tnap_tbl_masterfile.OWI_DESCRIPTION AS OWI_DESCRIPTION,
									tnap_tbl_consign_reports.consign_tag AS consign_tag,
									tnap_tbl_consign_reports.consign_qty AS consign_qty
									from ((((`tnap_tbl_consign_reports` left join `tnap_tbl_dr` on(`tnap_tbl_dr`.`consign_tag` = `tnap_tbl_consign_reports`.`consign_tag`)) left join `tnap_tbl_masterfile` on(`tnap_tbl_consign_reports`.`OWI_SKU` = `tnap_tbl_masterfile`.`OWI_SKU`)) left join `tnap_tbl_branch` on(`tnap_tbl_consign_reports`.`branch_id` = `tnap_tbl_branch`.`branch_id`)) left join `tbl_pqimasterfile` on(`tbl_pqimasterfile`.`OWI_SKU` = `tnap_tbl_masterfile`.`OWI_SKU`))
									where `tnap_tbl_consign_reports`.`OWI_SKU` = '".$_POST['form_sku'] ."'
													
									";
									
									$statement = $this->connection->prepare($query);
									$statement-> execute();
									$result = $statement->fetchAll();
									$data[] = array();
									// $fetchdata[] = array();
								
										foreach($result as $row)
												{
								
								
												$fetchdata[] = array(
													'OWI_SKU' => $row['OWI_SKU'],
													'OWI_DESCRIPTION' => $row['OWI_DESCRIPTION'],
													'consign_tag' => $row['consign_tag'],
													'branch_desc' => $row['branch_desc'],
													'dr_tag' => $row['dr_tag'],
													'del_date' => $row['del_date'],
													'consign_qty' => $row['consign_qty']
												
													
												);
								
												}
											$data = array_filter($fetchdata);
											// echo json_encode($data);
												return $data;
								
									}	
									
									

									

										public function pd_dash_1(){

											$query="
											SELECT DISTINCT
											tnap_tbl_consign_reports.cof_id, 
											tnap_tbl_consign_reports.consign_tag, 
											date_created, 
											tnap_tbl_consign_reports.dr_tag, 
											ref_co, 
											cof_crt_usr, 
											tnap_tbl_user.f_name, 
											tnap_tbl_user.lst_name, 
											tnap_tbl_dr.user_id AS ld_usr_id, 
											tnap_tbl_user.f_name AS ld_fname, 
											tnap_tbl_user.lst_name AS ld_lstname
										FROM
											tnap_tbl_consign_reports
											INNER JOIN
											tnap_tbl_user
											ON 
												tnap_tbl_consign_reports.cof_crt_usr = tnap_tbl_user.id
											LEFT JOIN
											tnap_tbl_dr
											ON 
												tnap_tbl_consign_reports.consign_tag = tnap_tbl_dr.consign_tag
										GROUP BY
											consign_tag";
											
											$statement = $this->connection->prepare($query);
											$statement-> execute();
											$result = $statement->fetchAll();
											$data[] = array();
											// $fetchdata[] = array();
											
											
										// $date = $row['date_created'];
										// $date1 = date("Y-m-d", strtotime($date));
												foreach($result as $row)
														{
										
										
														$fetchdata[] = array(
															'consign_tag' => $row['consign_tag'],
															
															'date_created' =>  date('m/d/Y',strtotime($row["date_created"])),
															// 'date_created' =>  $row['date_created'],
															
															'dr_tag' => $row['dr_tag'],
															'ttl_qty' => $this->pd_dash_ext($row['consign_tag']),
															'ttl_amt' => $this->pd_dash_ext_2($row['consign_tag']),
															'ref_co' => $row['ref_co'],
															'cof_crt' => $row['f_name'].' '.$row['lst_name'],
															'ld_crt' => $row['ld_fname'].' '.$row['ld_lstname'],
															// number_format($number, 2, '.', ',')
															// 'cof_crt' => $this->pd_dash_ext_3($row['consign_tag'])


															// 'ttl_amt' => $this->pd_dash_ext_2(number_format((float)$row['consign_tag'], 2, '.', ''),)

														
															
										
														);
										
														}
													$data = array_filter($fetchdata);
													// echo json_encode($data);
														return $data;
										
											}

// new update for total qty of cof files
											public function pd_dash_ext($ttl_qty){
												$query="
												SELECT  SUM(consign_qty) AS ttl_qty FROM tnap_tbl_consign_reports
												WHERE consign_tag = '".$ttl_qty."'
												";
												
												$statement = $this->connection->prepare($query);
												$statement-> execute();
												$result = $statement->fetchAll();
												$data[] = array();
												// $fetchdata[] = array();
												
												
											// $date = $row['date_created'];
											// $date1 = date("Y-m-d", strtotime($date));
													foreach($result as $row)
															{
											
											
															$fetchdata[] = array(
																'ttl_qty' => $row['ttl_qty'],
															);

											
															}
														$data = json_decode($row['ttl_qty']);
														// echo json_encode($data);
															return $data;
											}

											public function pd_dash_ext_2($ttl_amt){
												$query="
												SELECT  SUM(amt) AS ttl_amt FROM tnap_tbl_consign_reports
												WHERE consign_tag = '".$ttl_amt."'
												";
												
												$statement = $this->connection->prepare($query);
												$statement-> execute();
												$result = $statement->fetchAll();
												$data[] = array();
												// $fetchdata[] = array();
												
												
											// $date = $row['date_created'];
											// $date1 = date("Y-m-d", strtotime($date));
													foreach($result as $row)
															{
											
											
															$fetchdata[] = array(
																'ttl_amt' => number_format($row['ttl_amt'], 2, '.', ''),
																// number_format($number, 2, '.', ',')
															);

											
															}
														$data = json_decode($row['ttl_amt']);
														// echo json_encode($data);
															return $data;
											}

											// public function pd_dash_ext_3($cof_crt_usr){
											// 	$query="
											// 	SELECT
											// 	tbl_consign_reports.*, 
											// 	tbl_user.f_name
											
											// FROM
											// 	tbl_consign_reports
											// 	INNER JOIN
											// 	tbl_user
											// 	ON 
											// 		tbl_consign_reports.cof_crt_usr = tbl_user.id
											// 	WHERE consign_tag = '".$cof_crt_usr."'
											// 	";
												
											// 	$statement = $this->connection->prepare($query);
											// 	$statement-> execute();
											// 	$result = $statement->fetchAll();
											// 	$data[] = array();
											// 	// $fetchdata[] = array();
												
												
											// // $date = $row['date_created'];
											// // $date1 = date("Y-m-d", strtotime($date));
											// 		foreach($result as $row)
											// 				{
											
											
											// 				$fetchdata[] = array(
											// 					'cof_crt_usr' => $row['f_name'] ,
											// 					// number_format($number, 2, '.', ',')
											// 				);

											
											// 				}
											// 			$data = json_decode($row['f_name']);
											// 			// echo json_encode($data);
											// 				return $data;
											// }



											public function pd_dash_2(){

												$query="
												select `tnap_tbl_priceupdatehist`.`OWI_SKU` AS `OWI_SKU`,`tnap_tbl_priceupdatehist`.`date_updated` AS `date_updated`,`tnap_tbl_priceupdatehist`.`prev_price` AS `prev_price`,`tnap_tbl_priceupdatehist`.`new_price` AS `new_price`,`tnap_tbl_priceupdatehist`.`prev_upc` AS `prev_upc`,`tnap_tbl_priceupdatehist`.`new_upc` AS `new_upc`,`tnap_tbl_priceupdatehist`.`upt_reason` AS `upt_reason`,`tnap_tbl_priceupdatehist`.`user_id` AS `user_id`,`tnap_tbl_user`.`f_name` AS `f_name`,`tnap_tbl_user`.`lst_name` AS `lst_name`,`tnap_tbl_priceupdatehist`.`upt_id` AS `upt_id` from (`tnap_tbl_priceupdatehist` join `tnap_tbl_user` on(`tnap_tbl_user`.`id` = `tnap_tbl_priceupdatehist`.`user_id`)) order by `tnap_tbl_priceupdatehist`.`upt_id` desc
												
												";
												
												$statement = $this->connection->prepare($query);
												$statement-> execute();
												$result = $statement->fetchAll();
												$data[] = array();
												// $fetchdata[] = array();
												
							 
												
	
													foreach($result as $row)
															{
											
											
															$fetchdata[] = array(
																'date_updated' => date('m/d/Y H:i:s',strtotime($row["date_updated"])),
																'upt_id' => $row['upt_id'],
																'OWI_SKU' => $row['OWI_SKU'],
																'prev_price' => $row['prev_price'],
																'new_price' => $row['new_price'],
																'mrk' => $row['upt_reason'],
																
																
																'user_name' => strtoupper($row['f_name'] ." " . $row['lst_name']) 
														
																
											
															);
											
															}
														$data = array_filter($fetchdata);
														// echo json_encode($data);
															return $data;
											
												}

												public function ld_dash_1(){

													$query="SELECT DISTINCT consign_tag, date_created,dr_tag FROM tnap_tbl_consign_reports WHERE dr_tag != 'Y'
													";
													
													$statement = $this->connection->prepare($query);
													$statement-> execute();
													$result = $statement->fetchAll();
													$data[] = array();
													// $fetchdata[] = array();
													
													
												// $date = $row['date_created'];
												// $date1 = date("Y-m-d", strtotime($date));
														foreach($result as $row)
																{
												
												
																$fetchdata[] = array(
																	'consign_tag' => $row['consign_tag'],
																	'date_created' =>  date('m/d/Y',strtotime($row["date_created"])),
																	'dr_tag' => $row['dr_tag']
																	
												
																);
												
																}
															$data = array_filter($fetchdata);
															// echo json_encode($data);
																return $data;
												
													}

													public function ld_dash_2(){

														$query="
														SELECT
														tnap_tbl_dr.dr_id,
														tnap_tbl_dr.dr_tag,
														tnap_tbl_dr.consign_tag,
														tnap_tbl_dr.del_date,
														tnap_tbl_dr.user_id,
														tnap_tbl_dr.branch_id,
														tnap_tbl_branch.branch_desc,
														tnap_tbl_user.f_name,
														tnap_tbl_user.lst_name
														FROM
														tnap_tbl_dr
														INNER JOIN tnap_tbl_user ON tnap_tbl_user.id = tnap_tbl_dr.user_id
														INNER JOIN tnap_tbl_branch ON tnap_tbl_branch.branch_id = tnap_tbl_dr.branch_id";
														
														$statement = $this->connection->prepare($query);
														$statement-> execute();
														$result = $statement->fetchAll();
														$data[] = array();
														// $fetchdata[] = array();
														
														
													// $date = $row['date_created'];
													// $date1 = date("Y-m-d", strtotime($date));
															foreach($result as $row)
																	{
													
													
																	$fetchdata[] = array(
																		'consign_tag' => $row['consign_tag'],
																		'dr_tag' => $row['dr_tag'],
																		'del_date' =>  date('m/d/Y',strtotime($row["del_date"])),
																		'branch_desc' => $row['branch_desc'],
																		'user_name' => $row['f_name']. " " . $row['lst_name']
					

																															
																	);
													
																	}
																$data = array_filter($fetchdata);
																// echo json_encode($data);
																	return $data;
													
														}

														public function overallpie_res(){

															$query="

															SELECT
															COUNT(tnap_tbl_crdr_stat.stat) AS clcount,
															tnap_tbl_crdr_stat_desc.stat_desc AS stat_desc
															FROM
															tnap_tbl_crdr_stat
															INNER JOIN tnap_tbl_crdr_stat_desc ON tnap_tbl_crdr_stat_desc.stat = tnap_tbl_crdr_stat.stat
															GROUP BY tnap_tbl_crdr_stat_desc.stat_desc
															
													
															";
													
															$statement = $this->connection->prepare($query);
															$statement-> execute();
															$result = $statement->fetchAll();
															$data = array();
													
															foreach ($result as $row) {
															$data[] = array(
															'stat_name' => $row["stat_desc"], 
															'points' => $row["clcount"]
													
																);
															}
															return $data;
														}

														public function ldpie2(){

															$query="

															select `tnap_tbl_branch`.`branch_longDesc` AS `stat_name`,count(`tnap_tbl_dr`.`branch_id`) AS `points` from (`tnap_tbl_dr` join `tnap_tbl_branch` on(`tnap_tbl_branch`.`branch_id` = `tnap_tbl_dr`.`branch_id`)) group by `tnap_tbl_dr`.`branch_id`
													
															";
													
															$statement = $this->connection->prepare($query);
															$statement-> execute();
															$result = $statement->fetchAll();
															$data = array();
													
															foreach ($result as $row) {
															$data[] = array(
															'stat_name' => $row["stat_name"], 
															'points' => $row["points"]
													
																);
															}
															return $data;
														}

														// public function sls_res(){

														// 	$query="
														// 	SELECT * FROM tbl_pqimasterfile";
															
														// 	$statement = $this->connection->prepare($query);
														// 	$statement-> execute();
														// 	$result = $statement->fetchAll();
														// 	$data[] = array();
														// 	// $fetchdata[] = array();
														
														// 		foreach($result as $row)
														// 				{
														
														
														// 				$fetchdata[] = array(
														// 					'PG_SKU' => $row['PG_SKU'],
														// 					'OWI SKU' => $row['OWI_SKU'],
														// 					'OWI DESCRIPTION' => $row['OWI_DESCRIPTION'],
														// 					'inv_qty' => $row['inv_qty'],
														// 					'sls_qty' => $row['sls_qty'],
														// 					'PRICE' => $row['PRICE'],
														// 					'ONHAND' => $row['inv_qty'] - $row['sls_qty']
														
														// 				);
														
														// 				}
														// 			$data = array_filter($fetchdata);
														// 			// echo json_encode($data);
														// 				return $data;
														
														// 	}


															public function verSKU(){

																$query="
																SELECT *  FROM tnap_tbl_masterfile";
																
																$statement = $this->connection->prepare($query);
																$statement-> execute();
																$result = $statement->fetchAll();
																$data[] = array();
																// $fetchdata[] = array();
																
																
															// $date = $row['date_created'];
															// $date1 = date("Y-m-d", strtotime($date));

															foreach ($result as $row => $v) {
																$fetchdata[]=$v['OWI_SKU'];
															}
																		// echo json_encode($fetchdata);
																	$data = array_filter($fetchdata);
															return $fetchdata;

															
																}

																public function verPGSKU(){

																	$query="
																	SELECT *  FROM tnap_tbl_masterfile";
																	
																	$statement = $this->connection->prepare($query);
																	$statement-> execute();
																	$result = $statement->fetchAll();
																	$data[] = array();
																	// $fetchdata[] = array();
																	
																	
																// $date = $row['date_created'];
																// $date1 = date("Y-m-d", strtotime($date));
	
																foreach ($result as $row => $v) {
																	$fetchdata[]=$v['PG_SKU'];
																}
																			// echo json_encode($fetchdata);
																		$data = array_filter($fetchdata);
																return $fetchdata;
	
																
																	}

																	public function PGfetch_con(){

			 
																		$query="
																		SELECT * FROM tnap_tbl_masterfile WHERE PG_SKU = '".$_POST['inalu'] ."'";
																		// SELECT * FROM tbl_masterfile WHERE OWI_SKU = '74'";
																		
																		$statement = $this->connection->prepare($query);
																		$statement-> execute();
																		$result = $statement->fetchAll();
																		$data[] = array();
																		$fetchdata[] = array();
																		// $comvalres = '';
																		$comval = $_POST['cmval'];
																		switch ($comval) {
																			case "PQIN":
																				$comvalres = 'COM_PQIN';
																				break;
																			case "PTAG":
																				$comvalres = 'COM_PTAG';
																				break;
																			case "PCOM":
																				$comvalres = 'COM_PCOM';
																					break;	
																			case "PVAL":
																				$comvalres = 'COM_PVAL';
																						break;		
																			case 'PLIB':
																				$comvalres = 'COM_PLIB';
																				break;	
																			case 'PMAK':
																				$comvalres = 'COM_PMAK';
																				break;	
																			case 'PMON':
																				$comvalres = 'COM_PMON';
																				break;
																			case 'PSUC':
																				$comvalres = 'COM_PSUC';
																				break;
																			case 'PTAY':
																				$comvalres = 'COM_PTAY';
																				break;
																			case 'PLAS':
																				$comvalres = 'COM_PLAS';
																				break;
																			case 'PDAU':
																				$comvalres = 'COM_PDAU';
																				break;
																				case 'TNAP':
																					$comvalres = 'COM_TNAP';
																					break;

																			
																			default:
																				# code...
																				break;
																		}
																	
																	
																			foreach($result as $row)
																					{
																	
																	
																					$fetchdata[] = array(
														
																						'COM' => $row[$comvalres]
															
																	
																					);
																	
																					}
																				$data = array_filter($fetchdata);
																				// echo json_encode($data);
																					return $data;
																	
																		} 


	} // class end bracket






// $fn = new dbconfig();	
// $fn->verSKU();


?>
