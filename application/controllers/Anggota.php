<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once APPPATH . '/third_party/library/Requests.php';
class Anggota extends CI_Controller
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
        $notif = api('api/notifikasi', array("npsn" => $identitas['kode'], "uid" => $identitas['uid']));
        $this->data = array(
            'identitas' => $identitas,
            'id_level' => $this->session->level,
            'notif' => $notif->jumlah,
            'header' => 'Anggota',
            'headers' => array('Content-Type' => 'application/json'),
            'ctrl' => 'anggota'
        );
    }



    function index()
    {
        redirect('dashboard');
    }


    function data()
    {
        $data = $this->data;
        $data['title'] = 'Data Anggota';
        $data['link'] = 'anggota/data';

        if (bisaBaca($data['link'], $data['id_level'])) {
            $this->template->load('admin', 'admin/anggota/data', $data);
        } else {
            redirect('dashboard');
        }
    }

    function datatambah()
    {
        $data = $this->data;
        $data['title'] = 'Form Tambah Data Anggota';
        $data['link'] = 'anggota/data';

        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $nama = posttext('nama_anggota');
                $simpan = array(
                    'no_anggota' => postnumber('no_anggota'),
                    'nama_anggota' => $nama,
                    'jenis_kelamin' => posttext('jenis_kelamin'),
                    'tempat_lahir' => postnumber('tempat_lahir'),
                    'tgl_lahir' => postnumber('tgl_lahir'),
                    'alamat' => postnumber('alamat'),
                    'pekerjaan' => postnumber('pekerjaan'),
                    'agama' => postnumber('agama'),
                    'email' => postnumber('email'),
                    'telp' => postnumber('telp'),
                    'no_identitas' => postnumber('no_identitas'),
                    'tgl_daftar' => postnumber('tgl_daftar')
                );
                if ($this->model_app->insert('tb_anggota', $simpan)) {
                    $this->session->set_flashdata('sukses', 'Data Pengumuman Berhasil Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data Pengumuman Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/anggota/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function dataedit($seo = '')
    {
        $data = $this->data;
        $data['title'] = 'Form Edit Data Anggota';
        $data['link'] = 'anggota/data';

        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $where = array('id_anggota' => postnumber('id'));
                $nama = posttext('nama_anggota');
                $simpan = array(
                    'no_anggota' => postnumber('no_anggota'),
                    'nama_anggota' => $nama,
                    'jenis_kelamin' => postnumber('jenis_kelamin'),
                    'tempat_lahir' => postnumber('tempat_lahir'),
                    'tgl_lahir' => postnumber('tgl_lahir'),
                    'alamat' => postnumber('alamat'),
                    'pekerjaan' => postnumber('pekerjaan'),
                    'agama' => postnumber('agama'),
                    'email' => postnumber('email'),
                    'telp' => postnumber('telp'),
                    'no_identitas' => postnumber('no_identitas'),
                    'tgl_daftar' => postnumber('tgl_daftar')
                );
                if ($this->model_app->update('tb_anggota', $simpan, $where)) {

                    $this->session->set_flashdata('sukses', 'Data Anggota Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data Anggota Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_app->edit('tb_anggota', array('id_anggota' => dekrip($seo)))->row_array();
                $this->template->load('admin', 'admin/anggota/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function get_anggota()
    {
        $data = $this->data;
        $this->load->model('model_anggota');
        $data['link'] = 'anggota/data';
        $where = array();


        $list = $this->model_anggota->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {



            $edit = '';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id_anggota), '');
            }

            $hapus = '';
            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id_anggota), '');
            }
            $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id_anggota), '');


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->no_anggota;
            $row[] = $field->nama_anggota;
            $row[] = $field->jenis_kelamin;
            $row[] = $field->email;
            $row[] = $field->pekerjaan;

            $row[] = $detail . '&nbsp;' . $edit . '&nbsp;' . $hapus;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_anggota->count_all($where),
            "recordsFiltered" => $this->model_anggota->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function datahapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Data Anggota';
        $data['link'] = 'anggota/data';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $hapus = $this->model_app->delete('tb_anggota', array('id_anggota' => dekrip($seo)));
            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => 'Data Anggota Berhasil Dihapus');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => 'Data Anggota Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }
} //controller