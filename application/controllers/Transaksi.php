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


    function get_data_pinjam()
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
            $row[] = $field->no_pinjaman;
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
        $data['tgl_now'] =  date('Y-m-d');


        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $anggota = postnumber('id_anggota');
                $status = statusAnggota($anggota);
                $bunga = postnumber('bunga');
                $tenor =  postnumber('tenor');
                $jlhPinjaman = posttext('jlh_pinjam');
                $total = $bunga * $jlhPinjaman / 100;
                $angsuran =  $total / $tenor;
                $now =  date('YmdHis');

                if ($status == 'Open') {
                    redirect('transaksi/pinjampesan');
                } else {
                    $simpan = array(
                        'id_anggota' => $anggota,
                        'no_pinjaman' => 'P-' . $now,
                        'jlh_pinjam' => $jlhPinjaman,
                        'bunga' => $bunga,
                        'tenor' => $tenor,
                        'sisa_tenor' => $tenor,
                        'administrasi' => postnumber('administrasi'),
                        'keterangan' => postnumber('keterangan'),
                        'tgl_pinjam' => $data['tgl_now'],
                        'angsuran' => $angsuran,
                        'total' => $total,
                        'status' => 'Open'
                    );
                    if ($this->model_app->insert('tb_pinjaman', $simpan)) {
                        $idPinjaman = idPinjaman($anggota);
                        $data['result'] = viewPinjaman($idPinjaman);
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


    function angsuran()
    {
        $data = $this->data;
        $data['title'] = 'Transaksi Angsuran';
        $data['link'] = 'transaksi/angsuran';

        if (isset($_POST['cari'])) {
            $data['no_pinjaman'] = $_POST['no_angsuran'];
            $data['result'] = $this->model_app->view_pinjaman($data['no_pinjaman']);
            if ($data['result'] == null) {
                $this->template->load('admin', 'admin/transaksi/angsuran/angsuran-dana-notfound', $data);
            } else if ($data['result']['status'] == 'Open') {
                $data['angsuran_ke'] = hitungAngsuran($data['result']['no_pinjaman']);


                // Cari Tanggal Jatuh Tempo
                $pinjaman = $data['no_pinjaman'];
                $data['tgl_jatuh_tempo'] =  tglJatuhTempo($data['result']['tgl_pinjam'], $pinjaman);
                $data['tgl_telat'] = hitungHariTelat($data['tgl_jatuh_tempo']);
                $data['denda'] =  hitungDenda($data['tgl_jatuh_tempo'], $data['result']['angsuran']);
                $data['total_bayar'] = $data['denda'] + $data['result']['angsuran'];
                $this->template->load('admin', 'admin/transaksi/angsuran/angsuran-bayar', $data);
            } elseif ($data['result']['status']  == 'Lunas') {
                $this->template->load('admin', 'admin/transaksi/angsuran/angsuran-infolunas', $data);
            } else {
                $this->template->load('admin', 'admin/transaksi/angsuran/angsuran-dana-notfound', $data);
            }
        } elseif (isset($_POST['bayar'])) {
            $anggota = postnumber('id_anggota');
            $denda = postnumber('denda');
            $no_pinjaman =  posttext('no_pinjaman');
            $now =  date('YmdHis');
            $no_angsuran = 'AG- ' . $now;
            $tanggal = date('Y-m-d');
            $angsuran_ke = postnumber('angsuran_ke');
            $tenor = postnumber('tenor');
            $simpan = array(
                'no_pinjaman' =>  $no_pinjaman,
                'no_angsuran' => $no_angsuran,
                'id_anggota' => $anggota,
                'denda' => $denda,
                'angsuran_ke' => $angsuran_ke,
                'keterangan' => postnumber('keterangan'),
                'jlh_bayar' => postnumber('jlh_bayar'),
                'tanggal' => $tanggal,
                'tgl_jatuh_tempo' => postnumber('jth_tempo'),
                'hari_telat' => postnumber('hari_telat')
            );

            if ($this->model_app->insert('tb_angsuran', $simpan)) {
                // KETIKA DILAKUKAN SIMPAN, KURANGI SISA TENOR:
                $sisa_tenor = $tenor - $angsuran_ke;
                $where = array('no_pinjaman' => $no_pinjaman);

                if ($tenor == $angsuran_ke) {
                    $simpan = array(
                        'status' => 'Lunas',
                        'sisa_tenor' =>  (int)$sisa_tenor,
                    );
                } else {
                    $simpan = array(
                        'sisa_tenor' =>  (int)$sisa_tenor,
                    );
                }

                $this->model_app->update('tb_pinjaman', $simpan, $where);
                $data['result'] = $this->model_app->view_where('tb_angsuran', array('no_angsuran' => $no_angsuran, 'id_anggota' => $anggota))->row_array();

                $this->template->load('admin', 'admin/transaksi/angsuran/angsuran-sukses', $data);
            } else {
                $this->session->set_flashdata('gagal', 'Data Pinjaman Gagal Disimpan');
                redirect($data['link']);
            }
        } else {
            $this->template->load('admin', 'admin/transaksi/angsuran/cari-angsuran', $data);
        }
    }

    function cetak_pinjaman($id)
    {

        $data = $this->data;
        $data['title'] = 'Bukti Pinjaman';
        $data['link'] = 'transaksi/pinjam';
        $where = array('no_pinjaman' => $id);

        $data['result'] = $this->model_app->view_where('tb_pinjaman', $where)->row_array();

        $live_mpdf = new \Mpdf\Mpdf();
        $all_html = $this->load->view('admin/transaksi/pinjam/report_bukti_pinjam', $data, true);
        $live_mpdf->WriteHTML($all_html);
        $live_mpdf->Output();
    }

    function cetak_angsuran($id)
    {
        $data = $this->data;
        $data['title'] = 'Bukti Pinjaman';
        $data['link'] = 'transaksi/pinjam';
        $where = array('id_angsuran' => $id);

        $data['result'] = $this->model_app->view_where('tb_angsuran', $where)->row_array();
        $live_mpdf = new \Mpdf\Mpdf();
        $all_html = $this->load->view('admin/transaksi/angsuran/report_bukti_angsuran', $data, true);
        $live_mpdf->WriteHTML($all_html);
        $live_mpdf->Output();
    }

    function bukti_angsuran($id)
    {
        $data = $this->data;
        $data['title'] = 'Bukti Pinjaman';
        $data['link'] = 'transaksi/pinjam';
        $where = array('id_angsuran' => $id);

        $data['result'] = $this->model_app->view_where('view_angsuran', $where)->row_array();
        $live_mpdf = new \Mpdf\Mpdf();
        $all_html = $this->load->view('admin/transaksi/angsuran/bukti_angsuran', $data, true);
        $live_mpdf->WriteHTML($all_html);
        $live_mpdf->Output();
    }

    function get_pinjaman()
    {
        $data = $this->data;
        $this->load->model('model_view_pinjaman');
        $data['link'] = 'transaksi/pinjaman';
        $where = array();


        $list = $this->model_view_pinjaman->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->no_pinjaman;
            $row[] = $field->no_anggota;
            $row[] = 'IDR. ' . rupiah($field->jlh_pinjam);
            $row[] = $field->nama_anggota;
            $row[] = 'IDR. ' .  rupiah($field->angsuran);
            $row[] = $field->status;

            // $row[] = '&nbsp;' . $detail;
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
} //controller