<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
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
    $notif = api('api/notifikasi', array("npsn" => $identitas['kode'], "uid" => $identitas['uid']));
    $this->data = array(
      'identitas' => $identitas,
      'id_level' => $this->session->level,
      'notif' => $notif->jumlah,
      'header' => 'Setting',
      'ctrl' => 'setting'
    );
  }
  function identitas()
  {

    $id_level = $this->session->level;

    $data = $this->data;
    $link = 'setting/identitas';
    $data['header'] = 'Setting';
    $data['id_level'] = $id_level;
    $data['link'] = $link;
    $data['ctrl'] = 'setting';

    if (bisaBaca($link, $id_level)) {

      if (isset($_POST['submit'])) {
        $config['upload_path'] = 'assets/img/';
        $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|swf|PNG';
        $config['max_size'] = '1000'; // kb
        $this->load->library('upload', $config);
        $this->upload->do_upload('gambar');
        $hasil = $this->upload->data();
        if ($hasil['file_name'] == '') {
          $data = array(
            'kode' => $this->input->post('kode'),
            'tingkat' => $this->input->post('tingkat'),
            'instansi' => $this->db->escape_str($this->input->post('instansi')),
            'nama' => $this->db->escape_str($this->input->post('nama')),
            'alamat' => $this->db->escape_str($this->input->post('alamat')),
            'kota' => $this->db->escape_str($this->input->post('kota')),
            'telp' => $this->db->escape_str($this->input->post('telp')),

            'web' => $this->db->escape_str($this->input->post('web')),
            'email' => $this->db->escape_str($this->input->post('email')),
            'fb' => $this->db->escape_str($this->input->post('fb')),
            'tw' => $this->db->escape_str($this->input->post('tw')),


            'yt' => $this->db->escape_str($this->input->post('yt')),
            'footer' => $this->input->post('footer'),
            'deskripsi' => $this->input->post('deskripsi'),
            'keyword' => $this->input->post('keyword')
          );
        } else {
          $data = array(
            'kode' => $this->input->post('kode'),
            'tingkat' => $this->input->post('tingkat'),
            'instansi' => $this->db->escape_str($this->input->post('instansi')),
            'nama' => $this->db->escape_str($this->input->post('nama')),
            'alamat' => $this->db->escape_str($this->input->post('alamat')),
            'kota' => $this->db->escape_str($this->input->post('kota')),
            'telp' => $this->db->escape_str($this->input->post('telp')),

            'web' => $this->db->escape_str($this->input->post('web')),
            'email' => $this->db->escape_str($this->input->post('email')),
            'fb' => $this->db->escape_str($this->input->post('fb')),
            'tw' => $this->db->escape_str($this->input->post('tw')),


            'yt' => $this->db->escape_str($this->input->post('yt')),
            'footer' => $this->input->post('footer'),
            'deskripsi' => $this->input->post('deskripsi'),
            'keyword' => $this->input->post('keyword'),
            'logo' => $hasil['file_name']
          );
        }
        $where = array('id' => $this->input->post('id'));
        if ($this->model_app->update('identitas', $data, $where)) {
          $this->session->set_flashdata('sukses', 'Data Identitas Berhasil di Edit');
        } else {
          $this->session->set_flashdata('sukses', 'Data Identitas Gagal di Edit');
        }

        redirect($link);
      } else {
        $data['title'] = 'Identitas';
        $data['rows'] = $this->model_app->edit('identitas', array('id' => 1))->row_array();

        $this->template->load('admin', 'admin/setting/identitas/data', $data);
      }
    } else {
      $this->session->set_flashdata('gagal', "Maaf, Anda Tidak Berhak Mengakses Menu Ini!!!");
      redirect('home');
    }
  }



  function user()
  {
    $id_level = $this->session->level;

    $data = $this->data;
    $link = 'setting/user';
    $data['header'] = 'Setting';
    $data['id_level'] = $id_level;
    $data['link'] = $link;
    $data['ctrl'] = 'setting';

    if (bisaBaca($link, $id_level)) {
      $data['title'] = 'Data User';
      $data['record'] = $this->model_app->view_where_ordering('user', array('id_user !=' => 1), 'id_user', 'ASC');
      $this->template->load('admin', 'admin/setting/user/view_user', $data);
    } else {
      $this->session->set_flashdata('gagal', "Maaf, Anda Tidak Berhak Mengakses Menu Ini!!!");
      redirect('home');
    }
  }

  function usertambah()
  {

    $id_level = $this->session->level;

    $data = $this->data;
    $link = 'setting/user';
    $data['header'] = 'Setting';
    $data['id_level'] = $id_level;
    $data['link'] = $link;
    $data['ctrl'] = 'setting';

    if (bisaTulis($link, $id_level)) {
      if (isset($_POST['submit'])) {
        $salt = randomSalt();
        $pass = create_hash($this->input->post('password'), $salt);
        $config['upload_path'] = 'assets/img/user/';
        $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|swf|PNG';
        $config['max_size'] = '1000'; // kb
        $this->load->library('upload', $config);
        $this->upload->do_upload('gambar');
        $hasil = $this->upload->data();

        $level = postnumber('level');

        if ($hasil['file_name'] == '') {
          $data = array(
            'nama' => $this->db->escape_str($this->input->post('nama')),
            'email' => $this->input->post('email'),
            'hp' => $this->input->post('hp'),
            'level' => $this->input->post('level'),
            'status' => $this->input->post('status'),
            'username' => $this->input->post('username'),

            'password' => $pass,
            'salt' => $salt
          );
        } else {
          $data = array(
            'nama' => $this->db->escape_str($this->input->post('nama')),
            'email' => $this->input->post('email'),
            'hp' => $this->input->post('hp'),
            'level' => $this->input->post('level'),
            'status' => $this->input->post('status'),
            'username' => $this->input->post('username'),

            'password' => $pass,
            'salt' => $salt,
            'gambar' => $hasil['file_name']
          );
        }

        $this->model_app->insert('user', $data);
        redirect($link);
      } else {
        $data['title'] = 'Form Tambah User';
        $this->template->load('admin', 'admin/setting/user/tambah_user', $data);
      }
    } else {
      $this->session->set_flashdata('gagal', "Maaf, Anda Tidak Berhak Menambah Data!!!");
      redirect('dashboard');
    }
  }

  function useredit()
  {
    $data = $this->data;
    $id_level = $this->session->level;


    $link = 'setting/user';
    $data['header'] = 'Setting';
    $data['id_level'] = $id_level;
    $data['link'] = $link;
    $data['ctrl'] = 'setting';

    if (bisaTulis($link, $id_level)) {
      if (isset($_POST['submit'])) {
        $salt = randomSalt();
        $pass = create_hash($this->input->post('password'), $salt);
        $config['upload_path'] = 'assets/img/user/';
        $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|swf|PNG';
        $config['max_size'] = '1000'; // kb
        $this->load->library('upload', $config);
        $this->upload->do_upload('gambar');
        $hasil = $this->upload->data();
        $level = postnumber('level');

        if ($hasil['file_name'] == '') {
          if ($this->input->post('password') == '') {
            $data = array(
              'nama' => $this->db->escape_str($this->input->post('nama')),
              'email' => $this->input->post('email'),
              'hp' => $this->input->post('hp'),
              'level' => $this->input->post('level'),

              'status' => $this->input->post('status')


            );
          } else {
            $data = array(
              'nama' => $this->db->escape_str($this->input->post('nama')),
              'email' => $this->input->post('email'),
              'hp' => $this->input->post('hp'),
              'level' => $this->input->post('level'),

              'status' => $this->input->post('status'),


              'password' => $pass,
              'salt' => $salt
            );
          }
        } else {
          if ($this->input->post('password') == '') {
            $data = array(
              'nama' => $this->db->escape_str($this->input->post('nama')),
              'email' => $this->input->post('email'),
              'hp' => $this->input->post('hp'),
              'level' => $this->input->post('level'),

              'status' => $this->input->post('status'),


              'gambar' => $hasil['file_name']
            );
          } else {
            $data = array(
              'nama' => $this->db->escape_str($this->input->post('nama')),
              'email' => $this->input->post('email'),
              'hp' => $this->input->post('hp'),
              'level' => $this->input->post('level'),

              'status' => $this->input->post('status'),


              'password' => $pass,
              'salt' => $salt,
              'gambar' => $hasil['file_name']
            );
          }
        }
        $where = array('id_user' => $this->input->post('id'));
        $this->model_app->update('user', $data, $where);
        redirect($link);
      } else {
        $id = dekrip($this->uri->segment(3));
        $data['rows'] = $this->model_app->edit('user', array('id_user' => $id))->row_array();
        $data['title'] = 'Form Edit User';
        $this->template->load('admin', 'admin/setting/user/edit_user', $data);
      }
    } else {
      $this->session->set_flashdata('gagal', "Maaf, Anda Tidak Berhak Mengedit Data!!!");
      redirect('home');
    }
  }

  function userhapus()
  {
    $id_level = $this->session->level;
    $link = 'setting/user';

    if (bisaHapus($link, $id_level)) {
      $where = array('id_user' => dekrip($this->uri->segment(3)));
      $hapus = $this->model_app->delete('user', $where);
      if ($hapus) {
        $this->session->set_flashdata('sukses', "Data User Berhasil Dihapus");
      } else {
        $this->session->set_flashdata('gagal', "Data User Gagal Dihapus");
      }
      redirect($link);
    } else {
      redirect($link);
    }
  }


  function login()
  {
    $data = $this->data;
    $id_level = $this->session->level;
    $link = 'setting/login';
    $data['header'] = 'Website';
    $data['title'] = 'Gambar Login';
    $data['id_level'] = $id_level;
    $data['link'] = $link;
    $data['ctrl'] = 'setting';

    if (bisaBaca($link, $id_level)) {
      if (isset($_POST['tambah'])) {
        $config['upload_path'] = 'assets/img/login-bg/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|JPG|JPEG|PNG|JPEG';
        $config['max_size'] = '1000'; // kb
        $this->load->library('upload', $config);
        $this->upload->do_upload('gambar');
        $hasil = $this->upload->data();

        $data = array(
          'gambar' => $hasil['file_name']
        );


        $simpan = $this->model_app->insert('login', $data);
        if ($simpan) {
          $this->session->set_flashdata('sukses', "Data Gambar Login Berhasil Disimpan");
        } else {
          $this->session->set_flashdata('gagal', "Data Gambar Gagal Disimpan");
        }
        redirect($link);
      } else if (isset($_POST['edit'])) {
        $config['upload_path'] = 'assets/img/login-bg/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|JPG|JPEG|PNG|JPEG';
        $config['max_size'] = '3000'; // kb
        $this->load->library('upload', $config);
        $this->upload->do_upload('gambar');
        $hasil = $this->upload->data();
        $where = array('id' => postnumber('id'));

        $data = array(
          'gambar' => $hasil['file_name']
        );




        $simpan = $this->model_app->update('login', $data, $where);
        if ($simpan) {
          $this->session->set_flashdata('sukses', "Data Gambar Login Diedit");
        } else {
          $this->session->set_flashdata('gagal', "Data Gambar Login Diedit");
        }
        redirect($link);
      } else {



        $data['record'] = $this->model_app->view_ordering('login', 'id', 'ASC');
        $this->template->load('admin', 'admin/setting/login/data', $data);
      }
    } else {
      redirect('dashboard');
    }
  }

  function loginedit()
  {
    if (isset($_POST['rowid'])) {
      $id = $this->input->post('rowid');
      // mengambil data berdasarkan id
      // dan menampilkan data ke dalam form modal bootstrap
      $sql = $this->model_app->edit('login', array('id' => $id))->row_array();

      echo '<input type="hidden" name="id" value="' . $id . '">
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Gambar (1280x720)  </label>
                  <div class="col-sm-9">
                    <input type="file" name="gambar"  class="form-control"  required>
                  </div>
                </div><!-- row -->
                ';
    }
  }

  function loginhapus()
  {
    $id_level = $this->session->level;
    $link = 'setting/login';

    if (bisaHapus($link, $id_level)) {
      $id = array('id' => dekrip($this->uri->segment(3)));
      $foto = $this->model_app->edit('login', $id)->row_array();
      unlink('assets/img/login/' . $foto['gambar']);
      $this->model_app->delete('login', $id);
      $this->session->set_flashdata('sukses', "Data Gambar Login Berhasil Dihapus");
      redirect($link);
    } else {
      $this->session->set_flashdata('gagal', "Anda tidak diizinkan menghapus data Gambar Login");
      redirect($link);
    }
  }

  function surat()
  {
    $data = $this->data;
    $id_level = $this->session->level;
    $link = 'setting/surat';
    $data['title'] = 'Identitas Kop Surat';
    $data['id_level'] = $id_level;
    $data['link'] = $link;
    $data['ctrl'] = 'setting';

    if (bisaBaca($link, $id_level)) {


      if (isset($_POST['upload'])) {
        if (bisaUbah($link, $id_level)) {
          $config['upload_path'] = 'assets/img/';
          $config['allowed_types'] = 'pdf';
          $config['max_size'] = '1000'; // kb
          $this->load->library('upload', $config);
          if (!$this->upload->do_upload('gambar')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('gagal', $error['error']);
          } else {
            $where = array('id' => 1);
            $hasil = $this->upload->data();
            $jenis = postnumber('jenis');
            $simpan = array($jenis => $hasil['file_name']);
            $info = $this->model_app->edit('identitas', $where)->row_array();
            $this->model_app->update('identitas', $simpan, $where);
            if ($this->db->affected_rows() > 0) {
              unlink('assets/img/' . $info[$jenis]);
              $this->session->set_flashdata('sukses', 'Kop surat berhasil di Upload');
            } else {
              $this->session->set_flashdata('gagal', 'Kop Surat Gagal di Upload');
            }
          }


          redirect($link);
        } else {
          redirect($link);
        }
      } else {
        $data['title'] = 'Identitas Kop Surat';
        $data['id_level'] = $id_level;
        $data['link'] = $link;
        $data['ctrl'] = 'setting';
        $data['rows'] = $this->model_app->edit('identitas', array('id' => 1))->row_array();

        $this->template->load('admin', 'admin/setting/surat/data', $data);
      }
    }
  }




  function panduan()
  {
    $data = $this->data;
    $data['title'] = 'Panduan Penggunaan Website';
    $data['link'] = 'setting/panduan';

    if (bisaBaca($data['link'], $data['id_level'])) {


      $row = api('api/panduan', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid']));

      $data['record'] = $row->hasil;

      $this->template->load('admin', 'admin/setting/panduan/data', $data);
    } else {
      redirect('dashboard');
    }
  }
} //controller