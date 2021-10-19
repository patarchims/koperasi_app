<?php
$pdf = new ST('L', 'mm', 'A4');
$pdf->SetMargins(15, 50, 15);
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 10);
$pdf->SetLineWidth(0.5);

$table = new easyTable($pdf, '{8,14,30,15,20,30,25,35,40,20,20,20}', 'width:277; font-size:8; font-family: Arial; valign:T; paddingX:1; border-width:0.2;border:1;border-color:#000;');
$table->easyCell("DATA PENDAFTAR PPDB\r\n" . $identitas['nama'] . "\r\nTAHUN " . $tahun, "align:C;  font-size:12; valign:B;  colspan:12; padingY:0; border:0; font-style:B; ");
$table->printRow();

$table->easyCell("No", "align:C; font-size:10; font-style:B; ");
$table->easyCell("Cara Daftar", "align:C; font-size:10; font-style:B; ");
$table->easyCell("Nama", "align:C; font-size:10; font-style:B;  ");
$table->easyCell("J. Kel", "align:C; font-size:10; font-style:B; ");
$table->easyCell("Tgl. Lahir", "align:C; font-size:10; font-style:B; ");
$table->easyCell("Nama Orangtua", "align:C; font-size:10; font-style:B; ");
$table->easyCell("HP", "align:C; font-size:10; font-style:B; ");
$table->easyCell("Email", "align:C; font-size:10; font-style:B; ");
$table->easyCell("Alamat", "align:C; font-size:10; font-style:B; ");
$table->easyCell("NIK", "align:C; font-size:10; font-style:B; ");
$table->easyCell("Jurusan", "align:C; font-size:10; font-style:B; ");
$table->easyCell("Tgl. Daftar", "align:C; font-size:10; font-style:B; ");
$table->printRow();
$no = 0;
foreach ($record as $row) {
    $no++;
    $table->easyCell($no, "align:C;");
    $table->easyCell($row['cara_daftar'], "align:C;");
    $table->easyCell(stripslashes($row['nama']), "align:L; ");
    $table->easyCell($row['jk'], "align:C; ");
    $table->easyCell(tgl_view($row['tgl_lahir']), "align:L; ");
    $table->easyCell(stripslashes($row['nama_ortu']), "align:L; ");
    $table->easyCell(stripslashes($row['hp']), "align:L; ");
    $table->easyCell(stripslashes($row['email']), "align:L; ");
    $table->easyCell(stripslashes($row['alamat']), "align:L; ");
    $table->easyCell(stripslashes($row['nik']), "align:L; ");
    $table->easyCell(stripslashes($row['jurusan']), "align:L; ");
    $table->easyCell(tgl_waktu($row['create_at']), "align:L; ");
    $table->printRow();
}



$table->endTable();
$pdf->SetTitle("Pendaftar_" . $tahun);
$pdf->Output();
