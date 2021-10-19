<div class="row">

    <!-- begin col-6 -->
    <div class="col-md-3">

        <div class="thumbnail">
            <?php

            echo '
              <img src="' . gambarAws($rows['gambar']) . '" alt="" width="100%">
              ';

            ?>

        </div>

    </div>
    <!-- end col-6 -->
    <div class="col-md-9">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <!-- <a href="?=base_url($link.'edit')?>" class="btn btn-info btn-xs"  ><i class="fa fa-edit"></i> Edit</a> -->
                </div>
                <h4 class="panel-title">Biodata</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover ">
                    <tbody>
                        <tr>
                            <td>Nama</td>
                            <td width="1%">:</td>
                            <td><?= stripslashes($rows['nama']) ?></td>
                        </tr>
                        <tr>
                            <td>NIP</td>
                            <td>:</td>
                            <td><?= $rows['nip'] ?></td>
                        </tr>

                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?= $rows['jk'] ?></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td><?= $rows['agama'] ?></td>
                        </tr>
                        <tr>
                            <td>Pangkat/ Golongan</td>
                            <td>:</td>
                            <td><?= $rows['pangkat'] . '/' . $rows['gol'] ?></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td><?= viewJabatan($rows['id_jabatan']) ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td><?= $rows['status_pegawai'] ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?= $rows['email'] ?></td>
                        </tr>
                        <tr>
                            <td>HP</td>
                            <td>:</td>
                            <td><?= $rows['hp'] ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?= stripslashes($rows['alamat']) ?></td>
                        </tr>


                    </tbody>
                </table>
            </div>
        </div>
        <!-- end panel -->
    </div>
</div>