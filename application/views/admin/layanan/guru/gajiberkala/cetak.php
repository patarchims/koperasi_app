<?php
$pdf = new ST('P', 'mm', 'A4');
$pdf->SetMargins(20, 50, 20);

$pdf->AddPage();
$pdf->SetAutoPageBreak(false, 10);
$pdf->SetFont('Arial', '', 11);
$pdf->SetLineWidth(0.5);

$table = new easyTable($pdf, '{10,5,5,60,20,10,25,30}', 'width:170; font-size:11; font-family: Arial; valign:T; paddingX:1; border-width:0.2;border:0;border-color:#000;');
$table->easyCell(tgl_indo($rows['tanggal']), "align:R;  font-size:11; valign:B;  colspan:8; padingY:0; ");
$table->printRow();
$table->easyCell("Nomor", "align:L;  font-size:11; colspan:2;");
$table->easyCell(":", "align:C;  font-size:11;");
$table->easyCell($rows['nomor'], "align:L;  font-size:11; padingY:0; colspan:5; ");
$table->printRow();

$table->easyCell("Lamp", "align:L;  font-size:11; colspan:2;");
$table->easyCell(":", "align:C;  font-size:11;");
$table->easyCell($rows['lampiran'], "align:L;  font-size:11; padingY:0; ");
$table->easyCell("", "align:L;  font-size:11; padingY:0; ");
$table->easyCell("Kepada Yth :", "align:L;  font-size:11; padingY:0; colspan:3; ");
$table->printRow();

$table->easyCell("Hal", "align:L;  font-size:11; colspan:2;");
$table->easyCell(":", "align:C;  font-size:11;");
$table->easyCell($rows['hal'], "align:L;  font-size:11; padingY:0; ");
$table->easyCell("", "align:L;  font-size:11; padingY:0; ");
$table->easyCell("Kepada Dinas Pendidikan\r\nProvinsi Sumatera Utara", "align:L;  font-size:11; padingY:0; colspan:3; ");
$table->printRow();

$pdf->Ln(5);
$table->easyCell("", "align:L;  font-size:11; colspan:2;");
$table->easyCell("", "align:C;  font-size:11;");
$table->easyCell("", "align:L;  font-size:11; padingY:0; ");
$table->easyCell("", "align:L;  font-size:11; padingY:0; ");
$table->easyCell("Di-", "align:C;  font-size:11; padingY:0; ");
$table->easyCell("", "align:L;  font-size:11; padingY:0; ");
$table->easyCell("", "align:L;  font-size:11; padingY:0; ");
$table->printRow();
$table->easyCell("", "align:L;  font-size:11; colspan:2;");
$table->easyCell("", "align:C;  font-size:11;");
$table->easyCell("", "align:L;  font-size:11; padingY:0; ");
$table->easyCell("", "align:L;  font-size:11; padingY:0; ");
$table->easyCell("Medan", "align:R;  font-size:11; padingY:0; colspan:2; ");
$table->easyCell("", "align:L;  font-size:11; padingY:0; ");
$table->printRow();
$pdf->SetFont('Arial', '', 11);
$pdf->SetWidths(array(170));
$table->easyCell("Dengan Hormat", "align:L;  font-size:11; valign:B;  colspan:8; padingY:0; ");
$table->printRow();
$table->easyCell(gantiSpasi($rows['keterangan']), "align:L;  font-size:11; valign:B;  colspan:8; padingY:0; ");
$table->printRow();


$table->easyCell("No", "align:C; font-size:11; font-style:B; border:1;");
$table->easyCell("Nama", "align:C; font-size:11; font-style:B; colspan:3; border:1;");
$table->easyCell("Golongan", "align:C; font-size:11; font-style:B; colspan:2; border:1;");
$table->easyCell("NIP", "align:C; font-size:11; font-style:B; colspan:2; border:1;");
$table->printRow();
$no = 0;
foreach ($record as $row) {
    $no++;
    $table->easyCell($no, "align:C; font-size:11;  border:1;");
    $table->easyCell(stripslashes($row['nama']), "align:L; font-size:11;  colspan:3; border:1;");
    $table->easyCell($row['gol'], "align:C; font-size:11;  border:1; colspan:2;");
    $table->easyCell($row['nip'], "align:L; font-size:11;  border:1; colspan:2;");
    $table->printRow();
}



$table->easyCell("Demikian usulan ini disampaikan untuk urusan selanjutnya, atas kerja sama yang baik kami ucapkan terima kasih.", "align:L;  font-size:11; valign:B;  colspan:8; padingY:0; ");
$table->printRow();
$table->endTable();
$pdf->Ln(10);
$table = new easyTable($pdf, '{100,70}', 'width:170; font-size:11; font-family: Arial; valign:T; border-width:0.2;border:0;border-color:#000;');

$table->printRow();
if ($rows['kategori'] == 'Kepala Sekolah') {
    $table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
    $table->easyCell($rows['jabatan'] . ",", "align:L; font-size:11; font-style:B; paddingY:0.5;");
    $table->printRow();
} else {
    $table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
    $table->easyCell("a.n. Kepala Sekolah ", "align:L; font-size:11; font-style:B; paddingY:0.5;");
    $table->printRow();
    $table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
    $table->easyCell($rows['jabatan'] . ",", "align:L; font-size:11; font-style:B; paddingY:0.5;");
    $table->printRow();
}
$table->rowStyle("min-height:15;");
$table->easyCell("", "align:L; font-size:11; colspan:2; ");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
$table->easyCell(stripslashes($rows['nama']), "align:L; font-style:B; font-size:11; paddingY:0.5;");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
$table->easyCell("NIP. " . $rows['nip'], "align:L; font-size:11;paddingY:0.5;");
$table->printRow();
$table->endTable();
$pdf->SetTitle("GajiBerkala" . time());
$pdf->Output();
