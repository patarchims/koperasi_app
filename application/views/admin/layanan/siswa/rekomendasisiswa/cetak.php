<?php
$pdf = new ST('P', 'mm', 'A4');
$pdf->SetMargins(20, 50, 20);

$pdf->AddPage();
$pdf->SetAutoPageBreak(false, 10);
$pdf->SetFont('Arial', '', 11);
$pdf->SetLineWidth(0.5);

$table = new easyTable($pdf, '{10,8,42,55,30,25}', 'width:170; font-size:11; font-family: Arial; valign:M; paddingX:1; border-width:0.2;border:0;border-color:#000;');
$table->easyCell(tgl_indo($rows['tanggal']), "align:R;  font-size:12; valign:B;  colspan:6; padingY:0; ");
$table->printRow();
$table->easyCell(stripslashes($rows['judul_surat']), "align:C; font-style:BU; font-size:16; valign:B;  colspan:6; padingY:0; ");
$table->printRow();
$table->easyCell("Nomor : " . $rows['nomor'], "align:C;  font-size:12; valign:T;  colspan:6; padingY:0; ");
$table->printRow();
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 11);
$pdf->SetWidths(array(170));
$pdf->RowNoLine(array(stripslashes($rows['pengantar'])));
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Nama", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['pnama']), "align:L;  font-size:11; colspan:3; ");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("NISN", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['nisn']), "align:L; font-size:11; colspan:3; ");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Tempat, Tanggal Lahir", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['tempat_lahir']) . ", " . tgl_indo($rows['tgl_lahir']), "align:L; font-size:11; colspan:3; ");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Jenis Kelamin", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . $rows['jk'], "align:L; font-size:11; colspan:3; ");
$table->printRow();

$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Sekolah Asal", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['sekolah_asal']), "align:L;  font-size:11; colspan:3; ");
$table->printRow();

$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Alamat", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['alamat']), "align:L;  font-size:11; colspan:3; ");
$table->printRow();

$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Kelas/ Jurusan", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['kelas']) . "/ " . $rows['jurusan'], "align:L;  font-size:11; colspan:3; ");
$table->printRow();

$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Nama Orangtua", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['nama_ortu']), "align:L;  font-size:11; colspan:3; ");
$table->printRow();

$table->endTable();
$pdf->RowNoLine(array(stripslashes($rows['keterangan'])));
$pdf->Ln(5);
$pdf->RowNoLine(array("Demikian Surat Rekomendasi ini dibuat untuk dapat dipergunakan sebagaimana mestinya."));
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
$pdf->SetTitle("SuratRekomendasiSiswa" . time());
$pdf->Output();
