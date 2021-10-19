<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bos extends CI_Controller
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
        $this->load->library('Curl');
        $this->data = array(
            'identitas' => $identitas,
            'ctrl' => 'informasi',
            'tabs' => menuwebsite()

        );
    }



    function index()
    {
        $data = $this->data;
        $data['link'] = 'bos';
        $data['title'] = 'Penggunaan BOS';
        $data['deskripsi'] = $data['identitas']['deskripsi'];
        $data['keyword'] = $data['identitas']['keyword'];
        if (isset($_POST['caritahun'])) {
            $this->session->set_userdata(array('caritahun' => postnumber('caritahun')));
        }
        $caritahun = $this->session->caritahun;
        if ($caritahun == '') {
            $caritahun = date('Y');
        }


        $url = 'https://simpelbos-batubara.com/api/snp/';


        $kirim = array('npsn' => $data['identitas']['kode'], 'tahun' => $caritahun);

        $jsonDataEncoded = json_encode($kirim);
        $this->curl->create($url);
        $this->curl->option(CURLOPT_HTTPHEADER, array('Content-type: application/json; Charset=UTF-8'));
        $this->curl->post($jsonDataEncoded);
        // Execute - returns responce 
        $result = $this->curl->execute();
        $obj = json_decode($result, true);
        $data['record'] = $obj;
        $data['caritahun'] = $caritahun;
        // echo json_encode($obj);
        $this->template->load('front', 'front/bos', $data);
    }
} //controller
