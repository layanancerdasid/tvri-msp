<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metering extends CI_Controller {
	var $db_conf; 
	var $apikeymaps; 
	
	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
		$this->apikeymaps = $this->config->item('apikey_gmap');
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			 'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->load->model('Global_model');
		// $this->load->library('gridlibrary');
	}
	
	public function mtr()
	{
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Metering Digital";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idrpt'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = false;
		$grid["autoresize"] = true;
		$grid["responsive"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["add_options"] = array("width"=>"550");
		$grid["edit_options"] = array("width"=>"550");
		$grid["view_options"] = array("width"=>"550");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"metering");
		
		
		$g->set_actions(array(
				"add"=>false,
				"edit"=>false,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false,
			)
		);
		
		$g->select_command = "SELECT * FROM(
										  SELECT idrpt,trx.idlokasi,trx.waktu,idpetugas1,idpetugas2,idgroup1,idgroup2,trx.dinasshift
												,trx.forward_power,trx.reflected_power,trx.exciter_used,trx.operation,trx.pa_rack1,trx.pa_rack2,trx.note_panel_dg
												,trx.inlet_temperature_dg,trx.outlet_temperature_dg,trx.aux_power_supply_dg,trx.note_rack1,trx.inlet_temperature_rack1
												,trx.outlet_temperature_rack1,trx.aux_power_supply_rack1,trx.created
										  FROM trx_metering_digital trx
										  LEFT JOIN ms_pegawai mp1 ON mp1.idpeg=trx.idpetugas1
										  LEFT JOIN ms_pegawai mp2 ON mp2.idpeg=trx.idpetugas1
										  LEFT JOIN ms_grpetugas g1 ON g1.idgrup_petugas=trx.idgroup1
										  LEFT JOIN ms_grpetugas g2 ON g2.idgrup_petugas=trx.idgroup2
										) gabungan";
		$g->table = "trx_metering_digital";
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idrpt";
		$col["editable"] = true;
		$col["hidden"] = true;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Lokasi";
		$col["name"] = "idlokasi";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["formatter"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT idlokasi AS k, nama_lokasi AS v  FROM ms_lokasi_tvri WHERE idlokasi<>0 ORDER BY idlokasi");
		$col["searchoptions"] = array("value" =>":NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" => ":NA;".$str, 
										"separator" => ":", 
										"delimiter" => ";",
										"onChange" => array( "sql"=>"SELECT DISTINCT idlokasi AS k, nama_lokasi AS v  
																		FROM ms_lokasi_tvri WHERE idlokasi <>0 
																		AND idpeg={idpeg}
																		ORDER BY nama_lokasi",
																		"update_field" => "idlokasi" )
										);
		$cols[] = $col;								 
		
		$col = array();
		$col["title"] = "Waktu";
		$col["name"] = "waktu"; 
		$col["align"] = "center";
		$col["width"] = "200";
		$col["editable"] = true; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s',"opts" => array());
		$col["show"] = array("list"=>true,"edit"=>false,"add"=>false,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Petugas 1";
		$col["name"] = "idpetugas1";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["formatter"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT idpeg AS k, nama_lengkap AS v  FROM ms_pegawai WHERE idpeg<>0 ORDER BY idpeg");
		$col["searchoptions"] = array("value" =>":NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" => ":NA;".$str, 
										"separator" => ":", 
										"delimiter" => ";",
										"onChange" => array( "sql"=>"SELECT DISTINCT idpeg AS k, nama_lengkap AS v  
																		FROM ms_pegawai WHERE idpeg <>0 
																		AND idpeg={idpeg}
																		ORDER BY nama_lengkap",
																		"update_field" => "idpeg" )
										); 
		$cols[] = $col;								
		
		$col = array();
		$col["title"] = "Petugas 2";
		$col["name"] = "idpetugas2";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["formatter"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT idpeg AS k, nama_lengkap AS v  FROM ms_pegawai WHERE idpeg<>0 ORDER BY idpeg");
		$col["searchoptions"] = array("value" =>":NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" => ":NA;".$str, 
										"separator" => ":", 
										"delimiter" => ";",
										"onChange" => array( "sql"=>"SELECT DISTINCT idpeg AS k, nama_lengkap AS v  
																		FROM ms_pegawai WHERE idpeg <>0 
																		AND idpeg={idpeg}
																		ORDER BY nama_lengkap",
																		"update_field" => "idpeg" )
										); 
		$cols[] = $col;			
		
		$col = array();
		$col["title"] = "Group 1";
		$col["name"] = "idgroup1";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["formatter"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT idgrup_petugas AS k, nama_grup AS v  FROM ms_grpetugas WHERE idgrup_petugas<>0 ORDER BY idgrup_petugas");
		$col["searchoptions"] = array("value" =>":NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" => ":NA;".$str, 
										"separator" => ":", 
										"delimiter" => ";",
										"onChange" => array( "sql"=>"SELECT DISTINCT idgrup_petugas AS k, nama_grup AS v  
																		FROM ms_grpetugas WHERE idgrup_petugas <>0 
																		AND idgrup_petugas={idgrup_petugas}
																		ORDER BY nama_grup",
																		"update_field" => "idgrup_petugas" )
										); 
		$cols[] = $col;								
		
		$col = array();
		$col["title"] = "Group 2";
		$col["name"] = "idgroup2";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["formatter"] = "select"; 
		$str = $g->get_dropdown_values("SELECT DISTINCT idgrup_petugas AS k, nama_grup AS v  FROM ms_grpetugas WHERE idgrup_petugas<>0 ORDER BY idgrup_petugas");
		$col["searchoptions"] = array("value" =>":NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["editoptions"] = array("value" => ":NA;".$str, 
										"separator" => ":", 
										"delimiter" => ";",
										"onChange" => array( "sql"=>"SELECT DISTINCT idgrup_petugas AS k, nama_grup AS v  
																		FROM ms_grpetugas WHERE idgrup_petugas <>0 
																		AND idgrup_petugas={idgrup_petugas}
																		ORDER BY nama_grup",
																		"update_field" => "idgrup_petugas" )
										); 
		$cols[] = $col;								
		
 		$col = array();
		$col["title"] = "Dinas Shift";
		$col["name"] = "dinasshift";
		$col["width"] = "80";
		$col["search"] = true;
		$cols[] = $col;	 							
		
		$col = array();
		$col["title"] = "Forward Power";
		$col["name"] = "forward_power";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["align"] = "center";  
		$cols[] = $col; 

		$col = array();
		$col["title"] = "Reflected Power";
		$col["name"] = "reflected_power";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["align"] = "center";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Exciter Used";
		$col["name"] = "exciter_used";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["align"] = "center";   
		$cols[] = $col;		
		
		$col = array();
		$col["title"] = "Opeeration";
		$col["name"] = "operation";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["align"] = "left";
		$col["editrules"] = array("required"=>true);  
		$cols[] = $col;		
		
		$col = array();
		$col["title"] = "PA Rack 1";
		$col["name"] = "pa_rack1";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["align"] = "center";
		//$col["editrules"] = array("required"=>true);    
		$cols[] = $col;		
		
		$col = array();
		$col["title"] = "PA Rack 2";
		$col["name"] = "pa_rack2";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["align"] = "center";
		//$col["editrules"] = array("required"=>true);  
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Note Panel";
		$col["name"] = "note_panel_dg";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["align"] = "left";
		//$col["editrules"] = array("required"=>true);  
		$cols[] = $col;	
		
		$col = array();
		$col["title"] = "Inlet Temperatur Digital";
		$col["name"] = "inlet_temperature_dg";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$col["align"] = "center";
		//$col["editrules"] = array("required"=>true);  
		$cols[] = $col;	
		
		$col = array();
		$col["title"] = "Outlet Temperatur Digital";
		$col["name"] = "outlet_temperature_dg";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$col["align"] = "center";
		//$col["editrules"] = array("required"=>true);  
		$cols[] = $col;		
		
		$col = array();
		$col["title"] = "Aux Power Supply Digital";
		$col["name"] = "aux_power_supply_dg";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$col["align"] = "center";
		//$col["editrules"] = array("required"=>true);  
		$cols[] = $col;		
		
		$col = array();
		$col["title"] = "Note Rack 1";
		$col["name"] = "note_rack1";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "150";
		$col["align"] = "left";
		//$col["editrules"] = array("required"=>true);  
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Inlet Temperatur Rack 1";
		$col["name"] = "inlet_temperature_rack1";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$col["align"] = "center";
		//$col["editrules"] = array("required"=>true);  
		$cols[] = $col;	
		
		$col = array();
		$col["title"] = "Outlet Temperatur Rack 1";
		$col["name"] = "outlet_temperature_rack1";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$col["align"] = "center";  
		$cols[] = $col;	
		
		$col = array();
		$col["title"] = "Aux Power Supply Rack 1";
		$col["name"] = "aux_power_supply_rack1";
		$col["search"] = true;
		$col["editable"] = true;
		$col["width"] = "250";
		$col["align"] = "center";
		//$col["editrules"] = array("required"=>true);  
		$cols[] = $col;	
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created"; 
		$col["align"] = "center";
		$col["width"] = "200";
		$col["editable"] = true; 
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s',"opts" => array());
		$col["show"] = array("list"=>true,"edit"=>false,"add"=>false,"view"=>true);
		$cols[] = $col;
		
		$g->set_columns($cols);
		$g->set_options($grid);

		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["metering","metering"]);
		$data['gridout'] = $g->render("list1");	
		
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_metering',$data);
		$this->load->view('layout/footer');
}

	public function qc_metering()
	{
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "QC Metering";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idqc'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = true;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["autoresize"] = true;
		$grid["add_options"] = array("width"=>"550");
		$grid["edit_options"] = array("width"=>"550");
		$grid["view_options"] = array("width"=>"550");
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"qc metering");
		
		$grid["grouping"] = true;
		// $grid["groupingView"] = array();
		$grid["groupingView"]["groupField"] = array("kategori");
		$grid["groupingView"]["groupColumnShow"] = array(false);
		$grid["groupingView"]["groupOrder"] = array("desc");
		$grid["groupingView"]["groupText"] = array("<b>{0} ({1} Question)</b>");
		$grid["groupingView"]["groupDataSorted"] = array(true);
		// $grid["groupingView"]["groupSummary"] = array(true);
		$grid["groupingView"]["groupCollapse"] = false;
		// $grid["groupingView"]["groupSummaryOnHide"] = true;
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT idqc,kode_urut, item, keterangan, tipe_form, pilihan_jawaban, kategori, web, app FROM qc_metering";
		$g->table = "qc_metering";
		
		$col = array();
		$col["title"] = "No";
		$col["name"] = "idqc";
		$col["editoptions"] = array("maxlength" => "20", "size" =>"10");
		$col["search"] = true;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["isnull"] = false;	
		$col["autoid"] = true;	
		$col["align"] = "left";
		$col["width"] = "100";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kode Urut";
		$col["name"] = "kode_urut";
		$col["editoptions"] = array("maxlength" => "20", "size" =>"10");
		$col["search"] = true;
		$col["editable"] = true;
		$col["editrules"] = array("required"=>true); 
		$col["hidden"] = false;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "100";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Item";
		$col["name"] = "item";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "250";
		$col["edittype"] = "textarea";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "100", "cols"=>"50", "rows"=>"2",);
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Placeholder";
		$col["name"] = "keterangan";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "250";
		$col["edittype"] = "textarea";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array("maxlength" => "225", "cols"=>"50", "rows"=>"5",);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tipe Form";
		$col["name"] = "tipe_form";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>true);
		$str="checklistbox:checklistbox;combobox:combobox;foto:foto;number:number;number negative:number negative;radio button:radio button;text:text";
		$col["editoptions"] = array("value" => $str);
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Pilihan Jawaban";
		$col["name"] = "pilihan_jawaban";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "180";
		$col["edittype"] = "textarea";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array("maxlength" => "100", "cols"=>"50", "rows"=>"2",);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kategori";
		$col["name"] = "kategori";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>true);
		$str="Analog:Analog;Digital:Digital;Data Laporan:Data Laporan";
		$col["editoptions"] = array("value" => $str);
		$col["export"] = false;
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "iduser_created";
		$col["search"] = false;
		$col["export"] = false;
		$col["editable"] = true;
		$col["hidden"] = true;
		$col["editoptions"] = array("defaultValue" => $this->session->userdata('user_id'));
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Web";
		$col["name"] = "web";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'1');
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "App";
		$col["name"] = "app";
		$col["width"] = "50";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "center";
		$col["edittype"] = "checkbox"; 
		$col["stype"] = "checkbox"; 
		$col["formatter"] = "checkbox";
		$col["editoptions"] = array("maxlength"=>1,"size"=>75,"value"=>"1:0","defaultValue"=>'0');
		$cols[] = $col;
		
		$g->set_columns($cols);
		$g->set_options($grid);
		
		

		$head['title'] = $caps;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["metering","qc metering"]);
		$data['fluid'] = true;
		$data['gridout'] = $g->render("list1");
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_metering',$data);
		$this->load->view('layout/footer');
		
		
	}
	public function report()
	{
		
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$daterange = $this->input->get('daterange',true);
		$idlokasi = $this->input->get('idlokasi',true);
		if($idlokasi) $idlokasi = decodeAll($idlokasi);
		$nama_lokasi = "";
		
		$str = "<option value=''>Pilih</option>";
		#$rows = $this->db->get('ms_lokasi_tvri')->result();
		$query = $this->db->from("ms_lokasi_tvri")->select('idlokasi,nama_lokasi')->order_by('nama_lokasi');
		$rows = $query->get()->result();
		foreach($rows as $v){
			if($idlokasi){
				if($idlokasi==$v->idlokasi){					
					$str .= "<option selected value='".encodeAll($v->idlokasi)."'>".$v->nama_lokasi."</option>";
					// isi nama lokasi
					$nama_lokasi = $v->nama_lokasi;
				}else{
					$str .= "<option  value='".encodeAll($v->idlokasi)."'>".$v->nama_lokasi."</option>";
				}
			}else{
					$str .= "<option selected value='".encodeAll($v->idlokasi)."'>".$v->nama_lokasi."</option>";
			}
			
		}  
	
		if($daterange){
			//klu sudah pilih filter lokasi
			// koding untuk grid 
		
			$this->load->library('gridlibrary');
			$caps = "Report Metering Lokasi" ;
			
			$tgl = str_replace("/","-", $_GET['daterange'] );
			// echo $test = decode_date($tgl); exit;
			
			$f_date_start= decode_date($tgl); 
		
			
			$grid["caption"] =   $caps.' ' .$nama_lokasi.', Tanggal '.$tgl.' ' ;
			$grid["rowNum"] = 1000; 
			$grid["rowList"] = array(1000,2000,5000,'All');
			$grid["rownumbers"] = true;
			$grid["sortname"] = 'kode_urut'; 
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = true;
			$grid["forceFit"] = false;
			$grid["resizable"] = true;			
			$grid["multiselect"] = false; 
			$grid["rowactions"] = true; 
			$grid["toolbar"] = "both"; 
			$grid["height"] = ""; 
			$grid["autoresize"] = true;
			$grid["add_options"] = array("width"=>"360");
			$grid["edit_options"] = array("width"=>"360");
			$grid["view_options"] = array("width"=>"360");
			
			// export PDF file params
			$grid["export"] = array("filename"=>"Metering".$tgl.str_replace(' ','',$nama_lokasi), "heading"=>"Laporan Harian Metering ".$nama_lokasi.' , Tanggal '.$tgl, "orientation"=>"landscape", "paper"=>"f4");
			// for excel, sheet header
			$grid["export"]["sheetname"] = "Metering".$tgl;
			// export filtered data or all data
			$grid["export"]["range"] = "filtered"; // or "all"
			
			$grid["grouping"] = true;
			// $grid["groupingView"] = array();
			$grid["groupingView"]["groupField"] = array("kategori");
			$grid["groupingView"]["groupColumnShow"] = array(false);
			$grid["groupingView"]["groupOrder"] = array("asc");
			$grid["groupingView"]["groupText"] = array("<b>{0} ({1} Question)</b>");
			$grid["groupingView"]["groupDataSorted"] = array(true);
			// $grid["groupingView"]["groupSummary"] = array(true);
			$grid["groupingView"]["groupCollapse"] = true;
			// $grid["groupingView"]["groupSummaryOnHide"] = true;
			
			$g->set_actions(array(
					"add"=>false,
					"edit"=>false,
					"delete"=>false,
					"view"=>false,
					"rowactions"=>false,
					"export_xlsx"=>false,
					"export_pdf"=>true,
					"export"=>false,
					"autofilter" => true,
					"search" => false
				)
			);
			
			$g->set_options($grid);
			
			$this->load->model('Metmod');
			$g->select_command = $this->Metmod->report(true,$idlokasi,$f_date_start);
			
			
			$col = array();
			$col["title"] = "No";
			$col["name"] = "kode_urut";
			$col["search"] = false;
			$col["editable"] = false;
			$col["align"] = "left";
			$col["hidden"] = true;
			$col["width"] = "30";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "kategori";
			$col["name"] = "kategori";
			$col["search"] = true;
			$col["editable"] = false;
			$col["align"] = "left";
			$col["width"] = "60";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Question";
			$col["name"] = "item";
			$col["search"] = true;
			$col["editable"] = false;
			$col["align"] = "left";
			$col["width"] = "120";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Waktu Lapor";
			$col["name"] = "created";
			$col["search"] = false;
			$col["editable"] = false;
			$col["align"] = "left";
			$col["formatter"] = "datetime";
			$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s'); 
			$col["width"] = "150";
			$cols[] = $col;
			 
			$col = array();
			$col["title"] = "Answer";
			$col["name"] = "jawaban";
			$col["search"] = true;
			$col["editable"] = false;
			$col["align"] = "left";
			$col["width"] = "50";
			$cols[] = $col;

			$g->set_columns($cols);
			
			$data["gridout"] = $g->render("list1");
		}else{
			$data["gridout"] = "";
			
		}
		$head['title'] = $caps;	
		//$head['collapse'] = true;
	    $data['page']="report";
		$data['f_date_start']=$tgl;
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["metering","report"]);
		//$data['fluid'] = true;
		$data['opsilokasi'] = $str;

		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_report',$data);
		$this->load->view('layout/footer');
			
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