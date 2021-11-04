<?php
function identitas($p)
{
    $ci = &get_instance();
    $bg = $ci->db->query("SELECT $p FROM identitas WHERE id=1")->row_array();
    return $bg[$p];
}

function viewAnggota($id, $field)
{
    $ci = &get_instance();
    $bg = $ci->db->query("SELECT $field FROM tb_anggota WHERE id_anggota=$id")->row_array();
    return $bg[$field];
}

function viewFieldPinjaman($no, $field)
{
    $ci = &get_instance();
    $bg = $ci->db->query("SELECT $field FROM tb_pinjaman WHERE no_pinjaman='$no'")->row_array();
    return $bg[$field];
}

function jlhAnggota()
{
    $ci = &get_instance();
    $bg = $ci->db->query("SELECT COUNT(*) AS jumlah FROM tb_anggota")->row_array();
    return $bg['jumlah'];
}

function jlhPinjaman()
{
    $ci = &get_instance();
    $bg = $ci->db->query("SELECT SUM(jlh_pinjam) AS jlh_pinjaman FROM tb_pinjaman")->row_array();
    return $bg['jlh_pinjaman'];
}



function statusAnggota($id)
{
    $ci = &get_instance();
    $db =  $ci->db->query("SELECT status FROM tb_pinjaman WHERE id_anggota=$id ORDER BY id_pinjaman DESC")->row_array();
    if (!$db) {
        return '';
    } else {
        return $db['status'];
    }
}

function hitungAngsuran($no_pinjaman)
{
    $ci = &get_instance();
    $result = $ci->db->query("SELECT COUNT(*) as jumlah FROM tb_angsuran WHERE no_pinjaman = '$no_pinjaman'")->row_array();
    return $result['jumlah'] + 1;
}


function idPinjaman($id)
{
    $ci = &get_instance();
    $db =  $ci->db->query("SELECT id_pinjaman FROM tb_pinjaman WHERE id_anggota=$id ORDER BY id_pinjaman DESC")->row_array();
    return $db['id_pinjaman'];
}

function hitungDenda($tgl, $jlhAngsuran)
{

    $t = date_create($tgl);
    $n = date_create(date('Y-m-d'));
    $terlambat = date_diff($t, $n);
    $hari = $terlambat->format("%a");

    return $denda = ($jlhAngsuran * 1 / 100) * $hari;
}


function bisaBaca($link, $id_level)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT baca FROM view_menu WHERE link='$link' AND id_level='$id_level'")->row_array();
    return $fav['baca'];
}

function bisaTulis($link, $id_level)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT tulis FROM view_menu WHERE link='$link' AND id_level='$id_level'")->row_array();
    return $fav['tulis'];
}

function bisaUbah($link, $id_level)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT ubah FROM view_menu WHERE link='$link' AND id_level='$id_level'")->row_array();
    return $fav['ubah'];
}

function bisaHapus($link, $id_level)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT hapus FROM view_menu WHERE link='$link' AND id_level='$id_level'")->row_array();
    return $fav['hapus'];
}

function cekMenu($p, $q)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT id_menu FROM view_menu WHERE id_modul='$p' AND id_level='$q' AND baca=1 ")->num_rows();
    return $fav;
}

function cekSubMenu($p, $q)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT id_menu FROM view_menu WHERE id_parent='$p' AND id_level='$q' AND baca=1 ")->num_rows();
    return $fav;
}

function aksesMenu($modul, $level)
{
    $ci = &get_instance();
    $query = $ci->db->query("SELECT id_menu FROM menu WHERE id_modul='$modul'")->num_rows();
    if ($query > 0) {
        $aksi = '<a title="Akses Menu" href="' . base_url('config/aksesmenu/' . $modul . '/' . $level) . '" class="btn btn-block btn-primary" ><i class="fa fa-info-circle"></i> Detail</a>';
    } else {
        $aksi = '';
    }
    return $aksi;
}


function opModul($p = '')
{
    $ci = &get_instance();
    $opsi = '<option value="" >..::Pilih Modul::..</option>';
    $query = $ci->db->query("SELECT * FROM modul ORDER BY urutan ASC ");
    foreach ($query->result_array() as $r) {
        $cl = ($r['id_modul'] == $p) ? 'selected' : '';
        $opsi .= '<option value="' . $r['id_modul'] . '" ' . $cl . '>' . $r['nama_modul'] . '</option>';
    }
    return $opsi;
}

function opParentMenu($p, $q = '')
{
    $ci = &get_instance();
    $opsi = '<option value="" >..::Root::..</option>';
    $query = $ci->db->query("SELECT * FROM menu WHERE id_modul='$p' AND id_parent=0 ");
    foreach ($query->result_array() as $r) {
        $cl = ($r['id_menu'] == $q) ? 'selected' : '';
        $opsi .= '<option value="' . $r['id_menu'] . '" ' . $cl . '>' . $r['nama_menu'] . '</option>';
    }
    return $opsi;
}
function getMenu($postData)
{
    $ci = &get_instance();
    $response = array();

    // Select record
    $ci->db->select('id_menu,nama_menu');
    $ci->db->where('id_modul', $postData['modul']);
    $ci->db->where('id_parent', 0);
    $q = $ci->db->get('menu');
    $response = $q->result_array();

    return $response;
}

function getModul($postData)
{
    $ci = &get_instance();
    //$response = array();

    // Select record
    $ci->db->select('controller');
    $ci->db->where('id_modul', $postData['modul']);
    $q = $ci->db->get('modul');
    $response = $q->row_array();

    return $response['controller'];
}

function viewModul($p)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT nama_modul FROM modul WHERE id_modul='$p'")->row_array();
    return $fav['nama_modul'];
}

function idParent($p)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT id_parent FROM menu WHERE link='$p'")->row_array();
    return $fav['id_parent'];
}


function opLevel($p = '')
{
    $ci = &get_instance();
    $opsi = '<option value="" >..::Pilih Level::..</option>';
    $query = $ci->db->query("SELECT * FROM level ");
    foreach ($query->result_array() as $r) {
        $cl = ($r['id_level'] == $p) ? 'selected' : '';
        $opsi .= '<option value="' . $r['id_level'] . '" ' . $cl . '>' . $r['nama_level'] . '</option>';
    }
    return $opsi;
}

function viewLevel($p, $q = 'nama_level')
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT $q FROM level WHERE id_level='$p'")->row_array();
    return $fav[$q];
}

function viewUser($p, $q = 'nama')
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT $q FROM user WHERE id_user='$p'")->row_array();
    return $fav[$q];
}

function opEnum($table, $field, $value = '')
{
    $ci = &get_instance();
    $opsi = '';
    $ss = $ci->db->query("SHOW FIELDS FROM $table")->result_array();
    foreach ($ss as $as) {
        # code...

        $arrs = $as['Type'];
        if (substr($arrs, 0, 4) == 'enum' && $as['Field'] == $field) break;
    }
    $arr5 = array();
    $arrs = '' . substr($arrs, 4);
    $arr = eval('$arr5 = array' . $arrs . ';');
    foreach ($arr5 as $k => $v) {
        if ($v == $value) {
            $opsi .= '<option value="' . $v . '" selected>' . $v . '</option>';
        } else {
            $opsi .= '<option value="' . $v . '">' . $v . '</option>';
        }
    }
    return $opsi;
}

function viewAplikasi($p)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT referensi FROM tbrefa WHERE idxref='$p'")->row_array();
    return $fav['referensi'];
}

function viewKodeApp($p, $q)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT nmaref1,nmaref2 FROM tbrefb WHERE idxref='$p' AND kderef='$q'")->row_array();
    if ($fav['nmaref2'] != '') {
        return $fav['nmaref1'] . ' ' . $fav['nmaref2'];
    } else {
        return $fav['nmaref1'];
    }
}

function opKodeApp($p, $q = '')
{
    $ci = &get_instance();
    $opsi = '<option value="" >..::Pilih ' . viewAplikasi($p) . '::..</option>';
    $query = $ci->db->query("SELECT * FROM tbrefb WHERE idxref='$p' ORDER BY id");
    foreach ($query->result_array() as $r) {
        $cl = ($r['kderef'] == $q) ? 'selected' : '';
        $opsi .= '<option value="' . $r['kderef'] . '" ' . $cl . '>' . $r['nmaref1'] . ' ' . $r['nmaref2'] . '</option>';
    }
    return $opsi;
}


function opAnggota($p = '')
{
    $ci = &get_instance();
    $opsi = '';
    $query = $ci->db->query("SELECT a.id_anggota, a.nama_anggota, a.no_anggota FROM tb_anggota as a ORDER BY a.id_anggota asc");
    foreach ($query->result_array() as $r) {
        $cl = ($r['id_anggota'] == $p) ? 'selected' : '';
        $opsi .= '<option value="' . $r['id_anggota'] . '" ' . $cl . '>' . stripslashes($r['no_anggota']) . ' - ' . stripslashes($r['nama_anggota']) . '</option>';
    }
    return $opsi;
}




function opJabatan($p = '')
{
    $ci = &get_instance();
    $opsi = '<option value="" >..::Pilih Jabatan::..</option>';
    $query = $ci->db->query("SELECT * FROM jabatan ORDER BY urutan ");
    foreach ($query->result_array() as $r) {
        $cl = ($r['id_jabatan'] == $p) ? 'selected' : '';
        $opsi .= '<option value="' . $r['id_jabatan'] . '" ' . $cl . '>' . $r['jabatan'] . '</option>';
    }
    return $opsi;
}

function viewPinjaman($p)
{
    $ci = &get_instance();
    return $fav = $ci->db->query("SELECT * FROM view_pinjaman WHERE id_pinjaman='$p'")->row_array();
}



function viewKelas($id)
{
    $ci = &get_instance();
    $fav = $ci->db->query("SELECT kelas FROM view_kelas WHERE id_siswa='$id'")->row_array();
    $tingkat = identitas('tingkat');
    if ($tingkat == 'SD') {
        return $fav['kelas'];
    } else {
        return $fav['kelas'] + 6;
    }
}



function menutk()
{
    $ci = &get_instance();

    $sql = $ci->db->query("SELECT judul,seo FROM halaman WHERE jenis='Profil' ORDER BY urutan asc")->result_array();
    $menup = array();
    foreach ($sql as $key) {
        $menup[] = array('title-menu' => $key['judul'], 'url' => base_url('tentangkami/detail/halaman/' . $key['seo']));
    }
    $menup[] = array('title-menu' => 'Prestasi', 'url' => base_url('tentangkami/prestasi'));
    $menup[] = array('title-menu' => 'Kerjasama', 'url' => base_url('tentangkami/kerjasama'));
    $menup[] = array('title-menu' => 'Fasilitas', 'url' => base_url('tentangkami/fasilitas'));

    return $menup;
}

function menuwebsite()
{
    return array(
        array(
            'title-menu' => 'Home',
            'url' => base_url(),
            'ctrl' => 'home',
            'child' => array()
        ),
        array(
            'title-menu' => 'Profil',
            'url' => 'javascript:;',
            'ctrl' => 'tentangkami',
            'child' => menutk()
        ),

        array(
            'title-menu' => 'Gallery',
            'url' => 'javascript:;',
            'ctrl' => 'gallery',
            'child' => array(
                array(
                    'title-menu' => 'Gallery Foto',
                    'url' => base_url('gallery/foto')
                ),
                array(
                    'title-menu' => 'Gallery Video',
                    'url' => base_url('gallery/video')
                ),
            )
        ),
        array(
            'title-menu' => 'Informasi',
            'url' => 'javascript:;',
            'ctrl' => 'informasi',
            'child' => array(
                array(
                    'title-menu' => 'Berita',
                    'url' => base_url('informasi/berita')
                ),
                array(
                    'title-menu' => 'Agenda',
                    'url' => base_url('informasi/agenda')
                ),
                array(
                    'title-menu' => 'Pengumuman',
                    'url' => base_url('informasi/pengumuman')
                ),
                array(
                    'title-menu' => 'Penggunaan BOS',
                    'url' => base_url('bos')
                )
            )
        ),
        array(
            'title-menu' => 'Data',
            'url' => 'javascript:;',
            'ctrl' => 'data',
            'child' => array(
                array(
                    'title-menu' => 'Siswa',
                    'url' => base_url('data/siswa')
                ),
                array(
                    'title-menu' => 'Guru',
                    'url' => base_url('data/guru')
                ),
                array(
                    'title-menu' => 'Pegawai',
                    'url' => base_url('data/pegawai')
                )
            )
        ),
        array(
            'title-menu' => 'Download',
            'url' => base_url('download'),
            'ctrl' => 'download',
            'child' => array()
        ),
        array(
            'title-menu' => 'Tentang Disdik',
            'url' => 'javascript:;',
            'ctrl' => 'infodinas',
            'child' => array(
                array(
                    'title-menu' => 'Profil Dinas Pendidikan ',
                    'url' => base_url('infodinas/profil')
                ),
                array(
                    'title-menu' => 'Berita',
                    'url' => base_url('infodinas/berita')
                ),
                array(
                    'title-menu' => 'Pengumuman',
                    'url' => base_url('infodinas/pengumuman')
                ),
                array(
                    'title-menu' => 'Download',
                    'url' => base_url('infodinas/download')
                )
            )
        ),
        array(
            'title-menu' => 'Hubungi Kami',
            'url' => base_url('hubungikami'),
            'ctrl' => 'hubungikami',
            'child' => array()
        ),
    );
}


function menuguru()
{
    return array(
        array(
            'title-menu' => 'Dashboard',
            'url' => 'guru',
            'icon' => 'home',
            'ctrl' => 'dashboard',
            'child' => array()
        ),
        array(
            'title-menu' => 'Profil',
            'url' => 'guru/profil',
            'icon' => 'user',
            'ctrl' => 'profil',
            'child' => array()
        ),
        array(
            'title-menu' => 'Layanan',
            'url' => 'javascript:;',
            'icon' => 'handshake',
            'ctrl' => 'layanan',
            'child' => array(
                array(
                    'title-menu' => 'Surat Tugas',
                    'url' => 'guru/surattugas'
                ),
                array(
                    'title-menu' => 'Surat Keterangan',
                    'url' => 'guru/suratketerangan'
                ),
                array(
                    'title-menu' => 'Usulan Kenaikan Gaji Berkala',
                    'url' => 'guru/gajiberkala'
                ),
                array(
                    'title-menu' => 'Open Tiket',
                    'url' => 'guru/opentiket'
                )
            )
        ),

    );
}

function menusiswa()
{
    return array(
        array(
            'title-menu' => 'Dashboard',
            'url' => 'siswa',
            'icon' => 'home',
            'ctrl' => 'dashboard',
            'child' => array()
        ),
        array(
            'title-menu' => 'Profil',
            'url' => 'siswa/profil',
            'icon' => 'user',
            'ctrl' => 'profil',
            'child' => array()
        ),
        array(
            'title-menu' => 'Layanan',
            'url' => 'javascript:;',
            'icon' => 'handshake',
            'ctrl' => 'layanan',
            'child' => array(
                array(
                    'title-menu' => 'Surat Keterangan',
                    'url' => 'siswa/suratketerangan'
                ),
                array(
                    'title-menu' => 'Surat Keterangan Berkelakuan Baik',
                    'url' => 'siswa/skbb'
                ),
                array(
                    'title-menu' => 'Open Tiket',
                    'url' => 'siswa/opentiket'
                )
            )
        ),

    );
}
