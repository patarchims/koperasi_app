<?php
//require_once('vendor/autoload.php');
//require_once('application/libraries/S3.php');
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller {

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
            'header'=>'Website',
            'ctrl'=>'website'
        );
        
    }
    function index(){
        redirect('dashboard');
    }

    function berita(){
        $data=$this->data;
        $data['title']='Daftar Berita';
        $data['link']='website/berita';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/berita/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function beritatambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Berita';
        $data['link']='website/berita';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
              $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'tanggal'=>postnumber('tanggal'),
                              'id_kategori'=>postnumber('id_kategori'),
                              'keyword'=>posttext('keyword'),
                              'isi'=>postnumber('isi'),
                              'input_user'=>$this->session->id_user
                             );
                if($this->model_app->insert('berita',$simpan))
                {
                    $id=$this->db->insert_id();
                    if (!empty($_FILES['gambar']['name']))
                    {
                        
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                          if($upload!='')
                          {
                            
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $where=array('id_berita'=>$id);
                            $this->model_app->update('berita',$update,$where);
                            $this->session->set_flashdata('sukses','Data Berita Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                            $this->session->set_flashdata('gagal','Data Berita Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                        
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan dan Anda Tidak Mengupload Foto');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Berhasil Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/berita/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function beritaedit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Berita';
        $data['link']='website/berita';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_berita'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'tanggal'=>postnumber('tanggal'),
                              'id_kategori'=>postnumber('id_kategori'),
                              'keyword'=>posttext('keyword'),
                              'isi'=>postnumber('isi'),
                              'mod_at'=>date('Y-m-d'),
                              'mod_user'=>$this->session->id_user
                             );
                if($this->model_app->update('berita',$simpan,$where))
                {
                    if (!empty($_FILES['gambar']['name']))
                    {
                      
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                         // var_dump($upload);
                         
                          if($upload!='')
                          {
                            $info=$this->model_app->edit('berita',$where)->row_array();
                            if($info['gambarkey']!='')
                            {
                             $delete= $this->s3_upload->delete_file($info['gambarkey']);
                            }
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $this->model_app->update('berita',$update,$where);
                            $this->session->set_flashdata('sukses','Data Berita Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                          
                            $this->session->set_flashdata('gagal',' Data Berita Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                     
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Berita Berhasil Disimpan dan Anda Tidak Mengganti Foto');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Berita Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('berita',array('id_berita'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/berita/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function beritadetail($seo){
        $data=$this->data;
        $data['title']='Data Berita';
        $data['link']='website/berita';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            $data['rows']=$this->model_app->edit('berita',array('id_berita'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/berita/detail',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function beritahapus($seo){
        $data=$this->data;
        $data['title']='Data Berita';
        $data['link']='website/berita';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_berita'=>dekrip($seo));
            $info=$this->model_app->edit('berita',$where)->row_array();
            $hapus=$this->model_app->delete('berita',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Berita Berhasil Dihapus ');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Berita Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function beritaaktif($id,$status){
        $query = $this->db->query("CALL aktifBerita(".$id.",".$status.")");
    }

    function get_berita()
    {
        $data=$this->data;
        $this->load->model('model_berita');
        $data['link']='website/berita';
        $where=array();
        
        
        $list = $this->model_berita->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            $status=aksiAktif('website/beritaaktif',$field->id_berita,$field->pub);
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_berita),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_berita),'');
            }
            $detail=aksiDetail($data['link'].'detail',enkrip($field->id_berita),'');
            $judul=stripcslashes($field->judul);
            $foto=gambarAws($field->gambar);
            
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = '<a href="'.$foto.'" data-toggle="lightbox" data-title="'.$judul.'" >
                        <img src="'.$foto.'" width="75">
                    </a>';
            $row[] = tgl_view($field->tanggal);
            $row[] = $judul;
            $row[] = $field->kategori;
            $row[] = $status;
            $row[] = $field->dibaca;
            $row[] = viewUser($field->input_user);
            $row[] = $detail.'&nbsp;'.$edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_berita->count_all($where),
            "recordsFiltered" => $this->model_berita->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }


    function halaman(){
        $data=$this->data;
        $data['title']='Daftar Halaman';
        $data['link']='website/halaman';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/halaman/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function halamantambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Halaman';
        $data['link']='website/halaman';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
              $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'jenis'=>posttext('jenis'),
                              'urutan'=>postnumber('urutan'),
                              'isi'=>postnumber('isi'),
                              'input_user'=>$this->session->id_user
                             );
                if($this->model_app->insert('halaman',$simpan))
                {
                    $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan');
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Berhasil Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/halaman/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function halamanedit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Halaman';
        $data['link']='website/halaman';

        if(bisaUbah($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_halaman'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'jenis'=>posttext('jenis'),
                              'urutan'=>postnumber('urutan'),
                              'isi'=>postnumber('isi'),
                              'mod_at'=>date('Y-m-d'),
                              'mod_user'=>$this->session->id_user
                             );
                if($this->model_app->update('halaman',$simpan,$where))
                {
                    
                  $this->session->set_flashdata('sukses','Data Halaman Berhasil Disimpan');
                    
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Halaman Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('halaman',array('id_halaman'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/halaman/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function halamandetail(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('halaman',array('id_halaman'=>$id))->row_array();
         
        echo $sql['isi'];
        }
    }

    function halamanhapus($seo){
        $data=$this->data;
        $data['title']='Data Halaman';
        $data['link']='website/halaman';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $hapus=$this->model_app->delete('halaman',array('id_halaman'=>dekrip($seo)));

            if($this->db->affected_rows()>0)
            {
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Halaman Berhasil Dihapus');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Halaman Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function halamanaktif($id,$status){
        $query = $this->db->query("CALL aktifHalaman(".$id.",".$status.")");
    }

    function get_halaman()
    {
        $data=$this->data;
        $this->load->model('model_halaman');
        $data['link']='website/halaman';
        $where=array();
        
        
        $list = $this->model_halaman->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            $status=aksiAktif('website/halamanaktif',$field->id_halaman,$field->aktif);
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_halaman),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_halaman),'');
            }
            $detail=aksiModalLihat('#modalLihat',$field->id_halaman,'Lihat');
            $judul=stripcslashes($field->judul);
            
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = $judul;
            $row[] = $field->jenis;
            $row[] = $status;
            $row[] = $field->urutan;
            $row[] = $field->dibaca;
            $row[] = $detail;
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_halaman->count_all($where),
            "recordsFiltered" => $this->model_halaman->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }


    function slider(){
        $data=$this->data;
        $data['title']='Daftar Slider';
        $data['link']='website/slider';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/slider/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function slidertambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Slider';
        $data['link']='website/slider';

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
                            
                            $update=array('judul'=>posttext('judul'),'gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            
                            $this->model_app->insert('slider',$update);
                            $this->session->set_flashdata('sukses','Data Slider Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                            $this->session->set_flashdata('gagal','Data Slider Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          } 
                    }
                else
                {
                    $this->session->set_flashdata('gagal','Foto Gagal Di Upload: File Foto Kosong');
                }
            
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/slider/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function slideredit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Slider';
        $data['link']='website/slider';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_slider'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul
                             );
                if($this->model_app->update('slider',$simpan,$where))
                {
                    if (!empty($_FILES['gambar']['name']))
                    {
                        $info=$this->model_app->edit('slider',$where)->row_array();
                        if($info['gambarkey']!='')
                        {
                         $delete= $this->s3_upload->delete_file($info['gambarkey']);
                        }
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                         // var_dump($upload);
                         
                          if($upload!='')
                          {
                            
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $this->model_app->update('slider',$update,$where);
                            $this->session->set_flashdata('sukses','Data Slider Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                          
                            $this->session->set_flashdata('gagal',' Data Slider Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                     
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Slider Berhasil Disimpan dan Anda Tidak Mengganti Foto');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Slider Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('slider',array('id_slider'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/slider/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    
    function sliderhapus($seo){
        $data=$this->data;
        $data['title']='Data Slider';
        $data['link']='website/slider';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_slider'=>dekrip($seo));
            $info=$this->model_app->edit('slider',$where)->row_array();
            $hapus=$this->model_app->delete('slider',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Slider Berhasil Dihapus');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Slider Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function slideraktif($id,$status){
        $query = $this->db->query("CALL aktifSlider(".$id.",".$status.")");
    }

    function get_slider()
    {
        $data=$this->data;
        $this->load->model('model_slider');
        $data['link']='website/slider';
        $where=array();
        
        
        $list = $this->model_slider->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            $status=aksiAktif('website/slideraktif',$field->id_slider,$field->aktif);
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_slider),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_slider),'');
            }
            
            $judul=stripcslashes($field->judul);
            $foto=gambarAws($field->gambar);            
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = '<a href="'.$foto.'" data-toggle="lightbox" data-title="'.$judul.'" >
                        <img src="'.$foto.'" height="100">
                    </a>';
            $row[] = $judul;
            $row[] = $status;
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_slider->count_all($where),
            "recordsFiltered" => $this->model_slider->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }



    function albumfoto(){
        $data=$this->data;
        $data['title']='Daftar Album Foto';
        $data['link']='website/albumfoto';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/foto/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function albumfototambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Album Foto';
        $data['link']='website/albumfoto';

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
                      $judul=posttext('judul');
                      $simpan=array('judul'=>$judul,
                                    'seo'=>seo_title($judul),
                                    'gambar'=>$upload['uri'],
                                    'gambarkey'=>$upload['key']
                                   );
                      $this->model_app->insert('album_foto',$simpan);
                      $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan');
                    }
                    else
                    {
                      $this->session->set_flashdata('gagal','Foto Gagal Di Upload');
                    }
                  
                  
               
                }
                else
                {
                    $this->session->set_flashdata('gagal','Foto Gagal Di Upload: File Foto Kosong');
                }
            
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/foto/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function albumfotoedit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Album Foto';
        $data['link']='website/albumfoto';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_album'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul
                             );
                if($this->model_app->update('album_foto',$simpan,$where))
                {
                   
                    if (!empty($_FILES['gambar']['name']))
                    {
                      
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                         // var_dump($upload);
                         
                          if($upload!='')
                          {
                            $info=$this->model_app->edit('album_foto',$where)->row_array();
                            if($info['gambarkey']!='')
                            {
                             $delete= $this->s3_upload->delete_file($info['gambarkey']);
                            }
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $this->model_app->update('album_foto',$update,$where);
                            $this->session->set_flashdata('sukses','Data Album Foto Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                          
                            $this->session->set_flashdata('gagal',' Data Album Foto Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                     
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Album Foto Berhasil Disimpan dan Anda Tidak Mengganti Foto');
                    }
                
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Album Foto Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('album_foto',array('id_album'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/foto/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    
    function albumfotohapus($seo){
        $data=$this->data;
        $data['title']='Data Album Foto';
        $data['link']='website/albumfoto';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_album'=>dekrip($seo));
            $info=$this->model_app->edit('album_foto',$where)->row_array();
            $hapus=$this->model_app->delete('album_foto',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Album Foto Berhasil Dihapus');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Album Foto Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function albumfotoaktif($id,$status){
        $query = $this->db->query("CALL aktifAlbumFoto(".$id.",".$status.")");
    }

    function get_albumfoto()
    {
        $data=$this->data;
        $this->load->model('model_albumfoto');
        $data['link']='website/albumfoto';
        $where=array();
        
        
        $list = $this->model_albumfoto->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            $status=aksiAktif('website/albumfotoaktif',$field->id_album,$field->aktif);
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_album),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_album),'');
            }
            $jlh=viewJlhFoto($field->id_album);
            $judul=stripcslashes($field->judul);
            $foto=gambarAws($field->gambar);            
            $no++;
            $row=array();
            $row[] = $no;
            
            $row[] = $judul;
            $row[] = '<a href="'.$foto.'" data-toggle="lightbox" data-title="'.$judul.'" >
                        <img src="'.$foto.'" height="100">
                    </a>';
            $row[] = aksiDetail('website/foto',enkrip($field->id_album),$jlh);
            $row[] = $status;
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_albumfoto->count_all($where),
            "recordsFiltered" => $this->model_albumfoto->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function foto($seo){
        $data=$this->data;
        
        $data['link']='website/albumfoto';
        $data['post']='website/foto/'.$seo;
        if(bisaBaca($data['link'],$data['id_level']))
        {
            if(isset($_POST['tambah']))
            {
                if (!empty($_FILES['gambar']['name']))
                {
                  
                    $dir = dirname($_FILES["gambar"]["tmp_name"]);
                    $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                    rename($_FILES["gambar"]["tmp_name"], $destination);

                    $upload = $this->s3_upload->upload_file($destination);
                    if($upload!='')
                    {
                      $judul=posttext('judul');
                      $simpan=array('judul'=>$judul,
                                    'id_album'=>postnumber('id_album'),
                                    'gambar'=>$upload['uri'],
                                    'gambarkey'=>$upload['key'],
                                    'input_user'=>$this->session->id_user
                                   );
                      $this->model_app->insert('foto',$simpan);
                      $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan');
                    }
                    else
                    {
                      $this->session->set_flashdata('gagal','Foto Gagal Di Upload');
                    }
                  
                  
               
                }
                else
                {
                    $this->session->set_flashdata('gagal','Foto Gagal Di Upload: File Foto Kosong');
                }
            
                redirect($data['post']);
            }
            else if(isset($_POST['edit']))
            {
                if(bisaUbah($data['link'],$data['id_level']))
                {
                $where=array('id_foto'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul
                             );
                if($this->model_app->update('foto',$simpan,$where))
                {
                   
                    if (!empty($_FILES['gambar']['name']))
                    {
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                         // var_dump($upload);
                         
                          if($upload!='')
                          {
                            $info=$this->model_app->edit('foto',$where)->row_array();
                            if($info['gambarkey']!='')
                            {
                             $delete= $this->s3_upload->delete_file($info['gambarkey']);
                            }
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $this->model_app->update('foto',$update,$where);
                            $this->session->set_flashdata('sukses','Data Foto Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                          
                            $this->session->set_flashdata('gagal',' Data Foto Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                     
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Foto Berhasil Disimpan dan Anda Tidak Mengganti Foto');
                    }
                
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Album Foto Gagal Disimpan');
                }
                redirect($data['post']);
                }
            }
            else
            {
                $row=$this->model_app->edit('album_foto',array('id_album'=>dekrip($seo)))->row_array();
                $data['title']='Daftar Foto Pada Album '.stripcslashes($row['judul']);
                $data['id_album']=$row['id_album'];
                $this->template->load('admin','admin/website/foto/detail',$data);
            }
            
        }
        else
        {
            redirect('dashboard');
        }
    }

    function fotoedit(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('foto',array('id_foto'=>$id))->row_array();
         
        echo'
        <input type="hidden" name="id" value="'.$id.'">
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Judul</label>
                  <div class="col-sm-9">
                    '.formInputText('judul',stripcslashes($sql['judul']),'','required').'
                  </div>
                </div>
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Foto Sebelumnya</label>
                  <div class="col-sm-9">
                    <img src="'.gambarAws($sql['gambar']).'" height="100" alt="">
                  </div>
                </div>
            <div class="form-group row">
                <label class="control-label col-md-3">Foto</label>
                <div class="col-md-9">
                  '.formInputGambar('gambar','').'
                  <small>Kosongkan Jika Tidak Mengganti Foto, Ukuran Maksimal 500Kb</small>
                </div>
              </div>
            ';
        }
    }

    function fotohapus($seo){
        $data=$this->data;
        $data['title']='Data Foto';
        $data['link']='website/albumfoto';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_foto'=>dekrip($seo));
            $info=$this->model_app->edit('foto',$where)->row_array();
            $hapus=$this->model_app->delete('foto',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Foto Berhasil Dihapus');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Foto Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }


    function get_foto($id_album)
    {
        $data=$this->data;
        $this->load->model('model_foto');
        $data['link']='website/albumfoto';
        $where=array('id_album'=>$id_album);        
        $list = $this->model_foto->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
           // $status=aksiAktif('website/albumfotoaktif',$field->id_album,$field->aktif);
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiModalEdit('#modalEdit',$field->id_foto,'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal('website/fotohapus',enkrip($field->id_foto),'');
            }
            
            $judul=stripcslashes($field->judul);
            $foto=gambarAws($field->gambar);            
            $no++;
            $row=array();
            $row[] = $no;
            
            $row[] = $judul;
            $row[] = '<a href="'.$foto.'" data-toggle="lightbox" data-title="'.$judul.'" >
                        <img src="'.$foto.'" height="100">
                    </a>';
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_foto->count_all($where),
            "recordsFiltered" => $this->model_foto->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function albumvideo(){
        $data=$this->data;
        $data['title']='Daftar Album Video';
        $data['link']='website/albumvideo';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/video/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function albumvideotambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Album Video';
        $data['link']='website/albumvideo';

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
                      $judul=posttext('judul');
                      $simpan=array('judul'=>$judul,
                                    'seo'=>seo_title($judul),
                                    'gambar'=>$upload['uri'],
                                    'gambarkey'=>$upload['key']
                                   );
                      $this->model_app->insert('album_video',$simpan);
                      $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan');
                    }
                    else
                    {
                      $this->session->set_flashdata('gagal','Video Gagal Di Upload');
                    }
                  
                  
               
                }
                else
                {
                    $this->session->set_flashdata('gagal','Video Gagal Di Upload: File Foto Kosong');
                }
            
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/video/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function albumvideoedit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Album Video';
        $data['link']='website/albumvideo';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_album'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul
                             );
                if($this->model_app->update('album_video',$simpan,$where))
                {
                   
                    if (!empty($_FILES['gambar']['name']))
                    {
                      
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                         // var_dump($upload);
                         
                          if($upload!='')
                          {
                            $info=$this->model_app->edit('album_video',$where)->row_array();
                            if($info['gambarkey']!='')
                            {
                             $delete= $this->s3_upload->delete_file($info['gambarkey']);
                            }
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $this->model_app->update('album_video',$update,$where);
                            $this->session->set_flashdata('sukses','Data Album Video Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                          
                            $this->session->set_flashdata('gagal',' Data Album Video Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                     
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Album Video Berhasil Disimpan dan Anda Tidak Mengganti Foto');
                    }
                
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Album Video Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('album_video',array('id_album'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/video/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    
    function albumvideohapus($seo){
        $data=$this->data;
        $data['title']='Data Album Video';
        $data['link']='website/albumvideo';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_album'=>dekrip($seo));
            $info=$this->model_app->edit('album_video',$where)->row_array();
            $hapus=$this->model_app->delete('album_video',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Album Video Berhasil Dihapus');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Album Video Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function albumvideoaktif($id,$status){
        $query = $this->db->query("CALL aktifAlbumVideo(".$id.",".$status.")");
    }

    function get_albumvideo()
    {
        $data=$this->data;
        $this->load->model('model_albumvideo');
        $data['link']='website/albumvideo';
        $where=array();
        
        
        $list = $this->model_albumvideo->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            $status=aksiAktif('website/albumvideoaktif',$field->id_album,$field->aktif);
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_album),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_album),'');
            }
            $jlh=viewJlhVideo($field->id_album);
            $judul=stripcslashes($field->judul);
            $video=gambarAws($field->gambar);            
            $no++;
            $row=array();
            $row[] = $no;
            
            $row[] = $judul;
            $row[] = '<a href="'.$video.'" data-toggle="lightbox" data-title="'.$judul.'" >
                        <img src="'.$video.'" height="100">
                    </a>';
            $row[] = aksiDetail('website/video',enkrip($field->id_album),$jlh);
            $row[] = $status;
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_albumvideo->count_all($where),
            "recordsFiltered" => $this->model_albumvideo->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function video($seo){
        $data=$this->data;
        
        $data['link']='website/albumvideo';
        $data['post']='website/video/'.$seo;
        if(bisaBaca($data['link'],$data['id_level']))
        {
            if(isset($_POST['tambah']))
            {
                if (!empty($_FILES['gambar']['name']))
                {
                  
                    $dir = dirname($_FILES["gambar"]["tmp_name"]);
                    $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                    rename($_FILES["gambar"]["tmp_name"], $destination);

                    $upload = $this->s3_upload->upload_file($destination);
                    if($upload!='')
                    {
                      $judul=posttext('judul');
                      $simpan=array('judul'=>$judul,
                                    'id_album'=>postnumber('id_album'),
                                    'gambar'=>$upload['uri'],
                                    'gambarkey'=>$upload['key'],
                                    'link'=>postnumber('link'),
                                    'input_user'=>$this->session->id_user
                                   );
                      $this->model_app->insert('video',$simpan);
                      $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan');
                    }
                    else
                    {
                      $this->session->set_flashdata('gagal','Video Gagal Di Upload');
                    }
                  
                  
               
                }
                else
                {
                    $this->session->set_flashdata('gagal','Video Gagal Di Upload: File Foto Kosong');
                }
            
                redirect($data['post']);
            }
            else if(isset($_POST['edit']))
            {
                if(bisaUbah($data['link'],$data['id_level']))
                {
                $where=array('id_video'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul,'link'=>postnumber('link')
                             );
                if($this->model_app->update('video',$simpan,$where))
                {
                   
                    if (!empty($_FILES['gambar']['name']))
                    {
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                         // var_dump($upload);
                         
                          if($upload!='')
                          {
                            $info=$this->model_app->edit('video',$where)->row_array();
                            if($info['gambarkey']!='')
                            {
                             $delete= $this->s3_upload->delete_file($info['gambarkey']);
                            }
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $this->model_app->update('video',$update,$where);
                            $this->session->set_flashdata('sukses','Data Video Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                          
                            $this->session->set_flashdata('gagal',' Data Video Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                     
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Video Berhasil Disimpan dan Anda Tidak Mengganti Foto');
                    }
                
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Video Gagal Disimpan');
                }
                redirect($data['post']);
                }
            }
            else
            {
                $row=$this->model_app->edit('album_video',array('id_album'=>dekrip($seo)))->row_array();
                $data['title']='Daftar Video Pada Album '.stripcslashes($row['judul']);
                $data['id_album']=$row['id_album'];
                $this->template->load('admin','admin/website/video/detail',$data);
            }
            
        }
        else
        {
            redirect('dashboard');
        }
    }

    function videoedit(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('video',array('id_video'=>$id))->row_array();
         
        echo'
        <input type="hidden" name="id" value="'.$id.'">
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Judul</label>
                  <div class="col-sm-9">
                    '.formInputText('judul',stripcslashes($sql['judul']),'','required').'
                  </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-3">Link Video (Youtube)</label>
                <div class="col-sm-9">
                '.formInputUrl('link',$sql['link'],'Link Youtube','required').'
                </div>
              </div>
            <div class="form-group row">
                  <label class="col-sm-3 control-label ">Foto Sebelumnya</label>
                  <div class="col-sm-9">
                    <img src="'.gambarAws($sql['gambar']).'" height="100" alt="">
                  </div>
                </div>
            <div class="form-group row">
                <label class="control-label col-md-3">Foto</label>
                <div class="col-md-9">
                  '.formInputGambar('gambar','').'
                  <small>Kosongkan Jika Tidak Mengganti Video, Ukuran Maksimal 500Kb</small>
                </div>
              </div>
            ';
        }
    }

    function videohapus($seo){
        $data=$this->data;
        $data['title']='Data Video';
        $data['link']='website/albumvideo';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_video'=>dekrip($seo));
            $info=$this->model_app->edit('video',$where)->row_array();
            $hapus=$this->model_app->delete('video',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Video Berhasil Dihapus');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Video Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }


    function get_video($id_album)
    {
        $data=$this->data;
        $this->load->model('model_video');
        $data['link']='website/albumvideo';
        $where=array('id_album'=>$id_album);        
        $list = $this->model_video->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
           // $status=aksiAktif('website/albumvideoaktif',$field->id_album,$field->aktif);
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiModalEdit('#modalEdit',$field->id_video,'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal('website/videohapus',enkrip($field->id_video),'');
            }
            
            $judul=stripcslashes($field->judul);
            $video=gambarAws($field->gambar);            
            $no++;
            $row=array();
            $row[] = $no;
            
            $row[] = $judul;
            $row[] = '<a href="'.$video.'" data-toggle="lightbox" data-title="'.$judul.'" >
                        <img src="'.$video.'" height="100">
                    </a>';
            $row[] = '<a class="btn btn-info btn-xs" href="'.$field->link.'" data-toggle="lightbox" data-title="'.$judul.'"><i class="fas fa-info-circle"></i>Lihat</a>';
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_video->count_all($where),
            "recordsFiltered" => $this->model_video->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }


    function agenda(){
        $data=$this->data;
        $data['title']='Daftar Agenda';
        $data['link']='website/agenda';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/agenda/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function agendatambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Agenda';
        $data['link']='website/agenda';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
              $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'tanggal'=>postnumber('tanggal'),
                              'isi'=>postnumber('isi'),
                              'input_user'=>$this->session->id_user
                             );
                if($this->model_app->insert('agenda',$simpan))
                {
                    $id=$this->db->insert_id();
                    if (!empty($_FILES['gambar']['name']))
                    {
                        
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                          if($upload!='')
                          {
                            
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $where=array('id_agenda'=>$id);
                            $this->model_app->update('agenda',$update,$where);
                            $this->session->set_flashdata('sukses','Data Agenda Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                            $this->session->set_flashdata('gagal','Data Agenda Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                        
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan dan Anda Tidak Mengupload Foto');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Berhasil Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/agenda/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function agendaedit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Agenda';
        $data['link']='website/agenda';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_agenda'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'tanggal'=>postnumber('tanggal'),
                              'isi'=>postnumber('isi'),
                              'mod_at'=>date('Y-m-d'),
                              'mod_user'=>$this->session->id_user
                             );
                if($this->model_app->update('agenda',$simpan,$where))
                {
                    if (!empty($_FILES['gambar']['name']))
                    {
                      
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                         // var_dump($upload);
                         
                          if($upload!='')
                          {
                            $info=$this->model_app->edit('agenda',$where)->row_array();
                            if($info['gambarkey']!='')
                            {
                             $delete= $this->s3_upload->delete_file($info['gambarkey']);
                            }
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $this->model_app->update('agenda',$update,$where);
                            $this->session->set_flashdata('sukses','Data Agenda Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                          
                            $this->session->set_flashdata('gagal',' Data Agenda Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                     
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Agenda Berhasil Disimpan dan Anda Tidak Mengganti Foto');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Agenda Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('agenda',array('id_agenda'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/agenda/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function agendadetail($seo){
        $data=$this->data;
        $data['title']='Data Agenda';
        $data['link']='website/agenda';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            $data['rows']=$this->model_app->edit('agenda',array('id_agenda'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/agenda/detail',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function agendahapus($seo){
        $data=$this->data;
        $data['title']='Data Agenda';
        $data['link']='website/agenda';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_agenda'=>dekrip($seo));
            $info=$this->model_app->edit('agenda',$where)->row_array();
            $hapus=$this->model_app->delete('agenda',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Agenda Berhasil Dihapus ');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Agenda Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

   

    function get_agenda()
    {
        $data=$this->data;
        $this->load->model('model_agenda');
        $data['link']='website/agenda';
        $where=array();
        
        
        $list = $this->model_agenda->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_agenda),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_agenda),'');
            }
            $detail=aksiDetail($data['link'].'detail',enkrip($field->id_agenda),'');
            $judul=stripcslashes($field->judul);
            $foto=gambarAws($field->gambar);
            
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = '<a href="'.$foto.'" data-toggle="lightbox" data-title="'.$judul.'" >
                        <img src="'.$foto.'" width="75">
                    </a>';
            $row[] = tgl_view($field->tanggal);
            $row[] = $judul;
            
            $row[] = $field->dibaca;
            $row[] = viewUser($field->input_user);
            $row[] = $detail.'&nbsp;'.$edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_agenda->count_all($where),
            "recordsFiltered" => $this->model_agenda->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function pengumuman(){
        $data=$this->data;
        $data['title']='Daftar Pengumuman';
        $data['link']='website/pengumuman';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/pengumuman/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function pengumumantambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Pengumuman';
        $data['link']='website/pengumuman';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
              $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'tanggal'=>postnumber('tanggal'),
                              'isi'=>postnumber('isi'),
                              'input_user'=>$this->session->id_user
                             );
                if($this->model_app->insert('pengumuman',$simpan))
                {
                    $id=$this->db->insert_id();
                    if (!empty($_FILES['gambar']['name']))
                    {
                        
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                          if($upload!='')
                          {
                            
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $where=array('id_pengumuman'=>$id);
                            $this->model_app->update('pengumuman',$update,$where);
                            $this->session->set_flashdata('sukses','Data Pengumuman Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                            $this->session->set_flashdata('gagal','Data Pengumuman Berhasil Disimpan Tapi File Gagal Di Upload');
                          }
                        
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Pengumuman Berhasil Disimpan dan Anda Tidak Mengupload File');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Pengumuman Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/pengumuman/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function pengumumanedit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Pengumuman';
        $data['link']='website/pengumuman';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_pengumuman'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'tanggal'=>postnumber('tanggal'),
                              'isi'=>postnumber('isi'),
                              'mod_at'=>date('Y-m-d'),
                              'mod_user'=>$this->session->id_user
                             );
                if($this->model_app->update('pengumuman',$simpan,$where))
                {
                    if (!empty($_FILES['gambar']['name']))
                    {
                      
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                         // var_dump($upload);
                         
                          if($upload!='')
                          {
                            $info=$this->model_app->edit('pengumuman',$where)->row_array();
                            if($info['gambarkey']!='')
                            {
                             $delete= $this->s3_upload->delete_file($info['gambarkey']);
                            }
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $this->model_app->update('pengumuman',$update,$where);
                            $this->session->set_flashdata('sukses','Data Pengumuman Berhasil Disimpan');
                          }
                          else
                          {
                          
                            $this->session->set_flashdata('gagal',' Data Pengumuman Berhasil Disimpan Tapi File Gagal Di Upload');
                          }
                     
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Pengumuman Berhasil Disimpan dan Anda Tidak Mengganti/Mengupload File');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Pengumuman Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('pengumuman',array('id_pengumuman'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/pengumuman/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function pengumumandetail(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('pengumuman',array('id_pengumuman'=>$id))->row_array();
         
        echo $sql['isi'];
        }
    }

    function pengumumanfile(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('pengumuman',array('id_pengumuman'=>$id))->row_array();
        echo'<div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="'.$sql['gambar'].'" allowfullscreen></iframe>
             </div> ';
       
        }
    }

    function pengumumanhapus($seo){
        $data=$this->data;
        $data['title']='Data Pengumuman';
        $data['link']='website/pengumuman';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_pengumuman'=>dekrip($seo));
            $info=$this->model_app->edit('pengumuman',$where)->row_array();
            $hapus=$this->model_app->delete('pengumuman',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Pengumuman Berhasil Dihapus ');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Pengumuman Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

    

    function get_pengumuman()
    {
        $data=$this->data;
        $this->load->model('model_pengumuman');
        $data['link']='website/pengumuman';
        $where=array();
        
        
        $list = $this->model_pengumuman->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
           
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_pengumuman),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_pengumuman),'');
            }
            $detail=aksiModalLihat('#modalLihat',$field->id_pengumuman,'Lihat');
            $judul=stripcslashes($field->judul);
            if($field->gambar=='')
            {
                $berkas='Tidak Ada Berkas';
            }
            else
            {
                $berkas=aksiModalLihat('#modalFile',$field->id_pengumuman,'Lihat');
            }
            
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = tgl_view($field->tanggal);
            $row[] = $judul;
            $row[] = $detail;
            $row[] = $berkas;
            $row[] = $field->dibaca;
            $row[] = viewUser($field->input_user);
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_pengumuman->count_all($where),
            "recordsFiltered" => $this->model_pengumuman->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }


    function download(){
        $data=$this->data;
        $data['title']='Daftar Download';
        $data['link']='website/download';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/download/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function downloadtambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Download';
        $data['link']='website/download';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
              $jenis=postnumber('jenis');
              $judul=posttext('judul');
              if($jenis=='Link')
              {
                $simpan=array('judul'=>$judul,
                              'jenis'=>$jenis,
                              'gambar'=>postnumber('link'),
                              'input_user'=>$this->session->id_user
                             );
                if($this->model_app->insert('download',$simpan))
                {
                    $this->session->set_flashdata('sukses','Data Download Berhasil Disimpan');
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Download Gagal Disimpan');
                }
              }
              else
              {
                
                if (!empty($_FILES['gambar']['name']))
                {
                    
                      $dir = dirname($_FILES["gambar"]["tmp_name"]);
                      $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                      rename($_FILES["gambar"]["tmp_name"], $destination);

                      $upload = $this->s3_upload->upload_file($destination);
                      if($upload!='')
                      {
                        
                        $update=array('judul'=>$judul,
                                      'jenis'=>$jenis,
                                      'input_user'=>$this->session->id_user,
                                      'gambar'=>$upload['uri'],
                                      'gambarkey'=>$upload['key']
                                    );
                        
                        $this->model_app->insert('download',$update);
                        $this->session->set_flashdata('sukses','Data Download Berhasil Berhasil Disimpan');
                      }
                      else
                      {
                        $this->session->set_flashdata('gagal','Data Download Gagal Disimpan Karena File Gagal Di Upload');
                      }
                        
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Download Gagal Disimpan Karena File Kosong');
                }
              }
                
                
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/download/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function downloadedit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Download';
        $data['link']='website/download';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_download'=>postnumber('id'));
                $judul=posttext('judul');
                $jenis=postnumber('jenis');
                $info=$this->model_app->edit('download',$where)->row_array();
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }

                if($jenis=='Link')
                {
                $simpan=array('judul'=>$judul,
                              'jenis'=>$jenis,
                              'gambar'=>postnumber('link'),
                              'gambarkey'=>NULL,
                              'mod_at'=>date('Y-m-d'),
                              'mod_user'=>$this->session->id_user
                             );
                    if($this->model_app->update('download',$simpan,$where))
                    {
                        $this->session->set_flashdata('sukses','Data Download Berhasil Disimpan');
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',' Data Download Gagal Di Simpan');
                    }
                }
                else
                {
                    $simpan=array('judul'=>$judul,
                                  'jenis'=>$jenis,
                                  'mod_at'=>date('Y-m-d'),
                                  'mod_user'=>$this->session->id_user
                                 );
                    if($this->model_app->update('download',$simpan,$where))
                    {
                        if (!empty($_FILES['gambar']['name']))
                        {
                          
                              $dir = dirname($_FILES["gambar"]["tmp_name"]);
                              $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                              rename($_FILES["gambar"]["tmp_name"], $destination);

                              $upload = $this->s3_upload->upload_file($destination);
                             // var_dump($upload);
                             
                              if($upload!='')
                              {
                                
                                $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                                $this->model_app->update('download',$update,$where);
                                $this->session->set_flashdata('sukses','Data Download Berhasil Disimpan');
                              }
                              else
                              {
                              
                                $this->session->set_flashdata('gagal',' Data Download Berhasil Disimpan Tapi File Gagal Di Upload');
                              }
                         
                            
                        }
                        else
                        {
                            $this->session->set_flashdata('sukses','Data Download Berhasil Disimpan dan Anda Tidak Mengganti/Mengupload File');
                        }
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal','Data Download Gagal Disimpan');
                    }
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('download',array('id_download'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/download/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    
    function downloadfile(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('download',array('id_download'=>$id))->row_array();
        echo'<div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="'.$sql['gambar'].'" allowfullscreen></iframe>
             </div> ';
       
        }
    }

    function downloadhapus($seo){
        $data=$this->data;
        $data['title']='Data Download';
        $data['link']='website/download';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_download'=>dekrip($seo));
            $info=$this->model_app->edit('download',$where)->row_array();
            $hapus=$this->model_app->delete('download',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Download Berhasil Dihapus ');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Download Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

    

    function get_download()
    {
        $data=$this->data;
        $this->load->model('model_download');
        $data['link']='website/download';
        $where=array();
        
        
        $list = $this->model_download->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
           
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_download),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_download),'');
            }
            $detail=aksiModalLihat('#modalLihat',$field->id_download,'Lihat');
            $judul=stripcslashes($field->judul);
            if($field->jenis=='Link')
            {
                $berkas=aksiUrl($field->gambar,'Lihat');
            }
            else
            {
                $berkas=aksiModalLihat('#modalFile',$field->id_download,'Lihat');
            }
            
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = $judul;
            $row[] = $berkas;
            $row[] = $field->dibaca;
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_download->count_all($where),
            "recordsFiltered" => $this->model_download->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }


    function kerjasama(){
        $data=$this->data;
        $data['title']='Daftar Kerjasama';
        $data['link']='website/kerjasama';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/kerjasama/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function kerjasamatambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Kerjasama';
        $data['link']='website/kerjasama';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
              $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'jenis'=>posttext('jenis'),
                              'bidang'=>posttext('bidang'),
                              'rekanan'=>posttext('rekanan'),
                              'tanggal_mulai'=>postnumber('tanggal_mulai'),
                              'tanggal_selesai'=>postnumber('tanggal_selesai'),
                              'isi'=>postnumber('isi'),
                              'input_user'=>$this->session->id_user
                             );
                if($this->model_app->insert('kerjasama',$simpan))
                {
                    $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan');
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Berhasil Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/kerjasama/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function kerjasamaedit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Kerjasama';
        $data['link']='website/kerjasama';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_kerjasama'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'jenis'=>posttext('jenis'),
                              'bidang'=>posttext('bidang'),
                              'rekanan'=>posttext('rekanan'),
                              'tanggal_mulai'=>postnumber('tanggal_mulai'),
                              'tanggal_selesai'=>postnumber('tanggal_selesai'),
                              'isi'=>postnumber('isi'),
                              'mod_at'=>date('Y-m-d'),
                              'mod_user'=>$this->session->id_user
                             );
                if($this->model_app->update('kerjasama',$simpan,$where))
                {
                    
                  $this->session->set_flashdata('sukses','Data Kerjasama Berhasil Disimpan');
                    
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Kerjasama Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('kerjasama',array('id_kerjasama'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/kerjasama/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function kerjasamadetail(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('kerjasama',array('id_kerjasama'=>$id))->row_array();
         
        echo $sql['isi'];
        }
    }

    function kerjasamahapus($seo){
        $data=$this->data;
        $data['title']='Data Kerjasama';
        $data['link']='website/kerjasama';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $hapus=$this->model_app->delete('kerjasama',array('id_kerjasama'=>dekrip($seo)));

            if($this->db->affected_rows()>0)
            {
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Kerjasama Berhasil Dihapus');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Kerjasama Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

   

    function get_kerjasama()
    {
        $data=$this->data;
        $this->load->model('model_kerjasama');
        $data['link']='website/kerjasama';
        $where=array();
        
        
        $list = $this->model_kerjasama->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_kerjasama),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_kerjasama),'');
            }
            $detail=aksiModalLihat('#modalLihat',$field->id_kerjasama,'Lihat');
            $judul=stripcslashes($field->judul);
            
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = $judul;
            $row[] = stripcslashes($field->jenis);
            $row[] = stripcslashes($field->bidang);
            $row[] = stripcslashes($field->rekanan);
            $row[] = tgl_view($field->tanggal_mulai).' s/d '.tgl_view($field->tanggal_selesai);
            $row[] = $detail;
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_kerjasama->count_all($where),
            "recordsFiltered" => $this->model_kerjasama->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }


    function prestasi(){
        $data=$this->data;
        $data['title']='Daftar Prestasi';
        $data['link']='website/prestasi';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/prestasi/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function prestasitambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Prestasi';
        $data['link']='website/prestasi';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
              $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'tanggal'=>postnumber('tanggal'),
                              'nama'=>posttext('nama'),
                              'tingkat'=>posttext('tingkat'),
                              'juara'=>posttext('juara'),
                              'isi'=>postnumber('isi'),
                              'input_user'=>$this->session->id_user
                             );
                if($this->model_app->insert('prestasi',$simpan))
                {
                    $id=$this->db->insert_id();
                    if (!empty($_FILES['gambar']['name']))
                    {
                        
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                          if($upload!='')
                          {
                            
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $where=array('id_prestasi'=>$id);
                            $this->model_app->update('prestasi',$update,$where);
                            $this->session->set_flashdata('sukses','Data Prestasi Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                            $this->session->set_flashdata('gagal','Data Prestasi Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                        
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan dan Anda Tidak Mengupload Foto');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Berhasil Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/prestasi/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function prestasiedit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Prestasi';
        $data['link']='website/prestasi';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_prestasi'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'tanggal'=>postnumber('tanggal'),
                              'nama'=>posttext('nama'),
                              'tingkat'=>posttext('tingkat'),
                              'juara'=>posttext('juara'),
                              'isi'=>postnumber('isi'),
                              'mod_at'=>date('Y-m-d'),
                              'mod_user'=>$this->session->id_user
                             );
                if($this->model_app->update('prestasi',$simpan,$where))
                {
                    if (!empty($_FILES['gambar']['name']))
                    {
                      
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                         // var_dump($upload);
                         
                          if($upload!='')
                          {
                            $info=$this->model_app->edit('prestasi',$where)->row_array();
                            if($info['gambarkey']!='')
                            {
                             $delete= $this->s3_upload->delete_file($info['gambarkey']);
                            }
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $this->model_app->update('prestasi',$update,$where);
                            $this->session->set_flashdata('sukses','Data Prestasi Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                          
                            $this->session->set_flashdata('gagal',' Data Prestasi Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                     
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Prestasi Berhasil Disimpan dan Anda Tidak Mengganti Foto');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Prestasi Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('prestasi',array('id_prestasi'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/prestasi/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function prestasidetail(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('prestasi',array('id_prestasi'=>$id))->row_array();
         
        echo $sql['isi'];
        }
    }

    function prestasihapus($seo){
        $data=$this->data;
        $data['title']='Data Prestasi';
        $data['link']='website/prestasi';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_prestasi'=>dekrip($seo));
            $info=$this->model_app->edit('prestasi',$where)->row_array();
            $hapus=$this->model_app->delete('prestasi',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Prestasi Berhasil Dihapus ');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Prestasi Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function prestasiaktif($id,$status){
        $query = $this->db->query("CALL aktifPrestasi(".$id.",".$status.")");
    }

    function get_prestasi()
    {
        $data=$this->data;
        $this->load->model('model_prestasi');
        $data['link']='website/prestasi';
        $where=array();
        
        
        $list = $this->model_prestasi->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
                        
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_prestasi),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_prestasi),'');
            }
            $detail=aksiModalLihat('#modalLihat',$field->id_prestasi,'Lihat');
            $judul=stripcslashes($field->judul);
            $foto=gambarAws($field->gambar);
            
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = '<a href="'.$foto.'" data-toggle="lightbox" data-title="'.$judul.'" >
                        <img src="'.$foto.'" width="75">
                    </a>';
            $row[] = tgl_view($field->tanggal);
            $row[] = $judul;
            $row[] = stripcslashes($field->nama);
            $row[] = stripcslashes($field->juara);
            $row[] = stripcslashes($field->tingkat);
            $row[] = $detail;
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_prestasi->count_all($where),
            "recordsFiltered" => $this->model_prestasi->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function pesan(){
        $data=$this->data;
        $data['title']='Daftar Pesan Pengunjung';
        $data['link']='website/pesan';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/pesan/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function pesandetail(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('pesan',array('id_pesan'=>$id))->row_array();
         
        echo '<table class="table table-condensed">
                <thead>
                    <tr>
                        <th width="10%">Nama</th>
                        <th width="1%">:</th>
                        <th>'.stripcslashes($sql['nama']).'</th>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <th>:</th>
                        <th>'.stripcslashes($sql['nik']).'</th>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <th>:</th>
                        <th>'.stripcslashes($sql['hp']).'</th>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <th>:</th>
                        <th>'.stripcslashes($sql['email']).'</th>
                    </tr>
                    <tr>
                        <th>Umur</th>
                        <th>:</th>
                        <th>'.stripcslashes($sql['umur']).'</th>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <th>:</th>
                        <th>'.stripcslashes($sql['pekerjaan']).'</th>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <th>:</th>
                        <th>'.stripcslashes($sql['alamat']).'</th>
                    </tr>
                </thead>
            </table>';
        }
    }

    function pesanedit(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('pesan',array('id_pesan'=>$id))->row_array();
         
        echo'
        <input type="hidden" name="id" value="'.$id.'">
            <div class="form-group row">
              <label class="col-sm-3 control-label ">Keterangan</label>
              <div class="col-sm-9">
                <input type="text" name="keterangan" value="'.stripcslashes($sql['keterangan']).'" class="form-control" >
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

    function pesansimpan() { 
        $data=$this->data;
        $id=$this->input->post('id');
        $keterangan=posttext('keterangan');
                
        $simpan=array('keterangan'=>$keterangan,'user_id'=>$data['id_user'],'ket_at'=>date('Y-m-d H:i:s'));
        $where=array('id_pesan'=>$id);
        $this->model_app->update('pesan',$simpan,$where);
        
       }

    function pesanhapus($seo){
        $data=$this->data;
        $data['title']='Data Pesan Pengunjung';
        $data['link']='website/pesan';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $hapus=$this->model_app->delete('pesan',array('id_pesan'=>dekrip($seo)));

            if($this->db->affected_rows()>0)
            {
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Pesan Pengunjung Berhasil Dihapus');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Pesan Pengunjung Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

    
    function get_pesan()
    {
        $data=$this->data;
        $this->load->model('model_pesan');
        $data['link']='website/pesan';
        $where=array();
        
        
        $list = $this->model_pesan->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiModalEdit('#modalEdit',$field->id_pesan,'');
            }
            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_pesan),'');
            }
            $detail=aksiModalLihat('#modalLihat',$field->id_pesan,'Lihat');
            
            
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = stripcslashes($field->nama);
            $row[] = stripcslashes($field->judul);
            $row[] = stripcslashes($field->isi);
            $row[] = $detail;
            $row[] = stripcslashes($field->keterangan);
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_pesan->count_all($where),
            "recordsFiltered" => $this->model_pesan->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }


    function fasilitas(){
        $data=$this->data;
        $data['title']='Daftar Fasilitas';
        $data['link']='website/fasilitas';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $this->template->load('admin','admin/website/fasilitas/data',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function fasilitastambah(){
        $data=$this->data;
        $data['title']='Form Tambah Data Fasilitas';
        $data['link']='website/fasilitas';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
              $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'isi'=>postnumber('isi'),
                              'input_user'=>$this->session->id_user
                             );
                if($this->model_app->insert('fasilitas',$simpan))
                {
                    $id=$this->db->insert_id();
                    if (!empty($_FILES['gambar']['name']))
                    {
                        
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                          if($upload!='')
                          {
                            
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $where=array('id_fasilitas'=>$id);
                            $this->model_app->update('fasilitas',$update,$where);
                            $this->session->set_flashdata('sukses','Data Fasilitas Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                            $this->session->set_flashdata('gagal','Data Fasilitas Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                        
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Berhasil Berhasil Disimpan dan Anda Tidak Mengupload Foto');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Berhasil Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
            $this->template->load('admin','admin/website/fasilitas/tambah',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function fasilitasedit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Data Fasilitas';
        $data['link']='website/fasilitas';

        if(bisaTulis($data['link'],$data['id_level']))
        {
            if(isset($_POST['simpan']))
            {
                $where=array('id_fasilitas'=>postnumber('id'));
                $judul=posttext('judul');
                $simpan=array('judul'=>$judul,
                              'seo'=>seo_title($judul),
                              'isi'=>postnumber('isi'),
                              'mod_at'=>date('Y-m-d'),
                              'mod_user'=>$this->session->id_user
                             );
                if($this->model_app->update('fasilitas',$simpan,$where))
                {
                    if (!empty($_FILES['gambar']['name']))
                    {
                      
                          $dir = dirname($_FILES["gambar"]["tmp_name"]);
                          $destination = $dir . DIRECTORY_SEPARATOR . $_FILES["gambar"]["name"];
                          rename($_FILES["gambar"]["tmp_name"], $destination);

                          $upload = $this->s3_upload->upload_file($destination);
                         // var_dump($upload);
                         
                          if($upload!='')
                          {
                            $info=$this->model_app->edit('fasilitas',$where)->row_array();
                            if($info['gambarkey']!='')
                            {
                             $delete= $this->s3_upload->delete_file($info['gambarkey']);
                            }
                            $update=array('gambar'=>$upload['uri'],'gambarkey'=>$upload['key']);
                            $this->model_app->update('fasilitas',$update,$where);
                            $this->session->set_flashdata('sukses','Data Fasilitas Berhasil Berhasil Disimpan');
                          }
                          else
                          {
                          
                            $this->session->set_flashdata('gagal',' Data Fasilitas Berhasil Disimpan Tapi Foto Gagal Di Upload');
                          }
                     
                        
                    }
                    else
                    {
                        $this->session->set_flashdata('sukses','Data Fasilitas Berhasil Disimpan dan Anda Tidak Mengganti Foto');
                    }
                }
                else
                {
                    $this->session->set_flashdata('gagal','Data Fasilitas Gagal Disimpan');
                }
                redirect($data['link']);
            }
            else
            {
                $data['rows']=$this->model_app->edit('fasilitas',array('id_fasilitas'=>dekrip($seo)))->row_array();
            $this->template->load('admin','admin/website/fasilitas/edit',$data);
            }

        }
        else
        {
            redirect('dashboard');
        }
    }

    function fasilitasdetail(){
        if(isset($_POST['rowid']))
        {
        $id = $this->input->post('rowid');
        // mengambil data berdasarkan id
        // dan menampilkan data ke dalam form modal bootstrap
       $sql=$this->model_app->edit('fasilitas',array('id_fasilitas'=>$id))->row_array();
         
        echo $sql['isi'];
        }
    }

    function fasilitashapus($seo){
        $data=$this->data;
        $data['title']='Data Fasilitas';
        $data['link']='website/fasilitas';

        if(bisaHapus($data['link'],$data['id_level']))
        {
            $where=array('id_fasilitas'=>dekrip($seo));
            $info=$this->model_app->edit('fasilitas',$where)->row_array();
            $hapus=$this->model_app->delete('fasilitas',$where);

            if($this->db->affected_rows()>0)
            {
                if($info['gambarkey']!='')
                {
                 $delete= $this->s3_upload->delete_file($info['gambarkey']);
                }
                $hasil=array('hasil'=>'sukses','pesan'=>'Data Fasilitas Berhasil Dihapus ');
            }
            else
            {
                $hasil=array('hasil'=>'gagal','pesan'=>'Data Fasilitas Gagal Dihapus');
            }
           // redirect($data['link']);
            echo json_encode($hasil);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function fasilitasaktif($id,$status){
        $query = $this->db->query("CALL aktifFasilitas(".$id.",".$status.")");
    }

    function get_fasilitas()
    {
        $data=$this->data;
        $this->load->model('model_fasilitas');
        $data['link']='website/fasilitas';
        $where=array();
        
        
        $list = $this->model_fasilitas->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
                        
            $edit='';
            if(bisaUbah($data['link'],$data['id_level']))
            {
                $edit=aksiEdit($data['link'].'edit',enkrip($field->id_fasilitas),'');
            }

            $hapus='';
            if(bisaHapus($data['link'],$data['id_level']))
            {
                $hapus=aksiHapusSwal($data['link'].'hapus',enkrip($field->id_fasilitas),'');
            }
            $detail=aksiModalLihat('#modalLihat',$field->id_fasilitas,'Lihat');
            $judul=stripcslashes($field->judul);
            $foto=gambarAws($field->gambar);
            
            $no++;
            $row=array();
            $row[] = $no;
           
            $row[] = $judul;
            $row[] = $detail;
            $row[] = '<a href="'.$foto.'" data-toggle="lightbox" data-title="'.$judul.'" >
                        <img src="'.$foto.'" width="75">
                    </a>';
            $row[] = $edit.'&nbsp;'.$hapus;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_fasilitas->count_all($where),
            "recordsFiltered" => $this->model_fasilitas->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    
} //controller