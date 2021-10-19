<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan extends CI_Controller {

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

    function __construct(){
        parent::__construct(); // needed when adding a constructor to a controller
        $identitas=$this->model_app->edit('identitas',array('id'=>1))->row_array();
        $notif=api('api/notifikasi',array("npsn"=>$identitas['kode'],"uid"=>$identitas['uid']));
        $this->data = array(
            'identitas'=>$identitas,
            'id_level'=>$this->session->level,
            'notif'=>$notif->jumlah,
            'header'=>'Permintaan Data Oleh Dinas Pendidikan',
            'ctrl'=>'permintaan'
        );
        
    }
    function index(){
        redirect('dashboard');
    }

    function daftar(){
        $data=$this->data;
        $data['title']='Daftar Permintaan Data Oleh Dinas Pendidikan';
        $data['link']='permintaan/daftar';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $cek=api('api/permintaan',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid']));
            if($cek->action==true)
            {
                $data['permintaan']=$cek->jumlah;
                $data['isi']=$cek->isi;
                $data['hasil']=$cek->hasil;
                $data['belum']=$data['permintaan']-$data['isi'];
            }
            $this->template->load('admin','admin/permintaan/daftar/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function daftartambah($seo){
        $data=$this->data;
        $data['title']='Form Kirim File Permintaan Ke Dinas';
        $data['link']='permintaan/daftar';
        $data['seo']=$seo;
        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                
                if (!empty($_FILES['gambar']['name']))
                {
                    
                      $dir = dirname($_FILES["gambar"]["tmp_name"]);
                      $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                      rename($_FILES["gambar"]["tmp_name"], $destination);

                      $upload = $this->s3_upload->upload_file($destination);
                      if($upload!='')
                      {
                        
                        $kirim=array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid'],"id_permintaan"=>dekrip($seo),"judul"=>posttext('judul'),"keterangan"=>posttext('keterangan'),"gambar"=>$upload['uri'],"gambarkey"=>$upload['key'],"user"=>viewUser($this->session->id_user));
                        $cek=api('api/permintaansimpan',$kirim);
                        if($cek->action==true)
                        {
                          $this->session->set_flashdata('sukses','Data Berhasil Di Kirim Kedinas');
                        }
                        else
                        {
                          $this->session->set_flashdata('gagal','Data Gagal Di Kirim Ke Dinas');
                        }

                        
                      }
                      else
                      {
                        $this->session->set_flashdata('gagal','File Gagal Di Upload');
                      }
                    
                    
                }
                else
                {
                    $this->session->set_flashdata('gagal','File Masih Kosong');
                }
                
                redirect($data['link'].'detail/'.$seo);
            }
            else
            {
            $cek=api('api/permintaandetail',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid'],"id_permintaan"=>dekrip($seo)));
            $data['rows']=$cek->hasil;
            $this->template->load('admin','admin/permintaan/daftar/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function daftardetail($seo){
        $data=$this->data;
        $data['title']='Daftar Permintaan Data Oleh Dinas Pendidikan';
        $data['link']='permintaan/daftar';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
           $cek=api('api/permintaanfile',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid'],"id_permintaan"=>dekrip($seo)));
            $data['rows']=$cek->permintaan;
            $data['record']=$cek->hasil;
            $this->template->load('admin','admin/permintaan/daftar/detail',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function daftarhapus($seo,$id){
        $data=$this->data;
        $data['link']='permintaan/daftar';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $cek=api('api/permintaanfilehapus',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid'],"id"=>dekrip($id)));

            if($cek->action==true)
            {
                $hasil=$cek->hasil;
                $delete= $this->s3_upload->delete_file($hasil->gambarkey);
                $this->session->set_flashdata('sukses','File Berhasil Dihapus');
            }
            else
            {
                $this->session->set_flashdata('gagal','File Gagal Dihapus');
            }
           // redirect($data['link']);
            redirect($data['link'].'detail/'.$seo);

        }
        else
        {
            redirect('dashboard');
        }
    }
    
} //controller