<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once APPPATH . '/third_party/library/Requests.php';
class Siswa extends CI_Controller
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
        if ($this->session->login != true or $this->session->id_siswa < 1) {
            redirect('login/logout');
        }
        $this->load->model('model_layanan');
        $this->load->helper('layanan_helper');
        Requests::register_autoloader();
        $identitas = $this->model_app->edit('identitas', array('id' => 1))->row_array();
        if (isset($_POST['tahun'])) {
            $this->session->set_userdata(array('tahun' => postnumber('tahun')));
        }
        $this->data = array(
            'identitas' => $identitas,
            'tabs' => menusiswa(),
            'headers' => array('Content-Type' => 'application/json'),
            'user' => $this->session->id_siswa,
            'tahun' => $this->session->tahun

        );
    }

    function index()
    {
        $data = $this->data;
        $data['header'] = 'Selamat ' . waktuSekarang() . ' : ' . $this->session->nama_user;
        $data['ctrl'] = 'dashboard';
        $data['link'] = 'dashboard';
        $data['title'] = 'Dashboard';


        $this->template->load('siswa', 'siswa/dashboard/data', $data);
    }

    function profil()
    {
        $data = $this->data;
        $data['header'] = 'Profil ' . $this->session->nama_user;
        $data['title'] = 'Profil';
        $data['link'] = 'siswa/profil';
        $data['ctrl'] = 'profil';


        $data['rows'] = $this->model_app->edit('siswa', array('id_siswa' => $data['user']))->row_array();
        $this->template->load('siswa', 'siswa/profil/data', $data);
    }

    function profiledit()
    {
        $data = $this->data;
        $data['header'] = 'Profil ' . $this->session->nama_user;
        $data['title'] = 'Edit Profil';
        $data['link'] = 'siswa/profil';
        $data['ctrl'] = 'profil';
        if (isset($_POST['simpan'])) {
            $where = array('id_siswa' => $data['user']);


            $simpan = array(
                'nama' => posttext('nama'),
                'pendidikan' => postnumber('pendidikan'),
                'hp' => postnumber('hp'),
                'email' => posttext('email'),
                'alamat' => posttext('alamat'),
                'alumni' => posttext('alumni'),
                'jk' => postnumber('jk'),
                'nip' => posttext('nip'),
                'agama' => postnumber('agama'),
                'gol' => postnumber('gol'),
                'mod_at' => date('Y-m-d')
            );
            $this->model_app->update('siswa', $simpan, $where);

            $this->session->set_flashdata('sukses', 'Selamat Profil Anda Berhasil Disimpan');
            redirect($data['link']);
        } else {
            $data['rows'] = $this->model_app->edit('siswa', array('id_siswa' => $data['user']))->row_array();
            $this->template->load('siswa', 'siswa/profil/edit', $data);
        }
    }

    function gantipassword()
    {
        $data = $this->data;
        $data['header'] = 'Selamat ' . waktuSekarang() . ' : ' . $this->session->nama_user;
        $data['ctrl'] = 'dashboard';
        $data['link'] = 'siswa/gantipassword';
        $data['title'] = 'Ganti Password';
        if (isset($_POST['simpan'])) {
            $password = $this->db->escape_str($this->input->post('pass'));
            $pass1 = $this->db->escape_str($this->input->post('pass1'));
            $pass2 = $this->db->escape_str($this->input->post('pass2'));


            $cek = $this->model_app->view_where('siswa', array('id_siswa' => $data['user']));

            foreach ($cek->result_array() as $r) {
                $hash_pass = $r['password'];
                $salt = $r['salt'];
            }
            $check = validateLogin($password, $hash_pass, $salt);
            if ($check == true) {
                if ($pass1 == $pass2) {
                    $salt1 = randomSalt();
                    $passbaru = create_hash($pass1, $salt1);
                    $token = token();
                    $simpan = array(
                        'password' => $passbaru,
                        'salt' => $salt1,
                        'token' => $token,
                    );
                    $where = array('id_siswa' => $data['user']);
                    $hasil = array('uid' => $data['identitas']['uid'], 'npsn' => $data['identitas']['kode'], 'password' => $passbaru, 'token' => $token, 'salt' => $salt1, 'id_siswa' => $data['user']);
                    $response = Requests::post($data['identitas']['api'] . 'api/siswapassword', $data['headers'], json_encode($hasil));
                    $has = json_decode($response->body, true);
                    if ($has['action'] == true) {
                        if ($has['hasil'] == 'success') {
                            $this->model_app->update('siswa', $simpan, $where);
                            $this->session->set_flashdata('sukses', 'Password Berhasil Diganti');
                            redirect('siswa');
                            // echo "<script type=\"text/javascript\">window.alert('Password Berhasil di Ganti, Silahkan Login Kembali');window.location.href = '" . base_url('login/logout') . "';</script>";
                        } else {
                            $this->session->set_flashdata('gagal', 'Password Gagal Diganti');
                        }
                    } else {
                        $this->session->set_flashdata('gagal', 'Gagal Koneksi Ke Server Pusat');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'Password Baru Tidak Sama');
                }
            } else {
                $this->session->set_flashdata('gagal', 'Password Lama Salah');
            }
            redirect('siswa/gantipassword');
        } else {
            $data['rows'] = $this->model_app->edit('user', array('id_user' => $data['user']))->row_array();
            $this->template->load('siswa', 'siswa/dashboard/gantipassword', $data);
        }
    }

    function suratketerangan()
    {
        $data = $this->data;
        $data['header'] = 'Layanan';
        $data['title'] = 'Surat Keterangan';
        $data['link'] = 'siswa/suratketerangan';
        $data['ctrl'] = 'layanan';
        $data['record'] = $this->model_layanan->layanan03siswa($data['tahun'], $data['user']);
        $this->template->load('siswa', 'siswa/layanan/suratketerangan', $data);
    }

    function skbb()
    {
        $data = $this->data;
        $data['header'] = 'Layanan';
        $data['title'] = 'Surat Keterangan Berkelakuan Baik';
        $data['link'] = 'siswa/skbb';
        $data['ctrl'] = 'layanan';
        $data['record'] = $this->model_layanan->layanan04siswa($data['tahun'], $data['user']);
        $this->template->load('siswa', 'siswa/layanan/skbb', $data);
    }

    function opentiket()
    {
        $data = $this->data;
        $data['header'] = 'Layanan';
        $data['title'] = 'Open Tiket';
        $data['link'] = 'siswa/opentiket';
        $data['ctrl'] = 'layanan';
        $data['record'] = $this->model_layanan->opentiketsiswa($data['tahun'], $data['user']);
        $this->template->load('siswa', 'siswa/layanan/opentiket', $data);
    }

    function opentikettambah()
    {
        $data = $this->data;
        $data['header'] = 'Layanan';
        $data['title'] = 'Open Tiket';
        $data['link'] = 'siswa/opentiket';
        $data['ctrl'] = 'layanan';
        $table = 'siswa_tiket';
        if (isset($_POST['simpan'])) {


            if (!empty($_FILES['gambar']['name'])) {
                $dir = dirname($_FILES["gambar"]["tmp_name"]);
                $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                rename($_FILES["gambar"]["tmp_name"], $destination);

                $upload = $this->s3_upload->upload_file($destination);
                if ($upload != '') {
                    $simpan = array(
                        'id_siswa' => $data['user'],
                        'tanggal' => postnumber('tanggal'),
                        'hal' => posttext('tanggal'),
                        'isi' => posttext('isi'),
                        'gambar' => $upload['uri'],
                        'gambarkey' => $upload['key']
                    );
                    $this->model_app->insert($table, $simpan);
                    if ($this->db->affected_rows() > 0) {
                        $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                    } else {
                        $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'File Gagal Di Upload');
                }
            } else {
                $simpan = array(
                    'id_siswa' => $data['user'],
                    'tanggal' => postnumber('tanggal'),
                    'hal' => posttext('hal'),
                    'isi' => posttext('isi')
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                }
            }
            redirect($data['link']);
        } else {
            $this->template->load('siswa', 'siswa/layanan/opentikettambah', $data);
        }
    }

    function opentiketedit($seo)
    {
        $data = $this->data;
        $data['header'] = 'Layanan';
        $data['title'] = 'Open Tiket';
        $data['link'] = 'siswa/opentiket';
        $data['ctrl'] = 'layanan';
        $table = 'siswa_tiket';
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
                        'hal' => posttext('hal'),
                        'isi' => posttext('isi'),
                        'gambar' => $upload['uri'],
                        'gambarkey' => $upload['key']
                    );
                    $this->model_app->update($table, $simpan, $where);
                    if ($this->db->affected_rows() > 0) {
                        $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                    } else {
                        $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'File Gagal Di Upload');
                }
            } else {
                $simpan = array(
                    'hal' => posttext('hal'),
                    'isi' => posttext('isi')
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                }
            }
            redirect($data['link']);
        } else {
            $data['rows'] = $row;
            $this->template->load('siswa', 'siswa/layanan/opentiketedit', $data);
        }
    }

    function opentikethapus($seo)
    {
        $data = $this->data;
        $data['header'] = 'Layanan';
        $data['title'] = 'Open Tiket';
        $data['link'] = 'siswa/opentiket';
        $data['ctrl'] = 'layanan';
        $table = 'siswa_tiket';
        $where = array('id' => dekrip($seo));
        $row = $this->model_app->edit($table, $where)->row_array();
        $this->model_app->delete($table, $where);
        if ($this->db->affected_rows() > 0) {
            if ($row['gambarkey'] != '')
                $this->s3_upload->delete_file($row['gambarkey']);
            $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Dihapus');
        }
        redirect($data['link']);
    }

    function opentiketdetail($seo)
    {
        $data = $this->data;
        $data['header'] = 'Layanan';
        $data['title'] = 'Open Tiket';
        $data['link'] = 'siswa/opentiket';
        $data['ctrl'] = 'layanan';
        $table = 'siswa_tiket';
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
                        'pengirim' => 'Siswa',
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
                    'pengirim' => 'Siswa'
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
            $data['chat'] = $this->model_layanan->siswa_chat(dekrip($seo));
            $this->template->load('siswa', 'siswa/layanan/opentiketdetail', $data);
        }
    }
} //controller
