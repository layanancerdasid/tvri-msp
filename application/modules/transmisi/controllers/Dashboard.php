<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	var $db_conf; 
	var $apikeymaps; 
	
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
		$this->apikeymaps = $this->config->item('apikey_gmap');
	}

	
	public function index()
	{
		$this->load->model('Global_model','gb');
		$head['collapse'] = false;
		$head['title'] = "Home";
		$data['breadcrumbs'] = $this->gb->create_breadcrumbs(["Dashboard"]);
		$data['tokenapikey'] = $this->apikeymaps;
		// lahan
		$data['optionlahan'] = '';
		$op1 = $this->gb->get_ms_lahan(null);
		if($op1) 
			foreach($op1 as $v) $data['optionlahan'] .= "<option value='".encodeAll($v->idstatuslahan)."'>".$v->nama_status_lahan."</option>"; 
		// 
		$data['optionwilayah'] = '';
		$op2 = $this->gb->get_ms_provinsi(null);
		if($op2)
			foreach($op2 as $v) $data['optionwilayah'] .= "<option value='".encodeAll($v->idprovinsi)."'>".$v->nama_provinsi."</option>";
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_dashboard',$data);
		$this->load->view('layout/footer');
	}
	
	public function load_lokasi(){
		$idstatuslahan = decodeAll($this->input->post('lahan',true));
		$provinsi = decodeAll($this->input->post('provinsi',true));
		$istransmisi = $this->input->post('transmisi');
		$filter="";
		if($idstatuslahan){
			$filter .= " AND ms.status_lahan = '$idstatuslahan'";
		} 
		if($istransmisi){
			// $istransmisi = str_replace($this->kunci."#","",$istransmisi);
			if($istransmisi==='Analog')
				$filter .= " AND ms.is_analog=1";
			else if($istransmisi==='Digital')
				$filter .= " AND ms.is_digital=1";
			else
				$filter .= " ";
		} 
		if($provinsi){
			$filter .= " AND ms.idprovinsi = '$provinsi'";
		} 
		
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
				";
		
		$qry = $this->db->query($str);
		$rsl = $qry->result();
		$arrloc = array();
		$sumAnalog = 0;
		$sumDigital = 0;
		$total = 0;
		if($rsl)
			foreach($rsl as $idx => $v){
				$arrloc[] = array(
					"idlokasi"=>$v->idlokasi
					,"nama_lokasi"=>$v->nama_lokasi
					, "lat"=>$v->latitude
					, "long"=>$v->longitude
					, "alamat"=>$v->alamat
					, "jenis_kantor"=>$v->nama
					, "status_lahan"=>$v->nama_status_lahan
					, "transmisi"=>$v->tipe_transmisi
				);
				$sumAnalog += $v->is_analog;
				$sumDigital += $v->is_digital;
				
			}
			$total += count($arrloc);
		$datas = array("total"=>$total, "sumAnalog"=>$sumAnalog, "sumDigital"=>$sumDigital, "datas"=>$arrloc);
		echo json_encode($datas);
	}		
}
