<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once APPPATH . '/third_party/library/Requests.php';
class Master extends CI_Controller
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
            'header' => 'Master Data',
            'headers' => array('Content-Type' => 'application/json'),
            'ctrl' => 'master'
        );
    }
    function index()
    {
        redirect('dashboard');
    }

    function cari($jenis)
    {
        $this->session->set_userdata(array('jenis' => $jenis));
        redirect('master/guru');
    }

    function guru()
    {
        $data = $this->data;
        $data['title'] = 'Data Guru dan Pegawai';
        $data['link'] = 'master/guru';

        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['jenis'])) {
                $this->session->set_userdata(array('jenis' => postnumber('jenis')));
            }
            $data['jenis'] = $this->session->jenis;
            $this->template->load('admin', 'admin/master/guru/data', $data);
        } else {
            redirect('dashboard');
        }
    }

    // function gurutambah(){
    //     $data=$this->data;
    //     $data['title']='Form Tambah Data Guru dan Pegawai';
    //     $data['link']='master/guru';

    //     if(bisaTulis($data['link'],$data['id_level']))
    //     {
    //         if(isset($_POST['simpan']))
    //         {
    //             $hp=postnumber('hp');
    //             $salt=randomSalt();
    //             $token=token();
    //             $password=create_hash($hp,$salt);
    //             $simpan=array('jenis'=>postnumber('jenis'),
    //                           'nama'=>posttext('nama'),
    //                           'pendidikan'=>postnumber('pendidikan'),
    //                           'hp'=>postnumber('hp'),
    //                           'email'=>posttext('email'),
    //                           'alamat'=>posttext('alamat'),
    //                           'alumni'=>posttext('alumni'),
    //                           'jk'=>postnumber('jk'),
    //                           'nip'=>posttext('nip'),
    //                           'agama'=>postnumber('agama'),
    //                           'gol'=>postnumber('gol'),
    //                           'status'=>postnumber('status'),
    //                           'id_jabatan'=>postnumber('jabatan'),
    //                           'password'=>$password,
    //                           'salt'=>$salt,
    //                           'token'=>$token,
    //                           'input_user'=>$this->session->id_user
    //                          );
    //             if($this->model_app->insert('guru',$simpan))
    //             {
    //                 $id=$this->db->insert_id();

    //                 if (!empty($_FILES['gambar']['name']))
    //                 {

    //                       $dir = dirname($_FILES["gambar"]["tmp_name"]);
    //                       $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
    //                       rename($_FILES["gambar"]["tmp_name"], $destination);

    //                       $upload = $this->s3_upload->upload_file($destination);
    //                       if($upload!='')
    //                       {

    //                         $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
    //                         $where=array('id_guru'=>$id);
    //                         $this->model_app->update('guru',$update,$where);
    //                         $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan');
    //                       }
    //                       else
    //                       {
    //                         $this->session->set_flashdata('gagal','Data Guru Berhasil Disimpan Tapi Foto Gagal Di Upload');
    //                       }


    //                 }
    //                 else
    //                 {
    //                     $this->session->set_flashdata('sukses','Data Guru Berhasil Disimpan dan Anda Tidak Mengupload Foto');
    //                 }
    //             }
    //             else
    //             {
    //                 $this->session->set_flashdata('gagal','Data Guru Gagal Disimpan');
    //             }
    //             redirect($data['link']);
    //         }
    //         else
    //         {
    //         $this->template->load('admin','admin/master/guru/tambah',$data);
    //         }

    //     }
    //     else
    //     {
    //         redirect('dashboard');
    //     }
    // }

    // function guruedit($seo=''){
    //     $data=$this->data;
    //     $data['title']='Form Edit Data Guru dan Pegawai';
    //     $data['link']='master/guru';

    //     if(bisaUbah($data['link'],$data['id_level']))
    //     {
    //         if(isset($_POST['simpan']))
    //         {
    //             $where=array('id_guru'=>postnumber('id'));
    //             $simpan=array('jenis'=>postnumber('jenis'),
    //                           'nama'=>posttext('nama'),
    //                           'pendidikan'=>postnumber('pendidikan'),
    //                           'hp'=>postnumber('hp'),
    //                           'email'=>posttext('email'),
    //                           'alamat'=>posttext('alamat'),
    //                           'alumni'=>posttext('alumni'),
    //                           'jk'=>postnumber('jk'),
    //                           'nip'=>posttext('nip'),
    //                           'agama'=>postnumber('agama'),
    //                           'gol'=>postnumber('gol'),
    //                           'status'=>postnumber('status'),
    //                           'id_jabatan'=>postnumber('jabatan'),
    //                           'mod_at'=>date('Y-m-d'),
    //                           'mod_user'=>$this->session->id_user
    //                          );
    //             if($this->model_app->update('guru',$simpan,$where))
    //             {
    //                 if (!empty($_FILES['gambar']['name']))
    //                 {

    //                       $dir = dirname($_FILES["gambar"]["tmp_name"]);
    //                       $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
    //                       rename($_FILES["gambar"]["tmp_name"], $destination);

    //                       $upload = $this->s3_upload->upload_file($destination);
    //                      // var_dump($upload);

    //                       if($upload!='')
    //                       {

    //                         $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
    //                         $this->model_app->update('guru',$update,$where);
    //                         $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan');
    //                       }
    //                       else
    //                       {

    //                         $this->session->set_flashdata('gagal',' Data Guru Berhasil Disimpan Tapi Foto Gagal Di Upload');
    //                       }


    //                 }
    //                 else
    //                 {
    //                     $this->session->set_flashdata('sukses','Data Guru Berhasil Disimpan');
    //                 }
    //             }
    //             else
    //             {
    //                 $this->session->set_flashdata('gagal','Data Guru Gagal Disimpan');
    //             }
    //             redirect($data['link']);
    //         }
    //         else
    //         {
    //             $data['rows']=$this->model_app->edit('guru',array('id_guru'=>dekrip($seo)))->row_array();
    //         $this->template->load('admin','admin/master/guru/edit',$data);
    //         }

    //     }
    //     else
    //     {
    //         redirect('dashboard');
    //     }
    // }

    // function gurudetail($seo){
    //     $data=$this->data;
    //     $data['title']='Data Guru dan Pegawai';
    //     $data['link']='master/guru';

    //     if(bisaBaca($data['link'],$data['id_level']))
    //     {
    //         $data['rows']=$this->model_app->edit('guru',array('id_guru'=>dekrip($seo)))->row_array();
    //         $this->template->load('admin','admin/master/guru/detail',$data);

    //     }
    //     else
    //     {
    //         redirect('dashboard');
    //     }
    // }

    function gurupassword()
    {
        if (isset($_POST['rowid'])) {
            $id = $this->input->post('rowid');
            // mengambil data berdasarkan id
            // dan menampilkan data ke dalam form modal bootstrap

            echo '
        <input type="hidden" name="id" value="' . $id . '">
            <div class="form-group row">
              <label class="col-sm-3 control-label ">Password Baru</label>
              <div class="col-sm-9">
                <input type="text" name="password" value="" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
                  <label class="col-sm-3 control-label "></label>
                  <div class="col-sm-9">
                    <input type="submit" name="insert" id="insert" value="Update" class="btn btn-success" />
                  </div>
                </div>

            ';
        }
    }

    function guruedit()
    {
        if (isset($_POST['rowid'])) {
            $id = $this->input->post('rowid');
            // mengambil data berdasarkan id
            // dan menampilkan data ke dalam form modal bootstrap
            $sql = $this->model_app->edit('guru', array('id_guru' => $id))->row_array();
            echo '
        <input type="hidden" name="id" value="' . $id . '">
            <div class="form-group row">
              <label class="col-sm-3 control-label ">Jabatan</label>
              <div class="col-sm-9">
                <select name="jabatan" class="form-control">
                ' . opJabatan($sql['id_jabatan']) . '
                </select>
              </div>
            </div>

            <div class="form-group row">
                  <label class="col-sm-3 control-label "></label>
                  <div class="col-sm-9">
                    <input type="submit" name="insert" id="insert" value="Update" class="btn btn-success" />
                  </div>
                </div>

            ';
        }
    }

    function gurusimpan()
    {
        $data = $this->data;
        $id = $this->input->post('id');
        $password = posttext('password');
        $salt = randomSalt();
        $token = token();
        $pass = create_hash($password, $salt);
        $simpan = array('password' => $pass, 'token' => $token, 'salt' => $salt);
        $where = array('id_guru' => $id);
        $hasil = array('uid' => $data['identitas']['uid'], 'npsn' => $data['identitas']['kode'], 'password' => $pass, 'token' => $token, 'salt' => $salt, 'id_guru' => $id);
        $response = Requests::post($data['identitas']['api'] . 'api/gurupassword', $data['headers'], json_encode($hasil));
        $has = json_decode($response->body, true);
        if ($has['action'] == true) {
            if ($has['hasil'] == 'success') {
                $this->model_app->update('guru', $simpan, $where);
            }
        }

        $res = array('action' => $has['action'], 'pesan' => $has['pesan'], 'hasil' => $has['hasil']);
        echo json_encode($res);
    }

    function gurujabatan()
    {
        $data = $this->data;
        $id = $this->input->post('id');
        $jabatan = postnumber('jabatan');

        $simpan = array('id_jabatan' => $jabatan);
        $where = array('id_guru' => $id);

        $this->model_app->update('guru', $simpan, $where);
        if ($this->db->affected_rows() > 0) {
            $res = array('pesan' => 'Jabatan Berhasil Diedit', 'hasil' => "success");
        } else {
            $res = array('pesan' => 'Jabatan Gagal Diedit', 'hasil' => "error");
        }


        echo json_encode($res);
    }

    // function guruhapus($seo){
    //     $data=$this->data;
    //     $data['title']='Data Guru dan Pegawai';
    //     $data['link']='master/guru';

    //     if(bisaHapus($data['link'],$data['id_level']))
    //     {
    //         $where=array('id_guru'=>dekrip($seo));
    //         $info=$this->model_app->edit('guru',$where)->row_array();
    //         $hapus=$this->model_app->delete('guru',$where);

    //         if($this->db->affected_rows()>0)
    //         {
    //             if($info['gambarkey']!='')
    //             {
    //              $delete= $this->s3_upload->delete_file($info['gambarkey']);
    //             }
    //             $hasil=array('hasil'=>'sukses','pesan'=>'Data Guru Berhasil Dihapus ');
    //         }
    //         else
    //         {
    //             $hasil=array('hasil'=>'gagal','pesan'=>'Data Guru Gagal Dihapus');
    //         }
    //        // redirect($data['link']);
    //         echo json_encode($hasil);

    //     }
    //     else
    //     {
    //         redirect('dashboard');
    //     }
    // }

    function get_guru()
    {
        $data = $this->data;
        $this->load->model('model_guru');
        $data['link'] = 'master/guru';
        $jenis = $this->session->jenis;
        if ($jenis != '') {
            $where = array('jenis' => $jenis);
        } else {
            $where = array();
        }



        $list = $this->model_guru->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $pass = '';
            $edit = '';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $edit = aksiModalEdit('#modalEdit', $field->id_guru, '');
                $pass = aksiModalReset('#modalPassword', $field->id_guru, '');
            }


            // $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id_guru), '');
            $nama = stripcslashes($field->nama);


            $no++;
            $row = array();
            $row[] = $no;

            $row[] = $nama;
            $row[] = $field->nip;
            $row[] = $field->jk;
            $row[] = $field->hp;
            $row[] = $field->email;
            $row[] = $field->status_pegawai;
            $row[] = viewJabatan($field->id_jabatan);
            $row[] = $field->jenis;
            $row[] = $edit;
            $row[] = $pass;

            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_guru->count_all($where),
            "recordsFiltered" => $this->model_guru->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function gurusync()
    {
        $data = $this->data;
        $data['title'] = 'Data Guru dan Pegawai';
        $data['link'] = 'master/guru';
        $table = 'guru';
        if (bisaTulis($data['link'], $data['id_level'])) {
            $hasil = array('uid' => $data['identitas']['uid'], 'npsn' => $data['identitas']['kode']);
            $response = Requests::post($data['identitas']['api'] . 'api/guru', $data['headers'], json_encode($hasil));
            $simpan = json_decode($response->body, true);
            if (count($simpan['hasil']) == 0) {
                $this->session->set_flashdata('gagal', 'Tidak Ada ' . $data['title'] . '  Yang di Sinkronkan, Data Belum Ada Di Database Dinas');
            } else {
                $this->model_app->insert_multiple_update($table, $simpan['hasil']);
                $jumlah = $this->db->affected_rows();
                if ($jumlah > 0) {
                    $this->session->set_flashdata('sukses', 'Ada ' . $jumlah . '  ' . $data['title'] . '  Berhasil Disinkronkan');
                } else {
                    $this->session->set_flashdata('gagal', 'Tidak Ada ' . $data['title'] . '  Yang di Sinkronkan');
                }
            }
        } else {
            $this->session->set_flashdata('gagal', 'Anda Tidak Berhak Mengakses Menu Ini');
        }
        redirect($data['link']);
    }

    function siswa()
    {
        $data = $this->data;
        $data['title'] = 'Data Siswa';
        $data['link'] = 'master/siswa';

        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['tahun_masuk'])) {
                $this->session->set_userdata(array('tahun_masuk' => postnumber('tahun_masuk')));
            }
            $data['tahun_masuk'] = $this->session->tahun_masuk;
            $this->template->load('admin', 'admin/master/siswa/data', $data);
        } else {
            redirect('dashboard');
        }
    }

    function siswaedit()
    {
        if (isset($_POST['rowid'])) {
            $id = $this->input->post('rowid');
            // mengambil data berdasarkan id
            // dan menampilkan data ke dalam form modal bootstrap
            $sql = $this->model_app->edit('siswa', array('id_siswa' => $id))->row_array();
            echo '
        <input type="hidden" name="id" value="' . $id . '">
            <div class="form-group row">
              <label class="col-sm-3 control-label ">Kelas</label>
              <div class="col-sm-9">
                ' . formInputText('kelas', $sql['kelas'], 'Kelas') . '
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 control-label ">Program</label>
              <div class="col-sm-9">
                ' . formInputText('program', $sql['program'], 'Program') . '
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 control-label ">HP Ayah</label>
              <div class="col-sm-9">
                ' . formInputText('hp_ayah', $sql['hp_ayah'], 'HP Ayah') . '
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 control-label ">HP Ibu</label>
              <div class="col-sm-9">
                ' . formInputText('hp_ibu', $sql['hp_ibu'], 'HP Ibu') . '
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 control-label ">HP Wali</label>
              <div class="col-sm-9">
                ' . formInputText('hp_wali', $sql['hp_wali'], 'HP Wali') . '
              </div>
            </div>

            <div class="form-group row">
                  <label class="col-sm-3 control-label "></label>
                  <div class="col-sm-9">
                    <input type="submit" name="insert" id="insert" value="Update" class="btn btn-success" />
                  </div>
                </div>

            ';
        }
    }

    function siswaeditsimpan()
    {
        $data = $this->data;
        $id = $this->input->post('id');
        $simpan = array(
            'kelas' => posttext('kelas'),
            'program' => posttext('program'),
            'hp_ayah' => posttext('hp_ayah'),
            'hp_ibu' => posttext('hp_ibu'),
            'hp_wali' => posttext('hp_wali'),
        );
        $where = array('id_siswa' => $id);

        $this->model_app->update('siswa', $simpan, $where);
        if ($this->db->affected_rows() > 0) {
            $res = array('pesan' => 'Jabatan Berhasil Diedit', 'hasil' => "success");
        } else {
            $res = array('pesan' => 'Jabatan Gagal Diedit', 'hasil' => "error");
        }


        echo json_encode($res);
    }

    // function siswatambah()
    // {
    //     $data = $this->data;
    //     $data['title'] = 'Form Tambah Data Siswa';
    //     $data['link'] = 'master/siswa';

    //     if (bisaTulis($data['link'], $data['id_level'])) {
    //         if (isset($_POST['simpan'])) {
    //             $nisn = postnumber('nisn');
    //             $salt = randomSalt();
    //             $token = token();
    //             $password = create_hash($nisn, $salt);
    //             $simpan = array(
    //                 'nama' => posttext('nama'),
    //                 'alamat' => posttext('alamat'),
    //                 'jk' => postnumber('jk'),
    //                 'nisn' => $nisn,
    //                 'nis' => posttext('nis'),
    //                 'agama' => postnumber('agama'),
    //                 'tgl_masuk' => postnumber('tgl_masuk'),
    //                 'tempat_lahir' => posttext('tempat_lahir'),
    //                 'tgl_lahir' => postnumber('tgl_lahir'),
    //                 'nama_ayah' => posttext('nama_ayah'),
    //                 'nama_ibu' => posttext('nama_ibu'),
    //                 'nama_wali' => posttext('nama_wali'),
    //                 'hp_ayah' => posttext('hp_ayah'),
    //                 'hp_ibu' => posttext('hp_ibu'),
    //                 'hp_wali' => posttext('hp_wali'),
    //                 'pekerjaan_ayah' => postnumber('pekerjaan_ayah'),
    //                 'pekerjaan_ibu' => postnumber('pekerjaan_ibu'),
    //                 'password' => $password,
    //                 'salt' => $salt,
    //                 'token' => $token,
    //                 'input_user' => $this->session->id_user
    //             );
    //             if ($this->model_app->insert('siswa', $simpan)) {
    //                 $id = $this->db->insert_id();
    //                 if (!empty($_FILES['gambar']['name'])) {

    //                     $dir = dirname($_FILES["gambar"]["tmp_name"]);
    //                     $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
    //                     rename($_FILES["gambar"]["tmp_name"], $destination);

    //                     $upload = $this->s3_upload->upload_file($destination);
    //                     if ($upload != '') {

    //                         $update = array('gambar' => $upload['uri'], 'gambarkey' => $upload['key']);
    //                         $where = array('id_siswa' => $id);
    //                         $this->model_app->update('siswa', $update, $where);
    //                         $this->session->set_flashdata('sukses', 'Data Siswa Berhasil Berhasil Disimpan');
    //                     } else {
    //                         $this->session->set_flashdata('gagal', 'Data Siswa Berhasil Disimpan Tapi Foto Gagal Di Upload');
    //                     }
    //                 } else {
    //                     $this->session->set_flashdata('sukses', 'Data Siswa Berhasil Disimpan dan Anda Tidak Mengupload Foto');
    //                 }
    //             } else {
    //                 $this->session->set_flashdata('gagal', 'Data Siswa Gagal Disimpan');
    //             }
    //             redirect($data['link']);
    //         } else {
    //             $this->template->load('admin', 'admin/master/siswa/tambah', $data);
    //         }
    //     } else {
    //         redirect('dashboard');
    //     }
    // }

    // function siswaedit($seo = '')
    // {
    //     $data = $this->data;
    //     $data['title'] = 'Form Edit Data Siswa';
    //     $data['link'] = 'master/siswa';

    //     if (bisaUbah($data['link'], $data['id_level'])) {
    //         if (isset($_POST['simpan'])) {
    //             $where = array('id_siswa' => postnumber('id'));
    //             $simpan = array(
    //                 'nama' => posttext('nama'),
    //                 'alamat' => posttext('alamat'),
    //                 'jk' => postnumber('jk'),
    //                 'nisn' => posttext('nisn'),
    //                 'nis' => posttext('nis'),
    //                 'agama' => postnumber('agama'),
    //                 'tgl_masuk' => postnumber('tgl_masuk'),
    //                 'tempat_lahir' => posttext('tempat_lahir'),
    //                 'tgl_lahir' => postnumber('tgl_lahir'),
    //                 'nama_ayah' => posttext('nama_ayah'),
    //                 'nama_ibu' => posttext('nama_ibu'),
    //                 'nama_wali' => posttext('nama_wali'),
    //                 'hp_ayah' => posttext('hp_ayah'),
    //                 'hp_ibu' => posttext('hp_ibu'),
    //                 'hp_wali' => posttext('hp_wali'),
    //                 'pekerjaan_ayah' => postnumber('pekerjaan_ayah'),
    //                 'pekerjaan_ibu' => postnumber('pekerjaan_ibu'),
    //                 'mod_user' => $this->session->id_user,
    //                 'mod_at' => date('Y-m-d')
    //             );
    //             if ($this->model_app->update('siswa', $simpan, $where)) {
    //                 if (!empty($_FILES['gambar']['name'])) {

    //                     $dir = dirname($_FILES["gambar"]["tmp_name"]);
    //                     $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
    //                     rename($_FILES["gambar"]["tmp_name"], $destination);

    //                     $upload = $this->s3_upload->upload_file($destination);
    //                     // var_dump($upload);

    //                     if ($upload != '') {

    //                         $update = array('gambar' => $upload['uri'], 'gambarkey' => $upload['key']);
    //                         $this->model_app->update('siswa', $update, $where);
    //                         $this->session->set_flashdata('sukses', 'Data Siswa Berhasil Berhasil Disimpan');
    //                     } else {

    //                         $this->session->set_flashdata('gagal', ' Data Siswa Berhasil Disimpan Tapi Foto Gagal Di Upload');
    //                     }
    //                 } else {
    //                     $this->session->set_flashdata('sukses', 'Data Siswa Berhasil Disimpan dan Anda Tidak Mengganti Foto');
    //                 }
    //             } else {
    //                 $this->session->set_flashdata('gagal', 'Data Siswa Gagal Disimpan');
    //             }
    //             redirect($data['link']);
    //         } else {
    //             $data['rows'] = $this->model_app->edit('siswa', array('id_siswa' => dekrip($seo)))->row_array();
    //             $this->template->load('admin', 'admin/master/siswa/edit', $data);
    //         }
    //     } else {
    //         redirect('dashboard');
    //     }
    // }

    function siswadetail($seo)
    {
        $data = $this->data;
        $data['title'] = 'Data Siswa';
        $data['link'] = 'master/siswa';

        if (bisaBaca($data['link'], $data['id_level'])) {
            $data['rows'] = $this->model_app->edit('siswa', array('id_siswa' => dekrip($seo)))->row_array();
            $this->template->load('admin', 'admin/master/siswa/detail', $data);
        } else {
            redirect('dashboard');
        }
    }


    function siswapassword()
    {
        if (isset($_POST['rowid'])) {
            $id = $this->input->post('rowid');
            // mengambil data berdasarkan id
            // dan menampilkan data ke dalam form modal bootstrap

            echo '
        <input type="hidden" name="id" value="' . $id . '">
            <div class="form-group row">
              <label class="col-sm-3 control-label ">Password Baru</label>
              <div class="col-sm-9">
                <input type="text" name="password" value="" class="form-control" required>
              </div>
            </div>
            
            <div class="form-group row">
                  <label class="col-sm-3 control-label "></label>
                  <div class="col-sm-9">
                    <input type="submit" name="insert" id="insert" value="Update" class="btn btn-success" />
                  </div>
                </div>
          
            ';
        }
    }

    function siswasimpan()
    {
        $data = $this->data;
        $id = $this->input->post('id');
        $password = posttext('password');
        $salt = randomSalt();
        $token = token();
        $pass = create_hash($password, $salt);
        $simpan = array('password' => $pass, 'token' => $token, 'salt' => $salt);
        $where = array('id_siswa' => $id);
        $hasil = array('uid' => $data['identitas']['uid'], 'npsn' => $data['identitas']['kode'], 'password' => $pass, 'token' => $token, 'salt' => $salt, 'id_siswa' => $id);
        $response = Requests::post($data['identitas']['api'] . 'api/siswapassword', $data['headers'], json_encode($hasil));
        $has = json_decode($response->body, true);
        if ($has['action'] == true) {
            if ($has['hasil'] == 'success') {
                $this->model_app->update('siswa', $simpan, $where);
            }
        }

        $res = array('action' => $has['action'], 'pesan' => $has['pesan'], 'hasil' => $has['hasil']);
        echo json_encode($res);
    }

    function siswahapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Data Siswa';
        $data['link'] = 'master/siswa';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id_siswa' => dekrip($seo));
            $info = $this->model_app->edit('siswa', $where)->row_array();
            $hapus = $this->model_app->delete('siswa', $where);

            if ($this->db->affected_rows() > 0) {
                if ($info['gambarkey'] != '') {
                    $delete = $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil = array('hasil' => 'sukses', 'pesan' => 'Data Siswa Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => 'Data Siswa Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function get_siswa()
    {
        $data = $this->data;
        $this->load->model('model_siswa');
        $data['link'] = 'master/siswa';
        $tahun_masuk = $this->session->tahun_masuk;
        if ($tahun_masuk != '') {
            $where = array('YEAR(tgl_masuk)' => $tahun_masuk, 'status' => 'Aktif');
        } else {
            $where = array('status' => 'Aktif');
        }

        $list = $this->model_siswa->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $pass = '';
            $edit = '';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $edit = aksiModalEdit('#modalEdit', $field->id_siswa, '');
                $pass = aksiModalReset('#modalPassword', $field->id_siswa, '');
            }

            // $hapus = '';
            // if (bisaHapus($data['link'], $data['id_level'])) {
            //     $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id_siswa), '');
            // }
            $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id_siswa), '');
            $nama = stripcslashes($field->nama);


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $nama;
            $row[] = $field->nisn;
            $row[] = $field->jk;
            $row[] = stripcslashes($field->nama_ayah);
            $row[] = $field->hp_ayah;
            $row[] = stripcslashes($field->alamat);
            $row[] = $detail . '&nbsp;' . $edit;
            $row[] = $pass;


            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_siswa->count_all($where),
            "recordsFiltered" => $this->model_siswa->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function siswasync()
    {
        $data = $this->data;
        $data['title'] = 'Data Siswa';
        $data['link'] = 'master/siswa';
        $table = 'siswa';
        if (bisaTulis($data['link'], $data['id_level'])) {
            $hasil = array('uid' => $data['identitas']['uid'], 'npsn' => $data['identitas']['kode']);
            $response = Requests::post($data['identitas']['api'] . 'api/siswa', $data['headers'], json_encode($hasil));
            $simpan = json_decode($response->body, true);
            if (count($simpan['hasil']) == 0) {
                $this->session->set_flashdata('gagal', 'Tidak Ada ' . $data['title'] . '  Yang di Sinkronkan, Data Belum Ada Di Database Dinas');
            } else {
                $this->model_app->insert_multiple_update($table, $simpan['hasil']);
                $jumlah = $this->db->affected_rows();
                if ($jumlah > 0) {
                    $this->session->set_flashdata('sukses', 'Ada ' . $jumlah . '  ' . $data['title'] . '  Berhasil Disinkronkan');
                } else {
                    $this->session->set_flashdata('gagal', 'Tidak Ada ' . $data['title'] . '  Yang di Sinkronkan');
                }
            }
        } else {
            $this->session->set_flashdata('gagal', 'Anda Tidak Berhak Mengakses Menu Ini');
        }
        // echo json_encode($response);
        redirect($data['link']);
    }
} //controller