<?php
      // ob_start();
	require_once (__DIR__ . '../../../resources/SQL/SQL_funkcije.php');	// 
	include __DIR__ . '../../../Data/SQLParametri_PDO.php';	// 

      require_once(__DIR__ . '../../../resources/vendor/autoload.php');
      prvTab(); // kreira prvi tab
      $linije = dajLinije(); // array sa stanicama
      foreach ($linije as $row_linije) {
            ostaliTabovi($row_linije['ozn'], $row_linije['sfr']);
      }
      exportFiles();
      exportCsv();
function     ostaliTabovi($imeLinije, $sfr_lin){      
      global $spreadsheet;
      $spreadsheet->createSheet();
      $sheet = $spreadsheet->getSheet($spreadsheet->getSheetCount()-1);
      $sheet->setTitle($imeLinije);
      
      $sheet->setCellValueByColumnAndRow(1, 1, 'Линија');
      $sheet->setCellValueByColumnAndRow(2, 1, 'Смер');
      $sheet->setCellValueByColumnAndRow(3, 1, 'Правац');
      $sheet->setCellValueByColumnAndRow(4, 1, 'Редослед');
      $sheet->setCellValueByColumnAndRow(5, 1, 'Шифра');
      $sheet->setCellValueByColumnAndRow(6, 1, 'ГПС_координате (географска ширина и дужина)_стајалишта');
      $sheet->setCellValueByColumnAndRow(7, 1, 'Наткривено_ стајалиште');
      $sheet->setCellValueByColumnAndRow(8, 1, 'Постоји_приступ_за_особе_са_ инвалидитетом');
      $sheet->setCellValueByColumnAndRow(9, 1, 'НАЗИВ СТАЈАЛИШТА ближе одредиште');

      $sheet->setAutoFilter('A1:I1');
      $sheet->freezePane('A2');
      $sheet->getRowDimension('1')->setRowHeight(21);
      $style = $sheet->getStyle('A1:I1');
      $style->applyFromArray(StilZaglavlja());

      $xx = 2; // ako je početak, idi ispod zaglavlja
      $stavkeLinije = dajStavkeLinije($sfr_lin); // array sa stavkama linije
      foreach ($stavkeLinije as $row_stavkaLinije) {
            $brReda =  $xx;
            $sheet->setCellValueByColumnAndRow(1, $brReda, $row_stavkaLinije['ozn']);
            $sheet->setCellValueByColumnAndRow(2, $brReda, $row_stavkaLinije['smer']);
            $sheet->setCellValueByColumnAndRow(3, $brReda, $row_stavkaLinije['imeSmer']);
            $sheet->setCellValueByColumnAndRow(4, $brReda, $row_stavkaLinije['rbr']);
            $sheet->setCellValueByColumnAndRow(5, $brReda, $row_stavkaLinije['sfr_kor']);
            $sheet->setCellValueByColumnAndRow(6, $brReda, $row_stavkaLinije['Lat'] .','. $row_stavkaLinije['Lon']);
            // -- preskacu se 7 i 8
            $sheet->setCellValueByColumnAndRow(9, $brReda, $row_stavkaLinije['imeStan']);

            $xx += 1;
      }

      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getColumnDimension('B')->setAutoSize(true);
      $sheet->getColumnDimension('C')->setAutoSize(true);
      $sheet->getColumnDimension('D')->setAutoSize(true);
      $sheet->getColumnDimension('E')->setAutoSize(true);
      $sheet->getColumnDimension('F')->setAutoSize(true);
      $sheet->getColumnDimension('G')->setAutoSize(true);
      $sheet->getColumnDimension('H')->setAutoSize(true);
      $sheet->getColumnDimension('I')->setAutoSize(true);
}
function     prvTab(){
      global $spreadsheet;
      $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
      // $spreadsheet->getProperties();

      // $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setTitle("Опис атрибута");

      $sheet->setCellValue('A1', 'ОПИС');
      $sheet->setCellValue('B1', 'Овај скуп података садржи целокупни преглед свих аутобуских линија у оквиру система јавног градског превоза града Крагујевца, као и јединствено додељене шифре сваком аутобуском стајалишту на предметној линији. Уз то, овај скуп ближе одређује координате географске дужине и географске ширине сваког аутобуског стајалишта на конкретној линији јавног превоза, пре чему ближе описује и улицу и број у коме се свако од стајалишта у систему јавног аутобуског превоза и налази. Предметним сетом се ближе описује да ли је конкретна линија градског превоза двосмерна или кружна. Врло важан садржај предметног скупа јесу и информације да ли су аутобуска стајалишта на линијама наткривена или не, као и да ли аутобуска стајалишта имају обезбеђен приступ особама са инвалидитетом. Коначно, ради индивидуализације, скуп података даје преглед имена аутобуских стајалишта, као ближе одредиште за само стајалиште по одређеном топониму. Предметни сет података је отворила "Градска агенција за саобраћај" Крагујевац. Овај сет садржи следеће атрибуте: линија, смер, редослед, шифра, ГПС координате, наткривено стајалиште, приступ за особе са инвалидитетом, назив стајалишта.');

      $sheet->setCellValue('A2', 'ЛИНИЈА');
      $sheet->setCellValue('B2', 'Линија представља јединствену нумеричку ознаку правца кретања аутобуса у мрежи јавног градског аутобуског превоза Града.');

      $sheet->setCellValue('A3', 'СМЕР');
      $sheet->setCellValue('B3', 'Смер као атрибут описује да ли је једна аутобуска линија двосмерна или кружна.  Користе се ознаке 0 или 1 да укажу да ли се аутобус у оквиру линије креће двосмерно или кружно.');

      $sheet->setCellValue('A4', 'ПРАВАЦ');
      $sheet->setCellValue('B4', 'Правац као атрибут додатно текстуално описује линију кретања градског аутобуског превоза.');

      $sheet->setCellValue('A5', 'РЕДОСЛЕД');
      $sheet->setCellValue('B5', 'Редослед описује по растућем низу редне бројеве аутобуских стајалишта у једном смеру кретања аутобуса.');

      $sheet->setCellValue('A6', 'ШИФРА');
      $sheet->setCellValue('B6', 'Шифра стајалишта представља јединствени идентификациони број аутобуског стајалишта додељен у оквиру система јавног градског превоза Града.');

      $sheet->setCellValue('A7', 'ГПС_КООРДИНАТЕ');
      $sheet->setCellValue('B7', 'ГПС описује координате географске дужине и ширине аутобуског стајалишта у оквиру система јавног градског превоза Града Крагујевца');

      $sheet->setCellValue('A8', 'НАТКРИВЕНО_СТАЈАЛИШТЕ');
      $sheet->setCellValue('B8', 'Наткривено стајалиште указује да ли постоји нека врста заштите за путнике од утицаја временских прилика на конкретном аутобуском стајалишту.');

      $sheet->setCellValue('A9', 'ПРИСТУП_ЗА _ОСОБЕ_СА_ИНВАЛИДИТЕТОМ');
      $sheet->setCellValue('B9', 'Овај атрибут описује да ли на конкретном аутобуском стајалишту постоје услови за улазак инвалида у аутобус, било због тога што је тротоар довољно низак или зато што је аутобус нископодни. Пре свега се односи на приступ аутобусу у инвалидским колицима.');

      $sheet->setCellValue('A10', 'НАЗИВ_СТАЈАЛИШТА');
      $sheet->setCellValue('B10', 'Назив стајалишта представља јединствено име одређено аутобуском стајалишту у оквиру система јавног градског превоза Града Крагујевца. Истовремено представља и ближу референцу за аутобуско стајалиште по одређеном топониму.');




      $style = $sheet->getStyle('A1:B10');
      $style->applyFromArray(StilOpis());

      $sheet->getColumnDimension('A')->setAutoSize(true);
      $sheet->getStyle('B1:B100')
            ->getAlignment()
            ->setWrapText(true);
      $sheet->getColumnDimension('B')->setWidth(127);
}
function dajLinije(){
      global $DatPrefix; global $dbh;
      $query = "SELECT ozn, sfr
      FROM ".$DatPrefix."_linija AS AA
      ORDER BY ozn_num ASC";
      try {$Rezultat_query = $dbh->query($query);}catch (PDOException $pe){VratiGresku($pe);}
      return ($Rezultat_query);
}
function dajStavkeLinije($sfr_lin){
      global $DatPrefix; global $dbh;
      $dateSada = new DateTime('now', new DateTimeZone("Europe/Belgrade")); // od TIMEDATE  bez toga, vraća utc
      $dan     = GetSQLValueString($dateSada->format('Y-m-d'), "date");

      if($sfr_lin){
            $ogrLinija = " AND AA.sfr_lin = $sfr_lin  ";
      }

      $query = "SELECT AA.rbr,
            BB.sfr_kor, BB.Lat, BB.Lon, BB.ime AS imeStan,
            CC.smer, CC.ime AS imeSmer,
            DD.ozn 
            FROM ".$DatPrefix."_rute AS AA
            LEFT JOIN ".$DatPrefix."_stanice as BB
            ON  AA.sfr_stanice = BB.sfr 
            LEFT JOIN ".$DatPrefix."_smer as CC
            ON  AA.sfr_smer = CC.sfr 
            LEFT JOIN ".$DatPrefix."_linija as DD
            ON  AA.sfr_lin = DD.sfr 
        
            WHERE sfr_promene = 
            (SELECT sfr FROM ".$DatPrefix."_rutepromene as CC
                  WHERE CC.dat <= $dan AND CC.sfr_lin = $sfr_lin AND CC.sfr_smer = AA.sfr_smer
                  ORDER BY CC.dat desc
            LIMIT 1)  ". $ogrLinija ."
            ORDER BY AA.sfr_smer ASC, AA.rbr ASC
            ";
      
      //   error_log('$query: ' . $query, 0);	
      try {$Rezultat_query = $dbh->query($query); }catch (PDOException $pe){VratiGresku($pe);}
      return ($Rezultat_query);
}
function    StilZaglavlja(){
      $styleSet = [
            // FONT
            'font' => [
              'color' => ['argb' => 'FFFFFFFF'], // bela slova
              'size' => 12
            ],
          
            // ALIGNMENT
            'alignment' => [
              'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
              'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
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
              'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP
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
function exportFiles(){
      global $spreadsheet;

      $spreadsheet->setActiveSheetIndex(0); // setuje aktivan tab (0) kad otvori excel

      $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      $writer->save('data.xlsx');

      $writer = new PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
      $writer->save('data.xls');

      $writer = new PhpOffice\PhpSpreadsheet\Writer\Ods($spreadsheet);
      $writer->save('data.ods');
      

      $writer = new PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
      $writer->save('data.csv');

}
function exportCsv() {
      global $spreadsheet;
      $allData = Array();
      $sheetCount = $spreadsheet->getSheetCount();
      for ($i = 1; $i < $sheetCount; $i++) {
            $sheet = $spreadsheet->getSheet($i);
            if($i == 1){
                  $pocetnaKolona = 'A1:';
            }else{
                  $pocetnaKolona = 'A2:';
            }
            $highestRow = $sheet->getHighestRow(); // e.g. 10
            $highestColumn = $sheet->getHighestColumn(); // e.g 'F'
            $sheetData = $sheet->rangeToArray($pocetnaKolona . $highestColumn.$highestRow, 
                  '',        // Value that should be returned for empty cells
                  TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
                  TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
                  TRUE         // Should the array be indexed by cell row and cell column
            );
            $allData = array_merge($allData, $sheetData);
      }

      $fp = fopen('data.csv', 'w');
      $i = 0;
      foreach ($allData as $fields) {
          fputcsv($fp, array_values($fields), ',', '"');
          $i++;
      }
      fclose($fp);
     
      $html = "<table>";
      foreach($allData as $row) {
          $html .= "<tr>";
          foreach ($row as $cell) {
              $html .= "<td>" . $cell . "</td>";
          }
          $html .= "</tr>";
      }
      $html .= "</table>";
      file_put_contents('data.html', $html);
}
?>