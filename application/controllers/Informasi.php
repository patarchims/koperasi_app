<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi extends CI_Controller
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
      'ctrl' => 'informasi',
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

  function berita()
  {
    $data = $this->data;
    $data['link'] = 'informasi/berita';
    $data['title'] = 'Berita';
    $data['deskripsi'] = $data['identitas']['deskripsi'];
    $data['keyword'] = $data['identitas']['keyword'];

    if (isset($_POST['cari'])) {
      $this->session->set_userdata(array('cariberita' => postnumber('cari')));
    }
    $cari = $this->session->cariberita;
    $data['cari'] = $cari;
    $query = $this->model_app->view_berita($cari);
    $jumlah = count($query);
    $config['base_url'] = base_url() . 'informasi/berita';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $jumlah;
    $config['per_page'] = 2;


    if ($this->uri->segment('3') == '') {
      $dari = 0;
    } else {
      $hal = $this->uri->segment('3');
      $dari = ($hal - 1) * $config['per_page'];
    }


    $data['total'] = $jumlah;
    $data['sisa'] = $config['per_page'];
    $data['dari'] = $dari;

    if (is_numeric($dari)) {
      $data['record'] = $this->model_app->view_berita_limit($cari, $dari, $config['per_page']);
    } else {
      redirect();
    }
    $this->pagination->initialize($config);
    $this->template->load('front', 'front/informasi/berita', $data);
  }

  function beritakategori($seo)
  {
    $data = $this->data;
    $data['link'] = 'informasi/beritakategori';

    $data['deskripsi'] = $data['identitas']['deskripsi'];
    $data['keyword'] = $data['identitas']['keyword'];
    $row = $this->model_app->edit('kategori_berita', array('seo' => $seo))->row_array();
    if (isset($_POST['cari'])) {
      $this->session->set_userdata(array('cariberitakat' => postnumber('cari')));
    }
    $cari = $this->session->cariberitakat;
    $data['cari'] = $cari;
    $query = $this->model_app->view_berita_kategori($row['id_kategori'], $cari);
    $jumlah = count($query);
    $config['base_url'] = base_url() . 'informasi/beritakategori/' . $seo;
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $jumlah;
    $config['per_page'] = 6;


    if ($this->uri->segment('4') == '') {
      $dari = 0;
    } else {
      $hal = $this->uri->segment('4');
      $dari = ($hal - 1) * $config['per_page'];
    }


    $data['total'] = $jumlah;
    $data['sisa'] = $config['per_page'];
    $data['dari'] = $dari;

    if (is_numeric($dari)) {
      $data['record'] = $this->model_app->view_berita_kategori_limit($row['id_kategori'], $cari, $dari, $config['per_page']);
    } else {
      redirect();
    }
    $data['title'] = stripcslashes($row['kategori']);
    $data['rows'] = $row;
    $this->pagination->initialize($config);
    $this->template->load('front', 'front/informasi/berita', $data);
  }

  function agenda()
  {
    $data = $this->data;
    $data['link'] = 'informasi/agenda';
    $data['title'] = 'Agenda';
    $data['deskripsi'] = $data['identitas']['deskripsi'];
    $data['keyword'] = $data['identitas']['keyword'];

    if (isset($_POST['cari'])) {
      $this->session->set_userdata(array('cariagenda' => postnumber('cari')));
    }
    $cari = $this->session->cariagenda;
    $data['cari'] = $cari;
    $query = $this->model_app->view_agenda($cari);
    $jumlah = count($query);
    $config['base_url'] = base_url() . 'informasi/agenda';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $jumlah;
    $config['per_page'] = 9;


    if ($this->uri->segment('3') == '') {
      $dari = 0;
    } else {
      $hal = $this->uri->segment('3');
      $dari = ($hal - 1) * $config['per_page'];
    }


    $data['total'] = $jumlah;
    $data['sisa'] = $config['per_page'];
    $data['dari'] = $dari;

    if (is_numeric($dari)) {
      $data['record'] = $this->model_app->view_agenda_limit($cari, $dari, $config['per_page']);
    } else {
      redirect();
    }
    $this->pagination->initialize($config);
    $this->template->load('front', 'front/informasi/agenda', $data);
  }

  function pengumuman()
  {
    $data = $this->data;
    $data['link'] = 'informasi/pengumuman';
    $data['title'] = 'Pengumuman';
    $data['deskripsi'] = $data['identitas']['deskripsi'];
    $data['keyword'] = $data['identitas']['keyword'];

    if (isset($_POST['cari'])) {
      $this->session->set_userdata(array('caripengumuman' => postnumber('cari')));
    }
    $cari = $this->session->caripengumuman;
    $data['cari'] = $cari;
    $query = $this->model_app->view_pengumuman($cari);
    $jumlah = count($query);
    $config['base_url'] = base_url() . 'informasi/pengumuman';
    $config['use_page_numbers'] = TRUE;
    $config['total_rows'] = $jumlah;
    $config['per_page'] = 10;


    if ($this->uri->segment('3') == '') {
      $dari = 0;
    } else {
      $hal = $this->uri->segment('3');
      $dari = ($hal - 1) * $config['per_page'];
    }


    $data['total'] = $jumlah;
    $data['sisa'] = $config['per_page'];
    $data['dari'] = $dari;

    if (is_numeric($dari)) {
      $data['record'] = $this->model_app->view_pengumuman_limit($cari, $dari, $config['per_page']);
    } else {
      redirect();
    }
    $this->pagination->initialize($config);
    $this->template->load('front', 'front/informasi/pengumuman', $data);
  }

  function detail($hal, $seo)
  {
    $data = $this->data;
    $data['link'] = 'informasi/detail';
    if ($hal == 'berita') {
      $row = $this->model_app->beritadetail($seo);
      $id = $row['id_berita'];
      $this->db->query("CALL bacaBerita($id)");
      $isi_berita = (strip_tags($row['isi']));
      $isi = substr($isi_berita, 0, 200);
      $isi = substr($isi_berita, 0, strrpos($isi, " "));
      $data['deskripsi'] = $isi;
      $data['keyword'] = $row['keyword'];
      $data['tags'] = explode(",", $row['keyword']);
      $data['gambar'] = $row['gambar'];
    } else if ($hal == 'agenda') {
      $row = $this->model_app->edit('agenda', array('seo' => $seo))->row_array();
      $id = $row['id_agenda'];
      $this->db->query("CALL bacaAgenda($id)");
      $isi_berita = (strip_tags($row['isi']));
      $isi = substr($isi_berita, 0, 200);
      $isi = substr($isi_berita, 0, strrpos($isi, " "));
      $data['deskripsi'] = $isi;
      $data['keyword'] = $data['identitas']['keyword'];
      $data['gambar'] = $row['gambar'];
    } else if ($hal == 'pengumuman') {
      $row = $this->model_app->edit('pengumuman', array('seo' => $seo))->row_array();
      $id = $row['id_pengumuman'];
      $this->db->query("CALL bacaPengumuman($id)");
      $isi_berita = (strip_tags($row['isi']));
      $isi = substr($isi_berita, 0, 200);
      $isi = substr($isi_berita, 0, strrpos($isi, " "));
      $data['deskripsi'] = $isi;
      $data['keyword'] = $data['identitas']['keyword'];
      $data['gambar'] = '';
    }
    $data['title'] = stripcslashes($row['judul']);

    $data['hal'] = $hal;
    $data['rows'] = $row;
    // Penambahan Funsi terpisah Tanggal
    $data['bln'] =  getBulan(substr($data['rows']['tanggal'], 5, 2));
    $data['tgl'] =  substr($data['rows']['tanggal'], 8, 2);
    $data['tahun'] =  substr($data['rows']['tanggal'],  0, 4);
    $this->template->load('front', 'front/informasi/detail', $data);
  }
} //controller
