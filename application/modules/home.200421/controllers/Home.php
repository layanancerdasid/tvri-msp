<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	var $db_conf; 
	var $apikeymaps; 
	var $kunci; 
	
	function __construct()
	{
		parent::__construct();
		$this->apikeymaps = $this->config->item('apikey_gmap');
		$this->kunci = substr($this->apikeymaps,3,7);
	}

	
	public function index()
	{
		$this->load->model('Global_model','gb');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->gb->create_breadcrumbs(["Dashboard"]);
		$data['tokenapikey'] = $this->apikeymaps;
		// lahan
		$data['optionmerk'] = '';
		$op1 = $this->gb->get_ms_merk(null);
		if($op1) 
			foreach($op1 as $v) $data['optionmerk'] .= "<option value='".base64_encode($this->kunci.'#'.$v->merk)."'>".$v->merk."</option>"; 
		// 
		$data['optionwilayah'] = '';
		$op2 = $this->gb->get_ms_provinsi(null);
		if($op2)
			foreach($op2 as $v) $data['optionwilayah'] .= "<option value='".base64_encode($this->kunci.'#'.$v->idprovinsi)."'>".$v->nama_provinsi."</option>";
		$this->load->view('layout/headerhome',$head);
		$this->load->view('layout/sidebarhome');
		$this->load->view('v_dashboardhome',$data);
		$this->load->view('layout/footer');
	}
	
	public function load_lokasi(){
		$this->load->model('General_model','gm');
		$idstatuslahan = base64_decode($this->input->post('merk',true));
		$provinsi = base64_decode($this->input->post('provinsi',true));
		$istransmisi = $this->input->post('transmisi');
		$filter="";
		if($idstatuslahan){
			$idstatuslahan = str_replace($this->kunci."#","",$idstatuslahan);
			$filter .= " AND tm.merk = '$idstatuslahan'";
		} 
		if($istransmisi){
			// $istransmisi = str_replace($this->kunci."#","",$istransmisi);
			if($istransmisi==='Analog')
				$filter .= " AND tm.jenis_transmisi='Analog' ";
			else if($istransmisi==='Digital')
				$filter .= " AND tm.jenis_transmisi='Digital' ";
			else if($istransmisi==='Dualcast')
				$filter .= " AND tm.jenis_transmisi='Dualcast' ";
			else if($istransmisi==='VHF')
				$filter .= " AND tm.jenis_transmisi='VHF' ";
			else if($istransmisi==='DiDual')
				$filter .= " AND (tm.jenis_transmisi='Digital' || tm.jenis_transmisi='Dualcast')";
			else if($istransmisi==='AnVhf')
				$filter .= " AND (tm.jenis_transmisi='VHF' || tm.jenis_transmisi='Analog')";
			else if($istransmisi==='Unknown/STL')
				$filter .= " AND tm.jenis_transmisi = 'Unknown/STL' ";
			else
				$filter .= " ";
		} 
		if($provinsi){
			$provinsi = str_replace($this->kunci."#","",$provinsi);
			$filter .= " AND ms.idprovinsi = '$provinsi'";
		} 
		
		
		//Aslinya
		/*
		$str = "SELECT idlokasi, nama_lokasi, latitude, longitude,  alamat
				, ms.status_lahan, lh.nama_status_lahan
				, ms.jenis, jk.nama
				, CASE WHEN ms.is_analog=1 AND ms.is_digital=1 THEN 'Analog, Digital'
					   WHEN ms.is_analog=1 AND ms.is_digital=0 THEN 'Analog'
					   WHEN ms.is_analog=0 AND ms.is_digital=1 THEN 'Digital'
					   ELSE ''
				  END tipe_transmisi	
				,is_analog
				,is_digital
				FROM ms_lokasi_tvri ms
				LEFT JOIN ms_status_lahan lh ON lh.idstatuslahan=status_lahan
				LEFT JOIN ms_jenis_kantor jk ON jk.kode=ms.jenis
				WHERE longitude IS NOT NULL 
				AND nama_lokasi LIKE 'Site Trans%'
				$filter
				";*/
				
		//ubah
		$str = "SELECT ms.idlokasi, nama_lokasi, latitude, longitude,  alamat
				, ms.status_lahan, lh.nama_status_lahan, tm.merk
				, ms.jenis, jk.nama, tm.channel_1, tm.channel_2, tm.channel_3, tm.aktif1 as aktif1, tm.aktif2, tm.aktif3, jenis_transmisi, tm.coverage_populasi, tr.tipe, tr.koordinat, tr.tinggi, tr.kondisi, tr.tahun_dibangun, pic, telp_pic
				, CASE WHEN ms.is_analog=1 AND ms.is_digital=1 THEN 'Analog, Digital'
					   WHEN ms.is_analog=1 AND ms.is_digital=0 THEN 'Analog'
					   WHEN ms.is_analog=0 AND ms.is_digital=1 THEN 'Digital'
					   ELSE ''
				  END tipe_transmisi	
				,is_analog ms_kanal
				,is_digital, wilayah_layanan
				FROM ms_lokasi_tvri ms
				LEFT JOIN ms_status_lahan lh ON lh.idstatuslahan=status_lahan
				LEFT JOIN ms_jenis_kantor jk ON jk.kode=ms.jenis
				left JOIN trx_pemancar tm ON tm.idlokasi=ms.idlokasi
				LEFT JOIN trx_tower tr ON tr.idlokasi=ms.idlokasi
				WHERE longitude IS NOT NULL 
				$filter  GROUP BY idlokasi, jenis_transmisi, channel_1 order by nama_lokasi ";
		#echo $str;
		$qry = $this->db->query($str);
		$jumlah = $qry->num_rows();
		$rsl = $qry->result();
		$arrloc = array();
		$sumAnalog = 0;
		$sumDigital = 0;
		$sumDualcast = 0;
		$sumVhf = 0;
		$sumUnknown = 0;
		$total = 0;
		$totlLokasi=0;
		$lokasi="";
		$titleUnknown="";
		$titleAnalog="";
		$titleDigital="";
		$titleDualcast="";
		$titleVhf="";
		if($rsl)
		
			foreach($rsl as $idx => $v){
				$sql_wilayah = "SELECT GROUP_CONCAT(wilayah_layanan SEPARATOR ', ') as labellayanan FROM ms_area_layanan WHERE FIND_IN_SET(id, '$v->wilayah_layanan') <> 0 ";
				$labellayanan =  $this->gm->get_sql($sql_wilayah, 'labellayanan'); 
				$channel="";
				if($lokasi != $v->nama_lokasi)$totlLokasi +=  1;
					$lokasi = $v->nama_lokasi;
				if($v->nama_lokasi != ""){
					if($v->jenis_transmisi== "Analog"){
						$sumAnalog +=  1;
						$titleAnalog .= $v->nama_lokasi."<br>";
					}
					if($v->jenis_transmisi== "VHF"){
						$sumVhf +=  1;
						$titleVhf .= $v->nama_lokasi."<br>";
					}
					if($v->jenis_transmisi== "Digital"){
						$sumDigital +=  1;
						$titleDigital .= $v->nama_lokasi."<br>";
					}
					if($v->jenis_transmisi== "Dualcast"){
						$sumDualcast += 1;
						$titleDualcast.= $v->nama_lokasi."<br>";
					}
					if($v->jenis_transmisi== "Unknown/STL"){
						$sumUnknown += 1;
						$titleUnknown .= $v->nama_lokasi."<br>";
					}
					if($v->aktif1 == "1" && $v->channel_1 > 0) {
						//$frek1 = $this->gm->get_data('ms_kanal', 'channel', $v->channel_1, 'frequency');
						//$channel .= " Ch. ".$v->channel_1." / Freq. ".$frek1;
						$sql = "SELECT GROUP_CONCAT(CONCAT(' Ch. ',channel, ' / Freq ', frequency) SEPARATOR ', ') as channel FROM ms_kanal WHERE FIND_IN_SET(channel, '$v->channel_1') <> 0 ";
						$channel .=  $this->gm->get_sql($sql, 'channel'); 
					}
					if($v->aktif2 == "1" && $v->channel_2 > 0){
						//$frek2 = $this->gm->get_data('ms_kanal', 'channel', $v->channel_2, 'frequency');
						//$channel .= " Ch. ".$v->channel_2." / Freq. ".$frek2;
						$sql = "SELECT GROUP_CONCAT(CONCAT(' Ch. ',channel, ' / Freq ', frequency) SEPARATOR ', ') as channel FROM ms_kanal WHERE FIND_IN_SET(channel, '$v->channel_2') <> 0 ";
						$channel .=  $this->gm->get_sql($sql, 'channel'); 
					}
					if($v->aktif3 == "1" && $v->channel_3 > 0){
						//$frek3 = $this->gm->get_data('ms_kanal', 'channel', $v->channel_3, 'frequency');
						//$channel .= " Ch. ".$v->channel_3." / Freq. ".$frek3;
						$sql = "SELECT GROUP_CONCAT(CONCAT(' Ch. ',channel, ' / Freq ', frequency) SEPARATOR ', ') as channel FROM ms_kanal WHERE FIND_IN_SET(channel, '$v->channel_3') <> 0 ";
						$channel .=  $this->gm->get_sql($sql, 'channel'); 
					}
					$sql = "SELECT idlokasi, min(last_update) last_update
							  FROM
							   (
								 SELECT idlokasi, CASE WHEN last_update > CREATED  THEN DATE_FORMAT(last_update, '%d-%m-%Y %T') ELSE DATE_FORMAT(CREATED, '%d-%m-%Y %T') END AS last_update
								   FROM ms_lokasi_tvri WHERE idlokasi='$v->idlokasi'
								  GROUP BY idlokasi
							   UNION ALL
								 SELECT  idlokasi, CASE WHEN last_update > CREATED  THEN DATE_FORMAT(last_update, '%d-%m-%Y %T') ELSE DATE_FORMAT(CREATED, '%d-%m-%Y %T') END AS last_update  
								   FROM trx_pemancar WHERE idlokasi='$v->idlokasi'
								  GROUP BY idlokasi
								UNION ALL
								SELECT  idlokasi, (CASE WHEN detail_pemancar.last_update > detail_pemancar.CREATED  THEN DATE_FORMAT(detail_pemancar.last_update, '%d-%m-%Y %T') ELSE DATE_FORMAT(detail_pemancar.CREATED, '%d-%m-%Y %T') END) AS last_update 
								   FROM trx_pemancar INNER JOIN detail_pemancar ON trx_pemancar.id_pemancar=detail_pemancar.id_pemancar WHERE idlokasi='$v->idlokasi'
								  GROUP BY idlokasi
								UNION ALL
								 SELECT  idlokasi, CASE WHEN last_update > CREATED  THEN DATE_FORMAT(last_update, '%d-%m-%Y %T') ELSE DATE_FORMAT(CREATED, '%d-%m-%Y %T') END AS last_update 
								   FROM trx_antena WHERE idlokasi='$v->idlokasi'
								  GROUP BY idlokasi
								UNION ALL
								 SELECT  idlokasi, CASE WHEN last_update > CREATED  THEN DATE_FORMAT(last_update, '%d-%m-%Y %T') ELSE DATE_FORMAT(CREATED, '%d-%m-%Y %T') END AS last_update  
								   FROM trx_catu_daya`
								  GROUP BY idlokasi
								UNION ALL
								 SELECT  idlokasi, CASE WHEN last_update > CREATED  THEN DATE_FORMAT(last_update, '%d-%m-%Y %T') ELSE DATE_FORMAT(CREATED, '%d-%m-%Y %T') END AS last_update  
								   FROM trx_parabola` WHERE idlokasi='$v->idlokasi'
								  GROUP BY idlokasi
								UNION ALL
								 SELECT  idlokasi, CASE WHEN last_update > CREATED  THEN DATE_FORMAT(last_update, '%d-%m-%Y %T') ELSE DATE_FORMAT(CREATED, '%d-%m-%Y %T') END AS last_update 
								   FROM trx_ups WHERE idlokasi='$v->idlokasi'
								  GROUP BY idlokasi
								UNION ALL
								 SELECT  idlokasi, CASE WHEN last_update > CREATED  THEN DATE_FORMAT(last_update, '%d-%m-%Y %T') ELSE DATE_FORMAT(CREATED, '%d-%m-%Y %T') END AS last_update 
								   FROM trx_tower WHERE idlokasi='$v->idlokasi'
								  GROUP BY idlokasi
							   ) a
							WHERE idlokasi='$v->idlokasi'
							GROUP BY idlokasi";
					$last_update =  $this->gm->get_sql($sql, 'last_update'); 
					$tower = "Tipe: ".$v->tipe." Koord.: ".$v->koordinat.", Tinggi: ".$v->tinggi." m, Kondisi: ".$v->kondisi." Thn: ".$v->tahun_dibangun;
					$arrloc[] = array(
						"idlokasi"=>$v->idlokasi
						,"nama_lokasi"=>$v->nama_lokasi
						, "lat"=>$v->latitude
						, "long"=>$v->longitude
						, "alamat"=>$v->alamat
						, "jenis_kantor"=>$v->nama
						, "status_lahan"=>$v->nama_status_lahan
						, "merk"=>$v->merk
						, "transmisi"=>$v->tipe_transmisi
						, "jenis_transmisi"=>$v->jenis_transmisi
						, "channel"=>$channel
						, "populasi"=>$v->coverage_populasi
						, "tower"=>$tower
						, "pic"=>$v->pic
						, "last_update"=>$last_update
						, "telp_pic"=>$v->telp_pic
						, "wilayah_layanan"=>$labellayanan				
					);
				}
				if($lokasi != $v->nama_lokasi)$totlLokasi +=  10;
					$lokasi = $v->nama_lokasi;
			}
			$total += count($arrloc);
		$datas = array("total"=>$total, "sumAnalog"=>$sumAnalog, "sumDigital"=>$sumDigital, "sumDualcast"=>$sumDualcast, "sumVhf"=>$sumVhf, "sumUnknown"=>$sumUnknown, "totlLokasi"=>$totlLokasi, "titleAnalog"=>$titleAnalog, "titleDigital"=>$titleDigital, "titleDualcast"=>$titleDualcast, "titleVhf"=>$titleVhf, "titleUnknown"=>$titleUnknown, "datas"=>$arrloc);
		echo json_encode($datas);
	}
	
	function test()
	{
		echo base64_encode('x212')."<br>";
		echo base64_decode('')."<br>";
		
	}

		
}
