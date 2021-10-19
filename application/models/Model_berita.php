<?php
 
class Model_berita extends CI_Model {
 
    var $table1 = 'berita as a'; //nama tabel dari database
    var $table2 = 'kategori_berita as b';
    var $column_order = array(null,null, 'a.tanggal','a.judul','b.kategori','a.pub','a.dibaca','a.input_user',null); //field yang ada di table user
    var $column_search = array('a.tanggal','a.judul','b.kategori','a.isi'); //field yang diizin untuk pencarian 
    var $order = array('tanggal' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($where='')
    {
         
        $this->db->select('a.*, b.kategori');
        $this->db->from($this->table1);
        $this->db->join($this->table2, 'a.id_kategori=b.id_kategori');
        if($where!='')
        {
            $this->db->where($where);
        }
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables($where='')
    {
        $this->_get_datatables_query($where);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($where='')
    {
        $this->_get_datatables_query($where);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all($where='')
    {
        $this->db->select('a.*, b.kategori');
        $this->db->from($this->table1);
        $this->db->join($this->table2, 'a.id_kategori=b.id_kategori');
        if($where!='')
        {
            $this->db->where($where);
        }
        return $this->db->count_all_results();
    }
 
}