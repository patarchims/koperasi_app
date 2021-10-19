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
        $this->load->model('model_layanan');
        $this->load->helper('layanan_helper');
        $identitas = $this->model_app->edit('identitas', array('id' => 1))->row_array();
        $notif = api('api/notifikasi', array("npsn" => $identitas['kode'], "uid" => $identitas['uid']));
        if (isset($_POST['tahun'])) {
            $this->session->set_userdata(array('tahun' => postnumber('tahun')));
        }
        $this->data = array(
            'identitas' => $identitas,
            'id_level' => $this->session->level,
            'ctrl' => 'dashboard',
            'notif' => $notif->jumlah,
            'tahun' => $this->session->tahun,
            'header' => 'Selamat ' . waktuSekarang() . ' : ' . $this->session->nama_user,
            'user' => $this->session->id_user

        );
    }

    function index()
    {
        $data = $this->data;
        $data['link'] = 'dashboard/index';
        $data['title'] = 'Dashboard';
        if (isset($_POST['prosessiswa'])) {
            if (!empty($_FILES['gambar']['name'])) {
                $dir = dirname($_FILES["gambar"]["tmp_name"]);
                $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                rename($_FILES["gambar"]["tmp_name"], $destination);

                $upload = $this->s3_upload->upload_file($destination);
                if ($upload != '') {
                    $simpan = array(
                        'id_tiket' => postnumber('id_tiket'),
                        'pesan' => posttext('pesan'),
                        'id_pengirim' => $data['user'],
                        'pengirim' => 'Admin',
                        'gambar' => $upload['uri'],
                        'gambarkey' => $upload['key']
                    );
                    $this->model_app->insert('siswa_tiket_chat', $simpan);
                    if ($this->db->affected_rows() > 0) {
                        $this->model_app->update('siswa_tiket', array('status' => 1), array('id' => postnumber('id_tiket')));
                        $this->session->set_flashdata('sukses', 'Open Tiket Berhasil Diproses');
                    } else {
                        $this->session->set_flashdata('gagal', 'Open Tiket Gagal Diproses');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'Lampiran Gagal Di Upload');
                }
            } else {
                $simpan = array(
                    'id_tiket' => postnumber('id_tiket'),
                    'pesan' => posttext('pesan'),
                    'id_pengirim' => $data['user'],
                    'pengirim' => 'Admin'
                );
                $this->model_app->insert('siswa_tiket_chat', $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->model_app->update('siswa_tiket', array('status' => 1), array('id' => postnumber('id_tiket')));
                    $this->session->set_flashdata('sukses', 'Open Tiket Berhasil Diproses');
                } else {
                    $this->session->set_flashdata('gagal', 'Open Tiket Gagal Diproses');
                }
            }
            redirect(current_url());
        } else if (isset($_POST['selesaisiswa'])) {

            $simpan = array(
                'status' => 2,
                'informasi' => posttext('informasi'),
                'admin' => $data['user'],
                'selesai_at' => date('Y-m-d H:i:s')
            );
            $this->model_app->update('siswa_tiket', $simpan, array('id' => postnumber('id_tiket')));
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('sukses', 'Open Tiket Berhasil Ditutup');
            } else {
                $this->session->set_flashdata('gagal', 'Open Tiket Gagal Ditutup');
            }

            redirect(current_url());
        } else if (isset($_POST['prosesguru'])) {
            if (!empty($_FILES['gambar']['name'])) {
                $dir = dirname($_FILES["gambar"]["tmp_name"]);
                $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                rename($_FILES["gambar"]["tmp_name"], $destination);

                $upload = $this->s3_upload->upload_file($destination);
                if ($upload != '') {
                    $simpan = array(
                        'id_tiket' => postnumber('id_tiket'),
                        'pesan' => posttext('pesan'),
                        'id_pengirim' => $data['user'],
                        'pengirim' => 'Admin',
                        'gambar' => $upload['uri'],
                        'gambarkey' => $upload['key']
                    );
                    $this->model_app->insert('guru_tiket_chat', $simpan);
                    if ($this->db->affected_rows() > 0) {
                        $this->model_app->update('guru_tiket', array('status' => 1), array('id' => postnumber('id_tiket')));
                        $this->session->set_flashdata('sukses', 'Open Tiket Berhasil Diproses');
                    } else {
                        $this->session->set_flashdata('gagal', 'Open Tiket Gagal Diproses');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'Lampiran Gagal Di Upload');
                }
            } else {
                $simpan = array(
                    'id_tiket' => postnumber('id_tiket'),
                    'pesan' => posttext('pesan'),
                    'id_pengirim' => $data['user'],
                    'pengirim' => 'Admin'
                );
                $this->model_app->insert('guru_tiket_chat', $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->model_app->update('guru_tiket', array('status' => 1), array('id' => postnumber('id_tiket')));
                    $this->session->set_flashdata('sukses', 'Open Tiket Berhasil Diproses');
                } else {
                    $this->session->set_flashdata('gagal', 'Open Tiket Gagal Diproses');
                }
            }
            redirect(current_url());
        } else if (isset($_POST['selesaiguru'])) {

            $simpan = array(
                'status' => 2,
                'informasi' => posttext('informasi'),
                'admin' => $data['user'],
                'selesai_at' => date('Y-m-d H:i:s')
            );
            $this->model_app->update('guru_tiket', $simpan, array('id' => postnumber('id_tiket')));
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('sukses', 'Open Tiket Berhasil Ditutup');
            } else {
                $this->session->set_flashdata('gagal', 'Open Tiket Gagal Ditutup');
            }

            redirect(current_url());
        } else {
            $data['siswabaru'] = $this->model_layanan->tiket_siswa($data['tahun'], 0);
            $data['siswaproses'] = $this->model_layanan->tiket_siswa($data['tahun'], 1);
            $data['siswaselesai'] = $this->model_layanan->tiket_siswa($data['tahun'], 2);
            $data['gurubaru'] = $this->model_layanan->tiket_guru($data['tahun'], 0);
            $data['guruproses'] = $this->model_layanan->tiket_guru($data['tahun'], 1);
            $data['guruselesai'] = $this->model_layanan->tiket_guru($data['tahun'], 2);
            $cek = api('api/permintaan', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid']));
            // $berita=api('api/beritadinas',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid'],'jumlah'=>'5',"halaman"=>"1","cari"=>""));
            if ($cek->action == true) {
                $data['permintaan'] = $cek->jumlah;
                $data['isi'] = $cek->isi;
                $data['hasil'] = $cek->hasil;
                $data['belum'] = $data['permintaan'] - $data['isi'];
                // $data['berita']=$berita->hasil;
            }

            $this->template->load('admin', 'admin/dashboard/data', $data);
        }
    }

    function indexdetail($seo, $jenis = 'siswa')
    {
        $data = $this->data;
        $data['title'] = 'Detail Open Tiket ' . ucfirst($jenis);
        $data['link'] = 'dashboard/index';
        if ($jenis == 'siswa') {
            $table = 'siswa_tiket';
        } else {
            $table = 'guru_tiket';
        }
        $where = array('id' => dekrip($seo));
        $row = $this->model_app->edit($table, $where)->row_array();
        if (isset($_POST['simpan'])) {
            if (!empty($_FILES['gambar']['name'])) {
                $dir = dirname($_FILES["gambar"]["tmp_name"]);
                $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                rename($_FILES["gambar"]["tmp_name"], $destination);

                $upload = $this->s3_upload->upload_file($destination);
                if ($upload != '') {
                    if ($row['gambarkey'] != '') {
                        $this->s3_upload->delete_file($row['gambarkey']);
                    }
                    $simpan = array(
                        'id_tiket' => postnumber('id_tiket'),
                        'pesan' => posttext('pesan'),
                        'id_pengirim' => $data['user'],
                        'pengirim' => 'Admin',
                        'gambar' => $upload['uri'],
                        'gambarkey' => $upload['key']
                    );
                    $this->model_app->insert($table . '_chat', $simpan);
                    if ($this->db->affected_rows() > 0) {
                        $this->session->set_flashdata('sukses', 'Pesan Berhasil Disimpan');
                    } else {
                        $this->session->set_flashdata('gagal', 'Pesan Gagal Disimpan');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'File Gagal Di Upload');
                }
            } else {
                $simpan = array(
                    'id_tiket' => postnumber('id_tiket'),
                    'pesan' => posttext('pesan'),
                    'id_pengirim' => $data['user'],
                    'pengirim' => 'Admin'
                );
                $this->model_app->insert($table . '_chat', $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                }
            }
            redirect(current_url());
        } else {
            $data['rows'] = $row;
            if ($jenis == 'siswa') {
                $table = 'siswa_tiket';
                $data['chat'] = $this->model_layanan->siswa_chat(dekrip($seo));
                $this->template->load('admin', 'admin/dashboard/chat', $data);
            } else {
                $table = 'guru_tiket';
                $data['chat'] = $this->model_layanan->guru_chat(dekrip($seo));
                $this->template->load('admin', 'admin/dashboard/chatguru', $data);
            }
        }
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
