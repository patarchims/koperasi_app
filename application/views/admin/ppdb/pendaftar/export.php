<?php
$excel->getProperties()->setCreator($identitas['nama'])
  ->setLastModifiedBy($identitas['nama'])
  ->setTitle("PPDB")
  ->setSubject("PENDAFTAR")
  ->setDescription("Export Data Pedaftar")
  ->setKeywords("pendaftar");

$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PENDAFTAR PPDB"); // Set kolom A1 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A1:L1'); // Set Merge Cell pada kolom A1 sampai E1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14); // Set font size 15 untuk kolom A1
// Set text center untuk kolom A1

$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$excel->setActiveSheetIndex(0)->setCellValue('A2', $identitas['nama']); // Set kolom A1 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A2:L2'); // Set Merge Cell pada kolom A1 sampai E1
$excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14); // Set font size 15 untuk kolom A1
// Set text center untuk kolom A1

$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$excel->setActiveSheetIndex(0)->setCellValue('A3', "TAHUN " . $tahun); // Set kolom A1 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A3:L3'); // Set Merge Cell pada kolom A1 sampai E1
$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(14); // Set font size 15 untuk kolom A1
// Set text center untuk kolom A1
$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$excel->setActiveSheetIndex(0)->setCellValue('A5', "NO");
$excel->setActiveSheetIndex(0)->setCellValue('B5', "CARA DAFTAR");
$excel->setActiveSheetIndex(0)->setCellValue('C5', "NAMA");
$excel->setActiveSheetIndex(0)->setCellValue('D5', "J. KELAMIN");
$excel->setActiveSheetIndex(0)->setCellValue('E5', "TANGGAL LAHIR");
$excel->setActiveSheetIndex(0)->setCellValue('F5', "NAMA ORANGTUA");
$excel->setActiveSheetIndex(0)->setCellValue('G5', "HP");
$excel->setActiveSheetIndex(0)->setCellValue('H5', "EMAIL");
$excel->setActiveSheetIndex(0)->setCellValue('I5', "ALAMAT");
$excel->setActiveSheetIndex(0)->setCellValue('J5', "NIK");
$excel->setActiveSheetIndex(0)->setCellValue('K5', "JURUSAN");
$excel->setActiveSheetIndex(0)->setCellValue('L5', "TANGGAL DAFTAR");

//  $excel->getActiveSheet()->getStyle('A5:V7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// Set orientasi kertas jadi LANDSCAPE

for ($i = 'A'; $i <= 'L'; $i++) {
  $excel->getActiveSheet()->getStyle($i . '5')->applyFromArray($style_col);
}

$excel->getActiveSheet()->getStyle('A5:L5')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A5:L5')->getFont()->setSize(12);
$no = 0;


$rownum = 6;
foreach ($record as $row) {
  $no++;


  $excel->setActiveSheetIndex(0)->setCellValue('A' . $rownum, $no);
  $excel->setActiveSheetIndex(0)->setCellValue('B' . $rownum, $row['cara_daftar']);
  $excel->setActiveSheetIndex(0)->setCellValue('C' . $rownum, stripslashes($row['nama']));
  $excel->setActiveSheetIndex(0)->setCellValue('D' . $rownum, $row['jk']);
  $excel->setActiveSheetIndex(0)->setCellValue('E' . $rownum, tgl_indo($row['tgl_lahir']));
  $excel->setActiveSheetIndex(0)->setCellValue('F' . $rownum, stripslashes($row['nama_ortu']));
  $excel->setActiveSheetIndex(0)->setCellValueExplicit('G' . $rownum, $row['hp'], PHPExcel_Cell_DataType::TYPE_STRING);
  $excel->setActiveSheetIndex(0)->setCellValue('H' . $rownum, stripslashes($row['email']));
  $excel->setActiveSheetIndex(0)->setCellValue('I' . $rownum, stripslashes($row['alamat']));
  $excel->setActiveSheetIndex(0)->setCellValueExplicit('J' . $rownum, $row['nik'], PHPExcel_Cell_DataType::TYPE_STRING);
  $excel->setActiveSheetIndex(0)->setCellValue('K' . $rownum, $row['jurusan']);
  $excel->setActiveSheetIndex(0)->setCellValue('L' . $rownum, tgl_waktu_full($row['create_at']));

  for ($i = 'A'; $i <= 'L'; $i++) {
    $excel->getActiveSheet()->getStyle($i . $rownum)->applyFromArray($style_row);
  }

  $rownum++;
}



$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
$excel->getActiveSheet()->getColumnDimension('I')->setWidth(50);
$excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
$excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);


$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
$excel->getActiveSheet()->getStyle('A1:L' . $excel->getActiveSheet()->getHighestRow())->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$excel->getActiveSheet()->getStyle('A1:L' . $excel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("DATA_PENDAFTAR");
$excel->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="pendaftar' . $tahun . '.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');
