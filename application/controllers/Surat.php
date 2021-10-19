<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
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
            'header' => 'Surat Menyurat',
            'ctrl' => 'surat'
        );
    }
    function index()
    {
        redirect('dashboard');
    }

    function dinaskeluar($hal = 1)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keluar Ke Dinas Pendidikan';
        $data['link'] = 'surat/dinaskeluar';

        if (bisaBaca($data['link'], $data['id_level'])) {

            if (isset($_POST['cari'])) {
                $this->session->set_userdata(array('carisurat' => postnumber('cari')));
            }
            $cari = $this->session->carisurat;
            $data['cari'] = $cari;
            $config['per_page'] = 10;

            $row = api('api/suratkeluar', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], 'jumlah' => $config['per_page'], 'halaman' => $hal, 'cari' => $cari));

            $jumlah = $row->total;
            $config['base_url'] = base_url() . 'surat/dinaskeluar';
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $jumlah;

            $dari = ($hal - 1) * $config['per_page'];

            if (is_numeric($dari)) {
                $data['record'] = $row->hasil;
            } else {
                redirect();
            }
            $this->pagination->initialize($config);
            $this->template->load('admin', 'admin/surat/dinas/keluar', $data);
        } else {
            redirect('dashboard');
        }
    }

    function dinaskeluartambah()
    {
        $data = $this->data;
        $data['title'] = 'Form Kirim Surat Ke Dinas';
        $data['link'] = 'surat/dinaskeluar';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {

                if (!empty($_FILES['gambar']['name'])) {

                    $dir = dirname($_FILES["gambar"]["tmp_name"]);
                    $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                    rename($_FILES["gambar"]["tmp_name"], $destination);

                    $upload = $this->s3_upload->upload_file($destination);
                    if ($upload != '') {

                        $kirim = array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], "isi_ringkas" => posttext('isi_ringkas'), "no_surat" => posttext('no_surat'), "tgl_surat" => postnumber('tgl_surat'), "tgl_surat" => postnumber('tgl_surat'), "jenis_surat" => postnumber('jenis_surat'), "gambar" => $upload['uri'], "gambarkey" => $upload['key'], "user_input" => viewUser($this->session->id_user));
                        $cek = api('api/suratkeluarsimpan', $kirim);
                        if ($cek->action == true) {
                            $this->session->set_flashdata('sukses', 'Data Surat Berhasil Di Kirim Kedinas');
                        } else {
                            $this->session->set_flashdata('gagal', 'Surat Gagal Di Kirim Ke Dinas');
                        }
                    } else {
                        $this->session->set_flashdata('gagal', 'File Gagal Di Upload');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'File Masih Kosong');
                }

                redirect($data['link']);
            } else {
                $cek = api('api/jenissurat', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid']));
                $data['jenis'] = $cek->hasil;
                $this->template->load('admin', 'admin/surat/dinas/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function dinaskeluarhapus($seo)
    {
        $data = $this->data;
        $data['link'] = 'surat/dinaskeluar';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $cek = api('api/suratkeluarhapus', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], "id" => dekrip($seo)));

            if ($cek->action == true) {
                $hasil = $cek->hasil;
                $delete = $this->s3_upload->delete_file($hasil->gambarkey);
                $this->session->set_flashdata('sukses', 'Surat Keluar Berhasil Dihapus');
            } else {
                $this->session->set_flashdata('gagal', 'Surat Keluar Gagal Dihapus');
            }

            redirect($data['link']);
        } else {
            redirect('dashboard');
        }
    }


    function dinasmasuk($hal = 1)
    {
        $data = $this->data;
        $data['title'] = 'Surat Masuk Dari Dinas Pendidikan';
        $data['link'] = 'surat/dinasmasuk';

        if (bisaBaca($data['link'], $data['id_level'])) {

            if (isset($_POST['cari'])) {
                $this->session->set_userdata(array('carisurat' => postnumber('cari')));
            }
            $cari = $this->session->carisurat;
            $data['cari'] = $cari;
            $config['per_page'] = 10;

            $row = api('api/suratmasuk', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], 'jumlah' => $config['per_page'], 'halaman' => $hal, 'cari' => $cari));

            $jumlah = $row->total;
            $config['base_url'] = base_url() . 'surat/dinasmasuk';
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $jumlah;

            $dari = ($hal - 1) * $config['per_page'];

            if (is_numeric($dari)) {
                $data['record'] = $row->hasil;
            } else {
                redirect();
            }
            $this->pagination->initialize($config);
            $this->template->load('admin', 'admin/surat/dinas/masuk', $data);
        } else {
            redirect('dashboard');
        }
    }

    function dinasdownload($seo)
    {
        $data = $this->data;
        $id = dekrip($seo);
        $user = viewUser($this->session->id_user);
        $cek = api('api/suratmasukdownload', array("npsn" => $data['identitas']['kode'], "uid" => $data['identitas']['uid'], "id" => $id, "user" => $user));
        if ($cek->action == true) {
            redirect($cek->gambar);
        } else {
            $this->session->set_flashdata('gagal', 'Tidak Tersambung Ke Dinas');
            redirect('surat/dinasmasuk');
        }
    }


    function suratmasuk()
    {
        $data = $this->data;
        $data['title'] = 'Daftar Surat Masuk';
        $data['link'] = 'surat/suratmasuk';

        if (bisaBaca($data['link'], $data['id_level'])) {

            $this->template->load('admin', 'admin/surat/sekolah/masuk', $data);
        } else {
            redirect('dashboard');
        }
    }

    function suratmasuktambah()
    {
        $data = $this->data;
        $data['title'] = 'Form Tambah Data Surat Masuk';
        $data['link'] = 'surat/suratmasuk';

        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {

                if (!empty($_FILES['gambar']['name'])) {

                    $dir = dirname($_FILES["gambar"]["tmp_name"]);
                    $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                    rename($_FILES["gambar"]["tmp_name"], $destination);

                    $upload = $this->s3_upload->upload_file($destination);
                    if ($upload != '') {

                        $update = array(
                            'nomor' => posttext('nomor'),
                            'tanggal' => postnumber('tanggal'),
                            'pengirim' => posttext('pengirim'),
                            'tujuan' => posttext('tujuan'),
                            'perihal' => posttext('perihal'),
                            'input_user' => $this->session->id_user,
                            'gambar' => $upload['uri'],
                            'gambarkey' => $upload['key']
                        );

                        $this->model_app->insert('surat_masuk', $update);
                        $this->session->set_flashdata('sukses', 'Data Surat Masuk Berhasil Berhasil Disimpan');
                    } else {
                        $this->session->set_flashdata('gagal', 'Data Surat Masuk Gagal Disimpan Karena File Gagal Di Upload');
                    }
                } else {
                    $update = array(
                        'nomor' => posttext('nomor'),
                        'tanggal' => postnumber('tanggal'),
                        'pengirim' => posttext('pengirim'),
                        'tujuan' => posttext('tujuan'),
                        'perihal' => posttext('perihal'),
                        'input_user' => $this->session->id_user
                    );

                    $this->model_app->insert('surat_masuk', $update);
                    $this->session->set_flashdata('sukses', 'Data Surat Masuk Berhasil Berhasil Disimpan dan Anda Tidak Mengupload File');
                }



                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/surat/sekolah/masuktambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function suratmasukedit($seo = '')
    {
        $data = $this->data;
        $data['title'] = 'Form Edit Data Surat Masuk';
        $data['link'] = 'surat/suratmasuk';

        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $where = array('id_surat' => postnumber('id'));
                $info = $this->model_app->edit('surat_masuk', $where)->row_array();
                if ($info['gambarkey'] != '') {
                    $delete = $this->s3_upload->delete_file($info['gambarkey']);
                }


                $simpan = array(
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'pengirim' => posttext('pengirim'),
                    'tujuan' => posttext('tujuan'),
                    'perihal' => posttext('perihal')
                );
                if ($this->model_app->update('surat_masuk', $simpan, $where)) {
                    if (!empty($_FILES['gambar']['name'])) {

                        $dir = dirname($_FILES["gambar"]["tmp_name"]);
                        $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                        rename($_FILES["gambar"]["tmp_name"], $destination);

                        $upload = $this->s3_upload->upload_file($destination);
                        // var_dump($upload);

                        if ($upload != '') {

                            $update = array('gambar' => $upload['uri'], 'gambarkey' => $upload['key']);
                            $this->model_app->update('surat_masuk', $update, $where);
                            $this->session->set_flashdata('sukses', 'Data Surat Masuk Berhasil Disimpan');
                        } else {

                            $this->session->set_flashdata('gagal', ' Data Surat Masuk Berhasil Disimpan Tapi File Gagal Di Upload');
                        }
                    } else {
                        $this->session->set_flashdata('sukses', 'Data Surat Masuk Berhasil Disimpan dan Anda Tidak Mengganti/Mengupload File');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'Data Surat Masuk Gagal Disimpan');
                }

                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_app->edit('surat_masuk', array('id_surat' => dekrip($seo)))->row_array();
                $this->template->load('admin', 'admin/surat/sekolah/masukedit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }



    function suratmasukhapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Data Surat Masuk';
        $data['link'] = 'surat/suratmasuk';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id_surat' => dekrip($seo));
            $info = $this->model_app->edit('surat_masuk', $where)->row_array();
            $hapus = $this->model_app->delete('surat_masuk', $where);

            if ($this->db->affected_rows() > 0) {
                if ($info['gambarkey'] != '') {
                    $delete = $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil = array('hasil' => 'sukses', 'pesan' => 'Data Surat Masuk Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => 'Data Surat Masuk Gagal Dihapus');
            }
            // redirect($data['link']);


        } else {
            $hasil = array('hasil' => 'gagal', 'pesan' => 'Anda Tidak Diijinkan Menghapus Surat Masuk');
        }

        echo json_encode($hasil);
    }



    function get_suratmasuk()
    {
        $data = $this->data;
        $this->load->model('model_suratmasuk');
        $data['link'] = 'surat/suratmasuk';
        $where = array();


        $list = $this->model_suratmasuk->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {



            $edit = '';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id_surat), '');
            }

            $hapus = '';
            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id_surat), '');
            }
            if ($field->gambar != '') {
                $detail = aksiDownloadFile($field->gambar, 'Lihat');
            } else {
                $detail = 'Belum Upload File';
            }



            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = $field->tanggal;
            $row[] = stripcslashes($field->pengirim);
            $row[] = stripcslashes($field->tujuan);
            $row[] = stripcslashes($field->perihal);
            $row[] = $detail;
            $row[] = $edit . '&nbsp;' . $hapus;


            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_suratmasuk->count_all($where),
            "recordsFiltered" => $this->model_suratmasuk->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function suratkeluar()
    {
        $data = $this->data;
        $data['title'] = 'Daftar Surat Keluar';
        $data['link'] = 'surat/suratkeluar';

        if (bisaBaca($data['link'], $data['id_level'])) {

            $this->template->load('admin', 'admin/surat/sekolah/keluar', $data);
        } else {
            redirect('dashboard');
        }
    }

    function suratkeluartambah()
    {
        $data = $this->data;
        $data['title'] = 'Form Tambah Data Surat Keluar';
        $data['link'] = 'surat/suratkeluar';

        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {

                if (!empty($_FILES['gambar']['name'])) {

                    $dir = dirname($_FILES["gambar"]["tmp_name"]);
                    $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                    rename($_FILES["gambar"]["tmp_name"], $destination);

                    $upload = $this->s3_upload->upload_file($destination);
                    if ($upload != '') {

                        $update = array(
                            'nomor' => posttext('nomor'),
                            'tanggal' => postnumber('tanggal'),
                            'pengirim' => posttext('pengirim'),
                            'tujuan' => posttext('tujuan'),
                            'perihal' => posttext('perihal'),
                            'input_user' => $this->session->id_user,
                            'gambar' => $upload['uri'],
                            'gambarkey' => $upload['key']
                        );

                        $this->model_app->insert('surat_keluar', $update);
                        $this->session->set_flashdata('sukses', 'Data Surat Keluar Berhasil Berhasil Disimpan');
                    } else {
                        $this->session->set_flashdata('gagal', 'Data Surat Keluar Gagal Disimpan Karena File Gagal Di Upload');
                    }
                } else {
                    $update = array(
                        'nomor' => posttext('nomor'),
                        'tanggal' => postnumber('tanggal'),
                        'pengirim' => posttext('pengirim'),
                        'tujuan' => posttext('tujuan'),
                        'perihal' => posttext('perihal'),
                        'input_user' => $this->session->id_user
                    );

                    $this->model_app->insert('surat_keluar', $update);
                    $this->session->set_flashdata('sukses', 'Data Surat Keluar Berhasil Berhasil Disimpan dan Anda Tidak Mengupload File');
                }



                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/surat/sekolah/keluartambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function suratkeluaredit($seo = '')
    {
        $data = $this->data;
        $data['title'] = 'Form Edit Data Surat Keluar';
        $data['link'] = 'surat/suratkeluar';

        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $where = array('id_surat' => postnumber('id'));
                $info = $this->model_app->edit('surat_keluar', $where)->row_array();
                if ($info['gambarkey'] != '') {
                    $delete = $this->s3_upload->delete_file($info['gambarkey']);
                }


                $simpan = array(
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'pengirim' => posttext('pengirim'),
                    'tujuan' => posttext('tujuan'),
                    'perihal' => posttext('perihal')
                );
                if ($this->model_app->update('surat_keluar', $simpan, $where)) {
                    if (!empty($_FILES['gambar']['name'])) {

                        $dir = dirname($_FILES["gambar"]["tmp_name"]);
                        $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                        rename($_FILES["gambar"]["tmp_name"], $destination);

                        $upload = $this->s3_upload->upload_file($destination);
                        // var_dump($upload);

                        if ($upload != '') {

                            $update = array('gambar' => $upload['uri'], 'gambarkey' => $upload['key']);
                            $this->model_app->update('surat_keluar', $update, $where);
                            $this->session->set_flashdata('sukses', 'Data Surat Keluar Berhasil Disimpan');
                        } else {

                            $this->session->set_flashdata('gagal', ' Data Surat Keluar Berhasil Disimpan Tapi File Gagal Di Upload');
                        }
                    } else {
                        $this->session->set_flashdata('sukses', 'Data Surat Keluar Berhasil Disimpan dan Anda Tidak Mengganti/Mengupload File');
                    }
                } else {
                    $this->session->set_flashdata('gagal', 'Data Surat Keluar Gagal Disimpan');
                }

                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_app->edit('surat_keluar', array('id_surat' => dekrip($seo)))->row_array();
                $this->template->load('admin', 'admin/surat/sekolah/keluaredit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }



    function suratkeluarhapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Data Surat Keluar';
        $data['link'] = 'surat/suratkeluar';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id_surat' => dekrip($seo));
            $info = $this->model_app->edit('surat_keluar', $where)->row_array();
            $hapus = $this->model_app->delete('surat_keluar', $where);

            if ($this->db->affected_rows() > 0) {
                if ($info['gambarkey'] != '') {
                    $delete = $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil = array('hasil' => 'sukses', 'pesan' => 'Data Surat Keluar Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => 'Data Surat Keluar Gagal Dihapus');
            }
            // redirect($data['link']);


        } else {
            $hasil = array('hasil' => 'gagal', 'pesan' => 'Anda Tidak Diijinkan Menhapus Surat Keluar');
        }

        echo json_encode($hasil);
    }



    function get_suratkeluar()
    {
        $data = $this->data;
        $this->load->model('model_suratkeluar');
        $data['link'] = 'surat/suratkeluar';
        $where = array();


        $list = $this->model_suratkeluar->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {



            $edit = '';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id_surat), '');
            }

            $hapus = '';
            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id_surat), '');
            }

            if ($field->gambar != '') {
                $detail = aksiDownloadFile($field->gambar, 'Lihat');
            } else {
                $detail = 'Belum Upload File';
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = $field->tanggal;
            $row[] = stripcslashes($field->pengirim);
            $row[] = stripcslashes($field->tujuan);
            $row[] = stripcslashes($field->perihal);
            $row[] = $detail;
            $row[] = $edit . '&nbsp;' . $hapus;


            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_suratkeluar->count_all($where),
            "recordsFiltered" => $this->model_suratkeluar->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
} //controller