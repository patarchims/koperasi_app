<?php
class Model_layanan extends CI_model
{
    public function layanan01($id)
    {
        $where = array('a.id' => $id);
        $this->db->select('a.*,b.jabatan,b.nama,b.nip,b.pangkat,b.kategori');
        $this->db->from('layanan_01 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function layanan01guru($tahun, $id_guru)
    {
        $where = array('c.id_ptk' => $id_guru, 'YEAR(a.tanggal)' => $tahun);
        $this->db->select('c.keterangan,c.id_ptk,a.*,b.jabatan,b.nama,b.nip,b.pangkat,b.kategori');
        $this->db->from('layanan_01_peserta as c');
        $this->db->join('layanan_01 as a', 'c.id_layanan=a.id');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->where($where);
        $this->db->order_by('a.tanggal', 'desc');
        return $this->db->get()->result_array();
    }

    public function layanan01peserta($id)
    {
        $where = array('a.id_layanan' => $id);
        $this->db->select('a.*,b.nama,b.nip,c.jabatan');
        $this->db->from('layanan_01_peserta as a');
        $this->db->join('guru as b', 'a.id_ptk=b.id_guru');
        $this->db->join('jabatan as c', 'b.id_jabatan=c.id_jabatan', 'left');
        $this->db->where($where);
        $this->db->order_by('c.urutan', 'asc');
        return $this->db->get()->result_array();
    }

    public function layanan02($id)
    {
        $where = array('a.id' => $id);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori, c.nama, c.nip, c.pangkat, c.gol, d.jabatan');
        $this->db->from('layanan_02 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->join('guru as c', 'a.id_ptk=c.id_guru');
        $this->db->join('jabatan as d', 'c.id_jabatan=d.id_jabatan', 'left');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function layanan02guru($tahun, $id_guru)
    {
        $where = array('a.id_ptk' => $id_guru, 'YEAR(a.tanggal)' => $tahun);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori, c.nama, c.nip, c.pangkat, c.gol, d.jabatan');
        $this->db->from('layanan_02 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->join('guru as c', 'a.id_ptk=c.id_guru');
        $this->db->join('jabatan as d', 'c.id_jabatan=d.id_jabatan', 'left');
        $this->db->where($where);
        $this->db->order_by('a.tanggal', 'desc');
        return $this->db->get()->result_array();
    }

    public function layanan03($id)
    {
        $where = array('a.id' => $id);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori, c.nama, c.nis, c.nisn, c.kelas, c.program, c.nama_ayah, c.jk');
        $this->db->from('layanan_03 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->join('siswa as c', 'a.id_siswa=c.id_siswa');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function layanan03siswa($tahun, $id_siswa)
    {
        $where = array('a.id_siswa' => $id_siswa, 'YEAR(a.tanggal)' => $tahun);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori, c.nama, c.nisn, c.nis, c.kelas');
        $this->db->from('layanan_03 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->join('siswa as c', 'a.id_siswa=c.id_siswa');
        $this->db->where($where);
        $this->db->order_by('a.tanggal', 'desc');
        return $this->db->get()->result_array();
    }

    public function layanan04($id)
    {
        $where = array('a.id' => $id);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori, c.nama, c.nis, c.nisn, c.kelas, c.program, c.nama_ayah, c.jk');
        $this->db->from('layanan_04 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->join('siswa as c', 'a.id_siswa=c.id_siswa');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function layanan04siswa($tahun, $id_siswa)
    {
        $where = array('a.id_siswa' => $id_siswa, 'YEAR(a.tanggal)' => $tahun);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori, c.nama, c.nisn, c.nis, c.kelas');
        $this->db->from('layanan_04 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->join('siswa as c', 'a.id_siswa=c.id_siswa');
        $this->db->where($where);
        $this->db->order_by('a.tanggal', 'desc');
        return $this->db->get()->result_array();
    }

    public function layanan05($id)
    {
        $where = array('a.id' => $id);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori');
        $this->db->from('layanan_05 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function layanan05siswa($tahun, $id_siswa)
    {
        $where = array('a.id_siswa' => $id_siswa, 'YEAR(a.tanggal)' => $tahun);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori, c.nama, c.nisn, c.nis, c.kelas');
        $this->db->from('layanan_05 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->join('siswa as c', 'a.id_siswa=c.id_siswa');
        $this->db->where($where);
        $this->db->order_by('a.tanggal', 'desc');
        return $this->db->get()->result_array();
    }

    public function layanan06($id)
    {
        $where = array('a.id' => $id);
        $this->db->select('a.*,b.jabatan,b.nama,b.nip,b.pangkat,b.kategori');
        $this->db->from('layanan_06 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function layanan06guru($tahun, $id_guru)
    {
        $where = array('c.id_ptk' => $id_guru, 'YEAR(a.tanggal)' => $tahun);
        $this->db->select('c.keterangan,c.id_ptk,a.*,b.jabatan,b.nama,b.nip,b.pangkat,b.kategori');
        $this->db->from('layanan_06_peserta as c');
        $this->db->join('layanan_06 as a', 'c.id_layanan=a.id');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->where($where);
        $this->db->order_by('a.tanggal', 'desc');
        return $this->db->get()->result_array();
    }

    public function layanan06peserta($id)
    {
        $where = array('a.id_layanan' => $id);
        $this->db->select('a.*,b.nama,b.nip,c.jabatan,b.gol');
        $this->db->from('layanan_06_peserta as a');
        $this->db->join('guru as b', 'a.id_ptk=b.id_guru');
        $this->db->join('jabatan as c', 'b.id_jabatan=c.id_jabatan', 'left');
        $this->db->where($where);
        $this->db->order_by('c.urutan', 'asc');
        return $this->db->get()->result_array();
    }

    public function layanan07($id)
    {
        $where = array('a.id' => $id);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori');
        $this->db->from('layanan_07 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function layanan08($id)
    {
        $where = array('a.id' => $id);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori');
        $this->db->from('layanan_08 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }
    public function layanan09($id)
    {
        $where = array('a.id' => $id);
        $this->db->select('a.*,b.jabatan as pjabatan,b.nama as pnama, b.nip as pnip,b.pangkat as ppangkat,b.kategori');
        $this->db->from('layanan_09 as a');
        $this->db->join('layanan_penandatangan as b', 'a.penandatangan=b.id');
        $this->db->where($where);
        return $this->db->get()->row_array();
    }

    public function opentiketsiswa($tahun, $id_siswa)
    {
        $where = array('id_siswa' => $id_siswa, 'YEAR(tanggal)' => $tahun);
        $this->db->from('siswa_tiket');
        $this->db->where($where);
        $this->db->order_by('tanggal', 'desc');
        return $this->db->get()->result_array();
    }

    public function siswa_chat($id)
    {
        $where = array('id_tiket' => $id);
        $this->db->from('siswa_tiket_chat');
        $this->db->where($where);
        $this->db->order_by('id', 'asc');
        return $this->db->get()->result_array();
    }

    public function tiket_siswa($tahun, $status)
    {
        $where = array('a.status' => $status, 'YEAR(a.tanggal)' => $tahun);
        $this->db->select('a.*,b.nama');
        $this->db->from('siswa_tiket as a');
        $this->db->join('siswa as b', 'a.id_siswa=b.id_siswa');
        $this->db->where($where);
        $this->db->order_by('a.id', 'asc');
        return $this->db->get()->result_array();
    }

    public function opentiketguru($tahun, $id_guru)
    {
        $where = array('id_guru' => $id_guru, 'YEAR(tanggal)' => $tahun);
        $this->db->from('guru_tiket');
        $this->db->where($where);
        $this->db->order_by('tanggal', 'desc');
        return $this->db->get()->result_array();
    }

    public function guru_chat($id)
    {
        $where = array('id_tiket' => $id);
        $this->db->from('guru_tiket_chat');
        $this->db->where($where);
        $this->db->order_by('id', 'asc');
        return $this->db->get()->result_array();
    }

    public function tiket_guru($tahun, $status)
    {
        $where = array('a.status' => $status, 'YEAR(a.tanggal)' => $tahun);
        $this->db->select('a.*,b.nama');
        $this->db->from('guru_tiket as a');
        $this->db->join('guru as b', 'a.id_guru=b.id_guru');
        $this->db->where($where);
        $this->db->order_by('a.id', 'asc');
        return $this->db->get()->result_array();
    }
} //class