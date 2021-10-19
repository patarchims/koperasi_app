<?php
$pdf = new ST('P', 'mm', 'A4');
$pdf->SetMargins(20, 50, 20);

$pdf->AddPage();
$pdf->SetAutoPageBreak(false, 10);
$pdf->SetFont('Arial', '', 11);
$pdf->SetLineWidth(0.5);

$table = new easyTable($pdf, '{10,15,5,85,30,25}', 'width:170; font-size:11; font-family: Arial; valign:M; paddingX:1; border-width:0.2;border:0;border-color:#000;');
$table->easyCell(tgl_indo($rows['tanggal']), "align:R;  font-size:11; valign:B;  colspan:6; padingY:0; ");
$table->printRow();

$table->easyCell("Nomor", "align:L;  font-size:11; valign:T; padingY:0; colspan:2; ");
$table->easyCell(":", "align:C;  font-size:11; valign:T; padingY:0; ");
$table->easyCell($rows['nomor'], "align:L;  font-size:11; valign:T; padingY:0; colspan:3");
$table->printRow();

$table->easyCell("Lampiran", "align:L;  font-size:11; valign:T; padingY:0; colspan:2;");
$table->easyCell(":", "align:C;  font-size:11; valign:T; padingY:0; ");
$table->easyCell($rows['lampiran'], "align:L;  font-size:11; valign:T; padingY:0; colspan:3");
$table->printRow();

$table->easyCell("Perihal", "align:L;  font-size:11; valign:T; padingY:0; colspan:2; ");
$table->easyCell(":", "align:C;  font-size:11; valign:T; padingY:0; ");
$table->easyCell($rows['perihal'], "align:L; font-style:B; font-size:11; valign:T; padingY:0; colspan:3");
$table->printRow();
$table->endTable();
$table = new easyTable($pdf, '{10,35,5,65,30,25}', 'width:170; font-size:11; font-family: Arial; valign:M; paddingX:1; border-width:0.2;border:0;border-color:#000;');
$pdf->SetFont('Arial', '', 11);
$pdf->SetWidths(array(170));
$pdf->RowNoLine(array(stripslashes($rows['keterangan'])));
$pdf->RowNoLine(array(stripslashes($rows['pengantar'])));
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Nama", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['pnama']), "align:L; font-style:B;  font-size:11; colspan:3; ");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("NPM", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['npm']), "align:L; font-size:11; colspan:3; ");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Program Studi", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['prodi']), "align:L; font-size:11; colspan:3; ");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Judul", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . chr(147) . stripslashes($rows['judul']) . chr(148), "align:L; font-style:B; font-size:11; colspan:3; ");
$table->printRow();

$table->endTable();
$pdf->RowNoLine(array(stripslashes($rows['isi'])));
$pdf->Ln(4);
$pdf->RowNoLine(array("Demikian Surat Izin ini diberikan, untuk dapat dipergunakan seperlunya, atas kerjasama yang baik diucapkan terimakasih."));
$pdf->Ln(10);
$table = new easyTable($pdf, '{100,70}', 'width:170; font-size:11; font-family: Arial; valign:T; border-width:0.2;border:0;border-color:#000;');
// $table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
// $table->easyCell($identitas['kota'] . ", " . tgl_indo($rows['tanggal']), "align:L; font-size:11; paddingY:0.5;");
// $table->printRow();
if ($rows['kategori'] == 'Kepala Sekolah') {
    $table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
    $table->easyCell($rows['pjabatan'] . ",", "align:L; font-size:11; font-style:B; paddingY:0.5;");
    $table->printRow();
} else {
    $table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
    $table->easyCell("a.n. Kepala Sekolah ", "align:L; font-size:11; font-style:B; paddingY:0.5;");
    $table->printRow();
    $table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
    $table->easyCell($rows['pjabatan'] . ",", "align:L; font-size:11; font-style:B; paddingY:0.5;");
    $table->printRow();
}
$table->rowStyle("min-height:15;");
$table->easyCell("", "align:L; font-size:11; colspan:2; ");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
$table->easyCell(stripslashes($rows['pnama']), "align:L; font-style:B; font-size:11; paddingY:0.5;");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
$table->easyCell("NIP. " . $rows['pnip'], "align:L; font-size:11;paddingY:0.5;");
$table->printRow();
$table->endTable();
$pdf->SetTitle("SuratIzinPenelitianSiswa" . time());
$pdf->Output();
