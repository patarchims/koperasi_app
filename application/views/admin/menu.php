<?php

$level_id = $this->session->level;
$menu = $this->model_app->view_modul($level_id);
foreach ($menu as $row) {
    $id = $row['id_modul'];
    $ceksub = cekMenu($id, $level_id);
    if ($ctrl == $row['controller']) {
        $active = 'active';
        $open = 'menu-open';
    } else {
        $active = '';
        $open = '';
    }

    if ($ceksub == 0) {
        echo '<li class="nav-item ' . $active . '">
        <a href="' . base_url() . '' . $row['controller'] . '" class="nav-link">     
          <i class="' . $row['icon'] . '"></i>
          <p>
          ' . $row['nama_modul'] . '
          </p>
        </a>
      </li>';
    } else {
        echo '<li class="nav-item ' . $open . '">
                <a href="#" class="nav-link ' . $active . '">
                <i class="nav-icon fa fa-' . $row['icon'] . '"></i> 
                <p>
                ' .  $row['nama_modul'] . '
                    <i class="right fas fa-angle-left"></i>
                </p>
                </a>
        <ul class="nav nav-treeview">';

        $submenu = $this->model_app->view_menu($id, $level_id);
        foreach ($submenu as $rows) {


            $id_menu = $rows['id_menu'];
            if (cekSubMenu($id_menu, $level_id) == 0) {
                if ($link == $rows['link']) {
                    $aktif = 'active';
                } else {
                    $aktif = '';
                }

                echo ' <li class="nav-item ' . $aktif . '">
                <a href="' . base_url() . '' . $rows['link'] . '" class="nav-link ' . $aktif . '">
                  <i class="far fa-circle nav-icon"></i>
                  <p>' . $rows['nama_menu'] . '</p>
                </a>
              </li>';
            } else {
                if ($id_menu == idParent($link)) {
                    $aktif = 'active';
                } else {
                    $aktif = '';
                }
                echo '
                    <li class="nav-item ' . $aktif . '">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                        ' . $rows['nama_menu'] . '
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">';

                $submenu2 = $this->model_app->view_submenu($id_menu, $level_id);
                foreach ($submenu2 as $rows2) {
                    if ($link == $rows2['link']) {
                        $aktif2 = 'active';
                    } else {
                        $aktif2 = '';
                    }
                    echo '<li class="nav-item ' . $aktif2 . '">
                    <a href="' . base_url() . '' . $rows2['link'] . '" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>' . $rows2['nama_menu'] . '</p>
                    </a>
                  </li>';
                }
                echo '</ul>
                                    </li>';
            }
        }
        echo ' </ul>
                    </li>';
    }
}



if ($this->session->level == '1' and $this->session->id_user == 1) {
    $configmenu = $this->model_app->view_where_ordering('config_menu', array('id_parent' => 0), 'urutan', 'ASC');
    foreach ($configmenu as $configrow) {
        $idmenu = $configrow['id_menu'];
        $act = '';
        $open = '';
        if ($ctrl == $configrow['link']) {
            $act = 'active';
            $open = 'menu-open';
        }
        echo '
        <li class="nav-item ' . $open . '">
        <a href="#" class="nav-link ' . $act . '">
          <i class="nav-icon fas fa-th"></i>
          <p>
          ' . $configrow['nama_menu'] . '
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">';
        $subcmenu = $this->model_app->view_where_ordering('config_menu', array('id_parent' => $idmenu), 'urutan', 'ASC');
        foreach ($subcmenu as $rowc) {
            $tif = '';
            if ($link == $rowc['link']) {
                $tif = 'active';
            }

            echo '  <li class="nav-item">
                    <a href="' . base_url($rowc['link']) . '" class="nav-link ' . $tif . '">
                    <i class="far fa-circle nav-icon"></i>
                    <p>' . $rowc['nama_menu'] . '</p>
                    </a>
                </li>';
        }
        echo '</ul>
    </li>';
    }
}


echo '<li class="nav-item">
        <a href="' . base_url('admin/logout') . '" class="nav-link"><i class="fas fa-sign-out-alt text-danger"></i>
            <span>Logout</span>
        </a>
    </li>';
