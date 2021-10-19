<?php
$pdf = new ST('P', 'mm', 'A4');
$pdf->SetMargins(20, 50, 20);

$pdf->AddPage();
$pdf->SetAutoPageBreak(false, 10);
$pdf->SetFont('Arial', '', 11);
$pdf->SetLineWidth(0.5);

$table = new easyTable($pdf, '{10,8,32,65,30,25}', 'width:170; font-size:11; font-family: Arial; valign:M; paddingX:1; border-width:0.2;border:0;border-color:#000;');

$table->easyCell(stripslashes($rows['judul_surat']), "align:C; font-style:BU; font-size:16; valign:B;  colspan:6; padingY:0; ");
$table->printRow();
$table->easyCell("Nomor : " . $rows['nomor'], "align:C;  font-size:12; valign:T;  colspan:6; padingY:0; ");
$table->printRow();
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 11);
$pdf->SetWidths(array(170));
$pdf->RowNoLine(array("Yang bertandatangan di bawah ini,"));
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Nama", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['nama']), "align:L; font-style:B; font-size:11; colspan:3; ");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("NIP", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['nip']), "align:L; font-size:11; colspan:3; ");
$table->printRow();
$table->easyCell("", "align:L; font-size:11; ");
$table->easyCell("Jabatan", "align:L; font-size:11; colspan:2;");
$table->easyCell(": " . stripslashes($rows['jabatan']), "align:L; font-size:11; colspan:3; ");
$table->printRow();
if ($rows['isi1'] != '') {
    $pdf->RowNoLine(array(gantiKoma($rows['isi1'])));
}
$table->easyCell("No", "align:C; font-size:11; font-style:B; border:1;");
$table->easyCell("Nama", "align:C; font-size:11; font-style:B; colspan:3; border:1;");
$table->easyCell("Jabatan", "align:C; font-size:11; font-style:B; border:1;");
$table->easyCell("Ket", "align:C; font-size:11; font-style:B; border:1;");
$table->printRow();
$no = 0;
foreach ($record as $row) {
    $no++;
    $table->easyCell($no, "align:C; font-size:11;  border:1;");
    $table->easyCell(stripslashes($row['nama']) . "\r\nNIP. " . $row['nip'], "align:L; font-size:11;  colspan:3; border:1;");
    $table->easyCell($row['jabatan'], "align:L; font-size:11;  border:1;");
    $table->easyCell(stripslashes($row['keterangan']), "align:L; font-size:11;  border:1;");
    $table->printRow();
}
if ($rows['isi2'] != '') {
    $pdf->RowNoLine(array(gantiKoma($rows['isi2'])));
}

if ($rows['hari_tanggal'] != '') {
    $table->easyCell("", "align:L; font-size:11; ");
    $table->easyCell("Hari/ Tanggal", "align:L; font-size:11; colspan:2;");
    $table->easyCell(": " . stripslashes($rows['hari_tanggal']), "align:L; font-size:11; colspan:3; ");
    $table->printRow();
}

if ($rows['waktu'] != '') {
    $table->easyCell("", "align:L; font-size:11; ");
    $table->easyCell("Pukul", "align:L; font-size:11; colspan:2;");
    $table->easyCell(": " . stripslashes($rows['waktu']), "align:L; font-size:11; colspan:3; ");
    $table->printRow();
}
if ($rows['tempat'] != '') {
    $table->easyCell("", "align:L; font-size:11; ");
    $table->easyCell("Tempat", "align:L; font-size:11; colspan:2;");
    $table->easyCell(": " . stripslashes($rows['tempat']), "align:L; font-size:11; colspan:3; ");
    $table->printRow();
}
if ($rows['syarat'] != '') {
    $sya = explode(";", $rows['syarat']);
    if (count($sya) == 1) {

        $table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
        $table->easyCell(stripslashes($rows['syarat']), "align:L; font-size:11; colspan:5; paddingY:0.5;");
        $table->printRow();
    } else {
        foreach ($sya as $key) {
            $table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
            $table->easyCell(chr(108), "align:C; font-size:9; font-family: ZapfDingbats; paddingY:0.5;");
            $table->easyCell(stripslashes($key), "align:L; font-size:11; colspan:4; paddingY:0.5;");
            $table->printRow();
        }
    }
}
$table->endTable();

$pdf->RowNoLine(array("Demikian surat tugas ini dibuat untuk dilaksanakan dengan sebaik-baiknya."));
$pdf->Ln(5);
$table = new easyTable($pdf, '{100,70}', 'width:170; font-size:11; font-family: Arial; valign:T; border-width:0.2;border:0;border-color:#000;');
$table->easyCell("", "align:L; font-size:11; paddingY:0.5;");
$table->easyCell($identitas['kota'] . ", " . tgl_indo($rows['tanggal']), "align:L; font-size:11; paddingY:0.5;");
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
$pdf->SetTitle("SuratTugas" . time());
$pdf->Output();
