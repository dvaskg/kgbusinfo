<?php // salje sva moguća pitanja za anketu
	ob_start();
	require_once '../SQL_funkcije.php';	// 

	$DirSep = DajDirSeparator();
	$StazaSQLpar = dirname(dirname(dirname(getcwd()  ) ));
	include $StazaSQLpar . $DirSep . 'Data/SQLParametri_PDO.php';	//

	// long-nista ; int-setuje null; text-NULL; decimal-menja ,.; double-apostrofi; date - apostrofi; defined - vraca nesto ako je  i nije definisan
		
	if ( isset($_POST['start'])){GetSQLValueString($_POST['start'], "int") ;  }
	if ( isset($_POST['limit'])){$end  = GetSQLValueString($_POST['limit'], "int");  }
	if ( isset($_POST['SerchAtrib'])){$FilterTxt = $_POST['SerchAtrib'];}else{$FilterTxt = null;} 


	ob_end_clean();
	$TabelaOdgovora = Array(); $rowData = Array();

	$Query_Ceo = SQLUpit($DatPrefix, $FilterTxt);
	$Query_Page = $Query_Ceo . " ORDER BY rbr ASC";
	try {
		$CeoSkup = $dbh->prepare($Query_Ceo); $CeoSkup->execute();
		$Rezultat_query = $dbh->query($Query_Page);
	}catch (PDOException $pe){VratiGresku($pe);}
	
	foreach ($Rezultat_query as $row_Recordset) {
		$rowData["sfr"] = 	$row_Recordset['sfr']; // 
		$rowData["rbr"] = 	$row_Recordset['rbr']; // 
		$rowData["pit"] = 	$row_Recordset['pit']; // 
		
		$TabelaOdgovora[] = $rowData;
	}	
	
	$return = array(
		'success'	=> true,
		'TotalRecs' => $CeoSkup->rowCount(),	// kada je u pitanju paging, onda ukupan broj rkorda, a ne broj na strani
		'podaci' 	=> $TabelaOdgovora
	);
	
	header('Cache-Control: no-cache, must-revalidate');
	header('content-type:application/json');
	echo json_encode($return); 
	$dbh = null;	// Closing MySQL database connection  


function SQLUpit($DatPrefix, $FilterTxt){
			// opsti upit
			$query_Rcset = "SELECT  AA.*  
                  FROM ". $DatPrefix . "_anketa as AA 
                  WHERE akt = 1";

			return $query_Rcset;
	}	// kraj function SQLUpit 


?>