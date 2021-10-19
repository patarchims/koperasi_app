<?php

function opJurusan($p = '')
{
    $ci = &get_instance();
    $opsi = '<option value="">..::Pilih Jurusan::..</option>';
    $query = $ci->db->query("SELECT * FROM ppdb_jurusan WHERE status='1' ORDER BY id_jurusan asc ");
    foreach ($query->result_array() as $r) {
        $cl = ($r['id_jurusan'] == $p) ? 'selected' : '';
        $opsi .= '<option value="' . $r['id_jurusan'] . '" ' . $cl . '>' . stripslashes($r['jurusan']) . '</option>';
    }
    return $opsi;
}


function jurusanAktif($status = 1)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT count(id_jurusan) as jlh FROM ppdb_jurusan WHERE status='$status' ")->row_array();
    return $fav['jlh'];
}

function viewJurusan($p)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT jurusan FROM ppdb_jurusan WHERE id_jurusan='$p'")->row_array();
    return $fav['jurusan'];
}
