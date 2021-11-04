<!DOCTYPE html>
<html>

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title><?= $title  ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />


</head>

<body>

    <style>
        table,
        th,
        td {
            padding: 3px;
        }

        .tablesolid {
            border: 1px solid black;

        }
    </style>



    <table style="text-align: center; width: 100%;">
        <tr>
            <td> <img style="height: 75px; width: 75px;" src="<?= base_url('assets/img/' . $identitas['logo']) ?>" alt=""></td>
        </tr>
        <tr>
            <td>
                <h3><?= $identitas['nama'] ?></h3>
            </td>
        </tr>
        <tr>
            <td>
                <h5><?= $identitas['alamat'] ?></h5>
            </td>

        </tr>
    </table>

    <br>
    <h4 style="text-align: center;"><?= $title ?></h4>

    <br>

    <table class="table tablesolid">
        <thead>
            <tr>
                <th class="tablesolid">No.</th>
                <th class="tablesolid">Nomor Angsuran</th>
                <th class="tablesolid">No. Pinjaman</th>
                <th class="tablesolid">Angsuran Ke</th>
                <th class="tablesolid">Jumlah</th>
                <th class="tablesolid">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            foreach ($result as $key) {
                $no++;

            ?>
                <tr>
                    <td class="tablesolid"><?= $no ?></td>
                    <td class="tablesolid"><?= $key['no_angsuran'] ?></td>
                    <td class="tablesolid"><?= $key['no_pinjaman'] ?></td>
                    <td class="tablesolid"><?= $key['angsuran_ke'] ?></td>
                    <td class="tablesolid"><?= rupiah($key['jlh_bayar']) ?></td>
                    <td class="tablesolid"><?= tgl_indo($key['tanggal']) ?></td>
                </tr>
            <?php } ?>

        <tbody>
    </table>



</body>

</html>