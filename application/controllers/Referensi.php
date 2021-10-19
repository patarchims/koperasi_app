<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referensi extends CI_Controller {

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
            'header'=>'Referensi',
            'ctrl'=>'referensi'
        );
        
    }
    function index(){
        redirect('dashboard');
    }

    function kode(){
        $data=$this->data;
        $id_level=$this->session->level;
        $link='referensi/kode';
        $data['title']='Kode Aplikasi';
        $data['id_level']=$id_level;
        $data['link']=$link;
        $data['ctrl']='referensi';
        $data['ta']=$this->session->ta;

        if(bisaBaca($link,$id_level))
        {
            if (isset($_POST['submit']))
            {
                            
                $data = array('idxref'=>$this->input->post('kd'),
                              'referensi'=>$this->input->post('ket')
                            );
                
                $this->model_app->insert('tbrefa',$data);  
                redirect($link);
            }
            else
            {
                $data['record']=$this->model_app->view_kode();
                $this->template->load('admin','admin/referensi/kode/data',$data);
            }
        }
        else
        {
            redirect('dashboard');
        }
    }

    function kodedetail(){
        $data=$this->data;
        $id_level=$this->session->level;
        $link='referensi/kode';
        $data['title']='Kode Aplikasi';
        $data['id_level']=$id_level;
        $data['link']=$link;
        $data['ctrl']='referensi';
        $data['ta']=$this->session->ta;

        if(bisaBaca($link,$id_level))
        {
            if (isset($_POST['submit']))
            {
                            
                $data = array('idxref'=>$this->input->post('kd'),
                              'kderef'=>$this->input->post('kode'),
                              'nmaref1'=>$this->input->post('nmaref1'),
                              'nmaref2'=>$this->input->post('nmaref2'),
                              'nmaref3'=>$this->input->post('nmaref3'),
                              'kdedikti'=>$this->input->post('kdedikti')
                             );
                
                $this->model_app->insert('tbrefb',$data);  
                redirect('referensi/kodedetail/'.$this->input->post('kd'));
            }
            else if (isset($_POST['edit'])) 
            {
                
                $data = array('kderef'=>$this->input->post('kode'),
                              'nmaref1'=>$this->input->post('nmaref1'),
                              'nmaref2'=>$this->input->post('nmaref2'),
                              'nmaref3'=>$this->input->post('nmaref3'),
                              'kdedikti'=>$this->input->post('kdedikti'));
                $where = array('id' => $this->input->post('id'));
                $edit=$this->model_app->update('tbrefb', $data, $where);
                if($edit)
                    {
                        $this->session->set_flashdata('sukses',"Data Kode Aplikasi Berhasil Diedit");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Kode Aplikasi Gagal Diedit");
                    }
                redirect('referensi/kodedetail/'.$this->input->post('kd'));
            }
            else
            {
                $aplikasi=$this->uri->segment('3');
                $data['aplikasi']=$aplikasi;
                $data['record']=$this->model_app->view_where_ordering('tbrefb',array('idxref'=>$aplikasi),'id','ASC');
                $this->template->load('admin','admin/referensi/kode/detail',$data);
            }
            
        }
        else
        {
            redirect('dashboard');
        }
    }

    function kodehapus(){
        $id_level=$this->session->level;
        $link='referensi/kode';

        if(bisaHapus($link,$id_level))
        {
        $id = array('id' => dekrip($this->uri->segment(4)));
        $hapus=$this->model_app->delete('tbrefb',$id);
        if($hapus)
            {
                $this->session->set_flashdata('sukses',"Data Kode Aplikasi Berhasil Dihapus");
            }
            else
            {
                $this->session->set_flashdata('gagal',"Data Kode Aplikasi Gagal Dihapus");
            }
        redirect('referensi/kodedetail/'.$this->uri->segment('3'));
        }
        else
        {
        redirect('referensi/kode'); 
        }
    }

    function jabatan(){
        $data=$this->data;
        $data['link']='referensi/jabatan';
        $data['title']='Jabatan';
        if(bisaBaca($data['link'],$data['id_level']))
        {
            if (isset($_POST['tambah']))
            {
                            
                $simpan = array('jabatan'=>posttext('jabatan'),
                              'urutan'=>postnumber('urutan')
                             );
                
                if($this->model_app->insert('jabatan',$simpan))
                    {
                        $this->session->set_flashdata('sukses',"Data Jabatan Berhasil Disimpan");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Jabatan Gagal Disimpan");
                    }  
                redirect($data['link']);
            }
            else if (isset($_POST['edit'])) 
            {
                
                $simpan = array('jabatan'=>posttext('jabatan'),
                              'urutan'=>postnumber('urutan')
                             );
                $where = array('id_jabatan' => $this->input->post('id'));
                if($this->model_app->update('jabatan', $simpan, $where))
                    {
                        $this->session->set_flashdata('sukses',"Data Jabatan Berhasil Diedit");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Jabatan Gagal Diedit");
                    }
                redirect($data['link']);
            }
            else
            {
                
                $data['record']=$this->model_app->view_ordering('jabatan','urutan','ASC');
                $this->template->load('admin','admin/referensi/jabatan/data',$data);
            }
            
        }
        else
        {
            redirect('dashboard');
        }
    }

    function jabatanedit(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('jabatan',array('id_jabatan'=>$id))->row_array();
         
        echo'
        <input type="hidden" name="id" value="'.$id.'">
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Nama Jabatan</label>
                  <div class="col-sm-9">
                    <input type="text" name="jabatan" value="'.$sql['jabatan'].'" class="form-control" required>
                  </div>
             </div>
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Urutan</label>
                  <div class="col-sm-9">
                    <input type="number" name="urutan" value="'.$sql['urutan'].'" class="form-control" required>
                  </div>
            </div>
            ';
        }
    }


    function kategoriberita(){
        $data=$this->data;
        $data['link']='referensi/kategoriberita';
        $data['title']='Kategori Berita';
        if(bisaBaca($data['link'],$data['id_level']))
        {
            if (isset($_POST['tambah']))
            {
                            
                $simpan = array('kategori'=>posttext('kategori'),
                                'seo'=>seo_title(posttext('kategori')),
                                'urutan'=>postnumber('urutan')
                             );
                
                if($this->model_app->insert('kategori_berita',$simpan))
                    {
                        $this->session->set_flashdata('sukses',"Data Kategori Berita Berhasil Disimpan");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Kategori Berita Gagal Disimpan");
                    }  
                redirect($data['link']);
            }
            else if (isset($_POST['edit'])) 
            {
                
                $simpan = array('kategori'=>posttext('kategori'),
                                'seo'=>seo_title(posttext('kategori')),
                              'urutan'=>postnumber('urutan')
                             );
                $where = array('id_kategori' => $this->input->post('id'));
                if($this->model_app->update('kategori_berita', $simpan, $where))
                    {
                        $this->session->set_flashdata('sukses',"Data Kategori Berita Berhasil Diedit");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Kategori Berita Gagal Diedit");
                    }
                redirect($data['link']);
            }
            else
            {
                
                $data['record']=$this->model_app->view_ordering('kategori_berita','urutan','ASC');
                $this->template->load('admin','admin/referensi/kategoriberita/data',$data);
            }
            
        }
        else
        {
            redirect('dashboard');
        }
    }

    function kategoriberitaedit(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('kategori',array('id_kategori'=>$id))->row_array();
         
        echo'
        <input type="hidden" name="id" value="'.$id.'">
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Nama Kategori Berita</label>
                  <div class="col-sm-9">
                    <input type="text" name="kategoriberita" value="'.$sql['kategori'].'" class="form-control" required>
                  </div>
             </div>
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Urutan</label>
                  <div class="col-sm-9">
                    <input type="number" name="urutan" value="'.$sql['urutan'].'" class="form-control" required>
                  </div>
            </div>
            ';
        }
    }

    
} //controller