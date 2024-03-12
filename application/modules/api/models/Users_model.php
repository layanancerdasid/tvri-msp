<?php

class Users_model extends CI_Model {

    public $table = 'auth_users';

    public function __construct() {
        parent::__construct();
    }

    public function find_by_phone_and_password($phone,$password) {
        $result = $this->db->query("select u.*,gg.name as groupname,lt.idlokasi,lt.`nama_lokasi`,lt.alamat,
        lt.`iddesa`,lt.`idkec`,lt.`idkabupaten`,lt.`idprovinsi`,
        md.`nama_desa`, mk.`nama_kec`,kab.`nama_kabupaten`,mp.`nama_provinsi`,
        lt.wilayah_layanan,
        (
         SELECT group_concat(wilayah_layanan) FROM ms_area_layanan WHERE id IN (lt.wilayah_layanan)
        ) as nama_wilayah_layanan,gg.id as idgroup
         from auth_users u
        inner join auth_users_groups g on g.user_id = u.id
        inner join auth_groups gg on gg.id = g.group_id 
        inner join ms_lokasi_tvri lt on lt.idlokasi = u.idlokasi
        inner join ms_pegawai pg on pg.idlokasi = u.idlokasi
        inner join `ms_desa` md on md.`iddesa` = lt.iddesa
        inner join `ms_kecamatan` mk on mk.`idkec` = md.`idkec` 
        inner join `ms_kabupaten` kab on kab.`idkabupaten` = mk.`idkabupaten`
        inner join `ms_provinsi` mp on mp.`idprovinsi` = kab.`idprovinsi`
        WHERE u.phone='$phone' AND u.password='$password' AND u.active = 1 AND gg.id IN (3,4)")->row_array();
        return $result;
    }

    public function find_by_phone($phone) {
        $result = $this->db->query("select u.*,gg.name as groupname,lt.idlokasi,lt.`nama_lokasi`,lt.alamat,
        lt.`iddesa`,lt.`idkec`,lt.`idkabupaten`,lt.`idprovinsi`,
        md.`nama_desa`, mk.`nama_kec`,kab.`nama_kabupaten`,mp.`nama_provinsi`,
        lt.wilayah_layanan,
        (
         SELECT group_concat(wilayah_layanan) FROM ms_area_layanan WHERE id IN (lt.wilayah_layanan)
        ) as nama_wilayah_layanan,gg.id as idgroup
         from auth_users u
        inner join auth_users_groups g on g.user_id = u.id
        inner join auth_groups gg on gg.id = g.group_id 
        left join ms_lokasi_tvri lt on lt.idlokasi = u.idlokasi
        left join ms_pegawai pg on pg.idlokasi = u.idlokasi
        left join `ms_desa` md on md.`iddesa` = lt.iddesa
        left join `ms_kecamatan` mk on mk.`idkec` = md.`idkec` 
        left join `ms_kabupaten` kab on kab.`idkabupaten` = mk.`idkabupaten`
        left join `ms_provinsi` mp on mp.`idprovinsi` = kab.`idprovinsi`
        WHERE u.phone='$phone' AND u.active = 1 AND gg.id IN (3,4)")->row_array();
        return $result;
    }

    public function find_by_token($token) {
        $result = $this->db->query("select u.*,gg.name as groupname,lt.idlokasi,lt.`nama_lokasi`,lt.alamat,
        lt.`iddesa`,lt.`idkec`,lt.`idkabupaten`,lt.`idprovinsi`,
        md.`nama_desa`, mk.`nama_kec`,kab.`nama_kabupaten`,mp.`nama_provinsi`,
        lt.wilayah_layanan,
        (
         SELECT group_concat(wilayah_layanan) FROM ms_area_layanan WHERE id IN (lt.wilayah_layanan)
        ) as nama_wilayah_layanan,gg.id as idgroup
         from auth_users u
        inner join auth_users_groups g on g.user_id = u.id
        inner join auth_groups gg on gg.id = g.group_id 
        inner join ms_lokasi_tvri lt on lt.idlokasi = u.idlokasi
        inner join ms_pegawai pg on pg.idlokasi = u.idlokasi
        inner join `ms_desa` md on md.`iddesa` = lt.iddesa
        inner join `ms_kecamatan` mk on mk.`idkec` = md.`idkec` 
        inner join `ms_kabupaten` kab on kab.`idkabupaten` = mk.`idkabupaten`
        inner join `ms_provinsi` mp on mp.`idprovinsi` = kab.`idprovinsi`
        WHERE u.token='$token'")->row_array();
        if ($result) {
            return $result;
        }
        return $result;
    }

    public function find_by_email($email) {
        $this->db->where('email', $email);
        $result = $this->db->get($this->table)->row_array();
        if (isset($result)) {
            return $result;
        }
        return $result;
    }

    public function is_active($iduser) {
        $this->db->where('id', $iduser);
        $this->db->where('active', 1);
        $result = $this->db->get($this->table)->row_array();
        if (isset($result)) {
            return true;
        }
        return false;
    }

}
