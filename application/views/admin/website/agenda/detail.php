<div class="row">
<!-- end col-6 -->

<div class="col-md-12">
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <?=aksiKembali($link)?>
            </div>
            <h4 class="panel-title">Detail Pengumuman</h4>
        </div>
        <div class="panel-body text-center">
          <img class="p-b-20" src="<?=gambarAws($rows['gambar'])?>" class="200" alt="">
        </div>
        <div class="panel-body">
          <?php
          echo'
          <h4>'.stripcslashes($rows['judul']).'</h4>
          <h6>Tanggal : '.tgl_indo($rows['tanggal']).'<br>Dibaca : '.$rows['dibaca'].'<br>User Input : '.viewUser($rows['input_user']).'<br>Tanggal Input : '.tgl_waktu_full($rows['input_at']).'</h6>
          <br>
          '.$rows['isi'];
          ?>
        </div>
        
    </div>
    <!-- end panel -->
</div>
</div>