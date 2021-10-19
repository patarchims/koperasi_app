<div class="panel panel-inverse">
  <div class="panel-heading">
    

    <div class="panel-heading-btn">
      <?=aksiKembali($link)?>     
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
      <table  class="table table-striped table-bordered m-b-0" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Menu</th>
              <th>Baca</th>
              <th>Tulis</th>
              <th>Ubah</th>
              <th>Hapus</th>
              
              
            </tr>
          </thead>
          <tbody>
            <?php
              $no=0;
              foreach ($record as $row) {
              $no++;
              if($row['baca']==0)
              {
                $baca='<label class="switcher-control switcher-control-success"><input type="checkbox" id="baca_'.$row['id'].'_1"  name="onoffswitch"  class="baca  switcher-input">
                <span class="switcher-indicator"></span>
                </label>';
              }
              else
              {
                $baca='<label class="switcher-control switcher-control-success"><input type="checkbox" id="baca_'.$row['id'].'_0" name="onoffswitch"  class="baca  switcher-input" checked>
                <span class="switcher-indicator"></span></label>';
              }

              if($row['tulis']==0)
              {
                $tulis='<label class="switcher-control switcher-control-success"><input type="checkbox" id="tulis_'.$row['id'].'_1"  name="onoffswitch"  class="tulis  switcher-input">
                <span class="switcher-indicator"></span>
                </label>';
              }
              else
              {
                $tulis='<label class="switcher-control switcher-control-success"><input type="checkbox" id="tulis_'.$row['id'].'_0" name="onoffswitch"  class="tulis  switcher-input" checked>
                <span class="switcher-indicator"></span></label>';
              }

              if($row['ubah']==0)
              {
                $ubah='<label class="switcher-control switcher-control-success"><input type="checkbox" id="ubah_'.$row['id'].'_1"  name="onoffswitch"  class="ubah  switcher-input">
                <span class="switcher-indicator"></span>
                </label>';
              }
              else
              {
                $ubah='<label class="switcher-control switcher-control-success"><input type="checkbox" id="ubah_'.$row['id'].'_0" name="onoffswitch"  class="ubah  switcher-input" checked>
                <span class="switcher-indicator"></span></label>';
              }

              if($row['hapus']==0)
              {
                $hapus='<label class="switcher-control switcher-control-success"><input type="checkbox" id="hapus_'.$row['id'].'_1"  name="onoffswitch"  class="hapus  switcher-input">
                <span class="switcher-indicator"></span>
                </label>';
              }
              else
              {
                $hapus='<label class="switcher-control switcher-control-success"><input type="checkbox" id="hapus_'.$row['id'].'_0" name="onoffswitch"  class="hapus  switcher-input" checked>
                <span class="switcher-indicator"></span></label>';
              }
              echo'<tr>
                    <td>'.$no.'</td>
                    <td>'.$row['nama_menu'].'</td>
                    <td>'.$baca.'</td>
                    <td>'.$tulis.'</td>
                    <td>'.$ubah.'</td>
                    <td>'.$hapus.'</td>
                   
                  </tr>';

          
              }
            ?>
          </tbody>
                       
        </table>
    </div>
  </div>
  <!-- /.panel-body -->
</div><!-- begin breadcrumb -->
      
<script  type="text/javascript">
  $(document).ready(function(){

    $('.baca').change(function(){
      var id = this.id;
      var split_id = id.split("_");
      var field_name = split_id[0];
      var edit_id = split_id[1];
      var value = split_id[2];

      // AJAX request
      $.ajax({
        url:'<?=base_url()?>config/menubaca',
        method: 'post',
        data: {id: edit_id, value: value},
        dataType: 'json',
        success: function(){

       console.log('Save successfully'); 
         
        }
     });
   });

    $('.tulis').change(function(){
      var id = this.id;
      var split_id = id.split("_");
      var field_name = split_id[0];
      var edit_id = split_id[1];
      var value = split_id[2];

      // AJAX request
      $.ajax({
        url:'<?=base_url()?>config/menutulis',
        method: 'post',
        data: {id: edit_id, value: value},
        dataType: 'json',
        success: function(){

       console.log('Save successfully'); 
         
        }
     });
   });

    $('.ubah').change(function(){
      var id = this.id;
      var split_id = id.split("_");
      var field_name = split_id[0];
      var edit_id = split_id[1];
      var value = split_id[2];

      // AJAX request
      $.ajax({
        url:'<?=base_url()?>config/menuubah',
        method: 'post',
        data: {id: edit_id, value: value},
        dataType: 'json',
        success: function(){

       console.log('Save successfully'); 
         
        }
     });
   });

    $('.hapus').change(function(){
      var id = this.id;
      var split_id = id.split("_");
      var field_name = split_id[0];
      var edit_id = split_id[1];
      var value = split_id[2];

      // AJAX request
      $.ajax({
        url:'<?=base_url()?>config/menudelete',
        method: 'post',
        data: {id: edit_id, value: value},
        dataType: 'json',
        success: function(){

       console.log('Save successfully'); 
         
        }
     });
   });

 
});
</script>