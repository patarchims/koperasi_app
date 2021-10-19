<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tentangkami extends CI_Controller
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
            'ctrl' => 'tentangkami',
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

    function fasilitas()
    {
        $data = $this->data;
        $data['link'] = 'tentangkami/fasilitas';
        $data['title'] = 'Fasilitas';
        $data['deskripsi'] = $data['identitas']['deskripsi'];
        $data['keyword'] = $data['identitas']['keyword'];

        $data['record'] = $this->model_app->view_ordering('fasilitas', 'rand()', 'asc');
        $this->template->load('front', 'front/tentangkami/fasilitas', $data);
    }


    function detail($hal, $seo)
    {
        $data = $this->data;
        $data['link'] = 'tentangkami/detail';
        if ($hal == 'halaman') {
            $row = $this->model_app->edit('halaman', array('seo' => $seo))->row_array();
            $data['gambar'] = '';
            $id = $row['id_halaman'];
            $this->db->query("CALL bacaHalaman($id)");
        } else if ($hal == 'fasilitas') {
            $row = $this->model_app->edit('fasilitas', array('seo' => $seo))->row_array();
            $data['gambar'] = $row['gambar'];
        } else if ($hal == 'prestasi') {
            $row = $this->model_app->edit('prestasi', array('seo' => $seo))->row_array();
            $data['gambar'] = $row['gambar'];
        } else if ($hal == 'kerjasama') {
            $row = $this->model_app->edit('kerjasama', array('seo' => $seo))->row_array();
            $data['gambar'] = '';
        }
        $data['title'] = stripcslashes($row['judul']);
        $data['deskripsi'] = $data['identitas']['deskripsi'];
        $data['keyword'] = $data['identitas']['keyword'];
        $data['rows'] = $row;
        $data['hal'] = $hal;
        $this->template->load('front', 'front/tentangkami/detail', $data);
    }

    function prestasi()
    {
        $data = $this->data;
        $data['link'] = 'tentangkami/prestasi';
        $data['title'] = 'Prestasi';
        $data['deskripsi'] = $data['identitas']['deskripsi'];
        $data['keyword'] = $data['identitas']['keyword'];

        $this->template->load('front', 'front/tentangkami/prestasi', $data);
    }

    function get_prestasi()
    {
        $data = $this->data;
        $this->load->model('model_prestasi1');
        $data['link'] = 'tentangkami/prestasi';
        $where = array();


        $list = $this->model_prestasi1->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {


            $detail = aksiDetail('tentangkami/detail/prestasi', $field->seo, 'Detail');
            $judul = stripcslashes($field->judul);


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = tgl_view($field->tanggal);
            $row[] = $judul;
            $row[] = stripcslashes($field->nama);
            $row[] = stripcslashes($field->juara);
            $row[] = stripcslashes($field->tingkat);
            $row[] = $detail;


            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_prestasi1->count_all($where),
            "recordsFiltered" => $this->model_prestasi1->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function kerjasama()
    {
        $data = $this->data;
        $data['link'] = 'tentangkami/kerjasama';
        $data['title'] = 'Kerjasama';
        $data['deskripsi'] = $data['identitas']['deskripsi'];
        $data['keyword'] = $data['identitas']['keyword'];

        $this->template->load('front', 'front/tentangkami/kerjasama', $data);
    }

    function get_kerjasama()
    {
        $data = $this->data;
        $this->load->model('model_kerjasama');
        $data['link'] = 'tentangkami/kerjasama';
        $where = array();


        $list = $this->model_kerjasama->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {




            $detail = aksiDetail('tentangkami/detail/kerjasama', $field->seo, 'Detail');
            $judul = stripcslashes($field->judul);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $judul;
            $row[] = stripcslashes($field->jenis);
            $row[] = stripcslashes($field->bidang);
            $row[] = stripcslashes($field->rekanan);
            $row[] = tgl_view($field->tanggal_mulai) . ' s/d ' . tgl_view($field->tanggal_selesai);
            $row[] = $detail;


            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_kerjasama->count_all($where),
            "recordsFiltered" => $this->model_kerjasama->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
} //controller
