<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Infodinas extends CI_Controller
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
      'ctrl' => 'infodinas',
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
    redirect();
  }

  function berita($hal = 1)
  {
    $data = $this->data;
    $data['link'] = 'infodinas/berita';
    $data['title'] = 'Berita Dinas';
    $data['deskripsi'] = $data['identitas']['deskripsi'];
    $data['keyword'] = $data['identitas']['keyword'];

    if (isset($_POST['cari'])) {
      $this->session->set_userdata(array('cariberita' => postnumber('cari')));
    }
    $cari = $this->session->cariberita;
    $data['cari'] = $cari;
    $config['per_page'] = 6;

    $row = api('api/berita', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], 'jumlah' => $config['per_page'], 'halaman' => $hal, 'cari' => $cari));

    $jumlah = $row->total;
    $config['base_url'] = base_url() . 'infodinas/berita';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $jumlah;

    $dari = ($hal - 1) * $config['per_page'];

    if (is_numeric($dari)) {
      $data['record'] = $row->hasil;
    } else {
      redirect();
    }

    $this->pagination->initialize($config);
    $this->template->load('front', 'front/infodinas/berita', $data);
  }



  function pengumuman($hal = 1)
  {
    $data = $this->data;
    $data['link'] = 'infodinas/pengumuman';
    $data['title'] = 'Pengumuman';
    $data['deskripsi'] = $data['identitas']['deskripsi'];
    $data['keyword'] = $data['identitas']['keyword'];

    if (isset($_POST['cari'])) {
      $this->session->set_userdata(array('caripengumuman' => postnumber('cari')));
    }
    $cari = $this->session->caripengumuman;
    $data['cari'] = $cari;
    $config['per_page'] = 6;

    $row = api('api/pengumuman', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], 'jumlah' => $config['per_page'], 'halaman' => $hal, 'cari' => $cari));

    $jumlah = $row->total;
    $config['base_url'] = base_url() . 'infodinas/pengumuman';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $jumlah;

    $dari = ($hal - 1) * $config['per_page'];

    if (is_numeric($dari)) {
      $data['record'] = $row->hasil;
    } else {
      redirect();
    }
    $this->pagination->initialize($config);
    $this->template->load('front', 'front/infodinas/pengumuman', $data);
  }

  function download($hal = 1)
  {
    $data = $this->data;
    $data['link'] = 'infodinas/download';
    $data['title'] = 'Download';
    $data['deskripsi'] = $data['identitas']['deskripsi'];
    $data['keyword'] = $data['identitas']['keyword'];

    if (isset($_POST['cari'])) {
      $this->session->set_userdata(array('caridownload' => postnumber('cari')));
    }
    $cari = $this->session->caridownload;
    $data['cari'] = $cari;
    $config['per_page'] = 20;

    $row = api('api/download', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], 'jumlah' => $config['per_page'], 'halaman' => $hal, 'cari' => $cari));

    $jumlah = $row->total;
    $config['base_url'] = base_url() . 'infodinas/download';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $jumlah;

    $dari = ($hal - 1) * $config['per_page'];

    if (is_numeric($dari)) {
      $data['record'] = $row->hasil;
    } else {
      redirect();
    }
    $this->pagination->initialize($config);
    $this->template->load('front', 'front/infodinas/download', $data);
  }

  function downloadfile($seo)
  {
    $data = $this->data;
    $id = dekrip($seo);
    $row = api('api/downloadfile', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], 'seo' => $id));

    redirect($row->gambar);
  }

  function detail($hal, $seo)
  {
    $data = $this->data;
    $data['link'] = 'infodinas/detail';
    if ($hal == 'berita') {
      $row = api('api/beritadetail', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], 'seo' => $seo));

      $hasil = $row->hasil;
      $isi_berita = (strip_tags($hasil->isi));
      $isi = substr($isi_berita, 0, 200);
      $isi = substr($isi_berita, 0, strrpos($isi, " "));
      $data['deskripsi'] = $isi;
      $data['keyword'] = $hasil->keyword;
      $data['tags'] = explode(",", $hasil->keyword);
      $data['gambar'] = $hasil->gambar;
    } else if ($hal == 'pengumuman') {
      $row = api('api/pengumumandetail', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], 'seo' => $seo));

      $hasil = $row->hasil;
      $isi_berita = (strip_tags($hasil->isi));
      $isi = substr($isi_berita, 0, 200);
      $isi = substr($isi_berita, 0, strrpos($isi, " "));

      $data['deskripsi'] = $isi;
      $data['keyword'] = $data['identitas']['keyword'];
      $data['gambar'] = '';
    }
    $data['title'] = stripcslashes($hasil->judul);

    $data['hal'] = $hal;
    $data['rows'] = $hasil;
    // Penambahan Funsi terpisah Tanggal
    $data['bln'] =  getBulan(substr($data['rows']->tanggal, 5, 2));
    $data['tgl'] =  substr($data['rows']->tanggal, 8, 2);
    $data['tahun'] =  substr($data['rows']->tanggal,  0, 4);
    $this->template->load('front', 'front/infodinas/detail', $data);
  }

  function profil()
  {
    $data = $this->data;
    $data['link'] = 'infodinas/detail';

    $row = api('api/profil', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid']));
    $data['deskripsi'] = $data['identitas']['deskripsi'];
    $data['keyword'] = $data['identitas']['keyword'];

    $data['title'] = 'Profil Dinas Pendidikan';
    $data['record'] = $row->hasil;
    $this->template->load('front', 'front/infodinas/profil', $data);
  }
} //controller
