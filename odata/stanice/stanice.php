<?php
      // ob_start();
	require_once (__DIR__ . '../../../resources/SQL/SQL_funkcije.php');	// 

	include __DIR__ . '../../../Data/SQLParametri_PDO.php';	// 

      require_once(__DIR__ . '../../../resources/vendor/autoload.php');
      // ob_end_clean();


      // nadje početak podataka
      $query = "SELECT MAX(dan) AS maxDat , min(dan) AS minDat FROM ".$DatPrefix."_senzori AS AA
      WHERE 
      sfr_stan IS NOT NULL";
      try {$Rez = $dbh->query($query)->fetch(); }catch (PDOException $pe){VratiGresku($pe);}

      $minDat = new DateTime($Rez['minDat'], new DateTimeZone("Europe/Belgrade")); 
      $maxDat = new DateTime($Rez['maxDat'], new DateTimeZone("Europe/Belgrade")); 

      $maxDat->modify('last day of this month');
      $minDat->modify('first day of this month');
      $interval = DateInterval::createFromDateString('1 month');
      $period = new DatePeriod($minDat, $interval, $maxDat);
      foreach($period as $dt) {
          $dtMin = $dt->format( "Y-m-d" );
          $dt->modify('last day of this month');
            $stanice = dajStanice(); // array sa stanicama
            foreach ($stanice as $row_stanice) {
                  obracunajPeriod($dtMin, $dt->format( "Y-m-d" ), $row_stanice['sfr']); // min, max
            }
            produziVreme( );
      }
      exportujFajlove();
function     exportujFajlove(){
      $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
      // $spreadsheet->getProperties();

      // $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setTitle("Опис атрибута");
      $sheet->setCellValue('A1', 'ОПИС');
      $sheet->setCellValue('B1', 'Овај скуп података садржи преглед протока путника свих аутобуских стајалишта у оквиру система јавног градског превоза града Крагујевца, као и јединствено додељене шифре сваком аутобуском стајалишту на предметној линији. Уз то, овај скуп ближе одређује координате географске дужине и географске ширине сваког аутобуског стајалишта на конкретној линији јавног превоза, при чему ближе описује и назив стајалишта у систему јавног аутобуског превоза. и коначно, ради индивидуализације, скуп података даје преглед имена аутобуских стајалишта, као ближе одредиште за само стајалиште по одређеном топониму. Предметни сет података је отворила "Градска агенција за саобраћај" Крагујевац. Овај сет садржи следеће атрибуте: Mesec, Број станице, Назив станице, Lat, Lon, Улаз путника, Излаз путника, Сума.');

      $sheet->setCellValue('A2', 'Mesec');
      $sheet->setCellValue('B2', 'Mesec представља датум у месецу кад је почело бројање путника на стајаишту, за тај месец.');

      $sheet->setCellValue('A3', 'Број станице');
      $sheet->setCellValue('B3', 'Број станице је шифра стајалишта која представља јединствени идентификациони број аутобуског стајалишта додељен у оквиру система јавног градског превоза Града.');

      $sheet->setCellValue('A4', 'Назив станице');
      $sheet->setCellValue('B4', 'Назив станице  је имен аутобускog стајалишта, као ближе одредиште за само стајалиште по одређеном топониму.');

      $sheet->setCellValue('A5', 'Lat');
      $sheet->setCellValue('B5', 'Lat је ГПС географске дужине који описује координате  аутобуског стајалишта у оквиру система јавног градског превоза Града Крагујевца');

      $sheet->setCellValue('A6', 'Lon');
      $sheet->setCellValue('B6', 'Lat је ГПС географске ширине који описује координате  аутобуског стајалишта у оквиру система јавног градског превоза Града Крагујевца');

      $sheet->setCellValue('A7', 'Улаз путника');
      $sheet->setCellValue('B7', 'Улаз путника представља број путника који су ушли у аутобус на том стајалишту у току тог месеца.');

      $sheet->setCellValue('A8', 'Излаз путника');
      $sheet->setCellValue('B8', 'Излаз путника представља број путника који су изашли из аутобуса на том стајалишту у току тог месеца.');

      $sheet->setCellValue('A9', 'Сума');
      $sheet->setCellValue('B9', 'Сума  представља промет путника  на том стајалишту у току тог месеца.');
      $style = $sheet->getStyle('A1:B9');
      $style->applyFromArray(StilOpis());

      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getStyle('B1:B100')
            ->getAlignment()
            ->setWrapText(true);
      $sheet->getColumnDimension('B')->setWidth(127);


      $spreadsheet->createSheet();
      // Worksheets are in running sequence number - 0, 1, 2, etc...
      $sheet = $spreadsheet->getSheet(1);
      // Alternatively, we can get by name (after we set the title)
      //$sheet = $spreadsheet->getSheetByName('TITLE');
      $sheet->setTitle("Подаци");
      
      $sheet->setCellValueByColumnAndRow(1, 1, 'Mesec');
      $sheet->setCellValueByColumnAndRow(2, 1, 'Број станице');
      $sheet->setCellValueByColumnAndRow(3, 1, 'Назив станице');
      $sheet->setCellValueByColumnAndRow(4, 1, 'Lat');
      $sheet->setCellValueByColumnAndRow(5, 1, 'Lon');
      $sheet->setCellValueByColumnAndRow(6, 1, 'Улаз путника');
      $sheet->setCellValueByColumnAndRow(7, 1, 'Излаз путника');
      $sheet->setCellValueByColumnAndRow(8, 1, 'Сума');
      $sheet->setAutoFilter('A1:H1');
      $sheet->freezePane('A2');
      $sheet->getRowDimension('1')->setRowHeight(21);
      $style = $sheet->getStyle('A1:H1');
      $style->applyFromArray(StilZaglavlja());

      $brRecordaProtStanice = dajBrRecordaProtStanice();
      $krugova = round ($brRecordaProtStanice / 1000);
      // error_log('$krugova: ' . $krugova, 0);
      for ($x = 0; $x <= $krugova; $x++) {
            // echo "The number is: $x <br>";
            $setProtoSt = dajSetProtostanice($x * 1000);
            // error_log('$setProtoSt: '  . print_r($setProtoSt, TRUE), 0);
            upisiSheet($setProtoSt, $sheet, $x);
      } 
      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getColumnDimension('B')->setAutoSize(true);
      $sheet->getColumnDimension('C')->setAutoSize(true);
      $sheet->getColumnDimension('D')->setAutoSize(true);
      $sheet->getColumnDimension('E')->setAutoSize(true);
      $sheet->getColumnDimension('F')->setAutoSize(true);
      $sheet->getColumnDimension('G')->setAutoSize(true);
      $sheet->getColumnDimension('H')->setAutoSize(true);

      // $sheet = $spreadsheet->getSheet(0);
      $spreadsheet->setActiveSheetIndex(0); // setuje aktivan tab (0) kad otvori excel


      $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      $writer->save('data.xlsx');

      $writer = new PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
      $writer->save('data.xls');

      $writer = new PhpOffice\PhpSpreadsheet\Writer\Ods($spreadsheet);
      $writer->save('data.ods');
      
      $spreadsheet->removeSheetByIndex(0);
      
      $writer = new PhpOffice\PhpSpreadsheet\Writer\Html($spreadsheet);
      $writer->save('data.html');

      $writer = new PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
      $writer->save('data.csv');
      
}
function obracunajPeriod($datMin, $datMax, $sfr_stan){
      global $DatPrefix; global $dbh;
      $datMin_esc = GetSQLValueString($datMin, "date");
      $datMax_esc = GetSQLValueString($datMax, "date");
      $sfr_stan_esc = GetSQLValueString($sfr_stan, "int");

      $query = "SELECT sum(ula)+sum(ula_vanStan) AS ulaPut , sum(izl)+sum(izl_vanStan) AS izlPut 
      FROM ".$DatPrefix."_senzori AS AA
      WHERE 
      sfr_stan = $sfr_stan_esc AND dan >= $datMin_esc AND dan <= $datMax_esc";
      // error_log('$query: ' . $query, 0);

      try {$Rez = $dbh->query($query)->fetch(); }catch (PDOException $pe){VratiGresku($pe);}
      // error_log('$Rez ulaPut: ' . $datMin .' == '. $Rez['ulaPut'], 0);
      // error_log('$Rez izlPut: ' . $datMax .' == '. $Rez['izlPut'], 0);
       upisi_protstanice($Rez, $sfr_stan_esc,  $datMin_esc, $datMax_esc);
}
function dajStanice(){
      global $DatPrefix; global $dbh;
      $query = "SELECT sfr
      FROM ".$DatPrefix."_stanice AS AA";
      try {$Rezultat_query = $dbh->query($query);}catch (PDOException $pe){VratiGresku($pe);}
      return ($Rezultat_query);
}
function upisi_protstanice ($Rez, $sfr_stan_esc,  $datMin_esc, $datMax_esc){
      global $DatPrefix; global $dbh;
      $ula_esc = GetSQLValueString($Rez['ulaPut'], "int");
      $izl_esc = GetSQLValueString($Rez['izlPut'], "int");
      $sum_esc = GetSQLValueString(($Rez['ulaPut'] + $Rez['izlPut']), "int");
      // error_log('$Rez ula_esc: ' . $ula_esc .' == '. $izl_esc .' == '. $sum_esc, 0);
      $Fraza = "INSERT INTO ".$DatPrefix."_protstanice
      SET 
            mes = $datMin_esc,
            sfr_stan = $sfr_stan_esc,
            ula = $ula_esc,
            izl = $izl_esc,
            sum = $sum_esc
      ON DUPLICATE KEY UPDATE  
            ula = $ula_esc, izl = $izl_esc, sum = $sum_esc
      ";
      try {$dbh -> exec($Fraza); }catch (PDOException $pe){VratiGresku($pe);}

}
function dajBrRecordaProtStanice(){
      global $DatPrefix; global $dbh;
      $query = "SELECT count(mes) AS numRecProtStan 
      FROM ".$DatPrefix."_protstanice";
      // error_log('$query: ' . $query, 0);

      try {$Rez = $dbh->query($query)->fetch(); }catch (PDOException $pe){VratiGresku($pe);}
      return($Rez['numRecProtStan']);
}
function dajSetProtostanice($LIMIT){
      global $DatPrefix; global $dbh;
      $query = "SELECT AA.*, BB.ime, BB.Lat, BB.Lon
      FROM ".$DatPrefix."_protstanice AS AA
      LEFT JOIN ".$DatPrefix."_stanice as BB
      ON  AA.sfr_stan = BB.sfr 
      
      ORDER BY mes ASC LIMIT $LIMIT, 1000";
      try {$Rezultat_query = $dbh->query($query);}catch (PDOException $pe){VratiGresku($pe);}
      return ($Rezultat_query);
}
function upisiSheet($setProtoSt, $sheet, $x){
            $xx = 2; // ako je početak, idi ispod zaglavlja
      foreach ($setProtoSt as $rezultat) {
            $brReda =  ($x * 1000) + $xx;
            $sheet->setCellValueByColumnAndRow(1, $brReda, $rezultat['mes']);
            $sheet->setCellValueByColumnAndRow(2, $brReda, $rezultat['sfr_stan']);
            $sheet->setCellValueByColumnAndRow(3, $brReda, $rezultat['ime']);

            $sheet->setCellValueByColumnAndRow(4, $brReda, $rezultat['Lat']);
            $sheet->setCellValueByColumnAndRow(5, $brReda, $rezultat['Lon']);

            $sheet->setCellValueByColumnAndRow(6, $brReda, $rezultat['ula']);
            $sheet->setCellValueByColumnAndRow(7, $brReda, $rezultat['izl']);
            $sheet->setCellValueByColumnAndRow(8, $brReda, $rezultat['sum']);

            $xx += 1;
      }
}
function    StilZaglavlja(){
      $styleSet = [
            // FONT
            'font' => [
            //   'bold' => true,
            //   'italic' => true,
            //   'underline' => true,
            //   'strikethrough' => true,
              'color' => ['argb' => 'FFFFFFFF'], // bela slova
            //   'name' => "Cooper Hewitt",
              'size' => 12
            ],
          
            // ALIGNMENT
            'alignment' => [
              'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
              // \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
              // \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
              'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
              // \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
              // \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
          
            // BORDER
            'borders' => [
              'top' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FFFF0000']
              ],
              'bottom' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF00FF00']
              ],
              'left' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF0000FF']
              ],
              'right' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF0000FF']
              ]
              /* ALTERNATIVELY, THIS WILL SET ALL
              'outline' => [
                  'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                  'color' => ['argb' => 'FFFF0000']
              ]*/
            ],
          
            // FILL
            'fill' => [
              // SOLID FILL
              'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
              'color' => ['argb' => 'FF0000FF'] // boja ćelije - tplava
          
              /*  GRADIENT FILL
              'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
              'rotation' => 90,
              'startColor' => [
                  'argb' => 'FF000000',
              ],
              'endColor' => [
                  'argb' => 'FFFFFFFF',
              ]*/
            ]
      ];
      return ($styleSet);
}
function    StilOpis(){
      $styleSet = [
            // 'wrapText' =>true,
            'alignment' => [
              'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
              // \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
              // \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
              'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
              // \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
              // \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
          
            // // BORDER
            'borders' => [
                  'allBorders' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '00000000']
                  )

            ],
      ];
      return ($styleSet);
}

?>