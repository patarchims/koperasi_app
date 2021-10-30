<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once APPPATH . '/third_party/library/Requests.php';
class Transaksi extends CI_Controller
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
        Requests::register_autoloader();
        $identitas = $this->model_app->edit('identitas', array('id' => 1))->row_array();
        $this->data = array(
            'identitas' => $identitas,
            'id_level' => $this->session->level,
            'header' => 'Transaksi',
            'headers' => array('Content-Type' => 'application/json'),
            'ctrl' => 'transaksi'
        );
    }



    function index()
    {
        redirect('dashboard');
    }


    function pinjam()
    {
        $data = $this->data;
        $data['title'] = 'Transaksi Pinjaman';
        $data['link'] = 'transaksi/pinjam';

        if (bisaBaca($data['link'], $data['id_level'])) {
            $this->template->load('admin', 'admin/transaksi/pinjam/data', $data);
        } else {
            redirect('dashboard');
        }
    }


    function get_dataPinjam()
    {

        $data = $this->data;
        $this->load->model('model_pinjam');
        $data['link'] = 'traksaksi/pinjam';
        $where = array();


        $list = $this->model_pinjam->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {

            $edit = '';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id_pinjaman), '');
            }

            $hapus = '';
            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id_pinjaman), '');
            }
            $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id_pinjaman), '');


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nama_anggota;
            $row[] = $field->jlh_pinjam;
            $row[] = $field->bunga . ' %';
            $row[] = $field->tenor . ' Bulan';
            $row[] = 'test';

            $row[] = $detail . '&nbsp;' . $edit . '&nbsp;' . $hapus;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_pinjam->count_all($where),
            "recordsFiltered" => $this->model_pinjam->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function pinjamtambah()
    {
        $data = $this->data;
        $data['title'] = 'Form Tambah Data Pinjaman';
        $data['link'] = 'transaksi/pinjam';
        $data['subTitle'] = 'Data Pinjaman';


        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $anggota = postnumber('id_anggota');
                $status = statusAnggota($anggota);
                $bunga = postnumber('bunga');
                $tenor =  postnumber('tenor');
                $jlhPinjaman = posttext('jlh_pinjam');
                $total = $bunga * $jlhPinjaman / 100;
                $angsuran =  $total / $tenor;

                if ($status == 'Open') {
                    redirect('transaksi/pinjampesan');
                    // redirect('transaksi/pinjampesan');
                    // $this->template->load('admin', 'admin/transaksi/pinjam/pesan', $data);
                } else {
                    $simpan = array(
                        'id_anggota' => $anggota,
                        'jlh_pinjam' => $jlhPinjaman,
                        'bunga' => $bunga,
                        'tenor' => $tenor,
                        'administrasi' => postnumber('administrasi'),
                        'keterangan' => postnumber('keterangan'),
                        'tgl_pinjam' => postnumber('tgl_pinjam'),
                        'tgl_tempo' => postnumber('tgl_tempo'),
                        'angsuran' => $angsuran,
                        'total' => $total,
                        'status' => 'Open'
                    );
                    if ($this->model_app->insert('tb_pinjaman', $simpan)) {
                        // TAMPILKAN DALAM BENTUK SEBUAH LAPORAN :
                        // DAPATKAN ID PINJAMAN TERBARU BERDASARKAN ANGGOTA ID
                        $idPinjaman = idPinjaman($anggota);
                        $data['result'] = viewPinjaman($idPinjaman);
                        // $this->session->set_flashdata('sukses', 'Data Pinjaman Berhasil Berhasil Disimpan');
                        $this->template->load('admin', 'admin/transaksi/pinjam/pinjam-dana', $data);
                    } else {
                        $this->session->set_flashdata('gagal', 'Data Pinjaman Gagal Disimpan');
                        redirect($data['link']);
                    }
                }




                // redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/transaksi/pinjam/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function pinjampesan()
    {
        $data = $this->data;
        $data['title'] = 'Transaksi Pinjaman';
        $data['link'] = 'transaksi/pinjam';

        $this->template->load('admin', 'admin/transaksi/pinjam/pesan', $data);
    }

    function hasilpinjam($transaksi)
    {
        $data = $this->data;
        $data['title'] = 'Transaksi Pinjaman';
        $data['link'] = 'transaksi/pinjam';

        $this->template->load('admin', 'admin/transaksi/pinjam/pinjam-dana', $data);
    }
} //controller