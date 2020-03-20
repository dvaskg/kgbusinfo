<?php
	ob_start();
	require_once '../SQL_funkcije.php';	// 
	$DirSep = DajDirSeparator();
	$StazaSQLpar = dirname(dirname(dirname(getcwd())));
	include $StazaSQLpar . $DirSep . 'Data/SQLParametri_PDO.php';	// 
	ob_end_clean();

	$TabelaOdgovora = Array(); $rowData = Array();

      $dateSada = new DateTime('now', new DateTimeZone("Europe/Belgrade")); //
      $do_dat = GetSQLValueString($dateSada->format('Y-m-d H:i:s'), "date");

      // $od_dat = new DateTime('now', new DateTimeZone("Europe/Belgrade")); //
      $od_dat = GetSQLValueString('01-01-' .$dateSada->format('Y'). ' 00:00:00', "date");

	$Query_Ceo = SQLUpit($DatPrefix, $od_dat, $do_dat);
	$Query_Page = $Query_Ceo . " ORDER BY rbr ASC";
	try {
		$CeoSkup = $dbh->prepare($Query_Ceo); $CeoSkup->execute();
		$Rezultat_query = $dbh->query($Query_Page);
	}catch (PDOException $pe){VratiGresku($pe);}
	
	foreach ($Rezultat_query as $row_Recordset) {
		$rowData["sfr"] = 	$row_Recordset['sfr']; // 
		$rowData["rbr"] = 	$row_Recordset['rbr']; // 
		$rowData["pit"] = 	$row_Recordset['pit']; // 
		$rowData["akt"] = 	$row_Recordset['akt']; // 
		$rowData["brOdgovora"] =$row_Recordset['brOdgovora']; // 
		$rowData["prosek"]  = round ($row_Recordset['prosek'], 3, PHP_ROUND_HALF_UP); // просек одговора
		// $rowData["prosek"]     = $row_Recordset['prosek']; // просек одговора
		
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
function SQLUpit($DatPrefix,  $od_dat, $do_dat){
            // opsti upit
            $query_Rcset = "SELECT  AA.*, COUNT(BB.sfr_odg) AS brOdgovora, AVG(BB.odg) prosek  
            FROM ". $DatPrefix . "_anketa as AA
            left JOIN ". $DatPrefix . "_ankodgovori as BB
            ON  AA.sfr = BB.sfr_odg and (BB.dat >= $od_dat and BB.dat <= $do_dat) 
            WHERE akt = 1";
            $query_Rcset .= " GROUP BY AA.sfr";
            // error_log($query_Rcset, 0);	// log u log na serveru

            return $query_Rcset;
}	// kraj function SQLUpit 

?>