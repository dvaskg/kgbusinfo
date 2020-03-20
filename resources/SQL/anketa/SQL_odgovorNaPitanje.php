<?php
	ob_start();
	require_once '../SQL_funkcije.php';	// 

	$DirSep = DajDirSeparator();
	$StazaSQLpar = dirname(dirname(dirname(getcwd()  ) ));
	include $StazaSQLpar . $DirSep . 'Data/SQLParametri_PDO.php';	//

	$sfr_odg = GetSQLValueString($_POST["sfr"], 	"int");  
	$oce     = GetSQLValueString($_POST["oce"], 	"double");  

      $FrazaUpita = "INSERT INTO
            ".$DatPrefix."_ankodgovori
      SET 
            sfr_odg = $sfr_odg,
            odg = $oce ";
      // error_log($FrazaUpita, 0);	// log u log na serveru
      try {$dbh -> exec($FrazaUpita); }catch (PDOException $pe){VratiGresku($pe);}	
      $return = array(
            'success' => true,	
      );
      header('Cache-Control: no-cache, must-revalidate');
      header('content-type:application/json');
      die(json_encode($return));		
?>