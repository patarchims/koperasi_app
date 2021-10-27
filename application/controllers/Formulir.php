<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once APPPATH . '/third_party/library/Requests.php';
class Formulir extends CI_Controller
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
        $this->data = array(
            'identitas' => $identitas,
            'id_level' => $this->session->level,
            'header' => 'Formulir',
            'headers' => array('Content-Type' => 'application/json'),
            'ctrl' => 'formulir'
        );
    }

    function data()
    {
        $data = $this->data;
        $data['title'] = 'Data Formulir';
        $data['link'] = 'formulir/data';

        if (bisaBaca($data['link'], $data['id_level'])) {
            $this->template->load('admin', 'admin/formulir/data', $data);
        } else {
            redirect('dashboard');
        }
    }
}
