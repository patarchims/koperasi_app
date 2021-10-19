<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hubungikami extends CI_Controller
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
        $side_bd = api('api/sidebar', array("npsn" => $identitas['kode'], "uid" => $identitas['uid'], 'jumlah' => '6'));
        $this->data = array(
            'identitas' => $identitas,
            'ctrl' => 'hubungikami',
            'tabs' => menuwebsite(),
            'agenda' => $this->model_app->agenda(),
            'kategori' => $this->model_app->kategori_berita(),
            'berita_dinas' => $side_bd->berita,
            'tautan_dinas' => $side_bd->tautan,
            'koneksi_api' => $side_bd->action


        );
    }



    function index()
    {
        $data = $this->data;
        $data['link'] = 'hubungikami';
        $data['title'] = 'Hubungi Kami';
        $data['deskripsi'] = $data['identitas']['deskripsi'];
        $data['keyword'] = $data['identitas']['keyword'];
        $data['pesan'] = '';
        if (isset($_POST['simpan'])) {
            $simpan = array(
                'nama' => posttext('nama'),
                'hp' => posttext('hp'),
                'email' => posttext('email'),
                'nik' => posttext('nik'),
                'umur' => posttext('umur'),
                'pekerjaan' => posttext('pekerjaan'),
                'alamat' => posttext('alamat'),
                'judul' => posttext('judul'),
                'isi' => posttext('isi')
            );
            if ($this->model_app->insert('pesan', $simpan)) {
                $data['pesan'] = 'Terima Kasih Telah Menghubungi Kami';
            }
        }

        $this->template->load('front', 'front/hubungikami', $data);
    }
} //controller
