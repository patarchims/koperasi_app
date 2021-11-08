<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once APPPATH . '/third_party/library/Requests.php';
class Laporan extends CI_Controller
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
            'ctrl' => 'laporan'
        );
    }


    function index()
    {
        redirect('dashboard');
    }


    function pinjaman()
    {
        $data = $this->data;
        $data['title'] = 'Transaksi Pinjaman';
        $data['link'] = 'laporan/pinjaman';

        if (bisaBaca($data['link'], $data['id_level'])) {

            if (isset($_POST['cari'])) {

                $where = array(
                    'no_anggota' => postnumber('id_anggota')
                );

                $data['result'] = $this->model_app->view_where('view_pinjaman', $where)->result_array();

                $this->template->load('admin', 'admin/laporan/pinjaman/view_pinjaman', $data);
            }

            $this->template->load('admin', 'admin/laporan/pinjaman/data', $data);
        } else {
            redirect('dashboard');
        }
    }

    function get_pinjaman()
    {
        $data = $this->data;
        $this->load->model('model_view_pinjaman');
        $data['link'] = 'laporan/pinjaman';
        $where = array();


        $list = $this->model_view_pinjaman->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {



            $detail = '';

            $detail = aksiDetail($data['link'] . 'detail', enkrip($field->no_pinjaman), ' Detail');


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->no_pinjaman;
            $row[] = $field->no_anggota;
            $row[] = $field->jlh_pinjam;
            $row[] = $field->nama_anggota;
            $row[] = $field->angsuran;
            $row[] = $field->status;

            $row[] = '&nbsp;' . $detail;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_view_pinjaman->count_all($where),
            "recordsFiltered" => $this->model_view_pinjaman->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }


    function cetakpinjamanall()
    {
        $data = $this->data;
        $data['title'] = 'Laporan Data Pinjaman';
        $data['result'] = $this->model_app->view('tb_pinjaman')->result_array();
        $live_mpdf = new \Mpdf\Mpdf();
        $all_html = $this->load->view('admin/laporan/pinjaman/report_all', $data, true);
        $live_mpdf->WriteHTML($all_html);
        $live_mpdf->Output();
    }
    function cetakangsuranall()
    {
        $data = $this->data;
        $data['title'] = 'Laporan Data Angsuran';
        $data['result'] = $this->model_app->view('tb_angsuran')->result_array();
        $live_mpdf = new \Mpdf\Mpdf();
        $all_html = $this->load->view('admin/laporan/angsuran/report_all', $data, true);
        $live_mpdf->WriteHTML($all_html);
        $live_mpdf->Output();
    }

    function angsuran()
    {
        $data = $this->data;
        $data['title'] = 'Laporan Data Angsuran';
        $data['link'] = 'laporan/angsuran';

        if (bisaBaca($data['link'], $data['id_level'])) {

            if (isset($_POST['cari'])) {

                $data['title'] = 'View Data Angsuran';

                $where = array(
                    'no_anggota' => postnumber('id_anggota')
                );

                $data['result'] = $this->model_app->view_where('view_angsuran', $where)->result_array();

                $this->template->load('admin', 'admin/laporan/angsuran/view_angsuran', $data);
            }

            $this->template->load('admin', 'admin/laporan/angsuran/data', $data);
        } else {
            redirect('dashboard');
        }
    }

    function get_angsuran()
    {
        $data = $this->data;
        $this->load->model('model_view_pinjaman');
        $data['link'] = 'laporan/pinjaman';
        $where = array();


        $list = $this->model_view_pinjaman->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {



            $detail = '';

            $detail = aksiDetail($data['link'] . 'detail', enkrip($field->no_pinjaman), ' Detail');


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->no_pinjaman;
            $row[] = $field->no_anggota;
            $row[] = $field->jlh_pinjam;
            $row[] = $field->nama_anggota;
            $row[] = $field->angsuran;
            $row[] = $field->status;

            $row[] = '&nbsp;' . $detail;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_view_pinjaman->count_all($where),
            "recordsFiltered" => $this->model_view_pinjaman->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
}
