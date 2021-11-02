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

    <br><br>

    <table style="text-align: left;">
        <tbody>
            <tr>
                <td>Kepada</td>
                <td> :</td>
                <td>Nama Orang</td>
            </tr>
            <tr>
                <td>Telp</td>
                <td>:</td>
                <td>Telp</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>NIK</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>Email</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>Tanggal</td>
            </tr>
        </tbody>
    </table>

    <br><br>


    <table class="table tablesolid">
        <thead>
            <tr>
                <th class="tablesolid">Jumlah Pinjam</th>
                <th class="tablesolid">Tenor</th>
                <th class="tablesolid">Bunga Per Tahun</th>
                <th class="tablesolid">Total #</th>
                <th class="tablesolid">Angsuran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tablesolid">1</td>
                <td class="tablesolid">PHP and MySQL</td>
                <td class="tablesolid">Larry Ullman</td>
                <td class="tablesolid">Larry Ullman</td>
                <td class="tablesolid">Larry Ullman</td>
            </tr>

        <tbody>
    </table>


    <!-- Jarak -->
    <br><br>


    <div style="position: fixed; right: 0mm; bottom: 13cm; ">
        <table style="text-align: right; float:right; ">
            <tbody>
                <tr>
                    <td>Jumlah Pinjaman</td>
                    <td>:</td>
                    <td>IDR </td>
                </tr>
                <tr>
                    <td>Jumlah Pinjaman</td>
                    <td>:</td>
                    <td>IDR </td>
                </tr>
                <tr>
                    <td>Jumlah Pinjaman</td>
                    <td>:</td>
                    <td>IDR </td>
                </tr>
            </tbody>
        </table>
    </div>


    <div style="position: fixed; right: 0mm; top: 5.5cm; ">
        <h4>No. Pinjam : #</h4>
        <h4>No. Anggota : #</h4>
    </div>
    <div style="position: fixed; left: 0mm; bottom: 10cm; ">
        <strong>Note :</strong>
        <p>Catatan</p>
    </div>



</body>

</html>