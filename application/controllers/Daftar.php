<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar extends CI_Controller
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
        $this->load->helper('ppdb_helper');
        $this->load->model('model_ppdb');
        $identitas = $this->model_app->edit('identitas', array('id' => 1))->row_array();
        $side_bd = api('api/sidebar', array("npsn" => $identitas['kode'], "uid" => $identitas['uid'], 'jumlah' => '6'));

        $this->data = array(
            'identitas' => $identitas,
            'ctrl' => 'home',
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
        $data['deskripsi'] = $data['identitas']['deskripsi'];
        $data['keyword'] = $data['identitas']['keyword'];
        $data['title'] = 'PPDB ' . date('Y');
        $table = 'ppdb_pendaftar';
        if (isset($_POST['daftar'])) {
            $pass = postnumber('password');
            $salt = randomSalt();
            $token = token();
            $password = create_hash($pass, $salt);
            $simpan = array(
                'tahun' => postnumber('tahun'),
                'cara_daftar' => 'Online',
                'nama' => posttext('nama'),
                'tgl_lahir' => postnumber('tgl_lahir'),
                'jk' => postnumber('jk'),
                'nama_ortu' => posttext('nama_ortu'),
                'hp' => postnumber('hp'),
                'email' => posttext('email'),
                'alamat' => posttext('alamat'),
                'nik' => posttext('nik'),
                'id_jurusan' => postnumber('id_jurusan'),
                'password' => $password,
                'salt' => $salt,
                'token' => $token
            );
            $this->model_app->insert($table, $simpan);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('sukses', 'Pendaftaran ' . $data['title'] . ' Berhasil Disimpan');
            } else {
                $this->session->set_flashdata('gagal', 'Pendaftaran ' . $data['title'] . ' Gagal Disimpan');
            }
            redirect('daftar');
        } elseif (isset($_POST['upload'])) {
            if (!empty($_FILES['gambar']['name'])) {
                $where = array('email' => postnumber('email'));
                $password = postnumber('password');
                $info = $this->model_app->edit($table, $where)->row_array();
                if ($info['id'] > 0) {
                    $hash_pass = $info['password'];
                    $salt = $info['salt'];
                    $check = validateLogin($password, $hash_pass, $salt);
                    if ($check == true) {
                        $dir = dirname($_FILES["gambar"]["tmp_name"]);
                        $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                        rename($_FILES["gambar"]["tmp_name"], $destination);

                        $upload = $this->s3_upload->upload_file($destination);
                        if ($upload != '') {
                            if ($info['gambarkey'] != '') {
                                $this->s3_upload->delete_file($info['gambarkey']);
                            }
                            $update = array('gambar' => $upload['uri'], 'gambarkey' => $upload['key']);
                            $this->model_app->update($table, $update, $where);
                            $this->session->set_flashdata('sukses', 'File Berhasil Diupload');
                        } else {
                            $this->session->set_flashdata('gagal', 'File Gagal Diupload');
                        }
                    } else {
                        $this->session->set_flashdata('gagal', 'Email atau Password Salah');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'Email Belum Terdaftar');
                }
            } else {
                $this->session->set_flashdata('gagal', 'File Masih Kosong');
            }
            redirect('daftar');
        } else {
            $data['rows'] = $this->model_app->edit('ppdb_ta', array('tahun' => date('Y')))->row_array();
            $this->template->load('front', 'front/daftar/data', $data);
        }
    }
} //controller
