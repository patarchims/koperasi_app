<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Ppdb extends CI_Controller
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
        $this->load->library('pdf');
        $identitas = $this->model_app->edit('identitas', array('id' => 1))->row_array();
        $notif = api('api/notifikasi', array("npsn" => $identitas['kode'], "uid" => $identitas['uid']));
        if (isset($_POST['tahun'])) {
            $this->session->set_userdata(array('tahun' => postnumber('tahun')));
        }
        $tahun = $this->session->tahun;
        if ($tahun == '') {
            $tahun = date('Y');
        }
        $this->data = array(
            'identitas' => $identitas,
            'id_level' => $this->session->level,
            'notif' => $notif->jumlah,
            'tahun' => $tahun,
            'header' => 'PPDB',
            'ctrl' => 'ppdb'
        );
    }
    function index()
    {
        redirect('dashboard');
    }

    function tahun()
    {
        $data = $this->data;
        $data['title'] = 'Tahun Penerimaan';
        $data['link'] = 'ppdb/tahun';
        $table = 'ppdb_ta';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['tambah'])) {
                $simpan = array(
                    'tahun' => postnumber('tahun'),
                    'nama_tahun' => posttext('nama_tahun'),
                    'tgl_awal_daftar' => postnumber('tgl_awal_daftar'),
                    'tgl_akhir_daftar' => postnumber('tgl_akhir_daftar'),
                    'tgl_pengumuman' => postnumber('tgl_pengumuman') . ' ' . postnumber('waktu_pengumuman'),
                    'tgl_awal_registrasi' => postnumber('tgl_awal_registrasi'),
                    'tgl_akhir_registrasi' => postnumber('tgl_akhir_registrasi'),
                    'biaya_daftar' => postnumber('biaya_daftar'),
                    'keterangan' => posttext('keterangan'),
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else if (isset($_POST['edit'])) {
                $where = array('id' => postnumber('id'));
                $simpan = array(
                    'tahun' => postnumber('tahun'),
                    'nama_tahun' => posttext('nama_tahun'),
                    'tgl_awal_daftar' => postnumber('tgl_awal_daftar'),
                    'tgl_akhir_daftar' => postnumber('tgl_akhir_daftar'),
                    'tgl_pengumuman' => postnumber('tgl_pengumuman') . ' ' . postnumber('waktu_pengumuman'),
                    'tgl_awal_registrasi' => postnumber('tgl_awal_registrasi'),
                    'tgl_akhir_registrasi' => postnumber('tgl_akhir_registrasi'),
                    'biaya_daftar' => postnumber('biaya_daftar'),
                    'keterangan' => posttext('keterangan'),
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['record'] = $this->model_app->view_ordering('ppdb_ta', 'tgl_awal_daftar', 'desc');
                $this->template->load('admin', 'admin/ppdb/tahun/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function tahunedit()
    {
        if (isset($_POST['rowid'])) {
            $id = $this->input->post('rowid');
            // mengambil data berdasarkan id
            // dan menampilkan data ke dalam form modal bootstrap
            $sql = $this->model_app->edit('ppdb_ta', array('id' => $id))->row_array();
            $pecah = explode(" ", $sql['tgl_pengumuman']);
            echo '
                    <input type="hidden" name="id" value="' . $id . '">
                    <div class="form-group row">
                        <label class="control-label col-sm-3">Tahun</label>
                        <div class="col-sm-9">
                        <input type="year" class="form-control" name="tahun" value="' . $sql['tahun'] . '" placeholder="Tahun Penerimaan" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3">Tahun</label>
                        <div class="col-sm-9">
                        ' . formInputText('nama_tahun', stripslashes($sql['nama_tahun']), 'Nama Tahun Penerimaan', 'required') . '
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3">Tanggal Awal Pendaftaran</label>
                        <div class="col-sm-9">
                        ' . formInputDate('tgl_awal_daftar', $sql['tgl_awal_daftar'], 'Tanggal Awal Pendaftaran', 'required') . '
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3">Tanggal Akhir Pendaftaran</label>
                        <div class="col-sm-9">
                        ' . formInputDate('tgl_akhir_daftar', $sql['tgl_akhir_daftar'], 'Tanggal Akhir Pendaftaran', 'required') . '
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3">Tanggal Pengumuman Kelulusan</label>
                        <div class="col-sm-4">
                        ' . formInputDate('tgl_pengumuman', $pecah[0], 'Tanggal Pengumuman', 'required') . '
                        </div>
                        <label class="control-label col-sm-2">Waktu</label>
                        <div class="col-sm-3">
                        ' . formInputTime('waktu_pengumuman', $pecah[1], 'Jam Pengumuman', 'required') . '
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3">Tanggal Awal Registrasi Ulang</label>
                        <div class="col-sm-9">
                        ' . formInputDate('tgl_awal_registrasi', $sql['tgl_awal_registrasi'], 'Tanggal Awal Registrasi Ulang', 'required') . '
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3">Tanggal Akhir Registrasi Ulang</label>
                        <div class="col-sm-9">
                        ' . formInputDate('tgl_akhir_registrasi', $sql['tgl_akhir_registrasi'], 'Tanggal Akhir Registrasi Ulang', 'required') . '
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3">Biaya Pendaftaran</label>
                        <div class="col-sm-9">
                        ' . formInputNumber('biaya_daftar', $sql['biaya_daftar'], 'Biaya Pendaftaran', '') . '
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-sm-3">Keterangan</label>
                        <div class="col-sm-9">
                        ' . formInputTextarea('keterangan', gantiEdit($sql['keterangan']), 'form-control', 'Keterangan', '3') . '
                        </div>
                    </div>
            ';
        }
    }

    function tahunketerangan()
    {
        if (isset($_POST['rowid'])) {
            $id = $this->input->post('rowid');
            // mengambil data berdasarkan id
            // dan menampilkan data ke dalam form modal bootstrap
            $sql = $this->model_app->edit('ppdb_ta', array('id' => $id))->row_array();
            echo gantiEnter($sql['keterangan']);
        }
    }

    function tahunhapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Tahun Penerimaan';
        $data['link'] = 'ppdb/tahun';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $hapus = $this->model_app->delete('ppdb_ta', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => 'Data Tahun Penerimaan Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => 'Data Penerimaan Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function jurusan()
    {
        $data = $this->data;
        $data['link'] = 'ppdb/jurusan';
        $data['title'] = 'Jurusan';
        $table = 'ppdb_jurusan';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['tambah'])) {

                $simpan = array(
                    'jurusan' => posttext('jurusan')
                );

                if ($this->model_app->insert($table, $simpan)) {
                    $this->session->set_flashdata('sukses', "Data Jurusan Berhasil Disimpan");
                } else {
                    $this->session->set_flashdata('gagal', "Data Jurusan Gagal Disimpan");
                }
                redirect($data['link']);
            } else if (isset($_POST['edit'])) {

                $simpan = array(
                    'jurusan' => posttext('jurusan'),
                    'urutan' => postnumber('urutan')
                );
                $where = array('id_jurusan' => $this->input->post('id'));
                if ($this->model_app->update($table, $simpan, $where)) {
                    $this->session->set_flashdata('sukses', "Data Jurusan Berhasil Diedit");
                } else {
                    $this->session->set_flashdata('gagal', "Data Jurusan Gagal Diedit");
                }
                redirect($data['link']);
            } else {

                $data['record'] = $this->model_app->view_ordering($table, 'id_jurusan', 'ASC');
                $this->template->load('admin', 'admin/ppdb/jurusan/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function jurusanedit()
    {
        if (isset($_POST['rowid'])) {
            $id = $this->input->post('rowid');
            // mengambil data berdasarkan id
            // dan menampilkan data ke dalam form modal bootstrap
            $sql = $this->model_app->edit('jurusan', array('id_jurusan' => $id))->row_array();

            echo '
        <input type="hidden" name="id" value="' . $id . '">
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Nama Jurusan</label>
                  <div class="col-sm-9">
                    <input type="text" name="jurusan" value="' . $sql['jurusan'] . '" class="form-control" required>
                  </div>
             </div>
            ';
        }
    }

    function jurusanhapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Jurusan';
        $data['link'] = 'ppdb/tahun';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $hapus = $this->model_app->delete('ppdb_jurusan', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => 'Data Jurusan Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => 'Data Jurusan Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function jurusanaktif($seo, $status)
    {
        $data = $this->data;
        $data['title'] = 'Status Jurusan';
        $data['link'] = 'ppdb/jurusan';
        $table = 'ppdb_jurusan';
        if (bisaUbah($data['link'], $data['id_level'])) {
            $where = array('id_jurusan' => dekrip($seo));
            $simpan = array('status' => $status);
            $this->model_app->update($table, $simpan, $where);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Diubah');
            } else {
                $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Diubah');
            }
        } else {
            $this->session->set_flashdata('gagal', "Anda Tidak Diizinkan Mengedit Data");
        }
        redirect($data['link']);
    }

    function pendaftar()
    {
        $data = $this->data;
        $data['title'] = 'Pendaftar';
        $data['link'] = 'ppdb/pendaftar';
        if (bisaBaca($data['link'], $data['id_level'])) {
            $this->template->load('admin', 'admin/ppdb/pendaftar/data', $data);
        } else {
            redirect('dashboard');
        }
    }

    function pendaftarget()
    {
        $data = $this->data;
        $this->load->model('model_pendaftar');
        $data['link'] = 'ppdb/pendaftar';
        $where = array('tahun' => $data['tahun']);


        $list = $this->model_pendaftar->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $pass = '';
            $edit = '';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
                $pass = aksiModalReset('#modalPassword', $field->id, '');
            }

            $hapus = '';
            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }
            $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');
            $nama = stripcslashes($field->nama);

            $bukti = '';
            if ($field->gambar != '') {
                $bukti = aksiUrl($field->gambar, 'Lihat');
            }


            if ($field->status_bayar == 0) {
                $status = 'Belum Bayar<br>' . aksiValidasiSwal($data['link'] . 'validasi', enkrip($field->id), 'Validasi');
            } else {
                $status = 'Sudah Bayar';
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->cara_daftar;
            $row[] = $nama;
            $row[] = tgl_view($field->tgl_lahir);
            $row[] = $field->jk;
            $row[] = $field->hp;
            $row[] = stripcslashes($field->email);
            $row[] = $bukti;
            $row[] = $status;
            $row[] = $detail . '&nbsp;' . $edit;
            $row[] = $pass;


            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_pendaftar->count_all($where),
            "recordsFiltered" => $this->model_pendaftar->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function pendaftartambah()
    {
        $data = $this->data;
        $data['title'] = 'Pendaftar';
        $data['link'] = 'ppdb/pendaftar';
        $table = 'ppdb_pendaftar';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $pass = postnumber('password');
                $salt = randomSalt();
                $token = token();
                $password = create_hash($pass, $salt);
                $simpan = array(
                    'tahun' => postnumber('tahun'),
                    'cara_daftar' => 'Manual',
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
                    'token' => $token,
                    'create_user' => $this->session->id_user,
                    'status_bayar' => 1
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/ppdb/pendaftar/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function pendaftaredit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Pendaftar';
        $data['link'] = 'ppdb/pendaftar';
        $table = 'ppdb_pendaftar';
        $where = array('id' => dekrip($seo));
        if (bisaUbah($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {

                $simpan = array(
                    'tahun' => postnumber('tahun'),
                    'nama' => posttext('nama'),
                    'tgl_lahir' => postnumber('tgl_lahir'),
                    'jk' => postnumber('jk'),
                    'nama_ortu' => posttext('nama_ortu'),
                    'hp' => postnumber('hp'),
                    'email' => posttext('email'),
                    'alamat' => posttext('alamat'),
                    'nik' => posttext('nik'),
                    'id_jurusan' => postnumber('id_jurusan')
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_app->edit($table, $where)->row_array();
                $this->template->load('admin', 'admin/ppdb/pendaftar/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function pendaftardetail($seo)
    {
        $data = $this->data;
        $data['title'] = 'Pendaftar';
        $data['link'] = 'ppdb/pendaftar';
        $table = 'ppdb_pendaftar';
        $where = array('id' => dekrip($seo));
        if (bisaBaca($data['link'], $data['id_level'])) {
            $data['rows'] = $this->model_app->edit($table, $where)->row_array();
            $this->template->load('admin', 'admin/ppdb/pendaftar/detail', $data);
        } else {
            redirect('dashboard');
        }
    }

    function pendaftarpassword()
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

    function pendaftarsimpan()
    {
        $data = $this->data;
        $table = 'ppdb_pendaftar';
        $id = $this->input->post('id');
        $password = posttext('password');
        $salt = randomSalt();
        $token = token();
        $pass = create_hash($password, $salt);
        $simpan = array('password' => $pass, 'token' => $token, 'salt' => $salt);
        $where = array('id' => $id);
        $this->model_app->update($table, $simpan, $where);
        if ($this->db->affected_rows() > 0) {
            $res = array('action' => true, 'pesan' => 'Password Berhasil Di Ganti', 'hasil' => 'success');
        } else {
            $res = array('action' => true, 'pesan' => 'Password Gagal Di Ganti', 'hasil' => 'error');
        }

        echo json_encode($res);
    }

    function pendaftarvalidasi($seo)
    {
        $data = $this->data;
        $table = 'ppdb_pendaftar';
        $id = dekrip($seo);
        $simpan = array('status_bayar' => 1);
        $where = array('id' => $id);
        $this->model_app->update($table, $simpan, $where);
        if ($this->db->affected_rows() > 0) {
            $res = array('action' => true, 'pesan' => 'Data Berhasil di Validasi', 'hasil' => 'success');
        } else {
            $res = array('action' => true, 'pesan' => 'Data Gagal di Validasi', 'hasil' => 'error');
        }

        echo json_encode($res);
    }

    function pendaftarcetak($tahun)
    {
        $data = $this->data;
        $this->pdf->landscapea4();
        $data['record'] = $this->model_ppdb->pendaftar($tahun);
        $this->load->view('admin/ppdb/pendaftar/cetak', $data);
    }
} //controller