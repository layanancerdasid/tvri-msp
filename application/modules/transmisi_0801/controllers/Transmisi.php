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
		error_reporting(E_ALL);
		ini_set ("log_errors",1);
		ini_set("display_errors",1);
		error_reporting(-1);
		ini_set('display_errors', 1);
		
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
			$grid["shrinkToFit"] = false;// agar panjang row bisa sesuai
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
					"export"=>true,
					"autofilter" => true,
					"search" => "advance"
				)
			);
			
			$g->select_command ="SELECT * FROM (
				SELECT ms.idlokasi
				, idprovinsi
				, idkabupaten
				, idkec
				, iddesa
				, nama_lokasi
				, latitude
				, longitude, alamat
				, CONCAT(us.first_name,' ',IFNULL(us.last_name,''))nama_lengkap	
				,CASE WHEN ms.is_analog=1 AND ms.is_digital=1 THEN 'Analog, Digital'
					   WHEN ms.is_analog=1 AND ms.is_digital=0 THEN 'Analog'
					   WHEN ms.is_analog=0 AND ms.is_digital=1 THEN 'Digital'
					   ELSE ''
				  END tipe_transmisi	
				,is_analog
				,is_digital	
				FROM ms_lokasi_tvri ms 
				INNER JOIN auth_users us ON us.id=ms.iduser_created
			) tablegab";
			$g->table = "ms_lokasi_tvri";
			
			// $g->select_command = "SELECT * FROM (
				// SELECT idlokasi
				// , idprovinsi
				// , idkabupaten
				// , idkec
				// , iddesa
				// , nama_lokasi
				// , iduser_create, created
				// , CONCAT(us.first_name,' ',IFNULL(us.last_name,''))nama_lengkap		
				// FROM ms_lokasi_tvri ms 
				// INNER JOIN auth_users us ON us.id=ms.iduser_create
			// ) tablegab";
			// $g->table = "ms_lokasi_tvri";
			
				
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
			$col["title"] = "Nama Lokasi";
			$col["name"] = "nama_lokasi";
			$col["search"] = true;
			$col["align"] = "left";
			$col["editable"] = true;
			$col["width"] = "250";
			$col["editrules"] = array("required"=>true);
			$col["editoptions"] = array("maxlength" => "30", "size"=>30);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Provinsi";
			$col["name"] = "idprovinsi";
			$col["dbname"] = "ms_provinsi";
			$col["width"] = "200";
			$col["align"] = "left";
			$col["search"] = true;
			$col["editable"] = true;
			$col["edittype"] = "select"; // render as select
			# fetch data from database, with alias k for key, v for value

			# on change, update other dropdown
			$str = $g->get_dropdown_values("select distinct idprovinsi as k, nama_provinsi as v from ms_provinsi");
			$col["editoptions"] = array(
						"value"=>":;".$str, 
						"onchange" => array(    "sql"=>"select distinct idkabupaten as k, nama_kabupaten as v from ms_kabupaten WHERE idprovinsi = '{idprovinsi}'",
												"update_field" => "idkabupaten" )
										);

			$col["formatter"] = "select"; // display label, not value
			//$col["stype"] = "select-multiple"; // enable dropdown search
			$col["searchoptions"] = array("value" => ":;".$str);
			$cols[] = $col;        
			
			$col = array();
			$col["title"] = "Kabupaten";
			$col["name"] = "idkabupaten";
			$col["dbname"] = "ms_kabupaten";
			$col["width"] = "200";
			$col["search"] = true;
			$col["editable"] = true;
			$col["edittype"] = "select"; // render as select
			$str = $g->get_dropdown_values("select idkabupaten as k, nama_kabupaten as v from ms_kabupaten");
			$col["editoptions"] = array(
						"value"=>$str, 
						"onchange" => array(    "sql"=>"select distinct idkec as k, nama_kec as v from ms_kecamatan WHERE idkabupaten = '{idkabupaten}'",
												"update_field" => "idkec" )
										);
										
			$col["formatter"] = "select"; // display label, not value
			$col["searchoptions"] = array("value" => ":;".$str);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Kecamatan";
			$col["name"] = "idkec";
			$col["dbname"] = "ms_kecamatan";
			$col["width"] = "170";
			$col["search"] = true;
			$col["editable"] = true;
			$col["edittype"] = "select"; // render as select
			$str = $g->get_dropdown_values("select idkec as k, nama_kec as v from ms_kecamatan");
			$col["editoptions"] = array(
						"value"=>$str, 
						"onchange" => array(    "sql"=>"select distinct iddesa as k, nama_desa as v from ms_desa WHERE idkec = '{idkec}'",
												"update_field" => "iddesa" )
										);
										
			$col["formatter"] = "select"; // display label, not value
			$col["searchoptions"] = array("value" => ":;".$str);
			$cols[] = $col;
			
			$col = array();
			$col["title"] = "Desa";
			$col["name"] = "iddesa";
			$col["dbname"] = "ms_desa";
			$col["width"] = "170";
			$col["search"] = true;
			$col["editable"] = true;
			$col["edittype"] = "select"; // render as select
			$str = $g->get_dropdown_values("select iddesa as k, nama_desa as v from ms_desa LIMIT 10");
			$col["editoptions"] = array(
										"value"=>$str
										);
			// echo "tess"; die;
			// required for manual refresh link                    
			$col["editoptions"]["onload"]["sql"] = "select distinct iddesa as k, nama_desa as v from ms_desa where idkec		= '{idkec}'";
			$col["formatter"] = "select"; // display label, not value
			$col["searchoptions"] = array("value" => ":;".$str);
			$cols[] = $col;
			
			$col = array();
		$col["title"] = "Longitude";
		$col["name"] = "longitude";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "20", "size"=>"30"
							  ,"onfocus"=>"set_field_number0(this)");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Latitude";
		$col["name"] = "latitude";
		$col["search"] = true;
		$col["align"] = "center";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "20", "size"=>"30"
							  ,"onfocus"=>"set_field_number2(this)");
		$col["show"] = array("list"=>true,"edit"=>true,"add"=>true,"view"=>true);
		$cols[] = $col;
		 
		
		$col = array();
		$col["title"] = "Alamat";
		$col["name"] = "alamat";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "500";
		$col["edittype"] = "textarea";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("maxlength" => "50", "cols"=>"30", "rows"=>"3",);
		$cols[] = $col;
			

			$g->set_columns($cols);
			$g->set_options($grid);
				
		}
		/*end Grid utama*/
		
		/*set grid*/
		$data["gridlokasi"] = $g->render('list1');
		$data['breadcrumbs'] = $this->Global_model->create_breadcrumbs(["Transmisi","Data Transmisi"]);
		
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
		$grid["caption"] ="Pemancar";
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
		$grid["add_options"] = array("width"=>"500");
		$grid["edit_options"] = array("width"=>"500");
		$grid["view_options"] = array("width"=>"500");
		$grid["export"] = array("format"=>"xls", "filename"=>"data-pemancar", "sheetname"=>"data-pemancar");
		
		$grid["subGrid"] = true; 
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
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		$g2->select_command = "SELECT * FROM (
			SELECT id_pemancar
			, jenis_transmisi
			, ms.idlokasi
			, frekuensi
			, coverage_populasi
			, coverage_area
			, channel_1
			, channel_2
			, channel_3
			, tipe
			, koordinat
			, power_nominal
			, power_real
			, created
			, iduser_created
			, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
			FROM trx_pemancar ms 
			INNER JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi') tablegab";
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
		$col["editoptions"] = array("value"=>"Analog:Analog;Digital:Digital");
		$cols[] = $col;

		$col = array();
		$col["title"] = "Frequency";
		$col["name"] = "frekuensi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "150";
		$col["editrules"] = array("required"=>true, "number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left","maxlength" => "10", "size"=>30, "placeholder"=>"....(Hz)");
		$cols[] = $col;

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
		
		$col = array();
		$col["title"] = "Coverage Area";
		$col["name"] = "coverage_area";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "30", "size"=>30,"placeholder"=>"....Km2");
		$cols[] = $col;


		$col = array();
		$col["title"] = "Channel 1";
		$col["name"] = "channel_1";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "11", "size"=>30,  "placeholder"=>"....UHF");
		$cols[] = $col;

		$col = array();
		$col["title"] = "Channel 2";
		$col["name"] = "channel_2";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>false,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "11", "size"=>30, "placeholder"=>"....UHF");
		$cols[] = $col;

		$col = array();
		$col["title"] = "Channel 3";
		$col["name"] = "channel_3";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>false,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "11", "size"=>30, "placeholder"=>"....UHF");
		$cols[] = $col;

		$col = array();
		$col["title"] = "Tipe";
		$col["name"] = "tipe";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "20", "size"=>30, "placeholder"=>"Horizontal/Vertical");
		$cols[] = $col;

		$col = array();
		$col["title"] = "Koordinat";
		$col["name"] = "koordinat";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "20", "size"=>30);
		 $cols[] = $col;

		$col = array();
		$col["title"] = "Power Nominal";
		$col["name"] = "power_nominal";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "10", "size"=>30, "placeholder"=>"....Volt");
		$cols[] = $col;

		$col = array();
		$col["title"] = "Power Real";
		$col["name"] = "power_real";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["editrules"] = array("required"=>true,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array("style"=>"text-align:left", "maxlength" => "10", "size"=>30, "placeholder"=>"....Volt");
		$cols[] = $col;

		$col = array();
		$col["title"] = "User Created";
		$col["name"] = "nama_lengkap";
		$col["width"] = "250";
		$col["search"] = true;
		$col["hidden"] = false;
		$col["editable"] = false;
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

		$g2->set_columns($cols);
		$g2->set_options($grid);

		$e = array();
		$e["on_insert"] = array("setPemancar", null, true); 
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
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		
		$g->select_command = "SELECT 
								iddetpemancar
								,id_pemancar
								,project
								,merk
								,tahun
								,daya
								,kondisi
								,bd.iduser_created, bd.created 
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
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5");
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
		
		$g->set_columns($cols);
		$g->set_options($grid);
	
		// Global $id_pemancar;
		// $id_pemancar = $this->session->userdata('user_id'); 
		Global $iduser;
		$iduser = $this->session->userdata('user_id'); 
	

		$e = array();
		$e["on_insert"] = array("setDetailPemancar", null, true); 
		$g->set_events($e); 
		
		
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
		$grid["caption"] = "Tower";
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
					"export"=>true,
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
				iduser_created,created
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
			
		$col = array();
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
		$cols[] = $col;
			
		$col = array();
		$col["title"] = "Tinggi";
		$col["name"] = "tinggi";
		$col["search"] = true;
		$col["align"] = "left";
		$col["editable"] = true;
		$col["width"] = "200";
		$col["align"] = "left";
		$col["editrules"] = array("required"=>true,"number"=>true);
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
		$col["editrules"] = array("required"=>false);
		$col["isnull"] = true;
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5","placeholder"=>"Thn....");
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
		
		$g3->set_columns($cols);
		$g3->set_options($grid);
		
		Global $iduser_created; 
		$iduser_created = $this->session->userdata('user_id'); 
		
		$e = array();
		$e["on_insert"] = array("setTower", null, true); 
		$g3->set_events($e); 

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
		$grid["caption"] = "Antena";
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
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		$g4->select_command = "SELECT * FROM (
			SELECT idantena, ms.idlokasi,tipe,polarisasi,merk,thn_perolehan,panel_arah,gain,iduser_created,created
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
		$col["editrules"] = array("required"=>true);
		$col["isnull"] = true;
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
		$col["isnull"] = true;
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5","placeholder"=>"Thn....");
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
		$col["editrules"] = array("required"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"30");
		$cols[] = $col;
		
		
		$col = array();
		$col["title"] = "Gain";
		$col["name"] = "gain";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>true,"number"=>true);
		$col["isnull"] = true;
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"30","placeholder"=>"....Desibel");
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
		
		$g4->set_columns($cols);
		$g4->set_options($grid);
		
		
		$e = array();
		$e["on_insert"] = array("setAntena", null, true); 
		$g4->set_events($e); 

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
		$grid["caption"] = "Catu Daya";
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
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		$g5->select_command = "SELECT * FROM (
			SELECT idcatudaya,ms.idlokasi,sumber_daya,besar_daya,merk,phase,kondisi,thn_perolehan, iduser_created,created
			, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
			FROM trx_catu_daya ms 
			INNER JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi'
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
		$col["title"] = "Besar Daya";
		$col["name"] = "besar_daya";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["align"] = "left";
		$col["width"] = "120";
		$col["editrules"] = array("required"=>true, "number"=>true);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "11", "size"=>"30","placeholder"=>"....Watt");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Merk";
		$col["name"] = "merk";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>true);
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
		$col["editrules"] = array("required"=>true);
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
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5","placeholder"=>"Thn....");
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
		
		$g5->set_columns($cols);
		$g5->set_options($grid);
	
		$e = array();
		$e["on_insert"] = array("setCatuDaya", null, true); 
		$g5->set_events($e); 

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
		$grid["caption"] = "UPS";
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
				"export"=>true,
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
			,iduser_created,created
			, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
			FROM trx_ups ms 
			INNER JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi'
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
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "20", "size"=>"30","placeholder"=>"Masukan Merk UPS...");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Kapasitas";
		$col["name"] = "kapasitas";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("onfocus"=>"set_field_number0(this)","style"=>"text-align:left","maxlength" => "30", "size"=>"30","placeholder"=>"....VA/W");
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
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5","placeholder"=>"Thn...");
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
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"30","placeholder"=>"....seri");
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
		
		$g6->set_columns($cols);
		$g6->set_options($grid);
		
		$e = array();
		$e["on_insert"] = array("setUPS", null, true); 
		$g6->set_events($e); 

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
		$grid["caption"] = "Parabola";
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
				"export"=>true,
				"autofilter" => true,
				"search" => false
			)
		);
		$g7->select_command = "SELECT * FROM (
			SELECT idparabola
			, ms.idlokasi
			,merk
			,diameter
			,tipe
			,kondisi
			,thn_perolehan
			, iduser_created,created
			, CONCAT(us.first_name,' ',IFNULL(us.last_name,'')) nama_lengkap 
			FROM trx_parabola ms 
			INNER JOIN auth_users us ON us.id=ms.iduser_created WHERE ms.idlokasi='$idlokasi'
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
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array( "style"=>"text-align:left","maxlength" => "25", "size"=>"30","placeholder"=>"Masukan Merk Parabola...");
		$cols[] = $col;
		
		$col = array();
		$col["title"] = "Diameter";
		$col["name"] = "diameter";
		$col["search"] = true;
		$col["editable"] = true;
		$col["isnull"] = true;	
		$col["autoid"] = false;	
		$col["align"] = "left";
		$col["width"] = "150";
		$col["editrules"] = array("required"=>true);
		$col["editoptions"] = array("onfocus"=>"set_field_number0(this)","style"=>"text-align:left", "size"=>"25","placeholder"=>"....Diameter");
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
		$col["editrules"] = array("required"=>false);
		$col["editoptions"] = array("onfocus"=>"set_mask_years(this)", "size"=>"5");
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
		
		$g7->set_columns($cols);
		$g7->set_options($grid);

		$e = array();
		$e["on_insert"] = array("setParabola", null, true); 
		$g7->set_events($e); 

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
		$this->load->view('v_analog',$data);
		$this->load->view('layout/footer');
		
	}
	
	public function dsh_analog()
	{
		
		
	}

}

