<?php
/**
 * Name:    Global Model
 * Author:  elektra
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Global Model
 */
class Global_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function create_breadcrumbs($arr)
	{
		$item ='<div class="d-flex align-items-baseline flex-wrap mr-5">
				<h5 class="text-dark font-weight-bold my-1 mr-5">e-Transmisi</h5>
				<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">';
		foreach($arr as $key =>$v){
			if(count($arr)-1 !== $key){
				$item .= '<li class="breadcrumb-item"><a href="#" class="text-muted">'.$v.'</a></li>';
			}else{
				$item .= '<li class="breadcrumb-item"><a href="#" class="text-muted">'.$v.'</a></li>';
			}
		}
		$str = $item."</ul></div>";
		return $str;
	}
	
	public function get_ms_merk()
	{
		$query = $this->db->from("ms_merk")->select('merk,merk');
		$query->where('aktif','1');
		$qry = $query->get();
		/*if ($qry->num_rows() > 0){
			if($id!==null){
				return $qry->row();
			}else{
				return $qry->result();
			}
		}*/
		return $qry->result();
		#return null;
		
	}
	
	
	public function get_kontrak($idkontrak=null)
	{
		$query = $this->db->from("trx_kontrak")->select('idkontrak,nama,nomor');
		if($idkontrak != null)
			$query->where('idkontrak',$idkontrak);
		$qry = $query->get();
		if ($qry->num_rows() > 0){
			if($idkontrak!==null){
				return $qry->row();
			}else{
				return $qry->result();
			}
		}
		return null;
		
	}
	
	public function get_ms_lahan($id=null)
	{
		$query = $this->db->from("ms_status_lahan")->select('idstatuslahan,nama_status_lahan');
		if($id != null)
			$query->where('idstatuslahan',$id);
		$qry = $query->get();
		if ($qry->num_rows() > 0){
			if($id!==null){
				return $qry->row();
			}else{
				return $qry->result();
			}
		}
		return null;
		
	}
	
	public function get_ms_jeniskantor($id=null)
	{
		$query = $this->db->from("ms_jenis_kantor")->select('kode,nama');
		if($id != null)
			$query->where('idstatuslahan',$id);
		$qry = $query->get();
		if ($qry->num_rows() > 0){
			if($id!==null){
				return $qry->row();
			}else{
				return $qry->result();
			}
		}
		return null;
		
	}
	
	public function get_ms_provinsi($id=null)
	{
		$query = $this->db->from("ms_provinsi")->select('idprovinsi,nama_provinsi')->order_by('nama_provinsi ASC');
		if($id != null)
			$query->where('idprovinsi',$id);
		$query->where('aktif','1');
		$qry = $query->get();
		if ($qry->num_rows() > 0){
			if($id!==null){
				return $qry->row();
			}else{
				return $qry->result();
			}
		}
		return null;
		
	}
	
	
	
	
	public function get_kontrakbypphp()
	{
		$qry = $this->db->query("SELECT idkontrak,nama,nomor 
															FROM trx_kontrak WHERE idkontrak IN (
																	SELECT DISTINCT idkontrak 
																	FROM `trx_milestone` 
																	WHERE  `trx_milestone`.`allowby` IS NOT NULL
															) ");
		if ($qry->num_rows() > 0){
				return $qry->result();
		}
		return null;
		
	}

	
	public function get_kontrak_actifity()
	{
		$qry = $this->db->query("
															SELECT idkontrak,nama,nomor FROM trx_kontrak
															WHERE idkontrak IN (
																	SELECT 
																	DISTINCT ls.idkontrak
																	FROM trx_milestone lt
																	INNER JOIN trx_milestone ld ON lt.idreff=ld.idmilestone
																	INNER JOIN trx_milestone ls ON ls.idmilestone=ld.idreff
																	LEFT JOIN trx_foto_ujiactifity rs ON rs.idreff=lt.idmilestone AND rs.jenis='Lokasi'
																	WHERE lt.levelreference=3
																	AND rs.approveby IS NULL  AND rs.idfoto IS NOT NULL AND rs.volume>0 AND UPPER(rs.hasil)='DITERIMA'
															)
		");
		if ($qry->num_rows() > 0){
				return $qry->result();
		}
		return null;
		
	}
	public function get_listactifity($debug=false,$id,$jenis=null)
	{
		$filter = '';
		if($jenis!=null){
			if(strtolower($jenis)=='pphp')
				$filter .= "  AND rs.approveby IS NOT NULL  
											AND lt.allowby IS NULL
											AND EXISTS (
												 SELECT 1
												FROM trx_foto_ujiactifity s2
												WHERE lt.idmilestone = s2.idreff
												HAVING MAX(s2.idfoto) = rs.idfoto
											)";
			if(trim(strtolower($jenis))==='actifity')
				$filter .= " AND rs.approveby IS NULL AND rs.idfoto IS NOT NULL AND UPPER(rs.hasil)='DITERIMA' AND rs.volume>0 ";
		}
		
		$str = "SELECT * FROM (
														SELECT 
															lt.idmilestone
															,ls.idkontrak
															,ls.iduser
															,CONCAT(ls.nomor,' ',ls.scopeofwork) dvr
															,CONCAT(ld.nomor,' ',ld.scopeofwork) pck
															,CONCAT(lt.nomor,' ',lt.scopeofwork) act
															,lt.bobot 
															,lt.allowby
															,lt.platform
															,rs.idfoto, rs.tgl_pengujian, rs.catatan, rs.iduser_pengawas, rs.iduser_vendor
															,rs.approveby
															,rs.pathname
															,rs.pathpengawas
															,rs.hasil
															,rs.volume
														FROM trx_milestone lt
														INNER JOIN trx_milestone ld ON lt.idreff=ld.idmilestone
														INNER JOIN trx_milestone ls ON ls.idmilestone=ld.idreff
														LEFT JOIN trx_foto_ujiactifity rs ON rs.idreff=lt.idmilestone and rs.jenis='Lokasi'
														WHERE lt.levelreference=3
														AND lt.idkontrak='$id'
														$filter
													) rpt 
													WHERE 1=1		";
		if($debug)
			return $str;
		else{
			$qry = $this->db->query($str);
			if ($qry->num_rows() > 0){
				return $qry->result();
			}
			return null;
		}
		
	}

	public function get_actifity_pphp($debug=false,$id)
	{
		$str = "SELECT * FROM (
														SELECT 
															lt.idmilestone
															,ls.idkontrak
															,ls.iduser
															,CONCAT(ls.nomor,' ',ls.scopeofwork) dvr
															,CONCAT(ld.nomor,' ',ld.scopeofwork) pck
															,CONCAT(lt.nomor,' ',lt.scopeofwork) act
															,lt.bobot 
															,lt.allowby
															,lt.platform
															,rs.idfoto, rs.tgl_pengujian, rs.catatan, rs.iduser_pengawas, rs.iduser_vendor
															,rs.approveby
															,rs.pathname
															,rs.pathpengawas
															,rs.hasil
															,rs.volume
														FROM trx_milestone lt
														INNER JOIN trx_milestone ld ON lt.idreff=ld.idmilestone
														INNER JOIN trx_milestone ls ON ls.idmilestone=ld.idreff
														LEFT JOIN trx_foto_ujiactifity rs ON rs.idreff=lt.idmilestone and rs.jenis='Lokasi'
														WHERE lt.levelreference=3
														AND lt.idkontrak='$id'
														AND EXISTS (
															 SELECT 1
															FROM trx_foto_ujiactifity s2
															WHERE lt.idmilestone = s2.idreff
															HAVING MAX(s2.idfoto) = rs.idfoto
														)
														AND lt.allowby IS NOT NULL
													) rpt 
													WHERE 1=1		";
		if($debug)
			return $str;
		else{
			$qry = $this->db->query($str);
			if ($qry->num_rows() > 0){
				return $qry->result();
			}
			return null;
		}
		
	}
	
	
	public function get_penugasan($idlokasi,$idkegsurvei)
	{
		// ,(SELECT MAX(tanggal_survei) FROM trx_hasilsurvei rs WHERE rs.idlokasi=pn.lokasi_id) tgl_apps
		$query = $this->db->query("SELECT idlokasi,nama_lokasi, loc.idprovinsi,loc.idkabupaten,loc.idkec,loc.iddesa,desa
					,longitude, latitude, alamat, telp
					,pn.users_id
					,pn.petugas_lain
					,date_format(pn.tanggal_surat,'%d-%m-%Y') tanggal_surat
					,concat(date_format(pn.tanggal_awal,'%d-%m-%Y'), ' s/d ',date_format(pn.tanggal_akhir,'%d-%m-%Y') ) masa_tugas
					,nama_provinsi, nama_kabupaten, nama_kec, nama_desa, kg.idkegsurvei 
					,IFNULL(pn.no_surat,'-') no_surat,us.company,kg.nama
					
					,(SELECT CONCAT(DATE_FORMAT(MIN(tanggal_survei),'%d-%m-%Y'),' s/d ',DATE_FORMAT(MAX(tanggal_survei),'%d-%m-%Y')) FROM trx_hasilsurvei rs WHERE rs.idlokasi=pn.lokasi_id) tgl_apps
					FROM trx_kegsurvei kg
					INNER JOIN trx_survei loc ON kg.idkegsurvei=loc.idkegsurvei
					INNER JOIN ms_provinsi dt1 ON dt1.idprovinsi=loc.idprovinsi
					INNER JOIN ms_kabupaten dt2 ON dt2.idkabupaten=loc.idkabupaten
					INNER JOIN ms_kecamatan dt3 ON dt3.idkec=loc.idkec
					INNER JOIN ms_desa dt4 ON dt4.iddesa=loc.iddesa
					LEFT JOIN trx_penugasan_survei pn ON pn.idkegsurvei=kg.idkegsurvei AND pn.lokasi_id=loc.idlokasi
					LEFT JOIN users us ON us.id=pn.users_id
					WHERE kg.idkegsurvei='".$idkegsurvei."' AND pn.lokasi_id='".$idlokasi."'
					AND EXISTS (
						SELECT 1 FROM trx_hasilsurvei rs WHERE rs.idlokasi=loc.idlokasi 
					)
					");
		if ($query->num_rows() > 0){
				return $query->row();
			}
		return null;
		
	}

	public function get_data($tabel, $order)
	{
		#$query = $this->db->get_where($this->tbl_opd, array('AKTIF_OPD' => '1'));
		$query = $this->db->query("	SELECT 		*
									FROM 		$tabel
									WHERE 		AKTIF	= '1'												
									ORDER BY 	$order");
		return $query;
	}
	
	public function save_aduan($data){
		$this->db->insert('fbb_aduan',$data);
		$insert_id = $this->db->insert_id();

		if ($insert_id){
			return $insert_id;
		}
		return false;
		
	}

	public function get_pegawai($kpd){
		$query = $this->db->query("SELECT nip,nama_lengkap,pangkat_gol,jabatan FROM ms_pegawai WHERE idpeg IN ($kpd)");
				
		if ($query->num_rows() > 0){
			return $query->result();
		}
		return null;
	}

	
}