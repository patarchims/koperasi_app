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
                <td><?= viewAnggota($result['id_anggota'], 'nama_anggota') ?></td>
            </tr>
            <tr>
                <td>Telp</td>
                <td>:</td>
                <td><?= viewAnggota($result['id_anggota'], 'telp') ?></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td><?= viewAnggota($result['id_anggota'], 'no_anggota') ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td><?= viewAnggota($result['id_anggota'], 'email') ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?= $result['tanggal'] ?></td>
            </tr>
        </tbody>
    </table>

    <br><br>


    <table class="table tablesolid">
        <thead>
            <tr>
                <th class="tablesolid">Nomor Pinjam</th>
                <th class="tablesolid">NIK</th>
                <th class="tablesolid">Nama</th>
                <th class="tablesolid">Tanggal</th>
                <th class="tablesolid">Jumlah Angsuran</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tablesolid"><?= $result['no_pinjaman'] ?></td>
                <td class="tablesolid"><?= viewAnggota($result['id_anggota'], 'no_identitas') ?></td>
                <td class="tablesolid"><?= viewAnggota($result['id_anggota'], 'nama_anggota') ?></td>
                <td class="tablesolid"><?= $result['tanggal'] ?></td>
                <td class="tablesolid"><?= 'IDR ' . rupiah(viewFieldPinjaman($result['no_pinjaman'], 'angsuran')) ?></td>
            </tr>

        <tbody>
    </table>


    <!-- Jarak -->
    <br><br>


    <div style="position: fixed; right: 0mm; bottom: 13cm; ">
        <table style="text-align: right; float:right; ">
            <tbody>
                <tr>
                    <td>Nomor Angsuran</td>
                    <td>:</td>
                    <td><?= $result['no_angsuran'] ?> </td>
                </tr>
                <tr>
                    <td>Angsuran Ke</td>
                    <td>:</td>
                    <td><?= $result['angsuran_ke'] ?> </td>
                </tr>
                <tr>
                    <td>Denda</td>
                    <td>:</td>
                    <td>IDR . <?= rupiah($result['denda']) ?> </td>
                </tr>
                <tr>
                    <td>Total Bayar</td>
                    <td>:</td>
                    <td>IDR . <?= rupiah($result['jlh_bayar']) ?> </td>
                </tr>
            </tbody>
        </table>
    </div>


    <div style="position: fixed; right: 0mm; top: 5.5cm; ">
        <h4>No. Angsuran : #<?= $result['no_angsuran'] ?></h4>
        <h4>No. Pinjam : #<?= $result['no_pinjaman'] ?> </h4>
    </div>
    <div style="position: fixed; left: 0mm; bottom: 10cm; ">
        <strong>Note :</strong>
        <p><?= $result['keterangan'] ?></p>
    </div>



</body>

</html>