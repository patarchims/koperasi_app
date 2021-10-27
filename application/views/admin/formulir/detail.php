<div class="row">
<!-- end col-6 -->

<div class="col-md-12">
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <?=aksiKembali($link)?>
            </div>
            <h4 class="panel-title">Detail <?=$rows['jenis']?></h4>
        </div>
        <div class="panel-body text-center">
          <img class="p-b-20" src="<?=gambarAws($rows['gambar'])?>" width="200" alt="">
        
          <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
              <div class="table-responsive text-left f-w-700">
                  <table class="table table-hover table-condensed ">
                    <tbody>
                     <tr>
                        <td width="15%">Nama</td>
                        <td>:</td>
                        <td><?=stripcslashes($rows['nama'])?></td>
                     </tr>
                     <tr>
                          <td width="15%" nowrap>NIP</td>
                          <td width="1%">:</td>
                          <td><?=$rows['nip']?></td>
                     </tr>
                        <tr>
                          <td width="15%">Jenis Kelamin</td>
                          <td width="1%">:</td>
                          <td><?=viewKodeApp('KELAMIN',$rows['jk'])?></td>
                        </tr>
                        <tr>
                          <td>Agama</td>
                          <td width="1%">:</td>
                          <td><?=viewKodeApp('AGAMA',$rows['agama'])?></td>
                        </tr>
                         <tr>
                          <td width="15%">Alamat</td>
                          <td width="1%">:</td>
                          <td><?=stripcslashes($rows['alamat'])?></td>
                        </tr>
                         <tr>
                          <td width="15%">Email</td>
                          <td width="1%">:</td>
                          <td><?=$rows['email']?></td>
                        </tr>
                         <tr>
                          <td width="15%">No. HP</td>
                          <td width="1%">:</td>
                          <td><?=$rows['hp']?></td>
                        </tr>
                        <tr>
                          <td width="15%">Jabatan</td>
                          <td width="1%">:</td>
                          <td><?=viewJabatan($rows['id_jabatan'])?></td>
                        </tr>
                        <tr>
                          <td width="15%">Golongan/ Pangkat</td>
                          <td width="1%">:</td>
                          <td><?=viewKodeApp('GOL',$rows['gol'])?></td>
                        </tr>
                        <tr>
                          <td width="15%">Status</td>
                          <td width="1%">:</td>
                          <td><?=viewKodeApp('STSPEG',$rows['status'])?></td>
                        </tr>
                        <tr>
                          <td width="15%" nowrap>Pendidikan Terakhir</td>
                          <td width="1%">:</td>
                          <td><?=viewKodeApp('PENDIDIKAN',$rows['pendidikan'])?></td>
                        </tr>
                        <tr>
                          <td width="15%">Alumni Dari</td>
                          <td width="1%">:</td>
                          <td><?=stripcslashes($rows['alumni'])?></td>
                        </tr>
                        
                      
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
        
    </div>
    <!-- end panel -->
</div>
</div>