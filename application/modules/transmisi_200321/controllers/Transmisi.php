<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transmisi extends CI_Controller {
	var $db_conf; 
	var $idus; 
	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) redirect('auth/login', 'refresh');
		$this->db_conf = array(
			'type' => $this->db->dbdriver,
			'server' => $this->config->item('con_svr'),
			'user' => $this->db->username,
			'password' => $this->db->password,
			'database' => $this->db->database);
		$this->load->model('Global_model');
		$this->idus = $this->session->userdata('user_id');
		// error_reporting(E_ALL);
		// ini_set ("log_errors",1);
		// ini_set("display_errors",1);
		
	}
	
	public function index()
	{
		// echo $this->idus;
		$this->load->model('Global_model');
		$this->load->library('gridlibrary');
		Global $iduser; 
		$iduser = $this->session->userdata('user_id');
					
		//Grid 1
		{
			$g = new jqgrid($this->db_conf);
			$caps = "Lokasi Transmisi";
			
			$grid["caption"] = $caps;
			$grid["rowNum"] = 20; 
			$grid["rowList"] = array(40,40,100,'All');
			$grid["rownumbers"] = true;
			$grid["autowidth"] = true;
			$grid["shrinkToFit"] = true;// agar panjang row bisa sesuai
			$grid["forceFit"] = false;
			$grid["resizable"] = true;
			$grid["sortname"] = 'idlokasi';
			$grid["autoresize"] = true;
			$grid["multiselect"] = false; 
			$grid["toolbar"] = "buttom"; 
			$grid["add_options"] = array("width"=>"500");
			$grid["edit_options"] = array("width"=>"500");
			$grid["view_options"] = array("width"=>"400");
			$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"master-kategoriuji");
			$grid["onSelectRow"] = "function(id){ 
				var idenc = $('#list1').jqGrid('getCell', id, 'idenc');
				var nama_lokasi = $('#list1').jqGrid('getCell', id, 'nama_lokasi');
				$('#keytransmisi').val(idenc); 
				$('#labtransmisi').val(nama_lokasi); 
			}";
			
			// select row after addition
			$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list1').setSelection(r.id); }";
			
			$g->set_actions(array(
					"add"=>false,
					"edit"=>false,
					"delete"=>false,
					"rowactions"=>false,
					"export"=>false,
					"autofilter" => true,
					"search" => "advance"
				)
			);
			
			// $g->select_command ="SELECT * FROM (
				// SELECT idlokasi
				// , idprovinsi
				// , idkabupaten
				// , idkec
				// , iddesa
				// , nama_lokasi
				// , iduser_create, created
				// , CONCAT(us.first_name,' ',IFNULL(us.last_name,''))nama_lengkap	
				// ,CASE WHEN ms.is_analog=1 AND ms.is_digital=1 THEN 'Analog, Digital'
					   // WHEN ms.is_analog=1 AND ms.is_digital=0 THEN 'Analog'
					   // WHEN ms.is_analog=0 AND ms.is_digital=1 THEN 'Digital'
					   // ELSE ''
				  // END tipe_transmisi	
				// ,is_analog
				// ,is_digital	
				// FROM ms_lokasi_tvri ms 
				// INNER JOIN auth_users us ON us.id=ms.iduser_create
			// ) tablegab";
			// $g->table = "ms_lokasi_tvri";
			
			$g->select_command = "SELECT * FROM (SELECT ms.idlokasi,ms_provinsi.nama_provinsi, ms_kabupaten.nama_kabupaten,
								ms_kecamatan.nama_kec, ms_desa.nama_desa,ms.nama_lokasi,ms.iduser_created,ms.created, ms.last_update,
								CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
								FROM ms_lokasi_tvri ms
								left JOIN ms_provinsi ON ms.idprovinsi = ms_provinsi.idprovinsi
								left JOIN ms_kabupaten ON ms.idkabupaten = ms_kabupaten.idkabupaten
								left JOIN ms_kecamatan ON ms.idkec = ms_kecamatan.idkec
								left JOIN ms_desa ON ms.iddesa = ms_desa.iddesa
								left JOIN auth_users us ON us.id=ms.iduser_created )
								tablegab";
			$g->table = "ms_lokasi_tvri";
			
				
			$col = array();
			$col["title"] = "ID Lokasi";
			$col["name"] = "idlokasi";
			$col["editoptions"] = array("onfocus"=>"set_mask_nik(this)");
			$col["search"] = true;
			$col["hidden"] = true;
			$col["align"] = "center";
			$col["width"] = "80";
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "idenc";
			$col["name"] = "idenc";
			$col["editable"] = false;
			$col["width"] = "40";
			$col["align"] = "center";
			$col["hidden"] = true;
			$col["search"] = false;$col["sortable"] = false;$col["export"] = false;
			$col["on_data_display"] = array("encodeidenc",""); 
			function encodeidenc($data) { 
				$id = encodeAll($data["idlokasi"]); 
				if (empty($data["idlokasi"])) 
					return ""; 
				else{
					return $id; 
				} 
			} 
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "";
			$col["name"] = "action1";
			$col["editable"] = false;
			$col["width"] = "40";
			$col["align"] = "center";
			$col["search"] = false;$col["sortable"] = false;$col["export"] = false;
			#$col["on_data_display"] = array("encodetoken",""); 
			$col["on_data_display"] = array("btnxpexcel",""); 
			function btnxpexcel($data) { 
					// Global $g;
					// // $url = $g->options["url"]."&export=1&jqgrid_page=1&export_type=pdf&_search=true&filters=";
					// //$id = urlencode(base64_encode($data["telp"]."#".$data["idlokasi"])); 
					$id = encodeAll($data["idlokasi"]); 
					// if (empty($data[""])) 
						// return ""; 
					// else{
						$str.=' <a href="'.base_url().'transmisi/export/'.$id.'" data-toggle="tooltip" data-placement="top" title="Laporan Excel" target="_blank" class="btn btn-icon btn-light btn-hover-primary btn-sm">
									 <span class="menu-icon menu-icon-xs menu-icon-primary">
										 <i class="far fa-file-excel text-success"></i>Excel
									 </span>
								 </a>';
						return $str; 
					// } 
			} 
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Nama Lokasi";
			$col["name"] = "nama_lokasi";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "200";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "30", "size"=>30);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Provinsi";
			$col["name"] = "nama_provinsi";
			#$col["dbname"] = "ms_provinsi";
			$col["width"] = "150";
			$col["align"] = "left";
			$col["search"] = true;
			$col["editable"] = true;
			$col["edittype"] = "select"; // render as select
			# fetch data from database, with alias k for key, v for value

			# on change, update other dropdown
			$str = $g->get_dropdown_values("select distinct nama_provinsi as k, nama_provinsi as v from ms_provinsi");
			$col["editoptions"] = array(
						"value"=>":;".$str, 
						"onchange" => array(    "sql"=>"select distinct idkabupaten as k, nama_kabupaten as v from ms_kabupaten WHERE nama_provinsi = '{nama_provinsi}'",
												"update_field" => "idkabupaten" )
										);

			$col["formatter"] = "select"; // display label, not value
			//$col["stype"] = "select-multiple"; // enable dropdown search
			$col["searchoptions"] = array("value" => ":;".$str);
			$cols[] = $col;        
			
			$col = array();
			$col["title"] = "Kabupaten";
			$col["name"] = "nama_kabupaten";
			#$col["dbname"] = "ms_kabupaten";
			$col["width"] = "150";
			$col["search"] = true;
			$col["editable"] = true;
			$col["edittype"] = "select"; // render as select
			$str = $g->get_dropdown_values("select nama_kabupaten as k, nama_kabupaten as v from ms_kabupaten");
			$col["editoptions"] = array(
						"value"=>$str, 
						"onchange" => array(    "sql"=>"select distinct idkec as k, nama_kec as v from ms_kecamatan WHERE nama_kabupaten = '{nama_kabupaten}'",
												"update_field" => "idkec" )
										);
										
			$col["formatter"] = "select"; // display label, not value
			$col["searchoptions"] = array("value" => ":;".$str);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Kecamatan";
			$col["name"] = "nama_kec";
			#$col["dbname"] = "ms_kecamatan";
			$col["width"] = "150";
			$col["search"] = true;
			$col["editable"] = true;
			$col["edittype"] = "select"; // render as select
			$str = $g->get_dropdown_values("select nama_kec as k, nama_kec as v from ms_kecamatan");
			$col["editoptions"] = array(
						"value"=>$str, 
						"onchange" => array(    "sql"=>"select distinct iddesa as k, nama_desa as v from ms_desa WHERE nama_kec = '{nama_kec}'",
												"update_field" => "iddesa" )
										);
										
			$col["formatter"] = "select"; // display label, not value
			$col["searchoptions"] = array("value" => ":;".$str);
			$cols[] = $col;
			
			/*$col = array();
			$col["title"] = "Desa";
			$col["name"] = "nama_desa";
			$col["dbname"] = "ms_desa";
			$col["width"] = "150";
			$col["search"] = true;
			$col["editable"] = true;
			$col["edittype"] = "select"; // render as select
			$str = $g->get_dropdown_values("select nama_desa as k, nama_desa as v from ms_desa");
			$col["editoptions"] = array(
										"value"=>$str
										);
					
			// required for manual refresh link                    
			$col["editoptions"]["onload"]["sql"] = "select distinct iddesa as k, nama_desa as v from ms_desa where idkec		= '{idkec}'";
			$col["formatter"] = "select"; // display label, not value
			$col["searchoptions"] = array("value" => ":;".$str);
			$cols[] = $col;*/
			
			
			
			
		/*	$col = array();
			$col["title"] = "User Created";
			$col["name"] = "nama_lengkap";
			$col["width"] = "150";
			$col["search"] = true;
			$col["editable"] = false;
			$col["align"] = "left";
			$cols[] = $col;
			
			
			$col = array();
			$col["title"] = "Created";
			$col["name"] = "created"; 
			$col["width"] = "160";
			$col["editable"] = false; // this column is editable
			$col["editoptions"] = array("size"=>20, "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
			$col["editrules"] = array("required"=>false, "edithidden"=>true); // and is required
			$cols[] = $col;*/

			$g->set_columns($cols);
			$g->set_options($grid);
			
			$e = null;
			$e["on_insert"] = array("setLokasi", null, true);
			$e["on_update"] = array("setUpdateTime", null, true);
			$g->set_events($e);
			
			function setUpdateTime(&$data) 
		{ 
			$data["params"]["last_update"] = date("Y-m-d H:i:s");
		}

				function setLokasi(&$data) 
				{ 
					Global $iduser; 
					$data["params"]["iduser_created"] = $iduser;
				} 
				
		}
		/*end Grid utama*/
		
		/*set grid*/
		$data["gridlokasi"] = $g->render('list1');
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Fitur","Transmisi","Data Warehouse"]);
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_transmisi',$data);
		$this->load->view('layout/footer');
	}	
	
	public function pemancar($idparams)
	{
		
		Global $idlokasi;
		Global $iduser;
		$idparams = decodeAll ($idparams);
		$this->load->library('gridlibrary');
		$g2 = new jqgrid($this->db_conf);
		$idlokasi = $idparams;
		// $idparams = $_REQUEST["rowid"];
		// phpgrid_error($idparams);
		//echo 'test' die;
		
		// inisialisasi
		$grid = array();
		$this->load->model('Transmisi_model','tx');
		$grid["caption"] ="Pemancar, Lokasi ".$this->tx->get_lokasi($idlokasi)->nama_lokasi;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idlokasi'; //tadinya idlokasi
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
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
		$grid["export"] = array("format"=>"xls", "filename"=>"data-pemancar", "sheetname"=>"data-pemancar");
		
		$grid["subGrid"] = FALSE; 
		$grid["subgridurl"] = base_url()."transmisi/detailpemancar";
		$grid["subgridparams"] = "id_pemancar, jenis_transmisi";
				
		// select row after addition
		//$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list2').setSelection(r.id); }";

		// $g2->set_options($grid);
		$g2->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		$g2->select_command = "SELECT * FROM (
			SELECT id_pemancar, last_update , jenis_transmisi, ms.idlokasi, frekuensi, coverage_populasi, coverage_area, channel_1, aktif1, channel_2, aktif2,channel_3, aktif3, tipe, power_nominal, power_real, created, iduser_created, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap, keterangan_kerusakan, kondisi, thn_pengadaan, merk, isr
			FROM trx_pemancar ms 
			left JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi') tablegab";
		$g2->table = "trx_pemancar";

		// inisialisasi kolom
		
		$cols = array();
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "id_pemancar";
		$col["search"] = true;
		$col["editable"] = false;
		$col["hidden"] = true;
		$col["width"] = "20";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Jenis";
		$col["name"] = "jenis_transmisi";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["width"] = "120";
		$col["edittype"] = "select";
		$col["editrules"] = array("maxvalue"=>2);
		$col["editoptions"] = array("value"=>"Analog:Analog;Digital:Digital;Dualcast:Dualcast;VHF:VHF");
		$cols[] = $col;
		
		
		/*$col = array();
		$col["title"] = "Frequency";
		$col["name"] = "frekuensi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["editrules"] = array("required"=>true, "number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left","maxlength" => "10", "size"=>30, "placeholder"=>"....(Hz)");
		$cols[] = $col;*/

		$col = array();
		$col["title"] = "Coverage Populasi";
		$col["name"] = "coverage_populasi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>false, "number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "11", "size"=>10 ,"placeholder"=>"....org");
		$cols[] = $col;
		
		/*$col = array();
		$col["title"] = "Coverage Area";
		$col["name"] = "coverage_area";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>false,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "30", "size"=>30,"placeholder"=>"....Km2");
		$cols[] = $col;*/

		$col = array();
		$col["title"] = "Channel 1";
		$col["name"] = "channel_1";
		$col["width"] = "150";
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str = $g2->get_dropdown_values("SELECT  DISTINCT channel AS k, concat('Ch. ', channel,' / Freq ',frequency)  AS v FROM ms_kanal where aktif='1' ORDER BY channel");
		$col["editoptions"] = array("value"=>":;".$str); 
		$col["formatter"] = "select"; // display label, not value
		$col["stype"] = "select"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str);
		$col["editrules"] = array("required"=>false);
		$col["export"] = true;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Peta"; // caption of column
		$col["name"] = "aktif1"; 
		$col["width"] = "40";
		$col["editable"] = true;
		$col["formoptions"] = array("rowpos"=>"3", "colpos"=>"2");
		$col["editoptions"] = array("tabindex"=>"102");
		$col["edittype"] = "checkbox"; // render as checkbox
			$col["editoptions"] = array("value"=>"1:0"); // with these values "checked_value:unchecked_value"
			$col["formatter"] = "checkbox";
			$col["align"] = "center";
			$col["search"] = false;
		$cols[] = $col;		

		$col = array();
		$col["title"] = "Channel 2";
		$col["name"] = "channel_2";
		$col["width"] = "150";
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str2 = $g2->get_dropdown_values("SELECT  DISTINCT channel AS k, concat('Ch. ', channel,' / Freq ',frequency)  AS v FROM ms_kanal where aktif='1' ORDER BY channel");
		$col["editoptions"] = array("value"=>":;".$str2); 
		$col["formatter"] = "select"; // display label, not value
		$col["stype"] = "select"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str2);
		$col["editrules"] = array("required"=>false);
		$col["export"] = true;
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Peta"; // caption of column
		$col["name"] = "aktif2"; 
		$col["width"] = "40";
		$col["editable"] = true;
		$col["formoptions"] = array("rowpos"=>"5", "colpos"=>"2");
		$col["editoptions"] = array("tabindex"=>"102");
		$col["edittype"] = "checkbox"; // render as checkbox
		$col["editoptions"] = array("value"=>"1:0"); // with these values "checked_value:unchecked_value"
		$col["formatter"] = "checkbox";
		$col["align"] = "center";
		$col["search"] = false;
		$cols[] = $col;	

		$col = array();
		$col["title"] = "Channel 3";
		$col["name"] = "channel_3";
		$col["width"] = "150";
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str3 = $g2->get_dropdown_values("SELECT  DISTINCT channel AS k, concat('Ch. ', channel,' / Freq ',frequency)  AS v FROM ms_kanal where aktif='1' ORDER BY channel");
		$col["editoptions"] = array("value"=>":;".$str3); 
		$col["formatter"] = "select"; // display label, not value
		$col["stype"] = "select"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str3);
		$col["editrules"] = array("required"=>false);
		$col["export"] = true;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Peta"; // caption of column
		$col["name"] = "aktif3"; 
		$col["width"] = "40";
		$col["editable"] = true;
		$col["formoptions"] = array("rowpos"=>"7", "colpos"=>"2");
		$col["editoptions"] = array("tabindex"=>"102");
		$col["edittype"] = "checkbox"; // render as checkbox
		$col["editoptions"] = array("value"=>"1:0"); // with these values "checked_value:unchecked_value"
		$col["formatter"] = "checkbox";
		$col["align"] = "center";
		$col["search"] = false;
		$cols[] = $col;

		$col = array();
		$col["title"] = "Tipe";
		$col["name"] = "tipe";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["width"] = "120";
		$col["edittype"] = "select";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array("value"=>"Horizontal:Horizontal;Vertical:Vertical");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "I S R";
		$col["name"] = "isr";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["isnull"] = true;
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "60", "size"=>"25", "placeholder"=>" ISR...");
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Merk";
		$col["name"] = "merk";
		$col["width"] = "150";
		$col["align"] = "left";
		$col["search"] = true;
		$col["editable"] = true;
		$col["edittype"] = "select"; // render as select
		$str4 = $g2->get_dropdown_values("SELECT  DISTINCT merk AS k, merk  AS v FROM ms_merk where aktif='1' ORDER BY merk");
		$col["editoptions"] = array("value"=>":;".$str4); 
		$col["formatter"] = "select"; // display label, not value
		$col["stype"] = "select"; // enable dropdown search
		$col["searchoptions"] = array("value" => ":;".$str4);
		$col["editrules"] = array("required"=>false);
		$col["export"] = true;
		$cols[] = $col;
		/*
		$col = array();
		$col["title"] = "Merk";
		$col["name"] = "merk";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["isnull"] = true;
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "60", "size"=>"25", "placeholder"=>" Merk Pemancar....");
		$cols[] = $col;*/

		/*$col = array();
		$col["title"] = "Koordinat";
		$col["name"] = "koordinat";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>false);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "20", "size"=>30);
		 $cols[] = $col;*/

		$col = array();
		$col["title"] = "Power Nominal (Watt)";
		$col["name"] = "power_nominal";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>false,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("onfocus"=>"set_field_number1(this)","style"=>"text-align:left", "maxlength" => "10", "size"=>30, "placeholder"=>"....Watt");
		$cols[] = $col;

		$col = array();
		$col["title"] = "Power Real (Watt)";
		$col["name"] = "power_real";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>false,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("onfocus"=>"set_field_number1(this)","style"=>"text-align:left", "maxlength" => "10", "size"=>30, "placeholder"=>"....Watt");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tahun Pengadaan";
		$col["name"] = "thn_pengadaan";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "130";
		$col["editrules"] = array("required"=>false,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5", "maxlength" => "4");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kondisi";
		$col["name"] = "kondisi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$col["editoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Keterangan Kerusakan";
		$col["name"] = "keterangan_kerusakan";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "300";
		$col["editrules"] = array("required"=>false);
		$col["edittype"] = "textarea";
		$col["editoptions"] = array("rows"=>3,"cols"=>40, "placeholder"=>"Isikan Keterangan Kerusakan....");
		$cols[] = $col;

		/*$col = array();
		$col["title"] = "User Created";
		$col["name"] = "nama_lengkap";
		$col["width"] = "250";
		$col["search"] = true;
		$col["hidden"] = false;
		$col["editable"] = false;
		$col["align"] = "left";
		$cols[] = $col;*/

		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created"; 
		$col["width"] = "150";
		$col["editable"] = false; // this column is editable
		$col["formatter"] = "datetime";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s');
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Last Update";
		$col["name"] = "last_update"; 
		$col["width"] = "150";
		$col["editable"] = false; // this column is editable
		$col["formatter"] = "datetime";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s');
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;

		$g2->set_columns($cols);
		$g2->set_options($grid);

		$e = array();
		$e["on_insert"] = array("setPemancar", null, true); 
		$e["on_update"] = array("setUpdateTime", null, true); 
		$g2->set_events($e); 
	 
		Global $iduser; 
		$iduser = $this->session->userdata('user_id'); 
		
		function insertPemancar($data){
			Global $id_pemancar;
			$data["params"]["id_pemancar"] = $id_pemancar;
			// phpgrid_error($idprovinsi);
		}

		function setPemancar(&$data) 
		{ 
			Global $iduser; 
			Global $idlokasi;
			$data["params"]["iduser_created"] = $iduser;
			$data["params"]["idlokasi"] = $idlokasi;	
		}
		function setUpdateTime(&$data) 
		{ 
			$data["params"]["last_update"] = date("Y-m-d H:i:s");
		}
		$data["out"] =  $g2->render('list2');
		$this->load->view('v_reloadsingle',$data);
	}
	
	public function detailpemancar()
	{
		Global $id_pemancar;
		$this->load->library('gridlibrary');
		$g = new jqgrid($this->db_conf);
		$caps = "Detail peralatan pemancar ";
		$id_pemancar= $_REQUEST['rowid'];
		$id_pemancar = $_REQUEST["id_pemancar"];
		if($id_pemancar){
			$caps .= $jenis_transmisi;			
			$filter = "WHERE id_pemancar='$id_pemancar' ";	
			$grid["subGrid"] = false; 
			$grid["subgridurl"] = "detailpemancar";
			$grid["subgridparams"] = "iddetpemancar, project";
		}
		
		
		$grid = array();
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'iddetpemancar'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["autoresize"] = true;
		$grid["add_options"] = array("width"=>"460");
		$grid["edit_options"] = array("width"=>"460");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>"detailpemancar", "sheetname"=>"data-detailpemancar");

		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT 
								iddetpemancar
								,id_pemancar, last_update
								,project
								,merk
								,tahun
								,daya
								,kondisi
								,bd.iduser_created, bd.created, bd.last_update 
								,concat(us.first_name,' ',IFNULL(us.last_name,'')) as nama_lengkap
								FROM detail_pemancar bd
								INNER JOIN auth_users us ON us.id=bd.iduser_created
								$filter";
		$g->table = "detail_pemancar";
		
		// $g->select_command = "SELECT iddetpemancar,id_pemancar,project,merk,tahun,daya,kondisi,iduser_created, created 
							  // FROM detail_pemancar 
							  // $filter";
		// $g->table = "detail_pemancar";
		
		$cols = array();
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "iddetpemancar";
		$col["search"] = true;
		$col["editable"] = false;
		$col["isnull"] = true;
		$col["hidden"] = true;
		$col["width"] = "20";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Project";
		$col["name"] = "project";
		$col["width"] = "280";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>true); 
		$str = $g->get_dropdown_values("SELECT DISTINCT id_project AS k, CONCAT('[',nama_project,'] ',tahun_project) AS v  
																		FROM ms_project
																		WHERE nama_project IN (SELECT nama_project FROM ms_project)
																		ORDER BY 2");
		$col["editoptions"] = array("value" =>"0:NA;".$str, "separator" => ":", "delimiter" => ";");
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Merk";
		$col["name"] = "merk";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>true);
		$col["isnull"] = true;
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"25", "placeholder"=>"Masukan Merk Pemancar....");
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Daya";
		$col["name"] = "daya";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>true);
		$col["isnull"] = true;
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$col["editoptions"] = array("onfocus"=>"set_field_number0(this)", "style"=>"text-align:left", "size"=>"15","placeholder"=>"....Hz");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tahun Perolehan";
		$col["name"] = "tahun";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "130";
		$col["editrules"] = array("required"=>false);
		$col["isnull"] = true;
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5", "maxlength" => "4");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kondisi";
		$col["name"] = "kondisi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$col["editoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "nama_lengkap";
		$col["width"] = "250";
		$col["search"] = true;
		$col["editable"] = false;
		$col["align"] = "left";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created"; 
		$col["width"] = "200";
		$col["editable"] = false; // this column is editable
		$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Last Update";
		$col["name"] = "last_update"; 
		$col["width"] = "150";
		$col["editable"] = false; // this column is editable
		$col["formatter"] = "datetime";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s');
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$g->set_columns($cols);
		$g->set_options($grid);
	
		// Global $id_pemancar;
		// $id_pemancar = $this->session->userdata('user_id'); 
		Global $iduser;
		$iduser = $this->session->userdata('user_id'); 
	

		$e = array();
		$e["on_insert"] = array("setDetailPemancar", null, true); 
		$e["on_update"] = array("setUpdateTime", null, true);
		$g->set_events($e);
		
		function setUpdateTime(&$data) 
		{ 
			$data["params"]["last_update"] = date("Y-m-d H:i:s");
		}
		
		function setUpdateTime(&$data) 
		{ 
			$data["params"]["last_update"] = date("Y-m-d H:i:s");
		}
		
		function insertDetailPemancar($data){
			Global $id_pemancar;
			$data["params"]["id_pemancar"] = $id_pemancar;
			// phpgrid_error($idprovinsi);
		}
		
		function setDetailPemancar(&$data) 
		{ 
			Global $iduser; 
			Global $id_pemancar; 
			
			$data["params"]["iduser_created"] = $iduser;
			$data["params"]["id_pemancar"] = $id_pemancar;
		} 
		$data["out"] = $g->render('list8');
		$this->load->view('v_reloadsingle',$data);
	}
		
	public function tower($idparams)
	{
		Global $idlokasi;
		Global $iduser;
		$iduser = $this->idus;
		$idparams = decodeAll($idparams);
		//Grid 3 : Tower
		$this->load->library('gridlibrary');
		$g3 = new jqgrid($this->db_conf);
		$idlokasi = $idparams;
		
		$grid = array();
		$this->load->model('Transmisi_model','tx');
		$grid["caption"] ="Tower, Lokasi ".$this->tx->get_lokasi($idlokasi)->nama_lokasi;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idlokasi'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["autoresize"] = true;
		$grid["add_options"] = array("width"=>"500");
		$grid["edit_options"] = array("width"=>"500");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>"tower", "sheetname"=>"data-tower");
						
		// select row after addition
		$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list3').setSelection(r.id); }";

			
		$g3->set_actions(array(
					"add"=>true,
					"edit"=>true,
					"delete"=>true,
					"rowactions"=>false,
					"export"=>false,
					"autofilter" => true,
					"search" => false
			)
		);
		$g3->select_command = "SELECT * FROM (
				SELECT idtower, 
				ms.idlokasi,
				tipe, 
				koordinat,
				tinggi, 
				kondisi, 
				tahun_dibangun, 
				kondisi_grounding, 
				iduser_created,created, last_update
				, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
				FROM trx_tower ms 
				INNER JOIN auth_users us ON us.id=ms.iduser_created 
				WHERE ms.idlokasi='$idlokasi'
			) tablegab";
		$g3->table = "trx_tower";
				
		$cols = array();
		
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idtower";
		$col["search"] = true;
		$col["editable"] = false;
		$col["hidden"] = true;
		$col["width"] = "20";
		$cols[] = $col;

			
		$col = array();
		$col["title"] = "Tipe";
		$col["name"] = "tipe";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "120";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["editrules"] = array("required"=>false);
		$col["searchoptions"] = array("value" =>":;SELF SUPPORT:SELF SUPPORT;GUY WIRE:GUY WIRE");
		$col["editoptions"] = array("value" =>":;SELF SUPPORT:SELF SUPPORT;GUY WIRE:GUY WIRE");
		$col["export"] = false;
		$cols[] = $col;
			
		/*$col = array();
		$col["title"] = "Koordinat";
		$col["name"] = "koordinat";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["align"] = "left";
		$col["editrules"] = array("required"=>true,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"30");
		$cols[] = $col;*/
			
		$col = array();
		$col["title"] = "Tinggi";
		$col["name"] = "tinggi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["align"] = "left";
		$col["editrules"] = array("required"=>false,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left","maxlength" => "7", "size"=>"20", "placeholder"=>"....Meter");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tahun Dibangun";
		$col["name"] = "tahun_dibangun";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "130";
		$col["editrules"] = array("required"=>false, "number"=>true);
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5", "maxlength" => "4");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kondisi";
		$col["name"] = "kondisi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$col["editoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kondisi Grounding";
		$col["name"] = "kondisi_grounding";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$col["editoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "nama_lengkap";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = false;
		$col["edit_options"]= array ("maxlength"=>"11");
		$col["align"] = "left";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created"; 
		$col["width"] = "150";
		$col["editable"] = false; // this column is editable
		$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Last Update";
		$col["name"] = "last_update"; 
		$col["width"] = "150";
		$col["editable"] = false; // this column is editable
		$col["formatter"] = "datetime";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s');
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$g3->set_columns($cols);
		$g3->set_options($grid);
		
		Global $iduser_created; 
		$iduser_created = $this->session->userdata('user_id'); 
		
		$e = array();
		$e["on_insert"] = array("setTower", null, true);
		$e["on_update"] = array("setUpdateTime", null, true);
		$g3->set_events($e); 
		function setUpdateTime(&$data) 
		{ 
			$data["params"]["last_update"] = date("Y-m-d H:i:s");
		}
		function setTower(&$data) 
		{ 
			Global $iduser; 
			Global $idlokasi;
			Global $iduser_created;
			$data["params"]["iduser_created"] = $iduser;
			$data["params"]["idlokasi"] = $idlokasi;
			$data["params"]["iduser_created"] = $iduser_created;
		} 
		
		$data["out"] =  $g3->render('list3');
		$this->load->view('v_reloadsingle',$data);
		
	
	/*end grid 3*/
	
	}
	
	public function sistemantena($idparams)
	{
		Global $idlokasi;
		Global $iduser;
		$iduser = $this->idus;
		$idparams = decodeAll($idparams);
		//Grid 4 : Sistem Antena
		$this->load->library('gridlibrary');
		$g4 = new jqgrid($this->db_conf);
		$idlokasi = $idparams;
		
		
		$grid =array();
		$this->load->model('Transmisi_model','tx');
		$grid["caption"] ="Antena, Lokasi ".$this->tx->get_lokasi($idlokasi)->nama_lokasi;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idlokasi'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["autoresize"] = true;
		$grid["add_options"] = array("width"=>"550");
		$grid["edit_options"] = array("width"=>"550");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>"sistemantena", "sheetname"=>"data-sistemantena");
		
			// select row after addition
		// $grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list4').setSelection(r.id); }";
		
		$g4->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		$g4->select_command = "SELECT * FROM (
			SELECT idantena,ms.idlokasi,tipe,polarisasi,merk,thn_perolehan,panel_arah,gain,iduser_created,created, last_update
			, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
			FROM trx_antena ms 
			INNER JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi'
		) tablegab";
		$g4->table = "trx_antena";
			
		$cols =array();	
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idantena";
		$col["search"] = true;
		$col["editable"] = false;
		$col["hidden"] = true;
		$col["width"] = "20";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tipe";
		$col["name"] = "tipe";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;DIPOLE:DIPOLE;GROUND PLANE:GROUND PLANE;SECTORIAL/DIRECTIVE:SECTORIAL/DIRECTIVE");
		$col["editoptions"] = array("value" =>":;DIPOLE:DIPOLE;GROUND PLANE:GROUND PLANE;SECTORIAL/DIRECTIVE:SECTORIAL/DIRECTIVE");
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Polarisasi";
		$col["name"] = "polarisasi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;Horizontal:Horizontal;Vertical:Vertical");
		$col["editoptions"] = array("value" =>":;Horizontal:Horizontal;Vertical:Vertical");
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Merk";
		$col["name"] = "merk";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"30","placeholder"=>"Merk Antena....");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tahun Perolehan";
		$col["name"] = "thn_perolehan";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "110";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5", "maxlength" => "4");
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Panel Arah";
		$col["name"] = "panel_arah";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "160", "size"=>"30");
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Gain (Desibel)";
		$col["name"] = "gain";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false,"number"=>true);
		$col["editoptions"] = array( "onfocus"=>"set_field_number2(this)", "style"=>"text-align:left","maxlength" => "20", "size"=>"30","placeholder"=>"....Desibel");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "nama_lengkap";
		$col["width"] = "150";
		$col["search"] = true;
		$col["editable"] = false;
		$col["edit_options"]= array ("maxlength"=>"11");
		$col["align"] = "left";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created"; 
		$col["width"] = "150";
		$col["editable"] = false; // this column is editable
		$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Last Update";
		$col["name"] = "last_update"; 
		$col["width"] = "150";
		$col["editable"] = false; // this column is editable
		$col["formatter"] = "datetime";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s');
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$g4->set_columns($cols);
		$g4->set_options($grid);
		
		
		$e = array();
		$e["on_insert"] = array("setAntena", null, true);
		$e["on_update"] = array("setUpdateTime", null, true);
		$g4->set_events($e); 
		function setUpdateTime(&$data) 
		{ 
			$data["params"]["last_update"] = date("Y-m-d H:i:s");
		}
		function setAntena(&$data) 
		{ 
			Global $iduser; 
			$data["params"]["iduser_created"] = $iduser;
			Global $idlokasi; 
			$data["params"]["idlokasi"] = $idlokasi;
		} 
		
		$data["out"] =  $g4->render('list4');
		$this->load->view('v_reloadsingle',$data);
	
	}

	public function catudaya($idparams)
	{
		Global $idlokasi;
		Global $iduser;
		$iduser = $this->idus;
		$idparams = decodeAll($idparams);
		//Grid 5 : Catu Daya
		$this->load->library('gridlibrary');
		$g5 = new jqgrid($this->db_conf);
		$idlokasi = $idparams;
		
		$grid = array();
		$this->load->model('Transmisi_model','tx');
		$grid["caption"] ="Catu Daya, Lokasi ".$this->tx->get_lokasi($idlokasi)->nama_lokasi;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idlokasi'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["autoresize"] = true;
		$grid["add_options"] = array("width"=>"560");
		$grid["edit_options"] = array("width"=>"560");
		$grid["view_options"] = array("width"=>"500");
		$grid["export"] = array("format"=>"xls", "filename"=>"catudaya", "sheetname"=>"data-catudaya");
		
		// select row after addition
		// $grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list5').setSelection(r.id); }";
		
		$g5->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		$g5->select_command = "SELECT * FROM (
			SELECT idcatudaya,ms.idlokasi,sumber_daya,besar_daya,merk,phase,kondisi,thn_perolehan, iduser_created,created, last_update, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
			FROM trx_catu_daya ms 
			left JOIN auth_users us ON us.id=ms.iduser_created 
			WHERE ms.idlokasi='$idlokasi'
		) tablegab";
		$g5->table = "trx_catu_daya";
		
		
		$cols = array();
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idcatudaya";
		$col["search"] = true;
		$col["hidden"] = true;
		$col["width"] = "20";
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Sumber Daya";
		$col["name"] = "sumber_daya";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;PLN:PLN;GENSET:GENSET");
		$col["editoptions"] = array("value" =>":;PLN:PLN;GENSET:GENSET");
		$col["export"] = false;
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Besar Daya (KVA)";
		$col["name"] = "besar_daya";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["align"] = "left";
		$col["width"] = "120";
		$col["editrules"] = array("required"=>false, "number"=>true);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "11", "size"=>"30","placeholder"=>"....KVA");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Merk";
		$col["name"] = "merk";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"30","placeholder"=>"Masukan Merk....");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Phase";
		$col["name"] = "phase";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;		
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"30","placeholder"=>"....Watt");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kondisi";
		$col["name"] = "kondisi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$col["editoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tahun Perolehan";
		$col["name"] = "thn_perolehan";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "130";
		$col["editrules"] = array("required"=>false);
		$col["isnull"] = true;
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5", "maxlength" => "4");
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "nama_lengkap";
		$col["width"] = "200";
		$col["search"] = true;
		$col["edit_options"]= array ("maxlength"=>"11");
		$col["align"] = "left";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created"; 
		$col["width"] = "200";
		$col["editable"] = false; // this column is editable
		$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Last Update";
		$col["name"] = "last_update"; 
		$col["width"] = "150";
		$col["editable"] = false; // this column is editable
		$col["formatter"] = "datetime";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s');
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$g5->set_columns($cols);
		$g5->set_options($grid);
	
		$e = array();
		$e["on_insert"] = array("setCatuDaya", null, true);
		$e["on_update"] = array("setUpdateTime", null, true);
		$g5->set_events($e); 
		
		function setUpdateTime(&$data) 
		{ 
			$data["params"]["last_update"] = date("Y-m-d H:i:s");
		}
		function setCatuDaya(&$data) 
		{ 
			Global $iduser; 
			$data["params"]["iduser_created"] = $iduser;
			Global $idlokasi; 
			$data["params"]["idlokasi"] = $idlokasi;
		} 
		
		$data["out"] = $g5->render('list5');
		$this->load->view('v_reloadsingle',$data);

		/*end grid 5*/
		
	}
	
	public function ups($idparams)
	{
		Global $idlokasi;
		Global $iduser;
		$iduser = $this->idus;
		$idparams = decodeAll($idparams);
		$this->load->library('gridlibrary');
		$g6 = new jqgrid($this->db_conf);
		$idlokasi = $idparams;
		
		$grid = array ();
		$this->load->model('Transmisi_model','tx');
		$grid["caption"] ="UPS, Lokasi ".$this->tx->get_lokasi($idlokasi)->nama_lokasi;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idlokasi'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["autoresize"] = true;
		$grid["add_options"] = array("width"=>"560");
		$grid["edit_options"] = array("width"=>"560");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>"ups", "sheetname"=>"data-ups");
		
		// select row after addition
		//$grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list6').setSelection(r.id); }";
		
		
		$g6->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		$g6->select_command = "SELECT * FROM (
			SELECT idups
			,ms.idlokasi
			,merk
			,kapasitas
			,kondisi
			,thn_perolehan
			,nomer_seri
			,iduser_created,created, last_update
			, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
			FROM trx_ups ms 
			left JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi'
		) tablegab";
		$g6->table = "trx_ups";
			
		$cols = array ();
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idups";
		$col["search"] = true;
		$col["editable"] = false;
		$col["hidden"] = true;
		$col["width"] = "20";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Merk";
		$col["name"] = "merk";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"30","placeholder"=>"Masukan Merk UPS...");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kapasitas (KVA)";
		$col["name"] = "kapasitas";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array("onfocus"=>"set_field_number0(this)","style"=>"text-align:left","maxlength" => "30", "size"=>"30","placeholder"=>"....KVA");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kondisi";
		$col["name"] = "kondisi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$col["editoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tahun Perolehan";
		$col["name"] = "thn_perolehan";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "130";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5", "maxlength" => "4");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Nomor Seri";
		$col["name"] = "nomer_seri";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"30");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "nama_lengkap";
		$col["width"] = "200";
		$col["search"] = true;
		$col["editable"] = false;
		$col["edit_options"]= array ("maxlength"=>"11");
		$col["align"] = "left";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created"; 
		$col["width"] = "200";
		$col["editable"] = false; // this column is editable
		$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Last Update";
		$col["name"] = "last_update"; 
		$col["width"] = "150";
		$col["editable"] = false; // this column is editable
		$col["formatter"] = "datetime";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s');
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$g6->set_columns($cols);
		$g6->set_options($grid);
		
		$e = array();
		$e["on_insert"] = array("setUPS", null, true);
		$e["on_update"] = array("setUpdateTime", null, true);
		$g6->set_events($e); 
		
		function setUpdateTime(&$data) 
		{ 
			$data["params"]["last_update"] = date("Y-m-d H:i:s");
		}
		function setUPS(&$data) 
		{ 
			Global $iduser; 
			$data["params"]["iduser_created"] = $iduser;
			Global $idlokasi; 
			$data["params"]["idlokasi"] = $idlokasi;
		} 

		$data["out"] = $g6->render('list6');
		$this->load->view('v_reloadsingle',$data);
	
		/*end grid 6*/
		
		
	}

	public function parabola($idparams)
	{
		Global $idlokasi;
		Global $iduser;
		$iduser = $this->idus;
		$idparams = decodeAll($idparams);
		$this->load->library('gridlibrary');
		$g7 = new jqgrid($this->db_conf);
		$idlokasi = $idparams;
		
		$grid =array();
		$this->load->model('Transmisi_model','tx');
		$grid["caption"] ="Parabola, Lokasi ".$this->tx->get_lokasi($idlokasi)->nama_lokasi;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idlokasi'; 
		$grid["autowidth"] = true;
		$grid["shrinkToFit"] = false;
		$grid["forceFit"] = false;
		$grid["resizable"] = true;
		$grid["multiselect"] = false; 
		$grid["rowactions"] = true; 
		$grid["toolbar"] = "both"; 
		$grid["height"] = ""; 
		$grid["autoresize"] = true;
		$grid["add_options"] = array("width"=>"500");
		$grid["edit_options"] = array("width"=>"500");
		$grid["view_options"] = array("width"=>"460");
		$grid["export"] = array("format"=>"xls", "filename"=>"parabola", "sheetname"=>"data-parabola");
		
		// select row after addition
		// $grid["add_options"]["afterComplete"] = "function (response, postdata) { r = JSON.parse(response.responseText); $('#list7').setSelection(r.id); }";
		
		$g7->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>true,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		$g7->select_command = "SELECT * FROM (
			SELECT idparabola
			,ms.idlokasi
			,merk
			,diameter
			,tipe
			,kondisi
			,thn_perolehan
			, iduser_created,created, last_update
			, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
			FROM trx_parabola ms 
			left JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi'
		) tablegab";
		$g7->table = "trx_parabola";
			
		$cols =array();
		$col = array();
		$col["title"] = "ID";
		$col["name"] = "idparabola";
		$col["search"] = true;
		$col["editable"] = false;
		$col["hidden"] = true;
		$col["width"] = "20";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Merk";
		$col["name"] = "merk";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"30","placeholder"=>"Masukan Merk Parabola...");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Diameter (m)";
		$col["name"] = "diameter";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array("onfocus"=>"set_field_number2(this)","style"=>"text-align:left", "size"=>"25","placeholder"=>"... m");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tipe";
		$col["name"] = "tipe";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;Parabola Jaring (Mesh):Parabola Jaring (Mesh);Parabola Solid:Parabola Solid;Parabola Mini:Parabola Mini");
		$col["editoptions"] = array("value" =>":;Parabola Jaring (Mesh):Parabola Jaring (Mesh);Parabola Solid:Parabola Solid;Parabola Mini:Parabola Mini");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kondisi";
		$col["name"] = "kondisi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["edittype"] = "select";
		$col["stype"] = "select";
		$col["formatter"] = "select";
		$col["searchoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$col["editoptions"] = array("value" =>":;Baik:Baik;Rusak:Rusak;Sedang Diperbaiki:Sedang Diperbaiki");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Tahun Perolehan";
		$col["name"] = "thn_perolehan";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "120";
		$col["editrules"] = array("required"=>false, "number"=>true);
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5", "maxlength" => "4");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "nama_lengkap";
		$col["width"] = "200";
		$col["search"] = true;
		$col["editable"] = false;
		$col["edit_options"]= array ("maxlength"=>"11");
		$col["align"] = "left";
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Created";
		$col["name"] = "created"; 
		$col["width"] = "200";
		$col["editable"] = false; // this column is editable
		$col["editoptions"] = array("size"=>"20", "defaultValue" => date("d.m.Y")); // with default display of textbox with size 20
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Last Update";
		$col["name"] = "last_update"; 
		$col["width"] = "150";
		$col["editable"] = false; // this column is editable
		$col["formatter"] = "datetime";
		$col["formatoptions"] = array("srcformat"=>'Y-m-d H:i:s',"newformat"=>'d-m-Y H:i:s');
		$col["editrules"] = array("required"=>true, "edithidden"=>true); // and is required
		$cols[] = $col;
		
		$g7->set_columns($cols);
		$g7->set_options($grid);

		$e = array();
		$e["on_insert"] = array("setParabola", null, true);
		$e["on_update"] = array("setUpdateTime", null, true);
		$g7->set_events($e); 
		
		function setUpdateTime(&$data) 
		{ 
			$data["params"]["last_update"] = date("Y-m-d H:i:s");
		}

		function setParabola(&$data) 
		{ 
			Global $iduser; 
			$data["params"]["iduser_created"] = $iduser;
			Global $idlokasi; 
			$data["params"]["idlokasi"] = $idlokasi;
		} 
	
		$data["out"] = $g7->render('list7');
		$this->load->view('v_reloadsingle',$data);
	/*end grid 7*/
			
	}
	
	public function export($idlokasi)
	{
		$idlokasi = decodeAll($idlokasi);
		$id_pemancar = $idlokasi;
		//Global $id_pemancar;
		//$id_pemancar = decodeAll($id_pemancar);
		// echo $idlokasi; die;
		
		$temp = str_replace(date('dmY'),'',base64_decode(urldecode($this->input->get('id', TRUE))));
		$params = explode('###',$temp);

		
		
		
		$datatower = $this->db->query("select * FROM  trx_tower WHERE idlokasi='$idlokasi' ")->result();
		$dataantena = $this->db->query("select * FROM  trx_antena WHERE idlokasi='$idlokasi' ")->result();
		$datacatudaya = $this->db->query("select * FROM  trx_catu_daya WHERE idlokasi='$idlokasi' ")->result();
		$dataups = $this->db->query("select * FROM  trx_ups WHERE idlokasi='$idlokasi' ")->result();
		$dataparabola = $this->db->query("select * FROM  trx_parabola WHERE idlokasi='$idlokasi'")->result();
		
		// $idlokasi = $params[0];
		
		
		$this->load->library('PHPExcel.php');
		$objPHPExcel = new PHPExcel();
		$this->load->model('Transmisi_model');
		$template = 'assets/template/transmisi/DataTransmisi.xls';
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load($template);

		

		$data = $this->Transmisi_model->get_lokasi($idlokasi);
		// print_r($idlokasi);exit;
		// $title = (strlen($nama_pemohon) > 23) ? substr($nama_pemohon,0,23) : $nama_pemohon;
		
		// sheet lokasi
		{
			$datalokasi = $this->db->query("SELECT * FROM (SELECT ms.idlokasi,ms_provinsi.nama_provinsi, ms_kabupaten.nama_kabupaten,
											ms_kecamatan.nama_kec, ms_desa.nama_desa,ms.nama_lokasi,ms.iduser_created,ms.created,
											CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
											FROM ms_lokasi_tvri ms
											INNER JOIN ms_provinsi ON ms.idprovinsi = ms_provinsi.idprovinsi
											INNER JOIN ms_kabupaten ON ms.idkabupaten = ms_kabupaten.idkabupaten
											INNER JOIN ms_kecamatan ON ms.idkec = ms_kecamatan.idkec
											INNER JOIN ms_desa ON ms.iddesa = ms_desa.iddesa
											INNER JOIN auth_users us ON us.id=ms.iduser_created )
											tablegab ")->result();
			$objPHPExcel->setActiveSheetIndex(0);
			// $title = 'Lokasi';
			// $objPHPExcel->getActiveSheet()->setTitle("Lokasi ".$title);
			$objPHPExcel->getActiveSheet()->setTitle("Lokasi");
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar Lokasi Fixed Broadband "'.strtoupper($data->nama_lokasi).'"');
			$no = 1;
			$numrow = 4; // Set baris pertama untuk isi tabel
			foreach($datalokasi as $lk){ // looping
				 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
				 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $lk->nama_provinsi);
				 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $lk->nama_kabupaten);
				 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $lk->nama_kec);
				 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $lk->nama_desa);
				 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $lk->nama_lokasi);
				 $no++; // Tambah 1 setiap kali looping
				 $numrow++; // Tambah 1 setiap kali looping
			}
			
		}
		/* end sheet lokasi */
		
		// sheet pemancar
		{
			$datapemancar = $this->db->query("select * FROM  trx_pemancar WHERE idlokasi='$idlokasi' ")->result();
			$objPHPExcel->setActiveSheetIndex(1);
			$objPHPExcel->getActiveSheet()->setTitle("Pemancar ");
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar PemancarFixed Broadband "'.strtoupper($data->nama_lokasi).'"');
			$no = 1;
			$nfmrow = 4; // Set baris pertama untuk isi tabel
		    foreach($datapemancar as $pm){ // looping
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$nfmrow, $no);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$nfmrow, $pm->jenis_transmisi);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('C'.$nfmrow, $pm->frekuensi);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('D'.$nfmrow, $pm->coverage_populasi);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$nfmrow, $pm->coverage_area);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$nfmrow, $pm->channel_1);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$numrow, $pm->channel_2);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('H'.$numrow, $pm->channel_3);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$nfmrow, $pm->tipe);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('J'.$numrow, $pm->koordinat);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K'.$numrow, $pm->power_nominal);
				$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$nfmrow, $pm->power_real);
				$no++; // Tambah 1 setiap kali looping
				$nfmrow++; // Tambah 1 setiap kali looping
			}
		}
		/* end sheet pemancar */
		
		// sheet detailpemancar
		{
			$objPHPExcel->setActiveSheetIndex(2);
			$objPHPExcel->getActiveSheet()->setTitle("Detail Pemancar");
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar Detail Pemancar Fixed Broadband "'.strtoupper($data->nama_lokasi).'"');
			$no = 1;
			$nfmrow = 3; // Set baris pertama untuk isi tabel
			$arrtipe = ["Analog", "Digital"];
			foreach($arrtipe as $h){
				$objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.$nfmrow, $h);
				$nfmrow++;
				$datadetailpemancar = $this->db->query("SELECT *,pj.nama_project,pc.idlokasi,pc.jenis_transmisi
															FROM  detail_pemancar dt 
															LEFT JOIN trx_pemancar pc ON dt.id_pemancar = pc.id_pemancar 
															INNER JOIN ms_project pj ON dt.project= pj.id_project
															WHERE pc.idlokasi= '$idlokasi' AND pc.jenis_transmisi='$h'
															ORDER BY pc.jenis_transmisi ")->result();
				// code untuk detail_pemancar
				// echo json_encode($datadetailpemancar ); die;
				foreach($datadetailpemancar as $dp){ // looping
					$objPHPExcel->setActiveSheetIndex(2)->setCellValue('A'.$nfmrow, $no);
					$objPHPExcel->setActiveSheetIndex(2)->setCellValue('B'.$nfmrow, $dp->nama_project);
					$objPHPExcel->setActiveSheetIndex(2)->setCellValue('C'.$nfmrow, $dp->merk);
					$objPHPExcel->setActiveSheetIndex(2)->setCellValue('D'.$nfmrow, $dp->daya);
					$objPHPExcel->setActiveSheetIndex(2)->setCellValue('E'.$nfmrow, $dp->tahun);
					$objPHPExcel->setActiveSheetIndex(2)->setCellValue('F'.$nfmrow, $dp->kondisi);
					$no++; // Tambah 1 setiap kali looping
					$nfmrow++; // Tambah 1 setiap kali looping
				}
				
			}
			
		}
		/* end sheet detailpemancar */
		
		// sheet tower
		{
			$objPHPExcel->setActiveSheetIndex(3);
			$objPHPExcel->getActiveSheet()->setTitle("Tower");
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar Tower Fixed Broadband "'.strtoupper($data->nama_lokasi).'"');
			$no = 1;
			$nfmrow = 4; // Set baris pertama untuk isi tabel
			foreach($datatower as $tr){ // looping
				$objPHPExcel->setActiveSheetIndex(3)->setCellValue('A'.$nfmrow, $no);
				$objPHPExcel->setActiveSheetIndex(3)->setCellValue('B'.$nfmrow, $tr->tipe);
				$objPHPExcel->setActiveSheetIndex(3)->setCellValue('C'.$nfmrow, $tr->koordinat);
				$objPHPExcel->setActiveSheetIndex(3)->setCellValue('D'.$nfmrow, $tr->tinggi);
				$objPHPExcel->setActiveSheetIndex(3)->setCellValue('E'.$nfmrow, $tr->kondisi);
				$objPHPExcel->setActiveSheetIndex(3)->setCellValue('F'.$nfmrow, $tr->tahun_dibangun);
				$objPHPExcel->setActiveSheetIndex(3)->setCellValue('G'.$numrow, $tr->kondisi_grounding);
				$no++; // Tambah 1 setiap kali looping
				$nfmrow++; // Tambah 1 setiap kali looping
			}
		}
		/* end sheet tower */
		
		// sheet sistemantena
		{
			$objPHPExcel->setActiveSheetIndex(4);
			$objPHPExcel->getActiveSheet()->setTitle("sistemantena");
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar sistemantena Fixed Broadband "'.strtoupper($data->nama_lokasi).'"');
			$no = 1;
			$nfmrow = 4; // Set baris pertama untuk isi tabel
			foreach($dataantena as $sa){ // looping
				$objPHPExcel->setActiveSheetIndex(4)->setCellValue('A'.$nfmrow, $no);
				$objPHPExcel->setActiveSheetIndex(4)->setCellValue('B'.$nfmrow, $sa->tipe);
				$objPHPExcel->setActiveSheetIndex(4)->setCellValue('C'.$nfmrow, $sa->polarisasi);
				$objPHPExcel->setActiveSheetIndex(4)->setCellValue('D'.$nfmrow, $sa->merk);
				$objPHPExcel->setActiveSheetIndex(4)->setCellValue('E'.$nfmrow, $sa->thn_perolehan);
				$objPHPExcel->setActiveSheetIndex(4)->setCellValue('F'.$nfmrow, $sa->panel_arah);
				$objPHPExcel->setActiveSheetIndex(4)->setCellValue('G'.$numrow, $sa->gain);
				$no++; // Tambah 1 setiap kali looping
				$nfmrow++; // Tambah 1 setiap kali looping
			}
			
		}
		/* end sheet sistemantena */
		 
		// sheet catu daya
		{
			$objPHPExcel->setActiveSheetIndex(5);
			$objPHPExcel->getActiveSheet()->setTitle("Catu Daya");
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar Catu Daya Fixed Broadband "'.strtoupper($data->nama_lokasi).'"');
			$no = 1;
			$nfmrow = 4; // Set baris pertama untuk isi tabel
			foreach($datacatudaya as $cd){ // looping
				$objPHPExcel->setActiveSheetIndex(5)->setCellValue('A'.$nfmrow, $no);
				$objPHPExcel->setActiveSheetIndex(5)->setCellValue('B'.$nfmrow, $cd->sumber_daya);
				$objPHPExcel->setActiveSheetIndex(5)->setCellValue('C'.$nfmrow, $cd->besar_daya);
				$objPHPExcel->setActiveSheetIndex(5)->setCellValue('D'.$nfmrow, $cd->merk);
				$objPHPExcel->setActiveSheetIndex(5)->setCellValue('E'.$nfmrow, $cd->phase);
				$objPHPExcel->setActiveSheetIndex(5)->setCellValue('F'.$nfmrow, $cd->kondisi);
				$objPHPExcel->setActiveSheetIndex(5)->setCellValue('G'.$numrow, $cd->thn_perolehan);
				$no++; // Tambah 1 setiap kali looping
				$nfmrow++; // Tambah 1 setiap kali looping
			}


		}
		/* end sheet catu daya */
		
		// sheet UPS
		{
			$objPHPExcel->setActiveSheetIndex(6);
			$objPHPExcel->getActiveSheet()->setTitle("UPS");
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar UPS Fixed Broadband "'.strtoupper($data->nama_lokasi).'"');
			$no = 1;
			$nfmrow = 4; // Set baris pertama untuk isi tabel
			foreach($dataups as $ups){ // looping
				$objPHPExcel->setActiveSheetIndex(6)->setCellValue('A'.$nfmrow, $no);
				$objPHPExcel->setActiveSheetIndex(6)->setCellValue('B'.$nfmrow, $ups->merk);
				$objPHPExcel->setActiveSheetIndex(6)->setCellValue('C'.$nfmrow, $ups->kapasitas);
				$objPHPExcel->setActiveSheetIndex(6)->setCellValue('D'.$nfmrow, $ups->kondisi);
				$objPHPExcel->setActiveSheetIndex(6)->setCellValue('E'.$nfmrow, $ups->thn_perolehan);
				$objPHPExcel->setActiveSheetIndex(6)->setCellValue('F'.$nfmrow, $ups->nomer_seri);
				$no++; // Tambah 1 setiap kali looping
				$nfmrow++; // Tambah 1 setiap kali looping
			}
		 
		}
		/* end sheet UPS */
			
		// sheet Parabola
		{
			$objPHPExcel->setActiveSheetIndex(7);
			$objPHPExcel->getActiveSheet()->setTitle("Parabola");
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar Parabola Fixed Broadband "'.strtoupper($data->nama_lokasi).'"');
			$no = 1;
			$nfmrow = 4; // Set baris pertama untuk isi tabel
			foreach($dataparabola as $pa){ // looping
				$objPHPExcel->setActiveSheetIndex(7)->setCellValue('A'.$nfmrow, $no);
				$objPHPExcel->setActiveSheetIndex(7)->setCellValue('B'.$nfmrow, $pa->merk);
				$objPHPExcel->setActiveSheetIndex(7)->setCellValue('C'.$nfmrow, $pa->diameter);
				$objPHPExcel->setActiveSheetIndex(7)->setCellValue('D'.$nfmrow, $pa->tipe);
				$objPHPExcel->setActiveSheetIndex(7)->setCellValue('E'.$nfmrow, $pa->kondisi);
				$objPHPExcel->setActiveSheetIndex(7)->setCellValue('F'.$nfmrow, $pa->thn_perolehan);
				$no++; // Tambah 1 setiap kali looping
				$nfmrow++; // Tambah 1 setiap kali looping
			}
		}
		/* end sheet Parabola */

		// $prn = str_replace(".","_",'"'.$data->nama_lokasi.'"');
		// //echo json_encode($prn);
		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header('Content-Disposition: attachment;filename="'.$prn.'.xls"');
		// header('Cache-Control: max-age=0');

		// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		// $objWriter->save('php://output');
		
		$namafile ='Transmisi_'.$data->nama_lokasi.'.xls';
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($namafile);
		$len = filesize($namafile);
		// ob_clean();
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, GET-check=0, pre-check=0');
		header('Cache-Control: public');
		header('Content-Description: File Transfer');
		header('Content-Type:application/vnd.ms-excel'); // Send type of file
		$header='Content-Disposition: attachment;filename='.$namafile; // Send File Name
		header($header );
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.$len); // Send File Size
		@readfile($namafile);
		unlink($namafile);
		
	}
	public function dsh_digital()
	{
		$this->load->library('gridlibrary');
		global $g;
		$g = new jqgrid($this->db_conf);
		$this->load->model('Global_model','gb');
		$head['collapse'] = false;
		$head['title'] = "Dashboard Digital";
		$data['breadcrumbs'] = $this->gb->create_breadcrumbs(["Dashboard"]);
		$data['tokenapikey'] = $this->apikeymaps;
		
		$caps = "Dashboard Digital";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idlokasi'; 
		$grid["rowNum"] = 20; 
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
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"dashboard digital");
		
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$col = array();
		$col["title"] = "Nama Lokasi";
		$col["name"] = "idlokasi";
		$col["editoptions"] = array("maxlength" => "20","size"=>30);
		$col["editrules"] = array("required" => true);
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
																		AND idlokasi={idlokasi}
																		ORDER BY nama_lokasi",
																		"update_field" => "idlokasi" )
										);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Jenis";
		$col["name"] = "jenis_transmisi";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["width"] = "120";
		$col["edittype"] = "select";
		$col["editoptions"] = array("value"=>"Analog:Analog;Digital:Digital");
		$cols[] = $col;
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_digital',$data);
		$this->load->view('layout/footer');
		
	}
	
	public function dsh_analog()
	{
		$this->load->library('gridlibrary');
		global $g;
		$g = new jqgrid($this->db_conf);
		$this->load->model('Global_model','gb');
		$head['collapse'] = false;
		$head['title'] = "Dashboard Analog";
		$data['breadcrumbs'] = $this->gb->create_breadcrumbs(["Dashboard"]);
		$data['tokenapikey'] = $this->apikeymaps;
		
		$caps = "Dashboard Analog";
		
		$grid["caption"] = $caps;
		$grid["rowNum"] = 20; 
		$grid["rowList"] = array(20,40,100,'All');
		$grid["rownumbers"] = true;
		$grid["sortname"] = 'idlokasi'; 
		$grid["rowNum"] = 20; 
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
		$grid["export"] = array("format"=>"xls", "filename"=>$this->file_name, "sheetname"=>"dashboard analog");
		
		
		$g->set_actions(array(
				"add"=>true,
				"edit"=>true,
				"delete"=>false,
				"rowactions"=>false,
				"export"=>false,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$col = array();
		$col["title"] = "Nama Lokasi";
		$col["name"] = "idlokasi";
		$col["editoptions"] = array("maxlength" => "20","size"=>30);
		$col["editrules"] = array("required" => true);
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
																		AND idlokasi={idlokasi}
																		ORDER BY nama_lokasi",
																		"update_field" => "idlokasi" )
										);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Jenis";
		$col["name"] = "jenis_transmisi";
		$col["search"] = true;
		$col["editable"] = true;
		$col["align"] = "left";
		$col["width"] = "120";
		$col["edittype"] = "select";
		$col["editoptions"] = array("value"=>"Analog:Analog;Digital:Digital");
		$cols[] = $col;
		
		$this->load->view('layout/header',$head);
		$this->load->view('layout/sidebar');
		$this->load->view('v_analog',$data);
		$this->load->view('layout/footer');
		
	}
	
}
?>