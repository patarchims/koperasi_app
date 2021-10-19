<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Layanan extends CI_Controller
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
        $this->load->helper('layanan_helper');
        $this->load->library('pdf');
        $this->load->model('model_layanan');
        if (isset($_POST['tahun'])) {
            $this->session->set_userdata(array('tahun' => postnumber('tahun')));
        }
        $tahun = $this->session->tahun;
        if ($tahun == '') {
            $tahun = date('Y');
        }
        $identitas = $this->model_app->edit('identitas', array('id' => 1))->row_array();
        $notif = api('api/notifikasi', array("npsn" => $identitas['kode'], "uid" => $identitas['uid']));
        $this->data = array(
            'identitas' => $identitas,
            'id_level' => $this->session->level,
            'id_user' => $this->session->id_user,
            'notif' => $notif->jumlah,
            'tahun' => $tahun,
            'header' => 'Layanan',
            'ctrl' => 'layanan'
        );
    }
    function index()
    {
        redirect('dashboard');
    }



    function surattugas()
    {
        $data = $this->data;
        $data['title'] = 'Surat Perintah Tugas';
        $data['link'] = 'layanan/surattugas';
        $table = 'layanan_01';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['upload'])) {
                if (!empty($_FILES['gambar']['name'])) {
                    $where = array('id' => postnumber('id'));
                    $info = $this->model_app->edit($table, $where)->row_array();
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
                    $this->session->set_flashdata('gagal', 'File Masih Kosong');
                }
                redirect(current_url());
            } else {
                $this->template->load('admin', 'admin/layanan/guru/surattugas/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function surattugasget()
    {
        $data = $this->data;
        $this->load->model('model_layanan01');
        $data['link'] = 'layanan/surattugas';
        $where = array('YEAR(tanggal)' => $data['tahun']);

        $list = $this->model_layanan01->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $edit = '';
            $hapus = '';
            if (bisaUbah($data['link'], $data['id_level']) and $field->gambar == '') {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
            }

            if (bisaHapus($data['link'], $data['id_level']) and $field->gambar == '') {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }

            // $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');
            $cetak = aksiCetak($data['link'] . 'cetak', enkrip($field->id), '');
            $nama = stripcslashes($field->nama);

            $gambar = 'Belum Upload';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Upload');
            }
            if ($field->gambar != '') {
                $gambar = aksiUrl($field->gambar, 'Lihat');
                if (bisaUbah($data['link'], $data['id_level'])) {
                    $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Ganti');
                }
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = tgl_indo($field->tanggal);
            $row[] = $nama;
            $row[] = $gambar;
            $row[] = $edit . '&nbsp;' . $hapus . '&nbsp;' . $cetak;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_layanan01->count_all($where),
            "recordsFiltered" => $this->model_layanan01->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function surattugastambah()
    {
        $data = $this->data;
        $data['title'] = 'Surat Perintah Tugas';
        $data['link'] = 'layanan/surattugas';
        $table = 'layanan_01';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $pelaksana = postnumber('pelaksana');
                $keterangan = posttext('keterangan');
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'isi1' => posttext('isi1'),
                    'isi2' => posttext('isi2'),
                    'hari_tanggal' => posttext('hari_tanggal'),
                    'waktu' => posttext('waktu'),
                    'tempat' => posttext('tempat'),
                    'syarat' => posttext('syarat'),
                    'create_user' => $data['id_user']
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $id = $this->db->insert_id();
                    $peserta = array();
                    $total = count($pelaksana);
                    for ($i = 0; $i < $total; $i++) {
                        $peserta[] = array('id_layanan' => $id, 'id_ptk' => $pelaksana[$i], 'keterangan' => $keterangan[$i]);
                    }
                    $this->model_app->insert_multiple_update($table . '_peserta', $peserta);
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/layanan/guru/surattugas/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function surattugascetak($seo)
    {
        $data = $this->data;
        $this->pdf->portraitnopage();
        $id = dekrip($seo);
        $table = 'layanan_01';
        $data['rows'] = $this->model_layanan->layanan01($id);
        $data['record'] = $this->model_layanan->layanan01peserta($id);
        $this->load->view('admin/layanan/guru/surattugas/cetak', $data);
    }

    function surattugasedit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Perintah Tugas';
        $data['link'] = 'layanan/surattugas';
        $table = 'layanan_01';
        $id = dekrip($seo);
        $where = array('id' => dekrip($seo));
        if (bisaUbah($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                // $pelaksana = postnumber('pelaksana');
                // $keterangan = posttext('keterangan');
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'isi1' => posttext('isi1'),
                    'isi2' => posttext('isi2'),
                    'hari_tanggal' => posttext('hari_tanggal'),
                    'waktu' => posttext('waktu'),
                    'tempat' => posttext('tempat'),
                    'syarat' => posttext('syarat')
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    // $id = $this->db->insert_id();
                    // $peserta = array();
                    // $total = count($pelaksana);
                    // for ($i = 0; $i < $total; $i++) {
                    //     $peserta[] = array('id_layanan' => $id, 'id_ptk' => $pelaksana[$i], 'keterangan' => $keterangan[$i]);
                    // }
                    // $this->model_app->insert_multiple_update($table . '_peserta', $peserta);
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else if (isset($_POST['tambah'])) {
                $simpan = array(
                    'id_layanan' => postnumber('id_layanan'),
                    'id_ptk' => postnumber('id_ptk'),
                    'keterangan' => posttext('keterangan')
                );
                $this->model_app->insert($table . '_peserta', $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect(current_url());
            } else {
                $data['rows'] = $this->model_app->edit($table, $where)->row_array();
                $data['record'] = $this->model_layanan->layanan01peserta($id);
                $this->template->load('admin', 'admin/layanan/guru/surattugas/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function surattugashapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Perintah Tugas';
        $data['link'] = 'layanan/surattugas';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_01', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function surattugaspesertahapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Pelaksana Tugas';
        $data['link'] = 'layanan/surattugas';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_01_peserta', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function keteranganguru()
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Guru/ Pegawai';
        $data['link'] = 'layanan/keteranganguru';
        $table = 'layanan_02';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['upload'])) {
                if (!empty($_FILES['gambar']['name'])) {
                    $where = array('id' => postnumber('id'));
                    $info = $this->model_app->edit($table, $where)->row_array();
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
                    $this->session->set_flashdata('gagal', 'File Masih Kosong');
                }
                redirect(current_url());
            } else {
                $this->template->load('admin', 'admin/layanan/guru/keteranganguru/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function keteranganguruget()
    {
        $data = $this->data;
        $this->load->model('model_layanan02');
        $data['link'] = 'layanan/keteranganguru';
        $where = array('YEAR(tanggal)' => $data['tahun']);

        $list = $this->model_layanan02->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $edit = '';
            $hapus = '';
            if (bisaUbah($data['link'], $data['id_level']) and $field->gambar == '') {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
            }

            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }

            // $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');
            $cetak = aksiCetak($data['link'] . 'cetak', enkrip($field->id), '');
            $nama = stripcslashes($field->nama);
            $pnama = stripcslashes($field->pnama);

            $gambar = 'Belum Upload';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Upload');
            }
            if ($field->gambar != '') {
                $gambar = aksiUrl($field->gambar, 'Lihat');
                if (bisaUbah($data['link'], $data['id_level'])) {
                    $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Ganti');
                }
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = tgl_indo($field->tanggal);
            $row[] = $nama;
            $row[] = $pnama;
            $row[] = $gambar;
            $row[] = $edit . '&nbsp;' . $hapus . '&nbsp;' . $cetak;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_layanan02->count_all($where),
            "recordsFiltered" => $this->model_layanan02->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function keterangangurutambah()
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Guru/ Pegawai';
        $data['link'] = 'layanan/keteranganguru';
        $table = 'layanan_02';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'keterangan' => posttext('keterangan'),
                    'id_ptk' => posttext('id_ptk'),
                    'create_user' => $data['id_user']
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/layanan/guru/keteranganguru/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function keterangangurucetak($seo)
    {
        $data = $this->data;
        $this->pdf->portraitnopage();
        $id = dekrip($seo);
        $data['rows'] = $this->model_layanan->layanan02($id);
        $this->load->view('admin/layanan/guru/keteranganguru/cetak', $data);
    }

    function keteranganguruedit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Guru/ Pegawai';
        $data['link'] = 'layanan/keteranganguru';
        $table = 'layanan_02';
        $where = array('id' => dekrip($seo));
        if (bisaUbah($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'keterangan' => posttext('keterangan'),
                    'id_ptk' => posttext('id_ptk'),
                    'create_user' => $data['id_user']
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_app->edit($table, $where)->row_array();
                $this->template->load('admin', 'admin/layanan/guru/keteranganguru/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function keteranganguruhapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Guru/ Pegawai';
        $data['link'] = 'layanan/keteranganguru';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_02', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function keterangansiswa()
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Siswa';
        $data['link'] = 'layanan/keterangansiswa';
        $table = 'layanan_03';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['upload'])) {
                if (!empty($_FILES['gambar']['name'])) {
                    $where = array('id' => postnumber('id'));
                    $info = $this->model_app->edit($table, $where)->row_array();
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
                    $this->session->set_flashdata('gagal', 'File Masih Kosong');
                }
                redirect(current_url());
            } else {
                $this->template->load('admin', 'admin/layanan/siswa/keterangansiswa/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function keterangansiswaget()
    {
        $data = $this->data;
        $this->load->model('model_layanan03');
        $data['link'] = 'layanan/keterangansiswa';
        $where = array('YEAR(tanggal)' => $data['tahun']);
        $list = $this->model_layanan03->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $edit = '';
            $hapus = '';
            if (bisaUbah($data['link'], $data['id_level']) and $field->gambar == '') {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
            }

            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }

            // $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');
            $cetak = aksiCetak($data['link'] . 'cetak', enkrip($field->id), '');
            $nama = stripcslashes($field->nama);
            $pnama = stripcslashes($field->pnama);

            $gambar = 'Belum Upload';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Upload');
            }
            if ($field->gambar != '') {
                $gambar = aksiUrl($field->gambar, 'Lihat');
                if (bisaUbah($data['link'], $data['id_level'])) {
                    $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Ganti');
                }
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = tgl_indo($field->tanggal);
            $row[] = $nama;
            $row[] = $pnama;
            $row[] = $gambar;
            $row[] = $edit . '&nbsp;' . $hapus . '&nbsp;' . $cetak;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_layanan03->count_all($where),
            "recordsFiltered" => $this->model_layanan03->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function keterangansiswatambah()
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Siswa';
        $data['link'] = 'layanan/keterangansiswa';
        $table = 'layanan_03';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'keterangan' => posttext('keterangan'),
                    'id_siswa' => posttext('id_siswa'),
                    'create_user' => $data['id_user']
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/layanan/siswa/keterangansiswa/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function keterangansiswacetak($seo)
    {
        $data = $this->data;
        $this->pdf->portraitnopage();
        $id = dekrip($seo);
        $data['rows'] = $this->model_layanan->layanan03($id);
        $this->load->view('admin/layanan/siswa/keterangansiswa/cetak', $data);
    }

    function keterangansiswaedit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Siswa';
        $data['link'] = 'layanan/keterangansiswa';
        $table = 'layanan_03';
        $where = array('id' => dekrip($seo));
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'keterangan' => posttext('keterangan'),
                    'id_siswa' => posttext('id_siswa')
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_layanan->layanan03(dekrip($seo));
                $this->template->load('admin', 'admin/layanan/siswa/keterangansiswa/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function keterangansiswahapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Siswa';
        $data['link'] = 'layanan/keterangansiswa';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_03', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function skbb()
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Berkelakuan Baik';
        $data['link'] = 'layanan/skbb';
        $table = 'layanan_04';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['upload'])) {
                if (!empty($_FILES['gambar']['name'])) {
                    $where = array('id' => postnumber('id'));
                    $info = $this->model_app->edit($table, $where)->row_array();
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
                    $this->session->set_flashdata('gagal', 'File Masih Kosong');
                }
                redirect(current_url());
            } else {
                $this->template->load('admin', 'admin/layanan/siswa/skbb/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function skbbget()
    {
        $data = $this->data;
        $this->load->model('model_layanan04');
        $data['link'] = 'layanan/skbb';
        $where = array('YEAR(tanggal)' => $data['tahun']);

        $list = $this->model_layanan04->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $edit = '';
            $hapus = '';
            if (bisaUbah($data['link'], $data['id_level']) and $field->gambar == '') {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
            }

            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }

            // $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');
            $cetak = aksiCetak($data['link'] . 'cetak', enkrip($field->id), '');
            $nama = stripcslashes($field->nama);
            $pnama = stripcslashes($field->pnama);

            $gambar = 'Belum Upload';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Upload');
            }
            if ($field->gambar != '') {
                $gambar = aksiUrl($field->gambar, 'Lihat');
                if (bisaUbah($data['link'], $data['id_level'])) {
                    $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Ganti');
                }
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = tgl_indo($field->tanggal);
            $row[] = $nama;
            $row[] = $pnama;
            $row[] = $gambar;
            $row[] = $edit . '&nbsp;' . $hapus . '&nbsp;' . $cetak;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_layanan04->count_all($where),
            "recordsFiltered" => $this->model_layanan04->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function skbbtambah()
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Berkelakuan Baik';
        $data['link'] = 'layanan/skbb';
        $table = 'layanan_04';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'keterangan' => posttext('keterangan'),
                    'id_siswa' => posttext('id_siswa'),
                    'create_user' => $data['id_user']
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/layanan/siswa/skbb/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function skbbcetak($seo)
    {
        $data = $this->data;
        $this->pdf->portraitnopage();
        $id = dekrip($seo);
        $data['rows'] = $this->model_layanan->layanan04($id);
        $this->load->view('admin/layanan/siswa/skbb/cetak', $data);
    }

    function skbbedit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Berkelakuan Baik';
        $data['link'] = 'layanan/skbb';
        $table = 'layanan_04';
        $where = array('id' => dekrip($seo));
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'keterangan' => posttext('keterangan'),
                    'id_siswa' => posttext('id_siswa')
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_layanan->layanan04(dekrip($seo));
                $this->template->load('admin', 'admin/layanan/siswa/skbb/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function skbbhapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Berkelakuan Baik';
        $data['link'] = 'layanan/skbb';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_04', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function rekomendasisiswa()
    {
        $data = $this->data;
        $data['title'] = 'Surat Rekomendasi Siswa';
        $data['link'] = 'layanan/rekomendasisiswa';
        $table = 'layanan_05';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['upload'])) {
                if (!empty($_FILES['gambar']['name'])) {
                    $where = array('id' => postnumber('id'));
                    $info = $this->model_app->edit($table, $where)->row_array();
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
                    $this->session->set_flashdata('gagal', 'File Masih Kosong');
                }
                redirect(current_url());
            } else {
                $this->template->load('admin', 'admin/layanan/siswa/rekomendasisiswa/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function rekomendasisiswaget()
    {
        $data = $this->data;
        $this->load->model('model_layanan05');
        $data['link'] = 'layanan/rekomendasisiswa';
        $where = array('YEAR(tanggal)' => $data['tahun']);

        $list = $this->model_layanan05->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $edit = '';
            $hapus = '';
            if (bisaUbah($data['link'], $data['id_level']) and $field->gambar == '') {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
            }

            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }

            // $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');
            $cetak = aksiCetak($data['link'] . 'cetak', enkrip($field->id), '');
            $nama = stripcslashes($field->nama);
            $pnama = stripcslashes($field->pnama);

            $gambar = 'Belum Upload';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Upload');
            }
            if ($field->gambar != '') {
                $gambar = aksiUrl($field->gambar, 'Lihat');
                if (bisaUbah($data['link'], $data['id_level'])) {
                    $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Ganti');
                }
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = tgl_indo($field->tanggal);
            $row[] = $nama;
            $row[] = $field->nisn;
            $row[] = stripslashes($field->sekolah_asal);
            $row[] = $pnama;
            $row[] = $gambar;
            $row[] = $edit . '&nbsp;' . $hapus . '&nbsp;' . $cetak;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_layanan05->count_all($where),
            "recordsFiltered" => $this->model_layanan05->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function rekomendasisiswatambah()
    {
        $data = $this->data;
        $data['title'] = 'Surat Rekomendasi Siswa';
        $data['link'] = 'layanan/rekomendasisiswa';
        $table = 'layanan_05';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'pengantar' => posttext('pengantar'),
                    'keterangan' => posttext('keterangan'),
                    'nama' => posttext('nama'),
                    'nisn' => posttext('nisn'),
                    'tempat_lahir' => posttext('tempat_lahir'),
                    'tgl_lahir' => posttext('tgl_lahir'),
                    'jk' => posttext('jk'),
                    'sekolah_asal' => posttext('sekolah_asal'),
                    'alamat' => posttext('alamat'),
                    'kelas' => posttext('kelas'),
                    'jurusan' => posttext('jurusan'),
                    'nama_ortu' => posttext('nama_ortu'),
                    'create_user' => $data['id_user']
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/layanan/siswa/rekomendasisiswa/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function rekomendasisiswacetak($seo)
    {
        $data = $this->data;
        $this->pdf->portraitnopage();
        $id = dekrip($seo);
        $data['rows'] = $this->model_layanan->layanan05($id);
        $this->load->view('admin/layanan/siswa/rekomendasisiswa/cetak', $data);
    }

    function rekomendasisiswaedit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Rekomendasi Siswa';
        $data['link'] = 'layanan/rekomendasisiswa';
        $table = 'layanan_05';
        $where = array('id' => dekrip($seo));
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'keterangan' => posttext('keterangan'),
                    'pengantar' => posttext('pengantar'),
                    'nama' => posttext('nama'),
                    'nisn' => posttext('nisn'),
                    'tempat_lahir' => posttext('tempat_lahir'),
                    'tgl_lahir' => posttext('tgl_lahir'),
                    'jk' => posttext('jk'),
                    'sekolah_asal' => posttext('sekolah_asal'),
                    'alamat' => posttext('alamat'),
                    'kelas' => posttext('kelas'),
                    'jurusan' => posttext('jurusan'),
                    'nama_ortu' => posttext('nama_ortu')
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_layanan->layanan05(dekrip($seo));
                $this->template->load('admin', 'admin/layanan/siswa/rekomendasisiswa/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function rekomendasisiswahapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Rekomendasi Siswa';
        $data['link'] = 'layanan/rekomendasisiswa';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_05', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function gajiberkala()
    {
        $data = $this->data;
        $data['title'] = 'Usulan SK Kenaikan Gaji Berkala';
        $data['link'] = 'layanan/gajiberkala';
        $table = 'layanan_06';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['upload'])) {
                if (!empty($_FILES['gambar']['name'])) {
                    $where = array('id' => postnumber('id'));
                    $info = $this->model_app->edit($table, $where)->row_array();
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
                    $this->session->set_flashdata('gagal', 'File Masih Kosong');
                }
                redirect(current_url());
            } else {
                $this->template->load('admin', 'admin/layanan/guru/gajiberkala/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function gajiberkalaget()
    {
        $data = $this->data;
        $this->load->model('model_layanan06');
        $data['link'] = 'layanan/gajiberkala';
        $where = array('YEAR(tanggal)' => $data['tahun']);

        $list = $this->model_layanan06->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $edit = '';
            $hapus = '';
            if (bisaUbah($data['link'], $data['id_level']) and $field->gambar == '') {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
            }

            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }

            // $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');
            $cetak = aksiCetak($data['link'] . 'cetak', enkrip($field->id), '');
            $nama = stripcslashes($field->nama);

            $gambar = 'Belum Upload';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Upload');
            }
            if ($field->gambar != '') {
                $gambar = aksiUrl($field->gambar, 'Lihat');
                if (bisaUbah($data['link'], $data['id_level'])) {
                    $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Ganti');
                }
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = tgl_indo($field->tanggal);
            $row[] = $nama;
            $row[] = stripslashes($field->hal);
            $row[] = $gambar;
            $row[] = $edit . '&nbsp;' . $hapus . '&nbsp;' . $cetak;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_layanan06->count_all($where),
            "recordsFiltered" => $this->model_layanan06->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function gajiberkalatambah()
    {
        $data = $this->data;
        $data['title'] = 'Usulan SK Kenaikan Gaji Berkala';
        $data['link'] = 'layanan/gajiberkala';
        $table = 'layanan_06';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $pelaksana = postnumber('pelaksana');
                $simpan = array(
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'hal' => posttext('hal'),
                    'lampiran' => posttext('lampiran'),
                    'keterangan' => posttext('keterangan'),
                    'create_user' => $data['id_user']
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $id = $this->db->insert_id();
                    $peserta = array();
                    $total = count($pelaksana);
                    for ($i = 0; $i < $total; $i++) {
                        $peserta[] = array('id_layanan' => $id, 'id_ptk' => $pelaksana[$i]);
                    }
                    $this->model_app->insert_multiple_update($table . '_peserta', $peserta);
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/layanan/guru/gajiberkala/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function gajiberkalacetak($seo)
    {
        $data = $this->data;
        $this->pdf->portraitnopage();
        $id = dekrip($seo);
        $table = 'layanan_06';
        $data['rows'] = $this->model_layanan->layanan06($id);
        $data['record'] = $this->model_layanan->layanan06peserta($id);
        $this->load->view('admin/layanan/guru/gajiberkala/cetak', $data);
    }

    function gajiberkalaedit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Usulan SK Kenaikan Gaji Berkala';
        $data['link'] = 'layanan/gajiberkala';
        $table = 'layanan_06';
        $id = dekrip($seo);
        $where = array('id' => dekrip($seo));
        if (bisaUbah($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {

                $simpan = array(
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'hal' => posttext('hal'),
                    'lampiran' => posttext('lampiran'),
                    'keterangan' => posttext('keterangan')
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else if (isset($_POST['tambah'])) {
                $simpan = array(
                    'id_layanan' => postnumber('id_layanan'),
                    'id_ptk' => postnumber('id_ptk')
                );
                $this->model_app->insert($table . '_peserta', $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect(current_url());
            } else {
                $data['rows'] = $this->model_app->edit($table, $where)->row_array();
                $data['record'] = $this->model_layanan->layanan06peserta($id);
                $this->template->load('admin', 'admin/layanan/guru/gajiberkala/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function gajiberkalahapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Usulan SK Kenaikan Gaji Berkala';
        $data['link'] = 'layanan/gajiberkala';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_06', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function gajiberkalapesertahapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Usulan SK Kenaikan Gaji Berkala';
        $data['link'] = 'layanan/gajiberkala';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_06_peserta', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function keteranganpenelitian()
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Telah Melaksanakan Penelitian';
        $data['link'] = 'layanan/keteranganpenelitian';
        $table = 'layanan_07';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['upload'])) {
                if (!empty($_FILES['gambar']['name'])) {
                    $where = array('id' => postnumber('id'));
                    $info = $this->model_app->edit($table, $where)->row_array();
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
                    $this->session->set_flashdata('gagal', 'File Masih Kosong');
                }
                redirect(current_url());
            } else {
                $this->template->load('admin', 'admin/layanan/eksternal/keteranganpenelitian/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function keteranganpenelitianget()
    {
        $data = $this->data;
        $this->load->model('model_layanan07');
        $data['link'] = 'layanan/keteranganpenelitian';
        $where = array('YEAR(tanggal)' => $data['tahun']);

        $list = $this->model_layanan07->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $edit = '';
            $hapus = '';
            if (bisaUbah($data['link'], $data['id_level']) and $field->gambar == '') {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
            }

            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }

            // $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');
            $cetak = aksiCetak($data['link'] . 'cetak', enkrip($field->id), '');
            $nama = stripcslashes($field->nama);
            $pnama = stripcslashes($field->pnama);

            $gambar = 'Belum Upload';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Upload');
            }
            if ($field->gambar != '') {
                $gambar = aksiUrl($field->gambar, 'Lihat');
                if (bisaUbah($data['link'], $data['id_level'])) {
                    $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Ganti');
                }
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = tgl_indo($field->tanggal);
            $row[] = $nama;
            $row[] = $field->npm;
            $row[] = stripslashes($field->prodi);
            $row[] = $pnama;
            $row[] = $gambar;
            $row[] = $edit . '&nbsp;' . $hapus . '&nbsp;' . $cetak;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_layanan07->count_all($where),
            "recordsFiltered" => $this->model_layanan07->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function keteranganpenelitiantambah()
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Telah Melaksanakan Penelitian';
        $data['link'] = 'layanan/keteranganpenelitian';
        $table = 'layanan_07';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'pengantar' => posttext('pengantar'),
                    'nama' => posttext('nama'),
                    'npm' => posttext('npm'),
                    'prodi' => posttext('prodi'),
                    'jenjang' => posttext('jenjang'),
                    'isi1' => posttext('isi1'),
                    'judul_penelitian' => posttext('judul_penelitian'),
                    'isi2' => posttext('isi2'),
                    'create_user' => $data['id_user']
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/layanan/eksternal/keteranganpenelitian/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function keteranganpenelitiancetak($seo)
    {
        $data = $this->data;
        $this->pdf->portraitnopage();
        $id = dekrip($seo);
        $data['rows'] = $this->model_layanan->layanan07($id);
        $this->load->view('admin/layanan/eksternal/keteranganpenelitian/cetak', $data);
    }

    function keteranganpenelitianedit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Telah Melaksanakan Penelitian';
        $data['link'] = 'layanan/keteranganpenelitian';
        $table = 'layanan_07';
        $where = array('id' => dekrip($seo));
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'pengantar' => posttext('pengantar'),
                    'nama' => posttext('nama'),
                    'npm' => posttext('npm'),
                    'prodi' => posttext('prodi'),
                    'jenjang' => posttext('jenjang'),
                    'isi1' => posttext('isi1'),
                    'judul_penelitian' => posttext('judul_penelitian'),
                    'isi2' => posttext('isi2')
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_layanan->layanan07(dekrip($seo));
                $this->template->load('admin', 'admin/layanan/eksternal/keteranganpenelitian/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function keteranganpenelitianhapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Telah Melaksanakan Penelitian';
        $data['link'] = 'layanan/keteranganpenelitian';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_07', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function izinpenelitian()
    {
        $data = $this->data;
        $data['title'] = 'Surat Izin Penelitian';
        $data['link'] = 'layanan/izinpenelitian';
        $table = 'layanan_08';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['upload'])) {
                if (!empty($_FILES['gambar']['name'])) {
                    $where = array('id' => postnumber('id'));
                    $info = $this->model_app->edit($table, $where)->row_array();
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
                    $this->session->set_flashdata('gagal', 'File Masih Kosong');
                }
                redirect(current_url());
            } else {
                $this->template->load('admin', 'admin/layanan/eksternal/izinpenelitian/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function izinpenelitianget()
    {
        $data = $this->data;
        $this->load->model('model_layanan08');
        $data['link'] = 'layanan/izinpenelitian';
        $where = array('YEAR(tanggal)' => $data['tahun']);

        $list = $this->model_layanan08->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $edit = '';
            $hapus = '';
            if (bisaUbah($data['link'], $data['id_level']) and $field->gambar == '') {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
            }

            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }

            // $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');
            $cetak = aksiCetak($data['link'] . 'cetak', enkrip($field->id), '');
            $nama = stripcslashes($field->nama);
            $pnama = stripcslashes($field->pnama);

            $gambar = 'Belum Upload';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Upload');
            }
            if ($field->gambar != '') {
                $gambar = aksiUrl($field->gambar, 'Lihat');
                if (bisaUbah($data['link'], $data['id_level'])) {
                    $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Ganti');
                }
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = tgl_indo($field->tanggal);
            $row[] = $nama;
            $row[] = $field->npm;
            $row[] = stripslashes($field->prodi);
            $row[] = $pnama;
            $row[] = $gambar;
            $row[] = $edit . '&nbsp;' . $hapus . '&nbsp;' . $cetak;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_layanan08->count_all($where),
            "recordsFiltered" => $this->model_layanan08->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function izinpenelitiantambah()
    {
        $data = $this->data;
        $data['title'] = 'Surat Izin Penelitian';
        $data['link'] = 'layanan/izinpenelitian';
        $table = 'layanan_08';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'lampiran' => posttext('lampiran'),
                    'perihal' => posttext('perihal'),
                    'pengantar' => posttext('pengantar'),
                    'nama' => posttext('nama'),
                    'npm' => posttext('npm'),
                    'prodi' => posttext('prodi'),
                    'judul' => posttext('judul'),
                    'isi' => posttext('isi'),
                    'keterangan' => posttext('keterangan'),
                    'create_user' => $data['id_user']
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/layanan/eksternal/izinpenelitian/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function izinpenelitiancetak($seo)
    {
        $data = $this->data;
        $this->pdf->portraitnopage();
        $id = dekrip($seo);
        $data['rows'] = $this->model_layanan->layanan08($id);
        $this->load->view('admin/layanan/eksternal/izinpenelitian/cetak', $data);
    }

    function izinpenelitianedit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Izin Penelitian';
        $data['link'] = 'layanan/izinpenelitian';
        $table = 'layanan_08';
        $where = array('id' => dekrip($seo));
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'lampiran' => posttext('lampiran'),
                    'perihal' => posttext('perihal'),
                    'pengantar' => posttext('pengantar'),
                    'nama' => posttext('nama'),
                    'npm' => posttext('npm'),
                    'prodi' => posttext('prodi'),
                    'judul' => posttext('judul'),
                    'isi' => posttext('isi'),
                    'keterangan' => posttext('keterangan'),
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_layanan->layanan08(dekrip($seo));
                $this->template->load('admin', 'admin/layanan/eksternal/izinpenelitian/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function izinpenelitianhapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Izin Penelitian';
        $data['link'] = 'layanan/izinpenelitian';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_08', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function penyerahanskripsi()
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Telah Menyerahkan Skripsi';
        $data['link'] = 'layanan/penyerahanskripsi';
        $table = 'layanan_09';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['upload'])) {
                if (!empty($_FILES['gambar']['name'])) {
                    $where = array('id' => postnumber('id'));
                    $info = $this->model_app->edit($table, $where)->row_array();
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
                    $this->session->set_flashdata('gagal', 'File Masih Kosong');
                }
                redirect(current_url());
            } else {
                $this->template->load('admin', 'admin/layanan/eksternal/penyerahanskripsi/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function penyerahanskripsiget()
    {
        $data = $this->data;
        $this->load->model('model_layanan09');
        $data['link'] = 'layanan/penyerahanskripsi';
        $where = array('YEAR(tanggal)' => $data['tahun']);

        $list = $this->model_layanan09->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $edit = '';
            $hapus = '';
            if (bisaUbah($data['link'], $data['id_level']) and $field->gambar == '') {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
            }

            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }

            // $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');
            $cetak = aksiCetak($data['link'] . 'cetak', enkrip($field->id), '');
            $nama = stripcslashes($field->nama);
            $pnama = stripcslashes($field->pnama);

            $gambar = 'Belum Upload';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Upload');
            }
            if ($field->gambar != '') {
                $gambar = aksiUrl($field->gambar, 'Lihat');
                if (bisaUbah($data['link'], $data['id_level'])) {
                    $gambar .= '<br>' . aksiModalUploadId('#modalUpload', $field->id, 'Ganti');
                }
            }


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nomor;
            $row[] = tgl_indo($field->tanggal);
            $row[] = $nama;
            $row[] = $field->npm;
            $row[] = stripslashes($field->prodi);
            $row[] = $pnama;
            $row[] = $gambar;
            $row[] = $edit . '&nbsp;' . $hapus . '&nbsp;' . $cetak;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_layanan09->count_all($where),
            "recordsFiltered" => $this->model_layanan09->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function penyerahanskripsitambah()
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Telah Menyerahkan Skripsi';
        $data['link'] = 'layanan/penyerahanskripsi';
        $table = 'layanan_09';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'pengantar' => posttext('pengantar'),
                    'nama' => posttext('nama'),
                    'npm' => posttext('npm'),
                    'prodi' => posttext('prodi'),
                    'jenjang' => posttext('jenjang'),
                    'keterangan' => posttext('keterangan'),
                    'judul_skripsi' => posttext('judul_skripsi'),
                    'create_user' => $data['id_user']
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/layanan/eksternal/penyerahanskripsi/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function penyerahanskripsicetak($seo)
    {
        $data = $this->data;
        $this->pdf->portraitnopage();
        $id = dekrip($seo);
        $data['rows'] = $this->model_layanan->layanan09($id);
        $this->load->view('admin/layanan/eksternal/penyerahanskripsi/cetak', $data);
    }

    function penyerahanskripsiedit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Telah Menyerahkan Skripsi';
        $data['link'] = 'layanan/penyerahanskripsi';
        $table = 'layanan_09';
        $where = array('id' => dekrip($seo));
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'judul_surat' => posttext('judul_surat'),
                    'nomor' => posttext('nomor'),
                    'tanggal' => postnumber('tanggal'),
                    'penandatangan' => postnumber('penandatangan'),
                    'pengantar' => posttext('pengantar'),
                    'nama' => posttext('nama'),
                    'npm' => posttext('npm'),
                    'prodi' => posttext('prodi'),
                    'jenjang' => posttext('jenjang'),
                    'keterangan' => posttext('keterangan'),
                    'judul_skripsi' => posttext('judul_skripsi')
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_layanan->layanan09(dekrip($seo));
                $this->template->load('admin', 'admin/layanan/eksternal/penyerahanskripsi/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function penyerahanskripsihapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Surat Keterangan Telah Menyerahkan Skripsi';
        $data['link'] = 'layanan/penyerahanskripsi';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_09', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }


    function penandatangan()
    {
        $data = $this->data;
        $data['link'] = 'layanan/penandatangan';
        $data['title'] = 'Penandatangan';
        if (bisaBaca($data['link'], $data['id_level'])) {
            if (isset($_POST['tambah'])) {

                $simpan = array(
                    'jabatan' => posttext('jabatan'),
                    'nama' => posttext('nama'),
                    'nip' => posttext('nip'),
                    'pangkat' => posttext('pangkat'),
                    'kategori' => posttext('kategori')
                );

                $this->model_app->insert('layanan_penandatangan', $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else if (isset($_POST['edit'])) {

                $simpan = array(
                    'jabatan' => posttext('jabatan'),
                    'nama' => posttext('nama'),
                    'nip' => posttext('nip'),
                    'pangkat' => posttext('pangkat'),
                    'kategori' => posttext('kategori')
                );
                $where = array('id' => $this->input->post('id'));
                $this->model_app->update('layanan_penandatangan', $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {

                $data['record'] = $this->model_app->view_ordering('layanan_penandatangan', 'id', 'ASC');
                $this->template->load('admin', 'admin/layanan/penandatangan/data', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function penandatanganedit()
    {
        if (isset($_POST['rowid'])) {
            $id = $this->input->post('rowid');
            // mengambil data berdasarkan id
            // dan menampilkan data ke dalam form modal bootstrap
            $sql = $this->model_app->edit('layanan_penandatangan', array('id' => $id))->row_array();

            echo '
        <input type="hidden" name="id" value="' . $id . '">
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Nama</label>
                  <div class="col-sm-9">
                    <input type="text" name="nama" value="' . stripslashes($sql['nama']) . '" class="form-control" required>
                  </div>
             </div>
             <div class="form-group row">
             <label class="col-sm-3 control-label ">NIP</label>
             <div class="col-sm-9">
               <input type="text" name="nip" value="' . stripslashes($sql['nip']) . '" class="form-control">
             </div>
        </div>
             <div class="form-group row">
                  <label class="col-sm-3 control-label ">Jabatan</label>
                  <div class="col-sm-9">
                    <input type="text" name="jabatan" value="' . stripslashes($sql['jabatan']) . '" class="form-control" required>
                  </div>
             </div>
             <div class="form-group row">
                  <label class="col-sm-3 control-label ">Pangkat/ Golongan</label>
                  <div class="col-sm-9">
                    <input type="text" name="pangkat" value="' . stripslashes($sql['pangkat']) . '" class="form-control">
                  </div>
             </div>
             <div class="form-group row">
                  <label class="col-sm-3 control-label ">Kategori</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="kategori" required>
                    ' . opEnum('layanan_penandatangan', 'kategori', $sql['kategori']) . '
                    </select>
                  </div>
             </div>
           
            ';
        }
    }

    function bukutamu()
    {
        $data = $this->data;
        $data['title'] = 'Buku Tamu';
        $data['link'] = 'layanan/bukutamu';
        $table = 'layanan_bukutamu';
        if (bisaBaca($data['link'], $data['id_level'])) {
            $this->template->load('admin', 'admin/layanan/bukutamu/data', $data);
        } else {
            redirect('dashboard');
        }
    }

    function bukutamuget()
    {
        $data = $this->data;
        $this->load->model('model_bukutamu');
        $data['link'] = 'layanan/bukutamu';
        $where = array('YEAR(tanggal)' => $data['tahun']);

        $list = $this->model_bukutamu->get_datatables($where);
        $no = $_POST['start'];
        $record = array();
        foreach ($list as $field) {
            $edit = '';
            $hapus = '';
            if (bisaUbah($data['link'], $data['id_level'])) {
                $edit = aksiEdit($data['link'] . 'edit', enkrip($field->id), '');
            }

            if (bisaHapus($data['link'], $data['id_level'])) {
                $hapus = aksiHapusSwal($data['link'] . 'hapus', enkrip($field->id), '');
            }

            $detail = aksiDetail($data['link'] . 'detail', enkrip($field->id), '');



            $no++;
            $row = array();
            $row[] = $no;
            $row[] = tgl_view($field->tanggal);
            $row[] = stripslashes($field->nama) . '/ ' . $field->nik;
            $row[] = stripslashes($field->instansi);
            $row[] = stripslashes($field->pekerjaan);
            $row[] = stripslashes($field->tujuan);
            $row[] = stripslashes($field->keperluan);
            $row[] = $detail . '&nbsp;' . $edit . '&nbsp;' . $hapus;
            $record[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_bukutamu->count_all($where),
            "recordsFiltered" => $this->model_bukutamu->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function bukutamutambah()
    {
        $data = $this->data;
        $data['title'] = 'Buku Tamu';
        $data['link'] = 'layanan/bukutamu';
        $table = 'layanan_bukutamu';
        if (bisaTulis($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'tanggal' => postnumber('tanggal'),
                    'waktu' => postnumber('waktu'),
                    'nama' => posttext('nama'),
                    'nik' => posttext('nik'),
                    'alamat' => posttext('alamat'),
                    'instansi' => posttext('instansi'),
                    'pekerjaan' => posttext('pekerjaan'),
                    'jabatan' => posttext('jabatan'),
                    'tujuan' => posttext('tujuan'),
                    'keperluan' => posttext('keperluan'),
                    'create_user' => $data['id_user'],
                    'mod_user' => $data['id_user']
                );
                $this->model_app->insert($table, $simpan);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $this->template->load('admin', 'admin/layanan/bukutamu/tambah', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function bukutamuedit($seo)
    {
        $data = $this->data;
        $data['title'] = 'Buku Tamu';
        $data['link'] = 'layanan/bukutamu';
        $table = 'layanan_bukutamu';
        $where = array('id' => dekrip($seo));
        if (bisaUbah($data['link'], $data['id_level'])) {
            if (isset($_POST['simpan'])) {
                $simpan = array(
                    'tanggal' => postnumber('tanggal'),
                    'waktu' => postnumber('waktu'),
                    'nama' => posttext('nama'),
                    'nik' => posttext('nik'),
                    'alamat' => posttext('alamat'),
                    'instansi' => posttext('instansi'),
                    'pekerjaan' => posttext('pekerjaan'),
                    'jabatan' => posttext('jabatan'),
                    'tujuan' => posttext('tujuan'),
                    'keperluan' => posttext('keperluan'),
                    'mod_at' => date('Y-m-d H:i:s'),
                    'mod_user' => $data['id_user']
                );
                $this->model_app->update($table, $simpan, $where);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('sukses', 'Data ' . $data['title'] . ' Berhasil Disimpan');
                } else {
                    $this->session->set_flashdata('gagal', 'Data ' . $data['title'] . ' Gagal Disimpan');
                }
                redirect($data['link']);
            } else {
                $data['rows'] = $this->model_app->edit($table, $where)->row_array();
                $this->template->load('admin', 'admin/layanan/bukutamu/edit', $data);
            }
        } else {
            redirect('dashboard');
        }
    }

    function bukutamuhapus($seo)
    {
        $data = $this->data;
        $data['title'] = 'Buku Tamu';
        $data['link'] = 'layanan/bukutamu';

        if (bisaHapus($data['link'], $data['id_level'])) {
            $where = array('id' => dekrip($seo));
            $this->model_app->delete('layanan_bukutamu', $where);

            if ($this->db->affected_rows() > 0) {
                $hasil = array('hasil' => 'sukses', 'pesan' => $data['title'] . ' Berhasil Dihapus ');
            } else {
                $hasil = array('hasil' => 'gagal', 'pesan' => $data['title'] . ' Gagal Dihapus');
            }
            // redirect($data['link']);
            echo json_encode($hasil);
        } else {
            redirect('dashboard');
        }
    }

    function bukutamudetail($seo)
    {
        $data = $this->data;
        $data['title'] = 'Buku Tamu';
        $data['link'] = 'layanan/bukutamu';
        $table = 'layanan_bukutamu';
        $where = array('id' => dekrip($seo));
        if (bisaBaca($data['link'], $data['id_level'])) {
            $data['rows'] = $this->model_app->edit($table, $where)->row_array();
            $this->template->load('admin', 'admin/layanan/bukutamu/detail', $data);
        } else {
            redirect('dashboard');
        }
    }
} //controller