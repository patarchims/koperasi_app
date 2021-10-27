<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
        $this->data = array(
            'identitas' => $identitas,
            'id_level' => $this->session->level,
            'ctrl' => 'dashboard',
            'header' => 'Selamat ' . waktuSekarang() . ' : ' . $this->session->nama_user,


        );
    }

    function index()
    {
        $data = $this->data;
        $data['link'] = 'dashboard/index';
        $data['title'] = 'Dashboard';

        $this->template->load('admin', 'admin/dashboard/data', $data);
    }


    function profil()
    {
        $data = $this->data;
        $data['title'] = 'Profil';
        $data['link'] = 'dashboard';
        $data['ctrl'] = 'dashboard';
        $user = $this->session->id_user;
        if (isset($_POST['ganti'])) {
            $where = array('id_user' => $user);

            $config['upload_path'] = 'assets/img/user/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|swf|PNG|jpeg';
            $config['max_size'] = '2000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('gambar');
            $hasil = $this->upload->data();
            $gambar = $hasil['file_name'];

            $upsk = array('gambar' => $gambar);
            $this->model_app->update('user', $upsk, $where);
            $this->session->set_userdata(array('foto_user' => $gambar));



            redirect('dashboard/profil');
        } else {

            $data['rows'] = $this->model_app->edit('user', array('id_user' => $user))->row_array();
            $this->template->load('admin', 'admin/dashboard/profil', $data);
        }
    }

    function editprofil()
    {
        $data = $this->data;
        $data['title'] = 'Edit Profil';
        $data['link'] = 'dashboard';
        $data['ctrl'] = 'dashboard';
        $user = $this->session->id_user;
        if (isset($_POST['edit'])) {
            $where = array('id_user' => $user);

            $config['upload_path'] = 'assets/img/user/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|swf|PNG|jpeg';
            $config['max_size'] = '2000'; // kb
            $this->load->library('upload', $config);
            $this->upload->do_upload('gambar');
            $hasil = $this->upload->data();
            $gambar = $hasil['file_name'];
            $simpan = array(
                'nama' => $this->db->escape_str($this->input->post('nama')),
                'email' => $this->db->escape_str($this->input->post('email')),
                'hp' => $this->input->post('hp')
            );
            $this->model_app->update('user', $simpan, $where);

            if ($gambar != '') {
                $upsk = array('gambar' => $gambar);
                $this->model_app->update('user', $upsk, $where);
                $this->session->set_userdata(array('foto_user' => $gambar));
            }


            redirect('dashboard/profil');
        } else {
            $data['rows'] = $this->model_app->edit('user', array('id_user' => $user))->row_array();
            $this->template->load('admin', 'admin/dashboard/editprofil', $data);
        }
    }

    function gantipassword()
    {
        $data = $this->data;
        $data['title'] = 'Ganti Password';

        $data['link'] = 'dashboard';

        $user = $this->session->id_user;
        if (isset($_POST['edit'])) {
            $password = $this->db->escape_str($this->input->post('pass'));
            $pass1 = $this->db->escape_str($this->input->post('pass1'));
            $pass2 = $this->db->escape_str($this->input->post('pass2'));


            $cek = $this->model_app->view_where('user', array('id_user' => $user));

            foreach ($cek->result_array() as $r) {
                $hash_pass = $r['password'];
                $salt = $r['salt'];
            }
            $check = validateLogin($password, $hash_pass, $salt);
            if ($check == true) {

                if ($pass1 == $pass2) {
                    $salt1 = randomSalt();
                    $passbaru = create_hash($pass1, $salt1);
                    $data = array(
                        'password' => $passbaru,
                        'salt' => $salt1,
                        'token' => token()
                    );
                    $where = array('id_user' => $user);

                    $this->model_app->update('user', $data, $where);

                    echo "<script type=\"text/javascript\">window.alert('Password Berhasil di Ganti, Silahkan Login Kembali');window.location.href = '" . base_url('admin/logout') . "';</script>";
                } else {
                    echo "<script type=\"text/javascript\">window.alert('Password Baru Tidak Sama');
            window.location.href = '" . base_url() . "dashboard/gantipassword';</script>";
                }
            } else {
                echo "<script type=\"text/javascript\">window.alert('Password Lama Salah');
            window.location.href = '" . base_url() . "dashboard/gantipassword';</script>";
            }
        } else {
            $data['rows'] = $this->model_app->edit('user', array('id_user' => $user))->row_array();
            $this->template->load('admin', 'admin/dashboard/gantipassword', $data);
        }
    }
} //controller
