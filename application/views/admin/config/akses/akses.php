<div class="panel panel-inverse">
  <div class="panel-heading">

    <div class="panel-heading-btn">
     
        <form class="form-inline" action="<?=base_url($link)?>" method="post">
            <div class="form-group">
               <select name="level_id" class="form-control form-control-sm" onchange="submit()">
                <?=opLevel($level_id)?>
                </select>
             </div>
        </form>
      
    </div>
    
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
        <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
             <thead>
              <tr>
                <th>No</th>
                <th>Nama Modul</th>
                <th>Baca</th>
                <th>Menu</th>
                
              </tr>
            </thead>
            <tbody>
              <?php
                $no=0;
                foreach ($record as $row) {
                $no++;
                if($row['baca']==0)
                {
                 $aksi= '<div class="switcher switcher-success">
                          <input type="checkbox" name="switcher_checkbox_2" class="edit" id="baca_'.$row['id'].'_1"  >
                          <label for="baca_'.$row['id'].'_1"></label>
                        </div>';
                  
                }
                else
                {
                  $aksi= '<div class="switcher switcher-success">
                            <input type="checkbox" name="switcher_checkbox_2" class="edit" id="baca_'.$row['id'].'_0" checked>
                            <label for="baca_'.$row['id'].'_0"></label>
                          </div>';
                }
                echo'<tr>
                      <td>'.$no.'</td>
                      <td>'.$row['nama_modul'].'</td>
                      <td>'.$aksi.'</td>
                      <td>'.aksesMenu($row['id_modul'],$level_id).'</td>
                     
                    </tr>';

            
                }
              ?>
            </tbody>
                         
          </table>
      </div>
  </div>
  <!-- /.panel-body -->
</div>
  
 
<script  type="text/javascript">
  $(document).ready(function(){

    $('.edit').change(function(){
      var id = this.id;
      var split_id = id.split("_");
      var field_name = split_id[0];
      var edit_id = split_id[1];
      var value = split_id[2];

      // AJAX request
      $.ajax({
        url:'<?=base_url()?>config/aksibaca',
        method: 'post',
        data: {id: edit_id, value: value},
        dataType: 'json',
        success: function(){
      
        }
     });
   });
 
 
});
</script>