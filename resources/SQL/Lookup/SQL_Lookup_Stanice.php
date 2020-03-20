<?php
	ob_start();
	require_once '../SQL_funkcije.php';	// 

	$DirSep = DajDirSeparator();
	$StazaSQLpar = dirname(dirname(dirname(getcwd()  ) ));
	include $StazaSQLpar . $DirSep . 'Data/SQLParametri_PDO.php';	//
		
	$start	= GetSQLValueString($_POST['start'],  	"int");
	$end  	= GetSQLValueString($_POST['limit'],  	"int");
	$page  	= GetSQLValueString($_POST['page'],  	"int");
	$query  	= $_POST['query'];

	ob_end_clean();
		 
	$TabelaOdgovora = Array(); $rowData = Array();
	$Query_Ceo = SQLUpit($DatPrefix, $query);
	// if ($SortPolje == ''){
	// 	$SortPolje = 'AA.PreIme';
	// }else{
	// 	switch ($SortPolje) {
	// 	case 'PreIme':
	// 		$SortPolje = 'AA.PreIme'; break;
	// 	case 'dos':
	// 		$SortPolje = 'AA.MobTel'; break;
	// 	}	
	// }		

	$Query_Page = $Query_Ceo . " ORDER BY AA.ime ASC LIMIT " . $start . "," . $end;
	try {
		$CeoSkup = $dbh->prepare($Query_Ceo); $CeoSkup->execute();
		$Rezultat_query = $dbh->query($Query_Page);
	}catch (PDOException $pe){VratiGresku($pe);}
	
	foreach ($Rezultat_query as $row_Recordset) {
		$rowData["sfr"]   = $row_Recordset['sfr']; // MORA!! radi izmene
		$rowData["sfr_kor"]   = $row_Recordset['sfr_kor']; // MORA!! radi izmene
		$rowData["ime"]   = $row_Recordset['ime']; // MORA!! radi izmene
            $rowData["sfr_korIme"] = '<b>' . $row_Recordset['sfr_kor'] . '</b><span class="condenzed"> - ' . $row_Recordset['ime'] . '</span>';
		// $rowData["titIme"] = $row_Recordset['titIme'];
		
		$TabelaOdgovora[] = $rowData;
	}	
	
	$return = array(
		'success'	=> true,
		'TotalRecs' => $CeoSkup->rowCount(), // kada je u pitanju paging, onda ukupan broj rkorda, a ne broj na strani
		'podaci' 	=> $TabelaOdgovora
	);
	header('Cache-Control: no-cache, must-revalidate');
	header('content-type:application/json');
	echo json_encode($return); 
	$dbh = null;	// Closing MySQL database connection  

function SQLUpit($DatPrefix, $query){
	if($query =='[null]'){$query = '';}
			// opsti upit
			$query_Rcset = "SELECT AA.sfr, AA.sfr_kor, AA.ime  
                  FROM ". $DatPrefix . "_stanice as AA
			";
			
			// ako ima uslovnosti, dodaj WHERE npr. ($query !== "") || ($idu_stgrupa !== 0)	ID_OrgJed  Naziv
			if ( $query !== ""  ){
					$query_Rcset = $query_Rcset .	" 
					WHERE (sfr_kor LIKE '" .  $query . "%' ) || (ime LIKE '%" .  $query . "%' )";
			}	
			//  error_log($query, 0);	 
			error_log($query_Rcset, 0);	 
		
			return $query_Rcset;
	}	// kraj function SQLUpit 


?>