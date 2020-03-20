<?php
	ob_start();
	require_once '../SQL_funkcije.php';	// 
	$DirSep = DajDirSeparator();
	$StazaSQLpar = dirname(dirname(dirname(getcwd())));
	include $StazaSQLpar . $DirSep . 'Data/SQLParametri_PDO.php';	// 
	ob_end_clean();

	$TabelaOdgovora = Array(); $rowData = Array();

      // $dateSada = new DateTime('now', new DateTimeZone("Europe/Belgrade")); //
      $sfr_stan = GetSQLValueString($_POST['sfr_stan'],  	"int");


	$Query_Ceo = SQLUpit($sfr_stan, $DatPrefix);
	$Query_Page = $Query_Ceo . " ORDER BY oceDol ASC";
	try {
		$CeoSkup = $dbh->prepare($Query_Ceo); $CeoSkup->execute();
		$Rezultat_query = $dbh->query($Query_Page);
	}catch (PDOException $pe){VratiGresku($pe);}
	
	foreach ($Rezultat_query as $row_Recordset) {
		$rowData["ozn"] 		= 	$row_Recordset['ozn']; // 
		$rowData["oceDol"] 	= 	$row_Recordset['oceDol']; // 
		$rowData["datInfo"] 	= 	$row_Recordset['datInfo']; // 
		$rowData["ki"] 		= 	$row_Recordset['ki']; // 
		
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
function SQLUpit($sfr_stan, $DatPrefix){
            // opsti upit
            $query_Rcset = "SELECT  AA.*, BB.ozn,
		DD.stanje, DD.brMesta, DD.sfr_stan_zad, DD.ki, DD.sfr_kor
            FROM ". $DatPrefix . "_displej as AA
            left JOIN ". $DatPrefix . "_linija as BB
		ON  AA.sfr_lin = BB.sfr 

		LEFT JOIN ".$DatPrefix."_autobusi as DD 
		ON AA.sfr_auto = DD.sfr 

            WHERE sfr_stan = $sfr_stan";

            return $query_Rcset;
}	// kraj function SQLUpit 

?>