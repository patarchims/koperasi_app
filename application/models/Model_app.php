<?php
class Model_app extends CI_model
{
    public function view($table)
    {
        return $this->db->get($table);
    }

    public function insert($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function edit($table, $data)
    {
        return $this->db->get_where($table, $data);
    }

    public function update($table, $data, $where)
    {
        return $this->db->update($table, $data, $where);
    }

    public function delete($table, $where)
    {
        return $this->db->delete($table, $where);
    }

    public function view_where($table, $data)
    {
        $this->db->where($data);
        return $this->db->get($table);
    }

    public function view_ordering_limit($table, $order, $ordering, $baris, $dari)
    {
        $this->db->select('*');
        $this->db->order_by($order, $ordering);
        $this->db->limit($dari, $baris);
        return $this->db->get($table);
    }

    public function view_ordering($table, $order, $ordering)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order, $ordering);
        return $this->db->get()->result_array();
    }

    public function view_where_ordering($table, $data, $order, $ordering)
    {
        $this->db->where($data);
        $this->db->order_by($order, $ordering);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function view_column_where($table, $data, $where)
    {
        $this->db->select($data);
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function view_join_one($table1, $table2, $field, $order, $ordering)
    {
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1 . '.' . $field . '=' . $table2 . '.' . $field);
        $this->db->order_by($order, $ordering);
        return $this->db->get()->result_array();
    }

    public function view_join_where($table1, $table2, $field, $where, $order, $ordering)
    {
        $this->db->select('*');
        $this->db->from($table1);
        $this->db->join($table2, $table1 . '.' . $field . '=' . $table2 . '.' . $field);
        $this->db->where($where);
        $this->db->order_by($order, $ordering);
        return $this->db->get()->result_array();
    }


    public function insert_multiple($table, $data)
    {
        $this->db->insert_batch($table, $data);
    }

    public function insert_multiple_update($table, $data)
    {
        $this->db->insert_on_duplicate_update_batch($table, $data);
    }

    public function view_modul($id)
    {
        return $this->db->query("SELECT * FROM view_modul WHERE id_level='$id' AND baca = 1 order by urutan ASC")->result_array();
    }

    public function view_pinjaman($no_pinjaman)
    {
        return $db = $this->db->query("SELECT * FROM tb_pinjaman WHERE  no_pinjaman='$no_pinjaman'  order by id_pinjaman DESC")->row_array();
        // var_dump($db);
        // die;
        // if (!$db) {
        //     return null;
        // } else {
        //     return $db;
        // }
    }

    // public function view_pinjaman($no_pinjaman)
    // {
    //     $db = $this->db->query("SELECT status FROM tb_pinjaman WHERE  no_pinjaman='$no_pinjaman' order by id_pinjaman DESC")->row_array();
    //     if (!$db) {
    //         return '';
    //     } else {
    //         return $db['status'];
    //     }
    // }


    public function riwayat_login($id)
    {
        return $this->db->query("SELECT * FROM history_login WHERE email='$id'  order by id_history DESC LIMIT 0,10");
    }

    public function view_menu($id, $id_level)
    {
        return $this->db->query("SELECT * FROM view_menu WHERE id_modul='$id' AND id_level = '$id_level' AND id_parent = '0' AND baca='1' order by urutan ASC")->result_array();
    }

    public function view_submenu($id_menu, $id_level)
    {
        return $this->db->query("SELECT * FROM view_menu WHERE id_parent='$id_menu' AND id_level = '$id_level'  AND baca='1' order by urutan ASC")->result_array();
    }



    public function view_kode()
    {
        return $this->db->query("SELECT * FROM tbrefa  ORDER BY id ASC");
    }


    public function berita($p = 6)
    {
        return $this->db->query("SELECT a.*,b.kategori,b.seo as seokategori FROM berita as a JOIN kategori_berita as b on a.id_kategori=b.id_kategori ORDER BY a.id_berita DESC LIMIT 0,$p")->result_array();
    }

    public function beritadetail($seo)
    {
        return $this->db->query("SELECT a.*, b.kategori, b.seo as seokategori FROM berita as a JOIN kategori_berita as b on a.id_kategori=b.id_kategori WHERE a.seo='$seo'")->row_array();
    }

    function view_berita($cari = '')
    {

        return $this->db->query("SELECT a.*, b.kategori, b.seo as seokategori FROM berita as a JOIN kategori_berita as b on a.id_kategori=b.id_kategori WHERE a.judul LIKE '%$cari%' OR a.isi LIKE '%$cari%'  ORDER BY a.tanggal DESC, a.id_berita DESC")->result_array();
    }

    function view_berita_limit($cari = '', $dari, $baris)
    {
        return $this->db->query("SELECT a.*, b.kategori, b.seo as seokategori FROM berita as a JOIN kategori_berita as b on a.id_kategori=b.id_kategori WHERE a.judul LIKE '%$cari%' OR a.isi LIKE '%$cari%'  ORDER BY a.tanggal DESC, a.id_berita DESC LIMIT $dari,$baris")->result_array();
    }

    public function fasilitas($p = 10)
    {
        return $this->db->query("SELECT * FROM fasilitas ORDER BY RAND() LIMIT 0,$p")->result_array();
    }

    public function agenda()
    {
        return $this->db->query("SELECT * FROM agenda WHERE tanggal >= curdate() ORDER BY tanggal ASC ")->result_array();
    }

    function view_agenda($cari = '')
    {

        return $this->db->query("SELECT * FROM agenda WHERE judul LIKE '%$cari%' OR isi LIKE '%$cari%'  ORDER BY tanggal DESC, id_agenda DESC")->result_array();
    }

    function view_agenda_limit($cari = '', $dari, $baris)
    {
        return $this->db->query("SELECT * FROM agenda WHERE judul LIKE '%$cari%' OR isi LIKE '%$cari%'  ORDER BY tanggal DESC, id_agenda DESC LIMIT $dari,$baris")->result_array();
    }

    public function kategori_berita()
    {
        return $this->db->query("SELECT * FROM kategori_berita  ORDER BY urutan ASC ")->result_array();
    }

    function view_berita_kategori($kat, $cari = '')
    {

        return $this->db->query("SELECT a.*, b.kategori, b.seo as seokategori FROM berita as a JOIN kategori_berita as b on a.id_kategori=b.id_kategori WHERE (a.judul LIKE '%$cari%' OR a.isi LIKE '%$cari%') AND a.id_kategori='$kat'  ORDER BY a.tanggal DESC, a.id_berita DESC")->result_array();
    }

    function view_berita_kategori_limit($kat, $cari = '', $dari, $baris)
    {
        return $this->db->query("SELECT a.*, b.kategori, b.seo as seokategori FROM berita as a JOIN kategori_berita as b on a.id_kategori=b.id_kategori WHERE (a.judul LIKE '%$cari%' OR a.isi LIKE '%$cari%') AND a.id_kategori='$kat'  ORDER BY a.tanggal DESC, a.id_berita DESC LIMIT $dari,$baris")->result_array();
    }

    public function pengumuman($p = 5)
    {
        return $this->db->query("SELECT * FROM pengumuman ORDER BY tanggal DESC LIMIT 0,$p")->result_array();
    }

    function view_pengumuman($cari = '')
    {

        return $this->db->query("SELECT * FROM pengumuman WHERE judul LIKE '%$cari%' OR isi LIKE '%$cari%'  ORDER BY tanggal DESC")->result_array();
    }

    function view_pengumuman_limit($cari = '', $dari, $baris)
    {
        return $this->db->query("SELECT * FROM pengumuman WHERE (judul LIKE '%$cari%' OR isi LIKE '%$cari%') ORDER BY tanggal DESC LIMIT $dari,$baris")->result_array();
    }

    public function view_menu_admin($modul = '')
    {
        $where = '';
        if ($modul != '') {
            $where = " WHERE a.id_modul='$modul'";
        }
        return $this->db->query("SELECT a.*, b.nama_modul FROM menu as a join modul as b on a.id_modul=b.id_modul $where order by b.urutan ASC, a.id_parent ASC, a.urutan ASC")->result_array();
    }
} //class