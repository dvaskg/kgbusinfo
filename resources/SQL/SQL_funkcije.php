<?php 
	$еrrLang = Array();
	$еrrLang['GreskaNaslov'] = 'Грешка у SQL измени података у бази'; // Greška u SQL izmeni podataka u bazi
	$еrrLang['GreskaTxt'] = 'Грешка је евидентирана на серверу<br/>администратори су обавештени <br/>да нешто није у реду.'; // Greška je evidentirana na severu<br/>administratori su obavešteni <br/>da nešto nije u redu.
	$еrrLang['GreskaRelNaslov'] = 'Ова операција није могућа';
	$еrrLang['GreskaRelTxt'] = 'Потребно је да уколоните податке<br/> који су логички повезани са овим појмом, <br/>да би ова операција<br/> била изводљива'; // Potrebno je da uklonite podatke<br/> koji su logički povezani sa ovim pojmom, <br/>da bi ova operacija<br/> bila izvodljiva
	$еrrLang['GreskaDupNaslov'] = 'дупли унос података'; // dupli unos podaka
	$еrrLang['GreskaDupTxt'] = 'Такав податак у бази већ постоји<br/>Овакав унос би значио дупли унос података'; // Takav podatak u bazi već postoji<br/>Ovakav unos bi značio dupli unos podataka

function VratiGresku($pe){ // pretvara datum iz forme u SQL DATUM (obrnuta godina i datum)
	$GreskaNaslov = 'Грешка у SQL измени података у бази';
	$GreskaTxt = 'Грешка је евидентирана на серверу<br/>администратори су обавештени <br/>да нешто није у реду.';

	$GreskaRelNaslov = 'Ова операција није могућа';
	$GreskaRelTxt = 'Потребно је да уколоните податке<br/> који су логички повезани са овим појмом, <br/>да би ова операција<br/> била изводљива';

	$GreskaDupNaslov = 'дупли унос података'; // dupli unos podaka
	$GreskaDupTxt = 'Такав податак у бази већ постоји<br/>Овакав унос би значио дупли унос података';
	
	 error_log('$pe: ' . $pe, 0);

	
	$Upit = $pe->getTrace()[0]['args'][0];
	$greska = $pe->getMessage();
	if(strpos($greska, 'violation: 1451')){  // Integrity constraint violation
		$return = array('success' => false, 'naslov' => $GreskaRelNaslov, 'opis' => $GreskaRelTxt);
	} elseif (strpos($greska, 'violation: 1062' )) {	// 'Duplicate entry'		
		$return = array('success' => false, 'naslov' => $GreskaDupNaslov, 'opis' => $GreskaDupTxt);
		// error_log($pe, 0);
		error_log('$pe-pokušan dupli unos: '  . print_r($pe->getTrace()[0]['file'], TRUE), 0);
		error_log('$pe-pokušan dupli unos: '  . print_r($pe->getTrace()[0]['args'], TRUE), 0);
	}else{
		// ==> ostaje log na serveru
		error_log('File: ' . $pe->getFile(), 0); 
		error_log('getLine: ' . $pe->getLine(), 0); 
		error_log('getCode: ' . $pe->getCode(), 0); 
		error_log('getMessage: ' . $pe->getMessage(), 0); 
		error_log('Upit: ' . $Upit, 0); // log u log na serveru
		$return = array(
			'success' => false, 
			'naslov'  => $GreskaNaslov,	
			'opis' => $GreskaTxt
		);
	}
	die(json_encode($return));		
}		 

function dtform($date, $delimS){ // pretvara datum iz forme u SQL DATUM (obrnuta godina i datum)
		$dateFinal = '';
		$dateFinal_exp = explode($delimS,$date);
		$dateFinal = $dateFinal_exp[2].$delimS.$dateFinal_exp[1].$delimS.$dateFinal_exp[0];
		return $dateFinal;
}		 
	 
function Procenat( $Broj, $Ukupno) {
		if ($Ukupno == 0) {return 0 . ' %';}
		$percent = $Broj/$Ukupno;
		$percent_friendly = number_format( $percent * 100, 0 ) . ' %'; // change 2 to # of decimals
		return $percent_friendly;
}

function numberFormat($num)	{
		return preg_replace("/(?<=\d)(?=(\d{3})+(?!\d))/",",",$num);
}

function DajDirSeparator(){	
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			//echo 'This is a server using Windows!';
			return '\\';
		} else {
			//echo 'This is a server not using Windows!';
			return '/';
		}
}	// kraj function DajdirSep
		

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {

		$theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
		switch ($theType) {
			case "text":	
				$theValue = ltrim(  rtrim($theValue)  );
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;   
	
			case "textBezTrima":	
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;    
			case "long":	// ne dira ga
				
			case "int":	//  daje NULL umeto null
				$theValue = ($theValue != "") ? intval($theValue) : 'NULL';	// 
				break;
			case "double":	// apostrofi
				// ||  $theValue != 0
				$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
				break;
			case "decimal":	// decimalno - menja zarez u tacku + apostrofi
					// ||  $theValue != 0
				//  error_log($theValue, 0);	// log u log na serveru

					$theValue = str_replace (',', '.', $theValue);
					// error_log($theValue, 0);	// log u log na serveru
					$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
					// error_log($theValue, 0);	// log u log na serveru
				break;
			case "date":	// apostrofi
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "dateSR":	// datum u srpskom obliku dan/mes/god dd/mm/YYYY
				if($theValue == ""){
					$theValue = "NULL";
				}else{
					$datObj = date_create_from_format('d/m/Y', $theValue);
					// error_log('$datObj: '  . print_r($datObj, TRUE), 0);	
					$theValue = "'" . $datObj->format('Y-m-d') . "'";
					// error_log('$theValue: ' . $theValue, 0);	
				}
				break;
			case "defined":	// prazan char
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
		return $theValue;
}
function DajDanUn($Ulaz){
	switch($Ulaz){
	case 1:
		return 'Понедељак'; break;	
	case 2:
		return 'Уторак'; break;		
	case 3:
		return 'Среда'; break;	
	case 4:
		return 'Четвртак'; break;		
	case 5:
		return 'Петак'; break;		
	case 6:
		return 'Субота'; break;		
	case 7:
		return 'Недеља'; break;	
	}		
}
		
		
function FarbajNiz($UlaStr, $TrazeniStr){
	$Lok_Sors 	= mb_strtoupper($UlaStr, "utf-8");
	$Lok_Trazim = mb_strtoupper($TrazeniStr, "utf-8");
	$Lok_Pozicija = stripos($Lok_Sors, $Lok_Trazim);
	$Lok_Duzina = strlen($TrazeniStr);
	if ($Lok_Pozicija !== false) {
		return substr($UlaStr, 0, $Lok_Pozicija) . '<span style="color: #E10000;">' . substr($UlaStr, $Lok_Pozicija, $Lok_Duzina) . '</span>' . substr($UlaStr, $Lok_Pozicija + $Lok_Duzina );
	}else{
		return $UlaStr;
	}	
}	// kraj function FarbajNiz 


	/**
	 * This function checks if the table exists in the passed PDO database connection
	 * @param PDO $pdo - connection to PDO database table
	 * @param type $tableName 
	 * @return boolean - true if table was found, false if not
	 */
function tableExists(PDO $pdo, $tableName) {
	$mrSql = "SHOW TABLES LIKE :table_name";
	$mrStmt = $pdo->prepare($mrSql);
	//protect from injection attacks
	$mrStmt->bindParam(":table_name", $tableName, PDO::PARAM_STR);

	$sqlResult = $mrStmt->execute();
	if ($sqlResult) {
		$row = $mrStmt->fetch(PDO::FETCH_NUM);
		if ($row[0]) {
			//table was found
			return true;
		} else {
			//table was not found
			return false;
		}
	} else {
		//some PDO error occurred
		echo("Could not check if table exists, Error: ".var_export($pdo->errorInfo(), true));
		return false;
	}
}	  
function time_elapsed_A($secs){
	if ($secs <= 0){return 0;}
	$bit = array(
		'y' => $secs / 31556926 % 12,
		'w' => $secs / 604800 % 52,
		'd' => $secs / 86400 % 7,
		'h' => $secs / 3600 % 24,
		'm' => $secs / 60 % 60,
		's' => $secs % 60
		);
		
	foreach($bit as $k => $v)
		if($v > 0)$ret[] = $v . $k;
		
	return join(' ', $ret);
}
function sanitSMS($string) { // sanitanizuje txt SMS poruke, izbaci cirilicu i čđš
	$trans = array(
		'Š' => "s",  'š' => "s",// š =-	(izlazi = a treba)
		'Đ' => "Dj", 'đ' => "dj",// š =-	(izlazi = a treba)
		'Č' => "c",  'č' => "c",// š =-	(izlazi = a treba)
		'Ć' => "c",  'ć' => "c",// š =-	(izlazi = a treba)
		'Ž' => "z",  'ž' => "z",// š =-	(izlazi = a treba)
	);
	$string = strtr($string, $trans);
	return utf8_decode($string);
}
function sanitSpace($string) { // sanitanizuje txt izbaci prazna mesta
	$trans = array(
		' ' => ""	// (izlazi = a treba)
	);
	$string = strtr($string, $trans);
	return utf8_decode($string);
}

function IzLatuCir ($string) {
	$table = array(
		// А Б В Г Д Ђ Е Ж З И Ј К Л Љ М Н Њ О П Р С Т Ђ У Ф Х Ц Ч Џ Ш
	'A'=>'А', 'B'=>'Б', 'V'=>'В', 'G'=>'Г', 'DJ'=>'Ђ','Dj'=>'Ђ', 'Dž'=>'Џ', 'DŽ'=>'Џ', 'D'=>'Д', 'E'=>'Е', 'Ž'=>'Ж', 'Z'=>'З', 'I'=>'И', 
	'J'=>'Ј', 'K'=>'К', 'LJ'=>'Љ', 'Lj'=>'Љ', 'L'=>'Л', 'M'=>'М', 'NJ'=>'Њ', 'Nj'=>'Њ', 'N'=>'Н', 'O'=>'О', 'P'=>'П', 'R'=>'Р', 
	'S'=>'С', 'T'=>'Т', 'Ć'=>'Ћ', 'U'=>'У', 'F'=>'Ф', 'H'=>'Х', 'C'=>'Ц', 'Č'=>'Ч', 'Š'=>'Ш',
	// а б в г д ђ е ж з и ј к л љ м н њ о п р с т ђ у ф х ц ч џ ш
	'a'=>'а', 'b'=>'б', 'v'=>'в', 'g'=>'г', 'd'=>'д', 'dj'=>'ђ', 'e'=>'е', 'ž'=>'ж', 'z'=>'з', 'i'=>'и', 
	'j'=>'ј', 'k'=>'к', 'l'=>'л', 'lj'=>'љ', 'm'=>'м', 'n'=>'н', 'nj'=>'њ', 'o'=>'о', 'p'=>'п', 'r'=>'р', 
	's'=>'с', 't'=>'т', 'ć'=>'ћ', 'u'=>'у', 'f'=>'ф', 'h'=>'х', 'c'=>'ц', 'č'=>'ч', 'dž'=>'џ', 'š'=>'ш',
	);

	return strtr($string, $table);
}
function IzCiruEng ($string) {
	return str_replace(array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','љ','м','н','њ','о','п','р','с','т','у','ф','х','ц','ч','џ','ш','щ','ъ','ы','ь','э','ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','Љ','М','Н','Њ','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Џ','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я'),
	array('a','b','v','g','d','e','e','z','z','i','j','k','l','lj','m','n','nj','o','p','r','s','t','u','f','h','c','c','dz','s','s','i','j','j','e','ju','ja','A','B','V','G','D','E','E','Z','Z','I','J','K','L','Lj','M','N','Nj','O','P','R','S','T','U','F','H','C','C','Dz','S','S','I','J','J','E','Ju','Ja'), $string);
}

function getRealUserIp() {
	$ip = '';
	if ($_SERVER['HTTP_CLIENT_IP'])
	    $ip = $_SERVER['HTTP_CLIENT_IP'];
	else if($_SERVER['HTTP_X_FORWARDED_FOR'])
	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if($_SERVER['HTTP_X_FORWARDED'])
	    $ip = $_SERVER['HTTP_X_FORWARDED'];
	else if($_SERVER['HTTP_FORWARDED_FOR'])
	    $ip = $_SERVER['HTTP_FORWARDED_FOR'];
	else if($_SERVER['HTTP_FORWARDED'])
	    $ip = $_SERVER['HTTP_FORWARDED'];
	else if($_SERVER['REMOTE_ADDR'])
	    $ip = $_SERVER['REMOTE_ADDR'];
	else
	    $ip = 'none';
    
	return $ip;
  }	  

  class CsvIterator implements Iterator
  {
	const ROW_SIZE = 4096;
	/**
	 * The pointer to the cvs file.
	 * @var resource
	 * @access private
	 */
	private $filePointer = null;
	/**
	 * The current element, which will
	 * be returned on each iteration.
	 * @var array
	 * @access private
	 */
	private $currentElement = null;
	/**
	 * The row counter.
	 * @var int
	 * @access private
	 */
	private $rowCounter = null;
	/**
	 * The delimiter for the csv file.
	 * @var str
	 * @access private
	 */
	private $delimiter = '"';
  
	/**
	 * This is the constructor.It try to open the csv file.The method throws an exception
	 * on failure.
	 *
	 * @access public
	 * @param str $file The csv file.
	 * @param str $delimiter The delimiter.
	 *
	 * @throws Exception
	 */
	public function __construct($file, $delimiter=';')
	{
	    try {
		  $this->filePointer = fopen($file, 'r');
		  $this->delimiter = $delimiter;
	    }
	    catch (Exception $e) {
		  throw new Exception('The file "'.$file.'" cannot be read.');
	    }
	}
  
	/**
	 * This method resets the file pointer.
	 *
	 * @access public
	 */
	public function rewind() {
	    $this->rowCounter = 0;
	    rewind($this->filePointer);
	}
  
	/**
	 * This method returns the current csv row as a 2 dimensional array
	 *
	 * @access public
	 * @return array The current csv row as a 2 dimensional array
	 */
	public function current() {
	    $this->currentElement = fgetcsv($this->filePointer, self::ROW_SIZE, $this->delimiter);
	    $this->rowCounter++;
	    return $this->currentElement;
	}
  
	/**
	 * This method returns the current row number.
	 *
	 * @access public
	 * @return int The current row number
	 */
	public function key() {
	    return $this->rowCounter;
	}
  
	/**
	 * This method checks if the end of file is reached.
	 *
	 * @access public
	 * @return boolean Returns true on EOF reached, false otherwise.
	 */
	public function next() {
	    return !feof($this->filePointer);
	}
  
	/**
	 * This method checks if the next row is a valid row.
	 *
	 * @access public
	 * @return boolean If the next row is a valid row.
	 */
	public function valid() {
	    if (!$this->next()) {
		  fclose($this->filePointer);
		  return false;
	    }
	    return true;
	}
  }
  function match_all($needles, $haystack){ // vrača true ako nadje iglu u senu
	if(empty($needles)){
	    return false;
	}
  
	foreach($needles as $needle) {
	    if (mb_strpos($haystack, $needle) == true) {
		  return true;
	    }
	}
	return false;
}
function searchThroughArray($search, $lists){
      try{
          foreach ($lists as $key => $value) {
              if(is_array($value)){
                  array_walk_recursive($value, function($v, $k) use($search ,$key,$value,&$val){
                      if(strpos($v, $search) !== false )  $val[$key]=$value;
                  });
          }else{
                  if(strpos($value, $search) !== false )  $val[$key]=$value;
              }

          }
          return $val;

      }catch (Exception $e) {
          return false;
      }
  }
  function downloadDistantFile($url, $dest){
	$options = array(
		CURLOPT_FILE => is_resource($dest) ? $dest : fopen($dest, 'w'),
      	CURLOPT_FOLLOWLOCATION => true,
      	CURLOPT_URL => $url,
      	CURLOPT_FAILONERROR => true, // HTTP code > 400 will throw curl error
    	);
	$ch = curl_init();
	curl_setopt_array($ch, $options);
	$return = curl_exec($ch);
	if ($return === false){
		return curl_error($ch);
	} else	{
		return true;
	}
}
function produziVreme( ){ // produzava vreme rada
      $seconds_remaining_until_termination = ini_get('max_execution_time') === "0" ? null : ((int)ini_get('max_execution_time'))-(microtime(true)-$_SERVER['REQUEST_TIME_FLOAT']);
      if($seconds_remaining_until_termination < 10){ set_time_limit ( 17 ); }      
}

?>