<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    var $data;

    function __construct()
    {
        parent::__construct(); // needed when adding a constructor to a controller
        $identitas = $this->model_app->edit('identitas', array('id' => 1))->row_array();
        $side_bd = api('api/sidebar', array("npsn" => $identitas['kode'], "uid" => $identitas['uid'], 'jumlah' => '10'));
        $this->data = array(
            'identitas' => $identitas,
            'ctrl' => 'home',
            'tabs' => menuwebsite(),
            'agenda' => $this->model_app->agenda('10'),
            'berita_dinas' => $side_bd->berita,
            'tautan_dinas' => $side_bd->tautan,
            'koneksi_api' => $side_bd->action
        );
    }

    function index()
    {
        $data = $this->data;
        $data['link'] = 'home';
        $data['title'] = 'Beranda Depan';
        $data['deskripsi'] = $data['identitas']['deskripsi'];
        $data['keyword'] = $data['identitas']['keyword'];

        $data['slider'] = $this->model_app->view_where_ordering('slider', array('aktif' => '1'), 'id_slider', 'DESC');
        $pengumuman = $this->model_app->pengumuman(5);
        $running = array();
        foreach ($pengumuman as $rt) {
            $running[] = '<a style=color:white; href="' . base_url('informasi/detail/pengumuman/' . $rt['seo']) . '">' . stripcslashes($rt['judul']) . '</a>';
        }
        $hasil = implode(' <i class="fa fa-star"></i> ', $running);
        $data['pengumuman'] = '<i class="fa fa-star"></i> ' . $hasil . ' <i class="fa fa-star"></i>';
        $data['berita'] = $this->model_app->berita('8');
        $data['fasilitas'] = $this->model_app->fasilitas('10');

        $this->template->load('front', 'front/home', $data);
    }
} //controller
