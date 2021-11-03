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
    <h4 style="text-align: center;">LAPORAN TRANSAKSI PINJAM DANA</h4>

    <br>

    <table class="table tablesolid">
        <thead>
            <tr>
                <th class="tablesolid">Nomor Pinjam</th>
                <th class="tablesolid">Nomor Anggota</th>
                <th class="tablesolid">Tanggal Transaksi</th>
                <th class="tablesolid">Jumlah Pinjaman</th>
                <th class="tablesolid"> Tenor</th>
                <th class="tablesolid">Bunga</th>
                <th class="tablesolid">Angsuran</th>
                <th class="tablesolid">Status</th>
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
                    <td class="tablesolid"><?= viewAnggota($key['id_anggota'], 'no_anggota') ?></td>
                    <td class="tablesolid"><?= $key['tgl_pinjam'] ?></td>
                    <td class="tablesolid"><?= $key['jlh_pinjam'] ?></td>
                    <td class="tablesolid"><?= $key['tenor'] . ' Bulan' ?></td>
                    <td class="tablesolid"><?= $key['bunga'] . ' %' ?></td>
                    <td class="tablesolid"><?= rupiah($key['angsuran'])  ?></td>
                    <td class="tablesolid"><?= $key['status']  ?></td>
                </tr>
            <?php } ?>

        <tbody>
    </table>



</body>

</html>