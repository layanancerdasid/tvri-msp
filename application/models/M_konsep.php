<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class M_konsep extends CI_Model {
	
	function data_konsep($a) {
		$this->db->select("idkak, unit_kerja, nama_kegiatan, program, sasaran_program, indikator_kinerja, thn_anggaran, sasaran_kegiatan,  keluaran,
								   indikator_keluaran, volume_keluaran, satuan_ukur, dasar_hukum, gambaran_kegiatan, penerima_manfaat, indikator_kegiatan, strategi_pencapaian, sumber_dana, perkiraan_biaya, ms_satker_tvri.nama_satker");
		$this->db->from('trx_kak');
		$this->db->join('ms_satker_tvri', 'ms_satker_tvri.idsatker = trx_kak.unit_kerja','left');
		$this->db->where('idkak', $a);
		$d = $this->db->get()->row();
		return $d;
	}
	
	function data_lembaga($a) {
		$this->db->select("nama_satker");
		$this->db->from('ms_satker_tvri');
		$this->db->where('iddirektorat', $a);
		$d = $this->db->get()->row();
		return $d;
	}
	
	function data_rab_row($table, $key, $key_value, $order) {
		$this->db->select("COUNT(*) as count");
		$this->db->from($table);
		$this->db->where($key, $key_value);
		$d = $this->db->get()->row();
		return $d;
	}
	
	function data_rab($table, $key, $key_value, $order) {
		$this->db->select("*");
		$this->db->from($table);
		$this->db->where($key, $key_value);
		 $this->db->order_by($order); 
		return  $this->db->get()->result();
	}
}
?>
