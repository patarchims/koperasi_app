<?php
class Model_ppdb extends CI_model
{
    public function pendaftar($tahun)
    {
        $where = array('a.tahun' => $tahun);
        $this->db->select('a.*,b.jurusan');
        $this->db->from('ppdb_pendaftar as a');
        $this->db->join('ppdb_jurusan as b', 'a.id_jurusan=b.id_jurusan', 'left');
        $this->db->where($where);
        $this->db->order_by('a.id', 'asc');
        return $this->db->get()->result_array();
    }
} //class