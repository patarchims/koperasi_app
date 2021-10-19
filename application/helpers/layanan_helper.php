<?php

function opPenandatangan($p = '')
{
    $ci = &get_instance();
    $opsi = '';
    $query = $ci->db->query("SELECT * FROM layanan_penandatangan ORDER BY id asc ");
    foreach ($query->result_array() as $r) {
        $cl = ($r['id'] == $p) ? 'selected' : '';
        $opsi .= '<option value="' . $r['id'] . '" ' . $cl . '>' . stripslashes($r['nama']) . ' - ' . $r['jabatan'] . '</option>';
    }
    return $opsi;
}

function opGuru($p = '')
{
    $ci = &get_instance();
    $opsi = '';
    $query = $ci->db->query("SELECT a.id_guru, a.nama, b.jabatan  FROM guru as a LEFT JOIN jabatan as b on a.id_jabatan=b.id_jabatan ORDER BY b.urutan asc ");
    foreach ($query->result_array() as $r) {
        $cl = ($r['id_guru'] == $p) ? 'selected' : '';
        $opsi .= '<option value="' . $r['id_guru'] . '" ' . $cl . '>' . stripslashes($r['nama']) . ' - ' . $r['jabatan'] . '</option>';
    }
    return $opsi;
}

function opSiswa($p = '')
{
    $ci = &get_instance();
    $opsi = '';
    $query = $ci->db->query("SELECT a.id_siswa, a.nama, a.nisn  FROM siswa as a ORDER BY a.nama asc ");
    foreach ($query->result_array() as $r) {
        $cl = ($r['id_siswa'] == $p) ? 'selected' : '';
        $opsi .= '<option value="' . $r['id_siswa'] . '" ' . $cl . '>' . stripslashes($r['nisn']) . ' - ' . stripslashes($r['nama']) . '</option>';
    }
    return $opsi;
}

function opPelaksana($idlayanan)
{
    $ci = &get_instance();
    $opsi = '';
    $query = $ci->db->query("SELECT a.id_guru, a.nama, b.jabatan  FROM guru as a LEFT JOIN jabatan as b on a.id_jabatan=b.id_jabatan WHERE a.id_guru NOT IN (SELECT id_ptk FROM layanan_01_peserta WHERE id_layanan='$idlayanan') ORDER BY b.urutan asc ");
    foreach ($query->result_array() as $r) {

        $opsi .= '<option value="' . $r['id_guru'] . '">' . stripslashes($r['nama']) . ' - ' . $r['jabatan'] . '</option>';
    }
    return $opsi;
}

function opGajiBerkala($idlayanan)
{
    $ci = &get_instance();
    $opsi = '';
    $query = $ci->db->query("SELECT a.id_guru, a.nama, b.jabatan, a.nip  FROM guru as a LEFT JOIN jabatan as b on a.id_jabatan=b.id_jabatan WHERE a.id_guru NOT IN (SELECT id_ptk FROM layanan_06_peserta WHERE id_layanan='$idlayanan') ORDER BY b.urutan asc ");
    foreach ($query->result_array() as $r) {

        $opsi .= '<option value="' . $r['id_guru'] . '">' . stripslashes($r['nip']) . ' - ' . stripslashes($r['nama']) . '</option>';
    }
    return $opsi;
}

function statusTiket($id = 0)
{
    if ($id == 0) {
        $status = '<button type="button" class="btn btn-xs btn-success">Baru</button>';
    } else if ($id == 1) {
        $status = '<button type="button" class="btn btn-xs btn-warning">Proses</button>';
    } else {
        $status = '<button type="button" class="btn btn-xs btn-danger">Selesai</button>';
    }
    return $status;
}

function viewSiswa($p, $q = 'nama')
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT $q FROM siswa WHERE id_siswa='$p'")->row_array();
    return $fav[$q];
}

function viewGuru($p, $q = 'nama')
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT $q FROM guru WHERE id_guru='$p'")->row_array();
    return $fav[$q];
}
