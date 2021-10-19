<?php
class Export extends CI_Controller
{
  var $data;
  var $style_col;
  var $style_row;
  function __construct()
  {
    parent::__construct(); // needed when adding a constructor to a controller
    include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
    $this->load->helper('ppdb_helper');
    $this->load->model('model_ppdb');
    $identitas = $this->model_app->edit('identitas', array('id' => 1))->row_array();
    $this->data = array(
      'user' => $this->session->id_user,
      'id_level' => $this->session->level,
      'identitas' => $identitas
    );
    $this->style_col = array(
      'font' => array('bold' => true),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      ),
      'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
      )
    );
    $this->style_row = array(
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
      ),
      'borders' => array(
        'top' => array(
          'style'  => PHPExcel_Style_Border::BORDER_THIN
        ), // Set border top dengan garis tipis
        'right' => array(
          'style'  => PHPExcel_Style_Border::BORDER_THIN
        ),  // Set border right dengan garis tipis
        'bottom' => array(
          'style'  => PHPExcel_Style_Border::BORDER_THIN
        ), // Set border bottom dengan garis tipis
        'left' => array(
          'style'  => PHPExcel_Style_Border::BORDER_THIN
        ) // Set border left dengan garis tipis
      )
    );
  }

  function index()
  {
  }


  function pendaftar($tahun)
  {
    $data = $this->data;
    $data['tahun'] = $tahun;
    $data['style_row'] = $this->style_row;
    $data['style_col'] = $this->style_col;
    $data['excel'] = new PHPExcel();
    $data['record'] = $this->model_ppdb->pendaftar($tahun);
    $this->load->view('admin/ppdb/pendaftar/export', $data);
  }
}//controller