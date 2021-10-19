
          <!-- begin row -->
                <div class="row">
                    
                    <!-- begin col-8 -->
                    <div class="col-md-12">
                        <!-- begin panel -->
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                              <div class="panel-heading-btn">
                                <?php
                                  
                                  if(bisaTulis($link,$id_level));
                                  {
                                    echo aksiTambah('setting/usertambah','Tambah');
                                  }
                                  ?>
                                </div>
                                <h4 class="panel-title"><?=$title?></h4>
                            </div>
                            <div class="panel-body">
                              <div class="table-responsive">
                                
                             
                    <table class="table table-striped" id="data-table">
                      <thead>
                        <tr>
                        <th>No</th>
                        <th>Foto</th>
                          <th>Nama</th>
                          <th>Username</th>
                           <th>Email</th>
                           <th>Level</th>
                          
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $no = 0;
                    foreach ($record as $row){
                     
                      $no++;
                        echo'<tr class="gradeU">
                          <td>'.$no.'</td>
                          <td><img src="'.base_url('assets/img/user/'.$row['gambar']).'" alt="" height="50"></td>
                          <td>'.$row['nama'].'</td>
                          <td>'.$row['username'].'</td>
                           <td>'.$row['email'].'</td>
                           <td>'.viewLevel($row['level']).'</td>
                          
                           <td class="center" nowrap>';
                         
                          if(bisaUbah($link,$id_level))
                          {
                            echo '&nbsp;'.aksiEdit('setting/useredit',enkrip($row['id_user']));
                          }
                          
                          if(bisaHapus($link,$id_level))
                          {
                            echo '&nbsp;'.aksiHapus('setting/userhapus',enkrip($row['id_user']));
                          }

                            echo'</td>
                        </tr>';
                      }
                        ?>
                      </tbody>
                    </table>
                  </div>
                 </div>
                </div>
                <!-- Panel Widget --> 
              </div>
              <!-- col-md-12 --> 
            </div>