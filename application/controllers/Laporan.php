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


                if (isset($_POST['simpan'])) {
                    $id_anggota = postnumber('id_anggota');
                }
            }

            $this->template->load('admin', 'admin/laporan/pinjaman/data', $data);
        } else {
            redirect('dashboard');
        }
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
}
