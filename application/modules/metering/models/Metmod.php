<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metmod extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function report($debug=false,$idlokasi,$ymd)
	{
		$str = "SELECT * FROM (
					SELECT qc.kategori, qc.kode_urut, qc.item, cl.tgl_laporan, cl.jawaban, qc.keterangan, cl.created
					FROM qc_metering qc
					LEFT JOIN  trx_metering_laporan cl ON qc.idqc=cl.idqc AND cl.idlokasi='$idlokasi' AND DATE_FORMAT(cl.tgl_laporan,'%Y-%m-%d')='$ymd'
					WHERE qc.kategori='Data Laporan' AND qc.aktif=1
					UNION
					SELECT 'Transmisi Analog' kategori, qc.kode_urut, qc.item, ca.tgl_laporan, ca.jawaban, qc.keterangan, ca.created
					FROM qc_metering qc
					LEFT JOIN  trx_metering_analog ca ON qc.idqc=ca.idqc AND ca.idlokasi='$idlokasi' AND DATE_FORMAT(ca.tgl_laporan,'%Y-%m-%d')='$ymd'
					WHERE qc.kategori='Analog' AND qc.aktif=1
					UNION
					SELECT 'Transmisi Digital' kategori, qc.kode_urut, qc.item, ca.tgl_laporan, ca.jawaban, qc.keterangan, ca.created
					FROM qc_metering qc
					LEFT JOIN  trx_metering_digital ca ON qc.idqc=ca.idqc AND ca.idlokasi='$idlokasi' AND DATE_FORMAT(ca.tgl_laporan,'%Y-%m-%d')='$ymd'
					WHERE qc.kategori='Digital' AND qc.aktif=1
				) rpt 
				WHERE 1=1 ";
		if($debug) return $str;
		$query = $this->db->query($str);
		if ($query->num_rows() > 0){
			return $query->result();
		}
		return null;		
	}


}
