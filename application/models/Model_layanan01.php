<?php

class Model_layanan01 extends CI_Model
{

    var $table = 'layanan_01 as a'; //nama tabel dari database
    var $table1 = 'layanan_penandatangan as b'; //nama tabel dari database
    var $column_order = array(null, 'a.nomor', 'a.tanggal', 'b.nama', null, null); //field yang ada di table user
    var $column_search = array('a.nomor', 'a.tanggal', 'b.nama'); //field yang diizin untuk pencarian 
    var $order = array('a.tanggal' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($where = '')
    {
        $this->db->select('a.*,b.nama,b.nip');
        $this->db->from($this->table);
        $this->db->join($this->table1, 'a.penandatangan=b.id');
        if ($where != '') {
            $this->db->where($where);
        }
        $i = 0;

        foreach ($this->column_search as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($where = '')
    {
        $this->_get_datatables_query($where);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($where = '')
    {
        $this->_get_datatables_query($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($where = '')
    {
        $this->db->select('a.id');
        $this->db->from($this->table);
        $this->db->join($this->table1, 'a.penandatangan=b.id');
        if ($where != '') {
            $this->db->where($where);
        }
        return $this->db->count_all_results();
    }
}
