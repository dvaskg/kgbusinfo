<?php
	ob_start();
	require_once '../SQL_funkcije.php';	// 

	$DirSep = DajDirSeparator();
	$StazaSQLpar = dirname(dirname(dirname(getcwd()  ) ));
	include $StazaSQLpar . $DirSep . 'Data/SQLParametri_PDO.php';	//
	// long-nista ; int-setuje null; text-NULL; decimal-menja ,.; double-apostrofi; date - apostrofi; defined - vraca nesto ako je  i nije definisan

	$query  	= GetSQLValueString(intval ($_POST['query']), 'text');

	ob_end_clean();
		 
	$Query_Ceo = SQLUpit($DatPrefix, $query);

	try {
		$Rezultat_query = $dbh->query($Query_Ceo);
	}catch (PDOException $pe){VratiGresku($pe);}
	$TabelaOdgovora = Array();
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
		// 'TotalRecs' => $CeoSkup->rowCount(), // kada je u pitanju paging, onda ukupan broj rkorda, a ne broj na strani
		'podaci' 	=> $TabelaOdgovora
	);
	header('Cache-Control: no-cache, must-revalidate');
	header('content-type:application/json');
	echo json_encode($return); 
	$dbh = null;	// Closing MySQL database connection  

function SQLUpit($DatPrefix, $query){
	// if($query =='[null]'){$query = '';}
			// opsti upit
			$query_Rcset = "SELECT AA.sfr, AA.sfr_kor, AA.ime  
			FROM ". $DatPrefix . "_stanice as AA
			WHERE sfr_kor = $query";
		
			return $query_Rcset;
}	// kraj function SQLUpit 

?>