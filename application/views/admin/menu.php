<?php 
       $level_id=$this->session->level;
       $menu=$this->model_app->view_modul($level_id);
       foreach ($menu as $row) 
       {
            $id=$row['id_modul'];
            $ceksub=cekMenu($id,$level_id);
            if($ctrl==$row['controller'])
                {
                    $active='active';
                }
                else
                {
                    $active='';
                }
        
                if($ceksub==0)
                {
                    
                    echo'<li class="'.$active.'"><a href="'.base_url().''.$row['controller'].'">
                    <i class="fa fa-'.$row['icon'].'"></i>
                    <span>'.$row['nama_modul'].'</span>
                  </a></li>';
                 
                }
                else
                {
                  
                echo' <li class="has-sub '.$active.'">
                         <a href="javascript:;">
                            <b class="caret pull-right"></b>
                                <i class="fa fa-'.$row['icon'].'"></i> 
                                    <span>'.$row['nama_modul'].'</span>
                        </a>
                        <ul class="sub-menu">';
                        $submenu=$this->model_app->view_menu($id,$level_id);
                        foreach ($submenu as $rows) {
                            

                                $id_menu=$rows['id_menu'];
                                    if(cekSubMenu($id_menu,$level_id)==0)
                                    {
                                        if($link==$rows['link'])
                                        {
                                            $aktif='active';
                                        }
                                        else
                                        {
                                        $aktif='';
                                        }
                                     echo'<li class="'.$aktif.'" ><a  href="'.base_url().''.$rows['link'].'">'.$rows['nama_menu'].'</a></li>';
                                    }
                                    else
                                    {
                                        if($id_menu==idParent($link))
                                        {
                                            $aktif='active';
                                        }
                                        else
                                        {
                                            $aktif='';
                                        }
                                    echo' <li class="has-sub '.$aktif.'">
                                     <a href="javascript:;">
                                        <b class="caret pull-right"></b>
                                         <span>'.$rows['nama_menu'].'</span>
                                        </a>
                                        <ul class="sub-menu"> ';

                                        $submenu2=$this->model_app->view_submenu($id_menu,$level_id);
                                        foreach ($submenu2 as $rows2) {
                                            if($link==$rows2['link'])
                                            {
                                            $aktif2='active';
                                            }
                                             else
                                            {
                                            $aktif2='';
                                            }
                                            echo'<li class="'.$aktif2.'" ><a  href="'.base_url().''.$rows2['link'].'">'.$rows2['nama_menu'].'</a></li>';
                                        }
                                    echo '</ul>
                                    </li>';
                            }
                        }
                   echo' </ul>
                    </li>';
                }
        }

        if($this->session->level=='1' AND $this->session->id_user==1)
        {
            $configmenu=$this->model_app->view_where_ordering('config_menu',array('id_parent'=>0),'urutan','ASC');
            foreach ($configmenu as $configrow) {
                $idmenu=$configrow['id_menu'];
                $act='';
                if($ctrl==$configrow['link'])
                {
                    $act='active';
                }                    
                echo' <li class="has-sub '.$act.'">
                         <a href="javascript:;">
                            <b class="caret pull-right"></b>
                                <i class="fa fa-list"></i> 
                                    <span>'.$configrow['nama_menu'].'</span>
                        </a>
                        <ul class="sub-menu">';
                        $subcmenu=$this->model_app->view_where_ordering('config_menu',array('id_parent'=>$idmenu),'urutan','ASC');
                        foreach ($subcmenu as $rowc) {
                            $tif='';
                            if($link==$rowc['link'])
                                {
                                    $tif='active';
                                }
                                
                             echo'<li class="'.$tif.'" ><a  href="'.base_url($rowc['link']).'">'.$rowc['nama_menu'].'</a></li>';
                         }
                         echo'</ul>
                         </li>';
            }
        }   

        echo'<li class="">
              <a href="'.base_url(
            'admin/logout').'">
                    <i class="fas fa-sign-out-alt text-danger"></i>
                    <span>Logout</span>
                  </a></li>';

     